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
-- Table structure for table `updated_mtrs`
--

CREATE TABLE `updated_mtrs` (
  `id` int(11) NOT NULL,
  `mtr_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mtr_month` text NOT NULL,
  `mtr_type` int(11) NOT NULL COMMENT '1=standard,2=custom',
  `update_date` text NOT NULL,
  `tollplaza` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `updated_mtrs`
--

INSERT INTO `updated_mtrs` (`id`, `mtr_id`, `user_id`, `mtr_month`, `mtr_type`, `update_date`, `tollplaza`) VALUES
(15, 55, 6, '2018-04-01', 1, '1554274415', 7),
(22, 51, 6, '2018-01-01', 1, '1554274978', 7),
(25, 55, 6, '2018-04-01', 1, '1554275129', 7),
(27, 57, 6, '2018-06-01', 1, '1554275325', 7),
(34, 51, 6, '2018-01-01', 1, '1554277394', 7),
(36, 55, 6, '2018-04-01', 1, '1554277521', 7),
(40, 236, 8, '2018-01-01', 1, '1554291454', 9),
(45, 277, 1, '2018-12-01', 1, '1554978428', 1),
(46, 277, 1, '2018-12-01', 1, '1554978510', 1),
(47, 277, 1, '2018-12-01', 1, '1554980804', 1),
(48, 275, 1, '2018-10-01', 1, '1555054789', 1),
(53, 320, 5, '2018-08-01', 1, '1556614223', 6),
(59, 265, 1, '2018-01-01', 1, '1557125771', 1),
(60, 266, 1, '2018-02-01', 1, '1557125883', 1),
(61, 267, 1, '2018-03-01', 1, '1557125941', 1),
(62, 268, 1, '2018-04-01', 1, '1557125990', 1),
(63, 269, 1, '2018-05-01', 1, '1557126041', 1),
(67, 256, 1, '2017-05-01', 1, '1557126466', 1),
(70, 259, 1, '2017-08-01', 1, '1557126746', 1),
(72, 261, 1, '2017-10-01', 1, '1557126945', 1),
(73, 263, 1, '2017-11-01', 2, '1557128105', 1),
(75, 326, 1, '2019-04-01', 1, '1557224274', 1),
(76, 320, 5, '2018-08-01', 1, '1557389666', 6),
(77, 320, 5, '2018-08-01', 1, '1557389767', 6),
(78, 320, 5, '2018-08-01', 1, '1557389854', 6),
(79, 320, 5, '2018-08-01', 1, '1557389940', 6),
(80, 320, 5, '2018-08-01', 1, '1557390015', 6),
(81, 320, 5, '2018-08-01', 1, '1557390076', 6),
(82, 320, 5, '2018-08-01', 1, '1557390159', 6),
(114, 229, 7, '2017-11-01', 2, '1557435652', 8),
(115, 143, 3, '2016-09-01', 1, '1558508915', 4),
(122, 131, 3, '2017-05-01', 1, '1558509616', 4),
(123, 330, 9, '2019-05-01', 2, '1559021504', 10),
(124, 330, 9, '2019-05-01', 2, '1559021775', 10),
(125, 330, 9, '2019-05-01', 2, '1559031919', 10),
(126, 341, 3, '2019-05-01', 1, '1561960068', 4),
(127, 342, 3, '2019-06-01', 1, '1561960101', 4),
(128, 130, 3, '2017-04-01', 1, '1561960191', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `updated_mtrs`
--
ALTER TABLE `updated_mtrs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `updated_mtrs`
--
ALTER TABLE `updated_mtrs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
