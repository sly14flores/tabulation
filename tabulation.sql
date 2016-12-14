-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 14, 2016 at 09:46 AM
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
  `name` varchar(100) NOT NULL,
  `remarks` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `criteria`
--

CREATE TABLE IF NOT EXISTS `criteria` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  `percentage` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `judges`
--

CREATE TABLE IF NOT EXISTS `judges` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `remarks` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `on_going_contestant` (`on_going_contestant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `scores`
--

CREATE TABLE IF NOT EXISTS `scores` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `judge_id` int(10) NOT NULL,
  `criteria_id` int(10) NOT NULL,
  `score` float(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `judge_id` (`judge_id`,`criteria_id`),
  KEY `criteria_id` (`criteria_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
-- Constraints for table `preferences`
--
ALTER TABLE `preferences`
  ADD CONSTRAINT `preferences_ibfk_1` FOREIGN KEY (`on_going_contestant`) REFERENCES `contestants` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `scores`
--
ALTER TABLE `scores`
  ADD CONSTRAINT `scores_ibfk_1` FOREIGN KEY (`judge_id`) REFERENCES `judges` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `scores_ibfk_2` FOREIGN KEY (`criteria_id`) REFERENCES `criteria` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `winners`
--
ALTER TABLE `winners`
  ADD CONSTRAINT `winners_ibfk_1` FOREIGN KEY (`contestant_id`) REFERENCES `contestants` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
