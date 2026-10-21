# Bénéficiaires et rapports de fin d'allocation : plan d'implémentation

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Donner à la FDA quatre indicateurs : bénéficiaires par secteur / type d'activité, taux par sexe, taux par situation de handicap, et un rapport complet au terme de chaque allocation.

**Architecture:** Les données de bénéficiaires sont saisies dans le rapport post-appui existant (`PostAppui`), enrichi de deux effectifs handicapés, d'observations et d'un fichier joint. Un service unique `StatistiquesBeneficiaires` calcule les indicateurs sur les demandes en cours (`demandes`) ; il prend une requête de base pour pouvoir être réutilisé plus tard sur `demandes_clotures`. La page statistiques et une fiche PDF par allocation consomment ce service.

**Tech Stack:** Laravel 9, Livewire 2 (`WithFileUploads`), MySQL 8, dompdf, Chart.js 3.9.1 (déjà chargé par CDN sur la page statistiques), PHPUnit 9.

**Spec:** pas de document de conception. La demande client tient en 4 lignes (ci-dessous) ; les décisions qui la complètent sont dans « Décisions prises par défaut ».

> 1. Le point des bénéficiaires par secteur ou type d'activité
> 2. Le taux de bénéficiaires par sexe
> 3. Le taux de bénéficiaires par état de personnes (handicapé ou non handicapé)
> 4. Les rapports au terme de chaque allocation

## Décisions prises par défaut (à valider)

| # | Décision | Pourquoi |
|---|---|---|
| D1 | **Bénéficiaire = personne formée / touchée**, déclarée dans le rapport post-appui (`effectif_homme_forme`, `effectif_femme_forme`). | C'est déjà la définition des graphiques g9 et g17 (`AdminController::statistiques`). Sexe et handicap n'ont pas de sens pour une structure ou une ONG demandeuse. |
| D2 | **Allocation = demande avec `valide = 2`**, que `suspendre` vaille 0 ou 1. | C'est la liste sur laquelle `PostAppui` fait saisir les rapports. `demandes_clotures` contient 11 demandes `valide=2` avec `statuts` NULL (anciennes écritures), dont certaines ont un rapport : filtrer sur `statuts` les perdrait. Conséquence assumée : les totaux de la nouvelle section peuvent différer des sections existantes, qui filtrent sur `statuts`. Un test fige le cas approuvée puis suspendue (demande 115). |
| D3 | **Secteur = branche (`braches`)**, **type d'activité = service** (Formation / Assistance). Un seul paramètre `dimension` sur liste blanche. | Ce sont les deux axes déjà présents dans le formulaire et les stats. |
| D4 | **Handicap ventilé par sexe** : `effectif_handicape_homme`, `effectif_handicape_femme`. | Pratique standard de désagrégation sexe × handicap (Washington Group Short Set : https://www.washingtongroup-disability.com/question-sets/wg-short-set-on-functioning-wg-ss/). Coût marginal maintenant, irrécupérable plus tard pour les rapports déjà saisis. |
| D5 | **Rapport de fin d'allocation = champs saisis + fichier joint optionnel (PDF) + fiche PDF générée** par allocation. | Reprend le motif existant `generatePdfForDemande`. |
| D6 | **Fichier du rapport sur le disque privé `local`** (`storage/app/rapports`), téléchargé via une route protégée. | Le disque `uploads` est dans `public/` : tout fichier y est lisible sans connexion par quiconque connaît le chemin. |
| D7 | **Les indicateurs v1 portent sur les demandes en cours uniquement.** Les exercices clôturés sont laissés de côté, mais les nouveaux champs sont recopiés à la clôture (Task 1) pour pouvoir les exploiter plus tard. | Validé par l'utilisateur. Conséquence assumée : les indicateurs repartent de zéro après chaque clôture, et les rapports d'une année doivent être saisis avant sa clôture. |
| D8 | **Chaque taux affiche sa couverture** : « calculé sur N rapports / M allocations ». | Seuls ~38 % des allocations ont un rapport dans les données clôturées : un taux sans couverture serait lu comme global. |
| D9 | **Branche absente de `braches`** → libellé « Branche inconnue » ; branche NULL → « Non renseigné ». Aucune liste figée de services. | 7 demandes clôturées pointent vers une branche disparue ; le service `Financier` existe dans les données. |
| D10 | **Le nouveau graphique par branche remplace g9** (« Effectifs par branche des dossiers approuvés »). g17 (par département) est conservé. | Deux graphiques par branche avec deux définitions donneraient deux chiffres pour la même question. |

## Global Constraints

- Le schéma garde ses fautes d'orthographe (`buget_prevu`, `Brache`, `braches`, `obejectif_activite`) : ne rien renommer.
- Toute colonne ajoutée à `demandes` est ajoutée à `demandes_clotures` **et** aux deux listes de colonnes du `INSERT ... SELECT` de `DemandeApprouve::cloturerExercice`.
- Tests sur MySQL uniquement (base `basefda_test`), jamais sqlite : la clôture utilise `YEAR()` et `DELETE ... JOIN`.
- Taux arrondis à 1 décimale, calculés en PHP ; dénominateur nul → `null`, affiché « n/d ».
- Filtres des nouvelles requêtes dans le `WHERE`, jamais dans le `ON` d'une jointure externe (g16/g17 font l'erreur inverse : les demandes non approuvées y fuient dans un groupe département `null`).
- Textes UI en français. Pas de tiret cadratin.
- Commits via `/commit`, uniquement sur le go de l'utilisateur. Travail sur une branche `feat/beneficiaires-rapports`.

