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
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `alert_type` int(1) NOT NULL COMMENT '1=action on assets, 2=action on MTR',
  `ref_id` int(11) NOT NULL,
  `date` text NOT NULL,
  `user_type` int(1) NOT NULL COMMENT '1=supervisor , 2=member , 3=admin',
  `user_id` int(11) NOT NULL,
  `for_user_type` int(1) NOT NULL COMMENT '1=supervisor , 2=member , 3=admin',
  `for_user_id` int(11) NOT NULL,
  `notification_msg` text NOT NULL,
  `is_read` int(1) NOT NULL DEFAULT '0' COMMENT '0=pending, 1=read by user'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `alert_type`, `ref_id`, `date`, `user_type`, `user_id`, `for_user_type`, `for_user_id`, `notification_msg`, `is_read`) VALUES
(47, 2, 336, '2019-07-02 08:49:44', 3, 1, 1, 5, 'Your  October, 2019 mtr disapproved.', 1),
(48, 2, 335, '2019-07-02 08:50:30', 3, 1, 1, 5, 'Your  October, 2019 mtr disapproved.', 1),
(359, 1, 1, '2019-07-21 21:52:15', 3, 1, 1, 1, 'A new Asset Added by Admin.', 0),
(360, 1, 1, '2019-07-21 21:52:15', 3, 1, 1, 2, 'A new Asset Added by Admin.', 0),
(361, 1, 1, '2019-07-21 21:52:15', 3, 1, 1, 3, 'A new Asset Added by Admin.', 0),
(362, 1, 1, '2019-07-21 21:52:15', 3, 1, 1, 4, 'A new Asset Added by Admin.', 1),
(363, 1, 1, '2019-07-21 21:52:15', 3, 1, 1, 5, 'A new Asset Added by Admin.', 0),
(364, 1, 1, '2019-07-21 21:52:15', 3, 1, 1, 6, 'A new Asset Added by Admin.', 1),
(365, 1, 1, '2019-07-21 21:52:15', 3, 1, 1, 7, 'A new Asset Added by Admin.', 1),
(366, 1, 1, '2019-07-21 21:52:15', 3, 1, 1, 8, 'A new Asset Added by Admin.', 0),
(367, 1, 1, '2019-07-21 21:52:15', 3, 1, 1, 9, 'A new Asset Added by Admin.', 1),
(368, 1, 1, '2019-07-21 21:52:15', 3, 1, 1, 10, 'A new Asset Added by Admin.', 0),
(369, 1, 1, '2019-07-21 21:52:16', 3, 1, 1, 11, 'A new Asset Added by Admin.', 1),
(370, 1, 1, '2019-07-21 21:52:16', 3, 1, 1, 12, 'A new Asset Added by Admin.', 1),
(371, 1, 1, '2019-07-21 21:52:16', 3, 1, 1, 13, 'A new Asset Added by Admin.', 0),
(372, 1, 1, '2019-07-21 21:52:16', 3, 1, 1, 14, 'A new Asset Added by Admin.', 1),
(373, 1, 1, '2019-07-21 21:52:16', 3, 1, 1, 15, 'A new Asset Added by Admin.', 1),
(374, 1, 1, '2019-07-21 21:52:16', 3, 1, 1, 16, 'A new Asset Added by Admin.', 0),
(375, 1, 1, '2019-07-21 21:52:16', 3, 1, 1, 17, 'A new Asset Added by Admin.', 0),
(376, 1, 1, '2019-07-21 21:52:16', 3, 1, 1, 18, 'A new Asset Added by Admin.', 0),
(377, 1, 1, '2019-07-21 21:52:16', 3, 1, 1, 19, 'A new Asset Added by Admin.', 0),
(378, 1, 1, '2019-07-21 21:52:16', 3, 1, 1, 20, 'A new Asset Added by Admin.', 0),
(379, 1, 1, '2019-07-21 21:52:16', 3, 1, 1, 22, 'A new Asset Added by Admin.', 0),
(380, 1, 1, '2019-07-21 21:52:16', 3, 1, 1, 23, 'A new Asset Added by Admin.', 0),
(381, 1, 1, '2019-07-21 21:52:16', 3, 1, 1, 24, 'A new Asset Added by Admin.', 0),
(382, 1, 2, '2019-07-21 21:52:16', 3, 1, 1, 1, 'A new Asset Added by Admin.', 0),
(383, 1, 2, '2019-07-21 21:52:16', 3, 1, 1, 2, 'A new Asset Added by Admin.', 0),
(384, 1, 2, '2019-07-21 21:52:16', 3, 1, 1, 3, 'A new Asset Added by Admin.', 0),
(385, 1, 2, '2019-07-21 21:52:16', 3, 1, 1, 4, 'A new Asset Added by Admin.', 1),
(386, 1, 2, '2019-07-21 21:52:16', 3, 1, 1, 5, 'A new Asset Added by Admin.', 0),
(387, 1, 2, '2019-07-21 21:52:16', 3, 1, 1, 6, 'A new Asset Added by Admin.', 1),
(388, 1, 2, '2019-07-21 21:52:16', 3, 1, 1, 7, 'A new Asset Added by Admin.', 1),
(389, 1, 2, '2019-07-21 21:52:16', 3, 1, 1, 8, 'A new Asset Added by Admin.', 0),
(390, 1, 2, '2019-07-21 21:52:16', 3, 1, 1, 9, 'A new Asset Added by Admin.', 1),
(391, 1, 2, '2019-07-21 21:52:16', 3, 1, 1, 10, 'A new Asset Added by Admin.', 0),
(392, 1, 2, '2019-07-21 21:52:16', 3, 1, 1, 11, 'A new Asset Added by Admin.', 1),
(393, 1, 2, '2019-07-21 21:52:16', 3, 1, 1, 12, 'A new Asset Added by Admin.', 1),
(394, 1, 2, '2019-07-21 21:52:16', 3, 1, 1, 13, 'A new Asset Added by Admin.', 0),
(395, 1, 2, '2019-07-21 21:52:16', 3, 1, 1, 14, 'A new Asset Added by Admin.', 1),
(396, 1, 2, '2019-07-21 21:52:16', 3, 1, 1, 15, 'A new Asset Added by Admin.', 1),
(397, 1, 2, '2019-07-21 21:52:16', 3, 1, 1, 16, 'A new Asset Added by Admin.', 0),
(398, 1, 2, '2019-07-21 21:52:16', 3, 1, 1, 17, 'A new Asset Added by Admin.', 0),
(399, 1, 2, '2019-07-21 21:52:16', 3, 1, 1, 18, 'A new Asset Added by Admin.', 0),
(400, 1, 2, '2019-07-21 21:52:16', 3, 1, 1, 19, 'A new Asset Added by Admin.', 0),
(401, 1, 2, '2019-07-21 21:52:16', 3, 1, 1, 20, 'A new Asset Added by Admin.', 0),
(402, 1, 2, '2019-07-21 21:52:16', 3, 1, 1, 22, 'A new Asset Added by Admin.', 0),
(403, 1, 2, '2019-07-21 21:52:16', 3, 1, 1, 23, 'A new Asset Added by Admin.', 0),
(404, 1, 2, '2019-07-21 21:52:16', 3, 1, 1, 24, 'A new Asset Added by Admin.', 0),
(409, 2, 143, '2019-07-22 12:54:08', 3, 1, 1, 3, 'Your  September, 2016 mtr disapproved.', 0),
(410, 2, 130, '2019-07-22 13:03:14', 3, 1, 1, 3, 'Your  April, 2017 mtr disapproved.', 0),
(411, 2, 356, '2019-07-23 12:22:18', 3, 1, 1, 5, 'Your  November, 2018 mtr disapproved.', 0),
(412, 2, 352, '2019-07-23 12:26:20', 3, 1, 1, 5, 'Your  October, 2018 mtr disapproved.', 0),
(413, 2, 357, '2019-07-25 10:32:25', 3, 1, 1, 7, 'Your  September, 2018 mtr disapproved.', 0),
(414, 2, 358, '2019-07-25 10:32:51', 3, 1, 1, 7, 'Your  October, 2018 mtr disapproved.', 0),
(415, 2, 359, '2019-07-25 10:33:02', 3, 1, 1, 7, 'Your  October, 2018 mtr disapproved.', 0),
(416, 2, 360, '2019-07-25 10:33:12', 3, 1, 1, 7, 'Your  October, 2018 mtr disapproved.', 0),
(417, 2, 361, '2019-07-25 10:33:22', 3, 1, 1, 7, 'Your  November, 2018 mtr disapproved.', 0),
(418, 2, 362, '2019-07-25 10:33:32', 3, 1, 1, 7, 'Your  November, 2018 mtr disapproved.', 0),
(419, 2, 363, '2019-07-25 10:33:44', 3, 1, 1, 7, 'Your  November, 2018 mtr disapproved.', 0),
(420, 2, 364, '2019-07-25 10:33:55', 3, 1, 1, 7, 'Your  December, 2018 mtr disapproved.', 0),
(421, 1, 5, '2019-07-25 16:28:47', 1, 11, 3, 1, 'A new Asset Added by Supervisor.', 0),
(422, 1, 6, '2019-07-25 16:28:47', 1, 11, 3, 1, 'A new Asset Added by Supervisor.', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=423;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
