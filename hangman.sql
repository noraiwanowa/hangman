-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2017 at 05:03 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hangman`
--
CREATE DATABASE IF NOT EXISTS `hangman` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `hangman`;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`) VALUES
(1, 'Ð–Ð¸Ð²Ð¾Ñ‚Ð½Ð¸'),
(2, 'Ð“Ñ€Ð°Ð´Ð¾Ð²Ðµ'),
(3, 'Ð”ÑŠÑ€Ð¶Ð°Ð²Ð¸');

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `currentWord` int(11) DEFAULT NULL,
  `userId` int(11) NOT NULL,
  `currentLettersNum` int(11) NOT NULL DEFAULT '0',
  `currentPositive` int(11) DEFAULT '0',
  `currentNegative` int(11) DEFAULT '0',
  `win` tinyint(1) DEFAULT '0',
  `lost` tinyint(1) DEFAULT '0',
  `letter` tinyint(1) NOT NULL DEFAULT '0',
  `word` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `currentWord`, `userId`, `currentLettersNum`, `currentPositive`, `currentNegative`, `win`, `lost`, `letter`, `word`) VALUES
(52, 24, 1, 4, 4, 0, 1, 0, 1, 0),
(53, 18, 1, 7, 7, 2, 1, 0, 1, 0),
(54, 18, 1, 7, 0, 0, 0, 0, 1, 0),
(55, 14, 1, 4, 0, 0, 0, 0, 1, 0),
(56, 18, 1, 7, 0, 0, 0, 0, 1, 0),
(57, 10, 1, 7, 7, 1, 1, 0, 1, 0),
(58, 17, 1, 6, 3, 4, 0, 1, 1, 0),
(59, 25, 1, 5, 0, 0, 0, 1, 0, 1),
(60, 13, 1, 7, 0, 0, 0, 1, 0, 1),
(61, 2, 1, 5, 0, 0, 1, 0, 0, 1),
(62, 23, 1, 3, 3, 0, 1, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `full_name` varchar(256) NOT NULL,
  `pwd_reset_token` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `full_name`, `pwd_reset_token`) VALUES
