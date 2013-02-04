-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Vert: localhost
-- Generert den: 04. Feb, 2013 14:23 PM
-- Tjenerversjon: 5.1.63
-- PHP-Versjon: 5.3.5-1ubuntu7.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `whitelist`
--

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `helicrash`
--

CREATE TABLE IF NOT EXISTS `helicrash` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classname` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `chance` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=75 ;
