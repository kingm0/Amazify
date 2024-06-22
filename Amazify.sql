-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 22, 2024 at 06:12 PM
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
-- Database: `Amazify`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `images` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `price`, `description`, `images`, `created_at`, `user`, `status`) VALUES
(94, 'Mukul singhal', 5678.00, 'sdiufhpaidhfkasd', 'uploads/nike.jpeg', '2024-06-22 14:17:08', NULL, NULL),
(95, 'adsfdfasfasdf', 2345678.00, 'asdhfoahdsiofdsf', 'uploads/check.jpeg', '2024-06-22 14:19:28', NULL, NULL),
(96, 'Mukul singhal', 234567.00, 'vuiohpj[lkpicgfvbkl;k', 'uploads/check.jpeg', '2024-06-22 14:24:22', '0', NULL),
(97, '4567890p', 34567890.00, 'cgfml,;/\r\nlpjigydtresdtfyhijo;.\'/', 'uploads/check.jpeg', '2024-06-22 15:46:40', 'singhalmukul920@gmail.com', 'Rejected'),
(98, 'Mukul singhal', 234.00, 'xfcgvbhijklpkojigvydxrzsdxcgb', 'uploads/nike.jpeg', '2024-06-22 15:51:20', 'singhalmukul920@gmail.com', 'Verified'),
(99, 'Mukul singhal', 234.00, 'xfcgvbhijklpkojigvydxrzsdxcgb', 'uploads/nike.jpeg', '2024-06-22 16:06:16', NULL, 'Verified'),
(100, 'Mukul singhal', 123.00, 'esrdtyhjiokpjigyfdtrs', 'uploads/check.jpeg', '2024-06-22 16:07:53', 'singhalmukul920@gmail.com', 'Rejected'),
(101, '1safgsfdas', 23244.00, 'asdfasfdgsaf', 'uploads/nike.jpeg', '2024-06-22 16:08:58', 'singhalmukul920@gmail.com', 'Verified');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`) VALUES
(6, 'singhalmukul1120@gmail.com', '$2y$10$oHx4a39U57WPwS4zCfGhk.k6Pyyh.w97gQnCO/u.1trzn6N38ye4u', 'Mukul Singhal'),
(7, 'singhalmukul110@gmail.com', '$2y$10$bB8B0rZwIxBK4vASW1ojO.QKXNoW5BdmDl/dI3wJK9/EEYSopWXGC', 'Mukul Singhal'),
(8, 'singhalmukul1140@gmail.com', '$2y$10$PH/BzDdbKpNh8.pOZiTs9.At5PwDPty.YQqXZbT.mVYbW3C8J3fFu', 'Mukul Singhal'),
(9, 'singhalmukul920@gmail.com', '$2y$10$uVVK535VwwyVFQmbGlJZmes3f3ZGbOZ3.w8X6TP6nFUu97VaG5N0S', 'Mukul Singhal');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
