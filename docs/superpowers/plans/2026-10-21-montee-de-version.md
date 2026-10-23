# Montée de version (Laravel 9 vers 13, Livewire 2 vers 3) : plan d'implémentation

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Ramener l'application sur des versions maintenues : Laravel 13 (PHP 8.3), Livewire 3, Jetstream 5 et PHPUnit 12, une version majeure à la fois, la suite restant verte à chaque palier.

**Architecture:** Une montée par palier, chacun dans son propre commit : 9 → 10 → 11 → 12 → 13 pour Laravel, et 2 → 3 pour Livewire, au palier Laravel 10. On garde la structure de dossiers actuelle (`app/Http/Kernel.php`) : Laravel 11 et suivants l'acceptent, et la migration vers le squelette allégé n'est pas nécessaire. Chaque palier suit le guide officiel de la version, consulté via Context7 au moment de l'exécution.

**Tech Stack:** Laravel 9 → 13, Livewire 2 → 3, Jetstream 3 → 5, PHPUnit 9 → 12, PHP 8.3.

**Spec:** diagnostic de la pile du 2026-10-21. Cibles vérifiées le 2026-10-21 : Laravel 13 exige PHP 8.3 ; Livewire 4 exige Laravel 10 et PHP 8.1 ; Jetstream 5.5 fonctionne avec Laravel 13 et Livewire 3, et sa compatibilité avec Livewire 4 n'est pas établie.

## Global Constraints

- **Prérequis bloquant :** connaître la version de PHP du serveur de production. Si elle est inférieure à 8.3 et ne peut pas être montée, la cible devient Laravel 12 (PHP 8.2) et le palier 6 est retiré.
- Prérequis : les plans « Sécurité », « Affichage », « Nettoyage », « État et exercices » et « Qualité des données » sont terminés. On ne monte pas de version du code mort.
- Un palier n'est terminé que si : `php artisan test` est vert, `PagesTest` compris ; le contrôle navigateur du palier est fait ; aucune dépréciation n'apparaît dans `storage/logs`.
- Livewire 4 : seulement si `composer why-not livewire/livewire ^4.0` ne signale aucun blocage venant de Jetstream. Sinon, on reste en Livewire 3 et le sujet passe à la session design, qui redessinera la page profil.
- Le framework CSS ne change pas ici : c'est l'objet de la session design.

## Contrôle navigateur (identique à chaque palier)

Base du worktree. En secrétaire : création d'une demande, puis transmission. En vérificateur : suspension, retransmission, approbation, rapport post-appui avec PDF (champs saisis puis fichier joint, le cas qui a déjà cassé une fois). En directeur : statistiques (section 4 et impression), fiche PDF, dossiers clôturés, export Excel. Profil : changement de mot de passe. Console du navigateur sans erreur.

## Review Focus

1. **Formulaire post-appui avec envoi de fichier** : en Livewire 3, `wire:model` n'envoie plus rien avant la soumission par défaut (comportement de l'ancien `.defer`). Le bug de saisie perdue peut revenir. → palier 2, `test_rapport_complet_enregistre` + contrôle navigateur du scénario « chiffres puis fichier ».
2. **Alertes et événements** (`livewire-alert`, `dispatchBrowserEvent`, `$emit`) : les noms et les signatures changent en Livewire 3. → palier 2, `grep` à zéro + contrôle navigateur des toasts.
3. **Pagination des listes** (`WithPagination`, thème bootstrap). → palier 2, `PagesTest` avec plus de 10 demandes dans une liste.
4. **Jeton CSRF** : `VerifyCsrfToken` devient `PreventRequestForgery` en Laravel 13, avec vérification de l'origine. → palier 6, test de soumission de formulaire classique (budget) et Livewire.
5. **Double authentification et profil** (Jetstream 5) : activation, codes de récupération, changement de mot de passe. → les tests Jetstream existants, adaptés, à chaque palier.

---

### Palier 0 : Préparation

