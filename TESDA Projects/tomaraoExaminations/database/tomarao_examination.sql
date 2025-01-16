-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2024 at 08:03 AM
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
-- Database: `tomarao_examination`
--

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `tomarao_Id` varchar(150) NOT NULL,
  `tomarao_Fname` varchar(191) NOT NULL,
  `tomarao_Lname` varchar(191) NOT NULL,
  `tomarao_Email` varchar(191) NOT NULL,
  `tomarao_Username` varchar(191) NOT NULL,
  `tomarao_Password` varchar(191) NOT NULL,
  `tomarao_Type` tinyint(4) NOT NULL DEFAULT 0,
  `tomarao_Status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`tomarao_Id`, `tomarao_Fname`, `tomarao_Lname`, `tomarao_Email`, `tomarao_Username`, `tomarao_Password`, `tomarao_Type`, `tomarao_Status`) VALUES
('08bddcaf697462ac53e5', 'Student', 'Student', 'student1@gmail.com', 'student', '12345', 0, 1),
('0f79b9609ec4cee0c6e5', 'Student2', 'Student2', 'student2@gmail.com', 'student2', '12345', 0, 1),
('24e4e7cd6856797251a7', 'Student3', 'Student3', 'studen3@gmail.com', 'student3', '12345', 0, 1),
('ad10fcc57d4de848c3ef', 'Admin', 'Admin', 'admin@admin.com', 'admin', '12345', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`tomarao_Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
