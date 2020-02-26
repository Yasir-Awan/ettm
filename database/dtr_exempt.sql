-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2019 at 11:24 AM
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
-- Table structure for table `dtr_exempt`
--

CREATE TABLE `dtr_exempt` (
  `id` int(11) NOT NULL,
  `dtr_id` int(11) NOT NULL,
  `description` varchar(100) NOT NULL,
  `notes` varchar(100) NOT NULL,
  `class1` varchar(25) NOT NULL,
  `class2` varchar(25) NOT NULL,
  `class3` varchar(25) NOT NULL,
  `class4` varchar(25) NOT NULL,
  `class5` varchar(25) NOT NULL,
  `class6` varchar(25) NOT NULL,
  `class7` varchar(25) NOT NULL,
  `class8` varchar(25) NOT NULL,
  `class9` varchar(25) NOT NULL,
  `class10` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dtr_exempt`
--
ALTER TABLE `dtr_exempt`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dtr_exempt`
--
ALTER TABLE `dtr_exempt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