- [ ] Vérifier la version de PHP du serveur de production (question à l'utilisateur, ou `php -v` sur le serveur). Noter la cible définitive.
- [ ] `composer outdated --direct` et `npm outdated` : noter l'état de départ.
- [ ] Contraintes du `composer.json` : `"php": "^8.3"` (ou `^8.2` si cible 12).

### Palier 1 : Laravel 10 (PHP 8.1 min.), PHPUnit 10

- [ ] Appliquer le guide de mise à niveau 9.x → 10.x (Context7 `/laravel/docs/__branch__10.x`, page « upgrade »). Dépendances : `laravel/framework ^10`, `laravel/sanctum ^3.2`, `nunomaduro/collision ^7`, `phpunit/phpunit ^10`, `spatie/laravel-ignition ^2`, et `jetstream ^3` (compatible 10).
- [ ] `phpunit.xml` au format PHPUnit 10 (`vendor/bin/phpunit --migrate-configuration`).
- [ ] Suite verte, contrôle navigateur, commit.

### Palier 2 : Livewire 3 et Jetstream 4

- [ ] Appliquer le guide officiel de Livewire 3 (Context7 `/livewire/livewire`, « upgrading »). Points connus pour ce code :
  - `wire:model` devient différé par défaut : relire chaque formulaire ; `wire:model.lazy` devient `wire:model.blur` ; vérifier le formulaire post-appui avec fichier ;
  - `$emit` et `dispatchBrowserEvent` deviennent `$dispatch` ; `protected $listeners` ;
  - `@livewireScripts` charge Alpine lui-même : retirer l'import d'Alpine de `resources/js/app.js`, pour éviter deux instances ;
  - composants dans `app/Livewire` (déplacement optionnel : garder `app/Http/Livewire` via la configuration, pour limiter le diff) ;
  - `jantinnerezo/livewire-alert` dans la version qui supporte Livewire 3 ;
  - Jetstream 4 et la republication de ses vues de profil.
- [ ] `grep -rn "\$emit\|dispatchBrowserEvent\|wire:model.defer\|wire:model.lazy" app resources` → 0 résultat.
- [ ] Suite verte, contrôle navigateur (scénario « chiffres puis fichier » obligatoire), commit.

### Palier 3 : Laravel 11

- [ ] Guide 10.x → 11.x. Garder la structure actuelle (Kernel, providers). Dépendances : `laravel/framework ^11`, `laravel/sanctum ^4`, `jetstream ^5`, `nunomaduro/collision ^8`.
- [ ] Suite verte, contrôle navigateur, commit.

### Palier 4 : Laravel 12

- [ ] Guide 11.x → 12.x. Suite verte, contrôle navigateur, commit.

### Palier 5 : Paquets annexes

- [ ] `barryvdh/laravel-dompdf ^3` : vérifier la fiche de fin d'allocation et la fiche de demande (rendu comparé aux captures de `docs/verification/`).
- [ ] `maatwebsite/excel`, `realrashid/sweet-alert`, `laravel/tinker`, `laravel/pint`, `laravel/sail` : dernières versions compatibles.
- [ ] Front : `vite`, `laravel-vite-plugin` et `axios` en version courante ; `npm run build` sans erreur.
- [ ] Suite verte, contrôle navigateur, commit.

### Palier 6 : Laravel 13 (PHP 8.3), PHPUnit 12

- [ ] Guide 12.x → 13.x (Context7 `/laravel/docs/__branch__13.x`). Points connus : `VerifyCsrfToken` devient `PreventRequestForgery` ; `laravel/tinker ^3` ; `phpunit/phpunit ^12`.
- [ ] Nouveau test `test_formulaire_classique_accepte_avec_jeton` : la soumission du budget (`demande.prixbudget`) fonctionne avec la nouvelle protection.
- [ ] Suite verte, contrôle navigateur, commit.

### Palier 7 : Livewire 4 (conditionnel)

- [ ] `composer why-not livewire/livewire ^4.0`. Si Jetstream bloque : arrêter, noter dans le bilan, et laisser le sujet à la session design.
- [ ] Sinon : guide 3.x → 4.x (Context7 `/websites/livewire_laravel_4_x`). Points connus : `smart_wire_keys` passe à true par défaut ; `wire:model` sur un conteneur exige `.deep`.
- [ ] Suite verte, contrôle navigateur, commit.

### Palier 8 : Déploiement

- [ ] Vérifier sur le serveur : version de PHP, extensions (`pdo_mysql`, `mbstring`, `gd`, `zip`, `intl`, `fileinfo`), `upload_max_filesize` et `post_max_size` ≥ 12M, dossier `storage/app/rapports` accessible en écriture.
- [ ] Sauvegarde complète de la base de production avant `php artisan migrate --force`.
- [ ] Ordre de déploiement et retour arrière écrits dans `docs/deploiement.md`.
