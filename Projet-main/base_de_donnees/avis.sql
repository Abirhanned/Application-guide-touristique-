-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2025 at 04:22 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `appli_tourisme`
--

-- --------------------------------------------------------

--
-- Table structure for table `avis`
--

CREATE TABLE `avis` (
  `nom` varchar(1000) NOT NULL,
  `id` varchar(11) NOT NULL,
  `date` date NOT NULL,
  `note` int(10) NOT NULL,
  `avis` varchar(2083) NOT NULL,
  `pseudo` varchar(1000) NOT NULL,
  `type` varchar(1000) NOT NULL,
  `code_postal` int(10) NOT NULL,
  `ville` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `avis`
--

INSERT INTO `avis` (`nom`, `id`, `date`, `note`, `avis`, `pseudo`, `type`, `code_postal`, `ville`) VALUES
('musée du Pays de Hanau - histoire et vies d’un territoire', 'M0003', '2025-01-25', 4, 'Pas mal! Si vous passez dans le coin, très bon musée à visiter', 'Fan2histoire', 'musees', 67330, 'Bouxwiller'),
('musée du Pays de Hanau - histoire et vies d’un territoire', 'M0003', '2025-01-10', 3, 'Pas aussi enthousiaste que fan2musee, mais c\'était sympa quand meme !', 'adeptededecouverte', 'musees', 67330, 'Bouxwiller'),
('Chambres d\'Hôtes Chateau des Noces', '6', '2025-01-01', 1, 'Pire expérience de ma vie! Fuyez cet établissement coute que coute', 'bigHater', 'Hotel', 85014, 'Bazoges-en-Pareds'),
('Jardin des sculptures', '6', '2025-01-24', 4, 'Magnifiques sculture. A voir si vous passez dans le coin.', 'MonsieurPof', 'Jardin', 76780, ''),
('Kimchi (75102)', '55553', '2025-01-29', 5, 'Très bon! Je pref ceux de ma maman et de Jimin mais ce sont surement les 3èmes meilleurs kimchis du monde!', 'JK97', 'Restaurant', 75102, 'Paris 2e Arrondissement'),
('Kimchi (75102)', '55553', '2025-01-24', 5, 'jai vu mon idole dans le restau omg, ca ne peut etre que bien', 'fan2kpop', 'Restaurant', 75102, 'Paris 2e Arrondissement'),
('Quick (30189)', '234', '2025-01-09', 4, 'quick, fast, and good ', 'unmonsieurgentil', 'Restaurant', 30189, 'Nîmes'),
('Ibis Budget (2)', '80', '2025-01-23', 4, 'super experience à prix reduit en plus, foncez !!', 'Sylvie81', 'Hotel', 2, 'Ajaccio'),
('Ibis Budget (2)', '80', '2025-01-31', 3, 'sympa', 'mickeyMousedeCorse', 'Hotel', 2, 'Ajaccio'),
('Hôtel Vol de Nuit – Ibis Styles Paris Vélizy (78640)', '148', '2025-01-02', 3, 'sympathique et assez classe', 'lifelover212', 'Hotel', 78640, 'Vélizy-Villacoublay'),
('Les Fermes du Château (43211)', '7', '2025-01-17', 2, 'sympathique, tres bien pour s\'isoler un peu du bruit de la ville', 'unGarsHeureux', 'Hotel', 43211, 'Saint-Maurice-de-Lignon'),
('Parc du château d’Arlay et jardin des jeux', '10', '2025-01-15', 3, 'bien.', 'PierreDePokemon', 'Jardin', 39140, 'Arlay'),
('Le Grand Jardin d\'Elisabeth (84065)', '21', '2025-01-29', 5, 'Meilleure experience de ma vie !', 'Imane', 'Hotel', 84065, 'Lauris'),
('Le Grand Jardin d\'Elisabeth (84065)', '21', '2025-01-30', 4, 'Pas autant aimé que ma soeur mais c\'était cool', 'Nawal', 'Hotel', 84065, 'Lauris'),
('Jardin du Moulin Jaune', '17', '2025-01-28', 3, 'pas si jaune que ça le moulin !', 'jemlanatur', 'Jardin', 77580, 'Crécy-la-Chapelle'),
('Jardin du Moulin Jaune', '17', '2025-01-29', 5, 'si il etait bien jaune !', '+granfandenatur', 'Jardin', 77580, 'Crécy-la-Chapelle'),
('musée du Louvre', 'M5031', '2025-01-30', 5, 'Je me suis vu omg !', 'LouisXIV', 'musees', 75058, 'Paris'),
('musée du Louvre', 'M5031', '2025-01-30', 5, 'Je me suis vu omg !', 'LouisXIV', 'musees', 75058, 'Paris'),
('Gîte Saint-Claude (42132)', '5', '2025-01-28', 2, 'peut mieux faire, accueil peu aimable', 'moi', 'Hotel', 42132, 'Malleval'),
('Les Fermes du Château (43211)', '7', '2025-01-04', 4, 'Tres belles fermes a voir depuis le sublime balcon carré', 'BobLaServiette', 'Hotel', 43211, 'Saint-Maurice-de-Lignon'),
('Jardin botanique de la Villa Thuret', '13', '2025-01-21', 5, 'Ca change des paysages de Beaubatons et poudlard!', 'fleurPotter', 'Jardin', 6160, 'Antibes'),
('Palais du Louvre et Jardin des Tuileries', '16', '2025-01-31', 5, 'Ma femme n\'est pas d\'accord mais ce jardin est bien mieux!', 'billWeasleyDelacour', 'Jardin', 75001, 'Paris'),
('Le Gourmandîne (17161)', '6', '2025-01-21', 1, 'Je prefererai marrier Jabba que retourner ici !', 'JeunePadawan', 'Restaurant', 17161, 'La Flotte'),
('musée Oberlin', 'M0021', '2025-01-27', 4, 'tres moderne.', 'plusvieuxquelaprehistoire', 'musees', 67130, 'Waldersbach'),
('musée de la Folie Marco', 'M0001', '2025-01-14', 2, 'Je croyais qu\'il s\'appelait musée de la Folie Marco !', 'itsmeMariooo', 'musees', 67140, 'Barr'),
('Heat\'s (94041)', '6529', '2025-01-27', 5, 'Tahial jazail', 'Heal', 'Restaurant', 94041, 'Ivry-sur-Seine'),
('Les Saveurs du Maroc (92012)', '4956', '2025-01-22', 4, 'miammm', 'Abir', 'Restaurant', 92012, 'Boulogne-Billancourt'),
('musée alsacien', 'M0004', '2025-01-28', 3, 'sympa', 'noemie', 'musees', 67500, 'Haguenau'),
('Pidélice (54395)', '116933', '2025-01-29', 5, 'Tout était trop bon. Bon acceuil, bon emplacement et plats délicieux!', 'Maman', 'Restaurant', 54395, 'Nancy'),
('Quick (54395)', '88688', '2025-01-29', 4, 'Plutot bon!', 'Kirito', 'Restaurant', 54395, 'Nancy'),
('Quick (54395)', '88688', '2025-01-30', 1, 'nul', 'fandeKFC', 'Restaurant', 54395, 'Nancy'),
('Quick (54395)', '88688', '2025-01-30', 4, 'Bien', 'manel', 'Restaurant', 54395, 'Nancy');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
