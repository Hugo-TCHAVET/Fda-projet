-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 20, 2025 at 12:21 PM
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
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `titre_activite` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `obejectif_activite` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `debut_activite` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fin_activite` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dure_activite` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `departement` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `commune` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lieux` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `homme_touche` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `budget` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `piece` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `buget_prevu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `rapport_depose` tinyint(1) NOT NULL DEFAULT '0',
  `effectif_homme_forme` int DEFAULT NULL,
  `effectif_femme_forme` int DEFAULT NULL,
  `date_depot_rapport` date DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'En attente',
  `statut` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statuts` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valide` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `suspendre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `rejeter` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `demandes`
--

INSERT INTO `demandes` (`id`, `code`, `structure`, `service`, `type_demande`, `branche`, `corps`, `metier`, `nom`, `prenom`, `sexe`, `ifu`, `contact`, `titre_activite`, `obejectif_activite`, `debut_activite`, `fin_activite`, `dure_activite`, `departement`, `commune`, `lieux`, `homme_touche`, `budget`, `piece`, `buget_prevu`, `rapport_depose`, `effectif_homme_forme`, `effectif_femme_forme`, `date_depot_rapport`, `status`, `statut`, `statuts`, `valide`, `suspendre`, `rejeter`, `message`, `created_at`, `updated_at`) VALUES
(1, 'G76-PEOK-XMPD-OZXL', 'ert', 'Assistance', 'professionnel', '2', '41', '300', 'ZERT', 'erty', 'Masculin', '1234565432123', '234567', 'ZERTY', 'ZERTY', '2025-11-19', '2025-11-20', '1', '4', '43', 'HOPITAL', '10', '1000000', 'piece/NgE32zeTqMLsxghYP5Eb3iFjPuSbX6GnbPkUZliP.pdf', '500000', 1, 100, 20, '2025-11-20', 'En attente', 'En cours de traitement', 'Approuvé', '2', '0', '0', NULL, '2025-11-20 22:43:33', '2025-11-20 11:20:50'),
(2, 'O78-GSJN-YOPL-KCPG', 'A', 'Financier', 'structure', '2', '41', '306', 'ZERT', 'Z', 'Masculin', '34321235', '34567', 'ZER', 'ERT', '2025-11-13', '2025-11-20', '7', '10', '36', '3', '3', '250000', 'piece/KQ9uP2q231ZH4bvKFn0OFWN2KEGL3SXotwTJayeB.pdf', '200000', 0, NULL, NULL, NULL, 'En attente', 'En cours de traitement', 'Approuvé', '2', '0', '0', NULL, '2025-11-20 23:55:00', '2025-11-21 04:11:16'),
(3, 'X81-YFAZ-POXW-KBDZ', 'n', 'Assistance', 'professionnel', '', '', '', 'n', 'n', 'Masculin', '1234', '2345', 'U', 'ERTY', '2025-11-21', '2025-11-23', '2', '10', '36', 'SALLE DES JEUNES', '5', '150000', 'piece/l7Pmgu9UJb9x6qJ7xPOmn6Ok3joxmfu8FH2mUjla.pdf', '10000', 0, NULL, NULL, NULL, 'En attente', 'En cours de traitement', 'Approuvé', '2', '0', '0', NULL, '2025-11-21 00:47:24', '2025-11-21 04:10:56'),
(4, 'M93-FIJP-DESJ-BNFX', 'h', 'Assistance', 'professionnel', '', '', '', 'h', 'Hugo', 'Féminin', '1234321234568', '234567', 'H', 'H', '2025-11-21', '2025-11-23', '2', '5', '55', 'SALLE DES ENFANTS', '50', '3456', 'piece/Q4Ir1mptf0jxYrFwiD4nat2PKsjFaV84Db7AiU2W.pdf', '1000', 0, NULL, NULL, NULL, 'En attente', 'En cours de traitement', 'Approuvé', '2', '0', '0', NULL, '2025-11-21 01:12:29', '2025-11-20 11:07:06'),
(5, 'L47-PWKO-IEUO-WVMK', 'h', 'Assistance', 'professionnel', '', '', '', 'sdfg', 'dfghj', 'Masculin', '1234321234568', '234567', 'ZER', 'TYU', '2025-11-13', '2025-11-20', '7', '8', '77', 'SALLE DES ENFANTS', '50', '250000', 'piece/5UHPZEcgXixt64lV8ODfrkRbtsJAtok1ARyRDzS4.pdf', '150000', 0, NULL, NULL, NULL, 'En attente', 'En cours de traitement', 'Approuvé', '2', '0', '0', NULL, '2025-11-21 01:15:17', '2025-11-20 11:07:14'),
(6, 'Z63-NAJU-AQBP-VSNY', 'ert', 'Assistance', 'structure', '', '', '', 'sdfg', 'dfghj', 'Masculin', '1234565432123', '234567', 'Mise à jour', 'Mise à jour de le plateforme', '2025-10-30', '2025-11-06', '7', '10', '33', 'SALLE DES ENFANTS', '50', '500000', 'piece/NaktdHr7F3odq1bnQgeOEXBQiymXl8CWKsP5JaZL.pdf', '10000', 0, NULL, NULL, NULL, 'En attente', 'En cours de traitement', 'Approuvé', '2', '0', '0', NULL, '2025-11-21 01:39:06', '2025-11-20 11:06:45'),
(7, 'X52-YNIB-EZDF-KYSD', 'zert', 'Formation', 'professionnel', '8', '', '', 'yui', 'Fanzaëlle Chancia', 'Féminin', '0234321234568', '234567', 'Mise à jour', 'rtyu', '2025-10-30', '2025-11-06', '7', '7', '4', 'HOPITAL', '20', '500000', 'piece/iHLrtLfTxmJ3DWsYihSzSxx6wHaENnKoFx0T7z0I.pdf', '0', 0, NULL, NULL, NULL, 'En attente', NULL, NULL, '0', '0', '0', NULL, '2025-11-21 02:17:36', '2025-11-21 02:17:36'),
(8, 'U06-LOPZ-AFMY-ZWHR', 'Fda', 'Assistance', 'professionnel', '', '', '', 'AKPO', 'Gérard', 'Masculin', '0987767666544', '34567', 'Mise à jour', 'Mise à jour de la plateforme', '2025-07-29', '2025-08-05', '7', '8', '75', 'DDAEP', '20', '500000', 'piece/SpQBDvBvUixooNNKzhYWmTM3PyEO88mrn0BJZ3GX.pdf', '0', 0, NULL, NULL, NULL, 'En attente', 'Suspendus', NULL, '0', '1', '0', 'Projet non prometteur', '2025-11-21 04:06:52', '2025-11-20 10:46:26'),
(9, 'M09-FNTT-NNAR-TKAU', 'ASSIRI', 'Assistance', 'structure', '8', '35', '259', 'Anicet', 'Pancras Anicet', 'Masculin', '1200901979305', '2290162012345', 'Formation en élévage de poules pondeuses', 'Formation', '2025-12-15', '2025-12-25', '10', '1', '7', 'Djèbgadji', '60', '500000', 'piece/ImXRARY1zYywFQWgcllTxvSt5WplPPV0uABUBwtL.pdf', '500000', 0, NULL, NULL, NULL, 'En attente', 'En cours de traitement', 'Approuvé', '2', '0', '0', NULL, '2025-11-20 09:58:38', '2025-11-20 10:44:15');

-- --------------------------------------------------------

--
-- Table structure for table `demande_localisations`
--

CREATE TABLE `demande_localisations` (
  `id` bigint UNSIGNED NOT NULL,
  `demande_id` bigint UNSIGNED NOT NULL,
  `departement_id` bigint UNSIGNED NOT NULL,
  `commune_id` bigint UNSIGNED NOT NULL,
  `lieux` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `homme_touche` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `demande_localisations`
--

INSERT INTO `demande_localisations` (`id`, `demande_id`, `departement_id`, `commune_id`, `lieux`, `homme_touche`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 43, 'HOPITAL', 10, '2025-11-20 22:43:33', '2025-11-20 22:43:33'),
(2, 1, 5, 55, 'MAIRIE', 12, '2025-11-20 22:43:33', '2025-11-20 22:43:33'),
(3, 2, 10, 36, '3', 3, '2025-11-20 23:55:00', '2025-11-20 23:55:00'),
(4, 3, 10, 36, 'SALLE DES JEUNES', 5, '2025-11-21 00:47:24', '2025-11-21 00:47:24'),
(5, 4, 5, 55, 'SALLE DES ENFANTS', 50, '2025-11-21 01:12:29', '2025-11-21 01:12:29'),
(6, 5, 8, 77, 'SALLE DES ENFANTS', 50, '2025-11-21 01:15:17', '2025-11-21 01:15:17'),
(7, 6, 10, 33, 'SALLE DES ENFANTS', 50, '2025-11-21 01:39:06', '2025-11-21 01:39:06'),
(8, 6, 7, 66, 'MAIRIE', 5, '2025-11-21 01:39:06', '2025-11-21 01:39:06'),
(9, 7, 7, 4, 'HOPITAL', 20, '2025-11-21 02:17:36', '2025-11-21 02:17:36'),
(10, 7, 9, 26, 'DDAEP', 5, '2025-11-21 02:17:36', '2025-11-21 02:17:36'),
(11, 8, 8, 75, 'DDAEP', 20, '2025-11-21 04:06:52', '2025-11-21 04:06:52'),
(12, 9, 1, 7, 'Djèbgadji', 60, '2025-11-20 09:58:38', '2025-11-20 09:58:38');

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
(16, '2025_11_18_193620_add_post_appui_columns_to_demandes_table', 2);

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
('IGFMXv4qFNCTNkBd9UOld5RHi1XVfyY7ep23bJdQ', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoib0VXR3J0ZHZ1T2k5MlhUd2pXT2s1eGptZVRuV1YxYnBpMVhxQ1FSRiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zdGF0aXN0aXF1ZV9zZXJ2aWNlIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjQ6ImF1dGgiO2E6MTp7czoyMToicGFzc3dvcmRfY29uZmlybWVkX2F0IjtpOjE3NjM2NTUwMDg7fXM6MjE6InBhc3N3b3JkX2hhc2hfc2FuY3R1bSI7czo2MDoiJDJ5JDEwJFVQT21ZOC95RnpwV0RmblVtWGFqb3VyUS5wS1A5YUc1LlZHWDBiam1JWTNXczhudU5LdkN1IjtzOjU6ImFsZXJ0IjthOjA6e319', 1763655082),
('l1wBISGn4lpbYCEeD8DCZuVjCWhxwdpMUlaWdO8y', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiMmx3eFUzZU82YUpENkI2MEZ2NHA4RWFuazZFRTlqckJSRzFkRjJQbyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9saXN0ZV9kZW1hbmRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjQ6ImF1dGgiO2E6MTp7czoyMToicGFzc3dvcmRfY29uZmlybWVkX2F0IjtpOjE3NjM2MzgwOTA7fXM6MjE6InBhc3N3b3JkX2hhc2hfc2FuY3R1bSI7czo2MDoiJDJ5JDEwJFZBaFVCaEdwUjVKdS9Ld1lNalFhYU9tSUQ2R1JJWEFOcy9KZC9FSmswRGh5Ny5jMU5BSFptIjtzOjU6ImFsZXJ0IjthOjA6e319', 1763639765),
('lA3VWmFhJFeGUtZsZIEV4aL0MXTkiKYSNiITF091', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoidUZRR0JqcEpmTGJzOEVrMndEVm5ackFkamY2aHo1MzBRMDNWU0xRWCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wb3N0LWFwcHVpIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjQ6ImF1dGgiO2E6MTp7czoyMToicGFzc3dvcmRfY29uZmlybWVkX2F0IjtpOjE3NjM2Mzc5MDY7fXM6MjE6InBhc3N3b3JkX2hhc2hfc2FuY3R1bSI7czo2MDoiJDJ5JDEwJFVQT21ZOC95RnpwV0RmblVtWGFqb3VyUS5wS1A5YUc1LlZHWDBiam1JWTNXczhudU5LdkN1IjtzOjU6ImFsZXJ0IjthOjA6e319', 1763641250);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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

INSERT INTO `users` (`id`, `name`, `email`, `code`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
(1, 'SESE FDA', 'sese@gmail.com', NULL, NULL, '$2y$10$UPOmY8/yFzpWDfnUmXajourQ.pKP9aG5.VGX0bjmIY3Ws8nuNKvCu', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'SPEA FDA', 'spea@gmail.com', NULL, NULL, '$2y$10$VAhUBhGpR5Ju/KwYMjQaaOmID6GRIXANs/Jd/EJk0Dhy7.c1NAHZm', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'DG FDA', 'dg@gmail.com', NULL, NULL, '$2y$10$agfBgurWrYJCv2MlfDpuvOlOPJ2d/CJPH7iLiS3OcT4F307r8MIqO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'DAF FDA', 'daf@gmail.com', NULL, NULL, '$2y$10$OLJgNFb1QsugMARwEmL31.Eu060s6M/xQseFUG1oRSp.j0KyYkxNm', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'DO FDA', 'do@gmail.com', NULL, NULL, '$2y$10$EOFjxCmlcBbl/7aIgo9EM.7qk78iTLv1eoUUG37zB1qQ8U9zBCn.y', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
-- Indexes for table `demande_localisations`
--
ALTER TABLE `demande_localisations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `demande_localisations_demande_id_foreign` (`demande_id`),
  ADD KEY `demande_localisations_departement_id_foreign` (`departement_id`),
  ADD KEY `demande_localisations_commune_id_foreign` (`commune_id`);

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `demande_localisations`
--
ALTER TABLE `demande_localisations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
-- Constraints for table `metiers`
--
ALTER TABLE `metiers`
  ADD CONSTRAINT `metiers_branche_id_foreign` FOREIGN KEY (`branche_id`) REFERENCES `braches` (`id`),
  ADD CONSTRAINT `metiers_corp_id_foreign` FOREIGN KEY (`corp_id`) REFERENCES `corps` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
