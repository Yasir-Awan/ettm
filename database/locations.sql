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
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `site` int(11) NOT NULL,
  `location` varchar(100) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `site`, `location`, `description`) VALUES
(1, 1, 'N1', ''),
(2, 1, 'N2', ''),
(3, 1, 'N3', ''),
(4, 1, 'N4', ''),
(5, 1, 'S1', ''),
(6, 1, 'S2', ''),
(7, 1, 'S3', ''),
(8, 1, 'S4', ''),
(9, 1, 'Control Room', ''),
(10, 1, 'Server Room', ''),
(11, 1, 'N1 inside Booth', ''),
(12, 1, 'N2 inside Booth', ''),
(13, 1, 'N3 inside Booth', ''),
(14, 1, 'N4 inside Booth', ''),
(15, 1, 'S1 inside Booth', ''),
(16, 1, 'S2 inside Booth', ''),
(17, 1, 'S3 inside Booth', ''),
(18, 1, 'S4 inside Booth', ''),
(19, 2, 'N1', ''),
(20, 2, 'N2', ''),
(21, 2, 'N3', ''),
(22, 2, 'N4', ''),
(23, 2, 'S1', ''),
(24, 2, 'S2', ''),
(25, 2, 'S3', ''),
(26, 2, 'S4', ''),
(27, 2, 'N1 inside Booth', ''),
(28, 2, 'N2 inside Booth', ''),
(29, 2, 'N3 inside Booth', ''),
(30, 2, 'N4 inside Booth', ''),
(31, 2, 'S1 inside Booth', ''),
(32, 2, 'S2 inside Booth', ''),
(33, 2, 'S3 inside Booth', ''),
(34, 2, 'S4 inside Booth', ''),
(35, 2, 'Control Room', ''),
(36, 2, 'Server Room', ''),
(37, 3, 'N1', ''),
(38, 3, 'N2', ''),
(39, 3, 'N3', ''),
(40, 3, 'N4', ''),
(41, 3, 'N5', ''),
(42, 3, 'N6', ''),
(43, 3, 'S1', ''),
(44, 3, 'S2', ''),
(45, 3, 'S3', ''),
(46, 3, 'S4', ''),
(47, 3, 'S5', ''),
(48, 3, 'S6', ''),
(49, 3, 'N1 inside Booth', ''),
(50, 3, 'N2 inside Booth', ''),
(51, 3, 'N3 inside Booth', ''),
(52, 3, 'N4 inside Booth', ''),
(53, 3, 'N5 inside Booth', ''),
(54, 3, 'N6 inside Booth', ''),
(55, 3, 'S1 inside Booth', ''),
(56, 3, 'S2 inside Booth', ''),
(57, 3, 'S3 inside Booth', ''),
(58, 3, 'S4 inside Booth', ''),
(59, 3, 'S5 inside Booth', ''),
(60, 3, 'S6 inside Booth', ''),
(61, 3, 'Server Room ', ''),
(62, 3, 'Control Room', ''),
(63, 4, 'N1', ''),
(64, 4, 'N2', ''),
(65, 4, 'N3', ''),
(66, 4, 'N4', ''),
(67, 4, 'S1', ''),
(68, 4, 'S2', ''),
(69, 4, 'S3', ''),
(70, 4, 'S4', ''),
(71, 4, 'N1 inside Booth', ''),
(72, 4, 'N2 inside Booth', ''),
(73, 4, 'N3 inside Booth', ''),
(74, 4, 'N4 inside Booth', ''),
(75, 4, 'S1 inside Booth', ''),
(76, 4, 'S2 inside Booth', ''),
(77, 4, 'S3 inside Booth', ''),
(78, 4, 'S4 inside Booth', ''),
(79, 4, 'Server Room', ''),
(80, 4, 'Control Room', ''),
(81, 5, 'N1', ''),
(82, 5, 'N2', ''),
(83, 5, 'N3', ''),
(84, 5, 'S1', ''),
(85, 5, 'S2', ''),
(86, 5, 'S3', ''),
(87, 5, 'Control Room', ''),
(88, 5, 'Server Room', ''),
(89, 6, 'N1', ''),
(90, 6, 'N2', ''),
(91, 6, 'N3', ''),
(92, 6, 'N4', ''),
(93, 6, 'S1', ''),
(94, 6, 'S2', ''),
(95, 6, 'S3', ''),
(96, 6, 'S4', ''),
(97, 6, 'N1 inside Booth', ''),
(98, 6, 'N2 inside Booth', ''),
(99, 6, 'N3 inside Booth', ''),
(100, 6, 'N4 inside Booth', ''),
(101, 6, 'S1 inside Booth', ''),
(102, 6, 'S2 inside Booth', ''),
(103, 6, 'S3 inside Booth', ''),
(104, 6, 'S4 inside Booth', ''),
(105, 6, 'Server Room', ''),
(106, 6, 'Control Room', ''),
(107, 7, 'N1', ''),
(108, 7, 'N2', ''),
(109, 7, 'N3', ''),
(110, 7, 'N4', ''),
(111, 7, 'S1', ''),
(112, 7, 'S2', ''),
(113, 7, 'S3', ''),
(114, 7, 'S4', ''),
(115, 7, 'N1 inside Booth', ''),
(116, 7, 'N2 inside Booth', ''),
(117, 7, 'N3 inside Booth', ''),
(118, 7, 'N4 inside Booth', ''),
(119, 7, 'S1 inside Booth', ''),
(120, 7, 'S2 inside Booth', ''),
(121, 7, 'S3 inside Booth', ''),
(122, 7, 'S4 inside Booth', ''),
(123, 7, 'Control Room', ''),
(124, 7, 'Server Room', ''),
(125, 8, 'N1', ''),
(126, 8, 'N2', ''),
(127, 8, 'N3', ''),
(128, 8, 'N4', ''),
(129, 8, 'S1', ''),
(130, 8, 'S2', ''),
(131, 8, 'S3', ''),
(132, 8, 'S4', ''),
(133, 8, 'N1 inside Booth', ''),
(134, 8, 'N2 inside Booth', ''),
(135, 8, 'N3 inside Booth', ''),
(136, 8, 'N4 inside Booth', ''),
(137, 8, 'S1 inside Booth', ''),
(138, 8, 'S2 inside Booth', ''),
(139, 8, 'S3 inside Booth', ''),
(140, 8, 'S4 inside Booth', ''),
(141, 8, 'Control Room', ''),
(142, 8, 'Server Room', ''),
(143, 9, 'N1', ''),
(144, 9, 'N2', ''),
(145, 9, 'N3', ''),
(146, 9, 'N4', ''),
(147, 9, 'S1', ''),
(148, 9, 'S2', ''),
(149, 9, 'S3', ''),
(150, 9, 'S4', ''),
(151, 9, 'N1 inside Booth', ''),
(152, 9, 'N2 inside Booth', ''),
(153, 9, 'N3 inside Booth', ''),
(154, 9, 'N4 inside Booth', ''),
(155, 9, 'S1 inside Booth', ''),
(156, 9, 'S2 inside Booth', ''),
(157, 9, 'S3 inside Booth', ''),
(158, 9, 'S4 inside Booth', ''),
(159, 9, 'Server Room', ''),
(160, 9, 'Control Room', ''),
(161, 10, 'N1', ''),
(162, 10, 'N2', ''),
(163, 10, 'N3', ''),
(164, 10, 'N4', ''),
(165, 10, 'S1', ''),
(166, 10, 'S2', ''),
(167, 10, 'S3', ''),
(168, 10, 'S4', ''),
(169, 10, 'N1 inside Booth', ''),
(170, 10, 'N2 inside Booth', ''),
(171, 10, 'N3 inside Booth', ''),
(172, 10, 'N4 inside Booth', ''),
(173, 10, 'S1 inside Booth', ''),
(174, 10, 'S2 inside Booth', ''),
(175, 10, 'S3 inside Booth', ''),
(176, 10, 'S4 inside Booth', ''),
(177, 10, 'Server Room', ''),
(178, 10, 'Control Room', ''),
(179, 11, 'N1', ''),
(180, 11, 'N2', ''),
(181, 11, 'N3', ''),
(182, 11, 'N4', ''),
(183, 11, 'S1', ''),
(184, 11, 'S2', ''),
(185, 11, 'S3', ''),
(186, 11, 'S4', ''),
(187, 11, 'N1 inside Booth', ''),
(188, 11, 'N2 inside Booth', ''),
(189, 11, 'N3 inside Booth', ''),
(190, 11, 'N4 inside Booth', ''),
(191, 11, 'S1 inside Booth', ''),
(192, 11, 'S2 inside Booth', ''),
(193, 11, 'S3 inside Booth', ''),
(194, 11, 'S4 inside Booth', ''),
(195, 11, 'Server Room', ''),
(196, 11, 'Control Room', ''),
(197, 12, 'Computer Bureau', ''),
(198, 12, 'OPS -1', ''),
(199, 12, 'OPS-2', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
