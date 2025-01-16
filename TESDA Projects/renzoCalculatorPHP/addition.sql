-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 15, 2024 at 11:33 AM
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
-- Table structure for table `addition`
--

CREATE TABLE `addition` (
  `tomarao_Num1` float(10,2) NOT NULL,
  `tomarao_Num2` float(10,2) NOT NULL,
  `tomaraoSum` float(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addition`
--

INSERT INTO `addition` (`tomarao_Num1`, `tomarao_Num2`, `tomaraoSum`) VALUES
(2.00, 2.00, 4.00),
(2.00, 2.00, 4.00),
(2.00, 2.00, 4.00),
(2.00, 2.00, 4.00),
(2.00, 2.00, 4.00),
(5.00, 15.00, 20.00),
(2.00, 2.00, 4.00),
(5.00, 5.00, 10.00),
(5.00, 5.00, 10.00),
(5.00, 5.00, 10.00),
(5.00, 5.00, 10.00);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
