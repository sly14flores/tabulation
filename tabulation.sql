-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 16, 2016 at 10:02 AM
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
  `overall_score` decimal(10,2) NOT NULL,
  `place` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `contestant_id` (`contestant_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `consolation_prizes`
--

INSERT INTO `consolation_prizes` (`id`, `contestant_id`, `overall_score`, `place`) VALUES
(1, 6, '0.00', 'Consolation Prize'),
(2, 7, '0.00', 'Consolation Prize'),
(3, 8, '0.00', 'Consolation Prize'),
(4, 9, '0.00', 'Consolation Prize'),
(5, 10, '0.00', 'Consolation Prize');

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
(3, 2, 'OPAG, OPVET & PSWDO', 'JOHN RAY DIAZ', '', 1),
(4, 3, 'SP', 'JANE FLORES', '', 1),
(5, 0, 'PITO, ASSESSOR, PPO', 'ARTHUR CORTEZ', '', 0),
(6, 4, 'BDH, BALDH', 'MARK PARCHAMENTO', '', 1),
(7, 5, 'LUMC', 'ARIANE AMPARO', '', 1),
(8, 6, 'PHO, NDH', '', '', 1),
(9, 7, 'OPG (All Divisions)', 'Aizel Trisha Joyce Villaremo', '', 1),
(10, 8, 'PGSO, PPDC & PEO', 'DONG ALCANTARA', '', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `judges`
--

INSERT INTO `judges` (`id`, `last_name`, `first_name`, `remarks`) VALUES
(1, 'ofiaza', 'markuz', ''),
(2, 'Flores', 'Sly', '');

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
  `score` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `judge_id` (`judge_id`,`criteria_id`),
  KEY `criteria_id` (`criteria_id`),
  KEY `contestant_id` (`contestant_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `scores`
--

INSERT INTO `scores` (`id`, `judge_id`, `contestant_id`, `criteria_id`, `score`) VALUES
(1, 2, 1, 1, 20),
(2, 2, 1, 2, 20),
(3, 2, 1, 3, 20),
(4, 2, 1, 4, 10),
(5, 2, 1, 5, 15),
(6, 2, 1, 6, 10),
(7, 1, 1, 1, 10),
(8, 1, 1, 2, 10),
(9, 1, 1, 3, 10),
(10, 1, 1, 4, 10),
(11, 1, 1, 5, 10),
(12, 1, 1, 6, 10),
(13, 2, 3, 1, 20),
(14, 2, 3, 2, 20),
(15, 2, 3, 3, 15),
(16, 2, 3, 4, 15),
(17, 2, 3, 5, 10),
(18, 2, 3, 6, 5),
(19, 1, 3, 1, 15),
(20, 1, 3, 2, 15),
(21, 1, 3, 3, 15),
(22, 1, 3, 4, 15),
(23, 1, 3, 5, 15),
(24, 1, 3, 6, 10);

-- --------------------------------------------------------

--
-- Table structure for table `winners`
--

CREATE TABLE IF NOT EXISTS `winners` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `contestant_id` int(10) NOT NULL,
  `overall_score` decimal(10,2) NOT NULL,
  `place` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `contestat_id` (`contestant_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `winners`
--

INSERT INTO `winners` (`id`, `contestant_id`, `overall_score`, `place`) VALUES
(1, 3, '85.00', 'First'),
(2, 1, '77.50', 'Second'),
(3, 4, '0.00', 'Third');

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
