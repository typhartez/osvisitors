-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 15 Mars 2016 à 15:15
-- Version du serveur :  5.6.21
-- Version de PHP :  5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `opensim`
--

-- --------------------------------------------------------

--
-- Structure de la table `osvisitors_inworld`
--

CREATE TABLE IF NOT EXISTS `osvisitors_inworld` (
`id` int(10) unsigned NOT NULL,
  `username` varchar(64) NOT NULL,
  `useruuid` varchar(36) NOT NULL,
  `hostname` varchar(128) NOT NULL,
  `gridname` varchar(128) NOT NULL,
  `regionname` varchar(128) NOT NULL,
  `parcelname` varchar(128) NOT NULL,
  `counter` int(11) NOT NULL,
  `firstvisit` int(11) NOT NULL,
  `lastvisit` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


--
-- Index pour la table `osvisitors_inworld`
--
ALTER TABLE `osvisitors_inworld`
 ADD PRIMARY KEY (`id`);


--
-- AUTO_INCREMENT pour la table `osvisitors_inworld`
--
ALTER TABLE `osvisitors_inworld`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
