-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 27, 2020 at 03:56 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms4.2.1`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) NOT NULL,
  `datetime` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL,
  `aname` varchar(30) NOT NULL,
  `addedby` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `datetime`, `username`, `password`, `aname`, `addedby`) VALUES
(1, 'August-26-2020 16:21:20', 'pkourpidis', 'olakala', 'Paris', 'Paris'),
(2, 'August-27-2020 13:53:11', 'loumidis', 'lpapa', 'papagalos', 'Paris');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) NOT NULL,
  `title` varchar(50) NOT NULL,
  `author` varchar(50) NOT NULL,
  `datetime` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `author`, `datetime`) VALUES
(1, 'Technology', 'Paris', 0),
(2, 'Music', 'Paris', 0),
(3, 'Football', 'Paris', 0),
(4, 'Technology', 'Paris', 0),
(5, 'Basket', 'Paris', 0),
(6, 'pariss', 'Paris', 0),
(7, 'politics', 'Paris', 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) NOT NULL,
  `datetime` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(60) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `approvedBy` varchar(50) NOT NULL,
  `status` varchar(3) NOT NULL,
  `post_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `datetime`, `name`, `email`, `comment`, `approvedBy`, `status`, `post_id`) VALUES
(4, 'August-25-2020 14:12:07', 'paris', 'paris@gmail.com', 'testing purpose', 'Pending', 'OFF', 5),
(5, 'August-25-2020 14:20:04', 'nikos', 'nikos@hotm.com', 'testing purpose 2', 'Pending', 'OFF', 9),
(6, 'August-25-2020 14:57:12', 'lewnidas', 'lewnidas@veltios.com', 'Ante leme reeee', 'Pending', 'OFF', 5),
(7, 'August-25-2020 14:58:18', 'paris', 'paris@gmail.com', 'eimaste oi kaluteroiiiii', 'Pending', 'OFF', 5);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(10) NOT NULL,
  `datetime` varchar(50) NOT NULL,
  `title` varchar(300) NOT NULL,
  `category` varchar(50) NOT NULL,
  `author` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL,
  `post` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `datetime`, `title`, `category`, `author`, `image`, `post`) VALUES
(5, 'August-19-2020 15:33:47', 'My first article', 'Technology', 'Paris', 'priv.png', 'Bitnami Modules are production-ready packages of the most popular open source applications, available in the widest variety of formats.\r\n\r\nDozens of Bitnami open source applications can be quickly and easily installed on top of your XAMPP server or deployed in the cloud — for a broad range of use cases from blogs to ecommerce, business automation to eLearning.'),
(9, 'August-24-2020 15:39:12', 'Paris Kourpidis', 'Technology', 'Paris', 'thumbnail_IMG_20200515_211437.jpg', '                            hahahah i am the joker                        ');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `Foreign_Relation` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
