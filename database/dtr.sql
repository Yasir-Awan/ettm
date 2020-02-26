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
-- Table structure for table `dtr`
--

CREATE TABLE `dtr` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `upload_type` int(1) NOT NULL DEFAULT '1' COMMENT '1=upload by supervisor, 2=upload by member	',
  `toolplaza` int(11) NOT NULL,
  `omc` int(11) NOT NULL,
  `description` text NOT NULL,
  `notes` text NOT NULL,
  `class1` varchar(100) NOT NULL,
  `class2` varchar(100) NOT NULL,
  `class3` varchar(100) NOT NULL,
  `class4` varchar(100) NOT NULL,
  `class5` varchar(100) NOT NULL,
  `class6` varchar(100) NOT NULL,
  `class7` varchar(100) NOT NULL,
  `class8` varchar(100) NOT NULL,
  `class9` varchar(100) NOT NULL,
  `class10` varchar(100) NOT NULL,
  `total` varchar(100) NOT NULL,
  `for_date` text NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '0=pending, 1=approved. 2=canceled',
  `adddate` text NOT NULL,
  `actiondate` text NOT NULL,
  `reason` text NOT NULL,
  `file` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dtr`
--

INSERT INTO `dtr` (`id`, `user_id`, `upload_type`, `toolplaza`, `omc`, `description`, `notes`, `class1`, `class2`, `class3`, `class4`, `class5`, `class6`, `class7`, `class8`, `class9`, `class10`, `total`, `for_date`, `status`, `adddate`, `actiondate`, `reason`, `file`) VALUES
(7, 4, 1, 5, 15, 'TRAFFIC', 'No of Passages', '5427', '1556', '450', '12', '57', '115', '167', '42', '76', '64', '7966', '2019-07-01', 1, '1563789314', '', '<p>date</p>', 'dtr7_01-07-2019.pdf'),
(8, 4, 1, 5, 15, 'TRAFFIC', 'No of Passages', '5827', '1616', '360', '13', '26', '119', '185', '40', '84', '65', '8335', '2019-07-02', 1, '1563789294', '', '<p>date</p>', 'dtr8_02-07-2019.pdf'),
(9, 23, 1, 9, 20, 'TRAFFIC', 'No of Passages', '7519', '1430', '2066', '162', '981', '483', '116', '241', '95', '145', '13238', '2019-07-01', 2, '1563171944', '', '<p><span style=\"font-weight: bold;\">1.Please also attach the PDF copy of signed DTR.</span></p>', 'dtr9_2019-07-01.pdf'),
(10, 8, 1, 9, 20, 'TRAFFIC', 'No of Passages', '7503', '1451', '1825', '183', '1255', '527', '121', '283', '113', '158', '13419', '2019-07-02', 2, '1563173692', '', '<p><span style=\"font-weight: 700;\">1.Please also attach the PDF copy of signed DTR.</span><br></p>', 'dtr10_2019-07-02.pdf'),
(11, 4, 1, 5, 15, 'TRAFFIC', 'No of Passages', '5573', '796', '749', '13', '426', '121', '88', '87', '63', '67', '7983', '2019-07-03', 1, '1563791750', '', '', 'dtr11_03-07-2019.pdf'),
(12, 4, 1, 5, 15, 'TRAFFIC', 'No of Passages', '8308', '1272', '944', '16', '551', '138', '99', '116', '99', '77', '11620', '2019-07-04', 1, '1563791739', '', '', 'dtr12_04-07-2019.pdf'),
(13, 4, 1, 5, 15, 'TRAFFIC', 'No of Passages', '8158', '1159', '1028', '27', '468', '102', '121', '82', '74', '40', '11259', '2019-07-05-01', 1, '1563789108', '', '', 'dtr13_05-07-2019.pdf'),
(14, 4, 1, 5, 15, 'TRAFFIC', 'No of Passages', '8436', '1171', '1116', '12', '288', '14', '68', '50', '39', '18', '11212', '2019-07-06', 1, '1563791727', '', '', 'dtr14_06-07-2019.pdf'),
(15, 1, 1, 1, 1, 'TRAFFIC', 'No of Passages', '7626', '740', '2395', '19', '65', '11', '11', '7', '10', '15', '10899', '2019-07-01', 1, '1563867692', '', '', 'dtr15_2019-07-01.pdf'),
(16, 8, 1, 9, 20, 'TRAFFIC', 'No of Passages', '7171', '1539', '1574', '223', '1633', '677', '145', '272', '157', '175', '13566', '2019-07-03', 2, '1563256165', '', '<p><span style=\"font-weight: 700;\">1.Please also attach the PDF copy of signed DTR</span><br></p>', 'dtr16_2019-07-03.pdf'),
(17, 8, 1, 9, 20, 'TRAFFIC', 'No of Passages', '7685', '1649', '2322', '156', '1307', '673', '137', '284', '139', '145', '14497', '2019-07-04', 2, '1563256747', '', '<p><span style=\"font-weight: 700;\">1.Please also attach the PDF copy of signed DTR.</span><br></p>', 'dtr17_2019-07-04.pdf'),
(18, 1, 1, 1, 1, 'TRAFFIC', 'No of Passages', '5258', '401', '2372', '22', '234', '12', '4', '4', '64', '59', '8430', '2019-07-02', 1, '1563257098', '', '', 'dtr18_2019-07-02.pdf'),
(19, 1, 1, 1, 1, 'TRAFFIC', 'No of Passages', '5635', '392', '1962', '34', '262', '7', '11', '10', '30', '58', '8401', '2019-07-03', 1, '1563257436', '', '', 'dtr19_2019-07-03.pdf'),
(20, 1, 1, 1, 1, 'TRAFFIC', 'No of Passages', '6789', '1143', '1858', '12', '287', '5', '1', '5', '22', '64', '10186', '2019-07-04', 1, '1563257790', '', '', 'dtr20_2019-07-04.pdf'),
(21, 8, 1, 9, 20, 'TRAFFIC', 'No of Passages', '8754', '1643', '2295', '109', '851', '361', '105', '233', '152', '136', '14639', '2019-07-05', 2, '1563258095', '', '<p><span style=\"font-weight: 700;\">1.Please also attach the PDF copy of signed DTR.</span><br></p>', 'dtr21_2019-07-05.pdf'),
(22, 1, 1, 1, 1, 'TRAFFIC', 'No of Passages', '6931', '1041', '1295', '47', '45', '11', '9', '2', '21', '37', '9439', '2019-07-05', 1, '1563258342', '', '', 'dtr22_2019-07-05.pdf'),
(23, 8, 1, 9, 20, 'TRAFFIC', 'No of Passages', '8792', '2224', '3017', '25', '179', '105', '17', '42', '24', '20', '14445', '2019-07-06', 2, '1563258426', '', '<p><span style=\"font-weight: 700;\">1.Please also attach the PDF copy of signed DTR.</span><br></p>', 'dtr23_2019-07-06.pdf'),
(24, 1, 1, 1, 1, 'TRAFFIC', 'No of Passages', '8020', '1386', '2190', '42', '140', '18', '5', '14', '31', '25', '11871', '2019-07-06', 1, '1563258648', '', '', 'dtr24_2019-07-06.pdf'),
(25, 8, 1, 9, 20, 'TRAFFIC', 'No of Passages', '9937', '1878', '2623', '113', '1069', '456', '105', '204', '110', '123', '16618', '2019-07-07', 2, '1563258661', '', '<p><span style=\"font-weight: 700;\">1.Please also attach the PDF copy of signed DTR.</span><br></p>', 'dtr25_2019-07-07.pdf'),
(26, 1, 1, 1, 1, 'TRAFFIC', 'No of Passages', '7630', '1192', '1936', '18', '71', '10', '0', '4', '33', '48', '10942', '2019-07-07', 1, '1563258903', '', '', 'dtr26_2019-07-07.pdf'),
(27, 8, 1, 9, 20, 'TRAFFIC', 'No of Passages', '8634', '1550', '2326', '102', '1078', '461', '113', '214', '110', '180', '14768', '2019-07-08', 2, '1563258943', '', '<p>Attach EXCEL sheet..</p>', 'dtr27_2019-07-08.pdf'),
(28, 1, 1, 1, 1, 'TRAFFIC', 'No of Passages', '8732', '1230', '1097', '39', '101', '27', '6', '4', '37', '12', '11285', '2019-07-08', 1, '1563259117', '', '', 'dtr28_2019-07-08.pdf'),
(29, 8, 1, 9, 20, 'TRAFFIC', 'No of Passages', '8436', '1829', '2614', '102', '949', '363', '72', '173', '103', '116', '14757', '2019-07-09', 1, '1563259171', '', '', 'dtr29_2019-07-09.pdf'),
(30, 1, 1, 1, 1, 'TRAFFIC', 'No of Passages', '7116', '1013', '2163', '21', '87', '5', '4', '2', '23', '18', '10452', '2019-07-09', 1, '1563259306', '', '', 'dtr30_2019-07-09.pdf'),
(31, 1, 1, 1, 1, 'TRAFFIC', 'No of Passages', '7571', '1370', '2170', '14', '47', '10', '7', '7', '74', '24', '11294', '2019-07-10', 1, '1563259459', '', '', 'dtr31_2019-07-10.pdf'),
(32, 1, 1, 1, 1, 'TRAFFIC', 'No of Passages', '5812', '1003', '1783', '45', '556', '92', '181', '76', '76', '155', '9779', '2019-07-11', 1, '1563259720', '', '', 'dtr32_2019-07-11.pdf'),
(33, 8, 1, 9, 20, 'TRAFFIC', 'No of Passages', '8909', '1538', '2267', '92', '1112', '428', '89', '253', '115', '159', '14962', '2019-07-10', 2, '1563268254', '', '<p>Attach same date EXCEL sheet DTR and Comprehensive report.</p>', 'dtr33_2019-07-10.pdf'),
(34, 1, 1, 1, 1, 'TRAFFIC', 'No of Passages', '5770', '1078', '2070', '39', '243', '36', '99', '57', '45', '379', '9816', '2019-07-12', 1, '1563259906', '', '', 'dtr34_2019-07-12.pdf'),
(35, 1, 1, 1, 1, 'TRAFFIC', 'No of Passages', '4385', '793', '1736', '31', '370', '47', '6', '20', '67', '559', '8014', '2019-07-13', 1, '1563260143', '', '', 'dtr35_2019-07-13.pdf'),
(36, 1, 1, 1, 1, 'TRAFFIC', 'No of Passages', '6069', '1093', '2328', '25', '242', '36', '31', '30', '44', '82', '9980', '2019-07-14', 1, '1563260340', '', '', 'dtr36_2019-07-14.pdf'),
(37, 1, 1, 1, 1, 'TRAFFIC', 'No of Passages', '7157', '1154', '2621', '20', '334', '44', '22', '26', '46', '87', '11511', '2019-07-15', 1, '1563260688', '', '', 'dtr37_2019-07-15.pdf'),
(38, 8, 1, 9, 20, 'TRAFFIC', 'No of Passages', '8646', '1426', '1559', '189', '1443', '635', '111', '341', '135', '174', '14659', '2019-07-12', 2, '1563268581', '', '<p>in attachment you have to attach excle sheet DTR and in supporting document you have to attach comprehensive.. and entred values traffic and comprehensive trafiic not matched.</p>', 'dtr38_2019-07-12.pdf'),
(46, 8, 1, 9, 20, 'TRAFFIC', 'No of Passages', '8238', '1507', '2164', '92', '808', '260', '83', '169', '85', '114', '13520', '2019-07-13', 2, '1563269968', '', '<p>Please reattach the document in proper manner .... i.e same DTR with same attachment</p>', ''),
(50, 4, 1, 5, 15, 'TRAFFIC', 'No of Passages', '8246', '1094', '1935', '9', '298', '18', '60', '46', '56', '13', '11775', '2019-07-07', 1, '1563791719', '', '', 'dtr50_07-07-2019.pdf'),
(51, 4, 1, 5, 15, 'TRAFFIC', 'No of Passages', '8773', '1211', '1401', '14', '397', '23', '95', '80', '57', '26', '12077', '2019-07-08', 1, '1563791711', '', '', 'dtr51_08-07-2019.pdf'),
(52, 4, 1, 5, 15, 'TRAFFIC', 'No of Passages', '8224', '999', '1259', '16', '379', '49', '83', '87', '82', '28', '11206', '2019-07-09', 1, '1563791702', '', '', 'dtr52_09-07-2019.pdf'),
(53, 4, 1, 5, 15, 'TRAFFIC', 'No of Passages', '8154', '960', '1613', '17', '453', '64', '115', '78', '85', '62', '11601', '2019-07-10', 1, '1563791693', '', '', 'dtr53_10-07-2019.pdf'),
(54, 4, 1, 5, 15, 'TRAFFIC', 'No of Passages', '6854', '608', '549', '22', '331', '44', '76', '60', '50', '27', '8621', '2019-07-11', 1, '1563791561', '', '', 'dtr54_11-07-2019.pdf'),
(55, 4, 1, 5, 15, 'TRAFFIC', 'No of Passages', '6762', '667', '855', '15', '325', '122', '81', '90', '64', '65', '9046', '2019-07-12', 1, '1563791543', '', '', 'dtr55_12-07-2019.pdf'),
(56, 4, 1, 5, 15, 'TRAFFIC', 'No of Passages', '5517', '479', '1097', '16', '229', '146', '79', '87', '46', '66', '7762', '2019-07-13', 1, '1563791534', '', '', 'dtr56_13-07-2019.pdf'),
(57, 4, 1, 5, 15, 'TRAFFIC', 'No of Passages', '6681', '735', '715', '23', '261', '162', '110', '137', '73', '110', '9007', '2019-07-14', 1, '1563791525', '', '', 'dtr57_14-07-2019.pdf'),
(58, 4, 1, 5, 15, 'TRAFFIC', 'No of Passages', '8015', '838', '848', '22', '302', '165', '83', '125', '61', '98', '10557', '2019-07-15', 1, '1563791516', '', '', 'dtr58_15-07-2019.pdf'),
(59, 4, 1, 5, 15, 'TRAFFIC', 'No of Passages', '7291', '950', '819', '25', '368', '176', '119', '128', '72', '116', '10064', '2019-07-16', 1, '1563791504', '', '', 'dtr59_16-07-2019.pdf'),
(60, 4, 1, 5, 15, 'TRAFFIC', 'No of Passages', '8060', '1075', '972', '26', '389', '178', '105', '134', '51', '101', '11091', '2019-07-17', 1, '1563791495', '', '', 'dtr60_17-07-2019.pdf'),
(61, 4, 1, 5, 15, 'TRAFFIC', 'No of Passages', '8477', '963', '1148', '24', '370', '171', '95', '113', '68', '102', '11531', '2019-07-18', 1, '1563791235', '', '', 'dtr61_18-07-2019.pdf'),
(62, 4, 1, 5, 15, 'TRAFFIC', 'No of Passages', '8498', '933', '1095', '27', '385', '198', '95', '155', '62', '106', '11554', '2019-07-19', 1, '1563791404', '', '', 'dtr62_19-07-2019.pdf'),
(63, 4, 1, 5, 15, 'TRAFFIC', 'No of Passages', '8331', '1216', '1114', '33', '458', '217', '143', '201', '84', '175', '11972', '2019-07-20', 1, '1563791341', '', '', 'dtr63_20-07-2019.pdf'),
(64, 4, 1, 5, 15, 'TRAFFIC', 'No of Passages', '7309', '1066', '954', '17', '348', '132', '177', '134', '75', '117', '10329', '2019-07-21', 1, '1563791326', '', '', 'dtr64_21-07-2019.pdf'),
(66, 4, 1, 5, 15, 'TRAFFIC', 'No of Passages', '8023', '1340', '1050', '21', '383', '143', '174', '156', '97', '108', '11495', '2019-07-22', 1, '1563862897', '', '', 'dtr66_22-07-2019.pdf'),
(67, 1, 1, 1, 1, 'TRAFFIC', 'No of Passages', '6018', '1058', '2418', '35', '429', '42', '41', '35', '89', '84', '10249', '2019-07-16', 1, '1563869979', '', '', 'dtr67_2019-07-16.pdf'),
(73, 1, 1, 1, 1, 'TRAFFIC', 'No of Passages', '7321', '1997', '1546', '47', '188', '290', '31', '29', '117', '88', '11654', '2019-07-22', 1, '1563951390', '', '', 'dtr73_2019-07-22.pdf'),
(74, 1, 1, 1, 1, 'TRAFFIC', 'No of Passages', '5265', '1368', '2571', '25', '455', '13', '64', '21', '93', '32', '9907', '2019-07-23', 1, '1563951444', '', '', 'dtr74_2019-07-23.pdf'),
(76, 4, 1, 5, 15, 'TRAFFIC', 'No of Passages', '6767', '923', '1398', '7', '147', '41', '45', '62', '19', '41', '9450', '2019-07-23', 1, '1563957126', '', '', 'dtr76_23-07-2019.pdf'),
(79, 1, 1, 1, 1, 'TRAFFIC', 'No of Passages', '6328', '1009', '1463', '38', '927', '71', '73', '34', '131', '74', '10148', '2019-07-17', 1, '1564037829', '', '', 'dtr79_2019-07-17.pdf'),
(80, 1, 1, 1, 1, 'TRAFFIC', 'No of Passages', '5912', '1075', '1936', '33', '488', '45', '29', '21', '47', '65', '9651', '2019-07-18', 1, '1564037885', '', '', 'dtr80_2019-07-18.pdf'),
(81, 1, 1, 1, 1, 'TRAFFIC', 'No of Passages', '5444', '1116', '1595', '53', '405', '30', '40', '30', '64', '118', '8895', '2019-07-19', 1, '1564037941', '', '', 'dtr81_2019-07-19.pdf'),
(82, 1, 1, 1, 1, 'TRAFFIC', 'No of Passages', '6346', '1070', '1833', '37', '712', '84', '58', '30', '125', '44', '10339', '2019-07-20', 1, '1564038009', '', '', 'dtr82_2019-07-20.pdf'),
(83, 1, 1, 1, 1, 'TRAFFIC', 'No of Passages', '6103', '940', '2488', '31', '357', '61', '29', '23', '43', '91', '10166', '2019-07-21', 1, '1564038208', '', '', 'dtr83_2019-07-21.pdf'),
(84, 1, 1, 1, 1, 'TRAFFIC', 'No of Passages', '6246', '1921', '2458', '54', '26', '28', '73', '35', '57', '33', '10931', '2019-07-24', 1, '1564038352', '', '', 'dtr84_2019-07-24.pdf'),
(85, 4, 1, 5, 15, 'TRAFFIC', 'No of Passages', '8180', '933', '1510', '12', '242', '64', '63', '77', '27', '58', '11166', '2019-07-24', 1, '1564052026', '', '', 'dtr85_24-07-2019.pdf'),
(86, 1, 1, 1, 1, 'TRAFFIC', 'No of Passages', '6774', '1944', '2008', '12', '116', '111', '26', '24', '38', '24', '11077', '2019-07-25', 1, '1564121683', '', '', 'dtr86_2019-07-25.pdf'),
(87, 4, 1, 5, 15, 'TRAFFIC', 'No of Passages', '7860', '799', '1529', '7', '126', '28', '23', '36', '16', '23', '10447', '25-07-2019', 1, '1564123356', '', '', 'dtr87_25-07-2019.pdf');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dtr`
--
ALTER TABLE `dtr`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dtr`
--
ALTER TABLE `dtr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
