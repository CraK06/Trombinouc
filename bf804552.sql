-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 12 juin 2019 à 11:03
-- Version du serveur :  5.7.24
-- Version de PHP :  7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `bf804552`
--

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `id_C` int(11) NOT NULL AUTO_INCREMENT,
  `_id` int(11) NOT NULL,
  `_id_P` int(11) NOT NULL,
  `reponse_C` text NOT NULL,
  `date_C` text NOT NULL,
  `time_C` text NOT NULL,
  PRIMARY KEY (`id_C`)
) ENGINE=MyISAM AUTO_INCREMENT=133 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `publication`
--

DROP TABLE IF EXISTS `publication`;
CREATE TABLE IF NOT EXISTS `publication` (
  `id_P` int(11) NOT NULL AUTO_INCREMENT,
  `_id` int(11) NOT NULL,
  `message_P` text NOT NULL,
  `date_P` text,
  `time_P` text NOT NULL,
  PRIMARY KEY (`id_P`)
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `publication`
--

INSERT INTO `publication` (`id_P`, `_id`, `message_P`, `date_P`, `time_P`) VALUES
(55, 1, 'bonjour', '12/06/19', '11:05:37');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `amis` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `nom`, `prenom`, `age`, `mail`, `mdp`, `amis`) VALUES
(10, 'DARLET', 'Marc', 19, 'marc.darlet@gmail.com', '$2y$10$hpS06vWJpROyPXx8.EZtpesNxs388qZVUSY7js.wLr51GdPYlnIru', 1),
(1, 'BOURDENET', 'Florian', 18, 'florian.bourdenet@gmail.com', '$2y$10$K7D.OdJG.xxkpfxJRylgLumBmdtLxiWPwSY9rZTrm0b6qnZqqjkKK', 1),
(11, 'LUCZAK', 'Alexis', 18, 'alexis.luczak@gmail.com', '$2y$10$SwZrD7icBaTnvjzMg5f6Zu5iqAfZiEA37WBEVrOb1KJyo2QIqqu3y', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
