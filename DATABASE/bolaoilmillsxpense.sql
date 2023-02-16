-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 13, 2021 at 06:19 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bolaoilmillsxpense`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
CREATE TABLE IF NOT EXISTS `account` (
  `accountid` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `balance` decimal(10,2) NOT NULL,
  `accountnumber` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`accountid`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`accountid`, `name`, `balance`, `accountnumber`, `description`) VALUES
(11, 'ICT Department', '1000000.00', '3111134158', 'ICT Department Opening Account');

-- --------------------------------------------------------

--
-- Table structure for table `budget`
--

DROP TABLE IF EXISTS `budget`;
CREATE TABLE IF NOT EXISTS `budget` (
  `budgetid` int(5) NOT NULL AUTO_INCREMENT,
  `userid` int(5) NOT NULL,
  `categoryid` int(5) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `fromdate` date NOT NULL,
  `todate` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`budgetid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `budget`
--

INSERT INTO `budget` (`budgetid`, `userid`, `categoryid`, `amount`, `fromdate`, `todate`, `description`) VALUES
(1, 1, 28, '50000000.00', '2021-07-30', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `categoryid` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `type` int(11) NOT NULL,
  `color` varchar(10) NOT NULL,
  PRIMARY KEY (`categoryid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categoryid`, `name`, `description`, `type`, `color`) VALUES
(1, 'ICT', 'ICT Expense', 2, '#FFFFFF'),
(2, 'General Company', 'General Company', 1, '#2159FF');

-- --------------------------------------------------------

--
-- Table structure for table `goals`
--

DROP TABLE IF EXISTS `goals`;
CREATE TABLE IF NOT EXISTS `goals` (
  `goalsid` int(5) NOT NULL AUTO_INCREMENT,
  `userid` int(5) NOT NULL,
  `accountid` int(5) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `balance` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `deposit` decimal(10,2) NOT NULL,
  `deadline` date NOT NULL,
  PRIMARY KEY (`goalsid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `roleid` int(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`roleid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`roleid`, `name`) VALUES
(2, 'Transactions'),
(3, 'Income'),
(4, 'Expense'),
(5, 'Accounts'),
(6, 'Track Budget'),
(7, 'Set Goals'),
(8, 'Calendar'),
(9, 'Income Category'),
(10, 'Expense Category'),
(11, 'Income Reports'),
(12, 'Expense Category'),
(13, 'Income vs Expense Reports'),
(14, 'Income Monthly Report'),
(15, 'Expense Monthly Report'),
(16, 'Account Transaction Reports'),
(17, 'User Role'),
(18, 'Application Setting'),
(19, 'Upcoming Income'),
(20, 'Upcoming Expense');

-- --------------------------------------------------------

--
-- Table structure for table `roleaccess`
--

DROP TABLE IF EXISTS `roleaccess`;
CREATE TABLE IF NOT EXISTS `roleaccess` (
  `roleaccessid` int(5) NOT NULL AUTO_INCREMENT,
  `roleid` int(5) NOT NULL,
  `userid` int(5) NOT NULL,
  PRIMARY KEY (`roleaccessid`),
  KEY `deleteroleaccess` (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roleaccess`
--

INSERT INTO `roleaccess` (`roleaccessid`, `roleid`, `userid`) VALUES
(18, 2, 1),
(19, 3, 1),
(20, 4, 1),
(21, 5, 1),
(22, 6, 1),
(23, 7, 1),
(24, 8, 1),
(25, 9, 1),
(26, 10, 1),
(27, 11, 1),
(28, 12, 1),
(29, 13, 1),
(30, 14, 1),
(31, 15, 1),
(32, 16, 1),
(33, 17, 1),
(34, 18, 1),
(35, 19, 1),
(36, 20, 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `settingsid` int(11) NOT NULL AUTO_INCREMENT,
  `company` varchar(255) NOT NULL,
  `city` varchar(200) NOT NULL,
  `address` text NOT NULL,
  `website` varchar(255) DEFAULT NULL,
  `phone` varchar(200) DEFAULT NULL,
  `logo` text NOT NULL,
  `currency` varchar(5) NOT NULL,
  `languages` varchar(10) NOT NULL,
  `dateformat` varchar(20) NOT NULL,
  PRIMARY KEY (`settingsid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`settingsid`, `company`, `city`, `address`, `website`, `phone`, `logo`, `currency`, `languages`, `dateformat`) VALUES
(1, 'WeGoHostU Expense Manager', 'Osogbo', 'Oroki Estate', 'wegohostu', '08035318934', 'hostlogo.png', '₦', 'en', 'd/m/Y');

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

DROP TABLE IF EXISTS `subcategory`;
CREATE TABLE IF NOT EXISTS `subcategory` (
  `subcategoryid` int(11) NOT NULL AUTO_INCREMENT,
  `categoryid` int(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`subcategoryid`),
  KEY `deletesubquery` (`categoryid`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`subcategoryid`, `categoryid`, `name`, `type`, `description`) VALUES
(28, 1, 'ICT', 2, 'This is to track the expenses of the ICT Department');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

DROP TABLE IF EXISTS `transaction`;
CREATE TABLE IF NOT EXISTS `transaction` (
  `transactionid` int(5) NOT NULL AUTO_INCREMENT,
  `userid` int(5) NOT NULL,
  `categoryid` int(5) NOT NULL,
  `accountid` int(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `transactiondate` date NOT NULL,
  `type` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `file` text DEFAULT NULL,
  PRIMARY KEY (`transactionid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`transactionid`, `userid`, `categoryid`, `accountid`, `name`, `amount`, `reference`, `transactiondate`, `type`, `description`, `file`) VALUES
(1, 1, 28, 11, 'HP Laptop', '350000.00', NULL, '2021-06-03', 2, 'We bought hp laptop for our ict department', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(60) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `email`, `name`, `password`, `role`, `phone`, `status`, `remember_token`, `updated_at`, `created_at`) VALUES
(1, 'admin@wegohostu.com', 'Ariyo Alex', '$2y$10$m4OZe0Q69QCCsFZlvA0AsOuplR1OhTHobaDK4gUzLS2gKJY1sl95W', 'Administrator', '08035318934', 'Active', '9quOOyh6djRVPUsy297suI6fAZQOUmMBm3IMMda09yMKjgoyM1yNFJlMyZT3', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `roleaccess`
--
ALTER TABLE `roleaccess`
  ADD CONSTRAINT `deleteroleaccess` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`) ON DELETE CASCADE;

--
-- Constraints for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD CONSTRAINT `deletesubquery` FOREIGN KEY (`categoryid`) REFERENCES `category` (`categoryid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



$2y$10$m4OZe0Q69QCCsFZlvA0AsOuplR1OhTHobaDK4gUzLS2gKJY1sl95W