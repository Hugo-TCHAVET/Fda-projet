# État unique des demandes et exercices : plan d'implémentation

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Remplacer les six colonnes d'état par un état unique et des transitions contrôlées. La clôture d'exercice marque désormais les allocations approuvées et reporte les autres demandes, au lieu de copier puis supprimer.

**Architecture:** Un enum PHP `EtatDemande` et des méthodes de transition sur `Demande` (seul endroit qui change l'état). Une colonne `exercice` et des colonnes de clôture sur `demandes` remplacent les tables `*_clotures`, dont les données sont réintégrées. Toutes les listes, statistiques, exports et PDF lisent l'état et l'exercice.

**Tech Stack:** Laravel 9, Livewire 2, MySQL 8, PHPUnit 9.

**Spec:** décisions de l'utilisateur du 2026-10-21 (feuille de route, section « Décisions ») : la suspension est une mise en attente ; à la clôture, les demandes non approuvées sont reportées sur l'exercice suivant.

## Global Constraints

- États : `en_attente`, `transmise`, `suspendue`, `approuvee`. Pas d'état « rejetée » tant qu'aucune action de rejet n'existe. Le tableau de bord parle de « Suspendues », plus de « Rejetées ».
- Transitions autorisées, et aucune autre : `en_attente → transmise` ; `transmise → suspendue` ; `suspendue → transmise` ; `transmise → approuvee` (budget ≤ montant demandé).
- Une seule écriture de l'état : les méthodes de `Demande`. Aucun `update(['valide' => ...])` ni `update(['etat' => ...])` ailleurs (contrôle par `grep` en fin de plan).
- L'exercice d'une demande vaut l'année de création. La clôture de l'exercice N marque `cloturee_le` sur les demandes `approuvee` de l'exercice N et passe les autres demandes non clôturées de N à N+1.
- Migrations de données : idempotentes, testées sur une copie de la base (dump), comptes de lignes vérifiés avant de supprimer quoi que ce soit.

## Review Focus

1. **Demande approuvée puis suspendue** (cas 115) : après migration, elle est `approuvee`, et son identifiant figure dans le rapport de migration. → Task 1 `test_approbation_prime_sur_suspension`.
2. **Clôturer deux fois la même année** ne déplace rien la seconde fois et ne perd rien. → Task 4 `test_cloture_idempotente`.
3. **Demande reportée puis approuvée** l'année suivante : elle est clôturée avec l'exercice N+1. → Task 4 `test_demande_reportee_cloturee_avec_l_exercice_suivant`.
4. **Ancien dossier clôturé** (81 en base) : il reste consultable, en fiche et en PDF, après la réintégration. → Task 3 `test_dossier_cloture_reintegre_consultable`.
5. **Transition interdite** (approuver une demande en attente) : refusée avec un message, état inchangé. → Task 2 `test_transition_interdite_refusee`.

---

### Task 1 : Enum, colonnes et migration des états

**Files:**
- Create: `app/Enums/EtatDemande.php`, `app/Support/MigrationEtat.php`, `database/migrations/2026_10_23_000000_add_etat_and_exercice_to_demandes.php`
- Test: `tests/Unit/MigrationEtatTest.php`, `tests/Feature/MigrationEtatDemandesTest.php`

**Interfaces:**
- Produces :
  - `enum EtatDemande: string { case EnAttente = 'en_attente'; case Transmise = 'transmise'; case Suspendue = 'suspendue'; case Approuvee = 'approuvee'; public function libelle(): string }`, avec les libellés « En attente », « En cours de traitement », « Suspendue » et « Approuvée ».
  - `MigrationEtat::remplir(): array` remplit `etat` et `exercice` sur les lignes où `etat` est null, renvoie `['par_etat' => [...], 'approuvees_suspendues' => [ids]]`, et est appelée par la migration.
  - `MigrationEtat::depuisDrapeaux(?string $valide, ?string $suspendre): EtatDemande`, avec la règle : `valide = '2'` → Approuvee ; sinon `suspendre = '1'` → Suspendue ; sinon `valide = '1'` → Transmise ; sinon EnAttente.
  - Colonnes `demandes.etat` (varchar 20, indexé), `demandes.exercice` (smallint unsigned, indexé), `demandes.cloturee_le` (datetime null), `demandes.cloturee_par` (FK `users` null, `nullOnDelete`). `Demande::$casts['etat'] = EtatDemande::class`.
- La migration remplit `etat` avec `depuisDrapeaux`, et `exercice` avec `YEAR(created_at)`. Elle écrit dans le log `migration-etat` les identifiants où `valide = '2'` et `suspendre = '1'`. Les anciennes colonnes ne sont **pas** supprimées ici (voir Task 5).

- [ ] **Step 1: Tests qui échouent**
  - `MigrationEtatTest` : les 6 combinaisons (`'0','0'` → EnAttente ; `'1','0'` → Transmise ; `'1','1'` → Suspendue ; `'0','1'` → Suspendue ; `'2','0'` → Approuvee ; `'2','1'` → Approuvee), et `null, null` → EnAttente.
  - `test_approbation_prime_sur_suspension` : insérer une demande `valide='2', suspendre='1', etat=null`, appeler `MigrationEtat::remplir()` → elle est `approuvee`, et son id figure dans `approuvees_suspendues`.
  - `test_exercice_egal_annee_de_creation` : demande créée le 2024-05-10 avec `exercice` null, puis `remplir()` → `exercice` 2024.
  - Ces deux tests sont **transitoires** : la Task 5 les supprime avec les anciennes colonnes.
- [ ] **Step 2:** → FAIL.
- [ ] **Step 3:** Implémenter.
- [ ] **Step 4:** → PASS. Puis, sur la base du worktree (copie du dump) : `migrate`, et `select etat, count(*) from demandes group by etat` est noté dans le journal.
- [ ] **Step 5:** `regression-reviewer`, commit.

### Task 2 : Transitions sur `Demande` et écrans qui les déclenchent

**Files:**
- Modify: `app/Models/Demande.php`, `app/Http/Controllers/AdminController.php` (`transmettre`, `updateMessage`, `updateBudget`), `app/Http/Livewire/{ListeDemande,DemandeSuspendu,DemandeVerifier}.php`
- Test: `tests/Feature/TransitionsDemandeTest.php`

**Interfaces:**
- Produces, sur `Demande` :
  - `transmettre(): void`, qui renseigne `date_transmission` ;
  - `suspendre(string $message): void` ;
  - `approuver(int $montantAccorde, string $dateApprobation): void`, qui renseigne `buget_prevu` et `date_approbation`, et refuse un montant supérieur au montant demandé ;
  - `scopeEtat(Builder $q, EtatDemande $etat)`, `scopeEnCours(Builder $q)` (`cloturee_le` null), `scopeAllocations(Builder $q)` (approuvee).
- Toute transition non autorisée lève `App\Exceptions\TransitionInterdite` (message en français). Les contrôleurs et composants l'attrapent et affichent le message en alerte.
- Pendant la transition, les méthodes écrivent aussi les anciennes colonnes (`valide`, `suspendre`, `statut`, `statuts`), pour que les écrans pas encore migrés restent justes. Cette double écriture disparaît en Task 5.

- [ ] **Step 1: Tests qui échouent** (un test par transition autorisée, avec l'état et les champs attendus) :
  - `test_transmettre`, `test_suspendre_enregistre_le_message`, `test_retransmettre_une_suspendue`, `test_approuver_renseigne_montant_et_date` ;
  - `test_transition_interdite_refusee` : `approuver()` sur une demande en attente lève l'exception, état inchangé ;
  - `test_approbation_superieure_au_montant_demande_refusee` ;
  - par HTTP et Livewire : `transmettre` (secrétaire), `updateMessage` (vérificateur), `updateBudget` (vérificateur) aboutissent au bon état.
- [ ] **Step 2:** → FAIL.
- [ ] **Step 3:** Implémenter, et remplacer chaque écriture directe d'état dans les fichiers listés.
- [ ] **Step 4:** → PASS ; suite complète verte.
- [ ] **Step 5:** `regression-reviewer`, commit.

### Task 3 : Réintégrer les dossiers clôturés dans `demandes`

**Files:**
- Create: `database/migrations/2026_10_23_100000_reintegrate_closed_demandes.php`
- Modify: `app/Http/Livewire/ExercicesClotures.php`, `AdminController::{showCloture,generatePdfForDemandeCloture,telechargerCloture}`, `resources/views/Admin/{show-cloture,pdf-cloture}.blade.php`, `app/Exports/DemandesClotureesExport.php`
- Delete (en fin de tâche) : `app/Models/DemandeCloture.php`, `app/Models/DemandeLocalisationCloture.php`
- Test: `tests/Feature/ReintegrationCloturesTest.php`

**Interfaces:**
- La conversion est une classe appelable : `App\Support\ReintegrationClotures::executer(): array` → `['demandes' => int, 'localisations' => int]`. La migration l'appelle. Elle insère chaque ligne de `demandes_clotures` dans `demandes` avec `id = demande_id_original` (identifiants jamais réutilisés : la clôture les avait supprimés de `demandes`), `exercice = annee_exercice_cloture`, `cloturee_le = date_cloture`, `cloturee_par = user_id_cloture`, `etat = depuisDrapeaux(valide, suspendre)`, et les mêmes colonnes métier. Les localisations reviennent dans `demande_localisations` avec `demande_id = demande_id_original`. Avant toute insertion, si un `demande_id_original` existe déjà dans `demandes`, la migration s'arrête avec la liste des conflits.
- Les tables `demandes_clotures` et `demande_localisations_clotures` sont conservées jusqu'à la Task 5, comme filet de retour.
- Les routes `*_cloture` gardent leur URL mais lisent `Demande::whereNotNull('cloturee_le')`.

- [ ] **Step 1: Tests qui échouent** (chaque test insère des lignes dans `demandes_clotures`, puis appelle `ReintegrationClotures::executer()` ; tous sont **transitoires**, et la Task 5 supprime le fichier avec les tables)
  - `test_reintegration_conserve_identifiant_et_champs` : une ligne clôturée (id original 501, exercice 2024, rapport H 10 / F 30, handicap 1 / 3) → `Demande::find(501)` a ces valeurs, `cloturee_le` non null, `exercice` 2024.
  - `test_reintegration_ramene_les_localisations`.
  - `test_reintegration_arretee_en_cas_de_conflit_d_identifiant`.
  - `test_dossier_cloture_reintegre_consultable` : `demande.cloture.show`, `demande.cloture.pdf` et la page `exercices.clotures` répondent 200 pour un directeur.
- [ ] **Step 2:** → FAIL.
- [ ] **Step 3:** Implémenter.
- [ ] **Step 4:** → PASS. Sur la base du worktree : nombre de lignes de `demandes` après = avant + 81 ; nombre de localisations après = avant + nombre de lignes de `demande_localisations_clotures`. Les deux comptes sont notés.
- [ ] **Step 5:** `regression-reviewer`, commit.

### Task 4 : Nouvelle clôture d'exercice

**Files:**
- Create: `app/Services/ClotureExercice.php`
- Modify: `app/Http/Livewire/DemandeApprouve.php` (`calculerStatistiquesCloture`, `cloturerExercice` appellent le service ; le SQL brut est supprimé)
- Test: `tests/Feature/ClotureExerciceTest.php` (réécrit)

**Interfaces:**
- Produces : `ClotureExercice::cloturer(int $annee, User $par): array` → `['cloturees' => int, 'reportees' => int]`, en une transaction, avec le query builder (plus de SQL propre à MySQL). `ClotureExercice::apercu(int $annee): array` → mêmes clés plus `'montant_accorde' => int`, pour la fenêtre de confirmation.

- [ ] **Step 1: Tests qui échouent** (exercice 2025 : A approuvée, B en attente, C suspendue, D approuvée déjà clôturée)
  - `test_cloture_marque_les_allocations_approuvees` : A a `cloturee_le` non null et `cloturee_par` renseigné ; résultat `cloturees` = 1.
  - `test_cloture_reporte_les_autres_demandes` : B et C passent à l'exercice 2026, état inchangé, `cloturee_le` null ; `reportees` = 2.
  - `test_cloture_idempotente` : un second appel donne `['cloturees' => 0, 'reportees' => 0]`.
  - `test_demande_reportee_cloturee_avec_l_exercice_suivant` : B approuvée en 2026, puis `cloturer(2026)` la clôture.
  - `test_apercu_sans_effet` : `apercu(2025)` renvoie `cloturees` 1, `reportees` 2 et ne modifie rien.
- [ ] **Step 2:** → FAIL.
- [ ] **Step 3:** Implémenter ; la fenêtre de clôture affiche les deux nombres avant confirmation.
- [ ] **Step 4:** → PASS.
- [ ] **Step 5:** `regression-reviewer`, commit.

### Task 5 : Lectures sur l'état, puis suppression des anciennes colonnes

**Files:**
- Modify : chaque fichier listé par `grep -rnE "'(valide|suspendre|rejeter|statut|statuts)'|->(valide|suspendre|rejeter|statut|statuts)\b|demandes\.(valide|statuts|suspendre)" app resources/views database` (inventaire du 2026-10-21 : `AdminController`, `IndexAdmin`, `ListeDemande`, `DemandeVerifier`, `DemandeSuspendu`, `DemandeApprouve`, `PostAppui`, `SuiviDemandes`, `DemandeArchivee`, `StatistiquesBeneficiaires`, `RapportAllocationController`, les trois exports, les vues `liste-demande`, `demande-verifier`, `demande-suspendu`, `demande-approuve`, `suivi-demandes`, `Admin/show`, `Admin/pdf`, `Admin/pdf-cloture`, `DemandeFactory`)
- Rename: `app/Exports/DemandesRejeteesExport.php` → `DemandesSuspenduesExport.php`
- Create: `database/migrations/2026_10_23_200000_drop_legacy_state_columns.php`, qui supprime `status`, `statut`, `statuts`, `valide`, `suspendre` et `rejeter` de `demandes`, puis les tables `demandes_clotures` et `demande_localisations_clotures`
- Test: `tests/Feature/TableauDeBordTest.php`. Dans le même commit, mettre à jour les tests qui touchent ce qui disparaît :
  - tous les tests qui posent `valide`, `suspendre` ou `statuts` (`creerAllocation()` pose désormais `etat`) ;
  - `SchemaProductionTest` : retirer les colonnes et tables supprimées ;
  - `StatistiquesBeneficiairesTest::test_ignore_demandes_cloturees` : réécrit pour qu'une demande avec `cloturee_le` renseigné soit exclue ;
  - supprimer les tests transitoires `MigrationEtatDemandesTest` et `ReintegrationCloturesTest`, et garder `MigrationEtatTest` (fonction pure, sans table).

**Interfaces:**
- Les listes lisent `etat` et `enCours()`. Toutes les sections de la page statistiques, et `StatistiquesBeneficiaires`, utilisent `allocations()` : il n'y a plus deux définitions d'« approuvé ». La carte « Rejetées » du tableau de bord devient « Suspendues ».

- [ ] **Step 1: Tests qui échouent**
  - `test_tableau_de_bord_compte_chaque_demande_une_fois` : en attente 1, transmise 1, suspendue 1, approuvée 2 → les cartes affichent ces nombres, et leur somme égale le total.
  - `test_sections_statistiques_meme_definition` : une demande approuvée sans libellé apparaît dans les sections 1, 2 et 4.
- [ ] **Step 2:** → FAIL.
- [ ] **Step 3:** Migrer chaque lecture. Le `grep` ci-dessus ne renvoie plus rien hors migrations. Retirer la double écriture de la Task 2, puis écrire la migration de suppression.
- [ ] **Step 4:** Suite complète verte, `PagesTest` compris. Navigateur : tableau de bord, chaque liste, statistiques, post-appui, dossiers clôturés, exports Excel.
- [ ] **Step 5:** `regression-reviewer`, commit.
