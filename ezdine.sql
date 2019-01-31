-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2018 at 08:22 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ezdine`
--

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `ID` int(4) NOT NULL,
  `name` varchar(70) NOT NULL,
  `email` varchar(100) NOT NULL,
  `ic` varchar(12) NOT NULL,
  `hpno` varchar(12) NOT NULL,
  `telno` varchar(10) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `race` varchar(10) NOT NULL,
  `position` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `username` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`ID`, `name`, `email`, `ic`, `hpno`, `telno`, `gender`, `race`, `position`, `address`, `username`) VALUES
(6, 'John Doe', 'ezdine@gmail.com', '990101016969', '0123456789', '073336969', 'Male', 'Chinese', 'Chef', '69, Jalan Teh Ais\r\n', 'stf0006'),
(7, 'Jane Doe', 'ezdine@gmail.com', '870605016969', '012-3456789', '0733336969', 'Female', 'Others', 'Waitress', '123, Kopi Ais, Taman Kacang', 'stf0007'),
(9, 'Bobby Ray', 'testing@gmail.com', '870605016969', '012-3456789', '07-3336666', 'Male', 'Chinese', 'Chef', 'Malaysia', 'stf0009');

-- --------------------------------------------------------

--
-- Table structure for table `emp_position`
--

CREATE TABLE `emp_position` (
  `ID` int(3) NOT NULL,
  `position` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emp_position`
--

INSERT INTO `emp_position` (`ID`, `position`) VALUES
(1, 'Chef'),
(2, 'Waiter'),
(3, 'Waitress'),
(12, 'Cleaner');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `invID` int(10) NOT NULL,
  `supplierid` int(10) NOT NULL,
  `itemname` varchar(50) NOT NULL,
  `measurement` varchar(50) NOT NULL,
  `price` double NOT NULL,
  `suppliername` varchar(50) NOT NULL,
  `quantity` double NOT NULL,
  `totalprice` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`invID`, `supplierid`, `itemname`, `measurement`, `price`, `suppliername`, `quantity`, `totalprice`) VALUES
(1, 1, 'Vanilla Milk', '250ml', 6, 'Justin Trading', 10, 60);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `foodid` int(20) NOT NULL,
  `foodname` text NOT NULL,
  `price` double(11,2) NOT NULL,
  `foodtype` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`foodid`, `foodname`, `price`, `foodtype`) VALUES
(1, 'Eggplant', 1.70, 'Food'),
(2, 'Burger', 16.99, 'Food'),
(3, 'cola', 1.50, 'Beverage'),
(4, 'chicken chop', 25.50, 'Food'),
(5, 'Seven Up', 2.00, 'Beverage'),
(6, 'Nasi Lemak', 4.50, 'Food'),
(7, 'Green Tea', 2.20, 'Beverage'),
(8, 'Fried Chicken', 3.50, 'Food'),
(9, 'Maggi Soup', 4.50, 'Food'),
(10, 'Wa Tan Ho', 6.00, 'Food'),
(11, 'Tea Ice', 2.30, 'Beverage'),
(12, 'Fried Mee', 4.60, 'Food'),
(13, 'Coffee Ice', 2.50, 'Beverage'),
(14, 'Sky Juice', 0.50, 'Beverage'),
(15, 'Ice Lemon Tea', 2.40, 'Beverage'),
(16, 'Spicy Chicken', 4.00, 'Food'),
(17, 'Meat Ball Soup', 5.00, 'Food'),
(18, 'Popcorn', 3.30, 'Food'),
(19, 'Chicken Rice', 5.00, 'Food'),
(20, 'Duck Rice', 6.00, 'Food');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderID` int(11) NOT NULL,
  `tableID` int(11) NOT NULL,
  `date` varchar(30) NOT NULL,
  `time` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payhistory`
--

