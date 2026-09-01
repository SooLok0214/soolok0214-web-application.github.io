-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2026-08-18 06:43:01
-- 服务器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `myshop`
--

-- --------------------------------------------------------

--
-- 表的结构 `customers`
--

CREATE TABLE `customers` (
  `Name` varchar(255) NOT NULL,
  `CusID` varchar(32) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` int(25) NOT NULL,
  `JoinYear` int(4) NOT NULL,
  `Phone` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `customers`
--

INSERT INTO `customers` (`Name`, `CusID`, `Email`, `Password`, `JoinYear`, `Phone`) VALUES
('Aiman Tan', '1001', 'aiman.tan@example.com', 123123, 2026, 33),
('Mei Lin Wong', '1002', 'meilin.wong@example.com', 234567, 123, 601345678),
('Daniel Lee', '1003', 'daniel.lee@example.com', 345678, 231, 601456789),
('Siti Nur', '1004', 'siti.nur@example.com', 456789, 1231, 601567890),
('123123', '1005', '123@gmail.com', 123123, 1900, 123123123),
('Wa Sha Bi', '1009', 'WaShaBi@gmail.com', 0, 332, 198767895);

-- --------------------------------------------------------

--
-- 表的结构 `orders`
--

CREATE TABLE `orders` (
  `OrderID` varchar(32) NOT NULL,
  `CusID` varchar(32) NOT NULL,
  `CustomerName` varchar(255) NOT NULL,
  `ProductID` varchar(32) NOT NULL,
  `ProductName` varchar(255) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `UnitPrice` decimal(10,2) NOT NULL,
  `TotalPrice` decimal(10,2) NOT NULL,
  `OrderDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `orders`
--

INSERT INTO `orders` (`OrderID`, `CusID`, `CustomerName`, `ProductID`, `ProductName`, `Quantity`, `UnitPrice`, `TotalPrice`, `OrderDate`) VALUES
('20260818123310_FVXLLT', '1002', 'Mei Lin Wong', '2008', 'The Product3', 6, 29.00, 174.00, '2026-08-18 04:33:10'),
('20260818123324_AG2SE5', '1009', 'Wa Sha Bi', '2008', 'The Product3', 2, 29.00, 58.00, '2026-08-18 04:33:24'),
('20260818123324_GS4M25', '1009', 'Wa Sha Bi', '20260818123113_C6PXPV', 'The Product9', 5, 12.00, 60.00, '2026-08-18 04:33:24'),
('20260818123324_SKPLO8', '1009', 'Wa Sha Bi', '2003', 'Wireless Mouse', 3, 59.00, 177.00, '2026-08-18 04:33:24'),
('5', '1009', 'Wa Sha Bi', '2009', 'The Product10', 1, 40.00, 40.00, '2026-08-13 09:21:31'),
('6', '1001', 'Aiman Tan', '2009', 'The Product10', 5, 40.00, 200.00, '2026-08-13 09:21:31'),
('8', '1001', 'Aiman Tan', '2009', 'The Product10', 5, 40.00, 200.00, '2026-08-13 09:21:31');

-- --------------------------------------------------------

--
-- 表的结构 `products`
--

CREATE TABLE `products` (
  `ProductName` varchar(255) NOT NULL,
  `ProductID` varchar(32) NOT NULL,
  `Price` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `products`
--

INSERT INTO `products` (`ProductName`, `ProductID`, `Price`) VALUES
('Wireless Mouse', '2003', 59),
('Stainless Bottle', '2004', 42),
('The Product9', '2007', 213),
('The Product3', '2008', 29),
('The Product10', '2009', 40),
('The Product9', '20260818123113_C6PXPV', 12);

--
-- 转储表的索引
--

--
-- 表的索引 `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`CusID`);

--
-- 表的索引 `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`);

--
-- 表的索引 `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ProductID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
