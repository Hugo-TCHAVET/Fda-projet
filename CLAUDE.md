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
```

**Test database:** the feature tests use `RefreshDatabase`, so they run `migrate:fresh` on the configured database. They must run against a dedicated MySQL database through a git-ignored `.env.testing` (loaded because phpunit sets `APP_ENV=testing`); without that file the suite wipes the database from `.env`. Do not switch to sqlite: the fiscal-year closing uses MySQL-only SQL (`YEAR()`, `DELETE dl FROM ... INNER JOIN`).

Local setup used so far (MySQL in Docker):

```bash
docker run -d --name fda-mysql -p 127.0.0.1:3307:3306 -e MYSQL_ROOT_PASSWORD=root -e MYSQL_DATABASE=basefda mysql:8.0
docker exec -i fda-mysql mysql -uroot -proot basefda < basefda.sql
php artisan migrate   # the dump predates the typed, renamed columns: import first, then migrate
docker exec fda-mysql mysql -uroot -proot -e "CREATE DATABASE basefda_test CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
sed 's/^DB_DATABASE=.*/DB_DATABASE=basefda_test/; s/^APP_ENV=.*/APP_ENV=testing/' .env > .env.testing
```

`DemandeFactory` picks branches and departments with `inRandomOrder()->first()`, which yields null on the empty test database: tests insert the reference rows they need.

## Database setup

- Reference data (`branches`, `corps`, `metiers`, `departements`, `communes`) exists only in `basefda.sql` (full MySQL dump, also contains sample demandes and users). Migrations alone leave the cascading dropdowns empty. The dropdowns load via unauthenticated JSON routes in `routes/api.php` (`/api/departements`, `/api/communes/{id}`, `/api/corps/{branche_id}`, `/api/metiers/{corp_id}`).
- Users and roles come from three sources that disagree: migration `2024_06_20_105017_add_default_user` inserts `*@gmail.com` staff accounts without role; `RoleSeeder` assigns roles to `*@apps.fda.bj` addresses (plus `dg@gmail.com`); `basefda.sql` has `*@gmail.com` accounts with roles already set. Check which source is authoritative before touching accounts.
- `users.role` defaults to `client`. Roles: `secretaire`, `verificateur`, `directeur` (helpers `isSecretaire()` etc. on `User`).

## Architecture

### Request flow
Routes in `routes/web.php` point to `AdminController` / `ClientController`, which mostly return a thin Blade view (`resources/views/Admin/*.blade.php`) that just embeds a Livewire component (`@livewire('liste-demande')` → `app/Http/Livewire/ListeDemande.php` + `resources/views/livewire/liste-demande.blade.php`). Most list/action logic lives in the Livewire components; the controller handles detail pages, edit/update, budget, suspension, PDF and file download. Some actions have two entry points (e.g. transmission from `AdminController::transmettre` and `ListeDemande::Transmetre`); both call the same `Demande` transition. The real layouts are `resources/views/Commun/Admin.blade.php` and `Commun/Client.blade.php`, not Jetstream's `layouts/app`.

### Authorization
All staff routes are inside the `auth:sanctum` + `verified` group and each one is guarded by a Gate (`->middleware('can:...')`) defined in `app/Providers/AuthServiceProvider.php`. The sidebar menu uses the same gates. Adding a page means: route + gate + menu entry.

Session lifetime: `FortifyServiceProvider` stores `remember_me` in the session at login, and `AdjustSessionLifetime` (web middleware group) sets 30 days or 24 h from it.

### Demande workflow
State is the `demandes.etat` column, cast to `App\Enums\EtatDemande` (`en_attente`, `transmise`, `suspendue`, `approuvee`; `libelle()` gives the French label shown everywhere). Only `Demande::transmettre()`, `suspendre()` and `approuver()` change it: they enforce the allowed transitions (en_attente/suspendue → transmise → suspendue or approuvee) and refuse any demande of a closed year, throwing `TransitionInterdite` whose message is shown as a toast. Never write `etat` directly.

| Step | Who | Method / write | Listed in |
|---|---|---|---|
| Submitted | secretaire (`/formulaire` → `ClientController::store`) | `etat` en_attente, `exercice` = creation year (model `creating` hook) | `ListeDemande` |
| Transmitted | secretaire | `transmettre()` (+ `date_transmission`) | `DemandeVerifier` |
| Suspended | verificateur | `suspendre($message)`; re-transmitting calls `transmettre()` | `DemandeSuspendu` |
| Approved | verificateur (`updateBudget`) | `approuver($montant, $date)`, amount ≤ `budget` | `DemandeApprouve` |
| Post-appui | verificateur/directeur | `rapport_depose`, effectifs H/F, disabled H/F, `observations_rapport`, `rapport_fichier`, `date_depot_rapport` | `PostAppui` |
| Archived | `DemandeApprouve::archiver` (page commented out, open question) | `archivee=true`, `annee_exercice` | `DemandeArchivee` |

Query scopes on `Demande`: `enCours()` (not closed), `cloturees()`, `etat(...)`, `allocations()` (approved), `recues()` (handed to verification: transmise, suspendue, approuvee; the dashboard and sections 1 of the statistics count these). Every live screen, statistic and export uses `enCours()`.

Columns: `budget`/`budget_accorde` are integer FCFA, `homme_touche` and `duree_activite` integers, `debut_activite`/`fin_activite` MySQL DATE left uncast (a Carbon cast would empty the `<input type="date">` fields of the edit form). `branche_id`, `corps_id`, `metier_id` are foreign keys (ON DELETE SET NULL) with `branche()`, `corps()`, `metier()` relations. `departement`, `commune`, `lieux` and `homme_touche` on `demandes` still duplicate the first `demande_localisations` row and are free strings without a foreign key: merging them is pending a business decision (the g12/g13/g16/g17 figures would change).

Migrating production (the 2026-10-22 to 2026-10-24 migrations rewrite data, and several `down()` refuse to run): 1) `mysqldump` the database; 2) `php artisan fda:audit-donnees` must report no anomaly (it reads the pre-rename column names too; the typing migration refuses to run otherwise); 3) `php artisan migrate`; 4) reference values that are empty, non-numeric or missing from their table become NULL and are logged as `orphelins-references` in `storage/logs`. On failure, restore the dump rather than retrying: a half-run migration does not resume.

Livewire actions have no gate of their own except the fiscal-year closing (`cloturer-exercice`); access control is the route gate of the page embedding the component, plus the scopes above. `PostAppui` is reachable by `directeur` too.

### Beneficiary indicators
Beneficiaries are the people trained, as declared in the post-appui report, not the applicant. `App\Services\StatistiquesBeneficiaires` computes them (by branche / service, sex rate, disability rate, report coverage) over open allocations. Reports saved before the disability fields existed have NULL there and are excluded from the disability rate. Its `allocations()` always adds `whereNull('cloturee_le')`, so pointing it at `Demande::cloturees()` returns nothing: past years need that filter lifted first. Per allocation, `RapportAllocationController` serves a PDF fiche and the uploaded report, stored on the private `local` disk under `rapports/` and served only from that prefix.

### Fiscal years and closing
`demandes.exercice` is the fiscal year; `cloturee_le` / `cloturee_par` mark a closed demande. `App\Services\ClotureExercice::cloturer($annee, $user)` closes the open approved allocations of that year and moves every other open demande of the year to `$annee + 1` (one transaction, no raw SQL); `apercu()` gives the counts shown before confirming. Closed demandes stay in `demandes` (the former `demandes_clotures` copy was merged back, keeping original ids) and are read through `cloturees()` by `ExercicesClotures` and the `*_cloture` routes, which take the demande id.

### Files
Uploaded documents go to the `uploads` disk (`config/filesystems.php`), i.e. `public/uploads/piece/...`; `demandes.piece` stores the path relative to that disk.

## Gotchas

- Livewire `ServiveClient` is misspelled on purpose (its view and tag use that name).
- Migrations that convert data keep their own column lists instead of reading app constants: a later rename would otherwise break `migrate:fresh`, which every test run replays.
- Tests enable `preventAccessingMissingAttributes` for `Demande`: reading a column that does not exist throws instead of rendering empty.
- `Demande` uses `$guarded = []`; anything in a request array passed to `update()` is written.
- The only unauthenticated data routes are the read-only `/api/*` reference lists. Demande creation (`/demande/store`) requires the `view-formulaire` gate, and Fortify registration is disabled: staff accounts are created by hand.
- `resources/views/Client/contact.blade.php` posts to `route('contact.submit')`, whose route is commented out in `routes/web.php`.
- Livewire 2 forms that also upload a file: bind the other fields with `wire:model.lazy`, not `.defer`. The upload's re-render resets every unfocused deferred field to its server value, silently dropping what the user typed.
- `AdminController::updateDemande` writes `$request->except([...])`, so any column can be set through that form.
- Email notifications on submission are commented out; `ClientController` sends the contact mail to a hardcoded address.
