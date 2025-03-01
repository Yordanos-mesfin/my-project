-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2025 at 09:41 PM
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
-- Database: `e_commerce_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`) VALUES
(5, 3, 2, 1),
(59, 2, 1, 2),
(60, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `created_at`) VALUES
(5, 'bags', '2025-02-09 09:49:51'),
(6, 'cloth', '2025-02-09 09:50:10'),
(7, 'cosmotics', '2025-02-09 09:50:34'),
(8, 'home accessory', '2025-02-09 09:50:52'),
(9, 'shoes', '2025-02-09 09:51:24');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'metages Legesse', 'metebenu2@gmail.com', 'better then ...', '2025-02-05 12:31:50'),
(2, 'yorina', 'yorina@gmail.com', 'thank you!\r\n', '2025-02-05 12:51:46'),
(3, 'yorina', 'yori@gmail.com', 'nice service', '2025-02-09 20:07:17');

-- --------------------------------------------------------

--
-- Table structure for table `order_history`
--

CREATE TABLE `order_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','completed','canceled') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_history`
--

INSERT INTO `order_history` (`id`, `user_id`, `order_date`, `total_amount`, `status`) VALUES
(1, 2, '2025-02-05 02:47:02', 355.22, 'completed'),
(2, 2, '2025-02-05 02:48:10', 0.00, 'completed'),
(3, 2, '2025-02-05 02:48:35', 0.00, 'completed'),
(4, 2, '2025-02-05 02:49:01', 0.00, 'completed'),
(5, 2, '2025-02-05 02:49:13', 0.00, 'completed'),
(6, 2, '2025-02-05 02:49:37', 0.00, 'completed'),
(7, 2, '2025-02-05 05:01:18', 62.43, 'completed'),
(8, 2, '2025-02-05 05:48:25', 50.11, 'completed'),
(9, 2, '2025-02-05 06:27:18', 321.77, 'completed'),
(10, 2, '2025-02-08 03:02:05', 251.05, 'completed'),
(11, 2, '2025-02-08 03:16:35', 74.97, 'completed'),
(12, 2, '2025-02-08 04:09:55', 75.10, 'completed'),
(13, 2, '2025-02-08 07:42:44', 75.10, 'completed'),
(14, 2, '2025-02-08 07:50:13', 140.34, 'completed'),
(15, 2, '2025-02-08 07:55:23', 100.22, 'completed'),
(16, 2, '2025-02-08 07:58:33', 50.11, 'completed'),
(17, 2, '2025-02-08 13:07:10', 803.31, 'completed'),
(18, 2, '2025-02-08 13:42:11', 75.10, 'completed'),
(19, 8, '2025-02-09 09:18:34', 49.98, 'completed'),
(20, 8, '2025-02-09 09:28:02', 315.79, 'completed'),
(21, 10, '2025-02-09 12:05:20', 750.00, 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `stock_quantity` int(11) DEFAULT 0,
  `is_active` tinyint(4) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `category_id`, `stock_quantity`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'SHOES', 'good product', 43.11, 'images/shoes11.jpg', 9, 10, 1, '2025-02-04 22:04:01', '2025-02-09 12:31:29'),
