-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 17, 2019 at 09:22 AM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nha`
--

-- --------------------------------------------------------

--
-- Table structure for table `weigh_limit`
--

DROP TABLE IF EXISTS `weigh_limit`;
CREATE TABLE IF NOT EXISTS `weigh_limit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `category_code` varchar(30) NOT NULL,
  `weigh_limit` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `weigh_limit`
--

INSERT INTO `weigh_limit` (`id`, `cat_id`, `category_code`, `weigh_limit`) VALUES
(1, 1, '200', '17.5'),
(2, 2, '200', '17.5'),
(3, 3, '310', '27.5'),
(4, 4, '300', '29.5'),
(5, 5, '410', '39.5'),
(6, 6, '420', '39.5'),
(7, 7, '430', '41.5'),
(8, 8, '570', '48.5'),
(9, 9, '530', '49.5'),
(10, 10, '510', '51.5'),
(11, 11, '520', '51.5'),
(12, 12, '610', '58.5'),
(13, 13, '630', '61.5');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
