-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2019 at 11:14 AM
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
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` int(11) NOT NULL,
  `item_type` int(1) NOT NULL COMMENT '1=Electronic Equipment, 2=Heavy Equipment, 3=Lab Equipment, 4=Event & Staging Equipment, 5=Marketing & Promotional Material, 6=IT Assets, 7=Consumables, 8=Tools',
  `name` text NOT NULL,
  `action_status` int(1) NOT NULL COMMENT '1=checkout , 2=checkin , 3 = install , 4=start_repair , 5=end_repair ,6=retire, 7=Extend_return, 8=reserve, 9=Re Installed',
  `product_model_no` text NOT NULL,
  `identification_no` varchar(100) NOT NULL,
  `cost_price` double NOT NULL,
  `supplier` text NOT NULL,
  `manufacturer` int(11) NOT NULL,
  `site` text NOT NULL,
  `purchased_on` text NOT NULL,
  `warranty_type` int(1) NOT NULL COMMENT '0=No warranty, 1=Replacement, 2=Repairing',
  `warranty_duration` text NOT NULL,
  `checkout_user_type` int(11) NOT NULL COMMENT '1=admin , 2=member , 3=supervisor ',
  `checkout_to` text NOT NULL,
  `user_type` int(11) NOT NULL COMMENT '1= admin, 2=supervisor, 3=member',
  `checkin_by` int(11) NOT NULL,
  `add_date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`id`, `item_type`, `name`, `action_status`, `product_model_no`, `identification_no`, `cost_price`, `supplier`, `manufacturer`, `site`, `purchased_on`, `warranty_type`, `warranty_duration`, `checkout_user_type`, `checkout_to`, `user_type`, `checkin_by`, `add_date`) VALUES
(1, 1, '12', 0, '33', 'OIPRG1', 3500, '2', 2, '12', '2019-06-01', 2, '1 Year', 0, '', 1, 1, '1563727935'),
(2, 1, '12', 0, '33', 'W8K3G9', 3500, '2', 2, '12', '2019-06-01', 2, '1 Year', 0, '', 1, 1, '1563727935'),
(3, 1, '9', 1, '44', 'T0TLS6', 1500, '1', 1, '10', '2019-06-01', 2, '1 Year', 3, '9', 2, 9, '1563728146'),
(4, 1, '9', 0, '44', 'T0TLS7', 1500, '1', 1, '10', '2019-06-01', 2, '1 Year', 0, '', 2, 9, '1563728146'),
(5, 1, '9', 0, '22', 'N7RFAH', 2500, '2', 2, '12', '2019-06-01', 2, '1 Year', 0, '', 2, 11, '1564054126'),
(6, 1, '9', 0, '22', 'N7RFAI', 2500, '2', 2, '12', '2019-06-01', 2, '1 Year', 0, '', 2, 11, '1564054127');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `identification_no` (`identification_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
