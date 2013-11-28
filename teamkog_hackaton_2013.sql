-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Jeu 28 Novembre 2013 à 17:30
-- Version du serveur: 5.5.24-log
-- Version de PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `teamkog_hackaton_2013`
--

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

CREATE TABLE IF NOT EXISTS `commentaires` (
  `idcommentaire` int(10) NOT NULL AUTO_INCREMENT,
  `idSalle` int(5) NOT NULL,
  `auteur` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `contenu` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `dateCommentaire` datetime NOT NULL,
  PRIMARY KEY (`idcommentaire`),
  KEY `idSalle` (`idSalle`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Contenu de la table `commentaires`
--

INSERT INTO `commentaires` (`idcommentaire`, `idSalle`, `auteur`, `contenu`, `dateCommentaire`) VALUES
(1, 1, 'Matt', 'Coucou', '0000-00-00 00:00:00'),
(2, 1, 'Matt', 'Coucou', '0000-00-00 00:00:00'),
(3, 1, 'Matt', 'Coucou', '0000-00-00 00:00:00'),
(4, 1, 'Matt', 'Coucou', '2013-11-28 16:34:59'),
(5, 1, 'Matt', 'Coucou2', '2013-11-28 16:37:58');

-- --------------------------------------------------------

--
-- Structure de la table `etapes`
--

CREATE TABLE IF NOT EXISTS `etapes` (
  `idEtape` int(5) NOT NULL AUTO_INCREMENT,
  `idSalle` int(10) NOT NULL,
  `destination` varchar(50) CHARACTER SET latin1 NOT NULL,
  `dateDebut` date NOT NULL,
  `dateFin` date NOT NULL,
  PRIMARY KEY (`idEtape`),
  KEY `idSalle` (`idSalle`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Contenu de la table `etapes`
--

INSERT INTO `etapes` (`idEtape`, `idSalle`, `destination`, `dateDebut`, `dateFin`) VALUES
(1, 1, 'Paris', '2013-11-28', '2013-11-29');

-- --------------------------------------------------------

--
-- Structure de la table `propositions`
--

CREATE TABLE IF NOT EXISTS `propositions` (
  `idProposition` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `idEtape` int(5) NOT NULL,
  `idTypeProposition` int(3) NOT NULL,
  `votePlus` int(5) NOT NULL,
  PRIMARY KEY (`idProposition`,`idEtape`,`idTypeProposition`),
  KEY `idEtape` (`idEtape`),
  KEY `idTypeProposition` (`idTypeProposition`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `salles`
--

CREATE TABLE IF NOT EXISTS `salles` (
  `idSalle` int(5) NOT NULL AUTO_INCREMENT,
  `nomSalle` varchar(50) CHARACTER SET latin1 NOT NULL,
  `lienSalle` varchar(200) CHARACTER SET latin1 NOT NULL,
  `dateCreation` date NOT NULL,
  `dateFin` date NOT NULL,
  PRIMARY KEY (`idSalle`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Contenu de la table `salles`
--

INSERT INTO `salles` (`idSalle`, `nomSalle`, `lienSalle`, `dateCreation`, `dateFin`) VALUES
(1, 'Essai', 'tructructruc', '2013-11-28', '2013-11-29');

-- --------------------------------------------------------

--
-- Structure de la table `typespropositions`
--

CREATE TABLE IF NOT EXISTS `typespropositions` (
  `idTypeProposition` int(3) NOT NULL AUTO_INCREMENT,
  `libelleProposition` varchar(50) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`idTypeProposition`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Contenu de la table `typespropositions`
--

INSERT INTO `typespropositions` (`idTypeProposition`, `libelleProposition`) VALUES
(1, 'Logement'),
(2, 'Expérience');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD CONSTRAINT `Commentaires_ibfk_1` FOREIGN KEY (`idSalle`) REFERENCES `salles` (`idSalle`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `etapes`
--
ALTER TABLE `etapes`
  ADD CONSTRAINT `Etapes_ibfk_1` FOREIGN KEY (`idSalle`) REFERENCES `salles` (`idSalle`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `propositions`
--
ALTER TABLE `propositions`
  ADD CONSTRAINT `Propositions_ibfk_1` FOREIGN KEY (`idEtape`) REFERENCES `etapes` (`idEtape`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Propositions_ibfk_2` FOREIGN KEY (`idTypeProposition`) REFERENCES `typespropositions` (`idTypeProposition`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
