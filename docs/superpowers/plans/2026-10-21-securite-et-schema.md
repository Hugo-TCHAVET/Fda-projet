# Sécurité, garde-fous et schéma aligné : plan d'implémentation

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Fermer les failles d'accès et d'écriture constatées, empêcher les tests d'effacer une vraie base, et faire produire aux migrations le même schéma que la production.

**Architecture:** Corrections ciblées dans les routes, `ClientController`, `AdminController::updateDemande`, `PostAppui` et une migration. Les routes publiques sans utilisateur sont supprimées plutôt que protégées. Une migration idempotente aligne le schéma migré sur celui du dump de production.

**Tech Stack:** Laravel 9, Livewire 2, MySQL 8, PHPUnit 9.

**Spec:** pas de document de conception. Source : constats de la session du 2026-10-21, listés dans `docs/superpowers/plans/2026-10-21-feuille-de-route-corrections.md` (points S1 à S8).

## Global Constraints

- Tests uniquement sur une base dont le nom se termine par `_test` (`basefda_wt_test` dans le worktree, via `.env.testing`).
- `basefda.sql` est la référence du schéma de production (hypothèse H1, confirmée par l’utilisateur le 2026-10-21).
- Ne renommer aucune colonne (`buget_prevu`, `braches`, `obejectif_activite` restent tels quels).
- Messages d'interface en français. Pas de tiret cadratin.
- Exécution dans le worktree du programme (voir la feuille de route), avec sa propre base `basefda_wt` et sa base de test `basefda_wt_test`. La base de dev de master n'est jamais touchée.
- Après chaque tâche : agent `regression-reviewer` sur le diff. Un commit par tâche dans le worktree.

## Review Focus

1. **La secrétaire modifie une demande depuis le formulaire habituel** (champs + localisations) : tout est encore enregistré. → Task 6 `test_modification_enregistre_champs_et_localisations`.
2. **Une vue pointe encore vers une route supprimée** → erreur 500 « Route not defined ». → Task 3 et Task 5 `test_pages_secretaire_s_affichent` (liste, détail, édition rendues en 200).
3. **La secrétaire crée une demande depuis `/formulaire`** : la création marche toujours. → Task 4 `test_secretaire_cree_une_demande`.
4. **Un vérificateur saisit un rapport sur une allocation approuvée** : aucun changement. → la suite `PostAppuiRapportTest` existante reste verte (Task 7, étape de vérification).
5. **Lancer les tests sans `.env.testing`** n'efface rien. → Task 1, étape de vérification manuelle avec sauvegarde.

---

### Task 1 : Garde-fou contre l'effacement d'une vraie base

**Files:**
- Modify: `tests/TestCase.php`
- Test: `tests/Feature/GardeFouBaseDeTestTest.php`

