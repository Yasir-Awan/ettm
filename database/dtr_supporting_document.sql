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
-- Table structure for table `dtr_supporting_document`
--

CREATE TABLE `dtr_supporting_document` (
  `id` int(11) NOT NULL,
  `dtr_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dtr_supporting_document`
--

INSERT INTO `dtr_supporting_document` (`id`, `dtr_id`, `name`, `path`) VALUES
(1, 7, 'Comprehensive', 'dtr_supporting_document7_1.pdf'),
(2, 8, 'Comprehensive', 'dtr_supporting_document8_2.pdf'),
(3, 9, 'Comp', 'dtr_supporting_document9_3.pdf'),
(4, 11, 'Comprehensive', 'dtr_supporting_document11_4.pdf'),
(5, 12, 'Comprehensive', 'dtr_supporting_document12_5.pdf'),
(6, 13, 'Comprehensive', 'dtr_supporting_document13_6.pdf'),
(7, 14, 'Comprehensive', 'dtr_supporting_document14_7.pdf'),
(8, 15, 'DTR', 'dtr_supporting_document15_8.pdf'),
(9, 18, 'DTR', 'dtr_supporting_document18_9.pdf'),
(10, 19, 'DTR', 'dtr_supporting_document19_10.pdf'),
(11, 20, 'DTR', 'dtr_supporting_document20_11.pdf'),
(12, 22, 'DTR', 'dtr_supporting_document22_12.pdf'),
(13, 24, 'DTR', 'dtr_supporting_document24_13.pdf'),
(14, 26, 'DTR', 'dtr_supporting_document26_14.pdf'),
(15, 28, 'DTR', 'dtr_supporting_document28_15.pdf'),
(16, 30, 'DTR', 'dtr_supporting_document30_16.pdf'),
(17, 31, 'DTR', 'dtr_supporting_document31_17.pdf'),
(18, 32, 'DTR', 'dtr_supporting_document32_18.pdf'),
(19, 34, 'DTR', 'dtr_supporting_document34_19.pdf'),
(20, 35, 'DTR', 'dtr_supporting_document35_20.pdf'),
(21, 36, 'DTR', 'dtr_supporting_document36_21.pdf'),
(22, 37, 'DTR', 'dtr_supporting_document37_22.pdf'),
(24, 50, 'Comprehensive', 'dtr_supporting_document50_24.pdf'),
(25, 51, 'Comprehensive', 'dtr_supporting_document51_25.pdf'),
(26, 52, 'Comprehensive', 'dtr_supporting_document52_26.pdf'),
(27, 53, 'Comprehensive', 'dtr_supporting_document53_27.pdf'),
(28, 54, 'Comprehensive', 'dtr_supporting_document54_28.pdf'),
(29, 55, 'Comprehensive', 'dtr_supporting_document55_29.pdf'),
(30, 56, 'Comprehensive', 'dtr_supporting_document56_30.pdf'),
(31, 57, 'Comprehensive', 'dtr_supporting_document57_31.pdf'),
(32, 58, 'Comprehensive', 'dtr_supporting_document58_32.pdf'),
(33, 59, 'Comprehensive', 'dtr_supporting_document59_33.pdf'),
(34, 60, 'Comprehensive', 'dtr_supporting_document60_34.pdf'),
(35, 61, 'Comprehensive', 'dtr_supporting_document61_35.pdf'),
(36, 62, 'comprehensive', 'dtr_supporting_document62_36.pdf'),
(37, 63, 'comprehensive', 'dtr_supporting_document63_37.pdf'),
(38, 64, 'comprehensive', 'dtr_supporting_document64_38.pdf'),
(39, 66, 'Comprehensive', 'dtr_supporting_document66_39.pdf'),
(40, 67, 'DTR', 'dtr_supporting_document67_40.pdf'),
(46, 73, 'DTR', 'dtr_supporting_document73_46.pdf'),
(47, 74, 'DTR', 'dtr_supporting_document74_47.pdf'),
(49, 76, 'Comprehensive', 'dtr_supporting_document76_49.pdf'),
(50, 79, 'DTR', 'dtr_supporting_document79_50.pdf'),
(51, 80, 'DTR', 'dtr_supporting_document80_51.pdf'),
(52, 81, 'DTR', 'dtr_supporting_document81_52.pdf'),
(53, 82, 'DTR', 'dtr_supporting_document82_53.pdf'),
(54, 83, 'DTR', 'dtr_supporting_document83_54.pdf'),
(55, 84, 'DTR', 'dtr_supporting_document84_55.pdf'),
(56, 85, 'Comprehensive', 'dtr_supporting_document85_56.pdf'),
(57, 86, 'DTR', 'dtr_supporting_document86_57.pdf'),
(58, 87, 'Comprehensive', 'dtr_supporting_document87_58.pdf');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dtr_supporting_document`
--
ALTER TABLE `dtr_supporting_document`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dtr_supporting_document`
--
ALTER TABLE `dtr_supporting_document`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
