-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 31, 2025 at 01:26 PM
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
-- Database: `ncrdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `location_name` varchar(255) NOT NULL,
  `pickup_date` datetime NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `RID` int(11) NOT NULL,
  `car_model` varchar(255) NOT NULL,
  `status` enum('pending','confirmed','cancelled') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cars_deals`
--

CREATE TABLE `cars_deals` (
  `id` int(11) NOT NULL,
  `car_model` varchar(255) DEFAULT '',
  `brand` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT NULL,
  `people_capacity` int(11) DEFAULT NULL,
  `autopilot` varchar(50) DEFAULT NULL,
  `range` varchar(50) DEFAULT NULL,
  `fuel_type` varchar(50) DEFAULT NULL,
  `price_per_day` decimal(10,2) DEFAULT NULL,
  `book_link` varchar(255) DEFAULT NULL,
  `is_booked` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cars_deals`
--

INSERT INTO `cars_deals` (`id`, `car_model`, `brand`, `image`, `rating`, `people_capacity`, `autopilot`, `range`, `fuel_type`, `price_per_day`, `book_link`, `is_booked`) VALUES
(1, 'Tesla Model S', NULL, 'assets/deals-1.png', 4.8, 4, 'Autopilot', NULL, 'Electric', 2000.00, '#', 1),
(2, 'Tesla Model E', NULL, 'assets/deals-2.png', 4.8, 4, 'Autopilot', NULL, 'Electric', 1500.00, '#', 1),
(3, 'Tesla Model Y', NULL, 'assets/deals-3.png', 4.8, 4, 'Autopilot', NULL, 'Electric', 2000.00, '#', 1),
(4, 'Mitsubishi Mirage', NULL, 'assets/deals-4.png', 4.7, 4, 'Manual', NULL, 'Diesel', 1200.00, '#', 1),
(5, 'Mitsubishi Xpander', NULL, 'assets/deals-5.png', 4.7, 4, 'Manual', NULL, 'Diesel', 1500.00, '#', 1),
(6, 'Mitsubishi Pajero Sports', NULL, 'assets/deals-6.png', 4.7, 4, 'Manual', NULL, 'Diesel', 1800.00, '#', 1),
(7, 'Mazda CX5', NULL, 'assets/deals-7.png', 4.7, 4, 'Manual', NULL, 'Diesel', 1300.00, '#', 1),
(8, 'Mazda CX-30', NULL, 'assets/deals-8.png', 4.7, 4, 'Manual', NULL, 'Diesel', 1400.00, '#', 1),
(169, 'Tesla Model z', NULL, 'assets/deals-1.png', 4.8, 4, 'Autopilot', NULL, 'Electric', 2000.00, '#', 1),
(170, 'Corolla', 'Toyota', 'C:\\Users\\user\\OneDrive\\Desktop\\VRENTAL\\assets\\deals-10.png', 4.0, 4, 'Manual', '18km/l', 'Diesel', 1800.00, '#', NULL),
(171, 'Innova', 'Toyota', 'C:\\Users\\user\\OneDrive\\Desktop\\VRENTAL\\assets\\deals-11.png', 4.0, 4, 'Manual', '18km/l', 'Diesel', 1500.00, '#', NULL),
(194, 'Fortuner', 'Toyota', 'C:\\Users\\user\\OneDrive\\Desktop\\VRENTAL\\assets\\deals-12.png', 4.0, 4, 'Manual', '18km/l', 'Diesel', 1900.00, '#', 1),
(195, 'Amaze', 'Honda', 'C:\\Users\\user\\OneDrive\\Desktop\\VRENTAL\\assets\\deals-13.png', 4.0, 4, 'Manual', '18km/l', 'Diesel', 1000.00, '#', 0),
(196, 'Amaze x', 'Honda', 'C:\\Users\\user\\OneDrive\\Desktop\\VRENTAL\\assets\\deals-13.png', 4.0, 4, 'Manual', '18km/l', 'Diesel', 1000.00, '#', 0),
(197, 'Elevate', 'Honda', 'C:\\Users\\user\\OneDrive\\Desktop\\VRENTAL\\assets\\deals-14.png', 4.0, 4, 'Manual', '18km/l', 'Diesel', 1200.00, '#', 0),
(198, 'City', 'Honda', 'C:\\Users\\user\\OneDrive\\Desktop\\VRENTAL\\assets\\deals-15.png', 4.0, 4, 'Manual', '18km/l', 'Diesel', 1500.00, '#', 1),
(199, 'Corolla V', 'Toyota', 'C:\\Users\\user\\OneDrive\\Desktop\\VRENTAL\\assets\\deals-10.png', 4.0, 4, 'Manual', '18km/l', 'Diesel', 1800.00, '#', 0),
(200, 'Civic', 'Honda', 'C:\\Users\\user\\OneDrive\\Desktop\\VRENTAL\\assets\\deals-16.png', 4.5, 5, 'Automatic', '16km/l', 'Petrol', 2000.00, '#', 0),
(201, 'Accord', 'Honda', 'C:\\Users\\user\\OneDrive\\Desktop\\VRENTAL\\assets\\deals-17.png', 4.8, 5, 'Automatic', '15km/l', 'Petrol', 2500.00, '#', 0),
(202, 'RAV4', 'Toyota', 'C:\\Users\\user\\OneDrive\\Desktop\\VRENTAL\\assets\\deals-18.png', 4.7, 5, 'Automatic', '12km/l', 'Hybrid', 2800.00, '#', 0),
(203, 'Highlander', 'Toyota', 'C:\\Users\\user\\OneDrive\\Desktop\\VRENTAL\\assets\\deals-19.png', 4.9, 7, 'Automatic', '10km/l', 'Petrol', 3500.00, '#', 0),
(204, 'Sienna', 'Toyota', 'C:\\Users\\user\\OneDrive\\Desktop\\VRENTAL\\assets\\deals-20.png', 4.6, 7, 'Automatic', '11km/l', 'Hybrid', 3200.00, '#', 0),
(205, NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, 0),
(206, NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `feedback` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `message`, `feedback`) VALUES
(1, 'Esther Mayiel ', 'cant see my location', 'thank you for your feedback'),
(2, 'Esther Mayiel ', 'failed to rent car', '');

-- --------------------------------------------------------

--
-- Table structure for table `details`
--

CREATE TABLE `details` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `location_name` varchar(255) NOT NULL,
  `pickup_date` datetime NOT NULL,
  `payment_method` enum('M-Pesa','Cash','Credit Card') NOT NULL,
  `payment_number` varchar(50) DEFAULT NULL,
  `credit_card_number` varchar(50) DEFAULT NULL,
  `is_booked` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `full_texts`
--

CREATE TABLE `full_texts` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `location_id` int(11) NOT NULL,
  `car_model` varchar(255) NOT NULL,
  `booking_date` datetime NOT NULL,
  `pickup_date` date NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `location_name` varchar(255) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `payment_number` varchar(50) NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `credit_card_number` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rental_spots`
--

CREATE TABLE `rental_spots` (
  `RID` int(100) NOT NULL,
  `location_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rental_spots`
--

INSERT INTO `rental_spots` (`RID`, `location_name`, `address`) VALUES
(1, 'Nakuru Town', 'Location address in Nakuru Town'),
(2, 'Menengai', 'Location address in Menengai'),
(3, 'Bondeni', 'Location address in Bondeni'),
(4, 'Kivumbini', 'Location address in Kivumbini'),
(5, 'Kwa Rhoda', 'Location address in Kwa Rhoda'),
(6, 'Naivasha Road', 'Location address in Naivasha Road'),
(7, 'Kenyatta Avenue', 'Location address in Kenyatta Avenue'),
(8, 'Lanet', 'Location address in Lanet'),
(9, 'Mbaruk', 'Location address in Mbaruk'),
(10, 'Nakuru Airport', 'Location address in Nakuru Airport'),
(11, 'Gilgil Road', 'Location address in Gilgil Road'),
(12, 'Njiru', 'Location address in Njiru'),
(13, 'Nakuru East', 'Location address in Nakuru East'),
(14, 'Nakuru West', 'Location address in Nakuru West'),
(15, 'Lakeview', 'Location address in Lakeview');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UID` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(255) DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UID`, `firstname`, `lastname`, `username`, `email`, `password`, `role`, `created_at`, `updated_at`, `status`) VALUES
(1, 'Ifrah', 'Rukiya', 'Maskan', 'maskan@gmail.com', '$2y$10$53x1pbNU6PGItAeUBfNqtOKjLMQ5ngNUpjpbVdp2s0n941ZaU5Ayu', 'user', '2024-12-04 09:07:47', '2024-12-04 09:07:47', 'active'),
(2, 'Rodgers', 'o', 'Rod', 'rod@gmail.com', '$2y$10$f29uzImh.d0py4ry.RRy6.1zk9KywYklcShsa4fwY156l0dH2YC9G', 'user', '2024-12-05 07:34:23', '2024-12-05 07:34:23', 'active'),
(3, 'Sally', 'M', 'sal', 'sally@gmail.com', '$2y$10$pvHnaOU.6rEOEWTVbqz8O.okl5xCquOovPiasAYQzXnLn5G3SOAr6', 'user', '2024-12-05 07:36:51', '2024-12-05 07:36:51', 'active'),
(4, 'Esther ', 'Mayiel', 'Essy', 'esthermayiel8@gmail.com', '$2y$10$C4FyHD1bwBPZjQje4X0xrebfZtoER511V2xeg4H3EkmhkMHiYUutC', 'admin', '2024-12-05 07:39:39', '2024-12-05 07:39:39', 'active'),
(5, 'Sam', 'G', 'gsam', 'gsam@gmail.com', '$2y$10$83MvhNDUwf7LtNudpFAIfeALl8MkBLRNNzxAiLoALK9Qbj2Qpn97S', 'user', '2024-12-05 08:31:13', '2024-12-05 08:31:13', 'active'),
(6, 'Sarah', 'Mayiel', 'sara', 'sara1@gmail.com', '$2y$10$OYXMxixYJHiGB/wNF5snBu/EDOn9x6j3dIhlZHa/AtW5fcZDp.Gji', 'admin', '2024-12-11 09:44:02', '2024-12-11 09:44:02', 'active'),
(7, 'Elijah', 'B', 'AJ', 'aj@gmail.com', '$2y$10$G1H809UlZsnOy1deLMxISO0/2HUBH5aNyKxkDyRDeaGM1Gsy9RGcu', 'user', '2024-12-11 10:04:46', '2024-12-11 10:04:46', 'active'),
(8, 'Josephine', 'Sang', 'Josy', 'josys@gmail.com', '$2y$10$iHL/atZzZ65fw7xK8H.4bOyGpccAKh/GQ2IgoNQMqk3Dbo8c.m2Ge', 'user', '2024-12-11 10:33:47', '2024-12-11 10:33:47', 'active'),
(9, 'STELLA', 'M', 'atara', 'atara@gmail.com', '$2y$10$lOvcOjSaU3ZRygp6cFLci.HcZt2Gf4tJMMwF5etmTVDEBU88RAnIW', 'admin', '2025-01-24 12:52:19', '2025-01-24 12:52:19', 'active'),
(10, 'SAMRA', 'N', 'nosh', 'nosh@gmail.com', '$2y$10$9YPxEfhx29sf/2.PjQYli.xon4gP4qC6UVlF1VbXbgO7dtfITR71e', 'user', '2025-01-24 12:53:37', '2025-01-24 12:53:37', 'active'),
(11, 'Brian', 'Kibet', 'bkibet', 'kibet@gmail.com', '$2y$10$121LG0M6mmblVGof4PZdOOwQzhExk6YqzT885dAy0O1uF8VdrhHIm', 'user', '2025-01-27 08:49:12', '2025-01-27 08:49:12', 'active'),
(12, 'martin', 'J', 'mato', 'mato@gmail.com', '$2y$10$H0n.3W.hhIqdXkO4ghbk9uwBwWgIlT5Z78C9tyB6d6RvO5STQW.4S', 'user', '2025-01-29 11:13:34', '2025-01-29 11:13:34', 'active'),
(13, 'MaryAnne', 'Njeri', 'Miriam', 'miriam@gmail.com', '$2y$10$luXWnUUCTeg9tr7FY7/gMeeS0Vfmpzr5GPPTpDqo03MOPpKhQ6yO.', 'user', '2025-01-29 12:22:55', '2025-01-29 12:22:55', 'active'),
(14, 'MANDELA', 'M', 'Cardinal', 'cardinal@gmail.com', '$2y$10$UfYg0qPBI0ij.qyh.p.MIu7RTQ/IqdEkcj5cTpz1uAJwiAFtiTdKy', 'user', '2025-01-30 07:22:07', '2025-01-30 07:22:07', 'active'),
(15, 'SALLY', 'M', 'sally', 'sally3@gmail.com', '$2y$10$/4.gy9TWQh0.tKEprLWY4.2BTsxFVFwPV93FhGyiBkhrQwQwetBiS', 'user', '2025-01-30 12:30:00', '2025-01-30 12:30:00', 'active'),
(16, 'ADRIAN', 'K', 'adrian', 'adrian@gmail.com', '$2y$10$8kslD7IqhnSgpLiRtuSLZuXQkyKs5si97WFR0uRoYCqkIW8CrcSsu', 'user', '2025-01-30 12:51:57', '2025-01-30 12:51:57', 'active'),
(17, 'Mary', 'Pepela', 'peps', 'pepela@gmail.com', '$2y$10$oXiJ34jZpFfSh/OWo5OSc.8OSpTJs.nS76gLXjkp7CRueSflWPG0q', 'user', '2025-01-30 13:03:23', '2025-01-30 13:03:23', 'active'),
(18, 'Samira', 'Ali', 'sam', 'samira@gmail.com', '$2y$10$WPK0KW57GSv.T/ZAV1/Myu4oMMHXEvt4sDNrezW6/Z7HJjMf1d7dy', 'user', '2025-01-30 16:18:39', '2025-01-30 16:18:39', 'active'),
(19, 'Brigid', 'Otieno', 'Bree', 'bree@gmail.com', '$2y$10$AdiTCdyqSIjQPKAhtPeTuuvVVrKMeMYHFhW26xEB6y./s.PKBBfLW', 'user', '2025-01-30 16:30:03', '2025-01-30 16:30:03', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `RID` (`RID`),
  ADD KEY `car_model` (`car_model`);

--
-- Indexes for table `cars_deals`
--
ALTER TABLE `cars_deals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `car_model` (`car_model`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `details`
--
ALTER TABLE `details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `full_texts`
--
ALTER TABLE `full_texts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rental_spots`
--
ALTER TABLE `rental_spots`
  ADD PRIMARY KEY (`RID`),
  ADD UNIQUE KEY `location_name` (`location_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UID`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cars_deals`
--
ALTER TABLE `cars_deals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `details`
--
ALTER TABLE `details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `full_texts`
--
ALTER TABLE `full_texts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rental_spots`
--
ALTER TABLE `rental_spots`
  MODIFY `RID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`RID`) REFERENCES `rental_spots` (`RID`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`car_model`) REFERENCES `cars_deals` (`car_model`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
