-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2019 at 11:27 AM
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
-- Table structure for table `weighstation_data`
--

CREATE TABLE `weighstation_data` (
  `id` int(11) NOT NULL,
  `weigh_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `ticket_no` varchar(100) NOT NULL,
  `type` varchar(20) NOT NULL,
  `vehicle_code` varchar(50) NOT NULL,
  `vehicle_no` varchar(150) NOT NULL,
  `haulier` varchar(200) NOT NULL,
  `weight` varchar(100) NOT NULL,
  `exces_weight` varchar(100) NOT NULL,
  `percent_overload` varchar(50) NOT NULL,
  `fine` int(50) NOT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `weighstation_data`
--

INSERT INTO `weighstation_data` (`id`, `weigh_id`, `date`, `time`, `ticket_no`, `type`, `vehicle_code`, `vehicle_no`, `haulier`, `weight`, `exces_weight`, `percent_overload`, `fine`, `status`) VALUES
(1, 1, '2019-07-22', '09:31:31', '  170 ', '6', '690', 'TLC138     ', 'QMAR', '62.7', '45.2', '258.29', 0, '2'),
(2, 1, '2019-07-22', '10:37:29', '  171 ', '6', '690', ' TLZ715    ', 'FIZA', '62.37', '44.87', '256.4', 0, '2'),
(17, 1, '2019-07-23', '00:07:25', '  183 ', '2', '200', 'FDS1014    ', 'RAFIQ', '9.1', '0', '0', 0, '1'),
(18, 1, '2019-07-23', '04:37:25', '  184 ', '6', '690', 'TLA987     ', 'AKBAR', '63.33', '4.83', '8.26', 0, '2'),
(19, 1, '2019-07-23', '11:57:21', '  185 ', '2', '200', ' MNS2204   ', 'ARSHED', '11.44', '0', '0', 0, '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `weighstation_data`
--
ALTER TABLE `weighstation_data`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `weighstation_data`
--
ALTER TABLE `weighstation_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