(2, 'SHOES', 'good shose', 24.99, 'images/shoes12.jpg', 9, 20, 1, '2025-02-04 22:16:56', '2025-02-09 12:33:31'),
(3, 'SHOES', 'nice shose', 65.24, 'images/shoes13.jpg', 9, 15, 1, '2025-02-04 22:16:56', '2025-02-09 12:35:30'),
(4, 'SHOES', 'nice shoes', 52.33, 'images/shoes14.jpg', 9, 5, 1, '2025-02-05 03:31:29', '2025-02-09 12:36:50'),
(5, 'SHOSE', 'nice shose', 85.85, 'images/shoes15.jpg', 9, 7, 1, '2025-02-05 03:34:30', '2025-02-09 12:38:02'),
(9, 'SHOES', 'nice shoes', 698.65, 'images/shoes16.jpg', 9, 6, 1, '2025-02-08 13:03:40', '2025-02-09 12:39:32'),
(10, 'shoes1', 'this is new brand shoes', 20.35, 'images/shoes1.jpg', 9, 7, 1, '2025-02-09 09:56:46', '2025-02-09 10:01:13'),
(11, 'shoes2', 'this is new brand', 24.56, 'images/shoes2.jpg', 9, 4, 1, '2025-02-09 09:57:36', '2025-02-09 10:01:29'),
(12, 'shoes3', 'this is new brand', 25.45, 'images/shoes3.jpg', 9, 14, 1, '2025-02-09 09:58:42', '2025-02-09 10:02:26'),
(13, 'BAG', 'best quality', 5.09, 'images/bag1.jpg', 5, 15, 1, '2025-02-09 10:42:54', '2025-02-09 10:42:54'),
(14, 'BAG', 'this is new brand', 24.56, 'images/bag2.jpg', 5, 4, 1, '2025-02-09 10:44:24', '2025-02-09 10:44:24'),
(15, 'BAG', 'brand new', 10.50, 'images/bag3.jpg', 5, 5, 1, '2025-02-09 10:46:37', '2025-02-09 10:46:37'),
(16, 'BAG', 'best sell', 52.12, 'images/bag4.jpg', 5, 6, 1, '2025-02-09 10:47:32', '2025-02-09 10:47:32'),
(17, 'BAG', 'best sell', 24.50, 'images/bag5.jpg', 5, 8, 1, '2025-02-09 10:48:09', '2025-02-09 10:48:09'),
(18, 'BAG', 'best quality', 12.60, 'images/bag6.jpg', 5, 3, 1, '2025-02-09 10:49:01', '2025-02-09 10:49:01'),
(19, 'BAG', 'best quality', 12.09, 'images/bag7.jpg', 5, 2, 1, '2025-02-09 10:50:11', '2025-02-09 10:50:11'),
(20, 'BAG', 'best quality', 11.11, 'images/bag8.jpg', 5, 5, 1, '2025-02-09 10:50:51', '2025-02-09 10:50:51'),
(21, 'BAG', 'best sell', 10.00, 'images/bag9.jpg', 5, 6, 1, '2025-02-09 10:51:31', '2025-02-09 10:51:31'),
(22, 'BAG', 'best sell', 10.00, 'images/bag9.jpg', 5, 6, 1, '2025-02-09 10:52:38', '2025-02-09 10:52:38'),
(23, 'CLOTH', 'Brand new', 100.00, 'images/cloth1.jpg', 6, 30, 1, '2025-02-09 10:54:01', '2025-02-09 10:54:01'),
(24, 'CLOTH', 'brand new', 39.00, 'images/cloth2.jpg', 6, 8, 1, '2025-02-09 10:55:14', '2025-02-09 10:55:14'),
(25, 'CLOTH', 'brand new', 24.56, 'images/cloth3.jpg', 6, 7, 1, '2025-02-09 10:56:03', '2025-02-09 10:56:03'),
(26, 'CLOTH', 'brand new', 52.33, 'images/cloth4.jpg', 6, 8, 1, '2025-02-09 10:56:36', '2025-02-09 10:56:36'),
(27, 'CLOTH', 'brand new', 85.85, 'images/cloth5.jpg', 6, 3, 1, '2025-02-09 10:57:22', '2025-02-09 10:57:22'),
(28, 'CLOTH', 'brand new', 85.77, 'images/cloth6.jpg', 6, 10, 1, '2025-02-09 10:58:04', '2025-02-09 10:58:04'),
(29, 'CLOTH', 'best quality', 200.00, 'images/cloth7.jpg', 6, 1, 1, '2025-02-09 10:58:39', '2025-02-09 10:58:39'),
(30, 'CLOTH', 'beat sell', 655.00, 'images/cloth7.jpg', 6, 5, 1, '2025-02-09 11:00:32', '2025-02-09 11:00:32'),
(31, 'HOME ACCESSARY', 'for your sweet home', 400.00, 'images/accessary1.jpg', 8, 9, 1, '2025-02-09 11:02:40', '2025-02-09 11:02:40'),
(32, 'HOME ACCESSARY', 'for your sweet home', 300.00, 'images/accessary2.jpg', 8, 5, 1, '2025-02-09 11:03:30', '2025-02-09 11:03:30'),
(33, 'HOME ACCESSARY', 'for your sweet home', 500.00, 'images/accessary3.jpg', 8, 19, 1, '2025-02-09 11:04:10', '2025-02-09 11:04:10'),
(34, 'HOME ACCESSARY', 'for your sweet home', 230.00, 'images/accessary4.jpg', 8, 28, 1, '2025-02-09 11:05:01', '2025-02-09 11:05:01'),
(35, 'HOME ACCESSARY', 'for your sweet home', 560.00, 'images/accessary5.jpg', 8, 29, 1, '2025-02-09 11:05:39', '2025-02-09 11:05:39'),
(36, 'HOME ACCESSARY', 'foryour sweet home', 530.00, 'images/accessary6.jpg', 8, 28, 1, '2025-02-09 11:06:19', '2025-02-09 11:06:19'),
(37, 'HOME ACCESSARY', 'for your sweet home', 446.00, 'images/accessary7.jpg', 8, 6, 1, '2025-02-09 11:06:55', '2025-02-09 11:06:55'),
(38, 'HOME ACCESSARY', 'for your sweet home', 555.00, 'images/accessary8.jpg', 8, 77, 1, '2025-02-09 11:07:44', '2025-02-09 11:07:44'),
(39, 'SHOSES', 'highly comfortable', 559.00, 'images/shoes1.jpg', 9, 44, 1, '2025-02-09 11:10:27', '2025-02-09 11:45:00'),
(40, 'SHOSES', 'highly comfortable', 321.00, 'images/shoes2.jpg', 9, 67, 1, '2025-02-09 11:11:27', '2025-02-09 11:45:28'),
(41, 'SHOSES', 'highly comfortable', 564.00, 'images/shoes3.jpg', 9, 87, 1, '2025-02-09 11:12:31', '2025-02-09 11:45:41'),
(42, 'SHOSES', 'highly comfortable', 448.00, 'images/shoes4.jpg', 9, 3, 1, '2025-02-09 11:13:14', '2025-02-09 11:46:01'),
(43, 'SHOSES', 'highly comfortable', 378.00, 'images/shoes5.jpg', 9, 6, 1, '2025-02-09 11:13:57', '2025-02-09 11:56:08'),
(44, 'SHOSES', 'highly comfortable', 668.00, 'images/shoes6.jpg', 9, 9, 1, '2025-02-09 11:14:48', '2025-02-09 11:46:44'),
(45, 'SHOSES', 'highly comfortable', 100.00, 'images/shoes7.jpg', 9, 8, 1, '2025-02-09 11:15:25', '2025-02-09 11:47:11'),
(46, 'SHOSES', 'highly comfortable', 700.00, 'images/shoes8.jpg', 9, 45, 1, '2025-02-09 11:16:09', '2025-02-09 11:47:52'),
(47, 'SHOSES', 'highly comfortable', 677.00, 'images/shoes9.jpg', 9, 54, 1, '2025-02-09 11:17:02', '2025-02-09 11:42:34'),
(48, 'COSMOTICS', 'for your beauty', 1000.00, 'images/cosmotics1.jpg', 7, 67, 1, '2025-02-09 11:18:26', '2025-02-09 11:56:40'),
(49, 'COSMOTICS', 'for your beauty', 300.00, 'images/cosmotics2.jpg', 7, 22, 1, '2025-02-09 11:19:26', '2025-02-09 11:49:10'),
(50, 'COSMOTICS', 'for your beauty', 753.00, 'images/cosmotics3.jpg', 7, 89, 1, '2025-02-09 11:20:15', '2025-02-09 11:49:57'),
(51, 'COSMOTICS', 'for your beauty', 677.00, 'images/cosmotics4.jpg', 7, 98, 1, '2025-02-09 11:21:03', '2025-02-09 11:50:30'),
(52, 'COSMOTICS', 'for your beauty', 600.00, 'images/cosmotics5.jpg', 7, 90, 1, '2025-02-09 11:22:02', '2025-02-09 11:51:19'),
(53, 'COSMOTICS', 'for your beauty', 800.00, 'images/cosmotics7.jpg', 7, 2, 1, '2025-02-09 11:22:40', '2025-02-09 11:52:18'),
(54, 'COSMOTICS', 'for your beauty', 788.00, 'images/cosmotics8.jpg', 7, 4, 1, '2025-02-09 11:23:26', '2025-02-09 11:52:42'),
(55, 'COSMOTICS', 'for your beauty', 900.00, 'images/cosmotics9.jpg', 7, 20, 1, '2025-02-09 11:25:03', '2025-02-09 11:53:08');

