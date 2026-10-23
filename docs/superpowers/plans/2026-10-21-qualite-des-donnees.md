# Qualité des données (types, clés étrangères, doublons, noms) : plan d'implémentation

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Stocker montants, effectifs et dates dans des types adaptés, relier `demandes` aux tables de référence par des clés étrangères, supprimer le doublon lieu/effectifs entre `demandes` et `demande_localisations`, et corriger les noms mal orthographiés.

**Architecture:** Une commande d'audit, lancée sur une copie de la production, liste les valeurs non convertibles avant toute migration. Les migrations convertissent seulement si l'audit est vide ou si chaque anomalie a reçu une règle. Les renommages viennent en dernier : ils sont mécaniques et couverts par toute la suite.

**Tech Stack:** Laravel 9, MySQL 8, PHPUnit 9.

**Spec:** point N2 de la feuille de route, et la section « base de données » du diagnostic du 2026-10-21.

## Global Constraints

- Prérequis : le plan « État unique des demandes et exercices » est terminé (une seule table `demandes`).
- `contact` reste du texte : c'est un numéro de téléphone.
- Montants en FCFA, entiers : `unsignedBigInteger`. Effectifs : `unsignedInteger`. Durée en jours : `unsignedSmallInteger`. Dates d'activité : `date`.
- Aucune valeur n'est perdue en silence : toute valeur non convertible est corrigée par une règle écrite dans le plan, ou bloque la migration.

## Review Focus

1. **Montant saisi avec espaces ou séparateurs** (« 1 500 000 », « 1.500.000 ») : il est converti correctement. → Task 1 `test_audit_normalise_montants`.
2. **Date au format jj/mm/aaaa** dans `debut_activite` : elle est convertie, pas mise à NULL. → Task 1 `test_audit_dates_formats_acceptes`.
3. **Branche supprimée** (7 cas en base) : le lien devient NULL, et l'identifiant d'origine est conservé dans le rapport d'audit. → Task 3 `test_branche_orpheline_mise_a_null_et_tracee`.
4. **Demande avec un lieu dans `demandes` mais aucune localisation** : une localisation est créée, rien n'est perdu. → Task 4 `test_lieu_de_demande_devient_localisation`.
5. **Graphiques par département ou commune** : mêmes chiffres avant et après la suppression du doublon. → Task 4 `test_statistiques_identiques_apres_fusion`.

---

### Task 1 : Commande d'audit des données

**Files:**
- Create: `app/Console/Commands/AuditDonnees.php` (`php artisan fda:audit-donnees`), `app/Support/Normalisation.php`
- Test: `tests/Unit/NormalisationTest.php`, `tests/Feature/AuditDonneesTest.php`

**Interfaces:**
- Produces :
  - `Normalisation::montant(?string $v): ?int` : retire les espaces (y compris insécables), les points et les virgules de milliers ; renvoie null si la valeur est vide ; lève `ValeurInvalide` sinon.
  - `Normalisation::date(?string $v): ?string` : accepte `Y-m-d` et `d/m/Y`, renvoie `Y-m-d`.
  - `Normalisation::entier(?string $v): ?int`.
- La commande parcourt `budget`, `buget_prevu`, `homme_touche`, `dure_activite`, `debut_activite`, `fin_activite`, et les colonnes de référence (`branche`, `corps`, `metier`, `departement`, `commune`). Elle affiche un tableau (id, colonne, valeur, problème) et rend le code de sortie 1 s'il reste des anomalies.

- [ ] **Step 1: Tests qui échouent**
  - `test_audit_normalise_montants` : « 1 500 000 » → 1500000 ; « 1.500.000 » → 1500000 ; « 0 » → 0 ; « » → null ; « abc » lève `ValeurInvalide`.
  - `test_audit_dates_formats_acceptes` : « 2026-10-05 » et « 05/10/2026 » → « 2026-10-05 » ; « 31/02/2026 » lève une exception.
  - `test_audit_signale_branche_orpheline` : une demande avec `branche = '999'` apparaît dans la sortie, avec le code de sortie 1.
