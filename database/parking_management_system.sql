-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 14, 2026 at 11:10 AM
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
-- Database: `parking_management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `activitylogs`
--

CREATE TABLE `activitylogs` (
  `ActivityLogID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Username` varchar(100) NOT NULL,
  `Role` varchar(50) NOT NULL,
  `Action` varchar(255) NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activitylogs`
--

INSERT INTO `activitylogs` (`ActivityLogID`, `UserID`, `Username`, `Role`, `Action`, `CreatedAt`) VALUES
(71, 1, 'superadmin', 'superadmin', 'Logged in', '2026-08-14 07:04:24'),
(72, 1, 'superadmin', 'superadmin', 'Logged out', '2026-08-14 07:04:47'),
(73, 1, 'superadmin', 'superadmin', 'Logged in', '2026-08-14 07:04:55'),
(74, 1, 'superadmin', 'superadmin', 'Logged out', '2026-08-14 07:05:16'),
(75, 4, 'admin_new', 'admin', 'Logged in', '2026-08-14 07:05:27'),
(76, 4, 'admin_new', 'admin', 'Deactivated user account: ', '2026-08-14 07:05:35'),
(77, 4, 'admin_new', 'admin', 'Deactivated user account: ', '2026-08-14 07:05:38'),
(78, 4, 'admin_new', 'admin', 'Deactivated user account: ', '2026-08-14 07:05:39'),
(79, 4, 'admin_new', 'admin', 'Deactivated user account: ', '2026-08-14 07:05:40'),
(80, 4, 'admin_new', 'admin', 'Deactivated user account: ', '2026-08-14 07:05:42'),
(81, 4, 'admin_new', 'admin', 'Deactivated user account: ', '2026-08-14 07:05:43'),
(82, 4, 'admin_new', 'admin', 'Logged out', '2026-08-14 07:05:45'),
(83, 1, 'superadmin', 'superadmin', 'Logged in', '2026-08-14 07:05:50'),
(84, 1, 'superadmin', 'superadmin', 'Activated user account: teststaff123', '2026-08-14 07:05:54'),
(85, 1, 'superadmin', 'superadmin', 'Activated user account: staff12', '2026-08-14 07:05:56'),
(86, 1, 'superadmin', 'superadmin', 'Activated user account: staff23', '2026-08-14 07:05:58'),
(87, 1, 'superadmin', 'superadmin', 'Activated user account: newstaff', '2026-08-14 07:05:59'),
(88, 1, 'superadmin', 'superadmin', 'Activated user account: staff12345', '2026-08-14 07:06:01'),
(89, 1, 'superadmin', 'superadmin', 'Activated user account: staff1234', '2026-08-14 07:06:03'),
(90, 1, 'superadmin', 'superadmin', 'Logged out', '2026-08-14 07:06:10'),
(91, 1, 'superadmin', 'superadmin', 'Logged in', '2026-08-14 07:06:38'),
(92, 1, 'superadmin', 'superadmin', 'Logged out', '2026-08-14 07:07:55'),
(93, 1, 'superadmin', 'superadmin', 'Logged in', '2026-08-14 07:07:59'),
(94, 1, 'superadmin', 'superadmin', 'Logged out', '2026-08-14 07:08:11'),
(95, 1, 'superadmin', 'superadmin', 'Logged in', '2026-08-14 07:08:15'),
(96, 1, 'superadmin', 'superadmin', 'Logged out', '2026-08-14 07:08:33');

-- --------------------------------------------------------

--
-- Table structure for table `parkinglogs`
--

CREATE TABLE `parkinglogs` (
  `LogID` int(11) NOT NULL,
  `VehicleID` int(11) NOT NULL,
  `SlotID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `TimeIn` datetime NOT NULL,
  `TimeOut` datetime DEFAULT NULL,
  `DurationMinutes` int(11) DEFAULT NULL,
  `Status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `parkingslots`
--

CREATE TABLE `parkingslots` (
  `SlotID` int(11) NOT NULL,
  `Floor` int(11) NOT NULL,
  `SlotNumber` varchar(10) NOT NULL,
  `VehicleType` varchar(20) NOT NULL,
  `Status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `PaymentID` int(11) NOT NULL,
  `LogID` int(11) NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `Method` varchar(20) NOT NULL,
  `DateTimePaid` datetime DEFAULT NULL,
  `Status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Role` varchar(20) NOT NULL,
  `Active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `VehicleID` int(11) NOT NULL,
  `PlateNumber` varchar(20) NOT NULL,
  `NumberOfWheels` int(11) NOT NULL,
  `Brand` varchar(50) NOT NULL,
  `Model` varchar(50) NOT NULL,
  `Color` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `parkinglogs`
--
ALTER TABLE `parkinglogs`
  ADD PRIMARY KEY (`LogID`),
  ADD KEY `FK_ParkingLogs_Vehicle` (`VehicleID`),
  ADD KEY `FK_ParkingLogs_Slot` (`SlotID`),
  ADD KEY `FK_ParkingLogs_User` (`UserID`);

--
-- Indexes for table `parkingslots`
--
ALTER TABLE `parkingslots`
  ADD PRIMARY KEY (`SlotID`),
  ADD UNIQUE KEY `Floor` (`Floor`,`SlotNumber`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`PaymentID`),
  ADD KEY `FK_Payments_ParkingLog` (`LogID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`VehicleID`),
  ADD UNIQUE KEY `PlateNumber` (`PlateNumber`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `parkinglogs`
--
ALTER TABLE `parkinglogs`
  MODIFY `LogID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `parkingslots`
--
ALTER TABLE `parkingslots`
  MODIFY `SlotID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `VehicleID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `parkinglogs`
--
ALTER TABLE `parkinglogs`
  ADD CONSTRAINT `FK_ParkingLogs_Slot` FOREIGN KEY (`SlotID`) REFERENCES `parkingslots` (`SlotID`),
  ADD CONSTRAINT `FK_ParkingLogs_User` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `FK_ParkingLogs_Vehicle` FOREIGN KEY (`VehicleID`) REFERENCES `vehicles` (`VehicleID`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `FK_Payments_ParkingLog` FOREIGN KEY (`LogID`) REFERENCES `parkinglogs` (`LogID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
