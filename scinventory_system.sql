-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2024 at 06:41 AM
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
-- Database: `scinventory_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `activity_type` varchar(255) NOT NULL,
  `activity_description` text DEFAULT NULL,
  `activity_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Breads'),
(9, 'Ingredients');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` int(11) UNSIGNED NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `file_name`, `file_type`) VALUES
(0, 'no_image.png', 'image/jpeg'),
(2, 'no_image.png', 'image/jpeg'),
(4, 'BAKERY-STYLE-CHOCOLATE-CHIP-COOKIES-9-637x637-1.jpg', 'image/jpeg'),
(5, 'French-Croissants-SM-2363.jpg', 'image/jpeg'),
(6, 'vegan-blueberry-muffins-1-1-500x500.jpg', 'image/jpeg'),
(7, 'Coffee-Cinnamon-Rolls-Feature1-500x500.jpg', 'image/jpeg'),
(8, 'french-chocolate-eclairs-recipe.jpg', 'image/jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` varchar(50) DEFAULT NULL,
  `buy_price` decimal(25,2) DEFAULT NULL,
  `sale_price` decimal(25,2) NOT NULL,
  `categorie_id` int(11) UNSIGNED NOT NULL,
  `media_id` int(11) DEFAULT 0,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `quantity`, `buy_price`, `sale_price`, `categorie_id`, `media_id`, `date`) VALUES
(1, 'Chocolate Chip Cookies', '74', 0.50, 1.50, 1, 4, '2024-05-02 08:30:00'),
(2, 'Croissant', '34', 0.75, 2.00, 1, 5, '2024-05-02 09:15:00'),
(3, 'Blueberry Muffin', '0', 1.00, 2.50, 1, 6, '2024-05-02 10:00:00'),
(4, 'Cinnamon Roll', '120', 1.25, 3.00, 1, 7, '2024-05-02 10:45:00'),
(5, 'Chocolate Eclair', '90', 1.50, 3.50, 1, 8, '2024-05-02 11:30:00'),
(9, 'Cupcake', '2', 12.00, 4213.00, 1, 0, '2024-05-14 16:41:36'),
(10, 'Cake', '12', 12.00, 12.00, 1, 0, '2024-05-14 22:42:51'),
(11, 'Spanish Bread', '12', 10.00, 12.00, 1, 0, '2024-05-14 23:10:28'),
(12, 'Mamon', '15', 12.00, 15.00, 1, 5, '2024-05-14 23:12:22');

-- --------------------------------------------------------

--
-- Table structure for table `raw_ingredients`
--

