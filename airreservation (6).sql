-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 18, 2013 at 02:32 PM
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
  `cod_iata` varchar(3) NOT NULL,
  `oras` varchar(100) NOT NULL,
  `id_tara` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_aeroport`),
  UNIQUE KEY `cod_iata` (`cod_iata`),
  UNIQUE KEY `denumire` (`denumire`),
  UNIQUE KEY `id_aeroport` (`id_aeroport`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `aeroporturi`
--

INSERT INTO `aeroporturi` (`id_aeroport`, `denumire`, `cod_iata`, `oras`, `id_tara`, `status`) VALUES
(1, 'Denmark Aalborg', 'AAL', 'Aalborg', 60, 1),
(3, 'Norway Vigra', 'AES', 'Aalesund', 164, 1),
(4, 'Denmark Tirstrup', 'AAR', 'Aarhus', 60, 1),
(5, 'Abbotsford Airport', 'YXX', 'Abbotsford', 38, 1),
(6, 'United Kingdom Dyce', 'ABZ', 'Aberdeen', 248, 1),
(7, 'Marka International ', 'ADJ', 'Amman', 111, 1),
(8, 'Aeroportul Arad', 'ARW', 'Arad', 180, 1),
(9, 'Aeroportul International Henri Coanda', 'OTP', 'Otopeni', 180, 1);

-- --------------------------------------------------------

--
-- Table structure for table `avioane`
--

CREATE TABLE IF NOT EXISTS `avioane` (
  `id_avion` int(11) NOT NULL AUTO_INCREMENT,
  `id_tip_avion` int(11) NOT NULL,
  `capacitate` int(11) NOT NULL,
  `serie` varchar(10) NOT NULL,
  PRIMARY KEY (`id_avion`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `avioane`
--

INSERT INTO `avioane` (`id_avion`, `id_tip_avion`, `capacitate`, `serie`) VALUES
(1, 1, 500, 'SE10'),
(2, 2, 300, 'E23');

-- --------------------------------------------------------

--
-- Table structure for table `bagaje_companie`
--

CREATE TABLE IF NOT EXISTS `bagaje_companie` (
  `id_bagaje_companie` int(11) NOT NULL AUTO_INCREMENT,
  `id_tip_bagaj` int(11) NOT NULL,
  `id_companie` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_bagaje_companie`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `bagaje_companie`
--

