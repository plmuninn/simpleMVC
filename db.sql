-- phpMyAdmin SQL Dump
-- version 3.3.10
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 25, 2012 at 11:03 AM
-- Server version: 5.1.58
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `loki_mvc`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE IF NOT EXISTS `blog` (
  `id_blog` int(11) NOT NULL AUTO_INCREMENT,
  `short` varchar(100) DEFAULT NULL,
  `long` varchar(150) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_blog`)
) ENGINE=InnoDB;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id_category` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB ;


-- --------------------------------------------------------

--
-- Table structure for table `configuration`
--

CREATE TABLE IF NOT EXISTS `configuration` (
  `id_configuration` int(11) NOT NULL,
  `Date_format` varchar(45) NOT NULL,
  `Time_zone` varchar(45) NOT NULL,
  `File_prev` varchar(45) NOT NULL,
  `Folder_prev` varchar(45) NOT NULL,
  `Admin_Email` varchar(45) NOT NULL,
  `Admin_id` varchar(45) NOT NULL,
  `Lang` varchar(45) NOT NULL,
  `Time_Format` varchar(45) NOT NULL,
  `Template` varchar(50) NOT NULL,
  PRIMARY KEY (`id_configuration`)
) ENGINE=InnoDB;

--
-- Dumping data for table `configuration`
--

INSERT INTO `configuration` (`id_configuration`, `Date_format`, `Time_zone`, `File_prev`, `Folder_prev`, `Admin_Email`, `Admin_id`, `Lang`, `Time_Format`, `Template`) VALUES
(1, 'm/d/y', '(GMT+01:00) Warsaw', '0777', '0777', 's8066@pjwstk.edu.pl', '1', 'PL', 'H:i', 'standard');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id_post` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(11500)  NOT NULL,
  `topic_id_topic` int(11) NOT NULL,
  `user_id_user` int(11) NOT NULL,
  `added_date` varchar(8) NOT NULL,
  `added_time` varchar(8) NOT NULL,
  PRIMARY KEY (`id_post`)
) ENGINE=InnoDB ;

-- --------------------------------------------------------

--
-- Table structure for table `shoutbox`
--

CREATE TABLE IF NOT EXISTS `shoutbox` (
  `id_shoutbox` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(100) NOT NULL,
  `user_id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_shoutbox`)
) ENGINE=InnoDB ;

-- --------------------------------------------------------

--
-- Table structure for table `topic`
--

CREATE TABLE IF NOT EXISTS `topic` (
  `id_topic` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) DEFAULT NULL,
  `category_id_category` int(11) NOT NULL,
  `user_id_user` int(11) NOT NULL,
  `added_date` varchar(8) NOT NULL,
  `added_time` varchar(45) NOT NULL,
  `first_topic` int(11) NOT NULL,
  PRIMARY KEY (`id_topic`)
) ENGINE=InnoDB ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(45) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `surname` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB  ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `login`, `email`, `password`, `name`, `surname`) VALUES
(1, 'admin', 'biuro@onewebpro.pl', '21232f297a57a5a743894a0e4a801fc3', 'Maciej', 'Roma&Aring;'),
(2, 'user', 'maciej.romanski@o2.pl', 'ee11cbb19052e40b07aac0ca060c23ee', 'user', 'user');
