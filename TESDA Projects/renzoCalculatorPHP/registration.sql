-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 15, 2024 at 11:32 AM
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
-- Database: `renzocalculator`
--

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `id` int(11) NOT NULL,
  `tomarao_Fname` varchar(50) NOT NULL,
  `tomarao_Lname` varchar(50) NOT NULL,
  `tomarao_Email` varchar(50) NOT NULL,
  `tomarao_Username` varchar(50) NOT NULL,
  `tomarao_Password` varchar(50) NOT NULL,
  `tomarao_ConfirmedPassword` varchar(50) NOT NULL,
  `tomarao_Phone` int(20) NOT NULL,
  `tomarao_Street` varchar(50) NOT NULL,
  `tomarao_Barangay` varchar(50) NOT NULL,
  `tomarao_City` varchar(50) NOT NULL,
  `tomarao_Province` varchar(50) NOT NULL,
  `tomarao_Code` int(7) NOT NULL,
  `tomarao_Country` varchar(50) NOT NULL,
  `tomarao_Company` varchar(50) NOT NULL,
  `tomarao_Count` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `tomarao_Fname`, `tomarao_Lname`, `tomarao_Email`, `tomarao_Username`, `tomarao_Password`, `tomarao_ConfirmedPassword`, `tomarao_Phone`, `tomarao_Street`, `tomarao_Barangay`, `tomarao_City`, `tomarao_Province`, `tomarao_Code`, `tomarao_Country`, `tomarao_Company`, `tomarao_Count`) VALUES
(1, '', '', '', '', '', '', 0, '', '', '', '', 0, '', '', 0),
(2, 'ROSEMARIE', 'ROSEMARIE', '', '', '', '', 0, '', '', '', '', 0, '', '', 0),
(3, 'ROSEMARIE', 'ROSEMARIE', '', '', '', '', 0, '', '', '', '', 0, '', '', 0),
(4, 'ROSEMARIE', 'ROSEMARIE', '', '', '', '', 0, '', '', '', '', 0, '', '', 0),
(5, 'ROSEMARIE', 'ROSEMARIE', '', '', '', '', 0, '', '', '', '', 0, '', '', 0),
(6, 'ROSEMARIE', 'GUIRRE', '', '', '', '', 0, '', '', '', '', 0, '', '', 0),
(7, 'rose', 'guirre', 'rosemarieguirre@gmail.com', '', '', '', 0, '', '', '', '', 0, '', '', 0),
(8, 'rose', 'guirre', 'rosemarieguirre@gmail.com', '', '', '', 0, '', '', '', '', 0, '', '', 0),
(9, 'aaa', 'aaaa', 'aaa@g.com', '', '', '', 0, '', '', '', '', 0, '', '', 0),
(10, 'aaa', 'aaaa', 'aaa@g.com', 'aaa', 'aaa', 'aaa', 0, '', '', '', '', 0, '', '', 0),
(11, 'aaa', 'aaaa', 'aaa@g.com', 'aaa', 'aaa', 'aaa', 0, '', '', '', '', 0, '', '', 0),
(12, 'aaa', 'aaaa', 'aaa@g.com', 'aaa', 'aaa', 'aaa', 0, '', '', '', '', 0, '', '', 0),
(13, 'bbb', 'bbb', 'bbb@gmail.com', 'aaa', 'aaa', '', 0, '', '', '', '', 0, '', '', 0),
(14, 'nnn', 'nnn', 'nnn@gmail.com', 'nnnn', 'nnnn', 'nnnn', 0, '', '', '', '', 0, '', '', 0),
(17, 'zoren', 'flores', 'floreszoren@gmail.com', 'zflores', '012345', '012345', 2147483647, '456', 'maimpis', 'san fernando', 'pampanga', 2000, 'philippines', 'garland', 5),
(18, 'zoren', 'flores', 'floreszoren@gmail.com', 'zflores', '012345', '012345', 2147483647, '456', 'maimpis', 'san fernando', 'pampanga', 2000, 'philippines', 'garland', 5),
(19, 'zoren', 'flores', 'floreszoren@gmail.com', 'zflores', '012345', '012345', 2147483647, '456', 'maimpis', 'san fernando', 'pampanga', 2000, 'philippines', 'garland', 5),
(20, 'zoren', 'flores', 'floreszoren@gmail.com', 'zflores', '012345', '012345', 2147483647, '456', 'maimpis', 'san fernando', 'pampanga', 2000, 'philippines', 'garland', 5),
(21, 'zoren', 'flores', 'floreszoren@gmail.com', 'zflores', '012345', '012345', 2147483647, '456', 'maimpis', 'san fernando', 'pampanga', 2000, 'philippines', 'garland', 5),
(22, 'zoren', 'flores', 'floreszoren@gmail.com', 'zflores123', '12345', '12345', 1234567890, '225', 'Maimpis', 'San Fernando', 'Pampanga', 2000, 'Philippines', 'garland', 5),
(23, 'zoren', 'flores', 'floreszoren@gmail.com', 'zflores123', '12345', '12345', 1234567890, '225', 'Maimpis', 'San Fernando', 'Pampanga', 2000, 'Philippines', 'garland', 5),
(24, 'zoren', 'flores', 'floreszoren@gmail.com', 'zflores123', '12345', '12345', 1234567890, '225', 'Maimpis', 'San Fernando', 'Pampanga', 2000, 'Philippines', 'garland', 5),
(31, 'renzo', 'flores', 'flores@gmail.com', 'flores123', '123456789', '123456789', 2147483647, '476', 'calulut', 'san fernando', 'pampanga', 2000, 'philippines', 'VA', 2),
(32, 'renzo', 'flores', 'flores@gmail.com', 'flores123', '123456', '123456', 1234567890, '486', 'maimpis', 'san fernando', 'pampanga', 2000, 'philippines', 'project interior', 5),
(33, 'zoren', 'flores', 'flores@gmail.com', 'zoren', '123456', '123456', 123456789, '123', 'maimpis', 'san fernando', 'pampanga', 2000, 'philippines', 'project interior', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
