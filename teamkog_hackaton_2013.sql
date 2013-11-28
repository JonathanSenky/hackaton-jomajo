-- phpMyAdmin SQL Dump
-- version 4.0.8
-- http://www.phpmyadmin.net
--
-- Client: sql427.redheberg.com
-- Généré le: Jeu 28 Novembre 2013 à 15:02
-- Version du serveur: 5.1.69-log
-- Version de PHP: 5.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Structure de la table `Commentaires`
--

CREATE TABLE IF NOT EXISTS `Commentaires` (
  `idcommentaire` int(10) NOT NULL AUTO_INCREMENT,
  `idSalle` int(5) NOT NULL,
  `auteur` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `contenu` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `dateCommentaire` date NOT NULL,
  PRIMARY KEY (`idcommentaire`),
  KEY `idSalle` (`idSalle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `Etapes`
--

CREATE TABLE IF NOT EXISTS `Etapes` (
  `idEtape` int(5) NOT NULL AUTO_INCREMENT,
  `idSalle` int(10) NOT NULL,
  `destination` varchar(50) CHARACTER SET latin1 NOT NULL,
  `dateDebut` date NOT NULL,
  `dateFin` date NOT NULL,
  PRIMARY KEY (`idEtape`),
  KEY `idSalle` (`idSalle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `Propositions`
--

CREATE TABLE IF NOT EXISTS `Propositions` (
  `idProposition` int(10) NOT NULL AUTO_INCREMENT,
  `idEtape` int(5) NOT NULL,
  `idTypeProposition` int(3) NOT NULL,
  `votePlus` int(5) NOT NULL,
  `voteMoins` int(5) NOT NULL,
  PRIMARY KEY (`idProposition`),
  KEY `idEtape` (`idEtape`),
  KEY `idTypeProposition` (`idTypeProposition`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `Salles`
--

CREATE TABLE IF NOT EXISTS `Salles` (
  `idSalle` int(5) NOT NULL AUTO_INCREMENT,
  `nomSalle` varchar(50) CHARACTER SET latin1 NOT NULL,
  `lienSalle` varchar(200) CHARACTER SET latin1 NOT NULL,
  `dateCreation` date NOT NULL,
  `dateFin` date NOT NULL,
  PRIMARY KEY (`idSalle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `TypesPropositions`
--

CREATE TABLE IF NOT EXISTS `TypesPropositions` (
  `idTypeProposition` int(3) NOT NULL AUTO_INCREMENT,
  `libelleProposition` varchar(50) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`idTypeProposition`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Commentaires`
--
ALTER TABLE `Commentaires`
  ADD CONSTRAINT `Commentaires_ibfk_1` FOREIGN KEY (`idSalle`) REFERENCES `Salles` (`idSalle`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Etapes`
--
ALTER TABLE `Etapes`
  ADD CONSTRAINT `Etapes_ibfk_1` FOREIGN KEY (`idSalle`) REFERENCES `Salles` (`idSalle`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Propositions`
--
ALTER TABLE `Propositions`
  ADD CONSTRAINT `Propositions_ibfk_2` FOREIGN KEY (`idTypeProposition`) REFERENCES `TypesPropositions` (`idTypeProposition`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Propositions_ibfk_1` FOREIGN KEY (`idEtape`) REFERENCES `Etapes` (`idEtape`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
