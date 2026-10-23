# Correctifs d'affichage : plan d'implémentation

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Supprimer les erreurs JavaScript et les fichiers introuvables de l'espace admin, et retirer des graphiques g6, g16 et g17 les demandes non approuvées qui y fuient.

**Architecture:** Corrections dans le layout `Commun/Admin`, la vue `livewire/index-admin` et trois requêtes de `AdminController::statistiques`. Aucune modification du modèle de données.

**Tech Stack:** Laravel 9 (Blade), Chart.js, MySQL 8, PHPUnit 9.

**Spec:** constats A1 à A3 de `docs/superpowers/plans/2026-10-21-feuille-de-route-corrections.md`.

## Global Constraints

- Ne pas toucher au `Chart.js` du layout (`Admin/assets/js/plugins/chartjs.min.js`) : six vues Livewire l'utilisent.
- Les graphiques g6, g16 et g17 gardent leur définition actuelle d'« approuvé » (`statuts = 'Approuvé'`). L'unification relève du plan « État des demandes ».
- Exécution dans le worktree du programme (bases `basefda_wt` et `basefda_wt_test`). Après chaque tâche : `regression-reviewer`, puis un commit.

## Review Focus

1. **Pages imbriquées** (`/budget_demande/{id}`, `/detail_demande/{id}`, `/edit_demande/{id}`) : jQuery et Bootstrap se chargent (menu utilisateur, barre latérale). → Task 1, contrôle navigateur.
2. **Tableau de bord** : plus aucune erreur en console, les cartes s'affichent. → Task 1, contrôle navigateur.
3. **Département non renseigné** sur une demande approuvée : elle reste visible dans g16/g17 sous « Non renseigné », au lieu de disparaître. → Task 2 `test_g17_departement_non_renseigne_conserve`.
4. **Branche supprimée** dans g6 : la demande apparaît sous « Branche inconnue ». → Task 2 `test_g6_branche_inconnue`.
5. **Impression de la page statistiques** : elle fonctionne toujours. → Task 2, contrôle navigateur.

---

### Task 1 : Layout admin sans fichiers introuvables ni code de démonstration

**Files:**
- Modify: `resources/views/Commun/Admin.blade.php` (scripts et feuilles de style en `asset('Admin/...')` ; retirer le script Google Maps `key=YOUR_KEY_HERE`, `Admin/assets/demo/demo.js` et l'appel `demo.initDashboardPageCharts()`)
- Modify: `resources/views/livewire/index-admin.blade.php` (retirer le bloc `<script>` qui cible `#bigDashboardChart`, absent de la page)
- Test: `tests/Feature/LayoutAdminTest.php`

- [ ] **Step 1: Tests qui échouent** (en vérificateur, sur une allocation créée par `creerAllocation()`)
  - `test_scripts_charges_en_chemin_absolu` : la réponse de `route('demande.budget', $id)` contient `asset('Admin/assets/js/core/jquery.min.js')` et ne contient pas `src="Admin/assets/`.
  - `test_code_de_demonstration_retire` : la réponse de `route('home')` ne contient ni `YOUR_KEY_HERE`, ni `demo.initDashboardPageCharts`, ni `bigDashboardChart`.
- [ ] **Step 2:** `php artisan test --filter=LayoutAdminTest` → FAIL.
- [ ] **Step 3:** Implémenter. Vérifier avec `grep -n 'src="Admin/\|href="Admin/' resources/views/Commun/Admin.blade.php` qu'il ne reste aucun chemin relatif.
- [ ] **Step 4:** → PASS.
- [ ] **Step 5: Navigateur** : en vérificateur, ouvrir le tableau de bord, `/budget_demande/{id}`, `/detail_demande/{id}` et `/statistiques`. Attendu : aucune erreur en console (hors extensions du navigateur), et le menu utilisateur s'ouvre.
- [ ] **Step 6:** `regression-reviewer`, `/commit` (sur go).

### Task 2 : Graphiques g6, g16 et g17 sans demandes non approuvées

**Files:**
- Modify: `app/Http/Controllers/AdminController.php` (`statistiques` : requêtes g6, g16, g17)
- Test: `tests/Feature/GraphiquesApprouvesTest.php`

**Interfaces:**
- Règle : partir de `Demande::where('statuts', 'Approuvé')` puis faire un `leftJoin` sur `braches` (g6) ou `departements` (g16, g17), avec le filtre dans le `WHERE`. Libellé : `COALESCE(nom, 'Non renseigné')` quand la clé est nulle, `'Branche inconnue'` (g6) quand la clé ne correspond à aucune ligne. Noms et clés des colonnes inchangés (`nom`, `count` ; `nom`, `prevu`, `touche` ; `nom`, `homme`, `femme`), car le JavaScript de la vue les lit.
- Tests : lire les données passées à la vue avec `View::composer('Statistique.index', ...)`, comme dans `RapportAllocationTest::donneesFiche`.

Jeu de données : département 1 « Atlantique », branche 1 « Bois ».

| Demande | statuts | branche | departement | effectif H / F |
|---|---|---|---|---|
| P | Approuvé | 1 | 1 | 10 / 20 |
| Q | Approuvé | 999 | null | 3 / 4 |
| R | null (non approuvée) | 1 | 1 | 100 / 100 |

- [ ] **Step 1: Tests qui échouent**
  - `test_g6_exclut_non_approuvees` : g6 donne Bois → 1 et Branche inconnue → 1, et aucune ligne de `nom` null.
  - `test_g6_branche_inconnue` : la ligne « Branche inconnue » existe avec `count` 1.
  - `test_g17_exclut_non_approuvees` : Atlantique → homme 10, femme 20 (et non 110 / 120).
  - `test_g17_departement_non_renseigne_conserve` : « Non renseigné » → homme 3, femme 4.
  - `test_g16_exclut_non_approuvees` : Atlantique → `touche` 30.
- [ ] **Step 2:** `php artisan test --filter=GraphiquesApprouvesTest` → FAIL.
- [ ] **Step 3:** Implémenter.
- [ ] **Step 4:** → PASS. La suite `StatistiquesPageTest` reste verte.
- [ ] **Step 5: Navigateur** : `/statistiques` sur la base de dev. Le graphique « Nombre de dossiers approuvés par branche » n'a plus de barre vide, et l'impression portrait fonctionne. Capture dans `docs/verification/`.
- [ ] **Step 6:** `regression-reviewer`, `/commit` (sur go).
