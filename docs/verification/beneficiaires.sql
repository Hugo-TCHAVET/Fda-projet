-- Contrôle indépendant de la section « 4. Bénéficiaires » de /statistiques.
-- Écrit sans réutiliser le code de l'application.
-- docker exec -i fda-mysql mysql -uroot -proot --default-character-set=utf8mb4 basefda < docs/verification/beneficiaires.sql

-- Couverture : allocations approuvées et rapports déposés
SELECT COUNT(*) AS allocations, SUM(rapport_depose = 1) AS rapports
FROM demandes WHERE valide = '2';

-- Sexe
SELECT SUM(effectif_homme_forme) AS hommes,
       SUM(effectif_femme_forme) AS femmes,
       ROUND(100 * SUM(effectif_homme_forme) / SUM(effectif_homme_forme + effectif_femme_forme), 1) AS taux_hommes,
       ROUND(100 * SUM(effectif_femme_forme) / SUM(effectif_homme_forme + effectif_femme_forme), 1) AS taux_femmes
FROM demandes WHERE valide = '2' AND rapport_depose = 1;

-- Handicap : seuls les rapports où la donnée est saisie
SELECT SUM(effectif_handicape_homme + effectif_handicape_femme) AS handicapes,
       SUM(effectif_homme_forme + effectif_femme_forme) AS total_renseigne,
       ROUND(100 * SUM(effectif_handicape_homme + effectif_handicape_femme) / SUM(effectif_homme_forme + effectif_femme_forme), 1) AS taux_handicapes
FROM demandes WHERE valide = '2' AND rapport_depose = 1 AND effectif_handicape_homme IS NOT NULL;

SELECT COUNT(*) AS rapports_non_renseignes
FROM demandes WHERE valide = '2' AND rapport_depose = 1 AND effectif_handicape_homme IS NULL;

-- Par branche
SELECT COALESCE(b.nom, IF(d.branche IS NULL, 'Non renseigné', 'Branche inconnue')) AS branche,
       COUNT(*) AS allocations, SUM(d.rapport_depose = 1) AS rapports,
       SUM(IF(d.rapport_depose = 1, d.effectif_homme_forme, 0)) AS hommes,
       SUM(IF(d.rapport_depose = 1, d.effectif_femme_forme, 0)) AS femmes
FROM demandes d LEFT JOIN braches b ON b.id = d.branche
WHERE d.valide = '2'
GROUP BY 1;

-- Par service
SELECT service, COUNT(*) AS allocations,
       SUM(IF(rapport_depose = 1, effectif_homme_forme, 0)) AS hommes,
       SUM(IF(rapport_depose = 1, effectif_femme_forme, 0)) AS femmes
FROM demandes WHERE valide = '2'
GROUP BY service;
