# Nettoyage du code mort : plan d'implémentation

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Supprimer le code qu'aucune route ni aucune vue n'atteint, pour réduire la surface à faire évoluer pendant la refonte de l'état des demandes et la montée de version.

**Architecture:** Un test « toutes les pages s'affichent » sert de filet de sécurité. Ensuite, des suppressions par lots, chacune prouvée morte par recherche de références et par `route:list`.

**Tech Stack:** Laravel 9, Livewire 2, PHPUnit 9.

**Spec:** points N1 de `2026-10-21-feuille-de-route-corrections.md`.

## Global Constraints

- Ne supprimer qu'après avoir prouvé l'absence de référence : `grep -rn` sur le nom de classe, le nom kebab-case Livewire, le nom de vue et le nom de route, dans `app resources routes config`. Le résultat de cette recherche est noté dans le journal d'exécution.
- Ne pas toucher à ce qui dépend d'une question ouverte : formulaire de contact (Q5), archivage (Q6).
- Le filet de sécurité de la Task 1 sert aussi aux plans suivants.

## Review Focus

1. **Une page encore utilisée** appelait un composant supprimé : erreur 500. → Task 1 `test_toutes_les_pages_s_affichent`.
2. **Page de connexion, mot de passe oublié et profil** (Fortify et Jetstream) : elles s'affichent toujours après la suppression des vues `auth/*` de laravel/ui. → Task 1, pages invitées et `profile.show`.
3. **Graphiques du tableau de bord** : ils s'affichent encore une fois les composants Livewire de statistiques retirés (le Chart.js du layout reste). → Task 1 + contrôle navigateur en Task 3.

---

### Task 1 : Filet de sécurité « toutes les pages s'affichent »

**Files:**
- Create: `tests/Feature/PagesTest.php`

**Interfaces:**
- Produces : un test paramétré par un fournisseur de données `public static function pages(): array`, avec des entrées (rôle, nom de route, `avecId` booléen). Il couvre chaque route GET nommée de `routes/web.php` pour le rôle autorisé par sa gate, plus les pages invitées (`/`, `/service`, `/A_propos`, `/login`, `/forgot-password`) et `profile.show`. Le fournisseur s'exécute avant le démarrage de l'application : il ne crée aucune donnée. C'est le corps du test qui crée l'allocation (`creerAllocation()` avec un rapport, pour que les fiches et les PDF existent), puis qui passe son identifiant quand `avecId` est vrai. Le fournisseur est `static` pour rester compatible avec PHPUnit 10 et suivants.

- [ ] **Step 1:** Écrire `test_toutes_les_pages_s_affichent` : statut 200 pour chaque entrée (les PDF : 200 et `Content-Type` PDF). `/contact` est exclu tant que Q5 n'est pas tranchée : une ligne de commentaire le dit.
- [ ] **Step 2:** `php artisan test --filter=PagesTest` → PASS sur le code actuel. C'est voulu : ce test est un filet, pas une spécification nouvelle. S'il échoue, l'échec révèle une page déjà cassée, qui est signalée à l'utilisateur.
- [ ] **Step 3:** Commit.

### Task 2 : Composants et méthodes sans point d'entrée

Liste vérifiée le 2026-10-21 (aucune vue ne les affiche, aucune route ne les appelle) :

| Élément | Fichiers |
|---|---|
| Livewire non affichés | `app/Http/Livewire/{Contact,DetailDemande,FormulaireClient,PrintPage,RechercheDemande,SuivreDemande}.php` et leurs vues `resources/views/livewire/*` |
| Statistiques publiques sans route | `ClientController::statistiqueDepartement`, `statistiqueSexe`, `statistiqueService`, `statistiqueDemandeur` ; vues `resources/views/Statistique/{departement,sexe,service,demandeur,effectifs-par-branche}.blade.php` ; Livewire `Demandeur`, `Departement`, `Sexe`, `Service`, `EffectifsParBranche` et leurs vues |
| Suivi et recherche publics commentés | `ClientController::SuivreDemande`, `RechercheDemande` ; vues `Client/suivredemande.blade.php`, `Client/recherchedemande.blade.php` |

- [ ] **Step 1:** Pour chaque ligne, relancer la recherche de références et la noter.
- [ ] **Step 2:** Supprimer, puis `composer dump-autoload`.
- [ ] **Step 3:** `php artisan test` → vert, `PagesTest` compris.
- [ ] **Step 4:** Commit.

### Task 3 : Authentification de laravel/ui et restes du template

| Élément | Condition avant suppression |
|---|---|
| `app/Http/Controllers/Auth/*`, `HomeController`, `resources/views/home.blade.php`, `resources/views/auth/passwords/*`, paquet `laravel/ui` | `Auth::routes()` reste commenté ; `php artisan route:list` ne montre aucune route vers ces contrôleurs ; Fortify et Jetstream servent `login`, `forgot-password` et `reset-password` |
| `public/Admin/examples/`, `public/Admin/README.md`, `public/Admin/demo/` | Plus aucune vue ne les référence après le plan « Correctifs d'affichage » |
| Feuilles `public/Admin/assets/css/corporate-ui-dashboard*.css` | Non référencées par `Commun/Admin.blade.php` |
| `resources/views/welcome.blade.php` | Aucune route ne la rend |
| `test_api.php` (racine) | Remplacé par la suite de tests ; retirer aussi sa ligne dans `CLAUDE.md` |

- [ ] **Step 1:** Vérifier chaque condition et noter le résultat.
- [ ] **Step 2:** Supprimer ; `composer remove laravel/ui`.
- [ ] **Step 3:** `php artisan test` → vert. Dans le navigateur : connexion, mot de passe oublié, profil, tableau de bord. Aucune erreur en console.
- [ ] **Step 4:** `regression-reviewer` sur le diff du plan, puis commit.
