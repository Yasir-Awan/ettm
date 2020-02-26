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
-- Table structure for table `faulty_equip`
--

CREATE TABLE `faulty_equip` (
  `id` int(11) NOT NULL,
  `tollplaza` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `contents` text NOT NULL,
  `omc` int(11) NOT NULL,
  `date` text NOT NULL,
  `file` varchar(200) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faulty_equip`
--

INSERT INTO `faulty_equip` (`id`, `tollplaza`, `user`, `contents`, `omc`, `date`, `file`, `status`) VALUES
(2, 11, 2, '[{\"location\":\"2\",\"equip_name\":\"testing equipment\",\"quantity\":\"3873\",\"price\":\"78898\"}]', 0, '1544085039', 'faulty2_11_2.jpg', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `faulty_equip`
--
ALTER TABLE `faulty_equip`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `faulty_equip`
--
ALTER TABLE `faulty_equip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
