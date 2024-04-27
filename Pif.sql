-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2024 at 10:22 PM
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
-- Database: `PIF`
--

-- --------------------------------------------------------

--
-- Table structure for table `Invoice`
--

CREATE TABLE `Invoice` (
  `InvoiceID` int(10) NOT NULL,
  `InvoiceDate` date NOT NULL,
  `InvoiceUsername` varchar(255) NOT NULL,
  `InvoiceCenterCode` varchar(255) NOT NULL,
  `Amount` float NOT NULL,
  `isPaid` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Measurement`
--

CREATE TABLE `Measurement` (
  `id` int(10) NOT NULL,
  `Weight(kg)` int(3) NOT NULL,
  `Date` date NOT NULL,
  `idInvoice` int(10) NOT NULL,
  `StationID` int(10) NOT NULL,
  `Type` varchar(255) NOT NULL,
  `Username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `RecyclingCenter`
--

CREATE TABLE `RecyclingCenter` (
  `CenterCode` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `PostalCode` int(10) NOT NULL,
  `Town` varchar(255) NOT NULL,
  `Open` time NOT NULL,
  `Close` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Station`
--

CREATE TABLE `Station` (
  `StationID` int(11) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `CenterCode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `Users` (
  `Username` varchar(255) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Type` varchar(255) NOT NULL DEFAULT 'user',
  `RandomCode` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `RecCenterCode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Waste`
--

CREATE TABLE `Waste` (
  `Type` varchar(255) NOT NULL,
  `Describtion` varchar(255) NOT NULL,
  `Price` float(2,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Invoice`
--
ALTER TABLE `Invoice`
  ADD PRIMARY KEY (`InvoiceID`),
  ADD KEY `InvoiceUsername` (`InvoiceUsername`),
  ADD KEY `InvoiceCenterCode` (`InvoiceCenterCode`);

--
-- Indexes for table `Measurement`
--
ALTER TABLE `Measurement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idInvoice` (`idInvoice`),
  ADD KEY `StationID` (`StationID`),
  ADD KEY `Type` (`Type`),
  ADD KEY `Username` (`Username`);

--
-- Indexes for table `RecyclingCenter`
--
ALTER TABLE `RecyclingCenter`
  ADD UNIQUE KEY `Center Code` (`CenterCode`);

--
-- Indexes for table `Station`
--
ALTER TABLE `Station`
  ADD PRIMARY KEY (`StationID`),
  ADD KEY `CenterCode` (`CenterCode`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Username`),
  ADD KEY `RecCenterCode` (`RecCenterCode`);

--
-- Indexes for table `Waste`
--
ALTER TABLE `Waste`
  ADD PRIMARY KEY (`Type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Invoice`
--
ALTER TABLE `Invoice`
  MODIFY `InvoiceID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Measurement`
--
ALTER TABLE `Measurement`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Station`
--
ALTER TABLE `Station`
  MODIFY `StationID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Invoice`
--
ALTER TABLE `Invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`InvoiceUsername`) REFERENCES `users` (`Username`),
  ADD CONSTRAINT `invoice_ibfk_2` FOREIGN KEY (`InvoiceCenterCode`) REFERENCES `RecyclingCenter` (`CenterCode`);

--
-- Constraints for table `Measurement`
--
ALTER TABLE `Measurement`
  ADD CONSTRAINT `measurement_ibfk_1` FOREIGN KEY (`idInvoice`) REFERENCES `Invoice` (`InvoiceID`),
  ADD CONSTRAINT `measurement_ibfk_2` FOREIGN KEY (`StationID`) REFERENCES `Station` (`StationID`),
  ADD CONSTRAINT `measurement_ibfk_3` FOREIGN KEY (`Type`) REFERENCES `Waste` (`Type`),
  ADD CONSTRAINT `measurement_ibfk_4` FOREIGN KEY (`Username`) REFERENCES `users` (`Username`);

--
-- Constraints for table `Station`
--
ALTER TABLE `Station`
  ADD CONSTRAINT `station_ibfk_1` FOREIGN KEY (`CenterCode`) REFERENCES `RecyclingCenter` (`CenterCode`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`RecCenterCode`) REFERENCES `RecyclingCenter` (`CenterCode`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`RecCenterCode`) REFERENCES `RecyclingCenter` (`CenterCode`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
