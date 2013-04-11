-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 11, 2013 at 12:30 PM
-- Server version: 5.5.29
-- PHP Version: 5.4.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `field-test`
--

-- --------------------------------------------------------

--
-- Table structure for table `Countries`
--

CREATE TABLE IF NOT EXISTS `Countries` (
  `country_id` int(11) NOT NULL,
  `country_code` varchar(2) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Countries`
--

INSERT INTO `Countries` (`country_id`, `country_code`, `name`) VALUES
(0, 'AU', 'Australia'),
(1, 'GB', 'United Kingdom');

-- --------------------------------------------------------

--
-- Table structure for table `Encounters`
--

CREATE TABLE IF NOT EXISTS `Encounters` (
  `encounter_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `complete` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`encounter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Encounter_Reasons`
--

CREATE TABLE IF NOT EXISTS `Encounter_Reasons` (
  `rfe_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `encounter_id` mediumint(9) NOT NULL,
  `refset_id` int(11) NOT NULL COMMENT 'this differentiates between health issues & RFE',
  `sct_id` int(11) DEFAULT NULL,
  `sct_scale` int(11) DEFAULT NULL,
  `sct_alt` varchar(250) DEFAULT NULL,
  `map_id` int(11) DEFAULT NULL,
  `map_scale` int(11) DEFAULT NULL,
  `map_alt_id` int(11) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`rfe_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Gender`
--

CREATE TABLE IF NOT EXISTS `Gender` (
  `gender_id` int(11) NOT NULL,
  `gender` varchar(10) NOT NULL,
  UNIQUE KEY `id` (`gender_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Gender`
--

INSERT INTO `Gender` (`gender_id`, `gender`) VALUES
(0, 'Male'),
(1, 'Female');

-- --------------------------------------------------------

--
-- Table structure for table `Map_Concepts`
--

CREATE TABLE IF NOT EXISTS `Map_Concepts` (
  `map_id` int(11) NOT NULL,
  `map_code` varchar(25) NOT NULL,
  `label` varchar(250) NOT NULL,
  `sct_id` mediumint(9) NOT NULL,
  PRIMARY KEY (`map_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `SCT_Concepts`
--

CREATE TABLE IF NOT EXISTS `SCT_Concepts` (
  `sct_id` int(11) NOT NULL,
  `concept_name` varchar(250) NOT NULL,
  PRIMARY KEY (`sct_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Title`
--

CREATE TABLE IF NOT EXISTS `Title` (
  `title_id` int(11) NOT NULL,
  `title` varchar(32) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`title_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `Title`
--

INSERT INTO `Title` (`title_id`, `title`) VALUES
(0, 'Mr.'),
(1, 'Mrs.'),
(2, 'Ms.'),
(3, 'Miss'),
(4, 'Dr.'),
(5, 'Prof.'),
(6, 'Rev.'),
(7, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `user_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `title` varchar(5) DEFAULT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `gender_id` int(11) DEFAULT NULL,
  `country_id` int(11) NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `verification` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;
