-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2024 at 02:17 AM
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
-- Database: `tomaraokiosk`
--

-- --------------------------------------------------------

--
-- Table structure for table `archive`
--

CREATE TABLE `archive` (
  `archiveId` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `unit` varchar(150) NOT NULL,
  `price_per_unit` decimal(10,2) NOT NULL,
  `image_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `date_time` varchar(150) NOT NULL,
  `customer_contact` varchar(255) NOT NULL,
  `item_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `unit` varchar(50) NOT NULL,
  `price_per_unit` decimal(10,2) NOT NULL,
  `image_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `unit`, `price_per_unit`, `image_url`) VALUES
(15, 'test1', 'pcs', 100.00, '1.png'),
(16, 'test2', 'pcs', 200.00, '2.png'),
(17, 'test3', 'pcs', 300.00, '3.png'),
(18, 'test4', 'pcs', 400.00, '4.png'),
(19, 'test5', 'pcs', 500.00, '5.png'),
(20, 'test6', 'pcs', 600.00, '6.png'),
(21, 'test7', 'pcs', 600.00, 'p_img18.png'),
(24, 'test8', 'pcs', 900.00, '9.png');

-- --------------------------------------------------------

--
-- Table structure for table `tomaraoregistration`
--

CREATE TABLE `tomaraoregistration` (
  `id` int(11) NOT NULL,
  `tomarao_Fname` varchar(50) NOT NULL,
  `tomarao_Lname` varchar(50) NOT NULL,
  `tomarao_Email` varchar(50) NOT NULL,
  `tomarao_Username` varchar(50) NOT NULL,
  `tomarao_Password` varchar(50) NOT NULL,
  `tomarao_ConfirmedPassword` varchar(50) NOT NULL,
  `tomarao_type` varchar(10) NOT NULL,
  `tomarao_status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tomaraoregistration`
--

INSERT INTO `tomaraoregistration` (`id`, `tomarao_Fname`, `tomarao_Lname`, `tomarao_Email`, `tomarao_Username`, `tomarao_Password`, `tomarao_ConfirmedPassword`, `tomarao_type`, `tomarao_status`) VALUES
(1, 'zoren', 'flores', 'admin@kiosk.com', 'admin', '12345', '12345', '1', '1'),
(2, 'zoren', 'flores', 'client@gmail.com', 'client', '12345', '12345', '0', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `archive`
--
ALTER TABLE `archive`
  ADD PRIMARY KEY (`archiveId`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `tomaraoregistration`
--
ALTER TABLE `tomaraoregistration`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `archive`
--
ALTER TABLE `archive`
  MODIFY `archiveId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tomaraoregistration`
--
ALTER TABLE `tomaraoregistration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