CREATE TABLE `raw_ingredients` (
  `ingredient_id` int(11) UNSIGNED NOT NULL,
  `ingredient_name` varchar(255) NOT NULL,
  `stock_quantity` varchar(50) DEFAULT NULL,
  `unit` varchar(5) NOT NULL,
  `purchase_price` decimal(25,2) DEFAULT NULL,
  `sale_price` decimal(25,2) NOT NULL,
  `category_id` int(11) UNSIGNED NOT NULL,
  `media_id` int(11) DEFAULT 0,
  `date_added` datetime NOT NULL,
  `expiry` date DEFAULT NULL,
  `supplier` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `raw_ingredients`
--

INSERT INTO `raw_ingredients` (`ingredient_id`, `ingredient_name`, `stock_quantity`, `unit`, `purchase_price`, `sale_price`, `category_id`, `media_id`, `date_added`, `expiry`, `supplier`) VALUES
(1, 'Chocolate Chips', '109', '', 0.50, 1.50, 1, 4, '2024-05-02 08:30:00', '2024-05-14', 'Teest'),
(3, 'Blueberries', '0', '', 1.00, 2.50, 1, 6, '2024-05-02 10:00:00', NULL, ''),
(4, 'Cinnamon', '120', '', 1.25, 3.00, 1, 7, '2024-05-02 10:45:00', NULL, ''),
(5, 'Chocolate Glaze', '90', '', 1.50, 3.50, 1, 8, '2024-05-02 11:30:00', NULL, ''),
(9, 'Flour', '3', '', 3.00, 3.00, 1, 4, '2024-05-14 15:14:47', NULL, ''),
(10, 'Brown Sugar', '12', '', 12.00, 12.00, 1, 0, '2024-05-14 16:29:22', '2024-05-14', 'PhilSugar'),
(12, 'Baking Soda', '12', 'kg', 0.00, 12.00, 9, 5, '2024-05-14 23:03:09', '2024-05-14', 'None'),
(13, 'Cake Flour', '12', '', 12.00, 12.00, 9, 5, '2024-05-14 23:09:27', '2024-06-01', 'PhilSugar'),
(14, 'Salt', '15', '', 12.00, 15.00, 9, 0, '2024-05-14 23:13:33', '2024-06-08', 'PhilSugar'),
(15, 'Oil', '15', 'liter', 55.00, 0.00, 9, 0, '2024-05-15 07:06:09', '2024-05-30', 'Baguio Oil');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(25,2) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `payment_method` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `product_id`, `qty`, `price`, `date`, `payment_method`) VALUES
(1, 1, 2, 1000.00, '2021-04-04 00:00:00', ''),
(2, 3, 3, 15.00, '2021-04-04 00:00:00', ''),
(9, 2, 1, 130.00, '2024-05-01 00:00:00', ''),
(50, 2, 1, 130.00, '2024-05-02 08:33:19', ''),
(51, 2, 1, 130.00, '2024-05-02 08:33:40', ''),
(52, 2, 1, 130.00, '2024-05-02 08:33:52', ''),
(53, 5, 1, 494.00, '2024-05-02 08:44:09', ''),
(54, 3, 1, 2.00, '2024-05-02 09:29:57', ''),
(55, 1, 1, 1.00, '2024-05-02 09:31:00', ''),
(56, 1, 1, 1.00, '2024-05-02 10:19:09', ''),
(57, 3, 1, 2.00, '2024-05-02 10:22:41', ''),
(58, 2, 1, 2.00, '2024-05-02 10:22:53', ''),
(59, 3, 3, 2.00, '2024-05-02 10:23:04', ''),
(60, 3, 3, 2.00, '2024-05-02 10:25:31', ''),
(61, 1, 4, 1.00, '2024-05-06 12:32:06', ''),
(62, 1, 14, 1.00, '2024-05-08 15:30:14', ''),
(63, 2, 1, 2.00, '2024-05-08 15:32:15', ''),
(64, 3, 72, 2.00, '2024-05-08 15:32:51', ''),
(65, 1, 15, 1.00, '2024-05-09 13:51:01', ''),
(66, 1, 6, 1.00, '2024-05-09 13:51:21', ''),
(67, 1, 1, 1.50, '2024-05-15 10:04:47', 'cash'),
(68, 1, 1, 1.50, '2024-05-15 10:04:47', 'cash'),
(69, 1, 1, 1.50, '2024-05-15 10:06:05', 'cash'),
(70, 1, 1, 1.50, '2024-05-15 10:06:05', 'cash'),
(71, 2, 2, 2.00, '2024-05-15 10:06:40', 'cash'),
(72, 2, 2, 2.00, '2024-05-15 10:06:40', 'cash'),
(73, 2, 2, 2.00, '2024-05-15 10:08:21', 'online'),
(74, 2, 2, 2.00, '2024-05-15 10:08:21', 'online'),
(75, 1, 1, 1.50, '2024-05-15 10:08:41', 'cash'),
(76, 1, 1, 1.50, '2024-05-15 10:08:41', 'cash'),
(77, 2, 1, 2.00, '2024-05-15 10:10:51', 'cash'),
(78, 2, 1, 2.00, '2024-05-15 10:10:51', 'cash'),
(79, 2, 3, 2.00, '2024-05-15 10:13:52', 'cash'),
(80, 2, 3, 2.00, '2024-05-15 10:13:52', 'cash'),
(81, 2, 1, 2.00, '2024-05-15 10:14:38', 'online'),
(82, 2, 1, 2.00, '2024-05-15 10:14:38', 'online'),
(83, 1, 4, 1.50, '2024-05-15 10:16:43', 'cash'),
(84, 1, 4, 1.50, '2024-05-15 10:16:43', 'cash'),
(85, 2, 1, 2.00, '2024-05-15 10:19:58', 'cash'),
(86, 2, 1, 2.00, '2024-05-15 10:19:58', 'cash'),
(87, 2, 1, 2.00, '2024-05-15 10:20:36', 'cash'),
(88, 2, 1, 2.00, '2024-05-15 10:20:36', 'cash'),
(89, 2, 1, 2.00, '2024-05-15 10:23:06', 'cash'),
(90, 2, 1, 2.00, '2024-05-15 10:23:06', 'cash'),
(91, 2, 3, 2.00, '2024-05-15 10:23:57', ''),
(92, 2, 1, 2.00, '2024-05-15 10:25:10', 'cash'),
(93, 2, 1, 2.00, '2024-05-15 10:25:10', 'cash'),
(94, 2, 2, 2.00, '2024-05-15 10:26:55', 'cash'),
(95, 2, 2, 2.00, '2024-05-15 10:26:55', 'cash'),
(96, 2, 1, 2.00, '2024-05-15 10:27:18', 'cash'),
(97, 2, 1, 2.00, '2024-05-15 10:27:18', 'cash'),
(98, 2, 1, 2.00, '2024-05-15 10:27:34', ''),
(99, 1, 1, 1.50, '2024-05-15 10:30:17', 'cash'),
(100, 1, 1, 1.50, '2024-05-15 10:30:17', 'cash'),
(101, 2, 1, 2.00, '2024-05-15 10:31:34', ''),
(102, 2, 4, 2.00, '2024-05-15 10:31:50', ''),
(103, 2, 2, 2.00, '2024-05-15 10:31:59', ''),
(104, 1, 2, 1.00, '2024-05-15 10:32:21', ''),
(105, 2, 3, 2.00, '2024-05-15 10:33:18', 'cash'),
(106, 2, 3, 2.00, '2024-05-15 10:33:18', 'cash'),
(107, 1, 1, 1.00, '2024-05-15 10:38:01', ''),
(108, 2, 3, 2.00, '2024-05-15 10:42:45', 'cash'),
(109, 2, 3, 2.00, '2024-05-15 10:43:06', 'cash'),
(110, 1, 5, 1.00, '2024-05-15 10:43:24', 'online'),
(111, 2, 1, 2.00, '2024-05-15 10:55:41', 'online'),
(112, 1, 1, 1.00, '2024-05-15 11:47:02', 'cash'),
(113, 1, 2, 1.00, '2024-05-15 12:17:20', 'cash'),
(114, 1, 2, 1.00, '2024-05-15 12:17:26', 'cash'),
(115, 1, 6, 1.00, '2024-05-15 12:22:34', 'cash');

