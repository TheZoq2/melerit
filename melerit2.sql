-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 26, 2014 at 03:31 
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `melerit2`
--

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `startDate` int(11) NOT NULL,
  `endDate` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`ID`, `name`, `startDate`, `endDate`) VALUES
(17, 'vvv', 1396915200, 1398816000),
(18, 'Pers hyperkurs', 1400544000, 1403481600),
(19, 'Danskens hyperkurs', 1400544000, 1403481600),
(20, 'Kurs 4', 1398297600, 1399939200),
(21, 'kurs2', 1397606400, 1398729600);

-- --------------------------------------------------------

--
-- Table structure for table `coursemember`
--

CREATE TABLE IF NOT EXISTS `coursemember` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userID` int(10) unsigned NOT NULL,
  `courseID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `coursemember`
--

INSERT INTO `coursemember` (`ID`, `userID`, `courseID`) VALUES
(1, 2, 17),
(2, 2, 18),
(3, 2, 19),
(4, 2, 20),
(5, 3, 21),
(6, 1, 17),
(7, 1, 18);

-- --------------------------------------------------------

--
-- Table structure for table `exercise`
--

CREATE TABLE IF NOT EXISTS `exercise` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(256) NOT NULL,
  `startDate` int(10) unsigned NOT NULL,
  `endDate` int(10) unsigned NOT NULL,
  `param1` int(10) unsigned NOT NULL,
  `param2` int(10) unsigned NOT NULL,
  `param3` int(10) unsigned NOT NULL,
  `param4` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `exercise`
--

INSERT INTO `exercise` (`ID`, `Name`, `startDate`, `endDate`, `param1`, `param2`, `param3`, `param4`) VALUES
(1, 'Test exercise', 1400191200, 1400709600, 41, 42, 43, 44),
(2, 'Test exercise', 1400191200, 1400709600, 45, 46, 47, 48),
(3, 'Test exercise', 1400191200, 1400709600, 49, 50, 51, 52),
(4, 'Test exercise', 1400191200, 1400709600, 53, 54, 55, 56),
(5, 'Test exercise', 1400191200, 1400709600, 57, 58, 59, 60),
(6, 'Everyone gets F', 1401314400, 1399932000, 61, 62, 63, 64);

-- --------------------------------------------------------

--
-- Table structure for table `exercisecourse`
--

CREATE TABLE IF NOT EXISTS `exercisecourse` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `courseID` int(10) unsigned NOT NULL,
  `exerciseID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `exercisecourse`
--

INSERT INTO `exercisecourse` (`ID`, `courseID`, `exerciseID`) VALUES
(1, 17, 5),
(2, 17, 6);

-- --------------------------------------------------------

--
-- Table structure for table `param`
--

CREATE TABLE IF NOT EXISTS `param` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `minVal` float NOT NULL,
  `maxVal` float NOT NULL,
  `minValOk` float NOT NULL,
  `maxValOk` float NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=65 ;

--
-- Dumping data for table `param`
--

INSERT INTO `param` (`ID`, `minVal`, `maxVal`, `minValOk`, `maxValOk`) VALUES
(41, 0, 0, 0, 0),
(42, 0, 0, 0, 0),
(43, 0, 0, 0, 0),
(44, 0, 0, 0, 0),
(45, 0, 0, 0, 0),
(46, 0, 0, 0, 0),
(47, 0, 0, 0, 0),
(48, 0, 0, 0, 0),
(49, 0, 0, 0, 0),
(50, 0, 0, 0, 0),
(51, 0, 0, 0, 0),
(52, 0, 0, 0, 0),
(53, 0, 0, 0, 0),
(54, 0, 0, 0, 0),
(55, 0, 0, 0, 0),
(56, 0, 0, 0, 0),
(57, 0, 0, 0, 0),
(58, 0, 0, 0, 0),
(59, 0, 0, 0, 0),
(60, 0, 0, 0, 0),
(61, 0, 0, 0, 0),
(62, 0, 0, 0, 0),
(63, 0, 0, 0, 0),
(64, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `result`
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
-- Table structure for table `usercourse`
--

CREATE TABLE IF NOT EXISTS `usercourse` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `courseID` int(10) unsigned NOT NULL,
  `exerciseID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role` smallint(6) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `name`, `password`, `role`) VALUES
(1, 'test', '$2y$10$oj9egFpILQxq05UrRbyQpeOdrrbAfQNXX3ZvcC06jnJiVGeEHYDpW', 0),
(2, 'admin', '$2y$10$H9rzy9m1x/JJiogeD7aMxunKtJn2/FwCKC79qoDL1iULerHSlgFuG', 1),
(3, 'konto2', '$2y$10$V.I0y7lYpUqru08cZDm5gu.KOqE.R/7adDsFXYxq7gl3T.iAb38lO', 1),
(4, 'test2', '$2y$10$GcHOlODvfl4tLDxTelNQvex7nB.mBZ5KnANw1/ZFi8DWErCVJ33Ua', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
