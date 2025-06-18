-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2025 at 06:32 PM
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
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `product_id` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `price` decimal(15,0) DEFAULT 0,
  `quantity` int(11) DEFAULT 0,
  `sold_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `product_id`, `name`, `category`, `price`, `quantity`, `sold_count`) VALUES
(1, 'BP001', 'Balo đen', 'Balo', 300000, 5, 0),
(2, 'BP002', 'Balo xám', 'Balo', 290000, 5, 0),
(3, 'BP003', 'Balo xanh trắng', 'Balo', 280000, 5, 0),
(4, 'HA001', 'Khăn bandana', 'Phụ kiện tóc', 70000, 10, 0),
(5, 'HA002', 'Khăn bandana hoa cúc', 'Phụ kiện tóc', 70000, 10, 0),
(6, 'HA003', 'Khăn bandana hoa hướng dương', 'Phụ kiện tóc', 70000, 15, 0),
(7, 'HA004', 'Khăn bandana hoa lan', 'Phụ kiện tóc', 70000, 10, 0),
(10, 'HA005', 'Khăn bandana hoa tím vàng', 'Phụ kiện tóc', 60000, 10, 0),
(11, 'O001', 'Combo khăn bandana + kẹp tóc', 'Khác', 150000, 5, 0),
(12, 'HA006', 'Băng đô', 'Phụ kiện tóc', 60000, 20, 0),
(13, 'HA007', 'Băng đô', 'Phụ kiện tóc', 50000, 10, 0),
(14, 'O002', 'Bánh kem mini', 'Khác', 80000, 5, 0),
(17, 'O003', 'Bánh kem mini', 'Khác', 80000, 10, 0),
(18, 'O004', 'Bánh quy', 'Khác', 70000, 5, 0),
(20, 'HA008', 'Cài tóc hoa cúc', 'Phụ kiện tóc', 50000, 15, 0),
(21, 'O005', 'Bọc sổ tay màu hồng', 'Khác', 165000, 20, 0),
(22, 'O006', 'Bọc sổ tay màu đỏ', 'Khác', 170000, 15, 0),
(23, 'O007', 'Bọc sổ tay hoa hồng nhỏ', 'Khác', 170000, 15, 0),
(24, 'O008', 'Bọc sổ tay', 'Khác', 150000, 12, 0),
(25, 'O009', 'Bọc sổ tay basic', 'Khác', 175000, 15, 0),
(26, 'O010', 'Bọc sổ tay hoa', 'Khác', 190000, 15, 0),
(27, 'O011', 'Bọc sổ tay lá thư', 'Khác', 145000, 14, 0),
(28, 'O012', 'Bọc sổ tay Tulip', 'Khác', 195000, 8, 0),
(29, 'O013', 'Bọc sổ tay caro', 'Khác', 175000, 16, 0),
(30, 'O014', 'Bọc sổ tay hoa', 'Khác', 140000, 16, 0),
(31, 'O015', 'Bọc sổ tay caro nâu', 'Khác', 180000, 12, 0),
(32, 'O016', 'Bọc sổ tay dâu tây', 'Khác', 170000, 10, 0),
(34, 'O017', 'Bó hoa', 'Khác', 178000, 11, 0),
(39, 'KC001', 'Móc khóa bó hoa mini', 'Móc khóa', 48000, 20, 0),
(40, 'O018', 'Bó hoa Lily', 'Khác', 108000, 15, 0),
(41, 'KC002', 'Móc khóa bó hoa', 'Móc khóa', 58000, 12, 0),
(42, 'O019', 'Bó hoa Tulip doll', 'Khác', 208000, 8, 0),
(43, 'O020', 'Bó hoa mini', 'Khác', 15000, 18, 0),
(44, 'O021', 'Bó hoa mini', 'Khác', 58000, 16, 0),
(45, 'O022', 'Miếng lót kính', 'Khác', 50000, 15, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