- [ ] **Step 2:** → FAIL.
- [ ] **Step 3:** Implémenter.
- [ ] **Step 4:** → PASS. Lancer `fda:audit-donnees` sur la base du worktree (copie du dump) et coller la sortie dans le journal. Chaque anomalie reçoit une règle, notée dans ce plan avant la Task 2.
- [ ] **Step 5:** Commit.

### Task 2 : Types des colonnes

**Files:**
- Create: `database/migrations/2026_10_24_000000_type_demandes_columns.php`
- Modify: `app/Models/Demande.php` (casts), `app/Services/StatistiquesBeneficiaires.php` et `resources/views/Admin/fiche-allocation.blade.php` (retirer les `str_replace(' ', '', ...)` devenus inutiles), formulaires de création et d'édition (`type="number"` déjà en place : vérifier)

**Interfaces:**
- La migration convertit les valeurs en PHP avec `Normalisation`, par paquets de 500 lignes, dans de nouvelles colonnes temporaires. Elle supprime ensuite les anciennes et renomme les nouvelles. Elle s'arrête au premier `ValeurInvalide` non couvert par une règle de la Task 1.

- [ ] **Step 1: Test qui échoue** `test_types_des_colonnes` : `information_schema` donne `bigint unsigned` pour `budget` et `buget_prevu`, `int unsigned` pour `homme_touche`, `date` pour `debut_activite` et `fin_activite`.
- [ ] **Step 2:** → FAIL.
- [ ] **Step 3:** Implémenter.
- [ ] **Step 4:** Suite complète verte. Sur la base du worktree : la somme de `buget_prevu` après migration égale la somme normalisée calculée par l'audit avant.
- [ ] **Step 5:** `regression-reviewer`, commit.

### Task 3 : Clés étrangères vers les tables de référence

**Files:**
- Create: `database/migrations/2026_10_24_100000_add_reference_foreign_keys.php`
- Modify: `app/Models/Demande.php` (relations `branche()`, `departement()`, `commune()`, `corps()`, `metier()`), puis les lectures qui font `Brache::where('id', $demande->branche)` (`AdminController::generatePdfForDemande`, `show`, `RapportAllocationController`, `StatistiquesBeneficiaires`)

**Interfaces:**
- Colonnes renommées `branche_id`, `corps_id`, `metier_id`, `departement_id` et `commune_id` (unsigned bigint, null), avec contrainte `nullOnDelete`. Les valeurs orphelines passent à NULL et sont journalisées (`orphelins-references` : id de la demande, colonne, ancienne valeur).
- La détection des orphelins est une fonction pure : `App\Support\Orphelins::detecter(array $valeurs, array $idsExistants): array`, qui renvoie la liste des valeurs sans correspondance. La migration l'appelle avant d'ajouter la contrainte. Une fois la clé étrangère en place, on ne peut plus insérer de ligne orpheline : le test porte donc sur la fonction, et la preuve sur données réelles est le journal de `basefda_wt`.
- Le libellé « Branche inconnue » disparaît : une branche absente devient « Non renseigné ». Le test correspondant de `StatistiquesBeneficiairesTest` est mis à jour.

- [ ] **Step 1: Tests qui échouent**
  - `test_branche_orpheline_mise_a_null_et_tracee` : `Orphelins::detecter(['1', '999', null], [1, 2])` → `['999']`.
  - `test_relations_demande` : `$demande->branche->nom` et `$demande->departement->nom` renvoient les bons noms.
  - `test_suppression_branche_met_null` : supprimer une branche ne supprime pas la demande.
- [ ] **Step 2:** → FAIL.
- [ ] **Step 3:** Implémenter.
- [ ] **Step 4:** Suite complète verte, `PagesTest` compris.
- [ ] **Step 5:** `regression-reviewer`, commit.

