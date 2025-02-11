-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2025 at 05:57 PM
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
-- Database: `treetech`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `Firstname` varchar(35) NOT NULL,
  `Lastname` varchar(35) NOT NULL,
  `Password` varchar(350) NOT NULL,
  `ConfirmPassword` varchar(350) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Phone_Nb` int(11) NOT NULL,
  `role` varchar(35) NOT NULL,
  `status` enum('Active','Blocked') DEFAULT 'Active',
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `color` varchar(30) DEFAULT 'black'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `Firstname`, `Lastname`, `Password`, `ConfirmPassword`, `Email`, `Phone_Nb`, `role`, `status`, `latitude`, `longitude`, `color`) VALUES
(9, 'Tree', 'Tech', '1935fe3b74f70b064403d9fd284a37bd5137b358f27528a8111d3fd13827e82f', '1935fe3b74f70b064403d9fd284a37bd5137b358f27528a8111d3fd13827e82f', 'TreeTech@gmail.com', 71184211, 'admin', 'Active', 33.87555840, 35.51068160, 'black'),
(10, 'Mohammad', 'Diab', '1935fe3b74f70b064403d9fd284a37bd5137b358f27528a8111d3fd13827e82f', '1935fe3b74f70b064403d9fd284a37bd5137b358f27528a8111d3fd13827e82f', 'moudi@gmail.com', 71184211, 'user', 'Active', 33.87555840, 35.51068160, 'white'),
(11, 'Jad', 'Mcheik', '1935fe3b74f70b064403d9fd284a37bd5137b358f27528a8111d3fd13827e82f', '1935fe3b74f70b064403d9fd284a37bd5137b358f27528a8111d3fd13827e82f', 'jad@gmail.com', 81953723, 'user', 'Active', 33.84636770, 36.03324710, 'yellow'),
(12, 'Bassel', 'Abou Hjeily', '1935fe3b74f70b064403d9fd284a37bd5137b358f27528a8111d3fd13827e82f', '1935fe3b74f70b064403d9fd284a37bd5137b358f27528a8111d3fd13827e82f', 'bassel@gmail.com', 71493637, 'user', 'Active', 33.91488000, 35.57621760, 'black'),
(13, 'Mohammad', 'Saleh', '1935fe3b74f70b064403d9fd284a37bd5137b358f27528a8111d3fd13827e82f', '1935fe3b74f70b064403d9fd284a37bd5137b358f27528a8111d3fd13827e82f', 'saleh@gmail.com', 3079306, 'user', 'Active', 33.84636490, 36.03324110, 'green'),
(14, 'Hussein', 'Dika', '1935fe3b74f70b064403d9fd284a37bd5137b358f27528a8111d3fd13827e82f', '1935fe3b74f70b064403d9fd284a37bd5137b358f27528a8111d3fd13827e82f', 'hussein@gmail.com', 71104464, 'user', 'Active', 33.87555840, 35.51068160, 'red');

-- --------------------------------------------------------

--
-- Table structure for table `cart_owner`
--

CREATE TABLE `cart_owner` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_owner`
--

INSERT INTO `cart_owner` (`id`, `user_id`, `created_at`, `updated_at`) VALUES
(8, 9, '2025-02-06 18:21:53', '2025-02-06 18:21:53'),
(9, 10, '2025-02-06 20:21:42', '2025-02-06 20:21:42');

-- --------------------------------------------------------

--
-- Table structure for table `cart_products`
--

CREATE TABLE `cart_products` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `status` varchar(30) DEFAULT NULL,
  `date_order` datetime DEFAULT NULL,
  `date_history` datetime DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `discount` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_products`
--

INSERT INTO `cart_products` (`id`, `cart_id`, `product_id`, `quantity`, `status`, `date_order`, `date_history`, `price`, `discount`) VALUES
(159, 8, 93, 1, 'history', '2025-02-06 22:21:47', '2025-02-08 22:34:16', 10, 0),
(160, 9, 93, 5, 'order', '2025-02-06 22:22:07', NULL, 10, 0),
(161, 9, 88, 1, 'order', '2025-02-06 22:22:07', NULL, 600, 0),
(162, 9, 91, 5, 'order', '2025-02-06 22:22:20', NULL, 700, 0),
(163, 9, 93, 5, 'order', '2025-02-06 22:25:21', NULL, 9, 10),
(164, 9, 99, 5, 'order', '2025-02-06 22:25:21', NULL, 100, 0),
(165, 9, 96, 1, 'history', '2025-02-07 14:13:20', '2025-02-08 22:33:58', 50, 0),
(166, 9, 116, 1, 'history', '2025-02-08 20:59:57', '2025-02-08 22:33:56', 1440, 10),
(167, 9, 94, 1, 'history', '2025-02-08 21:59:54', '2025-02-08 22:33:54', 1500, 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `Id` int(11) NOT NULL,
  `Name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`Id`, `Name`) VALUES
