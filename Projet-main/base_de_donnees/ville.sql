-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 22 jan. 2025 à 21:48
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `appli_tourisme`
--

-- --------------------------------------------------------

--
-- Structure de la table `ville`
--

CREATE TABLE `ville` (
  `id` int(11) NOT NULL DEFAULT 0,
  `nom` varchar(255) NOT NULL,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ville`
--

INSERT INTO `ville` (`id`, `nom`, `latitude`, `longitude`) VALUES
(1, 'Paris', 48.8566, 2.3522),
(2, 'Marseille', 43.2965, 5.3698),
(3, 'Lyon', 45.764, 4.8357),
(4, 'Toulouse', 43.6047, 1.4442),
(5, 'Nice', 43.7102, 7.262),
(6, 'Bordeaux', 44.8378, -0.5792),
(7, 'Nantes', 47.2184, -1.5536),
(8, 'Strasbourg', 48.5734, 7.7521),
(9, 'Montpellier', 43.6108, 3.8767),
(10, 'Rennes', 48.1173, -1.6778),
(11, 'Lille', 50.6292, 3.0573),
(12, 'Le Havre', 49.4944, 0.1079),
(13, 'Reims', 49.2583, 4.0317),
(14, 'Toulon', 43.1242, 5.928),
(15, 'Grenoble', 45.1885, 5.7245),
(16, 'Dijon', 47.322, 5.0415),
(17, 'Angers', 47.4784, -0.5632),
(18, 'Nîmes', 43.8367, 4.3601),
(19, 'Saint-Étienne', 45.4397, 4.3872),
(20, 'Clermont-Ferrand', 45.7772, 3.087),
(21, 'Le Mans', 48.0061, 0.1996),
(22, 'Aix-en-Provence', 43.5297, 5.4474),
(23, 'Brest', 48.3904, -4.4861),
(24, 'Limoges', 45.8336, 1.2611),
(25, 'Tours', 47.3941, 0.6848),
(26, 'Amiens', 49.8941, 2.2957),
(27, 'Perpignan', 42.6886, 2.8948),
(28, 'Metz', 49.1193, 6.1757),
(29, 'Besançon', 47.2378, 6.0241),
(30, 'Orléans', 47.9024, 1.909),
(31, 'Rouen', 49.4432, 1.0999),
(32, 'Mulhouse', 47.7508, 7.3359),
(33, 'Caen', 49.1829, -0.3707),
(34, 'Nancy', 48.6921, 6.1844),
(35, 'Annecy', 45.8992, 6.1296),
(36, 'Pau', 43.2951, -0.3708),
(37, 'Versailles', 48.8014, 2.1301),
(38, 'Orléans', 47.9024, 1.909),
(39, 'Saint-Denis', 48.9362, 2.3574);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
