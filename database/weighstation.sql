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
-- Table structure for table `weighstation`
--

CREATE TABLE `weighstation` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `type` int(1) NOT NULL COMMENT '1=local, 2=ftp',
  `address` varchar(100) NOT NULL,
  `adddate` date NOT NULL,
  `status` int(1) NOT NULL COMMENT '1=active,2=inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `weighstation`
--

INSERT INTO `weighstation` (`id`, `name`, `type`, `address`, `adddate`, `status`) VALUES
(1, 'Gojra Weighstation', 2, '111.119.179.22', '2019-07-22', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `weighstation`
--
ALTER TABLE `weighstation`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `weighstation`
--
ALTER TABLE `weighstation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
