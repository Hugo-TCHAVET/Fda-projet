# Programme de remise à niveau

Ce document recense tous les points ouverts relevés le 2026-10-21, les décisions prises et l'ordre d'exécution. L'ensemble est exécuté en une fois, dans un worktree, plan après plan. La refonte du design fera l'objet d'une session à part, menée avec l'utilisateur.

## Cadre d'exécution

- **Worktree :** branche `chantier/remise-a-niveau`, créée depuis `master` avec `superpowers:using-git-worktrees`.
- **Bases de données propres au worktree :** `basefda_wt` (copie de `basefda.sql`) et `basefda_wt_test`, dans le conteneur `fda-mysql`. La base `basefda` de master n'est jamais touchée.
- **Un commit par tâche.** `regression-reviewer` après chaque tâche, et une relecture complète par un relecteur indépendant à la fin de chaque plan.
- **`impact-analyzer` avant de toucher un schéma ou un contrat partagé :** plan 1 Task 2, tout le plan 4, tout le plan 5.
- **Règle des tests entre plans :** une tâche qui supprime ou renomme une colonne ou une table met à jour, dans le même commit, chaque test qui la touche. Les tests de migration de données sont marqués « transitoires », et la tâche qui les supprime est nommée.
- **Migrations de données :** chaque conversion est une classe appelable, testée en insérant des lignes puis en l'appelant. Avec `RefreshDatabase`, la migration a déjà tourné sur une base vide quand le test commence, donc on ne teste pas « après la migration ». La preuve durable est le comptage avant/après sur `basefda_wt`, noté dans le journal.
- **Avant la PR finale :** `/codebase-design`, puis `/zero-tech-debt`, puis un bilan, puis le go de l'utilisateur.

## Mise en route du worktree

1. Commiter sur `master` les plans, la feuille de route, le guide et les captures (`docs/`), sinon le worktree ne les contient pas.
2. Créer le worktree (`superpowers:using-git-worktrees`), puis y lancer `composer install` et `npm install`.
3. Copier `.env` et `.env.testing` (ignorés par git, donc absents du worktree) : `DB_DATABASE=basefda_wt`, `DB_DATABASE=basefda_wt_test` pour les tests, `APP_URL=http://127.0.0.1:8001`.
4. Créer `basefda_wt` et `basefda_wt_test`, importer `basefda.sql` dans `basefda_wt`, puis `php artisan migrate` (le dump précède la migration du 2026-10-21).
5. Créer `storage/app/rapports`.
6. Serveurs sur d'autres ports que ceux de master : `php artisan serve --port=8001` et Vite sur 5174.
7. `php artisan test` : la référence de départ (54 réussis, 3 ignorés) est notée dans le journal.

## Ordre des plans