## Review Focus

1. **Ancien rapport sans données handicap** (les 11 rapports existants) : compté dans le taux par sexe, exclu du dénominateur handicap, affiché « non renseigné : N rapports ». → Task 2 `test_ancien_rapport_sans_handicap_exclu_du_taux_handicap`.
2. **Handicapés > formés du même sexe** : refusé à la saisie. → Task 3 `test_handicapes_superieurs_aux_formes_refuse`.
3. **Aucun rapport déposé** : taux `null`, page affiche « n/d », pas de division par zéro. → Task 2 `test_aucun_rapport_donne_taux_null`, Task 5 `test_page_sans_rapport_affiche_nd`.
4. **Clôture d'exercice** : les nouveaux champs et le chemin du fichier survivent à la copie dans `demandes_clotures`. → Task 1 `test_cloture_conserve_champs_rapport`.
5. **Accès au fichier du rapport** : secrétaire et visiteur non connecté refusés. → Task 4 `test_fichier_rapport_refuse_sans_gate`.

---

### Task 0 : Base de test MySQL isolée

**Files:**
- Create: `.env.testing` (copie de `.env` avec `DB_DATABASE=basefda_test`)
- Modify: `.gitignore` (ajouter `.env.testing`)
- Modify: `CLAUDE.md` (section Commands : comment créer la base de test)

- [ ] **Step 1:** Créer la base : `docker exec fda-mysql mysql -uroot -proot -e "CREATE DATABASE basefda_test CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"`
- [ ] **Step 2:** Lancer `php artisan migrate:fresh --env=testing`. Attendu : toutes les migrations passent. Personne ne les a jamais jouées sur une base vide (la base de dev vient du dump) : si l'une échoue, la corriger dans cette tâche et le signaler.
- [ ] **Step 3:** Lancer `php artisan test`. Noter le résultat de référence (tests Jetstream). Un échec préexistant est listé, pas corrigé.
- [ ] **Step 4:** Vérifier que la base de dev est intacte : `select count(*) from demandes` sur `basefda` renvoie toujours 6.

Note pour toutes les tâches : `DemandeFactory` choisit branches et départements avec `inRandomOrder()->first()`, ce qui donne `null` sur une base vide. Chaque test insère lui-même les lignes `braches` / `departements` dont il a besoin.

### Task 1 : Schéma et clôture d'exercice

**Avant de coder :** lancer l'agent `impact-analyzer` sur `demandes`, `demandes_clotures` et `cloturerExercice`.

**Files:**
- Create: `database/migrations/2026_10_21_000000_add_rapport_allocation_columns.php`
- Modify: `app/Http/Livewire/DemandeApprouve.php` (`cloturerExercice`, les deux listes de colonnes)
- Test: `tests/Feature/ClotureExerciceTest.php`

**Interfaces:**
- Produces : colonnes sur `demandes` **et** `demandes_clotures` : `effectif_handicape_homme` int nullable, `effectif_handicape_femme` int nullable, `observations_rapport` text nullable, `rapport_fichier` string nullable (chemin relatif au disque `local`). Placées après `date_depot_rapport`.

