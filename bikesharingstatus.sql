-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: Ott 11, 2013 alle 14:04
-- Versione del server: 5.5.29
-- Versione PHP: 5.4.10

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bikesharingstatus`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `city`
--

DROP TABLE IF EXISTS `city`;
CREATE TABLE `city` (
  `id_city` int(11) NOT NULL AUTO_INCREMENT,
  `bs_name` varchar(64) NOT NULL,
  PRIMARY KEY (`id_city`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dump dei dati per la tabella `city`
--

INSERT INTO `city` (`id_city`, `bs_name`) VALUES
(1, 'BikeMi');

-- --------------------------------------------------------

--
-- Struttura della tabella `city_bikes`
--

DROP TABLE IF EXISTS `city_bikes`;
CREATE TABLE `city_bikes` (
  `id_bike` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_city` int(11) NOT NULL,
  `serial` varchar(32) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_bike`),
  UNIQUE KEY `id_city_2` (`id_city`,`serial`),
  UNIQUE KEY `id_city` (`id_city`,`serial`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `city_bikes_issues`
--

DROP TABLE IF EXISTS `city_bikes_issues`;
CREATE TABLE `city_bikes_issues` (
  `id_bike` bigint(20) unsigned NOT NULL,
  `id_issue` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `note` text NOT NULL,
  KEY `id_bike` (`id_bike`),
  KEY `id_issue` (`id_issue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `city_issues`
--

DROP TABLE IF EXISTS `city_issues`;
CREATE TABLE `city_issues` (
  `id_city` int(11) NOT NULL,
  `id_issue` int(11) NOT NULL,
  PRIMARY KEY (`id_city`,`id_issue`),
  KEY `id_issue` (`id_issue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `city_issues`
--

INSERT INTO `city_issues` (`id_city`, `id_issue`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6);

-- --------------------------------------------------------

--
-- Struttura della tabella `issues`
--

DROP TABLE IF EXISTS `issues`;
CREATE TABLE `issues` (
  `id_issue` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `rank` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_issue`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dump dei dati per la tabella `issues`
--

INSERT INTO `issues` (`id_issue`, `name`, `description`, `rank`) VALUES
(1, 'Ruote', '', 1),
(2, 'Cambio', '', 1),
(3, 'Luci', '', 1),
(4, 'Sellino', '', 1),
(5, 'Freni', '', 1),
(6, 'Pedali', '', 1);

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `city_bikes`
--
ALTER TABLE `city_bikes`
  ADD CONSTRAINT `city_bikes_ibfk_1` FOREIGN KEY (`id_city`) REFERENCES `city` (`id_city`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `city_bikes_issues`
--
ALTER TABLE `city_bikes_issues`
  ADD CONSTRAINT `city_bikes_issues_ibfk_1` FOREIGN KEY (`id_bike`) REFERENCES `city_bikes` (`id_bike`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `city_bikes_issues_ibfk_2` FOREIGN KEY (`id_issue`) REFERENCES `issues` (`id_issue`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `city_issues`
--
ALTER TABLE `city_issues`
  ADD CONSTRAINT `city_issues_ibfk_1` FOREIGN KEY (`id_city`) REFERENCES `city` (`id_city`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `city_issues_ibfk_2` FOREIGN KEY (`id_issue`) REFERENCES `issues` (`id_issue`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
