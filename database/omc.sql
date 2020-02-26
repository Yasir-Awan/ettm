-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2019 at 11:25 AM
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
-- Table structure for table `omc`
--

CREATE TABLE `omc` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `status` int(1) NOT NULL,
  `date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `omc`
--

INSERT INTO `omc` (`id`, `name`, `status`, `date`) VALUES
(1, 'M/S NLC', 1, '1546325692'),
(2, 'M/s Muhammad Ramzan & Co.', 1, '1546325731'),
(3, 'M/S Three Star Company', 1, '1546325757'),
(4, 'M/S Al-Rehman Enterprises', 1, '1546325796'),
(5, 'M/s Haji Habib ur Rehman & sons', 1, '1546325844'),
(6, 'M/s Afridi Operators', 1, '1546325873'),
(7, 'M/s Sheikh Iqbal Akhtar & co', 1, '1546325924'),
(8, 'M/s Ijaz & Co', 1, '1546325977'),
(9, 'M/s Tram', 1, '1546325994'),
(10, 'M/s Rano Khan Jiskani', 1, '1546326018'),
(11, 'M/s Bara Brothers', 1, '1546326035'),
(12, 'M/s Abdul Karim Builder', 1, '1546326127'),
(13, 'M/s Sherzaman Operators', 1, '1546326157'),
(14, 'M/s Muhammad Ashraf Bhatti', 1, '1546326181'),
(15, 'M/s Sarfraz Associates', 1, '1546326243'),
(16, 'M/s Waleed Associates', 1, '1546326264'),
(17, 'm/s Abdul Ghaffar Bhatti', 1, '1546326375'),
(18, 'M/s Rana Associates', 1, '1548313576'),
(19, 'NHA', 1, '1549015130'),
(20, 'M/S Faizan Communication', 1, '1558944452');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `omc`
--
ALTER TABLE `omc`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `omc`
--
ALTER TABLE `omc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
