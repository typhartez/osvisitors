-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Sam 21 Janvier 2017 à 15:47
-- Version du serveur :  10.1.19-MariaDB
-- Version de PHP :  5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `opensim`
--

-- --------------------------------------------------------

--
-- Structure de la table `osvisitors_inworld`
--

CREATE TABLE `osvisitors_inworld` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL,
  `useruuid` varchar(36) NOT NULL,
  `gender` varchar(8) NOT NULL,
  `language` varchar(8) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `country` varchar(128) NOT NULL,
  `hostname` varchar(128) NOT NULL,
  `gridname` varchar(128) NOT NULL,
  `regionname` varchar(128) NOT NULL,
  `parcelname` varchar(128) NOT NULL,
  `counter` int(11) NOT NULL,
  `firstvisit` int(11) NOT NULL,
  `lastvisit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `osvisitors_inworld`
--
ALTER TABLE `osvisitors_inworld`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `osvisitors_inworld`
--
ALTER TABLE `osvisitors_inworld`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
