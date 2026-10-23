# Dettes techniques de l'application FDA

Registre établi le 2026-10-21. Chaque ligne a un identifiant, repris dans les plans de `docs/superpowers/plans/`. Le programme d'ensemble est décrit dans [la feuille de route](superpowers/plans/2026-10-21-feuille-de-route-corrections.md).

Statuts : **ouvert**, **en cours**, **réglé**, **action manuelle** (à faire hors du code).

## 1. Accès et sécurité

Aujourd'hui, des portes sont ouvertes au public. Objectif : seul le personnel accède à l'espace admin, et chaque action passe par le bon rôle.

| Id | Aujourd'hui | Objectif | Gravité | Plan | Statut |
|---|---|---|---|---|---|
| S9 | Un inconnu crée un compte sur `/register` et voit le tableau de bord et ses montants (vérifié) | Inscription fermée, tableau de bord réservé au personnel | Haute | Sécurité, Task 9 | réglé (branche chantier/remise-a-niveau) |
| S1 | Un inconnu lit et modifie n'importe quelle demande (IFU, contact) en changeant un numéro dans l'adresse (vérifié) | Pages publiques supprimées | Haute | Sécurité, Task 3 | réglé (branche chantier/remise-a-niveau) |
| S2 | Un inconnu peut créer des demandes (vérifié) | Création réservée à la secrétaire | Haute | Sécurité, Task 4 | réglé (branche chantier/remise-a-niveau) |
| S4 | Une secrétaire peut, en bricolant une requête, se mettre une demande « approuvée » avec un montant | Seuls les champs du formulaire sont enregistrés ; seul le vérificateur approuve | Haute | Sécurité, Task 6 | réglé (branche chantier/remise-a-niveau) |
| S7 | Les 6 comptes du personnel ont le même mot de passe, écrit dans le code | Chaque compte a le sien ; plus de mot de passe dans le code | Haute | Changement en production + Sécurité, Task 8 | code réglé ; changement des mots de passe en production à faire |
| S8 | Lancer les tests peut effacer une vraie base | Les tests refusent toute base dont le nom ne finit pas par `_test` | Haute | Sécurité, Task 1 | réglé (branche chantier/remise-a-niveau) |
| S3 | Une demande peut être supprimée par un simple lien (session connectée requise) | Suppression par formulaire (DELETE avec jeton CSRF), réservée au rôle qui gère les demandes | Moyenne | Sécurité, Task 5 | réglé (branche chantier/remise-a-niveau) |
| S5 | Le post-appui accepte une demande non approuvée si la requête est modifiée | Limité aux allocations approuvées | Basse | Sécurité, Task 7 | réglé (branche chantier/remise-a-niveau) |
| S6 | Un fichier de rapport peut rester orphelin si l'enregistrement échoue | Fichier supprimé en cas d'échec | Basse | Sécurité, Task 7 | réglé (branche chantier/remise-a-niveau) |

| S10 | `GET /transmettre_demande/{id}` change l'état d'une demande : un lien piégé ouvert par une secrétaire connectée transmet la demande | Transmission par formulaire (POST avec jeton CSRF) | Moyenne | reliquat du travail 1 | réglé (branche chantier/remise-a-niveau) |
| S11 | Un compte au rôle `client` connecté arrive sur une page 403 sans déconnexion, et le bouton de retour boucle | Bouton de déconnexion sur la page 403 | Basse | reliquat du travail 1 | réglé (branche chantier/remise-a-niveau) |
| S12 | Un identifiant non numérique injecté dans le post-appui provoque une erreur 500 au lieu d'un message | Message « Demande introuvable » | Basse | reliquat du travail 1 | réglé (branche chantier/remise-a-niveau) || S15 | Le bouton « Clôturer exercice » n'était caché que dans la vue (adresse codée en dur) et l'action serveur ne vérifiait rien | Permission `cloturer-exercice` vérifiée côté serveur, même compte qu'avant ; qui doit pouvoir clôturer reste à décider (Q4) | Moyenne | trouvé pendant le plan État | réglé, règle à confirmer |
| S13 | Télécharger la pièce jointe d'une demande qui n'en a pas provoque une erreur 500 | Message « Le fichier demandé n'existe pas » | Basse | trouvé pendant le nettoyage | réglé (branche chantier/remise-a-niveau) |
| S14 | Chaque téléchargement de fiche PDF de demande provoque une erreur serveur (le PDF arrive quand même) | Réponse PDF propre | Basse | trouvé pendant le nettoyage | réglé (branche chantier/remise-a-niveau) |

