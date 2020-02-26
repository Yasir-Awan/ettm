-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2019 at 11:13 AM
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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `site` int(11) NOT NULL,
  `tsp` int(11) NOT NULL,
  `fname` text NOT NULL,
  `lname` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `contact` text NOT NULL,
  `adddate` text NOT NULL,
  `status` int(1) NOT NULL,
  `role` int(1) NOT NULL COMMENT '1=super admin,2=sub admin'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `site`, `tsp`, `fname`, `lname`, `username`, `password`, `contact`, `adddate`, `status`, `role`) VALUES
(1, 12, 0, 'NHA', 'Admin', 'admin@gmail.com', 'f865b53623b121fd34ee5426c792e5c33af8c227', '57757', '1553063821', 1, 1),
(8, 0, 0, 'Chairman', 'NHA', 'Chairman', 'a26ddc5afeca8860fa736cd073b6986bbdc6a602', 'N/A', '1553087195', 1, 2),
(9, 0, 0, 'DEPUTY DIRECTOR', 'MIS', 'DD MIS', 'e320ea7bcb9fb3ad90e4bbbe8bd0f1950151ac14', 'N/A', '1553087540', 1, 2),
(10, 0, 0, 'DIRECTOR', 'RevOps', 'director revops', 'e320ea7bcb9fb3ad90e4bbbe8bd0f1950151ac14', 'N/A', '1553087705', 1, 2),
(11, 0, 0, 'DIRECTOR', 'RevCont', 'dir revcont', 'e320ea7bcb9fb3ad90e4bbbe8bd0f1950151ac14', 'N/A', '1553087804', 1, 2),
(12, 0, 0, 'MEMBER', 'FINANCE', 'member finance', 'e320ea7bcb9fb3ad90e4bbbe8bd0f1950151ac14', 'N/A', '1553087931', 1, 2),
(13, 0, 0, 'Member', 'Planning', 'member planning', 'e320ea7bcb9fb3ad90e4bbbe8bd0f1950151ac14', 'N/A', '1553869996', 1, 2),
(14, 12, 1, 'watani', 'watani', 'watani', '6464515fcc0324cb201472415f6310b483f453f7', '', '1562307389', 1, 2),
(15, 12, 1, 'Abdus Samad', 'Sarfraz', 'samad_sarfraz', 'a678ede5a7b88ebbb42f064659046d97a5f5e83a', '', '1562847386', 1, 1),
(16, 12, 1, 'Rizwan', 'Khan', 'rizwan', '3c965db5365851fcdc5403988b10ca65150029b3', '', '1562914733', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
