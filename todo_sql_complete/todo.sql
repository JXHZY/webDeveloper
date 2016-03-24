-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Mar 24, 2016 at 04:33 PM
-- Server version: 5.5.42
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `todo`
--

-- --------------------------------------------------------

--
-- Table structure for table `todo`
--

CREATE TABLE `todo` (
  `id` int(11) NOT NULL,
  `description` varchar(256) NOT NULL,
  `scheduled_date` date NOT NULL,
  `status` enum('Not Started','Started','Midway','Completed') NOT NULL DEFAULT 'Not Started',
  `owner` varchar(64) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `todo`
--

INSERT INTO `todo` (`id`, `description`, `scheduled_date`, `status`, `owner`) VALUES
(1, 'Todo 1', '2016-03-15', 'Not Started', 'johnemmanueljd@gmail.com'),
(4, 'just for test', '2016-03-24', 'Not Started', 'ying@gmail.com'),
(5, 'Just for the test, first one', '2016-03-24', 'Not Started', 'ying@gmail.com'),
(6, 'Just for the test, second one', '2016-03-31', 'Not Started', 'ying@gmail.com'),
(7, 'Just for the test, 3th one', '2016-03-24', 'Not Started', 'ying@gmail.com'),
(9, 'edit ', '2016-03-24', 'Midway', 'ying@gmail.com'),
(10, 'first one', '2016-03-24', 'Midway', 'jiang@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `email` varchar(64) NOT NULL,
  `first_name` varchar(32) NOT NULL,
  `last_name` varchar(32) NOT NULL,
  `password` varchar(64) NOT NULL,
  `salt` char(8) NOT NULL,
  `type` enum('USER','ADMIN') NOT NULL DEFAULT 'USER',
  `enabled` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`email`, `first_name`, `last_name`, `password`, `salt`, `type`, `enabled`) VALUES
('jiang@gmail.com', 'jiang', 'jiang', '36f57b372dadd50a8e8c4b58bd171524', 'dbef4acc', 'USER', 1),
('johnemmanueljd@gmail.com', 'John', 'E', 'bf38ba0e2f6cd2f1755348b9bfd49caf', 'a8b23da3', 'USER', 1),
('test@gmail.com', 'test', 'test', 'b978cd143ca24c1ee4511c75e55e7297', '9c11c357', 'USER', 1),
('ying@gmail.com', 'Ying', 'Zhou', '46f911470b08366357f333edf8a9461c', '5fd2ae4a', 'USER', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `todo`
--
ALTER TABLE `todo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner` (`owner`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`email`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `todo`
--
ALTER TABLE `todo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `todo`
--
ALTER TABLE `todo`
  ADD CONSTRAINT `todo_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
