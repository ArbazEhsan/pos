-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2021 at 08:20 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(22) NOT NULL,
  `name` varchar(50) NOT NULL,
  `designation` varchar(200) DEFAULT NULL,
  `salary` varchar(200) DEFAULT NULL,
  `contact` varchar(50) NOT NULL,
  `phone1` varchar(50) NOT NULL,
  `phone2` varchar(50) NOT NULL,
  `phone3` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `type` varchar(22) NOT NULL,
  `active` varchar(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `name`, `designation`, `salary`, `contact`, `phone1`, `phone2`, `phone3`, `city`, `address`, `type`, `active`) VALUES
(6, 'General Customer', NULL, NULL, '', '', '', '', 'ISLAMABAD ', '', 'Customer', '11'),
(28, 'Ghulam Murtaza', 'B.B.Q Chief ', '39000', '', '', '', '', '', '', 'Liability', '1'),
(29, 'Ali Hassan', 'Waiter', '10000', '', '', '', '', '', '', 'Liability', '1');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone1` varchar(100) NOT NULL,
  `phone2` varchar(100) NOT NULL,
  `status` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `name`, `phone1`, `phone2`, `status`) VALUES
(1, 'X GRILL', '03216353876', '03216353876', 0);

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `id` int(100) NOT NULL,
  `day` date NOT NULL,
  `product_id` varchar(100) NOT NULL,
  `qty` int(100) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `account_id` varchar(100) NOT NULL,
  `naration` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `finished`
--

CREATE TABLE `finished` (
  `id` int(100) NOT NULL,
  `day` date NOT NULL,
  `finish_good` varchar(200) NOT NULL,
  `fQty` int(100) NOT NULL,
  `consume` varchar(200) NOT NULL,
  `qty` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ledgers`
--

CREATE TABLE `ledgers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `day` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  `trans_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pcounter`
--

CREATE TABLE `pcounter` (
  `id` int(22) NOT NULL,
  `sale_day` date NOT NULL,
  `bilty_No` varchar(100) NOT NULL,
  `bill_No` varchar(100) NOT NULL,
  `bill_date` date NOT NULL,
  `customer` varchar(50) NOT NULL,
  `transport_By` varchar(50) NOT NULL,
  `type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(22) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `size` int(100) NOT NULL,
  `p_price` varchar(100) NOT NULL,
  `w_price` varchar(100) NOT NULL,
  `r_price` varchar(100) NOT NULL,
  `minQ` varchar(50) NOT NULL,
  `shQty` int(100) NOT NULL,
  `sh_status` varchar(100) NOT NULL,
  `active` int(11) NOT NULL,
  `location` varchar(100) NOT NULL,
  `reorder` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `size`, `p_price`, `w_price`, `r_price`, `minQ`, `shQty`, `sh_status`, `active`, `location`, `reorder`) VALUES