(1, 'accessories'),
(3, 'laptop'),
(2, 'phone');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `name_picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`name_picture`) VALUES
('ppic_1739119065.jpg'),
('ppic_1739119083.webp'),
('ppic_1739119087.jpg'),
('ppic_1739119090.jpg'),
('ppic_1739119094.jpg'),
('ppic_1739119129.jpg'),
('ppic_1739119173.jpg'),
('ppic_1739119180.jpg'),
('ppic_1739119423.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `Item_ID` int(11) NOT NULL,
  `Name` varchar(32) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Price` int(11) NOT NULL,
  `discount_percentage` int(3) NOT NULL DEFAULT 0,
  `Price_after_discount` decimal(32,0) GENERATED ALWAYS AS (`Price` - `Price` * `discount_percentage` / 100) STORED,
  `discount_end_date` date NOT NULL DEFAULT current_timestamp(),
  `Add_Date` date NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Picture` varchar(255) NOT NULL,
  `Cat_ID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `role` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`Item_ID`, `Name`, `Description`, `Price`, `discount_percentage`, `discount_end_date`, `Add_Date`, `Status`, `Picture`, `Cat_ID`, `quantity`, `role`) VALUES
(88, 'Dell Core i7', '8 Ram 256 GB ', 130, 0, '2025-02-03', '2025-01-30', 'used', '8331_dell1.jpg', 3, 84, 1),
(91, 'Dell', 'Dell core i7 9th 12 Cpu', 400, 0, '2025-02-01', '2025-01-30', 'used', '4103_dell2.jpg', 3, 84, 1),
(93, 'Mouse', 'wired 2.4G', 10, 10, '2025-02-13', '2025-01-30', 'new', 'mouse1.jpg', 1, 84, 0),
(94, 'iphone 16', 'iphone 16 512gb', 1500, 0, '2025-02-26', '2025-01-30', 'new', '9680_iphone 14 prow max.jpeg', 2, 84, 1),
(95, 'sumsung s25 Ultra', '2 sim 512gb', 1300, 0, '2025-02-07', '2025-01-30', 'new', 'DSC_0020.JPG', 2, 80, 0),
(96, 'Remote Control Car', 'big battey', 50, 0, '2025-02-02', '2025-01-30', 'new', 'accessories2.jpg', 1, 84, 1),
(99, 'Led Light', 'Selfi Ring Led Light', 10, 0, '2025-01-29', '2025-01-30', 'used', 'accessories1.jpg', 1, 84, 1),
(102, 'iphone 17', 'fdsafafsd', 2000, 0, '2025-02-02', '2025-02-01', 'new', '9680_iphone 14 prow max.jpeg', 2, 100, 0),
(103, 'iphone 18', 'ghjglk', 3000, 0, '2025-02-01', '2025-02-01', 'new', '9680_iphone 14 prow max.jpeg', 2, 80, 0),
(107, 'Lenovo ThinkPad T495s', '16 Ram 512GB ', 260, 0, '2025-02-07', '2025-02-07', 'used', 'lenovo-laptop-thinkpad-t480-feature-02_02.webp', 3, 99, 1),
(108, 'HP EliteBook 845 G7', '16 Ram 256 GB', 330, 0, '2025-02-07', '2025-02-07', 'used', 'HP_EliteBook_845_G7_176Y4EA_image_1.webp', 3, 50, 1),
(109, 'MacBook Pro Retina', 'Touch 16 Ram 512 GB', 600, 10, '2025-02-19', '2025-02-07', 'used', '81r1Ir8LtbL._AC_SL1500.webp', 3, 30, 1),
(110, 'MacBook Air 15\" M3', '8 Ram 256 GB', 999, 20, '2025-02-19', '2025-02-07', 'new', 'Apple-MacBook-Air-M3-15-inch-Starlight-1_3884161b-ffad-49f4-971b-f9d625346363.webp', 3, 20, 1),
(111, 'Dell Latitude 5300', '32 Ram 512 GB', 400, 0, '2025-02-07', '2025-02-07', 'used', 'Dell_Latitude_5300_6.webp', 3, 100, 1),
(112, 'MacBook Pro 2020 M1', '16 Ram 512 SSD', 850, 0, '2025-02-07', '2025-02-07', 'new', '71Y6pcuRhmL._AC_UF894_1000_QL80.webp', 3, 53, 1),
(113, 'Lenovo ThinkPad T14s', '16 Ram 256 GB', 350, 0, '2025-02-07', '2025-02-07', 'used', 'Untitleddesign_11_e1369391-5bdd-4ad8-b22f-c4f5105511a8_1024x1024_png.webp', 3, 98, 1),
(114, 'infinix smart 8', '6 Ram 128 Gb', 100, 20, '2025-02-20', '2025-02-08', 'new', 'infinix smart 8.jpg', 2, 60, 1),
(115, 'S22', '8 Ram 128 Gb', 400, 10, '2025-02-28', '2025-02-08', 'used', '71qZERyxy6L._AC_UF1000,1000_QL80_.jpg', 2, 30, 1),
(116, 'iphone 16', '1 TB', 1600, 10, '2025-02-19', '2025-02-08', 'new', 'images.jpg', 1, 84, 0),
(118, 'iphone 15', '256 GB', 999, 0, '2025-02-08', '2025-02-08', 'used', 'images (1).jpg', 2, 30, 1),
(119, 'huawei pura 70 ultra', '16 Ram 512 GB', 1440, 0, '2025-02-08', '2025-02-08', 'new', 'download (1).jpg', 2, 53, 1),
(120, 'sumsung s23 Ultra', '8 Ram 256 GB', 800, 0, '2025-02-08', '2025-02-08', 'used', 'images (2).jpg', 2, 100, 1),
(121, 'itel A50', '6 Ram 128 GB', 100, 0, '2025-02-08', '2025-02-08', 'new', 'itel A50.jpg', 2, 80, 1),
(122, 'infinix Hot 50i', '8 Ram 128 GB', 150, 0, '2025-02-08', '2025-02-08', 'new', 'infinix Hot 50i.jpg', 2, 80, 1),
(123, 'keyboard', 'keyboard , Mouse, Headphone', 25, 0, '2025-02-08', '2025-02-08', 'new', 'keyboard.jpg', 1, 100, 1),
(124, 'Mouse ', 'Mouse Hp Wireless 2.4G', 5, 0, '2025-02-08', '2025-02-08', 'new', 'Mouse HP.jpg', 1, 90, 1),
(125, 'Controller Gamepad', 'Digital Game Player ', 20, 10, '2025-02-21', '2025-02-08', 'new', 'digital game player.jpg', 1, 150, 1),
(126, 'Router', 'netis 300 Mbps', 14, 0, '2025-02-08', '2025-02-08', 'new', 'router netis.jpg', 1, 150, 1),
(127, 'Controller Gamepad', '2.4G wireless', 15, 0, '2025-02-08', '2025-02-08', 'new', '2.4G controller gamepad.jpg', 1, 80, 1),
(128, 'Power Bank ', '60000 mAh with Light', 40, 10, '2025-02-26', '2025-02-08', 'new', 'Light.jpg', 1, 50, 1),
(129, 'ChromeCast', 'Tv streaming device by google', 7, 0, '2025-02-08', '2025-02-08', 'used', 'chrome cast.jpg', 1, 50, 1),
(130, 'Camera', 'Wifi Smart Net Camera', 13, 20, '2025-02-20', '2025-02-08', 'new', 'camera.jpg', 1, 70, 1),
(131, 'Usb  Adapter', 'USB Adapter Wireless', 2, 0, '2025-02-20', '2025-02-08', 'new', 'usb adapter wireless.jpg', 1, 200, 1),
(132, 'HeadPhone', 'wired Gaming with RGB Led', 10, 0, '2025-02-08', '2025-02-08', 'new', 'HeadPhone Tranyoo.jpg', 1, 60, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Gmail` (`Email`);

--
-- Indexes for table `cart_owner`
--
ALTER TABLE `cart_owner`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `cart_products`
--
ALTER TABLE `cart_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`name_picture`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`Item_ID`),
  ADD KEY `Cat_ID` (`Cat_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `cart_owner`
--
ALTER TABLE `cart_owner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cart_products`
--
ALTER TABLE `cart_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `Item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_owner`
--
ALTER TABLE `cart_owner`
  ADD CONSTRAINT `cart_owner_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `account` (`id`);

--
-- Constraints for table `cart_products`
--
ALTER TABLE `cart_products`
  ADD CONSTRAINT `cart` FOREIGN KEY (`cart_id`) REFERENCES `cart_owner` (`id`),
  ADD CONSTRAINT `cart_products_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `items` (`Item_ID`);

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `itm` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
