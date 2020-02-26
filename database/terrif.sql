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
-- Table structure for table `terrif`
--

CREATE TABLE `terrif` (
  `id` int(11) NOT NULL,
  `toolplaza` text NOT NULL,
  `class_1_description` text NOT NULL,
  `class_1_value` text NOT NULL,
  `class_2_description` text NOT NULL,
  `class_2_value` text NOT NULL,
  `class_3_description` text NOT NULL,
  `class_3_value` text NOT NULL,
  `class_4_description` text NOT NULL,
  `class_4_value` text NOT NULL,
  `class_5_description` text NOT NULL,
  `class_5_value` text NOT NULL,
  `class_6_description` text NOT NULL,
  `class_6_value` text NOT NULL,
  `class_7_description` text NOT NULL,
  `class_7_value` text NOT NULL,
  `class_8_description` text NOT NULL,
  `class_8_value` text NOT NULL,
  `class_9_description` text NOT NULL,
  `class_9_value` text NOT NULL,
  `class_10_description` text NOT NULL,
  `class_10_value` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `terrif`
--

INSERT INTO `terrif` (`id`, `toolplaza`, `class_1_description`, `class_1_value`, `class_2_description`, `class_2_value`, `class_3_description`, `class_3_value`, `class_4_description`, `class_4_value`, `class_5_description`, `class_5_value`, `class_6_description`, `class_6_value`, `class_7_description`, `class_7_value`, `class_8_description`, `class_8_value`, `class_9_description`, `class_9_value`, `class_10_description`, `class_10_value`, `start_date`, `end_date`, `date`) VALUES
(1, '1,2,3,5,6,7,8,9,10,11', 'Class-1 (Car, Jeep)', '30', 'Class-2 (Wagon, Hiace)', '40', 'Class-3 (Tractor & Trolly)', '110', 'Class-4 (Buses, Coaster)', '90', 'Class-5 (2 Axle Trucks)', '110', 'Class-6 (3 Axle Trucks)', '110', 'Class-7 (3 Axle Articulated)', '220', 'Class-8 (4 Axle Articulated)', '220', 'Class-9 (5 Axle Articulated)', '220', 'Class-10 (6 Axle Articulated)', '220', '2014-07-07', '2018-06-30', '1547239679'),
(2, '4', 'Class-1 (Car, Jeep)', '50', 'Class-2 (Wagon, Hiace)', '70', 'Class-3 (Tractor & Trolly)', '180', 'Class-4 (Buses, Coaster)', '150', 'Class-5 (2 Axle Trucks)', '180', 'Class-6 (3 Axle Trucks)', '180', 'Class-7 (3 Axle Articulated)', '350', 'Class-8 (4 Axle Articulated)', '350', 'Class-9 (5 Axle Articulated)', '350', 'Class-10 (6 Axle Articulated)', '350', '2014-07-07', '2018-06-30', '1547239723'),
(3, '1,2,3,5,6,7,8,9,10,11', 'Class-1 (Car, Jeep)', '30', 'Class-2 (Wagon, Hiace)', '50', 'Class-3 (Tractor & Trolly)', '120', 'Class-4 (Buses, Coaster)', '100', 'Class-5 (2 Axle Trucks)', '120', 'Class-6 (3 Axle Trucks)', '120', 'Class-7 (3 Axle Articulated)', '250', 'Class-8 (4 Axle Articulated)', '250', 'Class-9 (5 Axle Articulated)', '250', 'Class-10 (6 Axle Articulated)', '250', '2018-07-01', '2020-06-30', '1562133246'),
(4, '4', 'Class-1 (Car, Jeep)', '60', 'Class-2 (Wagon, Hiace)', '80', 'Class-3 (Tractor & Trolly)', '200', 'Class-4 (Buses, Coaster)', '170', 'Class-5 (2 Axle Trucks)', '200', 'Class-6 (3 Axle Trucks)', '200', 'Class-7 (3 Axle Articulated)', '400', 'Class-8 (4 Axle Articulated)', '400', 'Class-9 (5 Axle Articulated)', '400', 'Class-10 (6 Axle Articulated)', '400', '2018-07-01', '2020-06-30', '1562133259');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `terrif`
--
ALTER TABLE `terrif`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `terrif`
--
ALTER TABLE `terrif`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