### Task 4 : Un seul endroit pour le lieu et les effectifs prévus

Constat : `demandes.departement`, `commune`, `lieux` et `homme_touche` doublent la première ligne de `demande_localisations`. Le formulaire écrit les deux, et les graphiques g10, g12, g16 et g17 ne lisent pas la même source.

**Files:**
- Create: `database/migrations/2026_10_24_200000_merge_demande_location_into_localisations.php`
- Modify: `ClientController::store`, `AdminController::updateDemande`, les requêtes g10, g12, g16 et g17 de `AdminController::statistiques`, `Admin/show`, `Admin/pdf`, `Admin/fiche-allocation`, `DemandeFactory`

**Interfaces:**
- La conversion est une fonction pure : `App\Support\FusionLocalisations::localisationDepuisDemande(array $demande): ?array` renvoie la localisation à créer, ou null si la demande en a déjà une ou n'a pas de département. La migration l'appelle.
- Règle : `demande_localisations` est la seule source. Une demande sans localisation mais avec `departement` reçoit une localisation construite à partir de ses colonnes. Ensuite, les colonnes `departement_id`, `commune_id`, `lieux` et `homme_touche` de `demandes` sont supprimées. Les effectifs prévus d'une demande sont la somme de ses localisations.

- [ ] **Step 1: Tests qui échouent**
  - `test_lieu_de_demande_devient_localisation` : `localisationDepuisDemande(['departement' => '1', 'commune' => '2', 'lieux' => 'Cotonou', 'homme_touche' => '12', 'a_localisation' => false])` → `['departement_id' => 1, 'commune_id' => 2, 'lieux' => 'Cotonou', 'homme_touche' => 12]` ; avec `a_localisation` vrai → null.
  - `test_statistiques_identiques_apres_fusion` : avec un jeu fixe saisi en localisations, les tableaux g10, g12, g16 et g17 donnent les valeurs attendues, calculées à la main et écrites dans le test. L'égalité avant/après sur données réelles se vérifie sur `basefda_wt` : relever les quatre tableaux avant la migration, puis après, et noter les deux relevés dans le journal.
  - `test_creation_n_ecrit_que_les_localisations`.
- [ ] **Step 2:** → FAIL.
- [ ] **Step 3:** Implémenter.
- [ ] **Step 4:** Suite complète verte. Navigateur : création d'une demande à deux lieux, puis affichage en fiche et en PDF.
- [ ] **Step 5:** `regression-reviewer`, commit.

### Task 5 : Noms corrigés

| Avant | Après |
|---|---|
| table `braches`, modèle `Brache` | `branches`, `Branche` |
| `buget_prevu` | `budget_accorde` |
| `obejectif_activite` | `objectif_activite` |
| `dure_activite` | `duree_activite` |

**Files:** `database/migrations/2026_10_24_300000_rename_misspelled_columns.php`, puis chaque occurrence trouvée par `grep -rn "braches\|Brache\|buget_prevu\|obejectif_activite\|dure_activite" app resources routes database tests` (vues, noms de champs de formulaire, JavaScript, exports, tests).

- [ ] **Step 1:** Le `grep` est noté dans le journal (avant).
- [ ] **Step 2:** Migration de renommage (`Schema::rename`, `renameColumn` : MySQL 8 le permet sans dbal depuis Laravel 10 ; en Laravel 9, utiliser `ALTER TABLE ... RENAME COLUMN` en SQL brut).
- [ ] **Step 3:** Remplacer toutes les occurrences. Le `grep` ne renvoie plus rien hors migrations.
- [ ] **Step 4:** Suite complète verte. Navigateur : création, édition, approbation, post-appui, statistiques, exports Excel.
- [ ] **Step 5:** Retirer de `CLAUDE.md` la puce « Misspellings are the real schema ». `regression-reviewer`, commit.
