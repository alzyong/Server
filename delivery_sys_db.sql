-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2021 at 04:23 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `delivery_sys`
--

-- --------------------------------------------------------

--
-- Table structure for table `all_accounts`
--

CREATE TABLE `all_accounts` (
  `accountID` varchar(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `phoneNum` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `address` varchar(50) NOT NULL,
  `accType` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `all_devices`
--

CREATE TABLE `all_devices` (
  `deviceID` varchar(10) NOT NULL,
  `currentlyActive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `courier_account`
--

CREATE TABLE `courier_account` (
  `accountID` varchar(20) NOT NULL,
  `company` varchar(50) NOT NULL,
  `empID` varchar(15) NOT NULL,
  `totalEarnings` double NOT NULL,
  `currentlyActive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `device_specifications`
--

CREATE TABLE `device_specifications` (
  `transactionID` varchar(10) NOT NULL,
  `deviceID` varchar(15) NOT NULL,
  `solarCell` tinyint(1) NOT NULL,
  `gpsModule` tinyint(1) NOT NULL,
  `dhtModule` tinyint(1) NOT NULL,
  `lockModule` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `iot_data`
--

CREATE TABLE `iot_data` (
  `deviceID` varchar(15) NOT NULL,
  `dateTime` datetime NOT NULL,
  `breachStatus` tinyint(1) NOT NULL,
  `dhtTempData` double NOT NULL,
  `dhtHumidityData` double NOT NULL,
  `gpsData` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `product_info`
--

CREATE TABLE `product_info` (
  `productID` varchar(30) NOT NULL,
  `productName` varchar(50) NOT NULL,
  `manufactureDate` date DEFAULT NULL,
  `expiryDate` date DEFAULT NULL,
  `senderAcc` varchar(30) DEFAULT NULL,
  `company` varchar(50) DEFAULT NULL,
  `serialNum` varchar(20) NOT NULL,
  `category` varchar(20) NOT NULL,
  `qrCode` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `receiver_account`
--

CREATE TABLE `receiver_account` (
  `accountID` varchar(20) NOT NULL,
  `altContactPerson` varchar(50) NOT NULL,
  `altPhoneNum` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sender_account`
--

CREATE TABLE `sender_account` (
  `accountID` varchar(15) NOT NULL,
  `company` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `transactionID` varchar(10) NOT NULL,
  `deviceID` varchar(15) NOT NULL,
  `senderAcc` varchar(20) NOT NULL,
  `pickupAddress` varchar(100) NOT NULL,
  `productID` varchar(30) NOT NULL,
  `courierAcc` varchar(20) NOT NULL,
  `pickedUp` tinyint(1) NOT NULL DEFAULT 0,
  `receiverAcc` varchar(20) NOT NULL,
  `deliveryAddress` varchar(100) NOT NULL,
  `deliveryCoord` varchar(30) NOT NULL,
  `delivered` tinyint(1) NOT NULL DEFAULT 0,
  `deliveryFunds` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `all_accounts`
--
ALTER TABLE `all_accounts`
  ADD PRIMARY KEY (`phoneNum`),
  ADD UNIQUE KEY `accountID` (`accountID`);

--
-- Indexes for table `all_devices`
--
ALTER TABLE `all_devices`
  ADD PRIMARY KEY (`deviceID`);

--
-- Indexes for table `courier_account`
--
ALTER TABLE `courier_account`
  ADD PRIMARY KEY (`accountID`);

--
-- Indexes for table `device_specifications`
--
ALTER TABLE `device_specifications`
  ADD PRIMARY KEY (`transactionID`);

--
-- Indexes for table `iot_data`
--
ALTER TABLE `iot_data`
  ADD PRIMARY KEY (`dateTime`),
  ADD KEY `deviceID_FK` (`deviceID`);

--
-- Indexes for table `product_info`
--
ALTER TABLE `product_info`
  ADD PRIMARY KEY (`productID`),
  ADD UNIQUE KEY `serialNum` (`serialNum`);

--
-- Indexes for table `receiver_account`
--
ALTER TABLE `receiver_account`
  ADD KEY `RecAcc_FK` (`accountID`);

--
-- Indexes for table `sender_account`
--
ALTER TABLE `sender_account`
  ADD KEY `SendAcc_FK` (`accountID`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transactionID`),
  ADD KEY `transReceiverAccID_FK` (`receiverAcc`),
  ADD KEY `transCouierAccID_FK` (`courierAcc`),
  ADD KEY `transSenderAccID_FK` (`senderAcc`),
  ADD KEY `transProductID_FK` (`productID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courier_account`
--
ALTER TABLE `courier_account`
  ADD CONSTRAINT `CourAcc_FK` FOREIGN KEY (`accountID`) REFERENCES `all_accounts` (`accountID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `receiver_account`
--
ALTER TABLE `receiver_account`
  ADD CONSTRAINT `RecAcc_FK` FOREIGN KEY (`accountID`) REFERENCES `all_accounts` (`accountID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sender_account`
--
ALTER TABLE `sender_account`
  ADD CONSTRAINT `SendAcc_FK` FOREIGN KEY (`accountID`) REFERENCES `all_accounts` (`accountID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
