-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2024 at 06:23 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `carwash_data`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `token_expiry` datetime DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `username`, `password`, `token_expiry`, `is_verified`) VALUES
(1, 'admin', 'admin@gmail.com', 'aa7f019c326413d5b8bcad4314228bcd33ef557f5d81c7cc977f7728156f4357', NULL, 0),
(4, 'jake', 'jake@gmail.com', '86abb32d72a6612a716382b3c999a68b2664a31b1304cca6f22d5e8ff9420824', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `notification` varchar(100) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `notification`, `timestamp`) VALUES
(15, 'We are open till 07.00PM from next week', '2024-09-29 03:53:24'),
(2, 'We are open till 07.00PM from next week', '2021-06-02 15:10:40');

-- --------------------------------------------------------

--
-- Table structure for table `queue`
--

CREATE TABLE `queue` (
  `id` int(11) NOT NULL,
  `owner_email` varchar(200) NOT NULL,
  `owner_name` varchar(200) NOT NULL,
  `owner_phone` varchar(20) NOT NULL,
  `owner_address` varchar(250) NOT NULL,
  `vehicle_type` int(11) NOT NULL,
  `vehicle_number` varchar(20) NOT NULL,
  `service_type` int(11) NOT NULL,
  `in_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `out_time` timestamp NULL DEFAULT NULL,
  `status_type` int(11) NOT NULL DEFAULT 1,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `queue`
--

INSERT INTO `queue` (`id`, `owner_email`, `owner_name`, `owner_phone`, `owner_address`, `vehicle_type`, `vehicle_number`, `service_type`, `in_time`, `out_time`, `status_type`, `last_update`) VALUES
(23, 'johnlestermacabulos@gmail.com', 'john lester macabulos', '', 'asas', 2, '65476454', 1, '2024-09-29 02:18:02', NULL, 0, '2024-10-20 07:37:39'),
(27, 'johnlestermacabulos@gmail.com', 'john lester macabulos', '56465676', 'adsdsf', 3, '65476454df', 2, '2024-10-28 22:18:15', NULL, 1, '2024-10-29 05:18:15'),
(29, 'johnlestermacabulos@gmail.com', 'john lester macabulos', '232142354354564', 'fsdfsdffrdsfd', 3, '65476454', 1, '2024-11-18 18:18:01', NULL, 1, '2024-11-19 03:05:45');

-- --------------------------------------------------------

--
-- Table structure for table `service_type`
--

CREATE TABLE `service_type` (
  `id` int(11) NOT NULL,
  `type` varchar(200) NOT NULL,
  `description` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `service_type`
--

INSERT INTO `service_type` (`id`, `type`, `description`) VALUES
(1, 'Car wash only', 'Only car wash'),
(2, 'Car wash and waxing', 'Car wash and waxing as an additional service '),
(3, 'Car wash only', 'Only car wash'),
(4, 'Car wash and waxing', 'Car wash and waxing as an additional service '),
(5, 'Motor wash only', 'Only motor wash'),
(6, 'Motor Waxing only', 'Only motor waxing');

-- --------------------------------------------------------

--
-- Table structure for table `status_type`
--

CREATE TABLE `status_type` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `status_type`
--

INSERT INTO `status_type` (`id`, `name`) VALUES
(1, 'Initialized'),
(2, 'In Progress'),
(3, 'Completed'),
(4, 'Dispatched'),
(0, 'On Hold');

-- --------------------------------------------------------

--
-- Table structure for table `status_updates`
--

CREATE TABLE `status_updates` (
  `queue_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `description` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `status_updates`
--

INSERT INTO `status_updates` (`queue_id`, `status_id`, `time`, `description`) VALUES
(1, 4, '2021-06-03 14:50:42', 'Your car wash is completed'),
(1, 2, '2021-06-03 14:50:42', 'Your car wash is in progress. Please refresh back in few minutes for updates.'),
(2, 1, '2021-06-03 14:50:42', 'Your car wash is initialized. Please refresh back in few minutes for updates.'),
(2, 2, '2021-06-03 14:50:42', 'Your car wash is in progress. Please refresh back in few minutes for updates.'),
(3, 1, '2021-06-03 14:50:42', 'Your car wash is initialized. Please refresh back in few minutes for updates.'),
(3, 2, '2021-06-03 14:50:42', 'Your car wash is in progress. Please refresh back in few minutes for updates.');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_type`
--

CREATE TABLE `vehicle_type` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `vehicle_type`
--

INSERT INTO `vehicle_type` (`id`, `name`) VALUES
(1, 'Car'),
(2, 'Van'),
(3, 'Taxi'),
(4, 'Bus'),
(5, 'Motor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notification` (`notification`);

--
-- Indexes for table `queue`
--
ALTER TABLE `queue`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vehicle_number_2` (`vehicle_number`,`status_type`),
  ADD KEY `vehicle_number` (`vehicle_number`);

--
-- Indexes for table `service_type`
--
ALTER TABLE `service_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_type`
--
ALTER TABLE `status_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_updates`
--
ALTER TABLE `status_updates`
  ADD PRIMARY KEY (`queue_id`,`status_id`);

--
-- Indexes for table `vehicle_type`
--
ALTER TABLE `vehicle_type`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `queue`
--
ALTER TABLE `queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `service_type`
--
ALTER TABLE `service_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `status_type`
--
ALTER TABLE `status_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vehicle_type`
--
ALTER TABLE `vehicle_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