-- --------------------------------------------------------

--
-- Table structure for table `table1`
--

CREATE TABLE `table1` (
  `id` int(100) NOT NULL,
  `page` int(20) NOT NULL,
  `Fname` varchar(100) NOT NULL,
  `last-name` varchar(50) NOT NULL,
  `file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table1`
--

INSERT INTO `table1` (`id`, `page`, `Fname`, `last-name`, `file`) VALUES
(1, 0, 'ghfhg', 'ghgfhg', ''),
(2, 0, 'htrdhfgg', 'jhgfjhg', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('admin','customer') DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `created_at`, `role`) VALUES
(1, 'yewubdar', '$2y$10$NrQVF5Ci7SKEBU.m7HG4yOmsLW5MMa2TNUvwgqx6SJacxSU2ca9zy', 'yewub@gmail.com', '2025-02-05 07:49:50', 'admin'),
(2, 'sifen', '$2y$10$6.J9vc1eOFn42AKcFJ.bvOKVnsZb9qWLHee0MFBHVJgKkDXiQlFG.', 'sifen@gmail.com', '2025-02-05 08:14:00', 'customer'),
(3, 'mete8', '$2y$10$92r9OfgcBsTUz5GH8uMljeEiWvt.nKn2Jm1/9XSSFgaRxk6cMSwoq', 'mete888@gmail.com', '2025-02-05 08:17:20', 'customer'),
(4, 'onismos', '$2y$10$fWiovTGwLau3wlehGb/M4uw6YGdsIoVdHBJ0kTXv8O2l/0Mhf54ky', 'onismos@gmail.com', '2025-02-05 08:35:04', 'admin'),
(6, 'yewb111', '$2y$10$m8gbClW6jSmC/1ijFMDXwu2LbTilCn7V2yDdpB42mOjdsjdc4yPQy', 'yewb11@gmail.com', '2025-02-05 20:50:36', 'customer'),
(8, 'yorina', '$2y$10$TmS.peQQ/mlLvZTKnk4K.OW87RiyTjsfpsrrIUD1Hq1SwCAr/R0gS', 'yorina1@gmail.com', '2025-02-09 17:13:39', 'customer'),
(9, 'yewb', '$2y$10$Iv642/Asp4fdKW.EzrDR/eVyyQMGZ/5.jc30c0OaL9i/lcaomNpFy', 'yewb1@gmail.com', '2025-02-09 17:35:25', 'customer'),
(10, 'yordanos ', '$2y$10$VmsCljxDR8jJoFL2//tXGuNI6IRqyLwTbslE6D.pA7AkSLV3mWPFC', 'yordi@gmail.com', '2025-02-09 20:03:21', 'customer'),
(14, 'yordanoss', '$2y$10$Um23oDbRjPw1pG.XcDz0FuwTWXzouUnHRazqAqR039zfUV8.3pUoq', 'yordanos@gmai.com', '2025-02-09 20:09:46', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_history`
--
ALTER TABLE `order_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table1`
--
ALTER TABLE `table1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_history`
--
ALTER TABLE `order_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `table1`
--
ALTER TABLE `table1`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `order_history`
--
ALTER TABLE `order_history`
  ADD CONSTRAINT `order_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
