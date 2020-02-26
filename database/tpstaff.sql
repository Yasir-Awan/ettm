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
-- Table structure for table `tpstaff`
--

CREATE TABLE `tpstaff` (
  `id` int(11) NOT NULL,
  `tollplaza` int(11) NOT NULL,
  `fname` text NOT NULL,
  `lname` text NOT NULL,
  `designation` text NOT NULL,
  `contact` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tpstaff`
--

INSERT INTO `tpstaff` (`id`, `tollplaza`, `fname`, `lname`, `designation`, `contact`) VALUES
(1, 1, 'Tahir', 'Nadeem', 'JAC', '0344-5108827'),
(2, 1, 'Kashan', 'Mumtaz', 'TSI', '03315009597'),
(3, 1, 'Abid', 'Mehdi', 'QCS', '03218023301'),
(4, 1, 'Yasir', 'Mehmood', 'Technician', '03005809421'),
(5, 1, 'Fayyaz', 'Ali', 'Technician', '03449735835'),
(6, 2, 'Ikramullah', '', 'JAC', '03005938234'),
(7, 2, 'Sajjad', '', 'Technician', '03016921733'),
(8, 2, 'M', 'Riaz', 'Technician', '03028969946'),
(9, 3, 'Khurshid', 'Jaan', 'Office Assistant', '03018578413'),
(10, 3, 'Saad', 'Altaf', 'TSI', '03009865858'),
(11, 3, 'Muddabir', '', 'QCS', '03235155614'),
(12, 3, 'Javed', '', 'Technician', '03139800568'),
(13, 3, 'Arslan', '', 'Technician', '03125901929'),
(14, 3, 'Arshad', 'Mehmood', 'Technician', '03045037480'),
(15, 3, 'Abdussalam', 'Indar', 'Technician', '03005739681'),
(16, 4, 'Martaba', 'Abbasi', 'MIS_Supervisor', '03005083294'),
(17, 4, 'Faqeer', 'Hussain', 'Technician', '03005752255'),
(18, 4, 'Tayyab', '', 'Technician', '03000202203'),
(19, 5, 'Masnadi', 'Gull', 'Office_Assistant', '03350980320'),
(20, 5, 'Raja', 'Shaban', 'Technician', '03335339098'),
(21, 5, 'Badi-uz-Zaman', '', 'Technician', '03120159459'),
(22, 5, 'Shakir', '', 'Technician', '03067948721'),
(23, 6, 'Tahir', 'Sabir', 'JAC', '03319506591'),
(24, 6, 'Qazi', 'Khaleeq', 'TSI', '03215427206'),
(25, 6, 'Ibrahim', '', 'Technician', '03317383800'),
(26, 6, 'Bilal', '', 'Technician', '03438586187'),
(27, 6, 'Nauman', 'Ashraf', 'Technician', ''),
(28, 7, 'Amir', 'Javed', 'Technician', '03015522327'),
(29, 7, 'Tauqeer', '', 'Technician', '03235458448'),
(30, 8, 'Abid', 'Javed', 'Office_Assistant', '03224400757'),
(31, 8, 'Munaf', 'Naveed', 'TSI', '03344907268'),
(32, 8, 'Asif', '', 'Technician', '03002790427'),
(33, 8, 'Tasawar', 'Hussain', 'QCS', '03325016810'),
(34, 8, 'Zahid', '', 'Technician', '03339954616'),
(35, 9, 'Zahid', 'Butt', 'JAC', '03328232204'),
(36, 9, 'Shahid', 'Rasool', 'Technician', '03005751933'),
(37, 9, 'Qamar', 'Zaman', 'Technician', '03335872423'),
(38, 10, 'Muhammad', 'Waqas', 'Technician', '03007573621'),
(39, 10, 'Shoaib', '', 'Technician', '03007591530'),
(40, 10, 'Altaf', 'Hussain', 'Technician', '03347671320'),
(41, 10, 'Shakeel', 'Ahmed', 'Technician', '03347784592'),
(42, 11, 'Parvaiz', 'Ali', 'Technician', '03073112251'),
(43, 11, 'Tanveer', '', 'Technician', '03012005960'),
(44, 6, 'Saqib', 'Ullah', 'Technician', '03128373637');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tpstaff`
--
ALTER TABLE `tpstaff`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tpstaff`
--
ALTER TABLE `tpstaff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
