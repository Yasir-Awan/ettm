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
-- Table structure for table `tsp`
--

CREATE TABLE `tsp` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `contract_name` text NOT NULL,
  `contract_commence_date` text NOT NULL,
  `contract_expire_date` text NOT NULL,
  `person_name` text NOT NULL,
  `person_designation` text NOT NULL,
  `person_contact` text NOT NULL,
  `address` text NOT NULL,
  `asset_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tsp`
--

INSERT INTO `tsp` (`id`, `name`, `contract_name`, `contract_commence_date`, `contract_expire_date`, `person_name`, `person_designation`, `person_contact`, `address`, `asset_name`) VALUES
(1, 'National Engineers', '1 Year Revenue Collection', '2018-08-16', '2019-12-31', 'M. Sultan', 'Project Manager', '03334567890', 'Lahore', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tsp`
--
ALTER TABLE `tsp`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tsp`
--
ALTER TABLE `tsp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
