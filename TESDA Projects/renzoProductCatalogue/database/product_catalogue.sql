-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 21, 2024 at 07:11 AM
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
-- Database: `product_catalogue`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cartId` varchar(150) NOT NULL,
  `productId` varchar(150) NOT NULL,
  `pname` varchar(150) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `qty` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `username` varchar(150) NOT NULL,
  `order_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderId` varchar(150) NOT NULL,
  `username` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `name` varchar(150) NOT NULL,
  `productId` varchar(255) NOT NULL,
  `qty` varchar(150) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `address` varchar(255) NOT NULL,
  `payment_method` varchar(150) NOT NULL,
  `transaction_number` varchar(255) NOT NULL,
  `order_at` date DEFAULT NULL,
  `fulfilled_at` date DEFAULT NULL,
  `delivery_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderId`, `username`, `email`, `name`, `productId`, `qty`, `total_price`, `address`, `payment_method`, `transaction_number`, `order_at`, `fulfilled_at`, `delivery_date`) VALUES
('20241212045337-test-gcash-10', 'test', 'test@gmail.com', 'test test', '20241208-test,20241208-test2,20241208-test3,20241208-test4,20241208-test5', '1.00,1.00,1.00,1.00,1.00', 2500.00, '45 M CSF P 200', 'gcash', '', '2024-12-12', '2024-12-12', '2024-12-12'),
('20241212052500-diana-gcash-5', 'diana', 'd@gmail.com', 'Diana Pangilinan', '20241208-test,20241208-test2,20241208-test5', '2.00,3.00,3.00', 4000.00, '123 M CSF P 2000', 'gcash', 'adadahdahgdyiagsd6464968784654654668', '2024-12-12', '2024-12-12', '2024-12-13'),
('20241212053631-test-paypal-6', 'test', 'test@gmail.com', 'test test', '20241208-test', '1.00', 500.00, '45 M CSF P 200', 'paypal', 'asdadasdasdee33425234', '2024-12-12', NULL, NULL),
('20241212130334-client-paymaya-14', 'client', 'client@gmail.com', 'client client', '20241212-Carrot,20241212-Kalabasa', '1.00,3.00', 4650.00, '123 123 123 123 123', 'paymaya', 'JHAKDHGAGDUYG546464864', '2024-12-12', '2024-12-12', '2024-12-12');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `productId` varchar(150) NOT NULL,
  `pname` varchar(150) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `unit` varchar(150) NOT NULL,
  `qty` decimal(10,0) NOT NULL,
  `description` varchar(255) NOT NULL,
  `category` varchar(150) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productId`, `pname`, `price`, `unit`, `qty`, `description`, `category`, `image`, `created_at`, `updated_at`) VALUES
('20241212-Cabbage', 'Cabbage', 800.00, 'pcs', 500, 'Freshly picked from the farm of Bulakan, Bulacan.', 'Vegetables', 'p_3.webp', '2024-12-12', '2024-12-12'),
('20241212-Carrot', 'Carrot', 150.00, 'pcs', 499, 'Freshly picked from the farm of Bulakan, Bulacan.', 'Vegetables', 'p_1.jpg', '2024-12-12', NULL),
('20241212-Eggplant', 'Eggplant', 400.00, 'pcs', 500, 'Freshly picked from the farm of Bulakan, Bulacan.', 'Vegetables', 'p_5.jpg', '2024-12-12', NULL),
('20241212-Lettuce', 'Lettuce', 150.00, 'pcs', 500, 'Freshly picked from the farm of Bulakan, Bulacan.', 'Vegetables', 'p_2.webp', '2024-12-12', '2024-12-12'),
('20241212-Orange', 'Orange', 120.00, 'pcs', 50, 'Fresh', 'Fruits', 'p_7.webp', '2024-12-12', NULL),
('20241212-Raddish', 'Raddish', 1000.00, 'pcs', 850, 'Freshly picked from the farm of Bulakan, Bulacan.', 'Vegetables', 'p_6.webp', '2024-12-12', '2024-12-12'),
('20241212-Vitamilk', 'Vitamilk', 80.00, 'pcs', 50, 'Vitamilk Vanilla', 'Beverages', 'p_8.webp', '2024-12-12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `reviewId` varchar(150) NOT NULL,
  `productId` varchar(150) NOT NULL,
  `username` varchar(150) NOT NULL,
  `rate` int(10) NOT NULL,
  `reviews` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`reviewId`, `productId`, `username`, `rate`, `reviews`) VALUES
('20241210-admin', '20241208-test4', 'admin', 5, 'test'),
('20241210-admin11', '20241208-test4', 'admin', 5, 'FREEEEESH'),
('20241210-test7', '20241208-test3', 'test', 5, 'Freesssh'),
('20241210-test715', '20241208-test2', 'test', 2, 'Not so Fresh'),
('20241212-client640', '20241212-Kalabasa', 'client', 5, 'SO FRESH'),
('20241212-diana478', '20241208-test5', 'diana', 5, ''),
('20241212-test444', '20241208-test5', 'test', 5, ''),
('20241212-test585', '20241208-test', 'test', 5, ''),
('20241212-test704', '20241208-test2', 'test', 5, '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` varchar(150) NOT NULL,
  `fname` varchar(150) NOT NULL,
  `lname` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `username` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `number` varchar(150) NOT NULL,
  `street` varchar(150) NOT NULL,
  `barangay` varchar(150) NOT NULL,
  `municipality` varchar(150) NOT NULL,
  `province` varchar(150) NOT NULL,
  `zipcode` int(11) NOT NULL,
  `type` varchar(10) NOT NULL,
  `status` varchar(10) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `photo` varchar(255) NOT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `fname`, `lname`, `email`, `username`, `password`, `number`, `street`, `barangay`, `municipality`, `province`, `zipcode`, `type`, `status`, `created_at`, `photo`, `updated_at`) VALUES
('2024-admin@gmail.com', 'Zoren', 'Flores', 'admin@gmail.com', 'admin', 'admin12345', '2147483647', '123', 'Maimpis', 'CSF', 'P', 2000, '1', '1', '2024-12-07', '', '2024-12-08'),
('2024-client@gmail.com', 'client', 'client', 'client@gmail.com', 'client', 'admin12345', '2147483647', '123', '123', '123', '123', 123, '0', '1', '2024-12-12', '', NULL),
('2024-kevincosme@gmail.com', 'Kevin', 'Cosme', 'kevincosme@gmail.com', 'kevin', 'kevincosme', '2147483647', '123', 'Maligay', 'QC', 'Manila', 1500, '0', '1', '2024-12-12', '', NULL),
('2024-test@gmail.com', 'Test', 'Test', 'test@gmail.com', 'username', 'password', '2147483647', '123', '123', '123', '123', 123, '0', '0', '2024-12-13', '', NULL),
('2024-test@gmail.commm', 'test', 'test', 'test@gmail.commm', 'testasda', 'test', '09170000000', '123', '123', '123', '123', 123, '0', '0', '2024-12-13', '', NULL),
('2024-test@test.com', 'test', 'test', 'test@test.com', 'testtest', 'test', '54646465464', '64646464', '6464646', '464646', '464646', 6464, '0', '0', '2024-12-13', '', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cartId`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderId`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`productId`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`reviewId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