(1, 'nora.iwanowa@gmail.com', '$2y$10$3/LRynGLXzBdG7B36bLyfeUqAEz82pVyhMMSVRUxV5p0SRO8tadz6', 'ÐÐ¾Ñ€Ð° ÐŸÐµÑ‚ÐºÐ¾Ð²Ð°', NULL),
(2, 'nora@test.com', '$2y$10$nl9tyJUAGK81nOqVoA5h2u8uYdAh6nlpr9rDnsutJlAvf5iwCjs9e', 'Nora', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `words`
--

CREATE TABLE `words` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `word` varchar(100) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `words`
--

INSERT INTO `words` (`id`, `category_id`, `word`, `description`) VALUES
(1, 3, 'ÐÐ¾Ñ€Ð²ÐµÐ³Ð¸Ñ', 'Ð”ÑŠÑ€Ð¶Ð°Ð²Ð° Ð² Ð¡ÐµÐ²ÐµÑ€Ð½Ð° Ð•Ð²Ñ€Ð¾Ð¿Ð°'),
(2, 3, 'Ð§ÐµÑ€Ð½Ð° Ð“Ð¾Ñ€Ð°', 'Ð”ÑŠÑ€Ð¶Ð°Ð²Ð° Ñ Ð¸Ð·Ð»Ð°Ð· Ð½Ð° ÐÐ´Ñ€Ð¸Ð°Ñ‚Ð¸Ñ‡ÐµÑÐºÐ¾ Ð¼Ð¾Ñ€Ðµ'),
(3, 3, 'Ð“ÑŠÑ€Ñ†Ð¸Ñ', 'Ð”ÑŠÑ€Ð¶Ð°Ð²Ð° Ð² Ð®Ð¶Ð½Ð° Ð•Ð²Ñ€Ð¾Ð¿Ð°'),
(10, 2, 'Ð’ÐµÐ»Ð¸ÐºÐ¾ Ð¢ÑŠÑ€Ð½Ð¾Ð²Ð¾', 'Ð¡Ñ‚Ð°Ñ€Ð° Ð‘ÑŠÐ»Ð³Ð°Ñ€ÑÐºÐ° ÑÑ‚Ð¾Ð»Ð¸Ñ†Ð°'),
(11, 3, 'Ð˜ÑÐ»Ð°Ð½Ð´Ð¸Ñ', 'ÐžÑÑ‚Ñ€Ð¾Ð²Ð½Ð° Ð´ÑŠÑ€Ð¶Ð°Ð²Ð° Ð² ÑÐµÐ²ÐµÑ€Ð½Ð°Ñ‚Ð° Ñ‡Ð°ÑÑ‚ Ð½Ð° ÐÑ‚Ð»Ð°Ð½Ñ‚Ð¸Ñ‡ÐµÑÐºÐ¸Ñ Ð¾ÐºÐµÐ°Ð½'),
(12, 3, 'ÐœÐ°Ð´Ð°Ð³Ð°ÑÐºÐ°Ñ€', 'ÐžÑÑ‚Ñ€Ð¾Ð²Ð½Ð° Ð´ÑŠÑ€Ð¶Ð°Ð²Ð° Ð² Ð¸Ð½Ð´Ð¸Ð¹ÑÐºÐ¸Ñ Ð¾ÐºÐµÐ°Ð½'),
(13, 3, 'ÐÑ€Ð¶ÐµÐ½Ñ‚Ð¸Ð½Ð°', 'Ð”ÑŠÑ€Ð¶Ð°Ð²Ð° Ð² Ð®Ð¶Ð½Ð° ÐÐ¼ÐµÑ€Ð¸ÐºÐ°'),
(14, 2, 'ÐÑŽ ÐžÑ€Ð»ÐµÐ°Ð½Ñ', 'Ð“Ñ€Ð°Ð´ Ð² Ð›ÑƒÐ¸Ð·Ð¸Ð°Ð½Ð°'),
(15, 2, 'Ð’Ð°Ñ€Ð°Ð´ÐµÑ€Ð¾', 'Ð“Ñ€Ð°Ð´ Ð¸Ð·Ð²ÐµÑÑ‚ÐµÐ½ Ñ Ð¿Ð»Ð°Ð¶Ð¾Ð²ÐµÑ‚Ðµ ÑÐ¸ Ð² ÐšÑƒÐ±Ð°'),
(16, 2, 'ÐšÐ°Ð»Ð°Ð¼Ð±Ð°ÐºÐ°', 'Ð“Ñ€Ð°Ð´ Ð² Ð¿Ð¾Ð½Ð½Ð¾Ð¶Ð¸ÐµÑ‚Ð¾ Ð½Ð° Ð¼Ð°Ð½Ð°ÑÑ‚Ð¸Ñ€ÑÐºÐ¸ÐºÐ¾Ð¼Ð¿Ð»ÐµÐºÑ ÐœÐµÑ‚ÐµÐ¾Ñ€Ð°'),
(17, 2, 'Ð¡Ð°Ð½Ð´Ð°Ð½ÑÐºÐ¸', 'Ð“Ñ€Ð°Ð´ Ð² ÑŽÐ³Ð¾Ð·Ð°Ð¿Ð°Ð´Ð½Ð°Ñ‚Ð° Ð‘ÑŠÐ»Ð³Ð°Ñ€Ð¸Ñ'),
(18, 2, 'Ð¡Ð¸Ð½ÐµÐ¼Ð¾Ñ€ÐµÑ†', 'ÐœÐ¾Ñ€ÑÐºÐ¸ ÐºÑƒÑ€Ð¾Ñ€Ñ‚ Ð² Ð¡Ñ‚Ñ€Ð°Ð½Ð´Ð¶Ð° Ð¿Ð»Ð°Ð½Ð¸Ð½Ð°'),
(19, 2, 'Ð¡Ñ‚Ð°Ñ€Ð° Ð—Ð°Ð³Ð¾Ñ€Ð°', 'Ð“Ñ€Ð°Ð´ÑŠÑ‚ Ð½Ð° Ð»Ð¸Ð¿Ð¸Ñ‚Ðµ'),
(20, 1, 'Ð´ÐµÐ»Ñ„Ð¸Ð½', 'ÐœÐ¾Ñ€ÑÐºÐ¸ Ð±Ð¾Ð·Ð°Ð¹Ð½Ð¸Ðº Ð¾Ñ‚ Ñ€Ð°Ð·Ñ€ÐµÐ´ ÐšÐ¸Ñ‚Ð¾Ð¿Ð¾Ð´Ð¾Ð±Ð½Ð¸'),
(21, 1, 'Ñ…Ð¸Ð¿Ð¾Ð¿Ð¾Ñ‚Ð°Ð¼', 'Ð•Ð´ÑŠÑ€ Ð‘Ð¾Ð·Ð°Ð¹Ð½Ð¸Ðº'),
(22, 1, 'Ð¼Ð°Ð¹Ð¼ÑƒÐ½Ð°', 'ÐŸÑ€Ð¸Ð¼Ð°Ñ‚'),
(23, 1, 'ÐºÐ¾ÐºÐ¾ÑˆÐºÐ°', 'Ð”Ð¾Ð¼Ð°ÑˆÐ½Ð° Ð¿Ñ‚Ð¸Ñ†Ð°'),
(24, 1, 'Ð¿Ð°Ð¿Ð°Ð³Ð°Ð»', 'Ð”ÐµÐºÐ¾Ñ€Ð°Ñ‚Ð¸Ð²Ð½Ð° Ð¿Ñ‚Ð¸Ñ†Ð°'),
(25, 2, 'Ð¡Ñ‚Ð°Ñ€Ð° Ð—Ð°Ð³Ð¾Ñ€Ð°', 'Ð“Ñ€Ð°Ð´ Ð² Ð®Ð¶Ð½Ð° Ð‘ÑŠÐ»Ð³Ð°Ñ€Ð¸Ñ');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`),
  ADD KEY `currentWord` (`currentWord`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `words`
--
ALTER TABLE `words`
  ADD PRIMARY KEY (`id`),
  ADD KEY `word` (`word`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `words`
--
ALTER TABLE `words`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `games_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `games_ibfk_2` FOREIGN KEY (`currentWord`) REFERENCES `words` (`id`);

--
-- Constraints for table `words`
--
ALTER TABLE `words`
  ADD CONSTRAINT `words_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
