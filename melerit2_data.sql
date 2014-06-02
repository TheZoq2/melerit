-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 01, 2014 at 02:05 
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `melerit2`
--

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`ID`, `name`, `startDate`, `endDate`) VALUES
(17, 'vvv', 1396915200, 1398816000),
(18, 'Pers hyperkurs', 1400544000, 1403481600),
(19, 'Danskens hyperkurs', 1400544000, 1403481600),
(20, 'Kurs 4', 1398297600, 1399939200),
(21, 'kurs2', 1397606400, 1398729600);

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
(7, 1, 18),
(8, 4, 20),
(9, 1, 19);

--
-- Dumping data for table `exercise`
--

INSERT INTO `exercise` (`ID`, `Name`, `startDate`, `endDate`, `param1`, `param2`, `param3`, `param4`) VALUES
(11, 'DasUbung', 1403906400, 1404079200, 81, 82, 83, 84),
(12, 'DasUbung2', 1403906400, 1404079200, 85, 86, 87, 88),
(13, 'DasUbung3', 1403906400, 1404079200, 89, 90, 91, 92);

--
-- Dumping data for table `exercisecourse`
--

INSERT INTO `exercisecourse` (`ID`, `courseID`, `exerciseID`) VALUES
(7, 17, 11),
(8, 17, 12),
(9, 17, 13);

--
-- Dumping data for table `param`
--

INSERT INTO `param` (`ID`, `minVal`, `maxVal`, `minValOk`, `maxValOk`) VALUES
(81, 5, 15, 0, 20),
(82, 0, 0, 0, 1),
(83, 3, 6, 3, 6),
(84, -5, 10, -10, 15),
(85, 100, 200, 50, 250),
(86, -5, 10, -15, 10),
(87, 55, 65, 45, 65),
(88, -5, 10, -10, 15),
(89, 100, 200, 50, 250),
(90, 0.3, 0.7, 0.1, 0.9),
(91, 55, 65, 45, 65),
(92, -5, 10, -10, 15);

--
-- Dumping data for table `result`
--

INSERT INTO `result` (`ID`, `exerciseID`, `date`, `userID`, `param1`, `param2`, `param3`, `param4`) VALUES
(4, 8, '2014-05-28 00:00:00', 1, 3, 5, 2, -3),
(5, 9, '2014-06-01 00:00:00', 1, 5, 18, -3, 2),
(6, 9, '2014-06-01 00:00:00', 1, 3, 2, -5, 5),
(7, 9, '2014-06-01 00:00:00', 1, 3, 2, -8, 5),
(8, 9, '2014-06-01 00:00:00', 1, 3, 2, -11, 5),
(9, 9, '2014-06-01 00:00:00', 1, 3, 2, -110000, 5),
(10, 9, '2014-06-01 00:00:00', 1, 3, 2, -18, 5),
(11, 9, '2014-06-01 00:00:00', 1, 3, 2, -15, 5),
(12, 9, '2014-06-01 00:00:00', 1, 3, 2, 14, 5),
(13, 9, '2014-06-01 00:00:00', 1, 10, 2, 14, 5),
(14, 9, '2014-06-01 00:00:00', 1, 8, 2, 14, 5),
(15, 9, '2014-06-01 00:00:00', 1, 17, 2, 14, 5),
(16, 9, '2014-06-01 00:00:00', 1, 14.5, 2, 14, 5),
(17, 9, '2014-06-01 00:00:00', 1, 24, 2, 14, 5),
(18, 9, '2014-06-01 00:00:00', 1, 24, 24, 14, 5),
(19, 11, '2014-06-01 00:00:00', 1, 5, 25, 4.2, 10),
(20, 11, '2014-06-01 00:00:00', 1, 10, 25, 3.1, 16),
(21, 11, '2014-06-01 00:00:00', 1, 10, 1, 3.1, 16),
(22, 11, '2014-06-01 00:00:00', 1, 0.32, 0.312, 0.56, 0.2);

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
