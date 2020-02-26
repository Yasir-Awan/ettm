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
-- Table structure for table `google_locations`
--

CREATE TABLE `google_locations` (
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1=tollplaza, 2=weighstation, 3= cameras,4=weather information system,5= variable message sign,6=Motorway advisory radio,7=Emergency road side telephone,8=microwave vehicle detector,9=speed enforcement system,10 efine,11 fiber optic cable',
  `location_id` int(11) NOT NULL,
  `road_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `address` text NOT NULL,
  `state` varchar(50) NOT NULL,
  `lat` varchar(50) NOT NULL,
  `lang` varchar(50) NOT NULL,
  `chainage` varchar(50) NOT NULL,
  `status` int(1) NOT NULL COMMENT '0=inactive, 1=active'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `google_locations`
--

INSERT INTO `google_locations` (`id`, `type`, `location_id`, `road_id`, `name`, `address`, `state`, `lat`, `lang`, `chainage`, `status`) VALUES
(1, 1, 3, 1, 'Chakri Interchange', 'Chakri Rd, Rawalpindi, Punjab, Pakistan', 'Punjab', '33.30866248811738', '72.77926940490715', '50', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `google_locations`
--
ALTER TABLE `google_locations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `google_locations`
--
ALTER TABLE `google_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