CREATE TABLE `payhistory` (
  `payID` int(255) NOT NULL,
  `tableID` int(10) NOT NULL,
  `tableNum` int(10) NOT NULL,
  `date` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `total` double(50,2) NOT NULL,
  `payAmt` double(50,2) NOT NULL,
  `payChange` double(50,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payhistory`
--

INSERT INTO `payhistory` (`payID`, `tableID`, `tableNum`, `date`, `time`, `total`, `payAmt`, `payChange`) VALUES
(1, 1, 11, '2018/11/27', '08:02:24', 16.99, 17.00, 0.01),
(2, 1, 11, '2018/11/28', '15:39:41', 19.49, 20.00, 0.51),
(3, 1, 11, '2018/11/28', '15:50:00', 5.90, 6.00, 0.10),
(4, 2, 12, '2018/11/28', '16:08:36', 8.30, 10.00, 1.70),
(5, 3, 12, '2018/11/28', '16:11:59', 9.10, 10.00, 0.90),
(6, 3, 12, '2018/11/28', '16:22:54', 6.70, 8.00, 1.30),
(7, 1, 11, '2018/11/30', '02:57:42', 12.90, 15.00, 2.10),
(8, 1, 11, '2018/11/30', '03:09:25', 24.50, 25.00, 0.50),
(9, 2, 12, '2018/11/30', '03:10:35', 31.00, 31.00, 0.00),
(10, 3, 13, '2018/11/30', '03:11:09', 14.70, 20.00, 5.30),
(11, 3, 13, '2018/11/30', '03:16:59', 108.00, 120.00, 12.00),
(12, 1, 11, '2018/11/30', '03:21:07', 19.49, 20.00, 0.51);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(255) NOT NULL,
  `payID` int(255) NOT NULL,
  `foodid` int(255) NOT NULL,
  `foodname` varchar(255) NOT NULL,
  `price` double(50,2) NOT NULL,
  `quantity` int(100) NOT NULL,
  `date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `payID`, `foodid`, `foodname`, `price`, `quantity`, `date`) VALUES
(1, 1, 2, 'Burger', 16.99, 1, '2018/11/27'),
(2, 2, 2, 'Burger', 16.99, 1, '2018/11/28'),
(3, 2, 13, 'Coffee Ice', 2.50, 1, '2018/11/28'),
(4, 3, 8, 'Fried Chicken', 3.50, 1, '2018/11/28'),
(5, 3, 15, 'Ice Lemon Tea', 2.40, 1, '2018/11/28'),
(6, 4, 10, 'Wa Tan Ho', 6.00, 1, '2018/11/28'),
(7, 4, 11, 'Tea Ice', 2.30, 1, '2018/11/28'),
(8, 5, 12, 'Fried Mee', 4.60, 1, '2018/11/28'),
(9, 5, 9, 'Maggi Soup', 4.50, 1, '2018/11/28'),
(10, 6, 1, 'Eggplant', 1.70, 1, '2018/11/28'),
(11, 6, 17, 'Meat Ball Soup', 5.00, 1, '2018/11/28'),
(12, 7, 8, 'Fried Chicken', 3.50, 1, '2018/11/30'),
(13, 7, 15, 'Ice Lemon Tea', 2.40, 1, '2018/11/30'),
(14, 7, 6, 'Nasi Lemak', 4.50, 1, '2018/11/30'),
(15, 7, 14, 'Sky Juice', 2.50, 5, '2018/11/30'),
(16, 8, 12, 'Fried Mee', 4.60, 1, '2018/11/30'),
(17, 8, 8, 'Fried Chicken', 17.50, 5, '2018/11/30'),
(18, 8, 15, 'Ice Lemon Tea', 2.40, 1, '2018/11/30'),
(19, 9, 1, 'Eggplant', 6.80, 4, '2018/11/30'),
(20, 9, 7, 'Green Tea', 2.20, 1, '2018/11/30'),
(21, 9, 17, 'Meat Ball Soup', 20.00, 4, '2018/11/30'),
(22, 9, 5, 'Seven Up', 2.00, 1, '2018/11/30'),
(23, 10, 1, 'Eggplant', 1.70, 1, '2018/11/30'),
(24, 10, 14, 'Sky Juice', 1.00, 2, '2018/11/30'),
(25, 10, 10, 'Wa Tan Ho', 12.00, 2, '2018/11/30'),
(26, 11, 4, 'chicken chop', 102.00, 4, '2018/11/30'),
(27, 11, 3, 'cola', 6.00, 4, '2018/11/30'),
(28, 12, 2, 'Burger', 16.99, 1, '2018/11/30'),
(29, 12, 13, 'Coffee Ice', 2.50, 1, '2018/11/30');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `supplierid` int(10) NOT NULL,
  `itemname` varchar(50) NOT NULL,
  `measurement` varchar(20) NOT NULL,
  `price` double NOT NULL,
  `suppliername` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supplierid`, `itemname`, `measurement`, `price`, `suppliername`) VALUES
(1, 'Vanilla Milk', '250ml', 6, 'Justin Trading');

-- --------------------------------------------------------

--
-- Table structure for table `table1_order`
--

CREATE TABLE `table1_order` (
  `id` int(30) NOT NULL,
  `foodid` int(30) NOT NULL,
  `foodname` varchar(100) NOT NULL,
  `price` double(20,2) NOT NULL,
  `quantity` int(10) NOT NULL,
  `date` varchar(50) NOT NULL,
  `time` varchar(50) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `table2_order`
--

CREATE TABLE `table2_order` (
  `id` int(30) NOT NULL,
  `foodid` int(30) NOT NULL,
  `foodname` varchar(100) NOT NULL,
  `price` double(20,2) NOT NULL,
  `quantity` int(10) NOT NULL,
  `date` varchar(50) NOT NULL,
  `time` varchar(50) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `table3_order`
--

CREATE TABLE `table3_order` (
  `id` int(30) NOT NULL,
  `foodid` int(30) NOT NULL,
  `foodname` varchar(100) NOT NULL,
  `price` double(20,2) NOT NULL,
  `quantity` int(10) NOT NULL,
  `date` varchar(50) NOT NULL,
  `time` varchar(50) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tablemng`
--

CREATE TABLE `tablemng` (
  `tableID` int(5) NOT NULL,
  `tableNum` int(5) NOT NULL,
  `status` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tablemng`
--

INSERT INTO `tablemng` (`tableID`, `tableNum`, `status`) VALUES
(1, 11, 0),
(2, 12, 0),
(3, 13, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `type`) VALUES
('ezdine', '$2y$10$.1t1KVK40hklbuEa1AHcfe6kiz5fnNP7gBXxJ/ou6LMm7ZxJCNlBO', 'admin'),
('stf0006', '$2y$10$KL7qoWuXMTIwNXC86VlroOmWmUdQaFManDQ9CW2MjN9UMJPoHhvCK', 'chef'),
('stf0007', '$2y$10$SvWHryb453wl94XsnlG.Nu7HGRv/TbpeImcmfyF38S7KZ2.RCf0bi', 'employee'),
('stf0009', '$2y$10$Zvf0dkvSN9YMDsBi9ifNUeonFLLdzcJh96UeqY1jfmm.Vjdutqc82', 'chef');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `emp_position`
--
ALTER TABLE `emp_position`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`invID`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`foodid`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderID`);

--
-- Indexes for table `payhistory`
--
ALTER TABLE `payhistory`
  ADD PRIMARY KEY (`payID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplierid`);

--
-- Indexes for table `table1_order`
--
ALTER TABLE `table1_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table2_order`
--
ALTER TABLE `table2_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table3_order`
--
ALTER TABLE `table3_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tablemng`
--
ALTER TABLE `tablemng`
  ADD PRIMARY KEY (`tableID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `ID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `emp_position`
--
ALTER TABLE `emp_position`
  MODIFY `ID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `invID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `payhistory`
--
ALTER TABLE `payhistory`
  MODIFY `payID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplierid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `table1_order`
--
ALTER TABLE `table1_order`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `table2_order`
--
ALTER TABLE `table2_order`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `table3_order`
--
ALTER TABLE `table3_order`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
