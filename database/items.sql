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
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `item_type` int(1) NOT NULL COMMENT '1=Electronic Equipment, 2=Heavy Equipment, 3=Lab Equipment, 4=Event & Staging Equipment, 5=Marketing & Promotional Material, 6=IT Assets, 7=Consumables, 8=Tools',
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `item_type`, `name`, `description`, `date`) VALUES
(1, 2, 'Generator', 'This item is used as alternative of Electric Power Supply. It produces Electricity.', 1559024077),
(2, 3, 'LCD', 'This product is used to view of traffic. & human resource through CCTV Cameras', 1559024211),
(3, 1, 'CCTV Camera', 'This device is used for monitoring the Staff at remote locations & Sites. It can display live  video &  Record.', 1559024325),
(4, 4, 'Decoration Piece', 'This product is used when some event is organized. To create impression on guests we need to decorate the Stage.', 1559024583),
(5, 5, 'Pena Flex', 'This product is used for marketing purpose. of any event, any application, any Product.', 1559024700),
(6, 6, 'Ehternet Cables', 'This product is used to connect devices.', 1559024816),
(7, 7, 'Stationery', 'This product is used in office for purpose of writing and making notes of every thing.', 1559024980),
(8, 8, 'Screwdriver', 'Used for Maintenance purpose.', 1559025047),
(9, 1, 'TCT', 'Used like key board to pass instructions to lane AVC System.', 1563536639),
(10, 1, 'PFD', 'Used to display the fare of vehicle on exit side of lane.', 1563536733),
(11, 1, 'Thermal Printer', 'Used for printing of receipt.', 1563536799),
(12, 1, 'Boom Arm', 'Fixed on exit side of lane to stop the vehicle.', 1563536890),
(13, 1, 'Boom Mechanical Barrier', 'Mechanical portion of boom arm use to operate it.', 1563536977),
(14, 1, 'Ground Sensor Receiver', 'Sensors used for axle based classification of vehicle.', 1563537114);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
