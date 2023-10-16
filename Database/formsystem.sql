-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2023 at 06:22 PM
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
-- Database: `system`
--

-- --------------------------------------------------------

--
-- Table structure for table `countries_details`
--

CREATE TABLE `countries_details` (
  `CountryId` int(11) NOT NULL,
  `CountryName` varchar(255) NOT NULL,
  `CountryDetails` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `countries_details`
--

INSERT INTO `countries_details` (`CountryId`, `CountryName`, `CountryDetails`) VALUES
(1, 'Pakistan', '{\"Punjab\":[\"Lahore\",\"Faisalabad\",\"Rawalpindi\"],\"Sindh\":[\"Karachi\",\"Hyderabad\",\"Sukkur\"],\"Khyber Pakhtunkhwa\":[\"Peshawar\",\"Abbottabad\",\"Swat\"],\"Balochistan\":[\"Quetta\",\"Gwadar\",\"Turbat\"]}'),
(2, 'England', '{\"London\":[\"London\"],\"North West\":[\"Manchester\",\"Liverpool\",\"Blackpool\"],\"South East\":[\"Brighton\",\"Portsmouth\",\"Oxford\"]}'),
(3, 'Australia', '{\"New South Wales\":[\"Sydney\",\"Newcastle\",\"Wollongong\"],\"Victoria\":[\"Melbourne\",\"Geelong\",\"Ballarat\"],\"Queensland\":[\"Brisbane\",\"Gold Coast\",\"Cairns\"]}'),
(4, 'Sri Lanka', '{\"Western Province\":[\"Colombo\",\"Gampaha\",\"Kalutara\"],\"Central Province\":[\"Kandy\",\"Nuwara Eliya\",\"Matale\"],\"Southern Province\":[\"Galle\",\"Matara\",\"Hambantota\"]}');

-- --------------------------------------------------------

--
-- Table structure for table `persondata`
--

CREATE TABLE `persondata` (
  `PersonId` int(11) NOT NULL,
  `FirstName` varchar(255) DEFAULT NULL,
  `LastName` varchar(255) DEFAULT NULL,
  `Gender` varchar(255) DEFAULT NULL,
  `Country` varchar(255) DEFAULT NULL,
  `State` varchar(255) DEFAULT NULL,
  `City` varchar(255) DEFAULT NULL,
  `ProfilePic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `persondata`
--

INSERT INTO `persondata` (`PersonId`, `FirstName`, `LastName`, `Gender`, `Country`, `State`, `City`, `ProfilePic`) VALUES
(1, 'Aazan', 'Khan', 'Male', 'Pakistan', 'Sindh', 'Hyderabad', '../Images/79778_8-83719_best-wallpaper-for-laptop.jpg'),
(2, 'Sheeraz', 'Khan', 'Male', 'Pakistan', 'Khyber Pakhtunkhwa', 'Peshawar', '../Images/33670_00e0830cf439d2599b2d21374a7ed2e1.jpg'),
(6, 'Farhan', 'Khan', 'Male', 'Sri Lanka', 'Southern Province', 'Matara', '../Images/71782_bg img.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `countries_details`
--
ALTER TABLE `countries_details`
  ADD PRIMARY KEY (`CountryId`);

--
-- Indexes for table `persondata`
--
ALTER TABLE `persondata`
  ADD KEY `PersonId` (`PersonId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `countries_details`
--
ALTER TABLE `countries_details`
  MODIFY `CountryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `persondata`
--
ALTER TABLE `persondata`
  MODIFY `PersonId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