- [ ] **Step 1: Test qui échoue** `test_cloture_conserve_champs_rapport` : une demande créée en 2024, approuvée, avec rapport (H=10, F=30, handicapés H=1 / F=3, observations « RAS », fichier `rapports/x.pdf`) ; `Livewire::test(DemandeApprouve::class)` en tant que vérificateur, `set('annee_cloture', 2024)`, `call('cloturerExercice')`. Assertions : `demandes` ne contient plus la ligne ; `demandes_clotures` contient `effectif_handicape_homme=1`, `effectif_handicape_femme=3`, `observations_rapport='RAS'`, `rapport_fichier='rapports/x.pdf'`, `annee_exercice_cloture=2024`.
- [ ] **Step 2:** `php artisan test --filter=ClotureExerciceTest` → FAIL (colonne inconnue).
- [ ] **Step 3:** Migration (`up` sur les deux tables, `down` qui les retire) + ajout des 4 colonnes dans les deux listes du `INSERT ... SELECT`.
- [ ] **Step 4:** `php artisan migrate --env=testing && php artisan test --filter=ClotureExerciceTest` → PASS.
- [ ] **Step 5:** `regression-reviewer` sur le diff, puis `/commit` (sur go).

### Task 2 : Service `StatistiquesBeneficiaires`

**Files:**
- Create: `app/Services/StatistiquesBeneficiaires.php`
- Test: `tests/Feature/StatistiquesBeneficiairesTest.php`

**Interfaces:**
- Produces :
  - `StatistiquesBeneficiaires::pourDemandes(): self` (base `Demande::query()`)
  - `__construct(\Illuminate\Database\Eloquent\Builder $base)` (réutilisable sur `DemandeCloture::query()` en v2)
  - `couverture(): array` → `['allocations' => int, 'rapports' => int]`
  - `repartition(string $dimension): \Illuminate\Support\Collection` ; `$dimension` ∈ `['branche', 'service']`, sinon `InvalidArgumentException`. Chaque ligne : `libelle` (string, voir D9), `allocations` (int), `rapports` (int), `hommes`, `femmes`, `total` (int, issus des rapports). Tri par `total` décroissant.
  - `parSexe(): array` → `['hommes' => int, 'femmes' => int, 'total' => int, 'taux_hommes' => ?float, 'taux_femmes' => ?float]`
  - `parHandicap(): array` → `['handicapes' => int, 'non_handicapes' => int, 'total_renseigne' => int, 'rapports_non_renseignes' => int, 'taux_handicapes' => ?float, 'taux_non_handicapes' => ?float]`
- Règles : périmètre = `valide = 2` (D2) ; bénéficiaires = demandes avec `rapport_depose = 1`, effectifs NULL comptés 0 ; handicap renseigné ⇔ `effectif_handicape_homme IS NOT NULL` ; `branche` est un id en string, jointure `braches.id = branche` en `leftJoin` avec filtres dans le `WHERE`.

Jeu de données des tests (calculs faits à la main), toutes les lignes dans `demandes` :

| Demande | Statut | Branche / service | Rapport | H | F | Hand. H | Hand. F |
|---|---|---|---|---|---|---|---|
| A | Approuvé | Bois / Formation | oui | 10 | 30 | 1 | 3 |
| B | Approuvé | Métal / Assistance | oui | 5 | 5 | null | null |
| C | non approuvé (`valide=1`) | Bois / Formation | oui | 100 | 100 | 50 | 50 |
| D | Approuvé | Bois / Formation | non | null | null | null | null |

- [ ] **Step 1: Tests qui échouent**
  - `test_par_sexe` : hommes 15, femmes 35, total 50, taux_hommes 30.0, taux_femmes 70.0 (C exclu).
  - `test_ancien_rapport_sans_handicap_exclu_du_taux_handicap` : handicapes 4, total_renseigne 40, non_handicapes 36, taux_handicapes 10.0, taux_non_handicapes 90.0, rapports_non_renseignes 1.
  - `test_repartition_par_branche` : Bois → allocations 2, rapports 1, total 40 ; Métal → allocations 1, rapports 1, total 10 ; aucune trace de C.
  - `test_repartition_par_service` : Formation total 40, Assistance total 10.
  - `test_aucun_rapport_donne_taux_null` : base vide → totaux 0, tous les taux `null`.
  - `test_arrondi_une_decimale` : un seul rapport H=1, F=2 → 33.3 et 66.7.
  - `test_approuvee_puis_suspendue_reste_comptee` : `valide=2`, `suspendre=1`, rapport H=2 F=0 → hommes 2 (fige D2).
  - `test_approuvee_sans_statuts_comptee` : `valide=2`, `statuts` NULL, rapport H=4 F=0 → hommes 4 (fige D2).
  - `test_dimension_inconnue_refusee` : `repartition('ifu')` lève `InvalidArgumentException`.
  - `test_couverture` : jeu A/B/C/D → allocations 3 (A, B, D), rapports 2 (A, B).
  - `test_branche_inconnue_et_nulle` : branche id 999 absente de `braches` → « Branche inconnue » ; branche NULL → « Non renseigné ».
  - `test_ignore_demandes_cloturees` : une ligne `demandes_clotures` approuvée avec rapport H=50 → `pourDemandes()->parSexe()['hommes']` vaut 0.