**Interfaces:**
- Produces : `Tests\TestCase::verifierBaseDeTest(?string $base): void` (protected static), qui lève `RuntimeException` si `$base` ne se termine pas par `_test`. Appelée dans `setUpTraits()` surchargé, **avant** `parent::setUpTraits()` (c'est là que `RefreshDatabase` agit), avec `config('database.connections.' . config('database.default') . '.database')`.

- [ ] **Step 1: Tests qui échouent**
  - `test_base_sans_suffixe_test_refusee` : `verifierBaseDeTest('basefda')` lève `RuntimeException` dont le message contient `basefda`.
  - `test_base_nulle_refusee` : `verifierBaseDeTest(null)` lève `RuntimeException`.
  - `test_base_de_test_acceptee` : `verifierBaseDeTest('basefda_test')` ne lève rien.
- [ ] **Step 2:** `php artisan test --filter=GardeFouBaseDeTestTest` → FAIL (méthode absente).
- [ ] **Step 3:** Implémenter. Message : `Tests refusés : la base « {base} » n'est pas une base de test (suffixe _test attendu).`
- [ ] **Step 4:** Tests → PASS.
- [ ] **Step 5: Vérification manuelle**
  1. Sauvegarder la base du worktree : `docker exec fda-mysql mysqldump -uroot -proot basefda_wt > <scratchpad>/basefda-avant-garde-fou.sql`.
  2. Renommer `.env.testing` en `.env.testing.off`, lancer `php artisan test`. Attendu : tous les tests échouent avec le message ci-dessus.
  3. Vérifier `select count(*) from demandes` sur `basefda_wt` : valeur inchangée.
  4. Remettre `.env.testing`.
- [ ] **Step 6:** `regression-reviewer`, `/commit` (sur go).

### Task 2 : Migrations alignées sur le schéma de production

**Files:**
- Create: `database/migrations/2026_10_22_000000_align_schema_with_production.php`
- Modify: `tests/Concerns/CreeDonneesReference.php` (retirer les valeurs forcées `piece`, `femme_touche`, `buget_prevu` de `creerDemande()`)
- Modify: `CLAUDE.md` (retirer la puce « Schema drift »)
- Test: `tests/Feature/SchemaProductionTest.php`

**Interfaces:**
- Produces : après `migrate`, les colonnes suivantes acceptent NULL, avec le même type et le même défaut qu'aujourd'hui, et `demandes.femme_touche` n'existe plus.

| Table | Colonnes rendues nullables |
|---|---|
| `demandes` | `archivee`, `buget_prevu`, `commune`, `contact`, `debut_activite`, `departement`, `dure_activite`, `fin_activite`, `homme_touche`, `lieux`, `piece`, `rapport_depose`, `rejeter`, `suspendre`, `valide` |
| `demandes_clotures` | `archivee`, `buget_prevu`, `rapport_depose`, `rejeter`, `status`, `suspendre`, `valide` |
| `demande_localisations` | `homme_touche` |
| `demande_localisations_clotures` | `commune_id`, `departement_id`, `homme_touche`, `lieux` |

- Règle : migration **idempotente**. `ALTER TABLE ... MODIFY` en SQL brut (pas de `doctrine/dbal`), suppression de `femme_touche` seulement si `Schema::hasColumn`. Sur la production, où ces colonnes sont déjà nullables, la migration ne change rien. Les clés étrangères des tables de localisations restent en place. `down()` ne fait rien et un commentaire d'une ligne dit pourquoi : revenir en NOT NULL échouerait sur les données réelles.

- [ ] **Step 1: Tests qui échouent**
  - `test_colonnes_nullables_comme_en_production` : pour chaque couple (table, colonne) du tableau, `information_schema.columns.is_nullable` vaut `YES`. Test transitoire : le plan « État et exercices », Task 5, retire de sa liste les colonnes et les tables qu'il supprime.
  - `test_femme_touche_absente_de_demandes` : `Schema::hasColumn('demandes', 'femme_touche')` est faux.
  - `test_demande_minimale_comme_le_formulaire` : `Demande::create()` avec seulement `code`, `structure`, `service`, `type_demande`, `nom`, `prenom`, `sexe`, `ifu`, `titre_activite`, `obejectif_activite`, `budget` réussit.
- [ ] **Step 2:** `php artisan test --filter=SchemaProductionTest` → FAIL.
- [ ] **Step 3:** Écrire la migration ; retirer les trois valeurs forcées dans `creerDemande()`.
- [ ] **Step 4:** `php artisan test` (suite complète) → PASS. Puis sur la base du worktree (`basefda_wt`) : `php artisan migrate` → OK, et le nombre de demandes est inchangé.
- [ ] **Step 5: Contrôle d'égalité des schémas.** Comparer `information_schema.columns` (`table_name, column_name, column_type, is_nullable, column_default`) entre `basefda_wt` et `basefda_wt_test`. Attendu : aucune différence.
- [ ] **Step 6:** `regression-reviewer`, `/commit` (sur go).

### Task 3 : Supprimer la modification publique des demandes

**Files:**
- Modify: `routes/web.php` (retirer `demande.modifier` et `demande.update`)
- Modify: `app/Http/Controllers/ClientController.php` (retirer `modifier()` et `update()`)
- Delete: `resources/views/Client/modifier-formulaire.blade.php`, `resources/views/Client/modifierFormulaire.blade.php`, `app/Http/Livewire/ModifierFormulaire.php`, `resources/views/livewire/modifier-formulaire.blade.php`
- Test: `tests/Feature/AccesDemandesTest.php`

Constat : aucune vue ne crée de lien vers `demande.modifier`. Ces routes ne servent qu'à exposer et modifier n'importe quelle demande sans connexion. La modification légitime passe par `demande.edit` / `update.demande` (secrétaire et vérificateur).

- [ ] **Step 1: Tests qui échouent** (une demande existante, aucun utilisateur connecté)
  - `test_modification_publique_impossible` : `get('/demande/modifier/{id}')` → 404 ; `put('/demande/update/{id}', ['structure' => 'Piratée'])` → 404 ou 405, et `structure` est inchangée en base.
  - `test_pages_secretaire_s_affichent` : en secrétaire, `route('liste.demande')`, `route('demande.show', $id)` et `route('demande.edit', $id)` répondent 200.
- [ ] **Step 2:** `php artisan test --filter=AccesDemandesTest` → FAIL (200 aujourd'hui).
- [ ] **Step 3:** Supprimer routes, méthodes et fichiers. `grep -rn "demande.modifier\|demande.update'\|modifier-formulaire\|ModifierFormulaire" app resources routes` ne renvoie plus rien.
- [ ] **Step 4:** Tests → PASS.
- [ ] **Step 5:** `regression-reviewer`, `/commit` (sur go).

### Task 4 : Création de demande réservée à la secrétaire

**Files:**
- Modify: `routes/web.php` (déplacer `Route::post('/demande/store', ...)` dans le groupe authentifié, avec `->middleware('can:view-formulaire')`)
- Test: `tests/Feature/AccesDemandesTest.php`

Charge utile valide (réutilisée par les tests) : `structure` « Atelier Test », `service` « Formation », `type_demande` « structure », `nom` « Doe », `prenom` « Jane », `sexe` « Féminin », `ifu` « 1234567890123 », `titre_activite` « Titre », `obejectif_activite` « Objectif », `budget` 500000.

- [ ] **Step 1: Tests qui échouent**
  - `test_creation_refusee_sans_connexion` : POST sur `route('demande.store')` → redirection vers `/login`, aucune demande créée.
  - `test_creation_refusee_au_verificateur` : → 403, aucune demande créée.
  - `test_secretaire_cree_une_demande` : → une demande `structure = 'Atelier Test'` existe, avec `valide = '0'`.
- [ ] **Step 2:** → les deux premiers FAIL (la route est publique aujourd'hui).
- [ ] **Step 3:** Déplacer la route.
- [ ] **Step 4:** Tests → PASS.
- [ ] **Step 5:** `regression-reviewer`, `/commit` (sur go).

### Task 5 : Supprimer la suppression par lien GET

**Files:**
- Modify: `routes/web.php` (retirer `Route::get('/delete/{id}', ...)`, nom `demande.delete`)
- Modify: `app/Http/Controllers/AdminController.php` (retirer `delete()`)
- Test: `tests/Feature/AccesDemandesTest.php`

Constat : aucune vue n'utilise `demande.delete`. La suppression dans l'interface passe par l'action Livewire `DemandeVerifier::delete`, qui est en POST et protégée par CSRF. Elle reste en place.

- [ ] **Step 1: Test qui échoue** `test_suppression_par_lien_impossible` : en secrétaire, `get('/delete/{id}')` → 404, la demande existe toujours.
- [ ] **Step 2:** → FAIL.
- [ ] **Step 3:** Supprimer la route et la méthode.
- [ ] **Step 4:** → PASS, et `test_pages_secretaire_s_affichent` reste vert.
- [ ] **Step 5:** `regression-reviewer`, `/commit` (sur go).

### Task 6 : `updateDemande` n'écrit que les champs du formulaire

**Files:**
- Modify: `app/Http/Controllers/AdminController.php` (`updateDemande`)
- Test: `tests/Feature/ModificationDemandeTest.php`

**Interfaces:**
- Règle : les données écrites viennent **uniquement** de `$validated`, sans `localisations` ni `piece` (le chemin de `piece` est ajouté seulement si un fichier a été envoyé). Les localisations sont créées à partir de `$validated['localisations']`, pas de `$request->localisations`.

- [ ] **Step 1: Tests qui échouent** (en secrétaire, PUT sur `route('update.demande', $id)` avec la charge utile de la Task 4)
  - `test_modification_ignore_champs_hors_formulaire` : la charge utile + `valide` « 2 », `statuts` « Approuvé », `buget_prevu` « 999999 », `rapport_fichier` « secret.txt » → `structure` vaut « Atelier Test » ; `valide`, `statuts`, `buget_prevu` et `rapport_fichier` gardent leurs valeurs d'avant.
  - `test_modification_enregistre_champs_et_localisations` : la charge utile + `localisations[0]` (`departement_id` 1, `commune_id` 1, `lieux` « Cotonou », `homme_touche` 12) → une seule localisation en base, avec ces valeurs.
- [ ] **Step 2:** → le premier FAIL (`valide` passe à 2 aujourd'hui).
- [ ] **Step 3:** Implémenter.
- [ ] **Step 4:** → PASS.
- [ ] **Step 5:** `regression-reviewer`, `/commit` (sur go).

### Task 7 : Post-appui limité aux allocations, sans fichier orphelin

**Files:**
- Modify: `app/Http/Livewire/PostAppui.php`
- Test: `tests/Feature/PostAppuiRapportTest.php`

**Interfaces:**
- Produces : `private function allocation(?int $id): ?Demande`, qui renvoie `Demande::where('valide', '2')->whereNotNull('buget_prevu')->find($id)`. C'est le même périmètre que la liste de `render()`. `edit()`, `store()` et `estAncienRapportSansHandicap()` l'utilisent.
- Règle : si `update()` échoue après `putFile`, le nouveau fichier est supprimé avant l'alerte d'erreur.

- [ ] **Step 1: Tests qui échouent**
  - `test_rapport_refuse_pour_demande_non_approuvee` : demande `valide = '1'` ; `Livewire::test(PostAppui::class)->set('demandeId', $id)`, puis les valeurs valides, puis `call('store')` → `rapport_depose` reste faux.
  - `test_edition_refusee_pour_demande_non_approuvee` : `call('edit', $id)` → `showModal` reste `false`.
  - `test_nouveau_fichier_supprime_si_enregistrement_echoue` : `Demande::updating(fn () => throw new \RuntimeException('panne'))`, store avec un PDF → `Storage::disk('local')->files('rapports')` est vide.
- [ ] **Step 2:** → FAIL.
- [ ] **Step 3:** Implémenter.
- [ ] **Step 4:** `php artisan test --filter=PostAppuiRapportTest` → toute la classe PASS (anciens et nouveaux tests).
- [ ] **Step 5:** `regression-reviewer`, `/commit` (sur go).

### Task 8 : Plus de mot de passe initial dans le code

**Files:**
- Modify: `database/migrations/2024_06_20_105017_add_default_user.php`
- Modify: `.env.example` (ajouter `FDA_MOT_DE_PASSE_INITIAL=`, avec une ligne de commentaire)
- Test: `tests/Feature/ComptesParDefautTest.php`

**Interfaces:**
- Règle : les comptes créés par la migration reçoivent `Hash::make(env('FDA_MOT_DE_PASSE_INITIAL') ?: Str::random(40))`. Sans variable, le mot de passe est aléatoire et inconnu ; l'accès se fait par « Mot de passe oublié » ou par un administrateur. La migration a déjà tourné en production : cette modification ne vaut que pour les installations neuves.

- [ ] **Step 1: Test qui échoue** `test_comptes_par_defaut_sans_mot_de_passe_connu` : après migration, `Hash::check('fdan2024', User::where('email', 'sese@gmail.com')->value('password'))` est faux.
- [ ] **Step 2:** → FAIL.
- [ ] **Step 3:** Implémenter.
- [ ] **Step 4:** → PASS.
- [ ] **Step 5: Action hors code, pour l'utilisateur :** les 6 comptes du dump partagent ce mot de passe (vérifié). En production, chaque compte doit le changer (Profil → Mettre à jour le mot de passe). Le signaler dans le bilan, sans le faire soi-même.
- [ ] **Step 6:** `regression-reviewer`, `/commit` (sur go).

### Task 9 : Inscription publique fermée, tableau de bord réservé au personnel

Constat vérifié le 2026-10-21 : un visiteur crée un compte sur `/register` (rôle `client` par défaut), puis voit le tableau de bord et ses montants. `/dashboard` n'exige qu'une connexion.

**Files:**
- Modify: `config/fortify.php` (retirer `Features::registration()`)
- Modify: `app/Providers/AuthServiceProvider.php` (nouvelle gate `view-dashboard` : secrétaire, vérificateur ou directeur)
- Modify: `routes/web.php` (`/dashboard` avec `->middleware('can:view-dashboard')`)
- Modify: `app/Providers/RouteServiceProvider.php` si nécessaire, pour que la redirection après connexion d'un compte sans rôle ne boucle pas
- Test: `tests/Feature/AccesDemandesTest.php`

- [ ] **Step 1: Tests qui échouent**
  - `test_inscription_publique_fermee` : `get('/register')` → 404, et `post('/register', [...])` ne crée aucun utilisateur.
  - `test_tableau_de_bord_refuse_au_role_client` : un utilisateur `role = 'client'` reçoit 403 sur `route('home')`.
  - `test_tableau_de_bord_ouvert_au_personnel` : secrétaire, vérificateur et directeur reçoivent 200.
- [ ] **Step 2:** → FAIL.
- [ ] **Step 3:** Implémenter. Les tests Jetstream qui supposent l'inscription ouverte (s'il y en a) sont adaptés, pas supprimés en silence : chaque modification est notée.
- [ ] **Step 4:** → PASS, et suite complète verte.
- [ ] **Step 5: Action hors code, pour l'utilisateur :** lister les comptes `role = 'client'` en production (`select id, email, created_at from users where role = 'client'`). Ce sont des inscriptions publiques à examiner, puis à supprimer.
- [ ] **Step 6:** `regression-reviewer`, `/commit` (sur go).

### Task 10 : Vérification d'ensemble

- [ ] **Step 1:** `php artisan test` → tout vert. Comparer avec la référence d'avant le plan (54 réussis, 3 ignorés), plus les nouveaux tests.
- [ ] **Step 2: Navigateur, base de dev, avec captures dans `docs/verification/`** :
  - en secrétaire : création d'une demande via `/formulaire`, puis modification via « Modifier » ;
  - en vérificateur : approbation d'un budget, puis saisie d'un rapport post-appui.
- [ ] **Step 3:** Avant toute PR : `/codebase-design` puis `/zero-tech-debt` sur le diff, bilan, attendre le go.
