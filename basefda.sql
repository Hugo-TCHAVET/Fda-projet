-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 27, 2025 at 11:38 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `basefda`
--

-- --------------------------------------------------------

--
-- Table structure for table `braches`
--

CREATE TABLE `braches` (
  `id` bigint UNSIGNED NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `braches`
--

INSERT INTO `braches` (`id`, `nom`, `created_at`, `updated_at`) VALUES
(2, 'Agro-alimentaire/ Alimentation/ Restauration', NULL, NULL),
(3, 'Mines et carrières/Construction et bâtiment', NULL, NULL),
(4, 'Métaux et constructions métalliques/ Mécanique/ Electromécanique/ Electronique/ Electricité et petites activités de transport', NULL, NULL),
(5, 'Bois et assimilés/Mobilier et ameublement\r\n', NULL, NULL),
(6, 'Textile/Habillement/Cuirs et peaux', NULL, NULL),
(7, 'Audiovisuel et communication', NULL, NULL),
(8, 'Hygiène et soins corporels', NULL, NULL),
(9, 'Artisanat d’art et décoration', NULL, NULL),
(10, 'Toutes branches confondues', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `communes`
--

CREATE TABLE `communes` (
  `id` bigint UNSIGNED NOT NULL,
  `departement_id` bigint UNSIGNED NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `communes`
--

INSERT INTO `communes` (`id`, `departement_id`, `nom`, `created_at`, `updated_at`) VALUES
(3, 7, 'Banikoara', NULL, NULL),
(4, 7, 'Gogounou', NULL, NULL),
(5, 1, 'Abomey-calavi', NULL, NULL),
(6, 1, 'Kpomassè', NULL, NULL),
(7, 1, 'Ouidah', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(8, 1, 'So-Ava', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(9, 1, 'Toffo', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(10, 1, 'Tori-Bossito', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(11, 1, 'Zè', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(12, 2, 'Athiémé', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(13, 2, 'Bopa', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(14, 2, 'Comè', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(15, 2, 'Grand-Popo', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(16, 2, 'Houéyogbé', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(17, 2, 'Lokossa', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(18, 3, 'Aplahoué', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(19, 3, 'Djakotomey', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(20, 3, 'Dogbo-Tota', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(21, 3, 'Klouékanmè', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(22, 3, 'Lalo', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(23, 3, 'Toviklin', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(24, 9, 'Bassila', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(25, 9, 'Copargo', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(26, 9, 'Djougou', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(27, 9, 'Ouaké', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(28, 12, 'Cotonou', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(29, 10, 'Adjarra', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(30, 10, 'Adjohoun', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(31, 10, 'Aguégués', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(32, 10, 'Akpro-Missérété', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(33, 10, 'Avrankou', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(34, 10, 'Bonou', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(35, 10, 'Dangbo', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(36, 10, 'Porto-Novo', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(37, 10, 'Sèmè-Kpodji', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(38, 11, 'Adja-Ouèrè', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(39, 11, 'Ifangni', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(40, 11, 'Kétou', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(41, 11, 'Pobè', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(42, 11, 'Sakété', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(43, 4, 'Abomey', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(44, 4, 'Agbangnizoun', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(45, 4, 'Bohicon', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(46, 4, 'Covè', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(47, 4, 'Djidja', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(48, 4, 'Ouinhi', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(49, 4, 'Zagnanado', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(50, 4, 'Za-Pota', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(51, 4, 'Zogbodomey', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(52, 5, 'Bantè', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(53, 5, 'Dassa-Zoumè', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(54, 5, 'Glazoué', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(55, 5, 'Ouèssè', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(56, 5, 'Savalou', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(57, 5, 'Savè', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(58, 6, 'Bembéréké', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(59, 6, 'Kalalé', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(60, 6, 'N’Dali', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(61, 6, 'Nikki', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(62, 6, 'Parakou', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(63, 6, 'Pèrèrè', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(64, 6, 'Sinendé', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(65, 6, 'Tchaourou', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(66, 7, 'Kandi', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(67, 7, 'Karimama', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(68, 7, 'Malanville', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(69, 7, 'Segbana', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(70, 8, 'Boukoumbé', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(71, 8, 'Cobly', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(72, 8, 'Kérou', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(73, 8, 'Kouandé', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(74, 8, 'Matéri', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(75, 8, 'Natitingou', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(76, 8, 'Péhunco', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(77, 8, 'Tanguiéta', '2024-02-29 21:19:28', '2024-02-29 21:19:28'),
(78, 8, 'Toucountouna', '2024-02-29 21:19:28', '2024-02-29 21:19:28');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `corps`
--

CREATE TABLE `corps` (
  `id` bigint UNSIGNED NOT NULL,
  `branche_id` bigint UNSIGNED NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `corps`
--

INSERT INTO `corps` (`id`, `branche_id`, `nom`, `created_at`, `updated_at`) VALUES
(6, 2, 'Transformation de produits laitiers et de glaces', NULL, NULL),
(7, 2, 'Fabrication de boissons', NULL, NULL),
(8, 2, 'Boulangerie-pâtisserie et pâtes alimentaires', NULL, NULL),
(9, 2, 'Restauration et fabrication d’autres produits alimentaires ', NULL, NULL),
(10, 2, 'Fabricants d’aliments pour animaux et d’engrais organiques', NULL, NULL),
(11, 3, 'Extraction de minerais non ferreux', NULL, NULL),
(12, 3, 'Extraction de produits de carrières et autres ', NULL, NULL),
(13, 3, 'Forage de puits d’eau et autres activités de forage', NULL, NULL),
(14, 3, 'Travail de la pierre ', NULL, NULL),
(15, 3, 'Fabrication de matériaux de construction en béton, en ciment, en plâtre et en terre cuite', NULL, NULL),
(16, 3, 'Construction et réhabilitation de bâtiments', NULL, NULL),
(17, 3, 'Construction et autres travaux de construction spécialisés', NULL, NULL),
(18, 3, 'Travaux de finition et autres travaux spécialisés', NULL, NULL),
(19, 4, 'Fabrication de machines et équipements d’usage général, spécifique et autres outils', NULL, NULL),
(20, 4, 'Constructeurs métalliques et ouvrage en acier, en métaux précieux et d’autres métaux non ferreux', NULL, NULL),
(21, 4, 'Réparation et mécanique d’automobiles, de motocycles et de cycles, de matériels de transport ferroviaire, roulant, naval et fluvial', NULL, NULL),
(22, 4, 'Petites activités de transport terrestre, fluvial et transport par conduites', NULL, NULL),
(23, 4, 'Installation, maintenance, entretien et réparation d’ordinateurs, de biens personnels et d’équipements domestiques', NULL, NULL),
(24, 4, 'Electricité, froid ', NULL, NULL),
(25, 5, 'Travail du bois (meubles et assimilés) ', NULL, NULL),
(26, 5, 'Travail sur végétaux', NULL, NULL),
(27, 6, 'Fabrication de fibres textiles, filature et tissage', NULL, NULL),
(28, 6, 'Fabrication de vêtements et d’autres textiles 29- Travaux sur cuir et peaux', NULL, NULL),
(29, 6, 'Travaux sur cuir et peaux', NULL, NULL),
(30, 7, 'Imagerie ', NULL, NULL),
(31, 7, 'Installation, maintenance, entretien et réparation de matériels optiques, photographiques et d’images', NULL, NULL),
(32, 8, 'Coiffures et tresses', NULL, NULL),
(33, 8, 'Fabrication de savons, de produits d’entretien et produits chimiques et cosmétiques ', NULL, NULL),
(34, 8, 'Travail d’esthétique et de produits de la pharmacopée', NULL, NULL),
(35, 8, 'Fabrication de prothèses et matériel orthopédique ', NULL, NULL),
(36, 8, 'Nettoyage et entretien', NULL, NULL),
(37, 9, 'Fabrication d’articles en joaillerie, bijouterie et articles similaires', NULL, NULL),
(38, 9, 'Fabrication d’art traditionnel et métiers de la création de pièces uniques ou de petites séries à tendance contemporaine ', NULL, NULL),
(39, 9, 'Fabrication et restauration du patrimoine', NULL, NULL),
(40, 9, 'Décoration', NULL, NULL),
(41, 2, 'Transformation et conservation de fruits, légumes, feuilles et noix', NULL, NULL),
(42, 2, 'Transformation des grains, des tubercules et produits amylacés', NULL, NULL),
(43, 2, 'Fabrication d’huiles, graisses végétales et animales', NULL, NULL),
(44, 2, 'Abattage, transformation et conservation de viande et préparation de produits à base de viande', NULL, NULL),
(45, 2, 'Transformation et conservation de produits à base de poissons et de produits de la pêche ', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `demandes`
--

CREATE TABLE `demandes` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `structure` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `service` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_demande` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branche` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `corps` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sexe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ifu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `titre_activite` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `obejectif_activite` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `debut_activite` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fin_activite` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dure_activite` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `departement` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commune` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lieux` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `homme_touche` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `budget` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `piece` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `buget_prevu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `rapport_depose` tinyint(1) DEFAULT '0',
  `effectif_homme_forme` int DEFAULT NULL,
  `effectif_femme_forme` int DEFAULT NULL,
  `date_depot_rapport` datetime DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'En attente',
  `statut` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statuts` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valide` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `suspendre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `rejeter` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `archivee` tinyint(1) DEFAULT '0',
  `annee_exercice` int DEFAULT NULL,
  `date_archivage` datetime DEFAULT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_transmission` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `date_approbation` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `demandes`
--

INSERT INTO `demandes` (`id`, `code`, `structure`, `service`, `type_demande`, `branche`, `corps`, `metier`, `nom`, `prenom`, `sexe`, `ifu`, `contact`, `titre_activite`, `obejectif_activite`, `debut_activite`, `fin_activite`, `dure_activite`, `departement`, `commune`, `lieux`, `homme_touche`, `budget`, `piece`, `buget_prevu`, `rapport_depose`, `effectif_homme_forme`, `effectif_femme_forme`, `date_depot_rapport`, `status`, `statut`, `statuts`, `valide`, `suspendre`, `rejeter`, `archivee`, `annee_exercice`, `date_archivage`, `message`, `date_transmission`, `created_at`, `updated_at`, `date_approbation`) VALUES
(115, 'L64-ZPEP-UPMQ-TMWF', 'Sauer, Lueilwitz and O\'Connell', 'Assistance', 'professionnel', '4', '19', '173', 'Gutkowski', 'Franz', 'Masculin', '57967544960988', '380.305.5711', 'Explicabo et est distinctio sed.', 'Eos reprehenderit qui fugit iusto neque quae. Voluptas esse molestiae necessitatibus et sed maiores consequuntur nihil. Facere non iure consequuntur assumenda aspernatur reiciendis perferendis.', '2025-12-12', '2026-02-16', '66', '6', '59', '81684 Jody Cove Suite 391', '115', '1842976', NULL, '1500000', 1, 100, 250, '2025-11-27 07:48:12', 'En attente', 'Suspendus', 'Approuvé', '2', '1', '0', 0, NULL, NULL, NULL, '2025-11-27 05:11:48', '2025-11-20 14:09:38', '2025-11-27 06:48:12', '2025-11-27 07:04:05'),
(117, 'C33-UJZF-KBPJ-AGDB', 'Hartmann, Ruecker and Maggio', 'Formation', 'professionnel', '10', NULL, NULL, 'Turner', 'Thora', 'Féminin', '26075691041490', '+1-910-785-9099', 'Tempore voluptatem odio voluptatum minima.', 'Voluptate numquam reprehenderit voluptatem dolorem culpa ipsa. Et ipsam perferendis ratione ut voluptas beatae. Voluptatibus ut id rerum.', '2025-12-11', '2026-01-21', '40', '9', '25', '649 Bauch Courts', '32', '4858332', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '0', '0', '0', 0, NULL, NULL, NULL, NULL, '2025-06-07 06:41:37', '2025-06-07 06:41:37', NULL),
(118, 'E38-GIBD-OMZU-HFAM', 'Wiegand, Oberbrunner and Stokes', 'Formation', 'professionnel', '6', '29', '228', 'Kris', 'Monica', 'Masculin', '75447584334269', '1-801-316-6843', 'Est vel vitae culpa et.', 'Aut et tempora deserunt minus rem ex. Velit cumque unde perspiciatis quae.', '2025-11-30', '2026-01-21', '52', '1', '11', '8177 Wisozk Club', '43', '803829', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '0', '0', '0', 0, NULL, NULL, NULL, NULL, '2025-04-18 04:20:45', '2025-04-18 04:20:45', NULL),
(119, 'U02-QNHB-NRLS-MAKP', 'Dickinson, Fahey and Bartoletti', 'Formation', 'professionnel', '4', '22', '177', 'Gleason', 'Matteo', 'Masculin', '81971082982036', '1-678-333-4799', 'Quo ut dolorum nihil.', 'Necessitatibus et accusamus rerum provident quo. Quidem et culpa excepturi qui.', '2025-12-02', '2025-12-03', '0', '10', '31', '3248 Pfeffer Valley', '155', '768892', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', 'En cours de traitement', NULL, '1', '0', '0', 0, NULL, NULL, NULL, '2025-11-27 10:13:57', '2025-05-30 04:23:13', '2025-11-27 10:13:57', NULL),
(120, 'F38-EKVO-SESL-HKQI', 'BOOBA AND CO', 'Assistance', 'ONG', NULL, NULL, NULL, 'Elie', 'Yaffah', 'Masculin', '1215444354554', '0162014598', 'Intitulé', 'Objectif', NULL, NULL, NULL, '', '', '', '0', '3000000', NULL, '0', 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '0', '0', '0', 0, NULL, NULL, NULL, NULL, '2025-11-27 07:53:42', '2025-11-27 08:56:43', NULL),
(121, 'I17-SVJI-WQGN-CJCS', 'Aigle royal et négoce internationale', 'Assistance', 'structure', '', '', '', 'GANLAKY', 'Fanzaëlle Chancia', 'Féminin', '1215444354554', NULL, 'Mise à jour', 'On controle', NULL, NULL, NULL, '', '', '', '0', '2000000', NULL, '0', 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '0', '0', '0', 0, NULL, NULL, NULL, NULL, '2025-11-27 10:17:45', '2025-11-27 10:17:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `demandes_clotures`
--

CREATE TABLE `demandes_clotures` (
  `id` bigint UNSIGNED NOT NULL,
  `demande_id_original` bigint UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `structure` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `service` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_demande` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branche` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `corps` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sexe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ifu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `titre_activite` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `obejectif_activite` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `debut_activite` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fin_activite` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dure_activite` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `departement` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commune` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lieux` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `homme_touche` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `budget` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `piece` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `buget_prevu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `rapport_depose` tinyint(1) DEFAULT '0',
  `effectif_homme_forme` int DEFAULT NULL,
  `effectif_femme_forme` int DEFAULT NULL,
  `date_depot_rapport` datetime DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'En attente',
  `statut` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statuts` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valide` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `suspendre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `rejeter` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `archivee` tinyint(1) DEFAULT '0',
  `annee_exercice` int DEFAULT NULL,
  `date_archivage` datetime DEFAULT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_transmission` timestamp NULL DEFAULT NULL,
  `date_approbation` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `annee_exercice_cloture` int NOT NULL,
  `date_cloture` datetime NOT NULL,
  `user_id_cloture` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `demandes_clotures`
--

INSERT INTO `demandes_clotures` (`id`, `demande_id_original`, `code`, `structure`, `service`, `type_demande`, `branche`, `corps`, `metier`, `nom`, `prenom`, `sexe`, `ifu`, `contact`, `titre_activite`, `obejectif_activite`, `debut_activite`, `fin_activite`, `dure_activite`, `departement`, `commune`, `lieux`, `homme_touche`, `budget`, `piece`, `buget_prevu`, `rapport_depose`, `effectif_homme_forme`, `effectif_femme_forme`, `date_depot_rapport`, `status`, `statut`, `statuts`, `valide`, `suspendre`, `rejeter`, `archivee`, `annee_exercice`, `date_archivage`, `message`, `date_transmission`, `date_approbation`, `created_at`, `updated_at`, `annee_exercice_cloture`, `date_cloture`, `user_id_cloture`) VALUES
(46, 1, 'G76-PEOK-XMPD-OZXL', 'ert', 'Assistance', 'professionnel', '2', '41', '300', 'ZERT', 'erty', 'Masculin', '1234565432123', '234567', 'ZERTY', 'ZERTY', '2025-11-19', '2025-11-20', '1', '4', '43', 'HOPITAL', '10', '1000000', 'piece/NgE32zeTqMLsxghYP5Eb3iFjPuSbX6GnbPkUZliP.pdf', '500000', 1, 100, 20, '2025-11-20 00:00:00', 'En attente', 'En cours de traitement', 'Approuvé', '2', '0', '0', 1, 2025, '2025-11-25 14:18:47', NULL, NULL, NULL, '2025-11-20 22:43:33', '2025-11-25 13:18:47', 2025, '2025-11-26 09:37:16', 1),
(47, 3, 'X81-YFAZ-POXW-KBDZ', 'n', 'Assistance', 'professionnel', '', '', '', 'n', 'n', 'Masculin', '1234', '2345', 'U', 'ERTY', '2025-11-21', '2025-11-23', '2', '10', '36', 'SALLE DES JEUNES', '5', '150000', 'piece/l7Pmgu9UJb9x6qJ7xPOmn6Ok3joxmfu8FH2mUjla.pdf', '10000', 0, NULL, NULL, NULL, 'En attente', 'En cours de traitement', 'Approuvé', '2', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2025-11-21 00:47:24', '2025-11-21 04:10:56', 2025, '2025-11-26 09:37:16', 1),
(48, 4, 'M93-FIJP-DESJ-BNFX', 'h', 'Assistance', 'professionnel', '', '', '', 'h', 'Hugo', 'Féminin', '1234321234568', '234567', 'H', 'H', '2025-11-21', '2025-11-23', '2', '5', '55', 'SALLE DES ENFANTS', '50', '3456', 'piece/Q4Ir1mptf0jxYrFwiD4nat2PKsjFaV84Db7AiU2W.pdf', '1000', 0, NULL, NULL, NULL, 'En attente', 'En cours de traitement', 'Approuvé', '2', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2025-11-21 01:12:29', '2025-11-20 11:07:06', 2025, '2025-11-26 09:37:16', 1),
(49, 5, 'L47-PWKO-IEUO-WVMK', 'h', 'Assistance', 'professionnel', '', '', '', 'sdfg', 'dfghj', 'Masculin', '1234321234568', '234567', 'ZER', 'TYU', '2025-11-13', '2025-11-20', '7', '8', '77', 'SALLE DES ENFANTS', '50', '250000', 'piece/5UHPZEcgXixt64lV8ODfrkRbtsJAtok1ARyRDzS4.pdf', '150000', 0, NULL, NULL, NULL, 'En attente', 'En cours de traitement', 'Approuvé', '2', '0', '0', 1, 2024, '2025-11-25 14:18:54', NULL, NULL, NULL, '2025-11-21 01:15:17', '2025-11-25 13:18:54', 2025, '2025-11-26 09:37:16', 1),
(50, 6, 'Z63-NAJU-AQBP-VSNY', 'ert', 'Assistance', 'structure', '', '', '', 'sdfg', 'dfghj', 'Masculin', '1234565432123', '234567', 'Mise à jour', 'Mise à jour de le plateforme', '2025-10-30', '2025-11-06', '7', '10', '33', 'SALLE DES ENFANTS', '50', '500000', 'piece/NaktdHr7F3odq1bnQgeOEXBQiymXl8CWKsP5JaZL.pdf', '10000', 0, NULL, NULL, NULL, 'En attente', 'En cours de traitement', 'Approuvé', '2', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2025-11-21 01:39:06', '2025-11-20 11:06:45', 2025, '2025-11-26 09:37:16', 1),
(51, 7, 'X52-YNIB-EZDF-KYSD', 'zert', 'Formation', 'professionnel', '8', '', '', 'yui', 'Fanzaëlle Chancia', 'Féminin', '0234321234568', '234567', 'Mise à jour', 'rtyu', '2025-10-30', '2025-11-06', '7', '7', '4', 'HOPITAL', '20', '500000', 'piece/iHLrtLfTxmJ3DWsYihSzSxx6wHaENnKoFx0T7z0I.pdf', '500000', 0, NULL, NULL, NULL, 'En attente', 'En cours de traitement', 'Approuvé', '2', '0', '0', 0, NULL, NULL, NULL, NULL, '2025-11-24 18:12:48', '2025-11-21 02:17:36', '2025-11-24 17:12:48', 2025, '2025-11-26 09:37:16', 1),
(52, 9, 'M09-FNTT-NNAR-TKAU', 'ASSIRI', 'Assistance', 'structure', '8', '35', '259', 'Anicet', 'Pancras Anicet', 'Masculin', '1200901979305', '2290162012345', 'Formation en élévage de poules pondeuses', 'Formation', '2025-12-15', '2025-12-25', '10', '1', '7', 'Djèbgadji', '60', '500000', 'piece/ImXRARY1zYywFQWgcllTxvSt5WplPPV0uABUBwtL.pdf', '500000', 0, NULL, NULL, NULL, 'En attente', 'En cours de traitement', 'Approuvé', '2', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2025-11-20 09:58:38', '2025-11-20 10:44:15', 2025, '2025-11-26 09:37:16', 1),
(53, 11, 'L26-PYJK-RGVT-PVFC', 'ASSIRI', 'Assistance', 'professionnel', '2', '41', '304', 'IZI', 'Net', 'Féminin', '2145786325875', '2290190996353', 'Formation', 'Formations', '2025-02-12', '2025-11-12', '273', '9', '24', 'Santiago', '100', '15000000', 'piece/PYj4CHe5y5d2BxrSiCdWtTZSA2T3xA1uQmtuSMlu.pdf', '0', 0, NULL, NULL, NULL, 'En attente', 'En cours de traitement', NULL, '1', '0', '0', 0, NULL, NULL, NULL, '2025-11-25 19:48:20', NULL, '2025-11-23 20:20:19', '2025-11-25 19:48:20', 2025, '2025-11-26 09:37:16', 1),
(54, 12, 'H62-ICAU-WCRH-TXHR', 'ASSIRI', 'Assistance', 'professionnel', '', '', '', 'ASSIRI', 'Services', 'Masculin', '1225654215848', '22901254887', 'Formation en élévage', 'kjdkfdns', '2025-02-15', '2025-03-30', '43', '10', '36', 'Missrété', '100', '1000000', 'piece/JPEjtrXNWvZRbYTVXusfBb3ABiKAa0nKPy9f68zD.pdf', '500000', 0, NULL, NULL, NULL, 'En attente', 'En cours de traitement', 'Approuvé', '2', '0', '0', 0, NULL, NULL, NULL, '2025-11-25 14:37:58', '2025-11-25 15:41:57', '2025-11-23 21:19:42', '2025-11-25 14:41:57', 2025, '2025-11-26 09:37:16', 1),
(55, 13, 'N94-BSIK-GLRV-PNFC', 'ASSIRI Services', 'Assistance', 'professionnel', '2', '', '', 'Thibault', 'Hack', 'Masculin', '1200901979305', '+2292968767789', 'Formation en élévage de poules pondeuses', 'Formation', '2025-03-22', '2025-04-21', '30', '1', '7', 'Djèbgadji', '100', '10000000', 'piece/S5zKkNfiZVMYfIHb9eWXcE6HQEpzC9mAmLoYM2us.pdf', '10000000', 0, NULL, NULL, NULL, 'En attente', 'En cours de traitement', 'Approuvé', '2', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2025-11-24 09:24:55', '2025-11-24 16:04:17', 2025, '2025-11-26 09:37:16', 1),
(56, 14, 'N85-WVCY-WPTU-GBQR', 'ASSIRI', 'Formation', 'professionnel', '5', '26', '271', 'Anicet', 'Hack', 'Féminin', '1200901979305', '22901254887', 'Formation en élévage de poules pondeuses', 'rien de sérieux', NULL, NULL, NULL, '', '', '', '0', '1000000', NULL, '1000000', 1, 35, 47, '2025-11-25 16:01:00', 'En attente', 'En cours de traitement', 'Approuvé', '2', '0', '0', 1, 2025, '2025-11-25 14:13:13', NULL, NULL, '2025-11-25 10:42:01', '2025-11-24 14:01:25', '2025-11-25 15:01:00', 2025, '2025-11-26 09:37:16', 1),
(57, 17, 'I58-UIMQ-RTEB-MTJJ', 'Assiri', 'Assistance', 'ONG', '', '', '', 'MONGADJI', 'Cyril', 'Masculin', '1458960265485', NULL, 'Formation', '7854', NULL, NULL, NULL, '', '', '', '0', '15000000', NULL, '0', 0, NULL, NULL, NULL, 'En attente', 'En cours de traitement', NULL, '1', '0', '0', 0, NULL, NULL, NULL, '2025-11-25 19:44:30', NULL, '2025-11-25 19:32:54', '2025-11-25 19:44:30', 2025, '2025-11-26 09:37:16', 1),
(58, 18, 'W54-VEEJ-XKXQ-MPCY', 'LighInovation', 'Formation', 'ONG', '3', '11', '41', 'Camenbert', 'TJAY', 'Masculin', '6705895202515', NULL, 'Formation', 'Formation', NULL, NULL, NULL, '', '', '', '0', '12000000', 'piece/ZPy6YegsowZ89FVX07bTJ5OAzYMQOE3MiI4m94nQ.pdf', '0', 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '0', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2025-11-25 20:51:36', '2025-11-25 21:24:37', 2025, '2025-11-26 09:37:16', 1),
(59, 19, 'G57-FFEX-GKAQ-SJEQ', 'ALKAPOTE', 'Assistance', 'structure', '3', '', '', 'Pop', 'Smoke', 'Masculin', '5684789520158', NULL, 'Intitulé', 'Objectif', NULL, NULL, NULL, '', '', '', '0', '3000000', NULL, '3000000', 0, NULL, NULL, NULL, 'En attente', 'En cours de traitement', 'Approuvé', '2', '0', '0', 0, NULL, NULL, NULL, '2025-11-25 21:06:35', '2025-11-25 22:06:56', '2025-11-25 20:53:37', '2025-11-25 21:06:56', 2025, '2025-11-26 09:37:16', 1),
(61, 40, 'W81-HGXU-BAQD-WEQR', 'Jaskolski Group', 'Formation', 'structure', '6', '28', '230', 'Doyle', 'Mikel', 'Féminin', '88301416126928', '364.310.2143', 'Vero assumenda et harum qui.', 'Sunt facilis impedit iste aut voluptas consequatur. Reiciendis dolorum hic nam est consequatur. Sit eaque odio quisquam ducimus qui dolor ratione.', '2025-12-13', '2026-01-11', '28', '6', '64', '17485 Agustin Light', '120', '2525930', NULL, '1750642', 0, 96, 113, NULL, 'En attente', NULL, NULL, '0', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2025-04-18 15:26:59', '2025-04-18 15:26:59', 2025, '2025-11-26 11:15:49', 1),
(62, 41, 'S22-LERK-YRVR-TJJV', 'Little, Cartwright and Muller', 'Formation', 'ONG', '4', '19', '136', 'Funk', 'Wayne', 'Masculin', '38595411765583', '1-626-800-5200', 'Sit ut sint.', 'Qui perspiciatis repellat reprehenderit assumenda reiciendis omnis voluptas. Nemo occaecati quia nemo fuga quos totam.', '2025-12-18', '2025-12-28', '10', '5', '55', '20760 Pfeffer Plaza', '161', '3160002', NULL, '2499798', 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '1', '0', '0', 0, NULL, NULL, NULL, '2025-09-27 14:07:35', NULL, '2025-04-13 03:48:50', '2025-04-13 03:48:50', 2025, '2025-11-26 11:15:49', 1),
(63, 42, 'S54-BJZA-CUBX-DLQR', 'Bruen Inc', 'Formation', 'ONG', '9', '39', '272', 'D\'Amore', 'Kailee', 'Féminin', '37851005245894', '283-982-4545', 'Explicabo molestiae fuga.', 'Facilis voluptatem et et enim sint et quia. Accusantium accusantium quas quibusdam. Odit est non fugiat aspernatur esse quo.', '2025-12-20', '2026-01-03', '14', '11', '38', '8162 Bashirian Corner Apt. 995', '57', '3169379', NULL, '389794', 0, 5, 30, '2025-11-14 04:13:25', 'En attente', NULL, NULL, '0', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2025-05-08 05:48:35', '2025-05-08 05:48:35', 2025, '2025-11-26 11:15:49', 1),
(64, 43, 'Z77-QYDV-UBIG-VZUA', 'VonRueden LLC', 'Financier', 'ONG', '7', '31', '232', 'Kovacek', 'Cade', 'Féminin', '82817353180633', '341.736.3508', 'Consequuntur velit et voluptate facere.', 'Labore doloribus laudantium repellendus occaecati nam. Sed officia inventore blanditiis nisi nobis quas nostrum. Vel quia dolorum aperiam qui nostrum deserunt.', '2025-12-07', '2025-12-14', '6', '1', '6', '3429 Gerhold Junction', '132', '2746283', NULL, '426359', 0, 108, 124, '2025-11-07 13:27:03', 'En attente', NULL, NULL, '1', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2025-04-05 03:50:13', '2025-04-05 03:50:13', 2025, '2025-11-26 11:15:49', 1),
(65, 44, 'C25-QDJE-LVUN-BYAU', 'Rohan LLC', 'Assistance', 'structure', '4', '20', '174', 'Bergstrom', 'Jamison', 'Féminin', '85254334675626', '(678) 954-1211', 'Inventore eius corporis aut.', 'Laborum odit id culpa aliquam sed ullam. Minima molestias autem laborum deleniti similique.', '2025-12-23', '2026-01-07', '14', '2', '13', '45284 Lilla Mount', '197', '891226', NULL, '462206', 0, NULL, 140, NULL, 'En attente', NULL, NULL, '2', '0', '0', 0, NULL, NULL, NULL, NULL, '2025-11-11 13:35:51', '2025-10-30 01:14:30', '2025-10-30 01:14:30', 2025, '2025-11-26 11:15:49', 1),
(66, 45, 'M22-NRKY-RLKL-KRUF', 'Johns-Wilderman', 'Financier', 'ONG', '7', '31', '231', 'Greenfelder', 'Granville', 'Masculin', '82493085525978', '+1-978-831-6051', 'Et ex doloremque aut.', 'Aperiam est quasi voluptas doloremque eum quo. Deleniti sit non est asperiores esse non eaque. Quasi repudiandae dicta aut enim voluptatibus et et.', '2025-12-03', '2025-12-31', '28', '6', '59', '6905 Kuvalis Ports', '172', '4419216', NULL, '856758', 0, 21, 49, NULL, 'En attente', NULL, NULL, '1', '0', '0', 0, NULL, NULL, NULL, NULL, '2025-11-11 03:04:11', '2025-10-25 17:35:08', '2025-10-25 17:35:08', 2025, '2025-11-26 11:15:49', 1),
(67, 46, 'U41-ZKUC-XJMK-MOWA', 'Lakin LLC', 'Formation', 'ONG', '9', '40', '279', 'Schamberger', 'Marisol', 'Masculin', '50749474007334', '+1 (404) 442-1555', 'Rerum impedit eum voluptas.', 'Soluta earum quibusdam accusamus quis tenetur tempore. Ex accusantium quia sapiente hic ipsum magni. Est illum omnis optio voluptas blanditiis in accusantium.', '2025-12-08', '2026-02-06', '60', '11', '41', '21108 Steve Gardens', '193', '4960114', NULL, '1630384', 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '2', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2025-03-15 09:03:57', '2025-03-15 09:03:57', 2025, '2025-11-26 11:15:49', 1),
(68, 47, 'K89-LLJI-UJBD-KOQU', 'Dickinson-Muller', 'Financier', 'professionnel', '2', '42', '41', 'Gerhold', 'Lawrence', 'Masculin', '00693857221460', '1-260-303-1181', 'Possimus corporis et voluptatem.', 'Tempora natus autem dolores officia doloremque dolores. Corrupti est aliquam possimus et quaerat.', '2025-12-09', '2025-12-24', '15', '3', '21', '8251 Klocko Lodge Suite 488', '119', '4518961', NULL, '491088', 0, 110, 134, '2025-11-08 00:51:53', 'En attente', NULL, NULL, '2', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2025-11-14 11:31:51', '2025-11-14 11:31:51', 2025, '2025-11-26 11:15:49', 1),
(69, 48, 'F62-HBXU-RGBH-FDRA', 'Gaylord-Bednar', 'Formation', 'professionnel', '4', '24', '165', 'Gottlieb', 'Abdullah', 'Féminin', '91048214870527', '+12123082248', 'Maiores deserunt ea maiores expedita.', 'Ipsum minima ipsum ab quo enim voluptas distinctio. Repudiandae impedit eos accusamus rerum in doloribus. Tenetur dolore voluptate voluptates reiciendis ratione vel.', '2025-11-29', '2025-12-02', '3', '12', '28', '801 Franecki Meadows Suite 145', '87', '3110687', NULL, '2101738', 0, 81, NULL, '2025-11-17 13:37:08', 'En attente', NULL, NULL, '1', '0', '0', 0, NULL, NULL, NULL, '2025-11-06 04:13:11', '2025-11-20 15:20:43', '2025-11-14 04:34:17', '2025-11-14 04:34:17', 2025, '2025-11-26 11:15:49', 1),
(70, 49, 'Z04-YALI-DWKM-MWHB', 'Lesch, Fadel and Hackett', 'Assistance', 'structure', '4', '20', '185', 'Dooley', 'Casimir', 'Masculin', '66283243189663', '430.630.3496', 'Illum minus minima molestiae.', 'Consequatur alias rerum voluptatem qui velit ratione accusantium veniam. Pariatur eum rerum itaque aut sapiente aut molestias.', '2025-12-19', '2026-02-15', '57', '8', '72', '1068 Jones Place Suite 021', '23', '2813906', NULL, '2016115', 0, 70, 85, NULL, 'En attente', NULL, NULL, '0', '0', '0', 0, NULL, NULL, NULL, '2025-10-29 05:50:11', '2025-10-27 04:17:57', '2025-05-14 12:24:13', '2025-05-14 12:24:13', 2025, '2025-11-26 11:15:49', 1),
(71, 50, 'D34-IDIK-WYGN-ZGEM', 'Zulauf-Robel', 'Assistance', 'ONG', '3', '16', '103', 'Reichel', 'Shea', 'Féminin', '13053969079196', '+13516085748', 'Sunt et est qui dolores.', 'Quasi porro occaecati ipsa. Deleniti voluptas asperiores ut minus itaque amet.', '2025-12-08', '2026-01-07', '29', '9', '25', '31122 Ernser Haven', '52', '2846757', NULL, '2606753', 0, NULL, 149, NULL, 'En attente', NULL, NULL, '1', '0', '0', 0, NULL, NULL, NULL, '2025-10-08 10:38:28', NULL, '2025-05-20 10:25:26', '2025-05-20 10:25:26', 2025, '2025-11-26 11:15:49', 1),
(72, 51, 'G01-HWOY-ZJAR-UZUE', 'Lowe Group', 'Financier', 'ONG', '5', '25', '195', 'Abernathy', 'Shanelle', 'Féminin', '05952171998963', '614.747.5870', 'Officiis blanditiis minima voluptates sit aperiam.', 'Quia ipsam nihil quis maiores tenetur cupiditate. Omnis laboriosam qui modi officia.', '2025-12-23', '2026-01-17', '24', '12', '28', '387 Lloyd Run', '102', '368136', NULL, '253640', 1, NULL, 64, '2025-10-29 01:31:05', 'En attente', NULL, NULL, '0', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2025-09-11 14:10:05', '2025-09-11 14:10:05', 2025, '2025-11-26 11:15:49', 1),
(73, 52, 'R89-RJCT-HNUH-HXMR', 'Adams, Gleichner and Abshire', 'Financier', 'structure', '4', '23', '119', 'Jones', 'Evangeline', 'Féminin', '83772087774119', '505.490.7945', 'Dicta itaque expedita.', 'Iure reprehenderit sed id est consequuntur. Pariatur consequuntur quibusdam quas dolor voluptatem cum sunt. Non voluptatibus voluptas ea sint facere dolores.', '2025-12-04', '2025-12-31', '26', '9', '24', '297 Marion Fall', '12', '523319', NULL, '138618', 0, 134, 107, NULL, 'En attente', NULL, NULL, '2', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2025-02-26 09:55:53', '2025-02-26 09:55:53', 2025, '2025-11-26 11:15:49', 1),
(74, 53, 'E46-KABY-IPOI-FFCE', 'Larson, Walter and Moore', 'Assistance', 'structure', '9', '37', '299', 'Rippin', 'Makenzie', 'Féminin', '19570351264559', '+1-513-569-4266', 'Ex dolore suscipit eum.', 'Architecto et consectetur quod voluptatem ad adipisci. Facere autem rem voluptatem incidunt impedit id. Voluptatem debitis ut cum vitae impedit nemo deleniti.', '2025-12-09', '2026-01-26', '48', '8', '76', '675 Bosco Motorway Apt. 331', '158', '3189997', NULL, '2347998', 0, NULL, 68, '2025-11-11 07:07:20', 'En attente', NULL, NULL, '0', '0', '0', 0, NULL, NULL, NULL, NULL, '2025-11-01 17:07:22', '2025-08-21 20:49:50', '2025-08-21 20:49:50', 2025, '2025-11-26 11:15:49', 1),
(75, 54, 'H30-TESL-UTKQ-AMAP', 'Cronin-Purdy', 'Financier', 'professionnel', '2', '45', '8', 'Gleichner', 'Joanie', 'Masculin', '29384903042440', '(646) 669-8233', 'Hic et sunt.', 'Hic modi sed et quibusdam ut. Voluptatem consequatur accusantium quae dicta veniam amet. Fuga veritatis accusantium dolor repudiandae.', '2025-12-11', '2026-01-22', '41', '8', '70', '946 Beer Plaza Suite 364', '187', '1039266', NULL, '50844', 0, 118, NULL, NULL, 'En attente', NULL, NULL, '2', '0', '0', 0, NULL, NULL, NULL, NULL, '2025-10-31 10:47:53', '2025-10-10 03:36:48', '2025-10-10 03:36:48', 2025, '2025-11-26 11:15:49', 1),
(76, 55, 'C09-UILZ-TVRN-SQNF', 'Kihn-Corwin', 'Financier', 'professionnel', '7', '30', '237', 'Bashirian', 'Estevan', 'Masculin', '32246286409390', '+1-567-539-0558', 'Aut eos eveniet nisi soluta commodi.', 'Voluptatem quidem aperiam optio et animi quia. Maxime fugit natus id delectus saepe sunt et.', '2025-12-18', '2026-01-15', '28', '1', '5', '7153 Schoen Common Suite 741', '152', '2320606', NULL, '563701', 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '0', '0', '0', 0, NULL, NULL, NULL, '2025-10-23 04:45:08', '2025-11-18 21:16:28', '2025-11-24 20:31:09', '2025-11-24 20:31:09', 2025, '2025-11-26 11:15:49', 1),
(77, 56, 'L69-JKUC-DPJF-WWLX', 'Heller-Johnson', 'Assistance', 'structure', '6', '28', '228', 'Conn', 'Stephon', 'Masculin', '57668144159288', '1-941-745-4125', 'Adipisci impedit nihil ut asperiores.', 'Quaerat ut omnis hic consequatur ipsum dolorum distinctio voluptas. Beatae nostrum aspernatur cumque explicabo odit. Est et nisi quo quae aliquid voluptates laudantium.', '2025-12-21', '2026-01-31', '41', '8', '71', '9335 Linwood Orchard Suite 254', '172', '4709086', NULL, '2130127', 1, 130, 132, NULL, 'En attente', NULL, NULL, '2', '0', '0', 0, NULL, NULL, NULL, '2025-09-29 00:19:53', NULL, '2025-10-22 20:21:04', '2025-10-22 20:21:04', 2025, '2025-11-26 11:15:49', 1),
(78, 57, 'T75-LWLQ-GIRJ-LNZC', 'Champlin Ltd', 'Assistance', 'ONG', '2', '44', '18', 'Wiza', 'Marcelino', 'Masculin', '78147407086529', '442-886-5855', 'Unde alias ex.', 'Voluptas exercitationem et aliquid vitae quia repellendus ipsa. Ad in quae sint sed facilis facilis aut.', '2025-11-27', '2026-01-20', '54', '5', '56', '36314 Schneider Highway', '29', '3411802', NULL, '92825', 0, 96, 77, NULL, 'En attente', NULL, NULL, '2', '0', '0', 0, NULL, NULL, NULL, NULL, '2025-11-10 07:10:43', '2025-04-17 09:26:55', '2025-04-17 09:26:55', 2025, '2025-11-26 11:15:49', 1),
(79, 58, 'I63-IABT-QSWN-IVUZ', 'Stehr, Smitham and Trantow', 'Formation', 'structure', '8', '33', '256', 'Franecki', 'Cole', 'Masculin', '75258113599399', '+13122781841', 'Amet ab minus dicta.', 'Aspernatur et repellat ipsum quia sint ipsum sed. Sit aut necessitatibus ex veniam ex asperiores. Est corporis ad quia ipsam.', '2025-12-01', '2026-02-19', '79', '4', '43', '7769 Crooks Summit Apt. 369', '187', '278855', NULL, '240144', 0, 29, 45, NULL, 'En attente', NULL, NULL, '0', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2025-04-06 20:58:08', '2025-04-06 20:58:08', 2025, '2025-11-26 11:15:49', 1),
(80, 59, 'C65-BDWC-GIVH-HAHF', 'King Inc', 'Financier', 'ONG', '3', '16', '61', 'Gleichner', 'Owen', 'Masculin', '42492785184547', '+1.443.616.4406', 'Assumenda autem qui porro dicta.', 'Reprehenderit praesentium alias consequatur voluptate. Et maxime temporibus perspiciatis veritatis nostrum. Quia aliquid autem quisquam.', '2025-12-17', '2026-01-09', '23', '8', '71', '611 Maximus Highway Suite 259', '193', '1602520', NULL, '524812', 0, 125, 5, NULL, 'En attente', NULL, NULL, '1', '0', '0', 0, NULL, NULL, NULL, '2025-11-08 23:19:05', NULL, '2025-08-25 22:47:22', '2025-08-25 22:47:22', 2025, '2025-11-26 11:15:49', 1),
(144, 60, 'H38-GTAW-LXBN-HXQL', 'Daugherty and Sons', 'Financier', 'professionnel', '10', NULL, NULL, 'Fadel', 'Bettye', 'Féminin', '92959645381617', '+1-929-778-2885', 'Ipsam cum et vel aliquid.', 'Ut maxime delectus repellendus voluptatem quae et. Corrupti eius totam cupiditate consequatur est id ut. Cupiditate vitae quam harum odio.', '2025-12-17', '2026-01-02', '16', '5', '52', '6765 Karlie Route Suite 342', '173', '3761097', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '2', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2024-01-25 06:29:42', '2024-01-25 06:29:42', 2024, '2025-11-26 18:04:02', 1),
(145, 61, 'I78-OHBB-GXSL-KWBI', 'Zboncak-Reynolds', 'Financier', 'structure', '8', '33', '249', 'Stiedemann', 'Maverick', 'Masculin', '83055146642039', '+1-754-946-3210', 'Laboriosam repudiandae eius quo ducimus.', 'Voluptatem veniam debitis non consequatur consequuntur eum possimus. Et hic occaecati quasi laudantium est modi tempora.', '2025-12-03', '2026-01-05', '33', '11', '42', '45090 Bergnaum Highway Suite 919', '55', '2292821', NULL, '2100000', 1, 0, 80, '2025-11-26 12:36:05', 'En attente', NULL, 'Approuvé', '2', '0', '0', 0, NULL, NULL, NULL, NULL, '2025-11-26 12:27:31', '2024-06-30 19:04:55', '2025-11-26 11:36:05', 2024, '2025-11-26 18:04:02', 1),
(146, 62, 'C23-PGNS-IYGY-MRQC', 'Hodkiewicz-Schuster', 'Financier', 'professionnel', '4', '22', '111', 'Pacocha', 'Dangelo', 'Masculin', '88279492879697', '(726) 328-1142', 'Et quia tempore corporis maiores.', 'Qui minus pariatur qui dicta architecto. Quaerat aut odit voluptatem officiis. Velit ad eveniet quod optio cumque nihil aut qui.', '2025-12-05', '2026-01-17', '43', '9', '26', '22636 Hershel Parkway', '157', '3819069', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '2', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2024-07-19 09:17:03', '2024-07-19 09:17:03', 2024, '2025-11-26 18:04:02', 1),
(147, 63, 'Q19-ZVEB-YTKH-EQJL', 'Mertz-Wilkinson', 'Formation', 'ONG', '3', '15', '98', 'Schoen', 'Oswaldo', 'Masculin', '38014450183308', '+1-959-725-4209', 'Labore consequatur eum deserunt quas aut.', 'Qui id quia at qui. Recusandae provident necessitatibus unde omnis sed. Unde et et aliquam.', '2025-12-22', '2026-01-05', '13', '9', '27', '4224 Leffler Stravenue Apt. 504', '72', '4601001', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '2', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2024-11-27 13:07:13', '2024-11-27 13:07:13', 2024, '2025-11-26 18:04:02', 1),
(148, 65, 'I25-WRZW-GUTH-XWKQ', 'Hettinger and Sons', 'Financier', 'professionnel', '10', NULL, NULL, 'Blanda', 'Jakob', 'Masculin', '39715555853358', '+1 (347) 612-7523', 'Voluptatem aspernatur ipsum voluptatem unde temporibus.', 'Vel repudiandae sequi aut qui officia aut enim. Corrupti illo nostrum qui doloremque nemo molestiae eligendi. Inventore tempora assumenda nobis commodi optio aliquid magni in.', '2025-12-07', '2026-01-05', '28', '3', '23', '3101 Larson Loop Apt. 306', '30', '282051', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '2', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2024-10-28 03:08:26', '2024-10-28 03:08:26', 2024, '2025-11-26 18:04:02', 1),
(149, 66, 'O85-DRTN-ALYX-ILAL', 'Mraz, Cruickshank and Johns', 'Formation', 'ONG', '9', '38', '282', 'Turcotte', 'Etha', 'Masculin', '74696778357977', '726.856.4214', 'Aut amet accusantium qui autem.', 'Molestiae minus aliquid eveniet iusto excepturi. Sapiente itaque et ut voluptate. Nesciunt aut sunt debitis dolores.', '2025-12-19', '2026-02-15', '58', '1', '10', '877 Hagenes Cliffs', '75', '2479058', NULL, '2400000', 1, 10, 25, '2025-11-26 12:35:11', 'En attente', NULL, 'Approuvé', '2', '0', '0', 0, NULL, NULL, NULL, NULL, '2025-11-26 12:30:13', '2024-11-01 04:10:00', '2025-11-26 11:35:11', 2024, '2025-11-26 18:04:02', 1),
(150, 67, 'Q66-TIKE-LNSE-CMRM', 'VonRueden-White', 'Financier', 'professionnel', '6', '27', '224', 'Wehner', 'Aylin', 'Féminin', '86384980839288', '+1.385.876.3912', 'Voluptatem nihil et repellat excepturi.', 'Qui alias vel excepturi tempora velit. Ad debitis amet et facere. Maiores eos impedit quia asperiores.', '2025-11-29', '2026-02-25', '87', '5', '55', '161 Upton Walk Suite 392', '118', '4941364', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '1', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2024-06-20 02:58:21', '2024-06-20 02:58:21', 2024, '2025-11-26 18:04:02', 1),
(151, 68, 'W78-NMFB-RVAI-OBOA', 'Lynch PLC', 'Assistance', 'structure', '3', '12', '61', 'Russel', 'Trey', 'Masculin', '68380050845555', '+1-854-725-0819', 'Voluptatem minus non laudantium.', 'Eveniet reiciendis itaque est et ipsam ipsa dolorum debitis. Ratione qui suscipit expedita quod molestias tenetur.', '2025-12-20', '2026-02-08', '49', '11', '41', '624 Annie Landing', '98', '1825067', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '1', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2024-01-05 17:18:38', '2024-01-05 17:18:38', 2024, '2025-11-26 18:04:02', 1),
(152, 69, 'G17-BJQV-BPYV-QGCH', 'Raynor-Will', 'Assistance', 'ONG', '7', '30', '236', 'Hettinger', 'Gail', 'Masculin', '42362083244716', '424-301-9669', 'Quo ut nihil ea.', 'At eum voluptates non quo voluptatem adipisci recusandae eveniet. Consectetur nulla unde autem cupiditate quas repellendus.', '2025-11-27', '2026-01-06', '40', '12', '28', '465 Rusty Lake Apt. 292', '147', '4793314', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '1', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2024-04-01 17:06:36', '2024-04-01 17:06:36', 2024, '2025-11-26 18:04:02', 1),
(153, 71, 'C57-HRMQ-WFAH-DUUN', 'Hintz LLC', 'Financier', 'ONG', '9', '39', '296', 'Emmerich', 'Johathan', 'Féminin', '77877689499532', '1-812-657-1217', 'Cumque aperiam voluptates similique occaecati autem.', 'Nesciunt repellat cum harum. Sit enim nam eos aperiam saepe quis cumque. Minus non reiciendis et at asperiores praesentium.', '2025-12-15', '2025-12-19', '4', '12', '28', '9692 Jordyn Locks Suite 212', '54', '2649986', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', 'Suspendus', NULL, '0', '1', '0', 0, NULL, NULL, NULL, NULL, NULL, '2024-11-27 18:50:08', '2025-11-26 11:32:56', 2024, '2025-11-26 18:04:02', 1),
(154, 73, 'N72-MDIN-BJTY-SMXT', 'Cronin-Greenholt', 'Formation', 'professionnel', '7', '31', '233', 'Turner', 'Sister', 'Masculin', '72630314455464', '678.254.5878', 'Et sed explicabo voluptate.', 'Iusto enim est est eveniet. Aut qui qui iste dolorum exercitationem sit facere officia. Deserunt blanditiis et et quod ea.', '2025-12-06', '2025-12-21', '15', '8', '76', '12685 Little Square Apt. 550', '96', '3376299', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '0', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2024-06-07 04:11:29', '2024-06-07 04:11:29', 2024, '2025-11-26 18:04:02', 1),
(155, 75, 'U61-EHAN-NGYU-TWRT', 'Bayer, Luettgen and Ankunding', 'Formation', 'professionnel', '2', '43', '14', 'Blick', 'Michele', 'Féminin', '62098222769970', '984-383-4240', 'Ea qui et numquam.', 'Aut aspernatur et excepturi saepe necessitatibus sit quae. Temporibus aut officia iure consequatur repellat perferendis.', '2025-12-12', '2026-01-07', '25', '6', '65', '8098 Dale Skyway', '127', '3010293', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', 'En cours de traitement', NULL, '1', '0', '0', 0, NULL, NULL, NULL, '2025-11-26 11:33:19', NULL, '2024-08-06 06:09:28', '2025-11-26 11:33:19', 2024, '2025-11-26 18:04:02', 1),
(156, 76, 'W17-SSJC-CTZF-LHOM', 'Mohr-Nolan', 'Assistance', 'ONG', '6', '28', '222', 'Schulist', 'Kassandra', 'Masculin', '37083362040762', '+1-820-976-0094', 'Quos molestias atque cum qui neque.', 'Distinctio incidunt ratione mollitia perspiciatis. Non at aliquid quasi soluta sed. Voluptatibus omnis et occaecati in voluptatem.', '2025-12-05', '2025-12-22', '16', '1', '8', '871 Dooley Mount', '155', '922321', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '0', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2024-06-22 03:42:27', '2024-06-22 03:42:27', 2024, '2025-11-26 18:04:02', 1),
(157, 77, 'M78-QEOL-FLKB-AZQF', 'Gottlieb-Gibson', 'Assistance', 'structure', '8', '33', '265', 'Roberts', 'Christina', 'Féminin', '25565484621582', '+1.316.661.3246', 'Delectus consequatur consequatur.', 'Itaque ipsa aut ut. Fuga voluptas minus sit totam voluptate eaque. Eum dolorem aliquam explicabo dolorem.', '2025-11-29', '2026-02-08', '70', '11', '42', '60035 Mante Squares Apt. 633', '144', '1515252', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', 'En cours de traitement', NULL, '1', '0', '0', 0, NULL, NULL, NULL, '2025-11-26 11:34:03', NULL, '2024-02-28 07:32:52', '2025-11-26 11:34:03', 2024, '2025-11-26 18:04:02', 1),
(158, 78, 'K91-VLWJ-ESEO-UIZQ', 'Pancras Anicet', 'Assistance', 'professionnel', '2', '7', '47', 'Wehner', 'Lea', 'Masculin', '74239192388490', '561-813-6525', 'Reiciendis possimus enim.', 'Inventore quia voluptatem dolores. Natus perspiciatis fugit alias repellendus nam. Magni voluptatem maiores veritatis quam.', '2025-11-27', '2026-01-20', '53', '1', '11', '7154 Vena Forks Suite 807', '155', '1417394', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '0', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2024-01-28 09:39:14', '2025-11-26 11:33:47', 2024, '2025-11-26 18:04:02', 1),
(159, 79, 'N79-JOEH-TQKL-YDJW', 'Donnelly-Effertz', 'Financier', 'professionnel', '4', '24', '117', 'Champlin', 'Roxanne', 'Masculin', '10020687874748', '(443) 279-9313', 'Iusto fugit ea dignissimos eaque optio.', 'Minima sunt officiis nihil in. Temporibus occaecati totam quibusdam aut cumque facere expedita. Accusamus suscipit dolores quia repellendus voluptas.', '2025-12-05', '2026-01-11', '36', '8', '74', '56209 Vernice Street', '22', '4832350', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '0', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2024-09-02 15:32:07', '2024-09-02 15:32:07', 2024, '2025-11-26 18:04:02', 1),
(160, 81, 'X62-YNAM-YAXI-HRRA', 'Considine, Erdman and Schuster', 'Financier', 'structure', '10', NULL, NULL, 'Gulgowski', 'Linwood', 'Masculin', '07899419726257', '+1-479-443-3508', 'Et excepturi non eum earum.', 'Eligendi ullam rerum commodi ab. Est et omnis iusto dolorum. Necessitatibus aliquid omnis quo enim laborum fugiat totam.', '2025-12-21', '2025-12-23', '1', '3', '19', '24520 Bogisich Valley', '117', '2125911', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '0', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2024-02-10 05:33:49', '2024-02-10 05:33:49', 2024, '2025-11-26 18:04:02', 1),
(161, 82, 'G78-WGCB-FVTI-YMCL', 'Hammes-Turcotte', 'Financier', 'professionnel', '4', '20', '121', 'Bradtke', 'Sarina', 'Féminin', '45314683646529', '+1-727-816-5429', 'Est aut aut sunt dicta.', 'Labore et quia commodi repellat sunt. Est minima ut deserunt molestias qui voluptas.', '2025-12-26', '2026-02-12', '48', '3', '18', '42802 Rohan Cliff Apt. 212', '120', '3971787', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '0', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2024-07-18 02:53:43', '2024-07-18 02:53:43', 2024, '2025-11-26 18:04:02', 1),
(162, 83, 'U40-VYIR-VGAO-TUOG', 'Weimann and Sons', 'Formation', 'structure', '4', '20', '190', 'Dietrich', 'Roman', 'Féminin', '18071098644261', '1-360-387-4370', 'Vel qui cum.', 'Explicabo ea dolor possimus debitis molestias cum. Minima molestiae itaque vero autem aut perferendis. Voluptatum quia quia sed eos ut ea laudantium.', '2025-12-18', '2026-02-18', '62', '7', '66', '4276 Hintz Lodge Suite 459', '47', '2006671', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', 'Suspendus', NULL, '0', '1', '0', 0, NULL, NULL, 'dossier incomplet', NULL, NULL, '2024-10-21 20:11:57', '2025-11-26 14:07:54', 2024, '2025-11-26 18:04:02', 1),
(163, 84, 'E87-IVXK-EDVF-XTXK', 'Rippin Ltd', 'Financier', 'professionnel', '7', '30', '236', 'Koelpin', 'Shemar', 'Féminin', '83927952853637', '1-678-767-1325', 'Dolorem in ea beatae.', 'Nesciunt esse officiis optio nostrum qui quo eos autem. Dolor eum dignissimos adipisci. Iusto odio error aperiam dolorum perspiciatis.', '2025-12-19', '2026-02-13', '56', '3', '23', '4576 Aditya Forge Apt. 229', '115', '1836205', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', 'En cours de traitement', NULL, '1', '0', '0', 0, NULL, NULL, NULL, '2025-11-26 12:17:22', NULL, '2024-10-25 08:40:13', '2025-11-26 12:17:22', 2024, '2025-11-26 18:04:02', 1),
(164, 85, 'R94-CQAT-OOTU-HAYG', 'Deckow Group', 'Formation', 'ONG', '8', '36', '259', 'Considine', 'Trudie', 'Masculin', '35694971843466', '1-430-594-7360', 'Architecto alias doloribus.', 'Dolorem error dolores deleniti explicabo asperiores tempora. Quis veritatis sed aut eveniet.', '2025-11-29', '2026-02-11', '73', '7', '68', '63610 Percival Drive Suite 190', '160', '2371171', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '0', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2024-04-26 19:18:49', '2024-04-26 19:18:49', 2024, '2025-11-26 18:04:02', 1),
(165, 87, 'D43-MTNT-GBJU-KYRJ', 'Kshlerin, Schumm and Aufderhar', 'Assistance', 'ONG', '5', '25', '206', 'Murazik', 'Alison', 'Féminin', '63309907270676', '331-248-7791', 'Ipsam aperiam ratione.', 'Et culpa eaque soluta necessitatibus laborum quia ut. Architecto est dolore enim accusamus itaque.', '2025-12-08', '2025-12-16', '8', '7', '68', '423 Cartwright Port Suite 884', '135', '2711553', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', 'Suspendus', NULL, '0', '1', '0', 0, NULL, NULL, NULL, NULL, NULL, '2024-06-04 00:52:22', '2025-11-26 12:17:52', 2024, '2025-11-26 18:04:02', 1),
(166, 88, 'V35-OCOO-HLHU-NSZO', 'Lehner-Torphy', 'Formation', 'structure', '2', '41', '14', 'Keeling', 'Jeramy', 'Féminin', '64884408241646', '520-706-1582', 'Omnis iure nisi omnis.', 'Est qui accusantium exercitationem voluptate. Ducimus beatae quia aliquam. Blanditiis et accusamus sunt eveniet.', '2025-12-16', '2025-12-30', '13', '6', '58', '9729 Ziemann Highway', '29', '2658111', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '0', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2024-05-22 01:50:38', '2024-05-22 01:50:38', 2024, '2025-11-26 18:04:02', 1),
(167, 89, 'Q81-WGOD-FWND-IDBV', 'Barrows LLC', 'Formation', 'ONG', '4', '23', '134', 'Wintheiser', 'Liana', 'Féminin', '78899498726467', '217-659-1282', 'Aut est enim iusto ut.', 'Dolorem est iusto a recusandae. Repudiandae sequi ut quia doloremque.', '2025-12-12', '2026-01-15', '33', '9', '24', '91675 Andy Ford Apt. 928', '173', '1642303', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '0', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2024-01-05 08:51:10', '2024-01-05 08:51:10', 2024, '2025-11-26 18:04:02', 1),
(168, 90, 'V93-FQGY-UYQR-LLEF', 'Stehr LLC', 'Formation', 'professionnel', '8', '33', '268', 'Wisozk', 'Darron', 'Masculin', '77132983335044', '954.578.7868', 'Harum dolore asperiores harum.', 'Consequuntur deleniti non laboriosam laudantium voluptas. Libero possimus veniam asperiores soluta nostrum nihil quasi.', '2025-12-23', '2026-02-23', '62', '12', '28', '94998 Zachariah Expressway', '96', '4443387', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '0', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2024-05-04 01:12:19', '2024-05-04 01:12:19', 2024, '2025-11-26 18:04:02', 1),
(169, 91, 'W38-JTFK-PHOW-ONJA', 'Treutel, Ullrich and Cummings', 'Formation', 'professionnel', '3', '17', '86', 'D\'Amore', 'Raphael', 'Féminin', '52063092750830', '+1-586-366-8587', 'Fugiat esse cum.', 'Modi rerum non aut ut sequi quia. Molestiae deleniti eos adipisci eum quidem odio.', '2025-12-24', '2026-01-25', '31', '9', '26', '8797 Natalie Ford Suite 677', '109', '3608268', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '0', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2024-04-02 16:52:02', '2024-04-02 16:52:02', 2024, '2025-11-26 18:04:02', 1),
(170, 92, 'N22-TYQY-MUHM-MDZG', 'Feest and Sons', 'Assistance', 'professionnel', '5', '26', '193', 'Witting', 'Geoffrey', 'Masculin', '80127585593187', '940.760.7411', 'Sequi animi aliquid aliquid dolores dolorum.', 'Aut quia doloremque omnis aut qui. Et eum consequatur magnam a sed cupiditate placeat.', '2025-12-17', '2025-12-22', '5', '4', '46', '7734 Lesly Harbor Apt. 631', '106', '2522946', NULL, '1000000', 1, 25, 25, '2025-11-26 15:57:05', 'En attente', 'En cours de traitement', 'Approuvé', '2', '0', '0', 0, NULL, NULL, NULL, '2025-11-26 14:08:49', '2025-11-26 15:24:12', '2024-10-14 00:03:14', '2025-11-26 14:57:05', 2024, '2025-11-26 18:04:02', 1),
(171, 93, 'A93-AIFS-CCPI-LHVZ', 'Weissnat, Farrell and Koelpin', 'Formation', 'structure', '10', NULL, NULL, 'Jacobi', 'Elenor', 'Masculin', '51024906445766', '(469) 951-2493', 'Molestiae occaecati aut.', 'Sequi soluta voluptatem ea aut. Est nihil aut ut ut perferendis. In nam provident sed fugit eius.', '2025-12-04', '2026-01-06', '33', '9', '24', '2072 Welch Mountain Suite 974', '177', '4391889', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '0', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2024-04-30 10:51:43', '2024-04-30 10:51:43', 2024, '2025-11-26 18:04:02', 1),
(172, 95, 'U89-CHTV-YLVQ-XAUA', 'Koss-Torp', 'Assistance', 'professionnel', '2', '44', '45', 'Oberbrunner', 'Cornell', 'Féminin', '10289821924410', '1-562-759-6012', 'Voluptates nobis nisi.', 'Explicabo aut odio atque molestiae. Nobis eum est sit perspiciatis.', '2025-12-09', '2026-01-25', '46', '8', '77', '6656 Connelly Inlet Suite 927', '90', '1150307', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '0', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2024-03-17 09:26:56', '2024-03-17 09:26:56', 2024, '2025-11-26 18:04:02', 1),
(173, 96, 'B85-NOAY-WLUR-JSDH', 'Swift-Franecki', 'Assistance', 'professionnel', '7', '31', '239', 'Ferry', 'Claude', 'Masculin', '33562499815720', '364.860.3862', 'Odit non nobis voluptatem.', 'Aspernatur voluptatem dignissimos tempora reprehenderit sequi dolorum. Veniam voluptas deleniti quisquam consectetur quia est nostrum omnis.', '2025-12-10', '2026-01-17', '37', '7', '68', '4167 Kody Track Apt. 635', '10', '1532820', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '0', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2024-01-15 18:05:48', '2024-01-15 18:05:48', 2024, '2025-11-26 18:04:02', 1),
(174, 97, 'B69-TUAG-IAAX-QEEH', 'Doyle LLC', 'Formation', 'professionnel', '4', '19', '146', 'Rogahn', 'Orie', 'Féminin', '47990247011566', '760.559.1788', 'Laudantium quisquam eius sit.', 'Quod dicta ea necessitatibus similique enim aut. Aut voluptatem ea dolor iste. Quidem quo et beatae dolore dolor placeat.', '2025-12-25', '2026-01-13', '19', '9', '27', '1970 Johnson Radial', '93', '4088046', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '0', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2024-09-11 19:11:17', '2024-09-11 19:11:17', 2024, '2025-11-26 18:04:02', 1),
(175, 98, 'R20-GCOW-ZYUO-HECD', 'Gulgowski-Doyle', 'Formation', 'ONG', '9', '39', '273', 'Nolan', 'Holly', 'Féminin', '40095122446763', '+1-856-755-5506', 'Corporis consequatur aut.', 'Voluptas sunt aperiam pariatur odit ut impedit illo. Eos in id assumenda adipisci cumque.', '2025-11-29', '2025-12-29', '29', '12', '28', '1771 Kunze Locks Suite 332', '134', '2780178', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '0', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2024-01-18 10:41:28', '2024-01-18 10:41:28', 2024, '2025-11-26 18:04:02', 1),
(176, 99, 'T14-HNSB-IFAO-NGVT', 'Keebler-Hane', 'Assistance', 'ONG', '9', '37', '283', 'Ullrich', 'Martin', 'Masculin', '12814415590285', '1-573-451-9792', 'Eum est commodi.', 'Consequatur non aspernatur dolorem reprehenderit aut laboriosam consequuntur qui. Dolorem cumque aliquid facilis culpa occaecati suscipit beatae. Quia quasi natus iusto.', '2025-11-26', '2026-01-29', '63', '11', '41', '8375 Phyllis Junction', '110', '4255979', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '0', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2024-01-31 03:52:43', '2024-01-31 03:52:43', 2024, '2025-11-26 18:04:02', 1),
(207, 105, 'F50-WCYV-STIR-JGRQ', 'Strosin-Purdy', 'Assistance', 'structure', '2', '41', '15', 'Waters', 'Hayden', 'Masculin', '26064852573622', '909.377.2194', 'Vero eligendi qui.', 'Ut enim rerum molestias omnis. Possimus hic vel sed sit facilis soluta impedit.', '2025-12-21', '2026-01-21', '31', '11', '39', '9047 Jeremie Brooks Suite 723', '136', '2113563', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '0', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2024-02-10 18:45:57', '2024-02-10 18:45:57', 2024, '2025-11-26 22:23:31', 1),
(208, 106, 'U72-ASWU-EEWC-VQUP', 'Bosco, Schulist and Rowe', 'Formation', 'professionnel', '6', '29', '223', 'Feest', 'Javier', 'Masculin', '06819976159852', '608.439.8811', 'Rem numquam harum maxime.', 'Omnis quia facilis minima est amet quas aut et. Porro quis dolorum dolor officiis illum. Et facere ipsa repellendus sed.', '2025-12-01', '2026-01-08', '38', '8', '72', '357 Hyatt Neck', '133', '668799', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '0', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2024-04-20 23:16:44', '2024-04-20 23:16:44', 2024, '2025-11-26 22:23:31', 1),
(209, 107, 'I70-PPFU-QQUK-OPHL', 'Beer, Welch and Torp', 'Formation', 'structure', '6', '28', '228', 'McGlynn', 'Vaughn', 'Féminin', '30102604239691', '+1.928.695.4326', 'Rerum impedit deserunt.', 'Eveniet itaque saepe qui nostrum repellat asperiores numquam. Voluptatem nemo enim saepe aut dolorum ut delectus. Necessitatibus adipisci repellat eos eum corporis.', '2025-12-08', '2025-12-29', '21', '11', '39', '353 Hans Lake', '156', '1942147', NULL, '1900000', 1, 65, 40, '2025-11-26 20:14:23', 'En attente', 'En cours de traitement', 'Approuvé', '2', '0', '0', 0, NULL, NULL, NULL, '2025-11-26 19:13:31', '2025-11-26 20:13:56', '2024-12-21 19:27:56', '2025-11-26 19:14:23', 2024, '2025-11-26 22:23:31', 1),
(210, 108, 'K94-JSZW-OEDH-REML', 'Schamberger-Baumbach', 'Formation', 'professionnel', '9', '39', '294', 'Powlowski', 'Jacey', 'Masculin', '59036360385860', '(757) 550-8953', 'Voluptatem reiciendis ab.', 'Et qui rerum eum omnis optio sequi. Asperiores corporis officiis culpa ex.', '2025-12-12', '2026-01-30', '49', '10', '32', '56675 Anya Forge', '178', '4286658', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '0', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2024-02-18 08:35:09', '2024-02-18 08:35:09', 2024, '2025-11-26 22:23:31', 1),
(211, 109, 'R28-YDSP-KHUM-ERMG', 'Treutel Group', 'Formation', 'ONG', '4', '21', '122', 'Champlin', 'Abraham', 'Féminin', '05791124238477', '1-435-434-5114', 'Sequi est aliquam accusantium est porro.', 'Illum ut omnis labore dignissimos dolores modi. Magnam nostrum officiis natus ut. Ex dolor minima ut aut officiis voluptates.', '2025-12-13', '2025-12-23', '9', '4', '43', '534 Pearl Street Apt. 527', '174', '592307', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '0', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2024-06-13 14:07:03', '2024-06-13 14:07:03', 2024, '2025-11-26 22:23:31', 1),
(212, 110, 'G58-SUUF-LYJB-DXVY', 'Vandervort PLC', 'Formation', 'ONG', '8', '36', '254', 'Mosciski', 'Hertha', 'Masculin', '69506939091049', '+1 (510) 601-8282', 'Vel aut aut corrupti.', 'Ad quod impedit recusandae sit. Provident blanditiis vel rem voluptatibus tempora dolore sit. Est est expedita praesentium sequi eius.', '2025-12-23', '2026-02-13', '51', '2', '17', '2693 Metz Park Suite 484', '149', '2078175', NULL, '2000000', 1, 60, 20, '2025-11-26 20:14:31', 'En attente', 'En cours de traitement', 'Approuvé', '2', '0', '0', 0, NULL, NULL, NULL, '2025-11-26 19:13:36', '2025-11-26 20:13:48', '2024-06-26 06:37:10', '2025-11-26 19:14:31', 2024, '2025-11-26 22:23:31', 1),
(213, 111, 'A85-BTWU-YKDC-DVQD', 'Goyette-Wuckert', 'Formation', 'professionnel', '3', '11', '67', 'Glover', 'Gregg', 'Masculin', '08551072503574', '1-276-588-8231', 'Est delectus ut quas ut eius.', 'Quia qui voluptas natus. Voluptas ex consequatur sunt et saepe distinctio. Maxime tempore qui optio ut commodi quidem.', '2025-12-05', '2025-12-23', '17', '11', '40', '78849 Kertzmann Drive Apt. 936', '101', '2145864', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', 'En cours de traitement', NULL, '1', '0', '0', 0, NULL, NULL, NULL, '2025-11-26 19:13:34', NULL, '2024-10-31 23:28:17', '2025-11-26 19:13:34', 2024, '2025-11-26 22:23:31', 1),
(214, 112, 'H49-MEQL-SZDD-HIUB', 'Koss and Sons', 'Formation', 'professionnel', '7', '30', '231', 'Langworth', 'Issac', 'Féminin', '04885274937665', '346.218.4278', 'Quia sed voluptatem autem non sit.', 'Debitis fuga et quis sunt delectus. Tenetur quis accusantium minus soluta rem aliquid.', '2025-11-30', '2026-02-07', '69', '1', '11', '4401 Lilian Lakes Suite 855', '62', '1000936', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '0', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2024-05-07 04:48:25', '2024-05-07 04:48:25', 2024, '2025-11-26 22:23:31', 1),
(215, 113, 'P62-TAHW-CXQS-SVMK', 'Tromp-Cremin', 'Assistance', 'ONG', '6', '27', '221', 'Wilkinson', 'Elinore', 'Masculin', '09976605102981', '253.715.6794', 'Asperiores quis voluptatem sed aliquam veniam.', 'Ipsum temporibus fugiat nesciunt rerum rerum sint. Neque aliquid explicabo pariatur. Sint cumque exercitationem voluptatem aut deserunt officiis quia.', '2025-12-03', '2025-12-28', '24', '5', '52', '55300 Tiana Station', '17', '470490', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '0', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2024-09-21 11:17:51', '2024-09-21 11:17:51', 2024, '2025-11-26 22:23:31', 1),
(216, 114, 'Z19-JOIL-FUBU-ZAME', 'Nicolas Inc', 'Formation', 'ONG', '8', '34', '246', 'Blanda', 'Madisen', 'Féminin', '67581798881619', '715-342-7061', 'Consequuntur illo nobis et voluptatem error.', 'Ad quam vitae quisquam quasi exercitationem necessitatibus ullam. Hic vel deleniti ab et.', '2025-12-22', '2026-02-24', '64', '7', '67', '999 Candace Stravenue Suite 529', '58', '2798736', NULL, NULL, 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '0', '0', '0', 0, NULL, NULL, NULL, NULL, NULL, '2024-06-15 02:24:41', '2024-06-15 02:24:41', 2024, '2025-11-26 22:23:31', 1),
(222, 70, 'K66-DZTG-GCDZ-BAII', 'ALKAPOTE', 'Assistance', 'professionnel', '', '', '', 'Pop', 'Smoke', 'Masculin', '1215444354554', NULL, 'Intitulé', 'BFdskfjdk', NULL, NULL, NULL, '', '', '', '150', '12000000', NULL, '10000000', 1, 52, 90, '2025-11-26 20:06:08', 'En attente', 'En cours de traitement', 'Approuvé', '2', '0', '0', 0, NULL, NULL, NULL, '2025-11-26 11:25:57', '2025-11-26 18:50:54', '2025-11-26 11:23:15', '2025-11-26 19:06:08', 2025, '2025-11-26 22:24:29', 1),
(223, 102, 'N86-YIAH-DPYT-FMPD', 'Aigle royal et négoce internationale', 'Formation', 'structure', '9', '38', '', 'GANLAKY', 'Benoît', 'Masculin', '3202113752161', '+2290199540808', 'Programme de formation de 50 jeunes artisans potiers de Ouidah sur le façonnage moderne des poteries', 'Programme de formation de 50 jeunes artisans potiers de Ouidah sur le façonnage moderne des poteries', '2025-06-02', '2025-06-06', '5', '1', '7', 'Djègbadji', '50', '9385000', NULL, '0', 0, NULL, NULL, NULL, 'En attente', 'Suspendus', NULL, '0', '1', '0', 0, NULL, NULL, NULL, NULL, NULL, '2025-11-26 13:58:41', '2025-11-26 15:49:55', 2025, '2025-11-26 22:24:29', 1),
(224, 103, 'N62-BSJM-JFUS-UVZT', 'ASSIRI', 'Formation', 'professionnel', '4', '20', '', 'IZI', 'Services', 'Masculin', '2145786325875', NULL, 'Formation en élévage de poules pondeuses', 'fdgfh', NULL, NULL, NULL, '1', '6', '', '40', '12525020202', NULL, '0', 0, NULL, NULL, NULL, 'En attente', 'Suspendus', NULL, '0', '1', '0', 0, NULL, NULL, NULL, NULL, NULL, '2025-11-26 15:32:05', '2025-11-26 15:49:08', 2025, '2025-11-26 22:24:29', 1),
(225, 104, 'O40-XSED-GIXH-ANAH', 'ALKAPOTE', 'Assistance', 'ONG', NULL, NULL, NULL, 'Pop', 'Smoke', 'Masculin', '1215444354554', '0162014598', 'Intitulé', 'fhtryrtyt', NULL, NULL, NULL, '', '', '', '100', '15000000', NULL, '12000000', 1, 30, 56, '2025-11-26 20:07:04', 'En attente', 'En cours de traitement', 'Approuvé', '2', '0', '0', 0, NULL, NULL, NULL, '2025-11-26 19:06:42', '2025-11-26 20:06:53', '2025-11-26 16:19:41', '2025-11-26 19:07:04', 2025, '2025-11-26 22:24:29', 1);

-- --------------------------------------------------------

--
-- Table structure for table `demande_localisations`
--

CREATE TABLE `demande_localisations` (
  `id` bigint UNSIGNED NOT NULL,
  `demande_id` bigint UNSIGNED NOT NULL,
  `departement_id` bigint UNSIGNED NOT NULL,
  `commune_id` bigint UNSIGNED NOT NULL,
  `lieux` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `homme_touche` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `demande_localisations`
--

INSERT INTO `demande_localisations` (`id`, `demande_id`, `departement_id`, `commune_id`, `lieux`, `homme_touche`, `created_at`, `updated_at`) VALUES
(124, 115, 12, 28, '36, avenue Hernandez', 95, '2025-11-27 05:06:34', '2025-11-27 05:06:34'),
(125, 115, 3, 20, '417, impasse Didier', 117, '2025-11-27 05:06:34', '2025-11-27 05:06:34'),
(127, 118, 6, 59, '7, impasse de Bonneau', 276, '2025-11-27 05:06:34', '2025-11-27 05:06:34'),
(128, 118, 8, 73, '37, impasse Emmanuel Millet', 125, '2025-11-27 05:06:34', '2025-11-27 05:06:34'),
(130, 120, 6, 62, 'Arafat', 150, '2025-11-27 08:57:03', '2025-11-27 08:57:03'),
(131, 117, 6, 59, NULL, NULL, '2025-11-27 10:14:04', '2025-11-27 10:14:04');

-- --------------------------------------------------------

--
-- Table structure for table `demande_localisations_clotures`
--

CREATE TABLE `demande_localisations_clotures` (
  `id` bigint UNSIGNED NOT NULL,
  `demande_cloture_id` bigint UNSIGNED NOT NULL,
  `demande_id_original` bigint UNSIGNED NOT NULL,
  `departement_id` bigint UNSIGNED DEFAULT NULL,
  `commune_id` bigint UNSIGNED DEFAULT NULL,
  `lieux` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `homme_touche` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `demande_localisations_clotures`
--

INSERT INTO `demande_localisations_clotures` (`id`, `demande_cloture_id`, `demande_id_original`, `departement_id`, `commune_id`, `lieux`, `homme_touche`, `created_at`, `updated_at`) VALUES
(1, 46, 1, 4, 43, 'HOPITAL', 10, '2025-11-20 22:43:33', '2025-11-20 22:43:33'),
(2, 46, 1, 5, 55, 'MAIRIE', 12, '2025-11-20 22:43:33', '2025-11-20 22:43:33'),
(3, 47, 3, 10, 36, 'SALLE DES JEUNES', 5, '2025-11-21 00:47:24', '2025-11-21 00:47:24'),
(4, 48, 4, 5, 55, 'SALLE DES ENFANTS', 50, '2025-11-21 01:12:29', '2025-11-21 01:12:29'),
(5, 49, 5, 8, 77, 'SALLE DES ENFANTS', 50, '2025-11-21 01:15:17', '2025-11-21 01:15:17'),
(6, 50, 6, 10, 33, 'SALLE DES ENFANTS', 50, '2025-11-21 01:39:06', '2025-11-21 01:39:06'),
(7, 50, 6, 7, 66, 'MAIRIE', 5, '2025-11-21 01:39:06', '2025-11-21 01:39:06'),
(8, 51, 7, 7, 4, 'HOPITAL', 20, '2025-11-21 02:17:36', '2025-11-21 02:17:36'),
(9, 51, 7, 9, 26, 'DDAEP', 5, '2025-11-21 02:17:36', '2025-11-21 02:17:36'),
(10, 52, 9, 1, 7, 'Djèbgadji', 60, '2025-11-20 09:58:38', '2025-11-20 09:58:38'),
(11, 54, 12, 10, 36, 'Missrété', 100, '2025-11-23 21:19:42', '2025-11-23 21:19:42'),
(12, 55, 13, 1, 7, 'Djèbgadji', 100, '2025-11-24 09:24:56', '2025-11-24 09:24:56'),
(13, 53, 11, 9, 24, 'Santiago', 100, '2025-11-25 19:24:20', '2025-11-25 19:24:20'),
(14, 53, 11, 6, 62, 'arafat', 200, '2025-11-25 19:24:20', '2025-11-25 19:24:20'),
(16, 61, 40, 6, 61, '32, rue Lagarde', 17, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(17, 61, 40, 2, 13, '849, boulevard de Lopez', 42, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(18, 61, 40, 11, 41, '9, rue de Bertin', 91, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(19, 62, 41, 9, 25, '4, boulevard Guyot', 49, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(20, 62, 41, 12, 28, '15, avenue Denis Noel', 72, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(21, 62, 41, 12, 28, '4, place Lacroix', 63, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(22, 63, 42, 9, 25, '4, avenue de Fontaine', 34, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(23, 63, 42, 1, 8, '27, impasse de Masse', 28, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(24, 63, 42, 7, 68, '420, avenue de Benard', 54, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(25, 64, 43, 9, 24, '6, boulevard Barbier', 10, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(26, 64, 43, 7, 3, 'place Lucie Boutin', 50, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(27, 64, 43, 3, 19, '3, rue de Leleu', 79, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(28, 65, 44, 4, 49, '6, rue Girard', 70, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(29, 65, 44, 4, 43, '3, place de Marchal', 86, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(30, 66, 45, 9, 27, '936, chemin de Lemaire', 65, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(31, 66, 45, 10, 35, '65, avenue Hugues Morel', 43, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(32, 66, 45, 11, 42, '96, place Fischer', 23, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(33, 67, 46, 4, 45, '70, impasse Noël Gros', 74, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(34, 68, 47, 7, 69, '9, place Roger Pineau', 39, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(35, 68, 47, 6, 59, '27, rue Lemoine', 76, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(36, 68, 47, 8, 71, '13, chemin Loiseau', 86, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(37, 69, 48, 7, 3, '17, boulevard de Bourgeois', 90, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(38, 69, 48, 10, 32, '10, place Julien Payet', 52, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(39, 70, 49, 2, 14, '96, rue Schmitt', 49, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(40, 71, 50, 7, 67, '58, impasse Bernadette Fernandes', 21, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(41, 71, 50, 5, 56, '75, rue Bertrand Sauvage', 81, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(42, 72, 51, 1, 6, '30, rue Martine Ribeiro', 38, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(43, 72, 51, 9, 25, '5, place Roland Delattre', 18, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(44, 72, 51, 8, 76, '962, avenue de Merle', 42, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(45, 73, 52, 11, 41, '38, chemin Gautier', 44, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(46, 74, 53, 9, 24, '28, chemin Agathe Aubry', 46, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(47, 74, 53, 3, 22, '6, boulevard Caroline Gautier', 91, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(48, 74, 53, 12, 28, '42, place Jean', 47, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(49, 75, 54, 10, 32, '215, rue Lorraine Le Gall', 14, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(50, 75, 54, 5, 52, '875, chemin Laurence Sauvage', 86, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(51, 75, 54, 9, 27, '770, impasse Émile Dubois', 71, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(52, 76, 55, 9, 24, '60, boulevard de Albert', 88, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(53, 76, 55, 2, 14, '32, rue Denis Ferrand', 19, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(54, 76, 55, 5, 53, '91, avenue Pires', 41, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(55, 77, 56, 7, 66, '193, avenue Perrot', 18, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(56, 78, 57, 8, 70, 'rue Picard', 81, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(57, 78, 57, 1, 9, '46, chemin Suzanne Robert', 74, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(58, 79, 58, 5, 57, '92, avenue Rolland', 10, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(59, 79, 58, 12, 28, '16, rue Frédéric Foucher', 68, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(60, 79, 58, 7, 4, 'impasse Chauvet', 92, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(61, 80, 59, 8, 77, 'rue Olivie Pruvost', 81, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(62, 80, 59, 11, 39, '230, avenue Gilles Pichon', 38, '2025-11-26 10:00:31', '2025-11-26 10:00:31'),
(94, 144, 60, 11, 39, '79, boulevard de Toussaint', 111, '2025-11-26 11:14:42', '2025-11-26 11:14:42'),
(95, 144, 60, 8, 78, '3, boulevard de Lopez', 123, '2025-11-26 11:14:42', '2025-11-26 11:14:42'),
(96, 145, 61, 4, 50, '35, rue de Barbier', 100, '2025-11-26 11:14:42', '2025-11-26 11:14:42'),
(97, 146, 62, 10, 30, '7, rue de Delaunay', 244, '2025-11-26 11:14:42', '2025-11-26 11:14:42'),
(98, 146, 62, 6, 63, '85, rue de Joubert', 283, '2025-11-26 11:14:42', '2025-11-26 11:14:42'),
(99, 149, 66, 1, 7, '7, impasse Bourdon', 221, '2025-11-26 11:14:42', '2025-11-26 11:14:42'),
(100, 150, 67, 3, 21, '2, avenue de Gregoire', 212, '2025-11-26 11:14:42', '2025-11-26 11:14:42'),
(101, 150, 67, 2, 17, '77, avenue Alves', 53, '2025-11-26 11:14:42', '2025-11-26 11:14:42'),
(102, 151, 68, 5, 57, '29, place de Lamy', 54, '2025-11-26 11:14:42', '2025-11-26 11:14:42'),
(103, 151, 68, 1, 6, '67, rue Nathalie Rousseau', 250, '2025-11-26 11:14:42', '2025-11-26 11:14:42'),
(104, 152, 69, 7, 67, '4, boulevard de Hernandez', 137, '2025-11-26 11:14:42', '2025-11-26 11:14:42'),
(105, 154, 73, 9, 26, '97, impasse Chauvet', 218, '2025-11-26 11:31:25', '2025-11-26 11:31:25'),
(106, 155, 75, 12, 28, 'chemin Bertrand Bourgeois', 106, '2025-11-26 11:31:25', '2025-11-26 11:31:25'),
(107, 155, 75, 4, 49, '17, boulevard Vasseur', 112, '2025-11-26 11:31:25', '2025-11-26 11:31:25'),
(108, 156, 76, 1, 5, '93, place Denis Turpin', 141, '2025-11-26 11:31:25', '2025-11-26 11:31:25'),
(109, 157, 77, 8, 78, 'avenue Julie Mace', 139, '2025-11-26 11:31:25', '2025-11-26 11:31:25'),
(110, 158, 78, 11, 42, '11, avenue de Levy', 284, '2025-11-26 11:33:47', '2025-11-26 11:33:47'),
(111, 161, 82, 3, 16, NULL, NULL, '2025-11-26 16:48:54', '2025-11-26 16:48:54'),
(112, 162, 83, 10, 36, '26, chemin Perez', 162, '2025-11-26 11:41:04', '2025-11-26 11:41:04'),
(113, 164, 85, 8, 76, '7, impasse Camille Guillaume', 229, '2025-11-26 11:41:04', '2025-11-26 11:41:04'),
(114, 164, 85, 10, 36, '50, rue Paul Cordier', 197, '2025-11-26 11:41:04', '2025-11-26 11:41:04'),
(115, 166, 88, 3, 21, 'rue Maryse Delaunay', 242, '2025-11-26 11:41:05', '2025-11-26 11:41:05'),
(116, 167, 89, 12, 28, '1, rue Alain Chauvet', 58, '2025-11-26 11:41:05', '2025-11-26 11:41:05'),
(117, 168, 90, 11, 42, '909, avenue Théophile Cordier', 179, '2025-11-26 11:41:05', '2025-11-26 11:41:05'),
(118, 169, 91, 2, 15, '83, chemin Hélène Grondin', 185, '2025-11-26 12:29:50', '2025-11-26 12:29:50'),
(119, 172, 95, 4, 49, '361, rue de Teixeira', 212, '2025-11-26 12:29:50', '2025-11-26 12:29:50'),
(120, 172, 95, 7, 68, '5, boulevard de Hernandez', 166, '2025-11-26 12:29:50', '2025-11-26 12:29:50'),
(121, 173, 96, 7, 68, 'rue Delaunay', 90, '2025-11-26 12:29:50', '2025-11-26 12:29:50'),
(122, 174, 97, 3, 22, '459, rue de Arnaud', 297, '2025-11-26 14:14:05', '2025-11-26 14:14:05'),
(123, 176, 99, 7, 67, '803, boulevard Christelle Gimenez', 212, '2025-11-26 12:29:50', '2025-11-26 12:29:50'),
(124, 176, 99, 5, 55, '37, impasse de Letellier', 211, '2025-11-26 12:29:50', '2025-11-26 12:29:50'),
(125, 207, 105, 4, 46, 'rue Grégoire Cordier', 175, '2025-11-26 19:13:13', '2025-11-26 19:13:13'),
(126, 208, 106, 1, 5, '31, rue Reynaud', 229, '2025-11-26 19:13:13', '2025-11-26 19:13:13'),
(127, 209, 107, 7, 4, '84, place Diane Joly', 273, '2025-11-26 19:13:13', '2025-11-26 19:13:13'),
(128, 209, 107, 11, 42, '29, impasse Sylvie Paris', 108, '2025-11-26 19:13:13', '2025-11-26 19:13:13'),
(129, 210, 108, 6, 59, '245, rue Carlier', 174, '2025-11-26 19:13:13', '2025-11-26 19:13:13'),
(130, 210, 108, 6, 61, '85, chemin de Daniel', 204, '2025-11-26 19:13:13', '2025-11-26 19:13:13'),
(131, 214, 112, 1, 8, '38, avenue Merle', 171, '2025-11-26 19:13:13', '2025-11-26 19:13:13'),
(132, 214, 112, 7, 67, '65, rue de Grenier', 250, '2025-11-26 19:13:13', '2025-11-26 19:13:13'),
(133, 216, 114, 8, 75, '280, avenue Alice Gillet', 287, '2025-11-26 19:13:13', '2025-11-26 19:13:13'),
(134, 216, 114, 11, 41, 'avenue Gilbert Rousset', 261, '2025-11-26 19:13:13', '2025-11-26 19:13:13'),
(140, 223, 102, 1, 7, 'Djègbadji', 50, '2025-11-26 13:58:41', '2025-11-26 13:58:41'),
(141, 224, 103, 1, 6, NULL, 40, '2025-11-26 15:32:05', '2025-11-26 15:32:05'),
(142, 225, 104, 2, 10, 'Missrété', 50, '2025-11-26 19:06:39', '2025-11-26 19:06:39');

-- --------------------------------------------------------

--
-- Table structure for table `departements`
--

CREATE TABLE `departements` (
  `id` bigint UNSIGNED NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departements`
--

INSERT INTO `departements` (`id`, `nom`, `created_at`, `updated_at`) VALUES
(1, 'ATLANTIQUE', NULL, NULL),
(2, 'MONO', NULL, NULL),
(3, 'COUFFO', NULL, NULL),
(4, 'ZOU', NULL, NULL),
(5, 'COLLINE', NULL, NULL),
(6, 'BORGOU', NULL, NULL),
(7, 'ALIBORI', NULL, NULL),
(8, 'ATACORA', NULL, NULL),
(9, 'DONGA', NULL, NULL),
(10, 'OUEME', NULL, NULL),
(11, 'PLATEAU', NULL, NULL),
(12, 'LITTORAL', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `metiers`
--

CREATE TABLE `metiers` (
  `id` bigint UNSIGNED NOT NULL,
  `branche_id` bigint UNSIGNED NOT NULL,
  `corp_id` bigint UNSIGNED NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `metiers`
--

INSERT INTO `metiers` (`id`, `branche_id`, `corp_id`, `nom`, `created_at`, `updated_at`) VALUES
(2, 2, 6, 'Fabricants d’assaisonnements', NULL, NULL),
(3, 2, 6, 'Fabricants de confitures', NULL, NULL),
(4, 2, 6, 'Fabricants de conserves de fruits', NULL, NULL),
(5, 2, 6, 'Sécheurs de fruits, de légumes', NULL, NULL),
(6, 2, 6, 'Transformateurs de noix en amuse-bouche', NULL, NULL),
(7, 2, 6, 'Transformateurs et conservateurs de feuilles, de fleurs comestibles', NULL, NULL),
(8, 2, 6, 'Fabricants d’autres produits à base de farine', NULL, NULL),
(9, 2, 6, 'Fabricants d’autres produits à base de tubercule', NULL, NULL),
(10, 2, 6, 'Fabricants de cossettes de manioc, d igname', NULL, NULL),
(11, 2, 6, 'Fabricants de couscous traditionnel', NULL, NULL),
(12, 2, 6, 'Fabricants de gari, de tapioca', NULL, NULL),
(13, 2, 6, 'Fabricants de moutarde', NULL, NULL),
(14, 2, 6, 'Meuniers ', NULL, NULL),
(15, 2, 6, 'Fabricants d’huile à base de graines', NULL, NULL),
(16, 2, 6, 'Fabricants d’huile à base de noix ', NULL, NULL),
(17, 2, 6, 'Bouchers ', NULL, NULL),
(18, 2, 6, 'Charcutiers ', NULL, NULL),
(19, 2, 6, 'Préparateurs de produits à base de viande, de volailles', NULL, NULL),
(20, 2, 6, 'Transformateurs et conservateurs de viandes, de volailles', NULL, NULL),
(21, 2, 6, 'Transformateurs et conservateurs de poissons, de crustacées, de mollusques', NULL, NULL),
(22, 2, 11, 'Fabricants de crèmes et glaces à sucer', NULL, NULL),
(23, 2, 11, 'Fabricants de fromage', NULL, NULL),
(24, 2, 11, 'Fabricants de glaces alimentaires', NULL, NULL),
(25, 2, 11, 'Fabricants de lait végétal', NULL, NULL),
(26, 2, 11, 'Fabricants de lait végétal', NULL, NULL),
(27, 2, 11, 'Extracteurs de sève', NULL, NULL),
(28, 2, 11, 'Fabricants de boissons à base d’eau naturelle', NULL, NULL),
(29, 2, 11, 'Fabricants de boissons alcoolisées', NULL, NULL),
(30, 2, 11, 'Fabricants de boissons non alcoolisées', NULL, NULL),
(31, 2, 11, 'Boulangerie', NULL, NULL),
(32, 2, 11, 'Fabricants de friandises', NULL, NULL),
(33, 2, 11, 'Fabricants de pâtes alimentaires', NULL, NULL),
(34, 2, 11, 'Pâtissiers', NULL, NULL),
(35, 2, 11, 'Apiculteurs', NULL, NULL),
(36, 2, 11, 'Cafetiers', NULL, NULL),
(37, 2, 11, 'Cantiniers', NULL, NULL),
(38, 2, 11, 'Cuisiniers', NULL, NULL),
(39, 2, 11, 'Fabricants de bouillies', NULL, NULL),
(40, 2, 11, 'Fabricants de galettes, beignets et d’autres produits alimentaires', NULL, NULL),
(41, 2, 11, 'Fabricants de plats préparés', NULL, NULL),
(42, 2, 11, 'Restaurateurs', NULL, NULL),
(43, 2, 11, 'Tenanciers de bars, buvettes', NULL, NULL),
(44, 2, 11, 'Traiteurs', NULL, NULL),
(45, 2, 11, 'Fabricants de pierre à lécher', NULL, NULL),
(46, 2, 11, 'Fabricants de provendes et autres aliments', NULL, NULL),
(47, 2, 11, 'Transformateurs de déchets organiques', NULL, NULL),
(48, 3, 12, 'Orpailleurs traditionnels', NULL, NULL),
(49, 3, 13, 'Extracteurs d’argiles', NULL, NULL),
(50, 3, 13, 'Extracteurs de granite ', NULL, NULL),
(51, 3, 13, 'Extracteurs de graviers', NULL, NULL),
(52, 3, 13, 'Extracteurs de grès ', NULL, NULL),
(53, 3, 13, 'Extracteurs de pierres ornementales', NULL, NULL),
(54, 3, 13, 'Extracteurs de sables', NULL, NULL),
(55, 3, 13, 'Producteurs de sel marin, de sel lacustre', NULL, NULL),
(56, 3, 16, 'Foreurs et installateurs de puits d’eau dotés de pompes immergées ', NULL, NULL),
(57, 3, 16, 'Fossoyeurs', NULL, NULL),
(58, 3, 16, 'Puisatiers', NULL, NULL),
(59, 3, 16, 'Réparateurs de pompe de forage', NULL, NULL),
(60, 3, 16, 'Concasseurs de pierre', NULL, NULL),
(61, 3, 16, 'Fabricants de pierre à moudre ', NULL, NULL),
(62, 3, 16, 'Graveurs sur pierre ', NULL, NULL),
(63, 3, 16, 'Marbriers', NULL, NULL),
(64, 3, 16, 'Tailleurs de pierre ', NULL, NULL),
(65, 3, 16, 'Fabricants de bornes, claustras, buses, dômes et autres accessoires en ciment ', NULL, NULL),
(66, 3, 16, 'Fabricants de briques en terre ', NULL, NULL),
(67, 3, 16, 'Fabricants de briques en ciment', NULL, NULL),
(68, 3, 16, 'Fabricants de carreaux ', NULL, NULL),
(69, 3, 16, 'Fabricants de pavés ', NULL, NULL),
(70, 3, 16, 'Fabricants de tuile ', NULL, NULL),
(71, 3, 17, 'Maçons', NULL, NULL),
(72, 3, 17, 'Spécialistes d’implantation de chantier ', NULL, NULL),
(73, 3, 17, 'Spécialistes de fouille pour fondation bâtiments', NULL, NULL),
(74, 3, 17, 'Spécialistes en démolition de bâtiments et édifices', NULL, NULL),
(75, 3, 18, 'Aménagistes de chaussées ', NULL, NULL),
(76, 3, 18, 'Constructeur d’ouvrages d’art ', NULL, NULL),
(77, 3, 18, 'Constructeur de bâtiments sur pilotis ', NULL, NULL),
(78, 3, 18, 'Constructeurs de bâtiments en bois, en bambou ', NULL, NULL),
(79, 3, 18, 'Constructeurs de bâtiments en terre de barre', NULL, NULL),
(80, 3, 18, 'Constructeurs de cases en terre de barre ', NULL, NULL),
(81, 3, 18, 'Constructeurs de greniers ', NULL, NULL),
(82, 3, 18, 'Constructeurs de paillotes ', NULL, NULL),
(83, 3, 18, 'Constructeurs de petits châteaux d’eau', NULL, NULL),
(84, 3, 18, 'Paveurs', NULL, NULL),
(85, 3, 19, 'Carreleurs ', NULL, NULL),
(86, 3, 19, 'Charpentiers', NULL, NULL),
(87, 3, 19, 'Coffreurs', NULL, NULL),
(88, 3, 19, 'Crépisseurs à la tyrolienne ', NULL, NULL),
(89, 3, 19, 'Dessinateurs-bâtiments ', NULL, NULL),
(90, 3, 19, 'Electriciens bâtiment', NULL, NULL),
(91, 3, 19, 'Encadreurs miroiteries ', NULL, NULL),
(92, 3, 19, 'Ferrailleurs', NULL, NULL),
(93, 3, 19, 'Métalliers', NULL, NULL),
(94, 3, 19, 'Peintres enduit lisse ', NULL, NULL),
(95, 3, 19, 'Peintres-bâtiments ', NULL, NULL),
(96, 3, 19, 'Plombiers', NULL, NULL),
(97, 3, 19, 'Poseurs d’enduits', NULL, NULL),
(98, 3, 19, 'Poseurs de cadre (porte et fenêtres)', NULL, NULL),
(99, 3, 19, 'Poseurs de gouttières', NULL, NULL),
(100, 3, 19, 'Poseurs de granitos ', NULL, NULL),
(101, 3, 19, 'Poseurs de pierres ornementales ', NULL, NULL),
(102, 3, 19, 'Poseurs de serrures ', NULL, NULL),
(103, 3, 19, 'Réalisateurs de feuillure en ciment', NULL, NULL),
(104, 3, 19, 'Spécialistes en revêtement et étanchéité ', NULL, NULL),
(105, 3, 19, 'Staffeurs ', NULL, NULL),
(106, 3, 19, 'Vitriers', NULL, NULL),
(107, 4, 21, 'Affûteurs', NULL, NULL),
(108, 4, 21, 'Chaudronniers ', NULL, NULL),
(109, 4, 21, 'Fabricants de poste à souder', NULL, NULL),
(110, 4, 21, 'Fabricants d’équipements de séchage de fruits et légumes ', NULL, NULL),
(111, 4, 21, 'Fabricants d’équipements de transformation des produits agroalimentaires', NULL, NULL),
(112, 4, 21, 'Fabricants de couveuses ', NULL, NULL),
(113, 4, 21, 'Fabricants de matériels à usage domestique ', NULL, NULL),
(114, 4, 21, 'Fabricants de matériels et équipements ', NULL, NULL),
(115, 4, 21, 'Fabricants de matériels et équipements agricoles et forestiers', NULL, NULL),
(116, 4, 21, 'Fabricants de métiers à tisser ', NULL, NULL),
(117, 4, 21, 'Fondeurs ', NULL, NULL),
(118, 4, 21, 'Fondeurs d’aluminium, de bronze et de cuivre ', NULL, NULL),
(119, 4, 21, 'Forgerons ', NULL, NULL),
(120, 4, 21, 'Fraiseurs ', NULL, NULL),
(121, 4, 21, 'Outilleurs ', NULL, NULL),
(122, 4, 21, 'Tourneurs', NULL, NULL),
(123, 4, 21, 'Charpentiers métalliers ', NULL, NULL),
(124, 4, 21, 'Fabricants de mobiliers en fer forgé ', NULL, NULL),
(125, 4, 21, 'Ferblantiers ', NULL, NULL),
(126, 4, 21, 'Menuisiers en aluminium ', NULL, NULL),
(127, 4, 21, 'Menuisiers métalliques', NULL, NULL),
(128, 4, 21, 'Poseurs de fils barbelés ', NULL, NULL),
(129, 4, 21, 'Soudeurs à l’arc ', NULL, NULL),
(130, 4, 21, 'Soudeurs autogène ', NULL, NULL),
(131, 4, 21, 'Tôliers', NULL, NULL),
(132, 4, 22, 'Ajusteurs d’appareils électriques ', NULL, NULL),
(133, 4, 22, 'Carrossiers ', NULL, NULL),
(134, 4, 22, 'Chargeurs de batterie ', NULL, NULL),
(135, 4, 22, 'Déboucheurs de radiateurs ', NULL, NULL),
(136, 4, 22, 'Electriciens auto moto ', NULL, NULL),
(137, 4, 22, 'Graisseurs de véhicules ', NULL, NULL),
(138, 4, 22, 'Mécaniciens de moteurs hors-bords ', NULL, NULL),
(139, 4, 22, 'Mécaniciens de motos pompe ', NULL, NULL),
(140, 4, 22, 'Mécatroniciens ', NULL, NULL),
(141, 4, 22, 'Peintres autos moto ', NULL, NULL),
(142, 4, 22, 'Régleurs de parallélisme ', NULL, NULL),
(143, 4, 22, 'Réparateur et mécanicien de cyclomoteurs ', NULL, NULL),
(144, 4, 22, 'Réparateurs de matériels de transport fluvial et naval ', NULL, NULL),
(145, 4, 22, 'Réparateurs de par brise et de phare ', NULL, NULL),
(146, 4, 22, 'Réparateurs de plastiques de véhicules et de cyclomoteurs ', NULL, NULL),
(147, 4, 22, 'Réparateurs de vélos ', NULL, NULL),
(148, 4, 22, 'Réparateurs et mécaniciens de véhicules ', NULL, NULL),
(149, 4, 22, 'Spécialistes de casse-auto', NULL, NULL),
(150, 4, 22, 'Spécialistes de pompes injection ', NULL, NULL),
(151, 4, 22, 'Vulcanisateurs', NULL, NULL),
(152, 4, 23, 'Chargeurs des produits extraits dans les carrières ', NULL, NULL),
(153, 4, 23, 'Conducteurs d’animaux de transport ', NULL, NULL),
(154, 4, 23, 'Conducteurs de pirogues et de barques ', NULL, NULL),
(155, 4, 23, 'Conducteurs de taxis motos / charrette / tricycles/ quadricycle ', NULL, NULL),
(156, 4, 23, 'Conducteurs de taxis vélos ', NULL, NULL),
(157, 4, 23, 'Déménageurs ', NULL, NULL),
(158, 4, 23, 'Eboueurs ', NULL, NULL),
(159, 4, 23, 'Porteurs de bagages(Dockers/bagagistes/portefaix/manutentionnaires) ', NULL, NULL),
(160, 4, 24, 'Dépanneurs radio, télévision et chaîne Hi-Fi ', NULL, NULL),
(161, 4, 24, 'Electroniciens ', NULL, NULL),
(162, 4, 24, 'Fabricants et réparateurs de machines-outils', NULL, NULL),
(163, 4, 24, 'Fabricants et réparateurs de cœurs de foyers améliorés ', NULL, NULL),
(164, 4, 24, 'Fabricants et réparateurs de petits outillages ', NULL, NULL),
(165, 4, 24, 'Fabricants, monteurs de composants électroniques ', NULL, NULL),
(166, 4, 24, 'Horlogers ', NULL, NULL),
(167, 4, 24, 'Installateurs de matériels de sécurité et de télésurveillance ', NULL, NULL),
(168, 4, 24, 'Installateurs et main tenanciers de matériels informatiques ', NULL, NULL),
(169, 4, 24, 'Installateurs et main tenanciers de panneaux solaires ', NULL, NULL),
(170, 4, 24, 'Laveurs autos, motos, moquettes ', NULL, NULL),
(171, 4, 24, 'Mécanographes ', NULL, NULL),
(172, 4, 24, 'Poseurs et réparateurs de serrures électroniques ', NULL, NULL),
(173, 4, 24, 'Réparateurs d’équipement de communication ', NULL, NULL),
(174, 4, 24, 'Réparateurs d’ordinateurs et d’équipements périphériques ', NULL, NULL),
(175, 4, 24, 'Réparateurs de gazinières ', NULL, NULL),
(176, 4, 24, 'Réparateurs de machines à broder', NULL, NULL),
(177, 4, 24, 'Réparateurs de machines à coudre et à surfiler ', NULL, NULL),
(178, 4, 24, 'Réparateurs de machines diverses ', NULL, NULL),
(179, 4, 24, 'Réparateurs de téléphones portables  ', NULL, NULL),
(180, 4, 24, 'Serruriers ', NULL, NULL),
(181, 4, 24, 'Techniciens en réseau ', NULL, NULL),
(182, 4, 25, 'Frigoristes ', NULL, NULL),
(183, 4, 25, 'Installateurs et réparateurs de fours à pain  ', NULL, NULL),
(184, 4, 25, 'Rebobineurs ', NULL, NULL),
(185, 4, 25, 'Réparateurs de chauffe-eau et autres appareils électriques  ', NULL, NULL),
(186, 4, 25, 'Réparateurs de climatiseurs ', NULL, NULL),
(187, 4, 25, 'Réparateurs de machines à laver ', NULL, NULL),
(188, 4, 25, 'Réparateurs de micro-onde ', NULL, NULL),
(189, 4, 25, 'Réparateurs de ventilateurs ', NULL, NULL),
(190, 4, 25, 'Spécialistes de froid et climatisation', NULL, NULL),
(191, 5, 27, 'Brossiers ', NULL, NULL),
(192, 5, 27, 'Bûcherons ', NULL, NULL),
(193, 5, 27, 'Charbonniers ', NULL, NULL),
(194, 5, 27, 'Constructeurs de pirogues et autres embarcations ', NULL, NULL),
(195, 5, 27, 'Ebénistes ', NULL, NULL),
(196, 5, 27, 'Fabricants de manches ou support d’outils ', NULL, NULL),
(197, 5, 27, 'Fabricants de mortiers et accessoires ', NULL, NULL),
(198, 5, 27, 'Machinistes en menuiserie bois ', NULL, NULL),
(199, 5, 27, 'Menuisiers ', NULL, NULL),
(200, 5, 27, 'Cordiers ', NULL, NULL),
(201, 5, 27, 'Extracteurs de traiteurs de raphia ', NULL, NULL),
(202, 5, 27, 'Fabricants d’articles en pailles et d’autres sparteries ', NULL, NULL),
(203, 5, 27, 'Menuisiers sur bambous et rônier ', NULL, NULL),
(204, 5, 27, 'Menuisiers sur rosiers', NULL, NULL),
(205, 5, 27, 'Menuisier sur rotin ', NULL, NULL),
(206, 5, 27, 'Nattiers ', NULL, NULL),
(207, 5, 27, 'Vanniers', NULL, NULL),
(208, 6, 28, 'Fabricants de filets de pêche ', NULL, NULL),
(209, 6, 28, 'Fabricants de macramés ', NULL, NULL),
(210, 6, 28, 'Fileurs ', NULL, NULL),
(211, 6, 28, 'Tisserands', NULL, NULL),
(212, 6, 29, 'Brodeurs à main ', NULL, NULL),
(213, 6, 29, 'Brodeurs ', NULL, NULL),
(214, 6, 29, 'Costumiers ', NULL, NULL),
(215, 6, 29, 'Fabricants d’articles à mailles et d’autres textiles ', NULL, NULL),
(216, 6, 29, 'Fabricants d’objets et accessoires en tissu ', NULL, NULL),
(217, 6, 29, 'Fabricants de batik ', NULL, NULL),
(218, 6, 29, 'Matelassiers ', NULL, NULL),
(219, 6, 29, 'Modélistes-stylistes', NULL, NULL),
(220, 6, 29, 'Tailleurs / couturiers ', NULL, NULL),
(221, 6, 29, 'Teinturiers', NULL, NULL),
(222, 6, 29, 'Tricoteurs ', NULL, NULL),
(223, 6, 29, 'Bottiers et selliers ', NULL, NULL),
(224, 6, 29, 'Cireurs et arrangeurs de chaussures ', NULL, NULL),
(225, 6, 29, 'Cordonniers ', NULL, NULL),
(226, 6, 29, 'Graveurs sur cuirs ', NULL, NULL),
(227, 6, 29, 'Maroquiniers ', NULL, NULL),
(228, 6, 29, 'Tanneurs ', NULL, NULL),
(229, 6, 29, 'Tapissiers ', NULL, NULL),
(230, 6, 29, 'Taxidermistes', NULL, NULL),
(231, 7, 32, 'Cameraman ', NULL, NULL),
(232, 7, 32, 'Encadreurs ', NULL, NULL),
(233, 7, 32, 'Graveurs ', NULL, NULL),
(234, 7, 32, 'Imprimeurs', NULL, NULL),
(235, 7, 32, 'Photographes ', NULL, NULL),
(236, 7, 32, 'Régisseurs de son ', NULL, NULL),
(237, 7, 32, 'Régisseurs de lumière ', NULL, NULL),
(238, 7, 32, 'Spécialistes de traitement d’images photographiques ', NULL, NULL),
(239, 7, 32, 'Techniciens de laboratoire photos ', NULL, NULL),
(240, 7, 32, 'Electriciens cinéma ', NULL, NULL),
(241, 7, 32, 'Installateurs/réparateurs de matériel audiovisuel  ', NULL, NULL),
(242, 7, 32, 'Installateurs/réparateurs de matériels cinématographiques  ', NULL, NULL),
(243, 7, 32, 'Installateurs/réparateurs de matériel de télécommunication et assimilés ', NULL, NULL),
(244, 7, 32, 'Installateurs/réparateurs de matériel et équipement photographiques ', NULL, NULL),
(245, 7, 32, 'Réparateurs d’appareils photographiques et caméras ', NULL, NULL),
(246, 8, 33, 'Coiffeurs ', NULL, NULL),
(247, 8, 33, 'Tresseurs modernes ', NULL, NULL),
(248, 8, 33, 'Tresseurs traditionnels', NULL, NULL),
(249, 8, 35, 'Techniciens de laboratoire photos ', NULL, NULL),
(250, 8, 35, 'Fabricants d’huiles essentielles', NULL, NULL),
(251, 8, 35, 'Fabricants de bougies ', NULL, NULL),
(252, 8, 35, 'Fabricants de cosmétiques et assimilés ', NULL, NULL),
(253, 8, 35, 'Fabricants de parfum et produits chimiques ', NULL, NULL),
(254, 8, 35, 'Fabricants de savons ', NULL, NULL),
(255, 8, 35, 'Circonciseurs', NULL, NULL),
(256, 8, 35, 'Esthéticiens ', NULL, NULL),
(257, 8, 35, 'Préparateurs de pharmacopée traditionnelle ', NULL, NULL),
(258, 8, 35, 'Soignants traditionnels de fractures ', NULL, NULL),
(259, 8, 35, 'Spécialistes de soins de beauté ', NULL, NULL),
(260, 8, 35, 'Tatoueurs', NULL, NULL),
(261, 8, 37, 'Fabricants de matériels orthopédiques ', NULL, NULL),
(262, 8, 37, 'Fabricants de prothèse dentaire ', NULL, NULL),
(263, 8, 37, 'Auxiliaires de maison ', NULL, NULL),
(264, 8, 37, 'Blanchisseurs ', NULL, NULL),
(265, 8, 37, 'Embaumeurs ', NULL, NULL),
(266, 8, 37, 'Installateurs de chapelles ardentes', NULL, NULL),
(267, 8, 37, 'Spécialistes de l’entretien de dépouilles mortelles ', NULL, NULL),
(268, 8, 37, 'Spécialiste de nettoyage courant de locaux et autres services de nettoyage ', NULL, NULL),
(269, 8, 37, 'Spécialiste de pressing ', NULL, NULL),
(270, 8, 37, 'Spécialistes de traitement et élimination des déchets', NULL, NULL),
(271, 9, 40, 'Armuriers (fabricants de fusils traditionnels) ', NULL, NULL),
(272, 9, 40, 'Bijoutiers en autres matières ', NULL, NULL),
(273, 9, 40, 'Bronziers ', NULL, NULL),
(274, 9, 40, 'Ferronniers d art ', NULL, NULL),
(275, 9, 40, 'Joailliers ', NULL, NULL),
(276, 9, 40, 'Orfèvres ', NULL, NULL),
(277, 9, 40, 'Fabricants d’instruments de musique ', NULL, NULL),
(278, 9, 40, 'Fabricants d’objets d’ornements divers ', NULL, NULL),
(279, 9, 40, 'Fabricants de cachets', NULL, NULL),
(280, 9, 40, 'Fabricants de flèches et accessoires ', NULL, NULL),
(281, 9, 40, 'Fabricants de jeux et jouets ', NULL, NULL),
(282, 9, 40, 'Fabricants d’objets divers à base du bois ', NULL, NULL),
(283, 9, 40, 'Sculpteurs et décorateurs sur tous matériaux ', NULL, NULL),
(284, 9, 40, 'Teinturiers ', NULL, NULL),
(285, 9, 40, 'Céramistes ', NULL, NULL),
(286, 9, 40, 'Constructeurs de hauts reliefs  ', NULL, NULL),
(287, 9, 40, 'Fabricants de foyers améliorés ', NULL, NULL),
(288, 9, 40, 'Potiers ', NULL, NULL),
(289, 9, 40, 'Restaurateurs de bas-reliefs ', NULL, NULL),
(290, 9, 40, 'Restaurateurs de murailles des palais royaux ', NULL, NULL),
(291, 9, 40, 'Verriers et autres objets d’arts', NULL, NULL),
(292, 9, 41, 'Aménagistes ', NULL, NULL),
(293, 9, 41, 'Calligraphes ', NULL, NULL),
(294, 9, 41, 'Créateurs d’espaces verts ', NULL, NULL),
(295, 9, 41, 'Décorateurs des véhicules et de lieux ', NULL, NULL),
(296, 9, 41, 'Décorateurs sur vitre ', NULL, NULL),
(297, 9, 41, 'Dessinateurs ', NULL, NULL),
(298, 9, 41, 'Fabricants d’aquarium ', NULL, NULL),
(299, 9, 41, 'Fabricants d’objets de décoration d’intérieur ', NULL, NULL),
(300, 9, 41, 'Fleuristes ', NULL, NULL),
(301, 9, 41, 'Jardiniers ', NULL, NULL),
(302, 9, 41, 'Ornemanistes ', NULL, NULL),
(303, 9, 41, 'Paysagistes ', NULL, NULL),
(304, 9, 41, 'Peintre-calligraphes ', NULL, NULL),
(305, 9, 41, 'Peintre-dessinateurs ', NULL, NULL),
(306, 9, 41, 'Peintre-décorateurs, portraitistes ', NULL, NULL),
(307, 9, 41, 'Portraitistes d’arts plastiques ', NULL, NULL),
(308, 9, 41, 'Pyrograveurs ', NULL, NULL),
(309, 9, 41, 'Scénographes ', NULL, NULL),
(310, 9, 41, 'Sérigraphes ', NULL, NULL),
(311, 9, 41, 'Spécialistes en art floral', NULL, NULL),
(312, 9, 41, 'Spécialistes en art graphique', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2024_01_15_085407_create_braches_table', 1),
(7, '2024_01_15_085425_create_corps_table', 1),
(8, '2024_01_15_085434_create_metiers_table', 1),
(9, '2024_01_15_085448_create_demandes_table', 1),
(10, '2024_01_15_090514_create_departements_table', 1),
(11, '2024_01_15_090527_create_communes_table', 1),
(12, '2024_01_16_055132_create_sessions_table', 1),
(13, '2024_02_01_160355_create_contacts_table', 1),
(14, '2024_06_20_105017_add_default_user', 1),
(15, '2024_06_20_120000_create_demande_localisations_table', 1),
(16, '2025_11_18_193620_add_post_appui_columns_to_demandes_table', 2),
(17, '2025_11_24_174135_add_date_approbation_to_demandes_table', 3),
(19, '2025_11_25_103051_add_date_transmission_to_demandes_table', 4),
(20, '2025_11_26_000000_change_date_depot_rapport_to_datetime_in_demandes_table', 5),
(21, '2025_11_25_133101_add_archive_fields_to_demandes_table', 6),
(22, '2025_11_26_073105_create_demandes_clotures_table', 7),
(23, '2025_11_26_073934_create_demande_localisations_clotures_table', 7),
(24, '2025_11_26_093305_remove_femme_touche_from_demande_localisations_clotures', 8),
(25, '2025_11_26_162727_make_lieux_nullable_in_demande_localisations_table', 9),
(26, '2025_11_27_103145_add_role_to_users_table', 10);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('0FpCAxRyOVON4TcQBe1XwYkKncY8T5HOCmWAWYdg', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaDU0V1F0MGwwenhUaFRnbFg5bzY0UjJ6WWFDeG1VUm00OWxhdnBsZCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9mb3JtdWxhaXJlIjt9fQ==', 1764243371),
('5gSzuG0xkbgQy6ghnVCmjlfpMBGEcALDriULX54Y', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiaXh2VUlsZjNJZjA0MjVYNUg1Sll3ME9HbXU2RUdOb1J4UVh3VUVhMSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zdGF0aXN0aXF1ZXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO3M6NDoiYXV0aCI7YToxOntzOjIxOiJwYXNzd29yZF9jb25maXJtZWRfYXQiO2k6MTc2NDE1MDcwNzt9czoyMToicGFzc3dvcmRfaGFzaF9zYW5jdHVtIjtzOjYwOiIkMnkkMTAkVkFoVUJoR3BSNUp1L0t3WU1qUWFhT21JRDZHUklYQU5zL0pkL0VKazBEaHk3LmMxTkFIWm0iO30=', 1764162844),
('sguAleWq1l7decb99MwkqaOkpwZSrf94urHkBwZm', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiZ0NGTk8wU3N4TWZ4andKUHZNaUZXOWJIeG0ySjZRdFdxdFNaaDFlbyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czo0OiJhdXRoIjthOjE6e3M6MjE6InBhc3N3b3JkX2NvbmZpcm1lZF9hdCI7aToxNzY0MTQ4ODkyO31zOjIxOiJwYXNzd29yZF9oYXNoX3NhbmN0dW0iO3M6NjA6IiQyeSQxMCRVUE9tWTgveUZ6cFdEZm5VbVhham91clEucEtQOWFHNS5WR1gwYmptSVkzV3M4bnVOS3ZDdSI7czo1OiJhbGVydCI7YTowOnt9fQ==', 1764243314),
('WftIZDa5dPIsuXyY9NWBWSB4jBXTy9EZM5sReGr2', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoidG1adDA3UEI0ODBVTFJGbElXcTdiakZvNXk3ak5ZZlV4dFpuV2EzaSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ob21lIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NDtzOjQ6ImF1dGgiO2E6MTp7czoyMToicGFzc3dvcmRfY29uZmlybWVkX2F0IjtpOjE3NjQyNDE0OTc7fXM6MjE6InBhc3N3b3JkX2hhc2hfc2FuY3R1bSI7czo2MDoiJDJ5JDEwJE9MSmdORmIxUXN1Z01BUndFbUwzMS5FdTA2MHM2TS94UXNlRlVHMW9SU3AuajBLeVlreE5tIjt9', 1764243332);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'client',
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `code`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
(1, 'SESE FDA', 'sese@gmail.com', 'verificateur', NULL, NULL, '$2y$10$UPOmY8/yFzpWDfnUmXajourQ.pKP9aG5.VGX0bjmIY3Ws8nuNKvCu', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'SPEA FDA', 'spea@gmail.com', 'directeur', NULL, NULL, '$2y$10$VAhUBhGpR5Ju/KwYMjQaaOmID6GRIXANs/Jd/EJk0Dhy7.c1NAHZm', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'DG FDA', 'dg@gmail.com', 'directeur', NULL, NULL, '$2y$10$agfBgurWrYJCv2MlfDpuvOlOPJ2d/CJPH7iLiS3OcT4F307r8MIqO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'DAF FDA', 'daf@gmail.com', 'directeur', NULL, NULL, '$2y$10$OLJgNFb1QsugMARwEmL31.Eu060s6M/xQseFUG1oRSp.j0KyYkxNm', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'DO FDA', 'do@gmail.com', 'verificateur', NULL, NULL, '$2y$10$EOFjxCmlcBbl/7aIgo9EM.7qk78iTLv1eoUUG37zB1qQ8U9zBCn.y', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'Secrétaire FDA', 'secretaire@gmail.com', 'secretaire', NULL, NULL, '$2y$10$5Sbdb69OX90US73CsHQ8LeL7hK65uXegAtGru7yBFFHcYr/.Sv2Z6', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-25 08:41:29', '2025-11-25 08:41:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `braches`
--
ALTER TABLE `braches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `communes`
--
ALTER TABLE `communes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `communes_departement_id_foreign` (`departement_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `corps`
--
ALTER TABLE `corps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `corps_branche_id_foreign` (`branche_id`);

--
-- Indexes for table `demandes`
--
ALTER TABLE `demandes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `demandes_clotures`
--
ALTER TABLE `demandes_clotures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `demandes_clotures_annee_exercice_cloture_index` (`annee_exercice_cloture`),
  ADD KEY `demandes_clotures_demande_id_original_index` (`demande_id_original`);

--
-- Indexes for table `demande_localisations`
--
ALTER TABLE `demande_localisations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `demande_localisations_demande_id_foreign` (`demande_id`),
  ADD KEY `demande_localisations_departement_id_foreign` (`departement_id`),
  ADD KEY `demande_localisations_commune_id_foreign` (`commune_id`);

--
-- Indexes for table `demande_localisations_clotures`
--
ALTER TABLE `demande_localisations_clotures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `demande_localisations_clotures_departement_id_foreign` (`departement_id`),
  ADD KEY `demande_localisations_clotures_commune_id_foreign` (`commune_id`),
  ADD KEY `demande_localisations_clotures_demande_cloture_id_index` (`demande_cloture_id`),
  ADD KEY `demande_localisations_clotures_demande_id_original_index` (`demande_id_original`);

--
-- Indexes for table `departements`
--
ALTER TABLE `departements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `metiers`
--
ALTER TABLE `metiers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `metiers_branche_id_foreign` (`branche_id`),
  ADD KEY `metiers_corp_id_foreign` (`corp_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `braches`
--
ALTER TABLE `braches`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `communes`
--
ALTER TABLE `communes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `corps`
--
ALTER TABLE `corps`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `demandes`
--
ALTER TABLE `demandes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `demandes_clotures`
--
ALTER TABLE `demandes_clotures`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=229;

--
-- AUTO_INCREMENT for table `demande_localisations`
--
ALTER TABLE `demande_localisations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `demande_localisations_clotures`
--
ALTER TABLE `demande_localisations_clotures`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT for table `departements`
--
ALTER TABLE `departements`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `metiers`
--
ALTER TABLE `metiers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=313;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `communes`
--
ALTER TABLE `communes`
  ADD CONSTRAINT `communes_departement_id_foreign` FOREIGN KEY (`departement_id`) REFERENCES `departements` (`id`);

--
-- Constraints for table `corps`
--
ALTER TABLE `corps`
  ADD CONSTRAINT `corps_branche_id_foreign` FOREIGN KEY (`branche_id`) REFERENCES `braches` (`id`);

--
-- Constraints for table `demande_localisations`
--
ALTER TABLE `demande_localisations`
  ADD CONSTRAINT `demande_localisations_commune_id_foreign` FOREIGN KEY (`commune_id`) REFERENCES `communes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `demande_localisations_demande_id_foreign` FOREIGN KEY (`demande_id`) REFERENCES `demandes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `demande_localisations_departement_id_foreign` FOREIGN KEY (`departement_id`) REFERENCES `departements` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `demande_localisations_clotures`
--
ALTER TABLE `demande_localisations_clotures`
  ADD CONSTRAINT `demande_localisations_clotures_commune_id_foreign` FOREIGN KEY (`commune_id`) REFERENCES `communes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `demande_localisations_clotures_demande_cloture_id_foreign` FOREIGN KEY (`demande_cloture_id`) REFERENCES `demandes_clotures` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `demande_localisations_clotures_departement_id_foreign` FOREIGN KEY (`departement_id`) REFERENCES `departements` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `metiers`
--
ALTER TABLE `metiers`
  ADD CONSTRAINT `metiers_branche_id_foreign` FOREIGN KEY (`branche_id`) REFERENCES `braches` (`id`),
  ADD CONSTRAINT `metiers_corp_id_foreign` FOREIGN KEY (`corp_id`) REFERENCES `corps` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
