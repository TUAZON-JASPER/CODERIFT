-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2025 at 04:21 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coderift`
--

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question`, `answer`) VALUES
(11, 'a', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `year_level` varchar(50) NOT NULL,
  `section` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `year_level`, `section`) VALUES
(1, 'Jasper James Perdigones', '2nd Year', 'B'),
(2, 'Marius Mangundayao', '1st Year', 'C'),
(3, 'aa', '1st Year', 'A'),
(4, 'bronny', '1st Year', 'A'),
(5, 'bronny', '1st Year', 'A'),
(6, 'fgga', '1st Year', 'A'),
(7, 'af', '1st Year', 'A'),
(8, 'afa', '1st Year', 'A'),
(9, 'Lebron', '1st Year', 'A'),
(10, 'Lebron', '1st Year', 'A'),
(11, 'admin', '1st Year', 'A'),
(12, 'admin', '1st Year', 'A'),
(13, 'admin', '1st Year', 'A'),
(14, 'Jasper Tuazon', '1st Year', 'A'),
(15, 'Jasper Tuazon', '1st Year', 'A'),
(16, 'Jasper Tuazon', '1st Year', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `cpp` int(255) NOT NULL,
  `ceasy` int(255) NOT NULL,
  `cinter` int(255) NOT NULL,
  `cadv` int(255) NOT NULL,
  `java` int(255) NOT NULL,
  `jeasy` int(255) NOT NULL,
  `jinter` int(255) NOT NULL,
  `jadv` int(255) NOT NULL,
  `points` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `cpp`, `ceasy`, `cinter`, `cadv`, `java`, `jeasy`, `jinter`, `jadv`, `points`) VALUES
(7, '1111', '$2y$10$7139S98BFk0KHYz2i13Ee.d9DxbaVWgVruZqNlD.wxruGP0bg.lxm', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(8, 'bronnyjemas', '$2y$10$IspbIDJYkNa30YvW69sKEuXGrXWXJB4hiMWtvvjP0L4yXw/RNFr8u', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(9, 'lebron', '$2y$10$fiI1qSjl0rPwKHcnRrAA..3o2vqlDiDszBnVg9jYmwR70N9Jqj6hy', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(10, 'bronny', '$2y$10$qA2lhC9/kB6F4kzBXOCdXOtCf3WcnRggcNQ/gu7Fuqte1jUq9W6.y', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(12, 'junjun', '$2y$10$YpPDPRWt1t1pOFBDaGKR0.8PwwCoenU4LNz7PfCTQLIv.7L9dAVuq', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(13, 'jasper', '$2y$10$1BJ130pR0qBemqKSimKpWu5BSbYqVNlZcF.JxbhMocXW5yZHEL/Ze', 0, 0, 0, 0, 0, 1, 0, 0, 9),
(14, 'jordanmichael', '$2y$10$NGYyhsi1tqsVstwcRWTQ4OAgrcbnuWTpTJwGQcDzFZn9ob1xTreE2', 0, 0, 0, 0, 0, 0, 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