| Ordre | Plan | Durée estimée | Prérequis |
|---|---|---|---|
| 1 | [Sécurité, garde-fous et schéma aligné](2026-10-21-securite-et-schema.md) | 6 à 8 h | aucun |
| 2 | [Correctifs d'affichage](2026-10-21-correctifs-affichage.md) | 2 à 3 h | 1 |
| 3 | [Nettoyage du code mort](2026-10-21-nettoyage-code-mort.md) | 2 à 3 h | 2 |
| 4 | [État unique des demandes et exercices](2026-10-21-etat-et-exercices.md) | 10 à 14 h | 3, et Q6 pour la page d'archives |
| 5 | [Qualité des données](2026-10-21-qualite-des-donnees.md) | 8 à 12 h | 4 |
| 6 | [Montée de version](2026-10-21-montee-de-version.md) | 2 à 4 jours | 5, et la version PHP de production |
| 7 | Comptes et rôles | 1 h | Q4 |
| 8 | Page contact | 0,5 h | Q5 |

**Total estimé : 7 à 10 jours de travail.** Le plan 6 est le moins prévisible : il dépend de ce que révèlent les guides officiels à chaque palier.

**Pourquoi cet ordre :**
- La sécurité passe d'abord, parce que les failles sont ouvertes au public aujourd'hui.
- Le nettoyage précède les refontes : retravailler ou migrer du code mort est du travail perdu.
- L'état et les données sont refaits avant la montée de version : on ne migre pas deux fois les mêmes écrans.

## Décisions prises (2026-10-21)

| Sujet | Décision |
|---|---|
| Référence du schéma de production | `basefda.sql` est un export fidèle de la production (H1 confirmée) |
| Suspension | Mise en attente temporaire ; la demande peut être retransmise. Pas d'état « rejetée » tant qu'aucune action de rejet n'existe |
| Clôture d'exercice | Seules les allocations approuvées sont clôturées ; les autres demandes sont reportées sur l'exercice suivant |
| Cible technique | Laravel 13 et Livewire 3 (Livewire 4 si Jetstream le permet). Laravel 12 si la production reste en PHP 8.2 |
| Hors programme | Framework CSS unique, abandon du template Now UI, mise en page du tableau de bord, page profil : session design |

## Tous les points ouverts

| Id | Point | Gravité | Plan |
|---|---|---|---|
| S1 | Voir et modifier n'importe quelle demande sans connexion. Testé : 200 sans connexion | Haute | 1 (Task 3) |
| S2 | Créer une demande sans connexion. Testé : la validation s'exécute pour un visiteur anonyme | Haute | 1 (Task 4) |
| S9 | Inscription publique ouverte : un visiteur crée un compte et voit le tableau de bord et ses montants. Testé | Haute | 1 (Task 9) |
| S4 | `updateDemande` écrit n'importe quelle colonne : une secrétaire peut s'approuver un montant | Haute | 1 (Task 6) |
| S7 | Le même mot de passe initial pour tous les comptes, écrit dans une migration. Le vrai correctif est de changer les 6 mots de passe en production | Haute (action manuelle) | Action immédiate + 1 (Task 8) |
| S8 | Les tests peuvent effacer une vraie base si `.env.testing` manque | Haute | 1 (Task 1) |
| S3 | Suppression par lien GET (session connectée requise) | Moyenne | 1 (Task 5) |
| S5 | Le post-appui accepte une demande non approuvée (requête modifiée par un utilisateur autorisé) | Basse | 1 (Task 7) |
| S6 | Fichier orphelin si l'enregistrement du rapport échoue | Basse | 1 (Task 7) |
| D1 | Les migrations ne reproduisent pas le schéma de production (27 colonnes, `femme_touche`) | Moyenne | 1 (Task 2) |
| A1 | Scripts du layout en chemin relatif : pas de 404 aujourd'hui grâce aux balises `<base>` des pages imbriquées, mais fragile (premier diagnostic erroné) | Basse | 2 (Task 1) |
| A2 | Code de démonstration du template : erreurs JavaScript sur chaque page | Basse | 2 (Task 1) |
| A3 | g6, g16 et g17 mélangent des demandes non approuvées | Basse | 2 (Task 2) |
| N1 | Code mort : une dizaine de composants Livewire, statistiques publiques sans route, authentification de laravel/ui, restes du template | Basse | 3 |
| E1 | Le tableau de bord compte la demande 115 deux fois | Moyenne | 4 (Task 5) |
| E2 | Six colonnes pour l'état d'une demande | Moyenne | 4 |
| E3 | La clôture supprime aussi les demandes en attente | Moyenne | 4 (Task 4) |
| E4 | Deux définitions d'« approuvé » selon les sections des statistiques | Basse | 4 (Task 5) |
| E5 | La clôture copie les dossiers dans une table jumelle, qu'il faut maintenir colonne par colonne | Moyenne | 4 (Task 3) |
| Q6 | Le bouton « Archiver » cache une demande approuvée, et aucune page ne montre les archives (page commentée) | Moyenne | 4, selon Q6 |
| N2 | Montants, effectifs et dates stockés en texte | Moyenne | 5 (Tasks 1 et 2) |
| N3 | Aucune clé étrangère vers les tables de référence ; 7 dossiers pointent vers une branche disparue | Moyenne | 5 (Task 3) |
| N4 | Lieu et effectifs prévus en double (`demandes` et `demande_localisations`) | Moyenne | 5 (Task 4) |
| N5 | Noms mal orthographiés (`braches`, `buget_prevu`, `obejectif_activite`, `dure_activite`) | Basse | 5 (Task 5) |
| V1 | Laravel 9, sans correctif de sécurité depuis 2024 | Haute | 6 |
| V2 | Livewire 2, Jetstream 3, PHPUnit 9, PHP ^8.0 | Moyenne | 6 |
| R1 | Rôles non attribués sur une base neuve (adresses différentes entre migration, seeder et dump) | Basse | 7 |
| C1 | `/contact` plante, et le message part vers une adresse Gmail codée en dur | Moyenne | 8 |
| O1 | Limite d'envoi PHP de 2 Mo en local, alors que le formulaire annonce 10 Mo | Basse | 6 (palier 8, vérification du serveur) |

## À faire tout de suite, hors programme

- Changer les mots de passe des 6 comptes du personnel en production (S7).
- Après le plan 1, examiner puis supprimer en production les comptes `role = 'client'` créés par l'inscription publique (S9).

## Questions encore ouvertes

- **Q4.** Quelles sont les adresses réelles des comptes du personnel : `@apps.fda.bj` (seeder) ou `@gmail.com` (migration et dump) ? Et qui est la secrétaire en production ?
- **Q5.** Faut-il garder le formulaire de contact public ? Si oui, vers quelle adresse officielle de la FDA ?
- **Q6.** Faut-il garder l'archivage d'une demande approuvée ? Trois options : rétablir la page des archives, le supprimer au profit de la clôture d'exercice, ou le garder tel quel.
- **PHP.** Quelle version de PHP tourne sur le serveur de production ? Elle bloque le plan 6, pas les plans 1 à 5.

Les plans 1 à 3 peuvent démarrer sans les réponses à Q4, Q5 et Q6.
