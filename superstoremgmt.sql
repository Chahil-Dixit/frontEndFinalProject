-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 11, 2022 at 04:56 AM
-- Server version: 5.7.33
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `superstoremgmt`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `firstName`, `lastName`, `gender`, `phone`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, '', 'Admin', 'Male', '1232123212', 'admin@gmail.com', 'MTIz', '2022-08-07 21:45:07', '2022-08-08 02:46:51');

-- --------------------------------------------------------

--
-- Table structure for table `customerinvoicebody`
--

CREATE TABLE `customerinvoicebody` (
  `id` int(11) NOT NULL,
  `invId` int(11) NOT NULL,
  `supplierId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customerinvoicebody`
--

INSERT INTO `customerinvoicebody` (`id`, `invId`, `supplierId`, `productId`, `qty`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 123, '2022-08-11 02:18:44', '2022-08-11 02:18:44'),
(2, 2, 1, 1, 3222, '2022-08-11 04:39:30', '2022-08-11 04:39:30'),
(3, 3, 1, 1, 1, '2022-08-11 04:43:57', '2022-08-11 04:43:57');

-- --------------------------------------------------------

--
-- Table structure for table `customerinvoicefooter`
--

CREATE TABLE `customerinvoicefooter` (
  `id` int(11) NOT NULL,
  `invId` int(11) NOT NULL,
  `total` float NOT NULL,
  `tax` float NOT NULL,
  `discount` float NOT NULL,
  `finalAmount` float NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customerinvoicefooter`
--

INSERT INTO `customerinvoicefooter` (`id`, `invId`, `total`, `tax`, `discount`, `finalAmount`, `created_at`, `updated_at`) VALUES
(2, 1, 35816.2, 5351.84, 5351.84, 41168, '2022-08-11 02:18:44', '2022-08-11 02:18:44'),
(3, 2, 930931, 139105, 139105, 1070040, '2022-08-11 04:39:30', '2022-08-11 04:39:30'),
(4, 3, 577.68, 86.32, 86.32, 664, '2022-08-11 04:43:57', '2022-08-11 04:43:57');

-- --------------------------------------------------------

--
-- Table structure for table `customerinvoiceheader`
--

CREATE TABLE `customerinvoiceheader` (
  `id` int(11) NOT NULL,
  `invId` varchar(255) NOT NULL,
  `customerId` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customerinvoiceheader`
--

INSERT INTO `customerinvoiceheader` (`id`, `invId`, `customerId`, `created_at`, `updated_at`) VALUES
(1, 'INV1660184324', 3, '2022-08-11 02:18:44', '2022-08-11 02:18:44'),
(2, 'INV1660192770', 3, '2022-08-11 04:39:30', '2022-08-11 04:39:30'),
(3, 'INV1660193037', 3, '2022-08-11 04:43:57', '2022-08-11 04:43:57');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `customerId` varchar(50) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `houseNumber` varchar(20) NOT NULL,
  `password` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `customerId`, `firstName`, `lastName`, `gender`, `phone`, `email`, `address`, `houseNumber`, `password`, `created_at`, `updated_at`) VALUES
(3, '1659924471', 'test', 'ttst', 'male', '5454545454', 't@t.com', 'test', '2131', 'MTIz', '2022-08-08 02:28:37', '2022-08-08 02:46:09'),
(4, '1659924563', 'teste', 'estse', 'male', '8798784464', 's@se.com', 'svs', '234', 'QW5hbWkkMTIz', '2022-08-08 02:09:23', '2022-08-08 02:46:09');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `productName` varchar(255) NOT NULL,
  `productId` int(11) NOT NULL,
  `supplierId` int(11) NOT NULL,
  `price` varchar(20) NOT NULL,
  `discount` varchar(10) NOT NULL,
  `tax` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `productName`, `productId`, `supplierId`, `price`, `discount`, `tax`, `created_at`, `updated_at`) VALUES
(1, 'test', 1659929856, 1, '332', '13', '13', '2022-08-08 03:37:36', '2022-08-10 02:26:23');

-- --------------------------------------------------------

--
-- Table structure for table `supplierinvoicebody`
--

CREATE TABLE `supplierinvoicebody` (
  `id` int(11) NOT NULL,
  `invId` int(11) NOT NULL,
  `supplierId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplierinvoicebody`
--

INSERT INTO `supplierinvoicebody` (`id`, `invId`, `supplierId`, `productId`, `qty`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 123, '2022-08-11 02:18:44', '2022-08-11 02:18:44');

-- --------------------------------------------------------

--
-- Table structure for table `supplierinvoicefooter`
--

CREATE TABLE `supplierinvoicefooter` (
  `id` int(11) NOT NULL,
  `invId` int(11) NOT NULL,
  `total` float NOT NULL,
  `tax` float NOT NULL,
  `discount` float NOT NULL,
  `finalAmount` float NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplierinvoicefooter`
--

INSERT INTO `supplierinvoicefooter` (`id`, `invId`, `total`, `tax`, `discount`, `finalAmount`, `created_at`, `updated_at`) VALUES
(2, 1, 35816.2, 5351.84, 5351.84, 41168, '2022-08-11 02:18:44', '2022-08-11 02:18:44');

-- --------------------------------------------------------

--
-- Table structure for table `supplierinvoiceheader`
--

CREATE TABLE `supplierinvoiceheader` (
  `id` int(11) NOT NULL,
  `invId` varchar(255) NOT NULL,
  `customerId` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplierinvoiceheader`
--

INSERT INTO `supplierinvoiceheader` (`id`, `invId`, `customerId`, `created_at`, `updated_at`) VALUES
(1, 'INV1660184324', 3, '2022-08-11 02:18:44', '2022-08-11 02:18:44');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `supplierId` varchar(50) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `houseNumber` varchar(20) NOT NULL,
  `password` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `supplierId`, `firstName`, `lastName`, `gender`, `phone`, `email`, `address`, `houseNumber`, `password`, `created_at`, `updated_at`) VALUES
(1, '1659925884', 'Supp', 'Lier', 'Male', '6515132231', 'e@g.com', 'sdvsd', 'sdv', 'MTIz', '2022-08-08 02:33:19', '2022-08-11 04:48:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customerinvoicebody`
--
ALTER TABLE `customerinvoicebody`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customerinvoicefooter`
--
ALTER TABLE `customerinvoicefooter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customerinvoiceheader`
--
ALTER TABLE `customerinvoiceheader`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplierinvoicebody`
--
ALTER TABLE `supplierinvoicebody`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplierinvoicefooter`
--
ALTER TABLE `supplierinvoicefooter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplierinvoiceheader`
--
ALTER TABLE `supplierinvoiceheader`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customerinvoicebody`
--
ALTER TABLE `customerinvoicebody`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customerinvoicefooter`
--
ALTER TABLE `customerinvoicefooter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customerinvoiceheader`
--
ALTER TABLE `customerinvoiceheader`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `supplierinvoicebody`
--
ALTER TABLE `supplierinvoicebody`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `supplierinvoicefooter`
--
ALTER TABLE `supplierinvoicefooter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `supplierinvoiceheader`
--
ALTER TABLE `supplierinvoiceheader`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
