-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 17, 2019 at 09:17 AM
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
-- Table structure for table `weigh_category`
--

DROP TABLE IF EXISTS `weigh_category`;
CREATE TABLE IF NOT EXISTS `weigh_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `axle` int(11) NOT NULL,
  `code` int(11) NOT NULL,
  `date` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `weigh_category`
--

INSERT INTO `weigh_category` (`id`, `name`, `axle`, `code`, `date`) VALUES
(1, '2 AX SINGLE(Bedford)', 2, 200, '2019-05-31'),
(2, '2 AX SINGLE(Hino/Nissan)', 2, 200, '2019-05-31'),
(3, '3 AX TENDEM', 3, 310, '2019-05-31'),
(4, '3 AX SINGLE', 3, 300, '2019-05-31'),
(5, '4 AX SINGLE-TENDEM', 4, 410, '2019-05-31'),
(6, '4 AX TENDEM-SINGLE', 4, 420, '2019-05-31'),
(7, '4 AX SINGLE', 4, 430, '2019-05-31'),
(8, '5 AX SINGLE-TRIDEM', 5, 570, '2019-05-31'),
(9, '5 AX TENDEM-TENDEM', 5, 530, '2019-05-31'),
(10, '5 AX SINGLE-SINGLE-TENDEM', 5, 510, '2019-05-31'),
(11, '5 AX TENDEM-SINGLE-SINGLE', 5, 520, '2019-05-31'),
(12, '6 AX TENDEM-TRIDEM', 6, 610, '2019-05-31'),
(13, '6 AX TENDEM-SINGLE-TENDEM', 6, 630, '2019-05-31');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
