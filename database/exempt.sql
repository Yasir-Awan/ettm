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
-- Table structure for table `exempt`
--

CREATE TABLE `exempt` (
  `id` int(11) NOT NULL,
  `mtr_id` int(11) NOT NULL,
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
-- Dumping data for table `exempt`
--

INSERT INTO `exempt` (`id`, `mtr_id`, `description`, `notes`, `class1`, `class2`, `class3`, `class4`, `class5`, `class6`, `class7`, `class8`, `class9`, `class10`) VALUES
(1, 174, 'Exempt', 'No of Passages', '23874', '2958', '24', '135', '620', '4', '3', '5', '223', '62'),
(2, 1, 'Exempt', 'No of Passages', '25989', '3011', '44', '132', '704', '11', '1', '18', '116', '15'),
(3, 2, 'Exempt', 'No of Passages', '19921', '2535', '16', '89', '706', '18', '0', '10', '93', '13'),
(4, 3, 'Exempt', 'No of Passages', '15980', '2430', '18', '68', '720', '23', '4', '9', '30', '8'),
(5, 4, 'Exempt', 'No of Passages', '13961', '2101', '10', '78', '806', '28', '7', '35', '25', '26'),
(6, 5, 'Exempt', 'No of Passages', '10841', '1847', '9', '41', '526', '16', '1', '17', '32', '15'),
(7, 6, 'Exempt', 'No of Passages', '15009', '1865', '20', '108', '595', '21', '4', '8', '62', '9'),
(8, 13, 'Exempt', 'No of Passages', '22196', '2622', '12', '41', '415', '5', '1', '4', '30', '0'),
(9, 14, 'Exempt', 'No of Passages', '18079', '2981', '10', '79', '880', '17', '4', '3', '81', '5'),
(10, 15, 'Exempt', 'No of Passages', '19082', '3100', '31', '93', '893', '39', '0', '5', '98', '6'),
(11, 18, 'Exempt', 'No of Passages', '19825', '3030', '15', '95', '677', '121', '0', '7', '38', '13'),
(12, 21, 'Exempt', 'No of Passages', '15465', '2350', '10', '63', '562', '88', '0', '12', '60', '3'),
(13, 23, 'Exempt', 'No of Passages', '16488', '2663', '7', '95', '528', '27', '2', '10', '42', '5'),
(14, 248, 'Exempt', 'No of Passages', '21081', '2544', '70', '89', '697', '20', '1', '25', '108', '41'),
(15, 279, 'Exempt', 'No of Passages', '22', '0', '0', '2', '3', '0', '4', '0', '1', '0'),
(16, 280, 'Exempt', 'No of Passages', '0', '0', '0', '1', '0', '0', '0', '0', '0', '0'),
(17, 290, 'Exempt', 'No of Passages', '16818', '2351', '112', '125', '727', '24', '4', '23', '114', '28'),
(18, 55, 'Exempt', 'No of Passages', '59000', '11149', '26', '280', '963', '17', '6', '4', '7', '9'),
(19, 297, 'Exempt', 'No of Passages', '1', '3', '0', '0', '0', '0', '1', '1', '2', '0'),
(20, 298, 'Exempt', 'No of Passages', '0', '0', '1', '0', '1', '0', '0', '0', '1', '0'),
(21, 299, 'Exempt', 'No of Passages', '0', '1', '1', '0', '1', '0', '0', '0', '23', '0'),
(22, 300, 'Exempt', 'No of Passages', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0'),
(23, 301, 'Exempt', 'No of Passages', '6', '0', '0', '0', '1', '0', '0', '1', '4', '0'),
(24, 319, 'Exempt', 'No of Passages', '6', '3', '5', '0', '0', '0', '0', '0', '11', '5'),
(25, 324, 'Exempt', 'No of Passages', '13825', '2330', '92', '121', '496', '29', '4', '34', '83', '14'),
(26, 330, 'Exempt', 'No of Passages', '8717', '1706', '36', '47', '418', '16', '2', '27', '43', '5'),
(27, 331, 'Exempt', 'No of Passages', '9849', '1955', '36', '55', '458', '28', '3', '28', '50', '5'),
(28, 334, 'Exempt', 'No of Passages', '0', '4', '2', '3', '12', '0', '1', '2', '0', '0'),
(29, 345, 'Exempt', 'No of Passages', '6875', '1785', '27', '45', '277', '83', '0', '10', '34', '12'),
(30, 346, 'Exempt', 'No of Passages', '0', '3', '0', '2', '5', '0', '0', '0', '2', '1'),
(31, 348, 'Exempt', 'No of Passages', '0', '1', '0', '0', '3', '0', '0', '0', '0', '0'),
(32, 356, 'Exempt', 'No of Passages', '186', '9', '0', '1', '10', '10', '0', '2', '0', '3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `exempt`
--
ALTER TABLE `exempt`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `exempt`
--
ALTER TABLE `exempt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