- [ ] **Step 2:** `php artisan test --filter=StatistiquesBeneficiairesTest` → FAIL (classe absente).
- [ ] **Step 3:** Implémenter. Agrégats en SQL (`SUM`, `COUNT`), taux via une méthode privée `taux(int $part, int $total): ?float` (`round(..., 1)`, `null` si `$total === 0`).
- [ ] **Step 4:** Tests → PASS.
- [ ] **Step 5:** `regression-reviewer`, `/commit` (sur go).

### Task 3 : Formulaire post-appui enrichi

**Files:**
- Modify: `app/Http/Livewire/PostAppui.php`
- Modify: `resources/views/livewire/post-appui.blade.php` (modale + colonne « Rapport » du tableau)
- Test: `tests/Feature/PostAppuiRapportTest.php`

**Interfaces:**
- Consumes : colonnes de la Task 1.
- Produces : propriétés Livewire `effectif_handicape_homme`, `effectif_handicape_femme`, `observations_rapport`, `rapport_fichier` (upload). Fichier stocké par `Storage::disk('local')->putFile('rapports', $file)` ; l'ancien fichier est supprimé s'il est remplacé.
- Règles de validation :
  - `effectif_handicape_homme` : `required|integer|min:0|lte:effectif_homme_forme`
  - `effectif_handicape_femme` : `required|integer|min:0|lte:effectif_femme_forme`
  - `observations_rapport` : `nullable|string|max:5000`
  - `rapport_fichier` : `nullable|file|mimes:pdf|max:10240`
  - messages en français dans `$messages`, comme les règles existantes.

- [ ] **Step 1: Tests qui échouent** (`Storage::fake('local')`, en tant que vérificateur)
  - `test_rapport_complet_enregistre` : H=10 F=30 hand. 1/3, observations, PDF → ligne en base avec ces valeurs, `rapport_depose=1`, fichier présent sous `rapports/`.
  - `test_handicapes_superieurs_aux_formes_refuse` : H=2, hand. H=3 → erreur sur `effectif_handicape_homme`, rien en base.
  - `test_fichier_non_pdf_refuse` : `.docx` → erreur sur `rapport_fichier`.
  - `test_edition_conserve_fichier_si_aucun_nouveau` : rapport existant avec fichier, réédition sans fichier → `rapport_fichier` inchangé.
- [ ] **Step 2:** Tests → FAIL.
- [ ] **Step 3:** Implémenter (ajouter `WithFileUploads`, préremplir les nouveaux champs dans `edit()`, les remettre à zéro dans `closeModal()`).
- [ ] **Step 4:** Tests → PASS.
- [ ] **Step 5:** `regression-reviewer`, `/commit` (sur go).

### Task 4 : Fiche PDF de fin d'allocation et téléchargement du rapport

**Files:**
- Create: `app/Http/Controllers/RapportAllocationController.php` (`AdminController` fait déjà 614 lignes)
- Create: `resources/views/Admin/fiche-allocation.blade.php`
- Modify: `routes/web.php` (dans le groupe authentifié)
- Modify: `resources/views/livewire/post-appui.blade.php` (boutons « Fiche » et « Rapport » quand `rapport_depose`)
- Test: `tests/Feature/RapportAllocationTest.php`

**Interfaces:**
- Produces :
  - `GET /rapport_allocation/{id}/fiche` → `RapportAllocationController@fiche`, nom `rapport.fiche`, `can:view-post-appui`, PDF dompdf.
  - `GET /rapport_allocation/{id}/fichier` → `RapportAllocationController@fichier`, nom `rapport.fichier`, `can:view-post-appui`, `Storage::disk('local')->download(...)` ; 404 si pas de fichier.
- Contenu de la fiche : code, structure, branche, service, montant demandé (`budget`), montant accordé (`buget_prevu`), date d'approbation, date de dépôt du rapport, effectifs H / F / total, handicapés H / F / total, observations, logo (même encodage base64 que `generatePdfForDemande`).

