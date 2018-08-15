-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 15, 2018 at 04:46 PM
-- Server version: 5.7.23-0ubuntu0.16.04.1
-- PHP Version: 7.0.30-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `canteen`
--

-- --------------------------------------------------------

--
-- Table structure for table `canteen_admin`
--

CREATE TABLE `canteen_admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `canteen_admin`
--

INSERT INTO `canteen_admin` (`admin_id`, `username`, `password`, `status`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 1);

-- --------------------------------------------------------

--
-- Table structure for table `canteen_cart`
--

CREATE TABLE `canteen_cart` (
  `cart_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `canteen_cart`
--

INSERT INTO `canteen_cart` (`cart_id`, `order_id`, `user_id`, `menu_id`, `quantity`) VALUES
(1, 1, 1, 1, 1),
(2, 1, 1, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `canteen_menu`
--

CREATE TABLE `canteen_menu` (
  `menu_id` int(11) NOT NULL,
  `breakfast` tinyint(4) NOT NULL DEFAULT '0',
  `lunch` tinyint(4) NOT NULL DEFAULT '0',
  `dinner` tinyint(4) NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL,
  `amount` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `canteen_menu`
--

INSERT INTO `canteen_menu` (`menu_id`, `breakfast`, `lunch`, `dinner`, `name`, `amount`, `status`) VALUES
(1, 1, 0, 1, 'Roti', 10, 1),
(2, 1, 1, 1, 'Tea', 5, 1),
(3, 1, 1, 0, 'Coffee', 8, 0),
(4, 0, 1, 1, 'Veg Meal', 40, 1),
(5, 0, 1, 0, 'Nonveg Meal', 50, 1);

-- --------------------------------------------------------

--
-- Table structure for table `canteen_order`
--

CREATE TABLE `canteen_order` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `canteen_order`
--

INSERT INTO `canteen_order` (`order_id`, `user_id`, `amount`, `datetime`, `status`) VALUES
(1, 1, 15, '2018-08-15 16:43:33', 0);

-- --------------------------------------------------------

--
-- Table structure for table `canteen_user`
--

CREATE TABLE `canteen_user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `amount` int(11) NOT NULL DEFAULT '0',
  `registered_on` datetime NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `canteen_user`
--

INSERT INTO `canteen_user` (`user_id`, `username`, `password`, `amount`, `registered_on`, `status`) VALUES
(1, 'user', 'e10adc3949ba59abbe56e057f20f883e', 985, '2018-08-15 16:38:54', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `canteen_admin`
--
ALTER TABLE `canteen_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `canteen_cart`
--
ALTER TABLE `canteen_cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `canteen_menu`
--
ALTER TABLE `canteen_menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `canteen_order`
--
ALTER TABLE `canteen_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `canteen_user`
--
ALTER TABLE `canteen_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `canteen_admin`
--
ALTER TABLE `canteen_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `canteen_cart`
--
ALTER TABLE `canteen_cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `canteen_menu`
--
ALTER TABLE `canteen_menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `canteen_order`
--
ALTER TABLE `canteen_order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `canteen_user`
--
ALTER TABLE `canteen_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;