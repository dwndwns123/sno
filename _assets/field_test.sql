
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/* create the database */
drop database if exists `field-test`;
create database if not exists `field-test`;
use `field-test`;

--
-- Database: `field-test`
--

-- --------------------------------------------------------

--
-- Table structure for table `Countries`
--

DROP TABLE IF EXISTS `Countries`;
CREATE TABLE `Countries` (
  `country_id` int(11) NOT NULL,
  `country_code` varchar(2) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Countries`
--

INSERT INTO `Countries` (`country_id`, `country_code`, `name`) VALUES
(0, 'AF', 'Afghanistan\n'),
(2, 'AL', 'Albania\n'),
(3, 'DZ', 'Algeria\n'),
(4, 'AS', 'American Samoa\n'),
(5, 'AD', 'Andorra\n'),
(6, 'AO', 'Angola\n'),
(7, 'AI', 'Anguilla\n'),
(8, 'AQ', 'Antarctica\n'),
(9, 'AG', 'Antigua and Barbuda\n'),
(10, 'AR', 'Argentina\n'),
(11, 'AM', 'Armenia\n'),
(12, 'AW', 'Aruba\n'),
(13, 'AU', 'Australia\n'),
(14, 'AT', 'Austria\n'),
(15, 'AZ', 'Azerbaijan\n'),
(16, 'BS', 'Bahamas\n'),
(17, 'BH', 'Bahrain\n'),
(18, 'BD', 'Bangladesh\n'),
(19, 'BB', 'Barbados\n'),
(20, 'BY', 'Belarus\n'),
(21, 'BE', 'Belgium\n'),
(22, 'BZ', 'Belize\n'),
(23, 'BJ', 'Benin\n'),
(24, 'BM', 'Bermuda\n'),
(25, 'BT', 'Bhutan\n'),
(26, 'BO', 'Bolivia\n'),
(27, 'BA', 'Bosnia and Herzegovina\n'),
(28, 'BW', 'Botswana\n'),
(29, 'BV', 'Bouvet Island\n'),
(30, 'BR', 'Brazil\n'),
(31, 'IO', 'British Indian Ocean Territory\n'),
(32, 'BN', 'Brunei Darussalam\n'),
(33, 'BG', 'Bulgaria\n'),
(34, 'BF', 'Burkina Faso\n'),
(35, 'BI', 'Burundi\n'),
(36, 'KH', 'Cambodia\n'),
(37, 'CM', 'Cameroon\n'),
(38, 'CA', 'Canada\n'),
(39, 'CV', 'Cape Verde\n'),
(40, 'KY', 'Cayman Islands\n'),
(41, 'CF', 'Central African Republic\n'),
(42, 'TD', 'Chad\n'),
(43, 'CL', 'Chile\n'),
(44, 'CN', 'China\n'),
(45, 'CX', 'Christmas Island\n'),
(46, 'CC', 'Cocos (Keeling) Islands\n'),
(47, 'CO', 'Colombia\n'),
(48, 'KM', 'Comoros\n'),
(49, 'CG', 'Congo\n'),
(50, 'CD', 'Congo, The Democratic Republic of The\n'),
(51, 'CK', 'Cook Islands\n'),
(52, 'CR', 'Costa Rica\n'),
(53, 'CI', 'Cote D''ivoire\n'),
(54, 'HR', 'Croatia\n'),
(55, 'CU', 'Cuba\n'),
(56, 'CY', 'Cyprus\n'),
(57, 'CZ', 'Czech Republic\n'),
(58, 'DK', 'Denmark\n'),
(59, 'DJ', 'Djibouti\n'),
(60, 'DM', 'Dominica\n'),
(61, 'DO', 'Dominican Republic\n'),
(62, 'EC', 'Ecuador\n'),
(63, 'EG', 'Egypt\n'),
(64, 'SV', 'El Salvador\n'),
(65, 'GQ', 'Equatorial Guinea\n'),
(66, 'ER', 'Eritrea\n'),
(67, 'EE', 'Estonia\n'),
(68, 'ET', 'Ethiopia\n'),
(69, 'FK', 'Falkland Islands (Malvinas)\n'),
(70, 'FO', 'Faroe Islands\n'),
(71, 'FJ', 'Fiji\n'),
(72, 'FI', 'Finland\n'),
(73, 'FR', 'France\n'),
(74, 'GF', 'French Guiana\n'),
(75, 'PF', 'French Polynesia\n'),
(76, 'TF', 'French Southern Territories\n'),
(77, 'GA', 'Gabon\n'),
(78, 'GM', 'Gambia\n'),
(79, 'GE', 'Georgia\n'),
(80, 'DE', 'Germany\n'),
(81, 'GH', 'Ghana\n'),
(82, 'GI', 'Gibraltar\n'),
(83, 'GR', 'Greece\n'),
(84, 'GL', 'Greenland\n'),
(85, 'GD', 'Grenada\n'),
(86, 'GP', 'Guadeloupe\n'),
(87, 'GU', 'Guam\n'),
(88, 'GT', 'Guatemala\n'),
(89, 'GG', 'Guernsey\n'),
(90, 'GN', 'Guinea\n'),
(91, 'GW', 'Guinea-bissau\n'),
(92, 'GY', 'Guyana\n'),
(93, 'HT', 'Haiti\n'),
(94, 'HM', 'Heard Island and Mcdonald Islands\n'),
(95, 'VA', 'Holy See (Vatican City State)\n'),
(96, 'HN', 'Honduras\n'),
(97, 'HK', 'Hong Kong\n'),
(98, 'HU', 'Hungary\n'),
(99, 'IS', 'Iceland\n'),
(100, 'IN', 'India\n'),
(101, 'ID', 'Indonesia\n'),
(102, 'IR', 'Iran, Islamic Republic of\n'),
(103, 'IQ', 'Iraq\n'),
(104, 'IE', 'Ireland\n'),
(105, 'IM', 'Isle of Man\n'),
(106, 'IL', 'Israel\n'),
(107, 'IT', 'Italy\n'),
(108, 'JM', 'Jamaica\n'),
(109, 'JP', 'Japan\n'),
(110, 'JE', 'Jersey\n'),
(111, 'JO', 'Jordan\n'),
(112, 'KZ', 'Kazakhstan\n'),
(113, 'KE', 'Kenya\n'),
(114, 'KI', 'Kiribati\n'),
(115, 'KP', 'Korea, Democratic People''s Republic of\n'),
(116, 'KR', 'Korea, Republic of\n'),
(117, 'KW', 'Kuwait\n'),
(118, 'KG', 'Kyrgyzstan\n'),
(119, 'LA', 'Lao People''s Democratic Republic\n'),
(120, 'LV', 'Latvia\n'),
(121, 'LB', 'Lebanon\n'),
(122, 'LS', 'Lesotho\n'),
(123, 'LR', 'Liberia\n'),
(124, 'LY', 'Libyan Arab Jamahiriya\n'),
(125, 'LI', 'Liechtenstein\n'),
(126, 'LT', 'Lithuania\n'),
(127, 'LU', 'Luxembourg\n'),
(128, 'MO', 'Macao\n'),
(129, 'MK', 'Macedonia, The Former Yugoslav Republic of\n'),
(130, 'MG', 'Madagascar\n'),
(131, 'MW', 'Malawi\n'),
(132, 'MY', 'Malaysia\n'),
(133, 'MV', 'Maldives\n'),
(134, 'ML', 'Mali\n'),
(135, 'MT', 'Malta\n'),
(136, 'MH', 'Marshall Islands\n'),
(137, 'MQ', 'Martinique\n'),
(138, 'MR', 'Mauritania\n'),
(139, 'MU', 'Mauritius\n'),
(140, 'YT', 'Mayotte\n'),
(141, 'MX', 'Mexico\n'),
(142, 'FM', 'Micronesia, Federated States of\n'),
(143, 'MD', 'Moldova, Republic of\n'),
(144, 'MC', 'Monaco\n'),
(145, 'MN', 'Mongolia\n'),
(146, 'ME', 'Montenegro\n'),
(147, 'MS', 'Montserrat\n'),
(148, 'MA', 'Morocco\n'),
(149, 'MZ', 'Mozambique\n'),
(150, 'MM', 'Myanmar\n'),
(151, 'NA', 'Namibia\n'),
(152, 'NR', 'Nauru\n'),
(153, 'NP', 'Nepal\n'),
(154, 'NL', 'Netherlands\n'),
(155, 'AN', 'Netherlands Antilles\n'),
(156, 'NC', 'New Caledonia\n'),
(157, 'NZ', 'New Zealand\n'),
(158, 'NI', 'Nicaragua\n'),
(159, 'NE', 'Niger\n'),
(160, 'NG', 'Nigeria\n'),
(161, 'NU', 'Niue\n'),
(162, 'NF', 'Norfolk Island\n'),
(163, 'MP', 'Northern Mariana Islands\n'),
(164, 'NO', 'Norway\n'),
(165, 'OM', 'Oman\n'),
(166, 'PK', 'Pakistan\n'),
(167, 'PW', 'Palau\n'),
(168, 'PS', 'Palestinian Territory, Occupied\n'),
(169, 'PA', 'Panama\n'),
(170, 'PG', 'Papua New Guinea\n'),
(171, 'PY', 'Paraguay\n'),
(172, 'PE', 'Peru\n'),
(173, 'PH', 'Philippines\n'),
(174, 'PN', 'Pitcairn\n'),
(175, 'PL', 'Poland\n'),
(176, 'PT', 'Portugal\n'),
(177, 'PR', 'Puerto Rico\n'),
(178, 'QA', 'Qatar\n'),
(179, 'RE', 'Reunion\n'),
(180, 'RO', 'Romania\n'),
(181, 'RU', 'Russian Federation\n'),
(182, 'RW', 'Rwanda\n'),
(183, 'SH', 'Saint Helena\n'),
(184, 'KN', 'Saint Kitts and Nevis\n'),
(185, 'LC', 'Saint Lucia\n'),
(186, 'PM', 'Saint Pierre and Miquelon\n'),
(187, 'VC', 'Saint Vincent and The Grenadines\n'),
(188, 'WS', 'Samoa\n'),
(189, 'SM', 'San Marino\n'),
(190, 'ST', 'Sao Tome and Principe\n'),
(191, 'SA', 'Saudi Arabia\n'),
(192, 'SN', 'Senegal\n'),
(193, 'RS', 'Serbia\n'),
(194, 'SC', 'Seychelles\n'),
(195, 'SL', 'Sierra Leone\n'),
(196, 'SG', 'Singapore\n'),
(197, 'SK', 'Slovakia\n'),
(198, 'SI', 'Slovenia\n'),
(199, 'SB', 'Solomon Islands\n'),
(200, 'SO', 'Somalia\n'),
(201, 'ZA', 'South Africa\n'),
(202, 'GS', 'South Georgia and The South Sandwich Islands\n'),
(203, 'ES', 'Spain\n'),
(204, 'LK', 'Sri Lanka\n'),
(205, 'SD', 'Sudan\n'),
(206, 'SR', 'Suriname\n'),
(207, 'SJ', 'Svalbard and Jan Mayen\n'),
(208, 'SZ', 'Swaziland\n'),
(209, 'SE', 'Sweden\n'),
(210, 'CH', 'Switzerland\n'),
(211, 'SY', 'Syrian Arab Republic\n'),
(212, 'TW', 'Taiwan, Province of China\n'),
(213, 'TJ', 'Tajikistan\n'),
(214, 'TZ', 'Tanzania, United Republic of\n'),
(215, 'TH', 'Thailand\n'),
(216, 'TL', 'Timor-leste\n'),
(217, 'TG', 'Togo\n'),
(218, 'TK', 'Tokelau\n'),
(219, 'TO', 'Tonga\n'),
(220, 'TT', 'Trinidad and Tobago\n'),
(221, 'TN', 'Tunisia\n'),
(222, 'TR', 'Turkey\n'),
(223, 'TM', 'Turkmenistan\n'),
(224, 'TC', 'Turks and Caicos Islands\n'),
(225, 'TV', 'Tuvalu\n'),
(226, 'UG', 'Uganda\n'),
(227, 'UA', 'Ukraine\n'),
(228, 'AE', 'United Arab Emirates\n'),
(229, 'GB', 'United Kingdom\n'),
(230, 'US', 'United States\n'),
(231, 'UM', 'United States Minor Outlying Islands\n'),
(232, 'UY', 'Uruguay\n'),
(233, 'UZ', 'Uzbekistan\n'),
(234, 'VU', 'Vanuatu\n'),
(235, 'VE', 'Venezuela\n'),
(236, 'VN', 'Viet Nam\n'),
(237, 'VG', 'Virgin Islands, British\n'),
(238, 'VI', 'Virgin Islands, U.S.\n'),
(239, 'WF', 'Wallis and Futuna\n'),
(240, 'EH', 'Western Sahara\n'),
(241, 'YE', 'Yemen\n'),
(242, 'ZM', 'Zambia\n'),
(243, 'ZW', 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `Encounters`
--

DROP TABLE IF EXISTS `Encounters`;
CREATE TABLE `Encounters` (
  `encounter_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `complete` tinyint(2) NOT NULL DEFAULT '0',
  `active` varchar(1) NOT NULL DEFAULT 'y',
  `user_encounter_id` INT( 4 ) NULL DEFAULT '0',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00', 
  PRIMARY KEY (`encounter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Triggers `Encounters`
--
DROP TRIGGER IF EXISTS `encounters_date_mod`;
DELIMITER //
CREATE TRIGGER `encounters_date_mod` BEFORE INSERT ON `Encounters`
 FOR EACH ROW SET NEW.date_modified = CURRENT_TIMESTAMP
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `Encounter_Reasons`
--

DROP TABLE IF EXISTS `Encounter_Reasons`;
CREATE TABLE `Encounter_Reasons` (
  `reason_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `encounter_id` mediumint(9) NOT NULL,
  `refset_id` int(11) NOT NULL COMMENT 'this differentiates between health issues & RFE - 0 for RFE, 1 for HI',
  `sct_id` int(11) DEFAULT NULL,
  `sct_scale` int(11) DEFAULT NULL,
  `sct_alt` varchar(250) DEFAULT NULL,
  `icpc_id` varchar(10) DEFAULT NULL,
  `icpc_scale` int(11) DEFAULT NULL,
  `icpc_alt_id` varchar(10) DEFAULT NULL,
  `active` varchar(1) NOT NULL DEFAULT 'y',
  `date_created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00', 
  PRIMARY KEY (`reason_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Triggers `Encounter_Reasons`
--
DROP TRIGGER IF EXISTS `reasons_date_mod`;
DELIMITER //
CREATE TRIGGER `reasons_date_mod` BEFORE INSERT ON `Encounter_Reasons`
 FOR EACH ROW SET NEW.date_modified = CURRENT_TIMESTAMP
//
DELIMITER ;

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

--
-- Dumping data for table `Gender`
--

INSERT INTO `Gender` (`gender_id`, `gender`) VALUES
(0, 'Male'),
(1, 'Female');

-- --------------------------------------------------------

--
-- Table structure for table `RefSetType`
--

DROP TABLE IF EXISTS `RefSet_Type`;
CREATE TABLE `RefSet_Type` (
  `refset_type_id` int(11) NOT NULL,
  `refset_type` varchar(20) NOT NULL,
  UNIQUE KEY `id` (`refset_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `RefSetType`
--

INSERT INTO `RefSet_Type` (`refset_type_id`, `refset_type`) VALUES
(0, 'RFE'),
(1, 'Health Issue');

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Table structure for table `Title`
--

DROP TABLE IF EXISTS `Title`;
CREATE TABLE `Title` (
  `title_id` int(11) NOT NULL,
  `title` varchar(32) CHARACTER SET utf8 NOT NULL,
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
-- Table structure for table `TestApproach`
--
DROP TABLE IF EXISTS `TestApproach`;

CREATE TABLE `TestApproach` (
  `option_id` smallint(6) NOT NULL,
  `option_label` varchar(50) NOT NULL,
  PRIMARY KEY (`option_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Dumping data for table `TestApproach`
--

INSERT INTO `TestApproach` (`option_id`, `option_label`) VALUES
(1, 'GP/FP SNOMED CT RefSet + map to ICPC-2'),
(2, 'ICPC-2 map + GP/FP SNOMED CT RefSet'),
(3, 'GP/FP SNOMED CT RefSet only');
-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
CREATE TABLE `Users` (
  `user_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `title_id` int(11) DEFAULT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `gender_id` int(11) DEFAULT NULL,
  `country_id` int(11) NOT NULL,
  `option_id` smallint(6) NOT NULL DEFAULT '1',
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `verification` varchar(256) DEFAULT NULL,
  `field_test_complete` smallint(6) NOT NULL DEFAULT '0',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00', 
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`user_id`, `title_id`, `first_name`, `last_name`, `email`, `password`, `role`, `age`, `gender_id`, `country_id`, `option_id`, `verified`, `verification`, `field_test_complete`) VALUES
(1, 0, 'Bob', 'Smith', 'rda@ihtsdo.org', '80ec3d3b70f87a52e614bf66d050d245', 'Doctor', 36, 0, 229, 1, 1, '24d1b323e1bcb772e3c1ac115009d8cb', 0),
(2, 5, 'ICPC', 'First', 'fieldtesttool@ihtsdo.org', '80ec3d3b70f87a52e614bf66d050d245', 'Doctor', 23, 1, 72, 2, 1, 'f31da5de60581be02dec07fbbbe707e6', 0),
(3, 6, 'Only', 'Refset', 'refsettest@ihtsdo.org', '80ec3d3b70f87a52e614bf66d050d245', 'Nurse', 34, 0, 58, 3, 1, '09377f32e5a980f5f371f7ff34ed8398', 0);

--
-- Triggers `Users`
--
DROP TRIGGER IF EXISTS `user_date_mod`;
DELIMITER //
CREATE TRIGGER `user_date_mod` BEFORE INSERT ON `Users`
 FOR EACH ROW SET NEW.date_modified = CURRENT_TIMESTAMP
//
DELIMITER ;
