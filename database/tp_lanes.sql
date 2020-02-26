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
-- Table structure for table `tp_lanes`
--

CREATE TABLE `tp_lanes` (
  `id` int(11) NOT NULL,
  `tollplaza` int(11) NOT NULL,
  `name` text NOT NULL,
  `bound` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tp_lanes`
--

INSERT INTO `tp_lanes` (`id`, `tollplaza`, `name`, `bound`) VALUES
(1, 1, 'N1', 'N'),
(2, 1, 'N2', 'N'),
(3, 1, 'N3', 'N'),
(4, 1, 'N4', 'N'),
(5, 1, 'S1', 'S'),
(6, 1, 'S2', 'S'),
(7, 1, 'S3', 'S'),
(8, 1, 'S4', 'S'),
(9, 2, 'N1', 'N'),
(10, 2, 'N2', 'N'),
(11, 2, 'N3', 'N'),
(12, 2, 'N4', 'N'),
(13, 2, 'S1', 'S'),
(14, 2, 'S2', 'S'),
(15, 2, 'S3', 'S'),
(16, 2, 'S4', 'S'),
(17, 3, 'N1', 'N'),
(18, 3, 'N2', 'N'),
(19, 3, 'N3', 'N'),
(20, 3, 'N4', 'N'),
(21, 3, 'N5', 'N'),
(22, 3, 'N6', 'N'),
(23, 3, 'S1', 'S'),
(24, 3, 'S2', 'S'),
(25, 3, 'S3', 'S'),
(26, 3, 'S4', 'S'),
(27, 3, 'S5', 'S'),
(28, 3, 'S6', 'S'),
(29, 4, 'N1', 'N'),
(30, 4, 'N2', 'N'),
(31, 4, 'N3', 'N'),
(32, 4, 'S1', 'S'),
(33, 4, 'S2', 'S'),
(34, 4, 'S3', 'S'),
(35, 5, 'N1', 'N'),
(36, 5, 'N2', 'N'),
(37, 5, 'N3', 'N'),
(38, 5, 'S1', 'S'),
(39, 5, 'S2', 'S'),
(40, 5, 'S3', 'S'),
(41, 6, 'N1', 'N'),
(42, 6, 'N2', 'N'),
(43, 6, 'N3', 'N'),
(44, 6, 'N4', 'N'),
(45, 6, 'S1', 'S'),
(46, 6, 'S2', 'S'),
(47, 6, 'S3', 'S'),
(48, 6, 'S4', 'S'),
(49, 7, 'N1', 'N'),
(50, 7, 'N2', 'N'),
(51, 7, 'N3', 'N'),
(52, 7, 'N4', 'N'),
(53, 7, 'S1', 'S'),
(54, 7, 'S2', 'S'),
(55, 7, 'S3', 'S'),
(56, 7, 'S4', 'S'),
(57, 8, 'N1', 'N'),
(58, 8, 'N2', 'N'),
(59, 8, 'N3', 'N'),
(60, 8, 'N4', 'N'),
(61, 8, 'S1', 'S'),
(62, 8, 'S2', 'S'),
(63, 8, 'S3', 'S'),
(64, 8, 'S4', 'S'),
(65, 9, 'S1', 'S'),
(66, 9, 'S2', 'S'),
(67, 9, 'S3', 'S'),
(68, 9, 'S4', 'S'),
(69, 10, 'N1', 'N'),
(70, 10, 'N2', 'N'),
(71, 10, 'N3', 'N'),
(72, 10, 'N4', 'N'),
(73, 10, 'S1', 'S'),
(74, 10, 'S2', 'S'),
(75, 10, 'S3', 'S'),
(76, 10, 'S4', 'S'),
(77, 11, 'N1', 'N'),
(78, 11, 'N2', 'N'),
(79, 11, 'N3', 'N'),
(80, 11, 'N4', 'N'),
(81, 11, 'S1', 'S'),
(82, 11, 'S2', 'S'),
(83, 11, 'S3', 'S'),
(84, 11, 'S4', 'S');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tp_lanes`
--
ALTER TABLE `tp_lanes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tp_lanes`
--
ALTER TABLE `tp_lanes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
