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
-- Table structure for table `asset_transaction`
--

CREATE TABLE `asset_transaction` (
  `id` int(11) NOT NULL,
  `asset_id` int(11) NOT NULL,
  `transaction_type` int(1) NOT NULL COMMENT '1=checkout , 2=checkin , 3 = install , 4=Start_repair , 5=End_repair , 6=Retire ,7=Extend_return , 8=reserve, 9=Re Installed',
  `site` int(11) NOT NULL,
  `location` int(11) NOT NULL,
  `action_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `organisation_type` int(11) NOT NULL COMMENT '1=tsp, 2=outsider',
  `organisation` text NOT NULL,
  `organisation_address` text NOT NULL,
  `repairing_person_type` int(1) NOT NULL COMMENT '1=admin , 2=member , 3=supervisor',
  `person` text NOT NULL,
  `person_contact` text NOT NULL,
  `action_comments` text NOT NULL,
  `issuance_type` int(1) NOT NULL COMMENT '1=permanent , 2=temporary',
  `return_date` text,
  `extend_date` text NOT NULL,
  `retire_type` int(1) NOT NULL COMMENT '1=Damaged, 2=Lost, 3=Gifted, 4=Expired, 5=Consumed',
  `retire_date` text NOT NULL,
  `repair_type` int(1) NOT NULL COMMENT '1=standard, 2=warranty, 3=others',
  `available` int(1) NOT NULL COMMENT '1=yes, 0=no',
  `repair_quantity` bigint(20) NOT NULL,
  `total_repairing_cost` bigint(20) NOT NULL,
  `unit_repairing_cost` bigint(20) NOT NULL,
  `checkout_user_role` int(1) NOT NULL COMMENT '1=admin , 2=member , 3=supervisor',
  `checkout_from_site` int(11) NOT NULL,
  `user_type` int(11) NOT NULL COMMENT '1=admin 2=supervisor 3=member',
  `added_by` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `asset_transaction`
--

INSERT INTO `asset_transaction` (`id`, `asset_id`, `transaction_type`, `site`, `location`, `action_date`, `organisation_type`, `organisation`, `organisation_address`, `repairing_person_type`, `person`, `person_contact`, `action_comments`, `issuance_type`, `return_date`, `extend_date`, `retire_type`, `retire_date`, `repair_type`, `available`, `repair_quantity`, `total_repairing_cost`, `unit_repairing_cost`, `checkout_user_role`, `checkout_from_site`, `user_type`, `added_by`) VALUES
(1, 3, 1, 10, 0, '2019-07-22 09:58:30', 0, '', '', 0, '9', '03467553057', 'fasfasdfasf', 1, '', '', 0, '', 0, 0, 0, 0, 0, 3, 10, 2, '9');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `asset_transaction`
--
ALTER TABLE `asset_transaction`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `asset_transaction`
--
ALTER TABLE `asset_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