-- --------------------------------------------------------

--
-- Table structure for table `session_logs`
--

CREATE TABLE `session_logs` (
  `id` int(11) NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `data` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `session_logs`
--

INSERT INTO `session_logs` (`id`, `session_id`, `data`, `created_at`) VALUES
(1, 'h7nnao69koncebr56pv1a41lvu', 'Data being processed', '2024-05-14 07:38:44'),
(2, 'Admin', 'Data being processed', '2024-05-14 07:39:27'),
(3, 'Admin', 'Logged In', '2024-05-14 07:40:03'),
(4, 'Admin', 'Logged In', '2024-05-14 07:40:05'),
(5, 'Admin', 'Login', '2024-05-14 07:44:24'),
(6, 'Admin', 'Login', '2024-05-14 07:44:29'),
(7, 'Admin', 'Login', '2024-05-14 07:44:50'),
(8, 'h7nnao69koncebr56pv1a41lvu', 'Login', '2024-05-14 07:47:21'),
(9, 'Admin', 'Login', '2024-05-14 07:54:54'),
(10, 'Admin', 'Login', '2024-05-14 07:56:09'),
(11, 'Admin', 'Login', '2024-05-14 07:56:12'),
(12, 'Admin', 'Login', '2024-05-14 07:56:14'),
(13, 'Scarlett', 'Login', '2024-05-14 08:00:02'),
(14, 'Scarlett', 'Login', '2024-05-14 08:03:15'),
(15, 'Scarlett', 'Login', '2024-05-14 08:03:22'),
(16, 'Scarlett', 'Login', '2024-05-14 08:03:23'),
(17, 'Scarlett', 'Login', '2024-05-14 08:05:15'),
(18, 'Scarlett', 'Login', '2024-05-14 08:05:58'),
(19, 'Scarlett', 'Login', '2024-05-14 08:06:20'),
(20, 'Scarlett', 'Login', '2024-05-14 08:06:27'),
(21, 'Scarlett', 'Login', '2024-05-14 08:06:30'),
(22, 'Scarlett', 'Login', '2024-05-14 08:06:43'),
(23, 'Scarlett', 'Login', '2024-05-14 08:13:52'),
(24, 'Scarlett', 'Login', '2024-05-14 08:15:25'),
(25, 'Scarlett', 'Login', '2024-05-14 08:15:34'),
(26, 'Scarlett', 'Login', '2024-05-14 08:15:42'),
(27, 'Scarlett', 'Login', '2024-05-14 08:15:45'),
(28, 'Scarlett', 'Login', '2024-05-14 08:16:10'),
(29, 'Scarlett', 'Login', '2024-05-14 08:26:08'),
(30, 'Scarlett', 'Login', '2024-05-14 08:26:09'),
(31, 'Scarlett', 'Login', '2024-05-14 08:26:38'),
(32, 'Scarlett', 'Login', '2024-05-14 08:28:48'),
(33, 'Scarlett', 'Login', '2024-05-14 08:28:50'),
(34, 'Scarlett', 'Login', '2024-05-14 08:28:51'),
(35, '', 'Added an Ingredient', '2024-05-14 08:29:22'),
(36, 'Scarlett', 'Login', '2024-05-14 08:29:22'),
(37, 'Scarlett', 'Login', '2024-05-14 08:29:25'),
(38, 'Scarlett', 'Login', '2024-05-14 08:29:28'),
(39, 'Scarlett', 'Login', '2024-05-14 08:29:49'),
(40, 'Scarlett', 'Login', '2024-05-14 08:31:00'),
(41, 'Scarlett', 'Login', '2024-05-14 08:31:05'),
(42, 'Scarlett', 'Login', '2024-05-14 08:31:07'),
(43, 'Scarlett', 'Login', '2024-05-14 08:31:11'),
(44, 'Scarlett', 'Login', '2024-05-14 08:31:13'),
(45, 'Scarlett', 'Login', '2024-05-14 08:31:15'),
(46, '', 'Added an Ingredient', '2024-05-14 08:31:27'),
(47, 'Scarlett', 'Login', '2024-05-14 08:31:27'),
(48, 'Scarlett', 'Login', '2024-05-14 08:31:29'),
(49, 'Scarlett', 'Login', '2024-05-14 08:31:31'),
(50, 'Scarlett', 'Login', '2024-05-14 08:31:34'),
(51, 'special', 'Login', '2024-05-14 08:35:30'),
(52, 'admin', 'Login', '2024-05-14 08:35:51'),
(53, '', 'Added a Product', '2024-05-14 08:37:14'),
(54, '', 'Added a Product', '2024-05-14 08:37:56'),
(55, '', 'Added a Product', '2024-05-14 08:41:36'),
(56, '', 'Added a Product', '2024-05-14 14:42:51'),
(57, 'admin', 'Login', '2024-05-14 14:59:27'),
(58, '', 'Added an Ingredient', '2024-05-14 15:03:09'),
(59, 'admin', 'Login', '2024-05-14 15:08:52'),
(60, 'admin', 'Added an Ingredient', '2024-05-14 15:09:27'),
(61, '', 'Added a Product', '2024-05-14 15:10:28'),
(62, 'admin', 'Login', '2024-05-14 15:11:50'),
(63, '', 'Added a Product', '2024-05-14 15:12:22'),
(64, 'admin', 'Added an Ingredient', '2024-05-14 15:13:33'),
(65, 'admin', 'Added an Ingredient', '2024-05-14 23:06:09'),
(66, 'admin', 'Updated an Ingredient', '2024-05-15 01:03:42'),
(67, 'admin', 'Edited a Product', '2024-05-15 01:05:36'),
(68, 'admin', 'Login', '2024-05-15 03:39:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_level` int(11) NOT NULL,
  `image` varchar(255) DEFAULT 'no_image.jpg',
  `status` int(1) NOT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `user_level`, `image`, `status`, `last_login`) VALUES
(1, 'Scarlett', 'Admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 'no_image.png', 1, '2024-05-15 11:39:48'),
(2, 'John Walker', 'special', 'ba36b97a41e7faf742ab09bf88405ac04f99599a', 2, 'no_image.png', 1, '2024-05-14 16:35:30'),
(3, 'Christopher', 'user', '12dea96fec20593566ab75692c9949596833adc9', 3, 'no_image.png', 1, '2021-04-04 19:54:46'),
(4, 'Natie Williams', 'natie', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 3, 'no_image.png', 1, NULL),
(5, 'Kevin', 'kevin', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 3, 'no_image.png', 1, '2021-04-04 19:54:29'),
(6, 'Jolina', 'jol123', '24ff7f1a1ccd3e1f02a10fc496024828aaa02914', 3, 'no_image.jpg', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE `user_groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(150) NOT NULL,
  `group_level` int(11) NOT NULL,
  `group_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`id`, `group_name`, `group_level`, `group_status`) VALUES
(1, 'Admin', 1, 1),
(2, 'Owner', 2, 1),
(3, 'Cashier', 3, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `categorie_id` (`categorie_id`),
  ADD KEY `media_id` (`media_id`);

--
-- Indexes for table `raw_ingredients`
--
ALTER TABLE `raw_ingredients`
  ADD PRIMARY KEY (`ingredient_id`),
  ADD UNIQUE KEY `ingredient_name` (`ingredient_name`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `media_id` (`media_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `session_logs`
--
ALTER TABLE `session_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_level` (`user_level`);

--
-- Indexes for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `group_level` (`group_level`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `raw_ingredients`
--
ALTER TABLE `raw_ingredients`
  MODIFY `ingredient_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `session_logs`
--
ALTER TABLE `session_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `FK_products` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `raw_ingredients`
--
ALTER TABLE `raw_ingredients`
  ADD CONSTRAINT `FK_raw_ingredients` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `SK` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_user` FOREIGN KEY (`user_level`) REFERENCES `user_groups` (`group_level`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
