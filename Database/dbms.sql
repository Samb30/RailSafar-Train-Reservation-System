-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2023 at 09:41 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_details`
--

CREATE TABLE `admin_details` (
  `adminId` int(20) NOT NULL,
  `adminFname` varchar(200) NOT NULL,
  `adminLname` varchar(200) NOT NULL,
  `adminEmail` varchar(200) NOT NULL,
  `adminUname` varchar(200) NOT NULL,
  `adminPwd` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_details`
--

INSERT INTO `admin_details` (`adminId`, `adminFname`, `adminLname`, `adminEmail`, `adminUname`, `adminPwd`) VALUES
(1, 'RailYatra 2', 'Admin', 'admin@gmail.com', 'Manager', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `passenger_details`
--

CREATE TABLE `passenger_details` (
  `passengerId` int(10) NOT NULL,
  `pnrNumber` int(11) NOT NULL,
  `passengerFname` varchar(50) NOT NULL,
  `passengerLname` varchar(50) NOT NULL,
  `passengerAge` int(11) NOT NULL,
  `passengerGender` varchar(10) NOT NULL,
  `passengerAddress` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL,
  `userId` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `passenger_details`
--

INSERT INTO `passenger_details` (`passengerId`, `pnrNumber`, `passengerFname`, `passengerLname`, `passengerAge`, `passengerGender`, `passengerAddress`, `status`, `userId`) VALUES
(2, 0, 'Kalpesh ', 'Salave', 0, 'female', '', 'Booked', 2);

-- --------------------------------------------------------

--
-- Table structure for table `reservation_details`
--

CREATE TABLE `reservation_details` (
  `pnrNumber` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `trainNumber` int(11) NOT NULL,
  `trainName` varchar(30) NOT NULL,
  `startPoint` varchar(50) NOT NULL,
  `destinationPoint` varchar(50) NOT NULL,
  `arrivalTime` time NOT NULL,
  `bookingDate` date NOT NULL,
  `journeyDate` date NOT NULL,
  `Fare` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservation_details`
--

INSERT INTO `reservation_details` (`pnrNumber`, `userId`, `trainNumber`, `trainName`, `startPoint`, `destinationPoint`, `arrivalTime`, `bookingDate`, `journeyDate`, `Fare`) VALUES
(2, 2, 1, 'Nandigram Express', 'Adilabad', 'Delhi', '13:00:00', '0000-00-00', '0000-00-00', 2181);

-- --------------------------------------------------------

--
-- Table structure for table `station_details`
--

CREATE TABLE `station_details` (
  `stationId` int(11) NOT NULL,
  `stationName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `station_details`
--

INSERT INTO `station_details` (`stationId`, `stationName`) VALUES
(1, 'Aurangabad'),
(2, 'Adilabad'),
(3, 'Ahmedabad'),
(4, 'Agra'),
(5, 'Amritsar'),
(6, 'Akola'),
(7, 'Nagpur'),
(8, 'Bhopal'),
(9, 'Chandigarh'),
(10, 'Delhi'),
(11, 'Gurgaon'),
(12, 'Jhansi'),
(13, 'Nanded'),
(14, 'Secunderabad'),
(15, 'Mumbai'),
(16, 'Nashik'),
(17, 'Kanpur'),
(18, 'Lucknow'),
(19, 'Jaipur'),
(20, 'Pune'),
(22, 'Chennai'),
(23, 'Bangalore'),
(24, 'Kolkata'),
(25, 'Basar');

-- --------------------------------------------------------

--
-- Table structure for table `train_details`
--

CREATE TABLE `train_details` (
  `trainNumber` int(11) NOT NULL,
  `trainName` varchar(50) NOT NULL,
  `stationName` varchar(50) NOT NULL,
  `startPoint` varchar(50) NOT NULL,
  `destinationPoint` varchar(50) NOT NULL,
  `arrivalTime` time NOT NULL,
  `departureTime` time NOT NULL DEFAULT '00:00:00',
  `distance` int(11) NOT NULL,
  `Fare` float NOT NULL,
  `Seats` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `train_details`
--

INSERT INTO `train_details` (`trainNumber`, `trainName`, `stationName`, `startPoint`, `destinationPoint`, `arrivalTime`, `departureTime`, `distance`, `Fare`, `Seats`) VALUES
(1, 'Nandigram Express', 'Delhi JT', 'Adilabad', 'Delhi', '13:00:00', '14:00:00', 1000, 2000, 100),
(2, 'Duronto Express', 'Mumbai CST', 'Mumbai', 'Nagpur', '13:20:00', '15:00:00', 1500, 1200, 80),
(3, 'Rajdhani Express', 'Delhi JT', 'Delhi', 'Nagpur', '09:25:00', '09:50:00', 2000, 3000, 100),
(4, 'Devagiri Express', 'Mumbai JCT', 'Mumbai', 'Secunderabad', '21:30:00', '14:45:00', 1200, 2000, 60),
(5, 'Jhansi - Lucknow Intercity', 'Jhansi JCT', 'Jhansi', 'Lucknow', '06:15:00', '12:00:00', 800, 750, 80),
(6, 'Ahmedabad Express', 'Delhi JCT', 'Delhi', 'Ahmedabad', '19:55:00', '09:30:00', 935, 1000, 90),
(7, 'Tapovan Express', 'Nanded JCT', 'Nanded', 'Mumbai', '10:05:00', '21:55:00', 850, 1300, 80),
(8, 'Tapovan Express', 'Mumbai JCT', 'Mumbai', 'Nanded', '06:15:00', '18:00:00', 600, 1000, 80),
(9, 'Panvel Express', 'Nanded JCT', 'Nanded', 'Panvel', '17:35:00', '09:00:00', 690, 750, 60),
(10, 'Sachkhand Express', 'Nanded JCT', 'Nanded', 'Amritsar', '09:30:00', '20:30:00', 1600, 700, 60),
(11, 'Sachkhand Express', 'Amritsar JCT', 'Amritsar', 'Nanded', '04:25:00', '14:25:00', 1600, 1000, 50),
(12, 'Sachkhand Express', 'Amritsar JCT', 'Amritsar', 'Mumbai', '04:25:00', '14:25:00', 1500, 1000, 60),
(13, 'Nanded - Sriganganagar Express', 'Nanded JCT', 'Nanded', 'Sriganganagar', '11:00:00', '20:15:00', 2000, 1200, 60),
(14, 'Ahmedabad Express', 'Ahmedabad JCT', 'Ahmedabad', 'Delhi', '15:55:00', '09:30:00', 930, 850, 80),
(15, 'Delhi Express', 'Delhi JCT', 'Delhi', 'Mumbai', '19:55:00', '09:30:00', 1930, 2000, 60),
(16, 'Delhi Express', 'Delhi JCT', 'Delhi', 'Pune', '14:55:00', '05:30:00', 1730, 3500, 30),
(17, 'Lucknow Express', 'Lucknow JCT', 'Lucknow', 'Delhi', '14:55:00', '04:30:00', 530, 1400, 30),
(18, 'Lucknow Express', 'Lucknow JCT', 'Lucknow', 'Mumbai', '11:55:00', '05:30:00', 1930, 1700, 60),
(19, 'Hyderabad Express', 'Hyderabad JCT', 'Hyderabad', 'Delhi', '14:30:00', '10:15:00', 1680, 1750, 40),
(20, 'Chennai Superfast', 'Chennai Central', 'Chennai', 'Delhi', '08:45:00', '13:20:00', 2500, 1800, 60),
(21, 'Kolkata Express', 'Kolkata JCT', 'Kolkata', 'Mumbai', '09:15:00', '17:45:00', 1960, 1750, 60),
(22, 'Jaipur Shatabdi', 'Jaipur JCT', 'Jaipur', 'Agra', '06:30:00', '10:10:00', 1200, 730, 40),
(23, 'Pune Duronto', 'Pune JCT', 'Pune', 'Mumbai', '16:20:00', '19:55:00', 1830, 1380, 45),
(24, 'Delhi Rajdhani', 'New Delhi', 'Delhi', 'Kolkata', '16:55:00', '10:45:00', 1770, 1965, 25),
(25, 'Delhi Express', 'New Delhi', 'Delhi', 'Kolkata', '08:45:00', '17:45:00', 1380, 1890, 15),
(26, 'Delhi Superfast', 'New Delhi', 'Delhi', 'Chennai', '14:30:00', '10:15:00', 1980, 2350, 25),
(27, 'Delhi Shatabdi', 'New Delhi', 'Delhi', 'Jaipur', '06:30:00', '10:10:00', 1350, 2280, 40),
(28, 'Delhi Duronto', 'New Delhi', 'Delhi', 'Mumbai', '16:20:00', '19:55:00', 1210, 1845, 25),
(29, 'Delhi Rajdhani', 'New Delhi', 'Delhi', 'Hyderabad', '16:55:00', '10:45:00', 1200, 2490, 35),
(30, 'Mumbai Express', 'Mumbai', 'Mumbai', 'Delhi', '11:55:00', '05:30:00', 1590, 1815, 40),
(31, 'Mumbai Superfast', 'Mumbai', 'Mumbai', 'Chennai', '10:30:00', '16:15:00', 1160, 1715, 45),
(32, 'Mumbai Shatabdi', 'Mumbai', 'Mumbai', 'Ahmedabad', '08:15:00', '11:50:00', 1400, 1925, 20),
(33, 'Mumbai Duronto', 'Mumbai', 'Mumbai', 'Kolkata', '13:40:00', '21:15:00', 1540, 1985, 25),
(34, 'Mumbai Rajdhani', 'Mumbai', 'Mumbai', 'Lucknow', '17:30:00', '11:15:00', 1480, 1650, 20),
(35, 'Lucknow Express', 'Lucknow JCT', 'Lucknow', 'Mumbai', '14:45:00', '09:20:00', 1990, 2390, 15),
(36, 'Hyderabad Superfast', 'Hyderabad JCT', 'Hyderabad', 'Delhi', '15:20:00', '23:45:00', 1120, 1910, 50),
(37, 'Chennai Express', 'Chennai Central', 'Chennai', 'Mumbai', '09:45:00', '15:20:00', 1230, 2480, 15),
(38, 'Jaipur Superfast', 'Jaipur JCT', 'Jaipur', 'Delhi', '07:15:00', '10:55:00', 1990, 1565, 40),
(39, 'Pune Duronto', 'Pune JCT', 'Pune', 'Mumbai', '16:20:00', '19:55:00', 1880, 1785, 25),
(40, 'Ahmedabad Superfast', 'Ahmedabad JCT', 'Ahmedabad', 'Mumbai', '13:30:00', '17:05:00', 1390, 1730, 35),
(41, 'Kolkata Rajdhani', 'Kolkata JCT', 'Kolkata', 'Delhi', '19:30:00', '09:15:00', 1750, 2100, 50),
(42, 'Bangalore Express', 'Bangalore City', 'Bangalore', 'Mumbai', '13:05:00', '17:45:00', 1350, 1520, 20),
(43, 'Gurgaon Express', 'Gurgaon', 'Gurgaon', 'Delhi', '08:00:00', '09:00:00', 1920, 1400, 45),
(44, 'Delhi-Mumbai Connection', 'New Delhi', 'Delhi', 'Mumbai', '11:00:00', '16:45:00', 1130, 1250, 35),
(45, 'Mumbai-Delhi Connection', 'Mumbai', 'Mumbai', 'Delhi', '14:30:00', '19:15:00', 1510, 2140, 25),
(46, 'Agra Superfast', 'Agra', 'Agra', 'Delhi', '12:20:00', '14:15:00', 970, 1860, 45),
(47, 'Nashik Express', 'Nashik', 'Nashik', 'Mumbai', '10:55:00', '14:30:00', 1920, 1675, 20),
(48, 'Amritsar Rajdhani', 'Amritsar', 'Amritsar', 'Delhi', '16:30:00', '20:10:00', 1090, 1600, 25),
(49, 'Chandigarh Duronto', 'Chandigarh', 'Chandigarh', 'Delhi', '14:10:00', '17:20:00', 1300, 1770, 25),
(50, 'Secunderabad Express', 'Secunderabad', 'Secunderabad', 'Mumbai', '15:15:00', '21:10:00', 1230, 1560, 30),
(51, 'Nanded Superfast', 'Nanded', 'Nanded', 'Mumbai', '11:45:00', '16:20:00', 1440, 1290, 15),
(52, 'Kanpur Shatabdi', 'Kanpur', 'Kanpur', 'Delhi', '06:30:00', '09:15:00', 1510, 1885, 15),
(53, 'Jaipur Duronto', 'Jaipur', 'Jaipur', 'Mumbai', '07:40:00', '12:25:00', 1250, 1745, 30),
(54, 'Pune Rajdhani', 'Pune', 'Pune', 'Delhi', '16:55:00', '10:45:00', 910, 1875, 45),
(55, 'Lucknow Superfast', 'Lucknow JCT', 'Lucknow', 'Delhi', '15:00:00', '20:30:00', 1190, 1630, 40),
(56, 'Jaipur Express', 'Jaipur', 'Jaipur', 'Delhi', '09:20:00', '12:05:00', 1240, 1340, 45),
(57, 'Nashik Superfast', 'Nashik', 'Nashik', 'Mumbai', '14:10:00', '17:45:00', 1830, 1910, 25),
(58, 'Kolkata Duronto', 'Kolkata', 'Kolkata', 'Delhi', '13:30:00', '21:00:00', 1040, 1725, 45),
(59, 'Mumbai-Ahmedabad Connection', 'Mumbai', 'Mumbai', 'Ahmedabad', '15:30:00', '18:00:00', 1300, 1695, 15),
(60, 'Lucknow Express', 'Lucknow JCT', 'Lucknow', 'Mumbai', '14:45:00', '09:20:00', 1370, 2100, 50),
(61, 'Nagpur Express', 'Nagpur', 'Nagpur', 'Aurangabad', '13:30:00', '19:45:00', 960, 1625, 25),
(62, 'Nagpur Superfast', 'Nagpur', 'Nagpur', 'Adilabad', '09:15:00', '14:30:00', 1100, 1930, 50),
(63, 'Nagpur Shatabdi', 'Nagpur', 'Nagpur', 'Ahmedabad', '07:20:00', '14:10:00', 1790, 2280, 35),
(64, 'Nagpur Duronto', 'Nagpur', 'Nagpur', 'Agra', '11:10:00', '15:45:00', 1270, 1810, 15),
(65, 'Nagpur Rajdhani', 'Nagpur', 'Nagpur', 'Amritsar', '16:40:00', '13:30:00', 1380, 2300, 50),
(66, 'Nagpur Connection', 'Nagpur', 'Nagpur', 'Akola', '14:00:00', '16:45:00', 1100, 2280, 20),
(67, 'Basar Express', 'Nagpur', 'Nagpur', 'Basar', '10:55:00', '15:30:00', 1760, 2010, 20),
(68, 'Bhopal Superfast', 'Nagpur', 'Nagpur', 'Bhopal', '08:30:00', '13:15:00', 1080, 2005, 30),
(69, 'Chandigarh Shatabdi', 'Nagpur', 'Nagpur', 'Chandigarh', '15:20:00', '10:05:00', 1710, 1505, 30),
(70, 'Delhi Duronto', 'Nagpur', 'Nagpur', 'Delhi', '12:45:00', '06:30:00', 920, 1605, 50),
(71, 'Gurgaon Rajdhani', 'Nagpur', 'Nagpur', 'Gurgaon', '16:30:00', '11:15:00', 1080, 2310, 35),
(72, 'Jhansi Express', 'Nagpur', 'Nagpur', 'Jhansi', '14:05:00', '19:50:00', 1820, 1625, 50),
(73, 'Nanded Superfast', 'Nagpur', 'Nagpur', 'Nanded', '13:15:00', '16:50:00', 1450, 1315, 45),
(74, 'Secunderabad Connection', 'Nagpur', 'Nagpur', 'Secunderabad', '09:40:00', '14:25:00', 1010, 1810, 20),
(75, 'Mumbai Express', 'Nagpur', 'Nagpur', 'Mumbai', '11:30:00', '17:05:00', 1080, 1290, 35),
(76, 'Nagpur Fast', 'Nagpur', 'Nagpur', 'Nashik', '12:50:00', '17:25:00', 1600, 2435, 20),
(77, 'Nagpur Shatabdi', 'Nagpur', 'Nagpur', 'Kanpur', '07:55:00', '12:40:00', 1550, 1900, 25),
(78, 'Nagpur Express', 'Nagpur', 'Nagpur', 'Lucknow', '10:00:00', '15:45:00', 970, 2295, 50),
(79, 'Nagpur Superfast', 'Nagpur', 'Nagpur', 'Jaipur', '15:50:00', '21:35:00', 836, 1800, 70),
(80, 'Nagpur Duronto', 'Nagpur', 'Nagpur', 'Pune', '14:25:00', '20:10:00', 950, 1000, 60),
(81, 'Pune Express JT', 'Pune JT', 'Pune', 'Delhi', '13:00:00', '06:00:00', 2000, 6000, 200),
(82, 'Delhi Express JT', 'Delhi JT', 'Delhi', 'Pune', '13:00:00', '06:00:00', 2000, 6000, 500),
(83, 'Delhi Express JT', 'Pune JT', 'Pune', 'Delhi', '13:00:00', '06:00:00', 2000, 100, 100);

-- --------------------------------------------------------

--
-- Table structure for table `users_details`
--

CREATE TABLE `users_details` (
  `userId` int(11) NOT NULL,
  `userFname` varchar(200) NOT NULL,
  `userLname` varchar(200) NOT NULL,
  `userPhone` varchar(200) NOT NULL,
  `userUname` varchar(200) NOT NULL,
  `userEmail` varchar(200) NOT NULL,
  `userPwd` varchar(200) NOT NULL,
  `userAddr` varchar(200) NOT NULL,
  `userBday` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_details`
--

INSERT INTO `users_details` (`userId`, `userFname`, `userLname`, `userPhone`, `userUname`, `userEmail`, `userPwd`, `userAddr`, `userBday`) VALUES
(2, 'Saman', 'Bhoyar', '9874561232', 'samb', 'sam@gmail.com', '12345', 'Nagpur', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_details`
--
ALTER TABLE `admin_details`
  ADD PRIMARY KEY (`adminId`),
  ADD UNIQUE KEY `unique_admin_adminUname` (`adminUname`);

--
-- Indexes for table `passenger_details`
--
ALTER TABLE `passenger_details`
  ADD PRIMARY KEY (`passengerId`),
  ADD KEY `passenger_details_foreign_key_1` (`pnrNumber`);

--
-- Indexes for table `reservation_details`
--
ALTER TABLE `reservation_details`
  ADD PRIMARY KEY (`pnrNumber`),
  ADD KEY `reservation_details_foreign_key_1` (`trainNumber`),
  ADD KEY `reservation_details_foreign_key_4` (`userId`);

--
-- Indexes for table `train_details`
--
ALTER TABLE `train_details`
  ADD PRIMARY KEY (`trainNumber`);

--
-- Indexes for table `users_details`
--
ALTER TABLE `users_details`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `passenger_details`
--
ALTER TABLE `passenger_details`
  MODIFY `passengerId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reservation_details`
--
ALTER TABLE `reservation_details`
  MODIFY `pnrNumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `train_details`
--
ALTER TABLE `train_details`
  MODIFY `trainNumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT for table `users_details`
--
ALTER TABLE `users_details`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