- [ ] **Step 1: Tests qui échouent**
  - `test_fiche_pdf_generee` : directeur, demande avec rapport → 200, `Content-Type: application/pdf`.
  - `test_fiche_refusee_si_pas_de_rapport` : `rapport_depose=0` → 404.
  - `test_fichier_rapport_telecharge` : vérificateur → 200, contenu identique au fichier faké.
  - `test_fichier_rapport_refuse_sans_gate` : secrétaire → 403 ; non connecté → redirection `/login`.
- [ ] **Step 2:** Tests → FAIL.
- [ ] **Step 3:** Implémenter.
- [ ] **Step 4:** Tests → PASS.
- [ ] **Step 5:** `regression-reviewer`, `/commit` (sur go).

### Task 5 : Section « Bénéficiaires » de la page statistiques

**Files:**
- Modify: `app/Http/Controllers/AdminController.php` (`statistiques`)
- Modify: `resources/views/Statistique/index.blade.php` (nouvelle section après la section 2)
- Test: `tests/Feature/StatistiquesPageTest.php`

**Interfaces:**
- Consumes : `StatistiquesBeneficiaires` (Task 2). Variables de vue : `$benef_branche`, `$benef_service`, `$benef_sexe`, `$benef_handicap`.

Contenu de la section « 3. Bénéficiaires (rapports post-appui) » :
- Une ligne sous le titre : « Allocations = demandes approuvées (budget validé). Bénéficiaires = effectifs déclarés dans les rapports post-appui. Exercice en cours uniquement. » (les totaux diffèrent des sections 1 et 2, voir D2).
- Sous chaque taux : « calculé sur N rapports / M allocations » (D8).
- Tableau + barres empilées H / F par branche, à la place du graphique g9 (D10 : supprimer `$g9_effectif_branche_approuves`, son canvas `g6g9Chart` et son script) ; idem par service.
- Anneau sexe avec les deux taux et le total.
- Anneau handicap avec les deux taux, et sous le graphique : « Données handicap non renseignées : N rapport(s) ».
- Tout taux `null` affiché « n/d ».

- [ ] **Step 1: Tests qui échouent** (en tant que directeur, jeu A/B/C/D de la Task 2)
  - `test_page_affiche_taux` : la réponse contient « 30.0 », « 70.0 », « 10.0 », « non renseignées : 1 ».
  - `test_page_sans_rapport_affiche_nd` : base vide → contient « n/d », statut 200.
  - `test_page_affiche_couverture` : jeu A/B/C/D → contient « 2 rapports / 3 allocations ».
  - `test_g9_retire` : la réponse ne contient plus `g6g9Chart`.
- [ ] **Step 2:** Tests → FAIL.
- [ ] **Step 3:** Implémenter (Chart.js déjà chargé ; suivre le style des graphiques g15 / g17).
- [ ] **Step 4:** Tests → PASS.
- [ ] **Step 5:** `regression-reviewer`, `/commit` (sur go).

### Task 6 : Test bout en bout et contrôle des chiffres

**Files:**
- Create: `tests/Feature/BeneficiairesWorkflowTest.php`
- Create: `docs/verification/beneficiaires.sql` (requête indépendante du service)

- [ ] **Step 1:** `BeneficiairesWorkflowTest` déroule le flux réel par HTTP et Livewire : secrétaire transmet → vérificateur approuve le budget (`/budget/{id}`) → vérificateur saisit le rapport avec PDF → directeur ouvre `/statistiques` et `/rapport_allocation/{id}/fiche`. Il écrit `storage/app/e2e/beneficiaires-workflow.json` (statuts HTTP, chiffres affichés). Commande : `php artisan test --filter=BeneficiairesWorkflowTest`.
- [ ] **Step 2:** Sur la base de dev, saisir 2 rapports via l'UI, puis comparer les taux affichés à `docs/verification/beneficiaires.sql` exécuté directement dans `fda-mysql`. Capture d'écran de la section enregistrée dans `docs/verification/`.
- [ ] **Step 3:** `php artisan test` complet : aucun test de la référence Task 0 ne régresse.
- [ ] **Step 4:** Avant toute PR : `/codebase-design` puis `/zero-tech-debt` sur le diff de la branche, bilan dans le chat, attendre le go.

## Hors périmètre v1

- Indicateurs sur les exercices clôturés (v2 : page `ExercicesClotures`, même service sur `DemandeCloture::query()`).
- Saisie ou correction de rapports sur des demandes déjà clôturées.
- Export Excel des indicateurs.
- Aligner les sections existantes 1 et 2 sur `valide = 2`, corriger g16 / g17 et le double comptage du tableau de bord : listés à part.

Validé par l'utilisateur le 2026-10-21 : D1 (bénéficiaire = personne formée), D7 (exercices clôturés hors v1).
