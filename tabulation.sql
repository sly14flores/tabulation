-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 14, 2016 at 08:09 PM
-- Server version: 5.6.20
-- PHP Version: 5.4.31

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tabulation`
--

-- --------------------------------------------------------

--
-- Table structure for table `consolation_prizes`
--

CREATE TABLE IF NOT EXISTS `consolation_prizes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `contestant_id` int(10) NOT NULL,
  `overall_score` float(10,2) NOT NULL,
  `place` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `contestant_id` (`contestant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `contestants`
--

CREATE TABLE IF NOT EXISTS `contestants` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `no` int(10) NOT NULL DEFAULT '0',
  `cluster_name` varchar(100) NOT NULL,
  `leader` varchar(100) NOT NULL,
  `remarks` varchar(100) NOT NULL,
  `is_active` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `contestants`
--

INSERT INTO `contestants` (`id`, `no`, `cluster_name`, `leader`, `remarks`, `is_active`) VALUES
(1, 1, 'ACCTG, BUDGET, PTO, LEGAL', 'FRENZILYN MAMARIL', '', 1),
(2, 0, 'CMCH, RDH', 'LORENZO ORTEGA', '', 0),
(3, 0, 'OPAG, OPVET & PSWDO', 'JOHN RAY DIAZ', '', 1),
(4, 0, 'SP', 'JANE FLORES', '', 1),
(5, 0, 'PITO, ASSESSOR, PPO', 'ARTHUR CORTEZ', '', 0),
(6, 0, 'BDH, BALDH', 'MARK PARCHAMENTO', '', 1),
(7, 0, 'LUMC', 'ARIANE AMPARO', '', 1),
(8, 0, 'PHO, NDH', '', '', 1),
(9, 0, 'OPG (All Divisions)', 'Aizel Trisha Joyce Villaremo', '', 1),
(10, 0, 'PGSO, PPDC & PEO', 'DONG ALCANTARA', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `criteria`
--

CREATE TABLE IF NOT EXISTS `criteria` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  `percentage` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `criteria`
--

INSERT INTO `criteria` (`id`, `description`, `percentage`) VALUES
(1, 'Stage Presence', 20),
(2, 'Choreography & Creativity', 20),
(3, 'Vocals', 20),
(4, 'Costume & Props', 15),
(5, 'Mastery', 15),
(6, 'Audience Impact', 10);

-- --------------------------------------------------------

--
-- Table structure for table `judges`
--

CREATE TABLE IF NOT EXISTS `judges` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `last_name` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `remarks` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `judges`
--

INSERT INTO `judges` (`id`, `last_name`, `first_name`, `remarks`) VALUES
(1, 'Flores', 'Sly', '');

-- --------------------------------------------------------

--
-- Table structure for table `preferences`
--

CREATE TABLE IF NOT EXISTS `preferences` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `on_going_contestant` int(10) NOT NULL,
  `minimum_score` int(10) NOT NULL,
  `maximum_score` int(10) NOT NULL,
  `signup_token` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `preferences`
--

INSERT INTO `preferences` (`id`, `title`, `on_going_contestant`, `minimum_score`, `maximum_score`, `signup_token`) VALUES
(1, 'Sayaw Awit', 0, 5, 10, 161216);

-- --------------------------------------------------------

--
-- Table structure for table `scores`
--

CREATE TABLE IF NOT EXISTS `scores` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `judge_id` int(10) NOT NULL,
  `contestant_id` int(10) NOT NULL,
  `criteria_id` int(10) NOT NULL,
  `score` float(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `judge_id` (`judge_id`,`criteria_id`),
  KEY `criteria_id` (`criteria_id`),
  KEY `contestant_id` (`contestant_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

--
-- Dumping data for table `scores`
--

INSERT INTO `scores` (`id`, `judge_id`, `contestant_id`, `criteria_id`, `score`) VALUES
(1, 1, 1, 1, 0.00),
(2, 1, 1, 2, 0.00),
(3, 1, 1, 3, 0.00),
(4, 1, 1, 4, 0.00),
(5, 1, 1, 5, 0.00),
(6, 1, 1, 6, 8.00),
(7, 1, 3, 1, 0.00),
(8, 1, 3, 2, 0.00),
(9, 1, 3, 3, 0.00),
(10, 1, 3, 4, 0.00),
(11, 1, 3, 5, 0.00),
(12, 1, 3, 6, 0.00),
(13, 1, 9, 1, 0.00),
(14, 1, 9, 2, 0.00),
(15, 1, 9, 3, 0.00),
(16, 1, 9, 4, 0.00),
(17, 1, 9, 5, 0.00),
(18, 1, 9, 6, 0.00),
(19, 1, 4, 1, 0.00),
(20, 1, 4, 2, 0.00),
(21, 1, 4, 3, 0.00),
(22, 1, 4, 4, 0.00),
(23, 1, 4, 5, 0.00),
(24, 1, 4, 6, 0.00),
(25, 1, 6, 1, 18.00),
(26, 1, 6, 2, 0.00),
(27, 1, 6, 3, 0.00),
(28, 1, 6, 4, 0.00),
(29, 1, 6, 5, 0.00),
(30, 1, 6, 6, 0.00),
(31, 1, 7, 1, 0.00),
(32, 1, 7, 2, 0.00),
(33, 1, 7, 3, 0.00),
(34, 1, 7, 4, 0.00),
(35, 1, 7, 5, 0.00),
(36, 1, 7, 6, 0.00),
(37, 1, 8, 1, 0.00),
(38, 1, 8, 2, 0.00),
(39, 1, 8, 3, 0.00),
(40, 1, 8, 4, 0.00),
(41, 1, 8, 5, 0.00),
(42, 1, 8, 6, 0.00),
(43, 1, 10, 1, 0.00),
(44, 1, 10, 2, 0.00),
(45, 1, 10, 3, 0.00),
(46, 1, 10, 4, 0.00),
(47, 1, 10, 5, 0.00),
(48, 1, 10, 6, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `winners`
--

CREATE TABLE IF NOT EXISTS `winners` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `contestant_id` int(10) NOT NULL,
  `overall_score` float(10,2) NOT NULL,
  `place` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `contestat_id` (`contestant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `consolation_prizes`
--
ALTER TABLE `consolation_prizes`
  ADD CONSTRAINT `consolation_prizes_ibfk_1` FOREIGN KEY (`contestant_id`) REFERENCES `contestants` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `scores`
--
ALTER TABLE `scores`
  ADD CONSTRAINT `scores_ibfk_1` FOREIGN KEY (`judge_id`) REFERENCES `judges` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `scores_ibfk_2` FOREIGN KEY (`criteria_id`) REFERENCES `criteria` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `scores_ibfk_3` FOREIGN KEY (`contestant_id`) REFERENCES `contestants` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `winners`
--
ALTER TABLE `winners`
  ADD CONSTRAINT `winners_ibfk_1` FOREIGN KEY (`contestant_id`) REFERENCES `contestants` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