(1, 'Chicken x Grill Burger', 0, '0', '0', '300', '', 50, '0', 1, '', '0'),
(2, 'Chicken X Cheese Burger', 0, '0', '0', '350', '', 50, '0', 1, '', '0'),
(3, 'Degi chicken Palao', 0, '0', '0', '180', '', 50, '0', 1, '', '0'),
(4, 'Degi chicken Baryani ', 0, '0', '0', '180', '', 50, '0', 1, '', '0'),
(5, 'Degi chaana Palao', 0, '0', '0', '160', '', 50, '0', 1, '', '0'),
(6, 'Mutton Paaye Half', 0, '0', '0', '300', '', 50, '0', 1, '', '0'),
(7, 'Mutton Paaye Full', 0, '0', '0', '550', '', 50, '0', 1, '', '0'),
(8, 'Chicken Leg Piece', 0, '0', '0', '210', '', 50, '0', 1, '', '0'),
(9, 'Chicken Chest Piece', 0, '0', '0', '230', '', 50, '0', 1, '', '0'),
(10, 'chicken X Tikka Boti', 0, '0', '0', '340', '', 50, '0', 1, '', '0'),
(11, 'Chicken X Malai Boti', 0, '0', '0', '340', '', 50, '0', 1, '', '0'),
(12, 'Chicken X Green Boti (X Special)', 0, '0', '0', '350', '', 50, '0', 1, '', '0'),
(13, 'Chicken X Seekh Kabab', 0, '0', '0', '320', '', 50, '0', 1, '', '0'),
(14, 'Chicken X Reeshmi Kabab', 0, '0', '0', '340', '', 50, '0', 1, '', '0'),
(15, 'Chicken X Tikka Piece (Red)', 0, '0', '0', '200', '', 50, '0', 1, '', '0'),
(16, 'Chicken X Green Piece (Green)', 0, '0', '0', '220', '', 50, '0', 1, '', '0'),
(17, 'Chicken X Malai Piece (White)', 0, '0', '0', '210', '', 50, '0', 1, '', '0'),
(18, 'Chicken Boneless Boti', 0, '0', '0', '400', '', 50, '0', 1, '', '0'),
(19, 'Chicken Kalmi Tikka', 0, '0', '0', '380', '', 50, '0', 1, '', '0'),
(20, 'X Special Grill Fish', 0, '0', '0', '900', '', 50, '0', 1, '', '0'),
(21, 'Mint Raita', 0, '0', '0', '40', '', 50, '0', 1, '', '0'),
(22, 'Zeera Raita', 0, '0', '0', '0', '', 50, '0', 1, '', '0'),
(23, 'Emli Chatni (X Special Sauce)', 0, '0', '0', '50', '', 50, '0', 1, '', '0'),
(24, 'Coke', 0, '0', '0', '40', '', 50, '0', 1, '', '0'),
(25, 'Sprite', 0, '0', '0', '40', '', 50, '0', 1, '', '0'),
(26, 'Fanta', 0, '0', '0', '40', '', 50, '0', 1, '', '0'),
(27, 'Mineral Water', 0, '0', '0', '40', '', 50, '0', 1, '', '0'),
(28, 'Mint Margarita', 0, '0', '0', '100', '', 50, '0', 1, '', '0'),
(29, 'Lemonade (Lemu Pani)', 0, '0', '0', '100', '', 50, '0', 1, '', '0'),
(30, 'Roghani Naan', 0, '0', '0', '20', '', 50, '0', 1, '', '0'),
(31, 'Sada Nan (Plain)', 0, '0', '0', '15', '', 50, '0', 1, '', '0'),
(32, 'Romali Roti (Chief Special)', 0, '0', '0', '20', '', 50, '0', 1, '', '0');

-- --------------------------------------------------------

--
-- Table structure for table `psale`
--

