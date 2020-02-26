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
-- Table structure for table `tpsupervisor`
--

CREATE TABLE `tpsupervisor` (
  `id` int(11) NOT NULL,
  `tollplaza` int(11) NOT NULL,
  `site` int(11) NOT NULL,
  `tsp` int(11) NOT NULL,
  `fname` text NOT NULL,
  `lname` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `contact` text NOT NULL,
  `role` int(11) NOT NULL,
  `adddate` text NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tpsupervisor`
--

INSERT INTO `tpsupervisor` (`id`, `tollplaza`, `site`, `tsp`, `fname`, `lname`, `username`, `password`, `contact`, `role`, `adddate`, `status`) VALUES
(1, 1, 1, 1, 'Abid', 'Mehdi', 'abid@iqbalshaheed', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '03218023301', 0, '1546506881', 1),
(2, 3, 3, 1, 'Mudabbir', 'Ehsan', 'mudabbir@sangjani', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '03235155614', 0, '1546507124', 1),
(3, 4, 4, 1, 'Martaba', 'Abbasi', 'martaba@imdcw', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '03005083294', 0, '1546507178', 1),
(4, 5, 5, 1, 'Shaban', 'Akhtar', 'shaban@qutbal', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '03335339098', 0, '1546507724', 1),
(5, 6, 6, 1, 'Khaliq', 'Ahmed', 'khaliq@mandra', '8cb2237d0679ca88db6464eac60da96345513964', '03215427206', 0, '1546507798', 1),
(6, 7, 7, 1, 'Khaliq', 'Ahmed', 'khaliq@tarakki', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '03215427206', 0, '1546507875', 1),
(7, 8, 8, 1, 'Tassawar', 'Husaain', 'tassawar@jhelum', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '03005016810', 0, '1563775271', 1),
(8, 9, 9, 1, 'Munaf', 'Naveed', 'munaf@chenab', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '03344907268', 0, '1546508022', 1),
(9, 10, 10, 1, 'Shoaib', 'Majid', 'shoaib@harappa', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '03007591530', 0, '1546508081', 1),
(10, 11, 11, 1, 'Yasin', 'yasin', 'yasin@khanbela', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '03477372984', 0, '1546508242', 1),
(11, 11, 11, 1, 'Wajih', 'Khan', 'wajih@kb', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '03445460030', 4, '1549443775', 1),
(12, 1, 1, 1, 'Kashan', 'Mumtaz', 'kashaan@mmr', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '03315009597', 2, '1557303283', 1),
(13, 2, 2, 1, 'Kashan', 'Mumtaz', 'kashaan@harro', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '03315009597', 2, '1557303361', 1),
(14, 3, 3, 1, 'Saad', 'Altaf', 'saad@sangjani', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '03009865858', 1, '1557303659', 1),
(15, 5, 5, 1, 'Kashaan', 'Mumtaz', 'kashaan@qutbal', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '03315009597', 2, '1557303784', 1),
(16, 6, 6, 1, 'Qazi', 'Khaleeq', 'qazi@mandra', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '03215427206', 1, '1557303876', 1),
(17, 7, 7, 1, 'Qazi', 'Khaleeq', 'qazi@tarakki', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '03215427206', 1, '1557304110', 1),
(18, 8, 8, 1, 'Munaf', 'Naveed', 'munaaf@jehlum', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '03344907268', 1, '1557304382', 1),
(19, 10, 10, 1, 'Saad', 'Altaf', 'saad@harrapa', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '03009865858', 1, '1557305075', 1),
(20, 11, 11, 1, 'Tanveer', '', 'tanveer@khanbela', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '03012005960', -1, '1557305261', 1),
(22, 4, 4, 1, 'Saad', 'Altaf', 'saad@imdcw', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '03009865858', 1, '1557312570', 1),
(23, 9, 9, 1, 'Munaf', 'Naveed', 'munaaf@chenab', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '03344907268', 1, '1558518107', 1),
(24, 9, 9, 1, 'Qamar', 'Zaman', 'qamar@chenab', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '03335872423', -1, '1563176314', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tpsupervisor`
--
ALTER TABLE `tpsupervisor`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tpsupervisor`
--
ALTER TABLE `tpsupervisor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
