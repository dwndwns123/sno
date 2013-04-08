-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 08, 2013 at 06:12 PM
-- Server version: 5.5.29
-- PHP Version: 5.4.10

SET time_zone = "+00:00";

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `Countries`
--

DROP TABLE IF EXISTS `Countries`;
CREATE TABLE `Countries` (
  `country_id` int(11) NOT NULL,
  `country_code` varchar(2) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Encounters`
--

DROP TABLE IF EXISTS `Encounters`;
CREATE TABLE `Encounters` (
  `encounter_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`encounter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Encounter_Reasons`
--

DROP TABLE IF EXISTS `Encounter_Reasons`;
CREATE TABLE `Encounter_Reasons` (
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

DROP TABLE IF EXISTS `Gender`;
CREATE TABLE `Gender` (
  `gender_id` int(11) NOT NULL,
  `gender` varchar(10) NOT NULL,
  UNIQUE KEY `id` (`gender_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Map_Concepts`
--

DROP TABLE IF EXISTS `Map_Concepts`;
CREATE TABLE `Map_Concepts` (
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

DROP TABLE IF EXISTS `SCT_Concepts`;
CREATE TABLE `SCT_Concepts` (
  `sct_id` int(11) NOT NULL,
  `concept_name` varchar(250) NOT NULL,
  PRIMARY KEY (`sct_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
CREATE TABLE `Users` (
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
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
