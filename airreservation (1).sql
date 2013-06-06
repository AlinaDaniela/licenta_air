-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 06, 2013 at 05:40 PM
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  PRIMARY KEY (`id_utilizator`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