CREATE TABLE `psale` (
  `id` int(22) NOT NULL,
  `sale_No` varchar(22) NOT NULL,
  `barcode` varchar(22) NOT NULL,
  `qty` varchar(100) NOT NULL,
  `price` varchar(100) NOT NULL,
  `grossId` varchar(100) NOT NULL,
  `discount` varchar(100) NOT NULL,
  `finalValue` varchar(100) NOT NULL,
  `received` varchar(100) NOT NULL,
  `remaining` varchar(100) NOT NULL,
  `sale_day` date NOT NULL,
  `w_price` varchar(50) NOT NULL,
  `r_price` varchar(50) NOT NULL,
  `customer` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `returnsale`
--

CREATE TABLE `returnsale` (
  `id` int(30) NOT NULL,
  `sale_No` varchar(50) NOT NULL,
  `pur_No` varchar(100) NOT NULL,
  `barcode` int(30) NOT NULL,
  `qty` int(30) NOT NULL,
  `price` varchar(30) NOT NULL,
  `total_Amnt` varchar(50) NOT NULL,
  `amnt_Paid` varchar(50) NOT NULL,
  `remaining` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rpcounter`
--

CREATE TABLE `rpcounter` (
  `id` int(50) NOT NULL,
  `pcounter_id` varchar(100) NOT NULL,
  `day` date NOT NULL,
  `customer` varchar(100) NOT NULL,
  `ref` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rscounter`
--

CREATE TABLE `rscounter` (
  `id` int(50) NOT NULL,
  `scounter_id` varchar(100) NOT NULL,
  `day` date NOT NULL,
  `customer` varchar(100) NOT NULL,
  `ref` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sale`
--

CREATE TABLE `sale` (
  `id` int(22) NOT NULL,
  `sale_No` varchar(22) NOT NULL,
  `barcode` varchar(22) NOT NULL,
  `purchase_Price` varchar(100) NOT NULL,
  `qty` varchar(22) NOT NULL,
  `price` varchar(22) NOT NULL,
  `grossId` varchar(22) NOT NULL,
  `discount` varchar(22) NOT NULL,
  `finalValue` varchar(22) NOT NULL,
  `profit` varchar(100) NOT NULL,
  `received` varchar(22) NOT NULL,
  `remaining` varchar(22) NOT NULL,
  `sale_day` date NOT NULL,
  `naration` varchar(100) NOT NULL,
  `customer` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `scounter`
--

CREATE TABLE `scounter` (
  `id` int(22) NOT NULL,
  `bilty_No` varchar(22) NOT NULL,
  `referal` varchar(200) NOT NULL,
  `customer` varchar(100) NOT NULL,
  `sale_day` date NOT NULL,
  `type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id` int(100) NOT NULL,
  `barcode` int(100) NOT NULL,
  `qty` int(100) NOT NULL,
  `day` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `subscription`
--

CREATE TABLE `subscription` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `month` date NOT NULL,
  `sub_key` varchar(200) NOT NULL,
  `status` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subscription`
--

INSERT INTO `subscription` (`id`, `user_id`, `month`, `sub_key`, `status`) VALUES
(38, 1, '2021-01-01', '670e13b825fd2e94e7f3a8c3be4b3707', 1),
(39, 1, '2021-02-01', '31f7e50d7cfc521c3ca598e1c429aac2', 1),
(40, 1, '2021-03-01', '77035cf111caaede6f686e471a6882ae', 1),
(41, 1, '2021-04-01', '166ad90f5d57f939cc4570d3677ddb5c', 1),
(42, 1, '2021-05-01', '8576c01af7116dfd744583b42be85dc2', 1),
(43, 1, '2021-06-01', '68f121202729f668b31556438658a433', 1),
(44, 1, '2021-07-01', '15ae3f102c3471aa94c7e03a75c4a99c', 1),
(45, 1, '2021-08-01', '92ed1d65658166edce4c26abcee7b56d', 1),
(46, 1, '2021-09-01', '19f6b1e0d9660a9da6656c6844739096', 1),
(47, 1, '2021-10-01', '0c698742d68e00e802df89940160962a', 1),
(48, 1, '2021-11-01', 'cdb7f2e468f5fc7a9110777f9a8faa1e', 1),
(49, 1, '2021-12-01', '2663ac798b24da395ec8a615253d0e67', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tcounter`
--

CREATE TABLE `tcounter` (
  `id` int(100) NOT NULL,
  `day` date NOT NULL,
  `voucher_no` varchar(100) NOT NULL,
  `total_amnt` varchar(100) NOT NULL,
  `type` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `trans`
--

CREATE TABLE `trans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `day` date DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `invoice_id` int(100) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `bill_no` int(11) DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `finished`
--
ALTER TABLE `finished`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ledgers`
--
ALTER TABLE `ledgers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pcounter`
--
ALTER TABLE `pcounter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `psale`
--
ALTER TABLE `psale`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `returnsale`
--
ALTER TABLE `returnsale`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rpcounter`
--
ALTER TABLE `rpcounter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rscounter`
--
ALTER TABLE `rscounter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scounter`
--
ALTER TABLE `scounter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscription`
--
ALTER TABLE `subscription`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tcounter`
--
ALTER TABLE `tcounter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trans`
--
ALTER TABLE `trans`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `finished`
--
ALTER TABLE `finished`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ledgers`
--
ALTER TABLE `ledgers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pcounter`
--
ALTER TABLE `pcounter`
  MODIFY `id` int(22) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `psale`
--
ALTER TABLE `psale`
  MODIFY `id` int(22) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `returnsale`
--
ALTER TABLE `returnsale`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rpcounter`
--
ALTER TABLE `rpcounter`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rscounter`
--
ALTER TABLE `rscounter`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale`
--
ALTER TABLE `sale`
  MODIFY `id` int(22) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `scounter`
--
ALTER TABLE `scounter`
  MODIFY `id` int(22) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscription`
--
ALTER TABLE `subscription`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `tcounter`
--
ALTER TABLE `tcounter`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trans`
--
ALTER TABLE `trans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