## 2. Chiffres présentés aux directeurs

Aujourd'hui, certains chiffres sont faux ou incohérents entre eux. Objectif : chaque demande comptée une fois, avec une seule définition d'« approuvé ».

| Id | Aujourd'hui | Objectif | Gravité | Plan | Statut |
|---|---|---|---|---|---|
| E1 | Le tableau de bord affiche « Total 2 », alors que ses lignes font 3 (demande comptée deux fois) | Chaque demande comptée une seule fois | Moyenne | État et exercices, Task 5 | réglé (branche chantier/remise-a-niveau) |
| E4 | Les sections des statistiques n'ont pas la même définition d'« approuvé » | Une seule définition partout | Basse | État et exercices, Task 5 | réglé (branche chantier/remise-a-niveau) |
| E3 | La clôture d'exercice efface aussi les demandes en attente | Les allocations approuvées sont clôturées ; les autres demandes sont reportées sur l'exercice suivant | Moyenne | État et exercices, Task 4 | réglé (branche chantier/remise-a-niveau) |
| A3 | Les graphiques g6, g16 et g17 mélangent des demandes non approuvées | Ils ne comptent que les approuvées | Basse | Affichage, Task 2 | réglé (branche chantier/remise-a-niveau) |
| Q6 | « Archiver » cache une demande approuvée, et aucune page ne montre les archives | À décider : rétablir la page, supprimer l'archivage, ou le garder | Moyenne | État et exercices | décision attendue |

## 3. Base de données

Ça ne se voit pas à l'écran, mais c'est la cause de plusieurs bugs ci-dessus.

| Id | Aujourd'hui | Objectif | Gravité | Plan | Statut |
|---|---|---|---|---|---|
| E2 | L'état d'une demande est réparti sur 6 colonnes qui peuvent se contredire | Une seule colonne d'état, et des transitions contrôlées | Moyenne | État et exercices | réglé (branche chantier/remise-a-niveau) |
| E5 | La clôture copie les dossiers dans une table jumelle, à maintenir colonne par colonne | Une seule table, avec un exercice et une date de clôture | Moyenne | État et exercices, Task 3 | réglé (branche chantier/remise-a-niveau) |
| D1 | Une installation neuve ne reproduit pas la base de production (27 colonnes, `femme_touche`) | Les migrations produisent le schéma de production | Moyenne | Sécurité, Task 2 | réglé (branche chantier/remise-a-niveau) |
| N2 | Montants, effectifs et dates stockés en texte | Vrais nombres et vraies dates | Moyenne | Qualité des données, Tasks 1 et 2 | réglé (branche chantier/remise-a-niveau) |
| N3 | Aucune clé étrangère vers les tables de référence (les « 7 dossiers orphelins » étaient des valeurs vides) | Liens contrôlés par la base | Moyenne | Qualité des données, Task 3 | réglé pour branche, corps, métier ; département et commune attendent N4 |
| N4 | Le lieu et les effectifs prévus sont enregistrés à deux endroits | Un seul endroit : les localisations | Moyenne | Qualité des données, Task 4 | ouvert : décision métier (les chiffres g12, g13, g16, g17 changent) |
| N5 | Noms mal orthographiés (`braches`, `buget_prevu`, `obejectif_activite`, `dure_activite`) | Noms corrigés | Basse | Qualité des données, Task 5 | réglé (branche chantier/remise-a-niveau) |
| R1 | Les rôles ne sont pas attribués sur une base neuve | Comptes et rôles cohérents | Basse | Comptes et rôles | décision attendue (Q4) |

## 4. Socle technique

