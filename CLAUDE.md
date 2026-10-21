# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project

Laravel 9 app for the FDA (Fonds de Développement de l'Artisanat, Bénin): artisans and structures submit funding requests ("demandes" for Formation or Assistance), staff review, approve a budget, track post-support reports, then close the fiscal year. UI, identifiers and messages are in French. Stack: Laravel 9 + Jetstream 3 (Livewire 2 stack, Fortify auth, Sanctum), Bootstrap/Tailwind via Vite, dompdf for PDFs, maatwebsite/excel for exports, sweet-alert / livewire-alert for toasts. The README is the stock Laravel one.

## Commands

```bash
composer install && npm install
cp .env.example .env && php artisan key:generate   # DB_CONNECTION=mysql
npm run dev            # Vite dev server (npm run build for production assets)
php artisan serve
php artisan migrate
php artisan db:seed --class=RoleSeeder             # assigns roles, see "Database setup"
php artisan test                                   # or vendor/bin/phpunit
php artisan test --filter=ProfileInformationTest   # single test class or method
vendor/bin/pint                                    # code style (Laravel preset, no pint.json)
php test_api.php                                   # ad-hoc script printing branche/corps/metier relations
```

**Test database:** the feature tests use `RefreshDatabase`, so they run `migrate:fresh` on the configured database. They must run against a dedicated MySQL database through a git-ignored `.env.testing` (loaded because phpunit sets `APP_ENV=testing`); without that file the suite wipes the database from `.env`. Do not switch to sqlite: the fiscal-year closing uses MySQL-only SQL (`YEAR()`, `DELETE dl FROM ... INNER JOIN`).

Local setup used so far (MySQL in Docker):

```bash
docker run -d --name fda-mysql -p 127.0.0.1:3307:3306 -e MYSQL_ROOT_PASSWORD=root -e MYSQL_DATABASE=basefda mysql:8.0
docker exec -i fda-mysql mysql -uroot -proot basefda < basefda.sql
docker exec fda-mysql mysql -uroot -proot -e "CREATE DATABASE basefda_test CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
sed 's/^DB_DATABASE=.*/DB_DATABASE=basefda_test/; s/^APP_ENV=.*/APP_ENV=testing/' .env > .env.testing
```

`DemandeFactory` picks branches and departments with `inRandomOrder()->first()`, which yields null on the empty test database: tests insert the reference rows they need.

## Database setup

- Reference data (`braches`, `corps`, `metiers`, `departements`, `communes`) exists only in `basefda.sql` (full MySQL dump, also contains sample demandes and users). Migrations alone leave the cascading dropdowns empty. The dropdowns load via unauthenticated JSON routes in `routes/api.php` (`/api/departements`, `/api/communes/{id}`, `/api/corps/{branche_id}`, `/api/metiers/{corp_id}`).
- Users and roles come from three sources that disagree: migration `2024_06_20_105017_add_default_user` inserts `*@gmail.com` staff accounts without role; `RoleSeeder` assigns roles to `*@apps.fda.bj` addresses (plus `dg@gmail.com`); `basefda.sql` has `*@gmail.com` accounts with roles already set. Check which source is authoritative before touching accounts.
- Schema drift: the real database (`basefda.sql`) was altered outside migrations. About 20 `demandes` / `demandes_clotures` columns are nullable there but NOT NULL after `migrate`, and `demandes.femme_touche` exists only in the migrated schema. A fresh `migrate` therefore does not reproduce production; `Tests\Concerns\CreeDonneesReference::creerDemande()` fills the extra NOT NULL columns.
- `users.role` defaults to `client`. Roles: `secretaire`, `verificateur`, `directeur` (helpers `isSecretaire()` etc. on `User`).

## Architecture

### Request flow
Routes in `routes/web.php` point to `AdminController` / `ClientController`, which mostly return a thin Blade view (`resources/views/Admin/*.blade.php`) that just embeds a Livewire component (`@livewire('liste-demande')` → `app/Http/Livewire/ListeDemande.php` + `resources/views/livewire/liste-demande.blade.php`). Most list/action logic lives in the Livewire components; the controller handles detail pages, edit/update, budget, suspension, PDF and file download. Some actions exist twice (e.g. "transmettre" in `AdminController::transmettre` and `ListeDemande::Transmetre`); change both. The real layouts are `resources/views/Commun/Admin.blade.php` and `Commun/Client.blade.php`, not Jetstream's `layouts/app`.

### Authorization
All staff routes are inside the `auth:sanctum` + `verified` group and each one is guarded by a Gate (`->middleware('can:...')`) defined in `app/Providers/AuthServiceProvider.php`. The sidebar menu uses the same gates. Adding a page means: route + gate + menu entry.

Session lifetime: `FortifyServiceProvider` stores `remember_me` in the session at login, and `AdjustSessionLifetime` (web middleware group) sets 30 days or 24 h from it.

### Demande workflow
State is held in integer-like string columns on `demandes`, not a single enum:

| Step | Who | Write | Listed in |
|---|---|---|---|
| Submitted | secretaire (`/formulaire` → `ClientController::store`) | `valide=0`, `suspendre=0` | `ListeDemande` |
| Transmitted | secretaire | `valide=1`, `statut='En cours de traitement'`, `date_transmission` | `DemandeVerifier` |
| Suspended | verificateur | `suspendre=1`, `statut='Suspendus'`, `message` | `DemandeSuspendu` (re-transmit resets `suspendre=0`) |
| Approved | verificateur (`updateBudget`) | `valide=2`, `statuts='Approuvé'`, `buget_prevu` (must be ≤ `budget`), `date_approbation` | `DemandeApprouve` |
| Post-appui | verificateur/directeur | `rapport_depose`, `effectif_homme_forme`, `effectif_femme_forme`, `effectif_handicape_homme`, `effectif_handicape_femme`, `observations_rapport`, `rapport_fichier`, `date_depot_rapport` | `PostAppui` |
| Archived | `DemandeApprouve::archiver` | `archivee=true`, `annee_exercice` | `DemandeArchivee` |

Three label columns coexist: `status` (default `'En attente'`, effectively unused), `statut` (workflow label), `statuts` (approval label). Statistics (`AdminController::statistiques`) and exports filter on the exact string `statuts = 'Approuvé'`. Amounts and counts are stored in string columns; `budget`/`buget_prevu` can contain spaces and are cast with `str_replace(' ', '', ...)` before summing.

Livewire actions (archive, post-appui report, fiscal-year closing) have no gate check of their own; access control is only the route gate of the page embedding the component. `PostAppui` is reachable by `directeur` too, so directors can record reports.

### Beneficiary indicators
Beneficiaries are the people trained, as declared in the post-appui report, not the applicant. `App\Services\StatistiquesBeneficiaires` computes them (by branche / service, sex rate, disability rate, report coverage) over allocations defined as `valide = 2`, while the older sections of the statistics page filter on `statuts = 'Approuvé'`, so their totals can differ. Reports saved before the disability fields existed have NULL there and are excluded from the disability rate. Indicators cover live `demandes` only; the service takes a base query so it can be pointed at `DemandeCloture` later. Per allocation, `RapportAllocationController` serves a PDF fiche and the uploaded report, stored on the private `local` disk under `rapports/` and served only from that prefix.

### Fiscal-year closing (`DemandeApprouve::cloturerExercice`)
Selects by `YEAR(created_at)` (not by `archivee` or `annee_exercice`), copies **every** demande of that year in any state into `demandes_clotures` and their `demande_localisations` into `demande_localisations_clotures`, then **deletes** them from the live tables, in one transaction with raw SQL. Any column added to `demandes` must also be added to `demandes_clotures` and to both column lists of that `INSERT ... SELECT`. Closed records are served by `DemandeCloture`, `ExercicesClotures` and the `*_cloture` routes (detail, PDF, file download).

### Files
Uploaded documents go to the `uploads` disk (`config/filesystems.php`), i.e. `public/uploads/piece/...`; `demandes.piece` stores the path relative to that disk.

## Gotchas

- Misspellings are the real schema and class names; do not "fix" them: model `Brache` / table `braches`, `buget_prevu`, `obejectif_activite`, `dure_activite`, Livewire `ServiveClient`.
- `Demande` uses `$guarded = []`; anything in a request array passed to `update()` is written.
- Public (unauthenticated) routes act on ids: `/demande/store`, `/demande/modifier/{id}`, `/demande/update/{id}`, plus the `/api/*` reference routes.
- `resources/views/Client/contact.blade.php` posts to `route('contact.submit')`, whose route is commented out in `routes/web.php`.
- `app/Http/Livewire/FormulaireClient.php` is not embedded in any view found; the live submission form is `Client/formulaire.blade.php` posting to `ClientController::store`.
- Livewire 2 forms that also upload a file: bind the other fields with `wire:model.lazy`, not `.defer`. The upload's re-render resets every unfocused deferred field to its server value, silently dropping what the user typed.
- `AdminController::updateDemande` writes `$request->except([...])`, so any column can be set through that form.
- Email notifications on submission are commented out; `ClientController` sends the contact mail to a hardcoded address.
