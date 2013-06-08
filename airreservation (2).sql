-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 08, 2013 at 10:05 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `airreservation`
--

-- --------------------------------------------------------

--
-- Table structure for table `aeroporturi`
--

CREATE TABLE IF NOT EXISTS `aeroporturi` (
  `id_aeroport` int(11) NOT NULL AUTO_INCREMENT,
  `denumire` varchar(100) NOT NULL,
  `cod_iata` varchar(10) NOT NULL,
  `oras` varchar(100) NOT NULL,
  `id_tara` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_aeroport`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `avioane`
--

CREATE TABLE IF NOT EXISTS `avioane` (
  `id_avion` int(11) NOT NULL AUTO_INCREMENT,
  `id_tip` int(11) NOT NULL,
  `id_companie` int(11) NOT NULL,
  `serie` varchar(10) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_avion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `bagaje_companie`
--

CREATE TABLE IF NOT EXISTS `bagaje_companie` (
  `id_bagaje_companie` int(11) NOT NULL AUTO_INCREMENT,
  `id_tip_bagaj` int(11) NOT NULL,
  `id_companie` int(11) NOT NULL,
  `pret` float NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_bagaje_companie`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `categorii_varsta`
--

CREATE TABLE IF NOT EXISTS `categorii_varsta` (
  `id_categorie` int(11) NOT NULL,
  `categorie` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `clasa_zbor`
--

CREATE TABLE IF NOT EXISTS `clasa_zbor` (
  `id_clasa` int(11) NOT NULL AUTO_INCREMENT,
  `id_zbor` int(11) NOT NULL,
  `nr_locuri` int(11) NOT NULL,
  `pret` float NOT NULL,
  PRIMARY KEY (`id_clasa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `clase`
--

CREATE TABLE IF NOT EXISTS `clase` (
  `id_clasa` int(11) NOT NULL AUTO_INCREMENT,
  `clasa` varchar(50) NOT NULL,
  PRIMARY KEY (`id_clasa`),
  UNIQUE KEY `clasa` (`clasa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `companie_clase`
--

CREATE TABLE IF NOT EXISTS `companie_clase` (
  `id_companie_clasa` int(11) NOT NULL AUTO_INCREMENT,
  `id_clasa` int(11) NOT NULL,
  `id_companie` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_companie_clasa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `companie_reduceri_categorii`
--

CREATE TABLE IF NOT EXISTS `companie_reduceri_categorii` (
  `id_comp_red_cat` int(11) NOT NULL AUTO_INCREMENT,
  `id_reducere` int(11) NOT NULL,
  `id_categorie` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_comp_red_cat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `companii_aeriene`
--

CREATE TABLE IF NOT EXISTS `companii_aeriene` (
  `id_companie` int(11) NOT NULL AUTO_INCREMENT,
  `denumire` varchar(50) NOT NULL,
  `descriere` text NOT NULL,
  `id_tara` int(11) NOT NULL,
  `id_tip_companie` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_companie`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fabricanti`
--

CREATE TABLE IF NOT EXISTS `fabricanti` (
  `id_fabricant` int(11) NOT NULL AUTO_INCREMENT,
  `fabricant` varchar(100) NOT NULL,
  PRIMARY KEY (`id_fabricant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `facturi`
--

CREATE TABLE IF NOT EXISTS `facturi` (
  `id_factura` int(11) NOT NULL AUTO_INCREMENT,
  `id_utilizator` int(11) NOT NULL,
  `nume` varchar(50) NOT NULL,
  `prenume` varchar(50) NOT NULL,
  `pret_total` float NOT NULL,
  `nr_factura` int(11) NOT NULL,
  `data_facturare` int(11) NOT NULL,
  `reg_com` varchar(20) NOT NULL,
  `cui` varchar(15) NOT NULL,
  `denumire_firma` varchar(50) NOT NULL,
  `cont_bancar` varchar(24) NOT NULL,
  `id_rezervare` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_factura`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `grupuri_utilizatori`
--

CREATE TABLE IF NOT EXISTS `grupuri_utilizatori` (
  `id_grup_utilizatori` int(11) NOT NULL AUTO_INCREMENT,
  `denumire_grup` varchar(50) NOT NULL,
  PRIMARY KEY (`id_grup_utilizatori`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `grupuri_utilizatori`
--

INSERT INTO `grupuri_utilizatori` (`id_grup_utilizatori`, `denumire_grup`) VALUES
(1, 'admin'),
(2, 'agent'),
(3, 'utilizator_inregistrat');

-- --------------------------------------------------------

--
-- Table structure for table `limbi`
--

CREATE TABLE IF NOT EXISTS `limbi` (
  `id_limba` int(11) NOT NULL AUTO_INCREMENT,
  `limba` varchar(50) NOT NULL,
  PRIMARY KEY (`id_limba`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `meniu_companie`
--

CREATE TABLE IF NOT EXISTS `meniu_companie` (
  `id_meniu_companie` int(11) NOT NULL AUTO_INCREMENT,
  `id_meniu` int(11) NOT NULL,
  `id_companie` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_meniu_companie`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `persoane`
--

CREATE TABLE IF NOT EXISTS `persoane` (
  `id_persoana` int(11) NOT NULL AUTO_INCREMENT,
  `id_titulatura` int(11) NOT NULL,
  `nume` varchar(50) NOT NULL,
  `prenume` varchar(50) NOT NULL,
  PRIMARY KEY (`id_persoana`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `reduceri`
--

CREATE TABLE IF NOT EXISTS `reduceri` (
  `id_tip` int(11) NOT NULL AUTO_INCREMENT,
  `reducere` float NOT NULL,
  PRIMARY KEY (`id_tip`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rezervare_persoana_zbor`
--

CREATE TABLE IF NOT EXISTS `rezervare_persoana_zbor` (
  `id_rez_pers_zbor` int(11) NOT NULL AUTO_INCREMENT,
  `id_rezervare` int(11) NOT NULL,
  `id_persoane` int(11) NOT NULL,
  `id_zbor` int(11) NOT NULL,
  `id_meniu` int(11) NOT NULL,
  `id_clasa` int(11) NOT NULL,
  `id_bagaj` int(11) NOT NULL,
  `loc` varchar(4) NOT NULL,
  `pret` float NOT NULL,
  `id_categorie_varsta` int(11) NOT NULL,
  PRIMARY KEY (`id_rez_pers_zbor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rezervari`
--

CREATE TABLE IF NOT EXISTS `rezervari` (
  `id_rezervare` int(11) NOT NULL AUTO_INCREMENT,
  `id_utilizator` int(11) NOT NULL,
  `cod` varchar(20) NOT NULL,
  `status` int(11) NOT NULL,
  `st_anulat` int(11) NOT NULL,
  `id_factura` int(11) NOT NULL,
  PRIMARY KEY (`id_rezervare`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rute`
--

CREATE TABLE IF NOT EXISTS `rute` (
  `id_ruta` int(11) NOT NULL AUTO_INCREMENT,
  `id_aeroport_plecare` int(11) NOT NULL,
  `id_aeroport_sosire` int(11) NOT NULL,
  PRIMARY KEY (`id_ruta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tari`
--

CREATE TABLE IF NOT EXISTS `tari` (
  `id_tara` int(11) NOT NULL AUTO_INCREMENT,
  `tara` varchar(100) NOT NULL,
  PRIMARY KEY (`id_tara`),
  UNIQUE KEY `tara` (`tara`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=248 ;

--
-- Dumping data for table `tari`
--

INSERT INTO `tari` (`id_tara`, `tara`) VALUES
(1, 'Afghanistan'),
(2, 'Albania'),
(3, 'Algeria'),
(4, 'American Samoa'),
(5, 'Andorra'),
(6, 'Angola'),
(7, 'Anguilla'),
(8, 'Antarctica'),
(9, 'Antigua and Barbuda'),
(10, 'Argentina'),
(11, 'Armenia'),
(12, 'Aruba'),
(13, 'Australia'),
(14, 'Austria'),
(15, 'Azerbaijan'),
(16, 'Bahamas'),
(17, 'Bahrain'),
(18, 'Bangladesh'),
(19, 'Barbados'),
(20, 'Belarus'),
(21, 'Belgium'),
(22, 'Belize'),
(23, 'Benin'),
(24, 'Bermuda'),
(25, 'Bhutan'),
(26, 'Bolivia'),
(27, 'Bosnia and Herzegowina'),
(28, 'Botswana'),
(29, 'Bouvet Island'),
(30, 'Brazil'),
(31, 'British Indian Ocean'),
(32, 'Brunei Darussalam'),
(33, 'Bulgaria'),
(34, 'Burkina Faso '),
(35, 'Burundi'),
(36, 'Cambodia'),
(37, 'Cameroon'),
(38, 'Canada'),
(39, 'Cape Verde'),
(40, 'Cayman Islands'),
(41, 'Central African Republic'),
(42, 'Chad'),
(43, 'Chile'),
(44, 'China'),
(45, 'Christmas Island'),
(46, 'Cocos (Keeling) Islands'),
(47, 'Colombia'),
(48, 'Comoros'),
(49, 'Congo (Democratic Republic of the)'),
(50, 'Congo (Republic of the)'),
(51, 'Cook islands'),
(52, 'Costa Rica'),
(53, 'Cote dIvoire (Ivory Coast)'),
(54, 'Croatia'),
(55, 'Cuba'),
(56, 'Curaco'),
(57, 'Cyprus'),
(58, 'Cyprus (Turkish Republic of Northern)'),
(59, 'Czech Republic'),
(60, 'Denmark'),
(61, 'Djibouti '),
(62, 'Dominica'),
(63, 'Dominican Republic'),
(64, 'East Timor'),
(65, 'Ecuador'),
(66, 'Egypt'),
(67, 'El Salvador'),
(68, 'Equatorial Guinea'),
(69, 'Eritrea'),
(70, 'Estonia'),
(71, 'Ethiopia'),
(72, 'Falkland Islands'),
(73, 'Faroe Islands'),
(74, 'Fiji'),
(75, 'Finland'),
(76, 'France'),
(77, 'France, Metropolitan'),
(78, 'French Guiana '),
(79, 'French Polynesia'),
(80, 'French Southern Territories'),
(81, 'Gabon'),
(82, 'Gambia'),
(83, 'Georgia'),
(84, 'Germany '),
(85, 'Ghana'),
(86, 'Gibraltar'),
(87, 'Greece'),
(88, 'Greenland'),
(89, 'Grenada'),
(90, 'Guadeloupe'),
(91, 'Guam'),
(92, 'Guatemala'),
(93, 'Guinea'),
(94, 'Guinea-Bissau'),
(95, 'Guyana'),
(96, 'Haiti'),
(97, 'Heard and Mc Donald Islands'),
(98, 'Honduras'),
(99, 'Hong Kong'),
(100, 'Hungary'),
(101, 'Iceland'),
(102, 'India'),
(103, 'Indonesia'),
(104, 'Iran'),
(105, 'Iraq'),
(106, 'Ireland'),
(107, 'Israel'),
(108, 'Italy'),
(109, 'Jamaica'),
(110, 'Japan'),
(111, 'Jordan'),
(112, 'Kazakhstan'),
(113, 'Kenya'),
(114, 'Kiribati'),
(115, 'Korea, Republic of (south)'),
(116, 'Kosovo'),
(117, 'Kuwait'),
(118, 'Kyrgyzstan'),
(119, 'Laos (Lao Peoples Democratic Republic)'),
(120, 'Latvia'),
(121, 'Lebanon'),
(122, 'Lesotho'),
(123, 'Liberia'),
(124, 'Libyan Arab Jamahiriya'),
(125, 'Liechtenstein'),
(126, 'Lithuania'),
(127, 'Luxembourg'),
(128, 'Macau'),
(129, 'Macedonia'),
(130, 'Madagascar'),
(131, 'Malawi'),
(132, 'Malaysia'),
(133, 'Maldives'),
(134, 'Mali'),
(135, 'Malta'),
(136, 'Marshall Islands'),
(137, 'Martinique '),
(138, 'Mauritania'),
(139, 'Mauritius'),
(140, 'Mayotte'),
(141, 'Mexico'),
(142, 'Micronesia'),
(143, 'Moldova'),
(144, 'Monaco'),
(145, 'Mongolia'),
(146, 'Montenegro'),
(147, 'Montserrat'),
(148, 'Morocco'),
(149, 'Mozambique'),
(150, 'Myanmar'),
(151, 'Namibia'),
(152, 'Nauru'),
(153, 'Nepal'),
(154, 'Netherlands'),
(155, 'Netherlands Antilles'),
(156, 'New Caledonia'),
(157, 'New Zealand'),
(158, 'Nicaragua'),
(159, 'Niger'),
(160, 'Nigeria'),
(161, 'Niue'),
(162, 'Norfolk Island'),
(163, 'Northern Mariana Islands'),
(164, 'Norway'),
(165, 'Oman'),
(166, 'Pakistan'),
(167, 'Palau'),
(168, 'Palestine'),
(169, 'Panama'),
(170, 'Papua New Guinea'),
(171, 'Paraguay'),
(172, 'Peru'),
(173, 'Philippines'),
(174, 'Pitcairn'),
(175, 'Poland'),
(176, 'Portugal'),
(177, 'Puerto Rico'),
(178, 'Qatar'),
(179, 'Reunion'),
(180, 'Romania'),
(181, 'Russia'),
(182, 'Rwanda'),
(183, 'Saint Helena (UK)'),
(184, 'Saint Kitts and Nevis'),
(185, 'Saint Lucia'),
(186, 'Saint Maarten'),
(187, 'Saint Pierre and Miquelon (FR)'),
(188, 'Saint Thomas'),
(189, 'Saint Vincent and the Grenadines'),
(190, 'Samoa'),
(191, 'San Marino'),
(192, 'Sao Tome and Principe'),
(193, 'Saudi Arabia'),
(194, 'Senegal'),
(195, 'Serbia'),
(196, 'Serbia + Montenegro (old)'),
(197, 'Seychelles'),
(198, 'Sierra Leone'),
(199, 'Singapore'),
(200, 'Slovakia'),
(201, 'Slovenia'),
(202, 'Solomon Islands'),
(203, 'Somalia'),
(204, 'South Africa'),
(205, 'South Georgia and the South Sandwich Islands'),
(206, 'Spain'),
(207, 'Sri Lanka'),
(208, 'Sudan'),
(209, 'Suriname'),
(210, 'Svalbard and Jan Mayen Islands'),
(211, 'Swaziland'),
(212, 'Sweden'),
(213, 'Switzerland'),
(214, 'Syrian Arab Republic'),
(215, 'Taiwan'),
(216, 'Tajikistan'),
(217, 'Tanzania'),
(218, 'Thailand'),
(219, 'Timor-Leste'),
(220, 'Togo'),
(221, 'Tokelau'),
(222, 'Tonga'),
(223, 'Trinidad and Tobago'),
(224, 'Tunisia'),
(225, 'Turkey'),
(226, 'Turkmenistan'),
(227, 'Turks and Caicos Islands'),
(228, 'Tuvalu'),
(229, 'Uganda'),
(230, 'Ukraine'),
(231, 'United Arab Emirates'),
(232, 'United Kingdom'),
(233, 'United States of America'),
(234, 'Uruguay'),
(235, 'Uzbekistan'),
(236, 'Vanuatu'),
(237, 'Vatican City State'),
(238, 'Venezuela'),
(239, 'Vietnam'),
(240, 'Virgin Islands (British)'),
(241, 'Virgin Islands (U.S.)'),
(242, 'Wallis and Futuna Islands'),
(243, 'Western Sahara'),
(244, 'Yemen'),
(245, 'Zaire'),
(246, 'Zambia'),
(247, 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `tipuri_avion`
--

CREATE TABLE IF NOT EXISTS `tipuri_avion` (
  `id_tip_avion` int(11) NOT NULL AUTO_INCREMENT,
  `id_fabricant` int(11) NOT NULL,
  `tip` varchar(50) NOT NULL,
  PRIMARY KEY (`id_tip_avion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tipuri_bagaj`
--

CREATE TABLE IF NOT EXISTS `tipuri_bagaj` (
  `id_tip_bagaj` int(11) NOT NULL AUTO_INCREMENT,
  `tip_bagaj` varchar(50) NOT NULL,
  PRIMARY KEY (`id_tip_bagaj`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tipuri_companii`
--

CREATE TABLE IF NOT EXISTS `tipuri_companii` (
  `id_tip_companie` int(11) NOT NULL AUTO_INCREMENT,
  `tip` varchar(50) NOT NULL,
  PRIMARY KEY (`id_tip_companie`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tipuri_meniu`
--

CREATE TABLE IF NOT EXISTS `tipuri_meniu` (
  `id_meniu` int(11) NOT NULL AUTO_INCREMENT,
  `denumire` varchar(50) NOT NULL,
  PRIMARY KEY (`id_meniu`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `titulaturi`
--

CREATE TABLE IF NOT EXISTS `titulaturi` (
  `id_titulatura` int(11) NOT NULL AUTO_INCREMENT,
  `titulatura` varchar(25) NOT NULL,
  PRIMARY KEY (`id_titulatura`),
  UNIQUE KEY `titulatura` (`titulatura`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `titulaturi`
--

INSERT INTO `titulaturi` (`id_titulatura`, `titulatura`) VALUES
(3, 'Doamna'),
(1, 'Domnisoara'),
(2, 'Domnul');

-- --------------------------------------------------------

--
-- Table structure for table `traduceri`
--

CREATE TABLE IF NOT EXISTS `traduceri` (
  `id_traducere` int(11) NOT NULL AUTO_INCREMENT,
  `tabela_referinta` varchar(50) NOT NULL,
  `camp_referinta` varchar(50) NOT NULL,
  `id_referinta` int(11) NOT NULL,
  `traducere` varchar(100) NOT NULL,
  `id_limba` int(11) NOT NULL,
  PRIMARY KEY (`id_traducere`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `utilizatori`
--

CREATE TABLE IF NOT EXISTS `utilizatori` (
  `id_utilizator` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_grup` int(11) NOT NULL,
  `id_titulatura` int(11) NOT NULL,
  `nume_utilizator` varchar(50) NOT NULL,
  `nume` varchar(50) NOT NULL,
  `prenume` varchar(50) NOT NULL,
  `adresa` varchar(100) NOT NULL,
  `oras` varchar(50) NOT NULL,
  `cod_postal` varchar(6) NOT NULL,
  `id_tara` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefon` varchar(10) NOT NULL,
  `parola` varchar(255) NOT NULL,
  `data_creare` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `cod_confirmare` varchar(25) NOT NULL,
  PRIMARY KEY (`id_utilizator`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `utilizatori`
--

INSERT INTO `utilizatori` (`id_utilizator`, `id_grup`, `id_titulatura`, `nume_utilizator`, `nume`, `prenume`, `adresa`, `oras`, `cod_postal`, `id_tara`, `email`, `telefon`, `parola`, `data_creare`, `status`, `cod_confirmare`) VALUES
(1, 1, 1, 'GAlina', 'Gheorghe', 'Smeagol', 'Str. Valul lui Traian, nr. 46', 'Constanta', '900147', 180, 'alinadanielagheorghe@gmail.com', '0729852902', '64e1f34a962fdae92da160ccf8674e7b0d14d477', 1370609688, 0, 'y0pd4gcstw19876rxhnkv3m2q'),
(13, 2, 1, 'Smeagol', 'Gheorghe', 'Smeagol', 'Str. Valul lui Traian, nr. 46', 'Constanta', '900147', 180, 'smeagol.woof@gmail.com', '0729852902', '64e1f34a962fdae92da160ccf8674e7b0d14d477', 1370618455, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `zboruri`
--

CREATE TABLE IF NOT EXISTS `zboruri` (
  `id_zbor` int(11) NOT NULL AUTO_INCREMENT,
  `cod_zbor` varchar(20) NOT NULL,
  `id_avion` int(11) NOT NULL,
  `id_ruta` int(11) NOT NULL,
  `data_plecare` int(11) NOT NULL,
  `data_sosire` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_zbor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
