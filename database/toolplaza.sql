-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2019 at 11:26 AM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.8

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
-- Table structure for table `toolplaza`
--

CREATE TABLE `toolplaza` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `google_map_status` int(1) NOT NULL DEFAULT '0' COMMENT '0=inactive,1=active',
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `toolplaza`
--

INSERT INTO `toolplaza` (`id`, `name`, `google_map_status`, `status`) VALUES
(1, 'Iqbal Shaheed', 1, 1),
(2, 'Harro', 1, 1),
(3, 'Sangjani', 1, 1),
(4, 'IMDCW', 1, 1),
(5, 'Qutbal', 1, 1),
(6, 'Mandra', 1, 1),
(7, 'Tarakki', 1, 1),
(8, 'Jhelum', 1, 1),
(9, 'Chenab', 1, 1),
(10, 'Harappa', 1, 1),
(11, 'Khan Bela', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `toolplaza`
--
ALTER TABLE `toolplaza`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `toolplaza`
--
ALTER TABLE `toolplaza`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
