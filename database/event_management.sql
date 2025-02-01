-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 01, 2025 at 06:29 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `event_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendees`
--

CREATE TABLE `attendees` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendees`
--

INSERT INTO `attendees` (`id`, `event_id`, `name`, `email`, `user_id`) VALUES
(3, 7, 'Whitney Rosario', 'baqegu@mailinator.com', 0),
(4, 7, 'Amela Stephenson', 'lulizen@mailinator.com', 0),
(5, 7, 'Elton Slater', 'pesemok@mailinator.com', 0),
(6, 7, 'Emerald Koch', 'befuq@mailinator.com', 2),
(7, 8, 'Galvin Cabrera', 'naky@mailinator.com', 2),
(8, 20, 'Callum Lucas', 'jexoqimor@mailinator.com', 2),
(9, 9, 'Nolan Rojas', 'vuryf@mailinator.com', 2),
(10, 12, 'Hashim Suarez', 'ziwejegy@mailinator.com', 2),
(12, 21, 'Aphrodite Hebert', 'typiko@mailinator.com', 2),
(13, 18, 'Autumn Alexander', 'sawumopyku@mailinator.com', 2),
(14, 7, 'Oishi', 'oishi@gmail.com', 3),
(15, 8, 'Fritz Baker', 'pijobet@mailinator.com', 3);

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
(1, 'Rajah Barton', 'nixec@mailinator.com', 'Odit sunt ea volupta', 'Fugit proident in ', '2025-02-01 16:06:28'),
(2, 'David Mcconnell', 'ruzijofago@mailinator.com', 'Quia quia fugiat co', 'Sed ea nihil ut ut r', '2025-02-01 16:06:32'),
(3, 'David Mcconnell', 'ruzijofago@mailinator.com', 'Quia quia fugiat co', 'Sed ea nihil ut ut r', '2025-02-01 16:09:01'),
(4, 'Ora Blackburn', 'rofasikovi@mailinator.com', 'Ullamco perspiciatis', 'Anim minima perferen', '2025-02-01 16:09:12'),
(5, 'Kelly Stein', 'nalydakado@mailinator.com', 'Qui aut in enim expe', 'Qui soluta culpa id ', '2025-02-01 16:13:53'),
(6, 'Duncan Kirk', 'vuxoxeg@mailinator.com', 'Rem aut nihil expedi', 'Harum dolorum accusa', '2025-02-01 16:33:39'),
(7, 'Duncan Kirk', 'vuxoxeg@mailinator.com', 'Rem aut nihil expedi', 'Harum dolorum accusa', '2025-02-01 16:37:48'),
(8, 'Walter Pennington', 'dejogozy@mailinator.com', 'Accusamus sit asper', 'Alias odit veritatis', '2025-02-01 16:44:09');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `date` date NOT NULL,
  `capacity` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `description`, `date`, `capacity`, `created_by`, `location`, `created_at`) VALUES
(7, 'Vernon Gordon', 'Nesciunt maiores so', '2010-10-15', 81, 2, 'dhaka', '2025-02-01 16:36:49'),
(8, 'Denise Bond', 'Commodo in asperiore', '1996-12-03', 28, 2, '', '2025-02-01 16:36:49'),
(9, 'Avram Collins', 'Dolor dolor vitae co', '1998-12-02', 70, 2, '', '2025-02-01 16:36:49'),
(12, 'Sierra Hurst', 'Placeat ullamco quo', '1984-09-25', 93, 2, '', '2025-02-01 16:36:49'),
(18, 'Kelly Mann', 'Commodo tenetur inve', '1977-03-05', 82, 1, '', '2025-02-01 16:36:49'),
(19, 'Alisa Tyler', 'Molestiae natus id ', '1993-04-26', 25, 1, '', '2025-02-01 16:36:49'),
(20, 'Evangeline Lowery', 'Natus illo nisi non ', '1974-08-03', 8, 1, 'Incidunt omnis rerus', '2025-02-01 16:36:49'),
(21, 'Herrod Davidson', 'Exercitationem sed n', '2025-02-04', 1, 1, 'Anim similique asper', '2025-02-01 16:36:49'),
(22, 'Amelia Steele', 'Ea corrupti in sit ', '2007-08-05', 81, 1, 'Expedita qui vel lab', '2025-02-01 16:36:49');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `email`) VALUES
(1, 'shihab', '$2y$10$4YtPQvqk/dPch2JmY9Af.O1HeATZ1nXF92D.hzeALN9.3G5Db2TPC', 'admin', ''),
(2, 'shihabahmed', '$2y$10$nzaiN/pZDFekCIFqXK7KHOHw0AXaGtqokUz4DNO5siFCwe952xgsq', 'user', 'shibum278@gmail.com'),
(3, 'oishi', '$2y$10$qYSJRK3ZteNaBxkZefUGT.zAgQK2RQlS1tRTlfGbNoSQL0gNBkpgm', 'user', 'oishi@gg.com'),
(4, 'user', '$2y$10$GUajvBXhvxxJ4KsSjz/PDuWr8IqUMsQQ1ibHShSuULRwA22KBWRJm', 'user', 'user@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendees`
--
ALTER TABLE `attendees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendees_ibfk_1` (`event_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendees`
--
ALTER TABLE `attendees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendees`
--
ALTER TABLE `attendees`
  ADD CONSTRAINT `attendees_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
