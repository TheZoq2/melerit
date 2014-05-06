-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Värd: localhost
-- Skapad: 06 maj 2014 kl 14:40
-- Serverversion: 5.6.12-log
-- PHP-version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `melerit2`
--
CREATE DATABASE IF NOT EXISTS `melerit2` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `melerit2`;

-- --------------------------------------------------------

--
-- Tabellstruktur `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `startDate` int(11) NOT NULL,
  `endDate` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumpning av Data i tabell `course`
--

INSERT INTO `course` (`ID`, `name`, `startDate`, `endDate`) VALUES
(17, 'vvv', 1396915200, 1398816000),
(18, 'Pers hyperkurs', 1400544000, 1403481600),
(19, 'Danskens hyperkurs', 1400544000, 1403481600),
(20, 'Kurs 4', 1398297600, 1399939200),
(21, 'kurs2', 1397606400, 1398729600);

-- --------------------------------------------------------

--
-- Tabellstruktur `coursemember`
--

CREATE TABLE IF NOT EXISTS `coursemember` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userID` int(10) unsigned NOT NULL,
  `courseID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumpning av Data i tabell `coursemember`
--

INSERT INTO `coursemember` (`ID`, `userID`, `courseID`) VALUES
(1, 2, 17),
(2, 2, 18),
(3, 2, 19),
(4, 2, 20),
(5, 3, 21);

-- --------------------------------------------------------

--
-- Tabellstruktur `exercise`
--

CREATE TABLE IF NOT EXISTS `exercise` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(256) NOT NULL,
  `paramID1` int(10) unsigned NOT NULL,
  `paramID2` int(10) unsigned NOT NULL,
  `paramID3` int(10) unsigned NOT NULL,
  `paramID4` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `exercisecourse`
--

CREATE TABLE IF NOT EXISTS `exercisecourse` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `courseID` int(10) unsigned NOT NULL,
  `exerciseID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `param`
--

CREATE TABLE IF NOT EXISTS `param` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `minVal` float NOT NULL,
  `maxVal` float NOT NULL,
  `minValOk` float NOT NULL,
  `maxValOk` float NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `result`
--

CREATE TABLE IF NOT EXISTS `result` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `exerciseID` int(10) unsigned NOT NULL,
  `date` datetime NOT NULL,
  `userID` int(10) unsigned NOT NULL,
  `param1` float NOT NULL,
  `param2` float NOT NULL,
  `param3` float NOT NULL,
  `param4` float NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `usercourse`
--

CREATE TABLE IF NOT EXISTS `usercourse` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `courseID` int(10) unsigned NOT NULL,
  `exerciseID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role` smallint(6) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumpning av Data i tabell `users`
--

INSERT INTO `users` (`ID`, `name`, `password`, `role`) VALUES
(1, 'test', '$2y$10$oj9egFpILQxq05UrRbyQpeOdrrbAfQNXX3ZvcC06jnJiVGeEHYDpW', 0),
(2, 'admin', '$2y$10$H9rzy9m1x/JJiogeD7aMxunKtJn2/FwCKC79qoDL1iULerHSlgFuG', 1),
(3, 'konto2', '$2y$10$V.I0y7lYpUqru08cZDm5gu.KOqE.R/7adDsFXYxq7gl3T.iAb38lO', 1),
(4, 'test2', '$2y$10$GcHOlODvfl4tLDxTelNQvex7nB.mBZ5KnANw1/ZFi8DWErCVJ33Ua', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
