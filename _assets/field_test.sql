
-- --------------------------------------------------------

--
-- Table structure for table `Countries`
--

CREATE TABLE `Countries` (
  `country_id` int(11) NOT NULL,
  `country_code` varchar(2) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Encounters`
--

CREATE TABLE `Encounters` (
  `encounter_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`encounter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Encounter_Reasons`
--

CREATE TABLE `Encounter_Reasons` (
  `rfe_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `refset_id` int(11) NOT NULL COMMENT 'this differentiates between health issues & RFE',
  `concept_id` int(11) DEFAULT NULL,
  `concept_scale` int(11) DEFAULT NULL,
  `concept_alt` varchar(250) DEFAULT NULL,
  `map_code_id` int(11) DEFAULT NULL,
  `map_scale` int(11) DEFAULT NULL,
  `map_alt_id` int(11) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`rfe_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Gender`
--

CREATE TABLE `Gender` (
  `gender_id` int(11) NOT NULL,
  `gender` varchar(10) NOT NULL,
  UNIQUE KEY `id` (`gender_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Map_Concepts`
--

CREATE TABLE `Map_Concepts` (
  `map_id` int(11) NOT NULL,
  `map_code` varchar(25) NOT NULL,
  `label` varchar(250) NOT NULL,
  PRIMARY KEY (`map_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `SCT_Concepts`
--

CREATE TABLE `SCT_Concepts` (
  `sct_id` int(11) NOT NULL,
  `concept_name` varchar(250) NOT NULL,
  PRIMARY KEY (`sct_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

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