| Id | Aujourd'hui | Objectif | Gravité | Plan | Statut |
|---|---|---|---|---|---|
| V1 | Laravel 9, sans correctif de sécurité depuis 2024 | Laravel 13 (maintenu jusqu'en 2028), ou 12 si le serveur reste en PHP 8.2 | Haute | Montée de version | ouvert |
| V2 | Livewire 2, Jetstream 3, PHPUnit 9, PHP ^8.0 | Livewire 3 (4 si possible), Jetstream 5, PHPUnit 12, PHP 8.3 | Moyenne | Montée de version | ouvert |
| N1 | Du code que rien n'utilise : une dizaine de composants, des pages sans route, l'ancienne authentification | Supprimé avant la montée de version | Basse | Nettoyage | réglé (branche chantier/remise-a-niveau) |
| A1 | Scripts chargés en chemin relatif. Ils se chargent aujourd'hui grâce à une balise `<base>` ajoutée page par page (première analyse erronée : pas de 404 dans le navigateur) ; une nouvelle page sans cette balise casserait | Chemins absolus | Basse | Affichage, Task 1 | réglé (branche chantier/remise-a-niveau) |
| A2 | Code de démonstration du template : erreurs JavaScript sur chaque page | Retiré | Basse | Affichage, Task 1 | réglé (branche chantier/remise-a-niveau) |
| C1 | La page `/contact` plante, et le message part vers une adresse Gmail codée en dur | À décider : garder (avec quelle adresse) ou retirer | Moyenne | Page contact | décision attendue (Q5) |
| O1 | Limite d'envoi de 2 Mo en local, alors que le formulaire annonce 10 Mo | Serveur réglé à 12 Mo minimum | Basse | Montée de version, palier 8 | à vérifier en production |

## 5. Constats des revues, non traités

| Id | Aujourd'hui | Objectif | Gravité | Plan | Statut |
|---|---|---|---|---|---|
| R1 | « Montant appuyé » des exercices clôturés additionne le montant accordé de tous les dossiers clôturés (2025 : 59 745 344), pas seulement des allocations approuvées (43 167 092) | Seules les allocations approuvées | Moyenne | à planifier | ouvert |
| R2 | Les 52 anciens dossiers clôturés non approuvés restent figés, alors que la règle de clôture reporte les non approuvés | À décider : les reporter ou les laisser | Basse | à décider | décision attendue |
| R3 | Le droit de clôturer attend `sese@apps.fda.bj`, absent de la base (seul `sese@gmail.com` existe) : personne ne peut clôturer | Règle fixée avec le métier | Haute | Rôles | décision attendue (Q4) |
| R4 | `users.two_factor_confirmed_at` absent : la confirmation de la double authentification Jetstream ne peut pas fonctionner | Colonne ajoutée ou fonction désactivée | Basse | Montée de version | ouvert |
| R6 | Un texte de plus de 255 caractères (objectif, titre, lieu…) : erreur 500 en modification, formulaire vidé sans message en création | Limite `max:255` dans la validation, ou colonnes `text` | Moyenne | à planifier | ouvert |
| R7 | Modifier un lieu sans rechoisir la commune : erreur 500, et les lieux de la demande sont déjà effacés (pas de transaction) | Commune obligatoire avec le département, écriture en transaction | Moyenne | à planifier | ouvert |
| R8 | Le catch générique de la création renvoie `toast.error`, clé jamais affichée, sans `withInput()` : l'utilisateur perd sa saisie sans message | Message visible et saisie conservée | Moyenne | à planifier | ouvert |
| R9 | Un dossier approuvé reste modifiable ou supprimable par URL (seule la vue masque les boutons) ; la secrétaire peut lire un dossier clôturé par son id | Garde côté serveur | Basse | à planifier | ouvert |
| R10 | Vocabulaire « rejet » (menu, titre de liste, export `demandes_rejetees.xlsx`) alors qu'une suspension est une mise en attente | Libellés « suspendue » | Basse | session design ou nettoyage | ouvert |
| R11 | « Total Demandes » du tableau de bord compte les demandes reçues (transmises, suspendues, approuvées), pas celles en attente | Libellé « Demandes reçues » | Basse | session design | ouvert |
| R5 | Restes de modale : `wire:submit="updateBudget"` sans méthode, `confirmerRejet` défini deux fois dans la fiche, règles `budget_accorde` inutilisées dans deux composants | Supprimés | Basse | Nettoyage | ouvert |

## Hors registre : session design

À décider ensemble, lors d'une session dédiée : framework CSS unique (trois sont mélangés aujourd'hui), abandon du template Now UI (2018), mise en page du tableau de bord (bandeau vide, cartes peu remplies, chiffres sans contexte), page profil.
