-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 24, 2014 at 11:29 AM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `melerit`
--
CREATE DATABASE IF NOT EXISTS `melerit` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `melerit`;

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
