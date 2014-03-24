-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 24, 2014 at 03:34 
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `melerit`
--

-- --------------------------------------------------------

--
-- Table structure for table `exercise`
--

CREATE TABLE IF NOT EXISTS `exercise` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `paramID1` int(11) NOT NULL,
  `paramID2` int(11) NOT NULL,
  `paramID3` int(11) NOT NULL,
  `paramID4` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `exercise`
--

INSERT INTO `exercise` (`ID`, `name`, `paramID1`, `paramID2`, `paramID3`, `paramID4`) VALUES
(1, 'Task1', 1, 2, 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `parameter`
--

CREATE TABLE IF NOT EXISTS `parameter` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `minVal` float NOT NULL,
  `maxVal` float NOT NULL,
  `minValOK` float NOT NULL,
  `maxValOK` float NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `parameter`
--

INSERT INTO `parameter` (`ID`, `name`, `minVal`, `maxVal`, `minValOK`, `maxValOK`) VALUES
(1, 'parameter1', 0, 25, 0, 20),
(2, 'parameter2', 0.3, 0.6, 0.2, 0.7),
(3, 'parameter3', -2, 2, -2.1, 2.2),
(4, 'parameter4', 0, 0.4, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `result`
--

CREATE TABLE IF NOT EXISTS `result` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `userID` int(10) unsigned NOT NULL,
  `exerciseID` int(10) unsigned NOT NULL,
  `param1` float NOT NULL,
  `param2` float NOT NULL,
  `param3` float NOT NULL,
  `param4` float NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `name`, `password`, `type`) VALUES
(1, 'Jimmys mamma', '$2y$10$j.2uTGToqcU39UBwHsB2Y.ooyxpiuDWipqXF76E2/EjiUkPlGRXtC', 0),
(2, 'Jimmys mamma', '$2y$10$2hscsy1J.xed0K013O/Viel0S5Q04W9St1TgptEPkJOocFh20LuXC', 0),
(3, 'test', '$2y$10$xV2kh/g/bSgnUsfnifiF5e2tWXY4W9VAXulFv99DapsqjcKhzOSF6', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