INSERT INTO `bagaje_companie` (`id_bagaje_companie`, `id_tip_bagaj`, `id_companie`, `status`) VALUES
(1, 1, 2, 1),
(2, 2, 2, 1),
(3, 3, 2, 1),
(4, 2, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categorii_varsta`
--

CREATE TABLE IF NOT EXISTS `categorii_varsta` (
  `id_categorie_varsta` int(11) NOT NULL AUTO_INCREMENT,
  `categorie` varchar(10) NOT NULL,
  PRIMARY KEY (`id_categorie_varsta`),
  UNIQUE KEY `id_categorie_varsta` (`id_categorie_varsta`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `categorii_varsta`
--

INSERT INTO `categorii_varsta` (`id_categorie_varsta`, `categorie`) VALUES
(1, 'Sub 3 ani'),
(2, '3-10 ani'),
(3, 'Peste 50');

-- --------------------------------------------------------

--
-- Table structure for table `clase`
--

CREATE TABLE IF NOT EXISTS `clase` (
  `id_clasa` int(11) NOT NULL AUTO_INCREMENT,
  `clasa` varchar(50) NOT NULL,
  PRIMARY KEY (`id_clasa`),
  UNIQUE KEY `clasa` (`clasa`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `clase`
--

INSERT INTO `clase` (`id_clasa`, `clasa`) VALUES
(5, 'Business'),
(4, 'Clasa intai'),
(6, 'Economica');

-- --------------------------------------------------------

--
-- Table structure for table `companie_avioane`
--

CREATE TABLE IF NOT EXISTS `companie_avioane` (
  `id_companie_avion` int(11) NOT NULL AUTO_INCREMENT,
  `id_companie` int(11) NOT NULL,
  `id_avion` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_companie_avion`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `companie_avioane`
--

INSERT INTO `companie_avioane` (`id_companie_avion`, `id_companie`, `id_avion`, `status`) VALUES
(1, 1, 1, 1),
(2, 2, 2, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `companie_clase`
--

INSERT INTO `companie_clase` (`id_companie_clasa`, `id_clasa`, `id_companie`, `status`) VALUES
(1, 4, 2, 1),
(2, 5, 2, 1),
(3, 5, 1, 1),
(4, 4, 1, 1),
(5, 6, 1, 1),
(6, 6, 2, 1),
(7, 5, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `companie_reduceri_categorii`
--

CREATE TABLE IF NOT EXISTS `companie_reduceri_categorii` (
  `id_comp_red_cat` int(11) NOT NULL AUTO_INCREMENT,
  `id_companie` int(11) NOT NULL,
  `id_categorie_varsta` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_comp_red_cat`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `companie_reduceri_categorii`
--

INSERT INTO `companie_reduceri_categorii` (`id_comp_red_cat`, `id_companie`, `id_categorie_varsta`, `status`) VALUES
(1, 2, 1, 1),
(2, 2, 2, 1),
(3, 2, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `companii_aeriene`
--

CREATE TABLE IF NOT EXISTS `companii_aeriene` (
  `id_companie` int(11) NOT NULL AUTO_INCREMENT,
  `denumire` varchar(50) NOT NULL,
  `cod` varchar(4) NOT NULL,
  `descriere` text NOT NULL,
  `id_tara` int(11) NOT NULL,
  `id_tip_companie` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_companie`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `companii_aeriene`
--

INSERT INTO `companii_aeriene` (`id_companie`, `denumire`, `cod`, `descriere`, `id_tara`, `id_tip_companie`, `status`) VALUES
(1, 'Wizz Air', 'WZ', 'Companie aeriana din Romania', 1, 3, 1),
(2, 'TAROM', 'TROM', 'Companie aeriana din Romania', 180, 2, 1),
(3, 'Lutfansa', 'LFT', 'Companie aeriana germana', 84, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `fabricanti`
--

CREATE TABLE IF NOT EXISTS `fabricanti` (
  `id_fabricant` int(11) NOT NULL AUTO_INCREMENT,
  `fabricant` varchar(100) NOT NULL,
  PRIMARY KEY (`id_fabricant`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `fabricanti`
--

INSERT INTO `fabricanti` (`id_fabricant`, `fabricant`) VALUES
(1, 'Boeing'),
(2, 'Airbus');

-- --------------------------------------------------------

--
-- Table structure for table `facturi`
--

CREATE TABLE IF NOT EXISTS `facturi` (
  `id_factura` int(11) NOT NULL AUTO_INCREMENT,
  `id_titulatura` int(11) NOT NULL,
  `nume` varchar(50) NOT NULL,
  `prenume` varchar(50) NOT NULL,
  `adresa` varchar(255) NOT NULL,
  `oras` varchar(50) NOT NULL,
  `tara` int(11) NOT NULL,
  `codPostal` varchar(6) NOT NULL,
  `telefon` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `facturi`
--

INSERT INTO `facturi` (`id_factura`, `id_titulatura`, `nume`, `prenume`, `adresa`, `oras`, `tara`, `codPostal`, `telefon`, `email`, `pret_total`, `nr_factura`, `data_facturare`, `reg_com`, `cui`, `denumire_firma`, `cont_bancar`, `id_rezervare`, `status`) VALUES
(1, 1, 'Gheorghe', 'Alina Daniela', 'Str. Valul lui Traian, nr. 46', 'Constanta', 180, '900147', '0729852902', 'alinadanielagheorghe@gmail.com', 2050, 235, 1371254400, '', '', '', '', 1, 1),
(2, 1, 'Gheorghe', 'Alina Daniela', 'Str. Valul lui Traian, nr. 46', 'Constanta', 180, '900147', '0729852902', 'alinadanielagheorghe@gmail.com', 2050, 0, 1371333514, '', '', '', '', 2, 0),
(3, 1, 'Gheorghe ', 'Alina Daniela', 'Str. Valul lui Traian, nr. 46', 'Constanta', 180, '900147', '0729852902', 'alinadanielagheorghe@gmail.com', 6600, 0, 1371382027, '', '', '', '', 0, 0),
(4, 1, 'Gheorghe', 'Alina Daniela', 'Str. Valul lui Traian, nr. 46', 'Constanta', 180, '900147', '0729852902', 'alinadanielagheorghe@gmail.com', 10100, 0, 1371382865, '', '', '', '', 0, 0),
(5, 1, 'Gheorghe', 'Alina Daniela', 'Str. Valul lui Traian, nr. 46', 'Constanta', 180, '900147', '0729852902', 'alinadanielagheorghe@gmail.com', 10100, 0, 1371382965, '', '', '', '', 0, 0),
(6, 1, 'Gheorghe', 'Alina Daniela', 'Str. Valul lui Traian, nr. 46', 'Constanta', 180, '900147', '0729852902', 'alinadanielagheorghe@gmail.com', 10100, 0, 1371383059, '', '', '', '', 0, 0),
(7, 1, 'Gheorghe', 'Alina Daniela', 'Str. Valul lui Traian, nr. 46', 'Constanta', 180, '900147', '0729852902', 'alinadanielagheorghe@gmail.com', 22240, 0, 1371385381, '', '', '', '', 0, 0),
(8, 1, 'Gheorghe', 'Daniela', 'Str. Valul lui Traian', 'Constanta', 180, '900147', '0729852902', 'alinadanielagheorghe@gmail.com', 2750, 0, 1371385966, '', '', '', '', 8, 0),
(14, 3, 'hggj', 'jgjh', 'gjh', 'jhj', 5, '900147', '0729852902', 'alinadanielagheorghe@gmail.com', 810, 2, 1371389147, '', '', '', '', 15, 0),
(15, 1, 'Gheorghe', 'Alina', 'Str. Valul lui Traian', 'Constanta', 180, '900147', '0729852902', 'alinadanielagheorghe@gmail.com', 500, 6, 1371340800, '', '', '', '', 16, 1),
(16, 2, 'Gheorghe', 'Smeagol', 'Str. Valul lui Traian, nr. 46', 'Constanta', 180, '900147', '0729852902', 'smeagol.woof@gmail.com', 990, 7, 1371452724, '', '', '', '', 17, 0);

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
  `cod_limba` varchar(2) NOT NULL,
  PRIMARY KEY (`id_limba`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `limbi`
--

INSERT INTO `limbi` (`id_limba`, `limba`, `cod_limba`) VALUES
(1, 'engleza', '');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `meniu_companie`
--

INSERT INTO `meniu_companie` (`id_meniu_companie`, `id_meniu`, `id_companie`, `status`) VALUES
(1, 1, 2, 1),
(2, 2, 2, 1),
(3, 1, 3, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `persoane`
--

INSERT INTO `persoane` (`id_persoana`, `id_titulatura`, `nume`, `prenume`) VALUES
(1, 1, 'Gheorghe', 'Alina Daniela'),
(2, 2, 'Oasa', 'Bogdan Valentin'),
(3, 1, 'Gheorghe', 'Alina'),
(4, 2, 'Oasa', 'Bogdan'),
(5, 1, 'Gheorghe', 'dsafa'),
(6, 2, 'Gheorghe', 'Smeagol'),
(7, 1, 'Gheorghe', ' Alina Daniela'),
(8, 1, 'Gheorghe', ' Alina Daniela'),
(9, 1, 'Gheorghe', ' Alina Daniela'),
(10, 3, 'Gheorghe ', 'Constanta'),
(11, 2, 'Gheorghe', 'Iulian'),
(12, 1, 'Gheorghe', 'Alina Daniela'),
(13, 1, 'Gheorghe', 'Elena'),
(14, 3, 'fhdh', 'hggf'),
(15, 1, 'gfjf', 'jfjfjf'),
(16, 3, 'scfsd', 'sdff'),
(17, 2, 'dsffdsdsf', 'fdsfdsdf'),
(18, 3, 'gfgf', 'hghg'),
(19, 2, 'hg', 'jg'),
(20, 2, 'hg', 'jg'),
(21, 2, 'hg', 'jg'),
(22, 2, 'Petrescu', 'Ion'),
(23, 1, 'Gheorghe', 'Constanta'),
(24, 2, 'Gheorghe', 'Smeagol');

-- --------------------------------------------------------

--
-- Table structure for table `rezervare_persoana_bagaj`
--

CREATE TABLE IF NOT EXISTS `rezervare_persoana_bagaj` (
  `id_rez_pers_bagaj` int(11) NOT NULL AUTO_INCREMENT,
  `id_rez_pers_zbor` int(11) NOT NULL,
  `id_zbor_bagaje_clasa` int(11) NOT NULL,
  PRIMARY KEY (`id_rez_pers_bagaj`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `rezervare_persoana_bagaj`
--

INSERT INTO `rezervare_persoana_bagaj` (`id_rez_pers_bagaj`, `id_rez_pers_zbor`, `id_zbor_bagaje_clasa`) VALUES
(1, 2, 17),
(2, 4, 17),
(3, 24, 16),
(4, 25, 20),
(5, 26, 26),
(6, 26, 27),
(7, 27, 34),
(8, 31, 37),
(9, 31, 38),
(10, 35, 38),
(11, 37, 20),
(12, 38, 29),
(13, 39, 30),
(14, 40, 11),
(15, 40, 13),
(16, 40, 15),
(17, 42, 26),
(18, 43, 31),
(19, 43, 32),
(20, 43, 34),
(21, 44, 11),
(22, 44, 15),
(23, 45, 20),
(24, 46, 22),
(25, 47, 22),
(26, 48, 22),
(27, 49, 22),
(28, 51, 20);

-- --------------------------------------------------------

--
-- Table structure for table `rezervare_persoana_zbor`
--

CREATE TABLE IF NOT EXISTS `rezervare_persoana_zbor` (
  `id_rez_pers_zbor` int(11) NOT NULL AUTO_INCREMENT,
  `id_rezervare` int(11) NOT NULL,
  `id_persoana` int(11) NOT NULL,
  `id_meniu` int(11) NOT NULL,
  `pret` float NOT NULL,
  `id_categorie_varsta` int(11) NOT NULL,
  PRIMARY KEY (`id_rez_pers_zbor`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

--
-- Dumping data for table `rezervare_persoana_zbor`
--

INSERT INTO `rezervare_persoana_zbor` (`id_rez_pers_zbor`, `id_rezervare`, `id_persoana`, `id_meniu`, `pret`, `id_categorie_varsta`) VALUES
(1, 1, 1, 17, 1000, 0),
(2, 1, 2, 17, 1050, 0),
(3, 2, 3, 17, 1000, 0),
(4, 2, 4, 17, 1050, 0),
(5, 0, 5, 36, 650, 0),
(6, 0, 5, 42, 675, 0),
(7, 0, 6, 36, 650, 0),
(8, 0, 6, 42, 675, 0),
(9, 0, 7, 22, 1000, 0),
(10, 0, 7, 29, 650, 0),
(11, 0, 7, 32, 500, 0),
(12, 0, 7, 13, 500, 0),
(13, 0, 8, 22, 1000, 0),
(14, 0, 8, 29, 650, 0),
(15, 0, 8, 32, 500, 0),
(16, 0, 8, 13, 500, 0),
(17, 0, 9, 22, 1000, 0),
(18, 0, 9, 29, 650, 0),
(19, 0, 9, 32, 500, 0),
(20, 0, 9, 13, 500, 0),
(21, 0, 10, 22, 1000, 0),
(22, 0, 10, 29, 650, 0),
(23, 0, 10, 32, 500, 0),
(24, 0, 10, 15, 1250, 0),
(25, 0, 11, 22, 1010, 0),
(26, 0, 11, 29, 750, 0),
(27, 0, 11, 33, 530, 0),
(28, 0, 11, 13, 500, 0),
(29, 8, 12, 36, 650, 0),
(30, 8, 12, 43, 675, 0),
(31, 8, 13, 36, 750, 0),
(32, 8, 13, 42, 675, 0),
(33, 9, 14, 36, 650, 0),
(34, 9, 14, 42, 675, 0),
(35, 9, 15, 36, 700, 0),
(36, 9, 15, 42, 675, 0),
(37, 0, 16, 24, 1010, 0),
(38, 0, 16, 30, 550, 0),
(39, 0, 16, 32, 510, 0),
(40, 0, 16, 14, 745, 0),
(41, 0, 17, 22, 1000, 0),
(42, 0, 17, 29, 700, 0),
(43, 0, 17, 32, 590, 0),
(44, 0, 17, 13, 720, 0),
(45, 0, 18, 24, 1010, 0),
(46, 0, 19, 25, 810, 0),
(47, 0, 20, 25, 810, 0),
(48, 14, 21, 25, 810, 0),
(49, 15, 22, 25, 810, 0),
(50, 16, 23, 34, 500, 0),
(51, 17, 24, 24, 990, 17);

-- --------------------------------------------------------

--
-- Table structure for table `rezervari`
--

CREATE TABLE IF NOT EXISTS `rezervari` (
  `id_rezervare` int(11) NOT NULL AUTO_INCREMENT,
  `id_utilizator` int(11) NOT NULL,
  `cod` varchar(20) NOT NULL,
  `status` int(11) NOT NULL,
  `status_anulat` int(11) NOT NULL,
  PRIMARY KEY (`id_rezervare`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `rezervari`
--

INSERT INTO `rezervari` (`id_rezervare`, `id_utilizator`, `cod`, `status`, `status_anulat`) VALUES
(1, 13, '1khnvjb38f', 1, 0),
(2, 13, 'w5bt0sgp7q', 1, 0),
(3, 13, 'dyn261g48c', 1, 0),
(4, 13, 'q380hn12cd', 1, 0),
(5, 13, 'b32z18gykw', 1, 0),
(6, 13, 'ms5nr0cgx4', 1, 0),
(7, 13, '6y2h1vfd50', 1, 0),
(8, 13, 'bkjm0p9hga', 1, 0),
(9, 13, '4wdmxzk805', 1, 0),
(10, 13, 'fp0jk3nr1w', 1, 0),
(11, 13, 'c6s32dyxtb', 1, 0),
(12, 13, '2tgfwcm9zb', 1, 0),
(13, 13, 'q3d6zt892c', 1, 0),
(14, 13, '6njp3c1shm', 1, 0),
(15, 13, 'zkjawytv13', 1, 0),
(16, 13, 'qkd28wcg1b', 1, 0),
(17, 13, '13hbxzckfw', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `rute`
--

CREATE TABLE IF NOT EXISTS `rute` (
  `id_ruta` int(11) NOT NULL AUTO_INCREMENT,
  `id_aeroport_plecare` int(11) NOT NULL,
  `id_aeroport_sosire` int(11) NOT NULL,
  `distanta` float NOT NULL,
  PRIMARY KEY (`id_ruta`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `rute`
--

INSERT INTO `rute` (`id_ruta`, `id_aeroport_plecare`, `id_aeroport_sosire`, `distanta`) VALUES
(1, 1, 5, 500),
(3, 1, 3, 500),
(4, 3, 5, 200),
(5, 5, 7, 200),
(6, 7, 9, 300),
(9, 5, 6, 600),
(10, 6, 9, 750),
(11, 1, 9, 600),
(12, 1, 4, 300),
(13, 4, 5, 265),
(16, 9, 1, 250),
(17, 4, 1, 500);

-- --------------------------------------------------------

--
-- Table structure for table `tari`
--

CREATE TABLE IF NOT EXISTS `tari` (
  `id_tara` int(11) NOT NULL AUTO_INCREMENT,
  `tara` varchar(100) NOT NULL,
  PRIMARY KEY (`id_tara`),
  UNIQUE KEY `tara` (`tara`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=249 ;

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
(248, 'Scotland'),
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tipuri_avion`
--

INSERT INTO `tipuri_avion` (`id_tip_avion`, `id_fabricant`, `tip`) VALUES
(1, 1, 'S234'),
(2, 2, 'KL5');

-- --------------------------------------------------------

--
-- Table structure for table `tipuri_bagaj`
--

CREATE TABLE IF NOT EXISTS `tipuri_bagaj` (
  `id_tip_bagaj` int(11) NOT NULL AUTO_INCREMENT,
  `tip_bagaj` varchar(50) NOT NULL,
  PRIMARY KEY (`id_tip_bagaj`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tipuri_bagaj`
--

INSERT INTO `tipuri_bagaj` (`id_tip_bagaj`, `tip_bagaj`) VALUES
(1, 'bagaj de mana'),
(2, 'bagaj'),
(3, 'bagaj special');

-- --------------------------------------------------------

--
-- Table structure for table `tipuri_companii`
--

CREATE TABLE IF NOT EXISTS `tipuri_companii` (
  `id_tip_companie` int(11) NOT NULL AUTO_INCREMENT,
  `tip` varchar(50) NOT NULL,
  PRIMARY KEY (`id_tip_companie`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tipuri_companii`
--

INSERT INTO `tipuri_companii` (`id_tip_companie`, `tip`) VALUES
(1, 'low cost'),
(2, 'nationala'),
(3, 'privata');

-- --------------------------------------------------------

--
-- Table structure for table `tipuri_meniu`
--

CREATE TABLE IF NOT EXISTS `tipuri_meniu` (
  `id_meniu` int(11) NOT NULL AUTO_INCREMENT,
  `denumire` varchar(50) NOT NULL,
  PRIMARY KEY (`id_meniu`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tipuri_meniu`
--

INSERT INTO `tipuri_meniu` (`id_meniu`, `denumire`) VALUES
(1, 'normal'),
(2, 'vegetarian');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `utilizatori`
--

INSERT INTO `utilizatori` (`id_utilizator`, `id_grup`, `id_titulatura`, `nume_utilizator`, `nume`, `prenume`, `adresa`, `oras`, `cod_postal`, `id_tara`, `email`, `telefon`, `parola`, `data_creare`, `status`, `cod_confirmare`) VALUES
(1, 2, 1, 'GAlina', 'Gheorghe', 'Alina', 'Str. Valul lui Traian, nr. 46', 'Constanta', '900147', 180, 'alinadanielagheorghe@gmail.com', '0729852902', 'ffea8b11bc4967af9999338d0e338a1fd7e1addf', 1370609688, 1, ''),
(13, 1, 3, 'Smeagol', 'Gheorghe', 'Smeagol', 'Str. Valul lui Traian, nr. 46', 'Constanta', '900147', 180, 'smeagol.woof@gmail.com', '0729852902', '64e1f34a962fdae92da160ccf8674e7b0d14d477', 1370618455, 1, ''),
(14, 3, 2, 'Alina', 'Gheorghe', 'Alina Daniela', 'Str. Valul lui Traian, nr. 46', 'Constanta', '900147', 180, 'crizuca_nice@yahoo.com', '0729852902', 'ffea8b11bc4967af9999338d0e338a1fd7e1addf', 1371041684, 1, '09ag7vhdsycxzpf54wt8q132n'),
(16, 3, 2, 'GConstanta', 'Gheorghe', 'Constanta', 'Str. Valul lui Traian, nr. 46', 'Constanta', '900147', 180, 'gheorghe_constanta@yahoo.com', '0241674232', 'ec9fc803ead5a995b5bd35881b570198bb48f216', 1371287151, 1, '');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `zboruri`
--

INSERT INTO `zboruri` (`id_zbor`, `cod_zbor`, `id_avion`, `id_ruta`, `data_plecare`, `data_sosire`, `status`) VALUES
(1, '123', 2, 1, 1371460200, 1371467940, 1),
(2, '200', 2, 1, 1357467180, 1357488780, 1),
(3, '562', 2, 3, 1372497000, 1372500900, 1),
(4, '253', 2, 4, 1372504200, 1372506900, 1),
(5, '965', 2, 5, 1372510560, 1372514340, 1),
(6, '109', 2, 6, 1372522200, 1372530600, 1),
(7, '451', 2, 11, 1372511940, 1372522200, 1),
(8, '109', 2, 10, 1399396680, 1399403400, 0),
(9, '263', 2, 6, 1404667080, 1404677400, 1),
(10, '235', 2, 1, 1372522620, 1372529820, 1),
(11, '266', 2, 12, 1372515180, 1372519020, 1),
(12, '563', 2, 13, 1372526220, 1372536960, 1),
(13, '154', 2, 16, 1372612620, 1372623480, 1),
(14, '565', 2, 17, 1372601460, 1372587240, 1);

-- --------------------------------------------------------

--
-- Table structure for table `zbor_bagaje_clasa`
--

CREATE TABLE IF NOT EXISTS `zbor_bagaje_clasa` (
  `id_zbor_bagaje_clasa` int(11) NOT NULL AUTO_INCREMENT,
  `id_zbor_clasa` int(11) NOT NULL,
  `id_tip_bagaj` int(11) NOT NULL,
  `descriere` varchar(50) NOT NULL,
  `pret` float NOT NULL,
  PRIMARY KEY (`id_zbor_bagaje_clasa`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

--
-- Dumping data for table `zbor_bagaje_clasa`
--

INSERT INTO `zbor_bagaje_clasa` (`id_zbor_bagaje_clasa`, `id_zbor_clasa`, `id_tip_bagaj`, `descriere`, `pret`) VALUES
(4, 11, 2, 'bagaj mare', 50),
(7, 5, 1, 'bagaj mic', 50),
(8, 5, 2, 'bagaj mare', 100),
(9, 5, 1, 'bagaj foarte mic', 10),
(10, 14, 1, 'bagaj mic', 20),
(11, 15, 1, 'bagaj mic', 20),
(12, 15, 1, 'bagaj mare', 100),
(13, 15, 2, '2 bagaje', 25),
(14, 15, 2, '3 bagaje', 75),
(15, 15, 3, 'echipament sportiv', 200),
(16, 16, 2, '3 bagaje', 250),
(17, 17, 1, 'bagaj de mana mic', 50),
(18, 17, 2, '2 bagaje', 50),
(19, 18, 2, 'bagaj mic', 50),
(20, 19, 1, 'bagaj mic de mana', 10),
(21, 19, 1, 'bagaj mare de mana', 20),
(22, 20, 1, 'bagaj mic de mana', 10),
(23, 20, 1, 'bagaj mare de mana', 20),
(24, 21, 1, 'bagaj mic de mana', 10),
(25, 21, 1, 'bagaj mare de mana', 20),
(26, 22, 1, 'bagaj de mana mare', 50),
(27, 22, 2, '3 bagaje', 50),
(28, 23, 3, 'echipament sportiv', 50),
(29, 23, 2, '2 bagaje', 50),
(30, 24, 1, 'bagaj mic', 10),
(31, 24, 1, 'bagaj mare', 30),
(32, 24, 2, '2 bagaje', 30),
(33, 24, 2, 'un bagaj', 10),
(34, 24, 3, 'echipament sportiv', 30),
(35, 25, 1, 'bagaj mic', 25),
(36, 25, 1, 'bagaj mare', 50),
(37, 26, 1, 'bagaj mare', 50),
(38, 26, 2, '2 bagaje', 50),
(39, 26, 2, '3 bagaje', 65),
(40, 27, 2, '2 bagaje', 50),
(41, 27, 2, '3 bagaje', 75),
(42, 28, 1, 'bagaj mare', 50),
(43, 28, 1, 'bagaj mic', 50),
(44, 28, 3, 'echipament sportiv', 50);

-- --------------------------------------------------------

--
-- Table structure for table `zbor_clasa`
--

CREATE TABLE IF NOT EXISTS `zbor_clasa` (
  `id_zbor_clasa` int(11) NOT NULL AUTO_INCREMENT,
  `id_zbor` int(11) NOT NULL,
  `id_clasa` int(11) NOT NULL,
  `pret_clasa` int(11) NOT NULL,
  `nr_locuri` int(11) NOT NULL,
  PRIMARY KEY (`id_zbor_clasa`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `zbor_clasa`
--

INSERT INTO `zbor_clasa` (`id_zbor_clasa`, `id_zbor`, `id_clasa`, `pret_clasa`, `nr_locuri`) VALUES
(5, 1, 5, 1000, 100),
(12, 1, 4, 100, 100),
(13, 1, 6, 1000, 50),
(14, 2, 4, 1000, 100),
(15, 6, 6, 500, 244),
(16, 6, 5, 1000, 49),
(17, 7, 5, 1000, 98),
(18, 7, 6, 650, 200),
(19, 3, 4, 1000, 96),
(20, 3, 5, 800, 96),
(21, 3, 6, 600, 100),
(22, 4, 5, 650, 97),
(23, 4, 6, 500, 199),
(24, 5, 6, 500, 296),
(25, 10, 6, 500, 299),
(26, 11, 6, 650, 298),
(27, 12, 6, 1500, 300),
(28, 13, 6, 690, 300),
(29, 14, 6, 675, 294);

-- --------------------------------------------------------

--
-- Table structure for table `zbor_meniu_clasa`
--

CREATE TABLE IF NOT EXISTS `zbor_meniu_clasa` (
  `id_zbor_meniu_clasa` int(11) NOT NULL AUTO_INCREMENT,
  `id_zbor_clasa` int(11) NOT NULL,
  `id_meniu` int(11) NOT NULL,
  PRIMARY KEY (`id_zbor_meniu_clasa`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `zbor_meniu_clasa`
--

INSERT INTO `zbor_meniu_clasa` (`id_zbor_meniu_clasa`, `id_zbor_clasa`, `id_meniu`) VALUES
(7, 11, 1),
(8, 11, 2),
(10, 5, 1),
(11, 14, 1),
(12, 14, 2),
(13, 15, 1),
(14, 15, 2),
(15, 16, 1),
(16, 16, 2),
(17, 17, 2),
(18, 17, 1),
(19, 18, 1),
(20, 18, 2),
(22, 19, 2),
(24, 19, 1),
(25, 20, 1),
(26, 20, 2),
(27, 21, 1),
(28, 21, 2),
(29, 22, 1),
(30, 23, 1),
(32, 24, 2),
(33, 24, 1),
(34, 25, 1),
(35, 25, 2),
(36, 26, 1),
(37, 26, 2),
(38, 27, 1),
(39, 27, 2),
(40, 28, 1),
(41, 28, 2),
(42, 29, 1),
(43, 29, 2);

-- --------------------------------------------------------

--
-- Table structure for table `zbor_reduceri_clasa`
--

CREATE TABLE IF NOT EXISTS `zbor_reduceri_clasa` (
  `id_zbor_reducere_clasa` int(11) NOT NULL AUTO_INCREMENT,
  `id_zbor_clasa` int(11) NOT NULL,
  `id_categorie_varsta` int(11) NOT NULL,
  `reducere` float NOT NULL,
  PRIMARY KEY (`id_zbor_reducere_clasa`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `zbor_reduceri_clasa`
--

INSERT INTO `zbor_reduceri_clasa` (`id_zbor_reducere_clasa`, `id_zbor_clasa`, `id_categorie_varsta`, `reducere`) VALUES
(4, 11, 2, 30),
(5, 11, 1, 30),
(6, 5, 1, 50),
(7, 12, 1, 30),
(8, 14, 1, 20),
(9, 14, 2, 10),
(10, 15, 1, 20),
(11, 15, 2, 10),
(12, 16, 3, 20),
(13, 17, 1, 5),
(14, 17, 2, 15),
(15, 18, 1, 20),
(16, 19, 1, 10),
(17, 19, 2, 2),
(18, 19, 3, 15),
(19, 20, 1, 10),
(20, 20, 2, 2),
(21, 20, 3, 15),
(22, 21, 1, 10),
(23, 21, 2, 2),
(24, 21, 3, 15),
(25, 24, 1, 10),
(26, 24, 2, 30),
(27, 24, 3, 20),
(28, 28, 1, 20),
(29, 28, 2, 10),
(30, 28, 3, 30);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
