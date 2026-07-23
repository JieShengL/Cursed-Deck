-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2026 at 04:09 AM
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
-- Database: `cp`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `account_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `account_level` int(100) NOT NULL,
  `xp` int(11) NOT NULL DEFAULT 0,
  `account_rank` varchar(50) NOT NULL,
  `rank_points` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`account_id`, `user_id`, `account_level`, `xp`, `account_rank`, `rank_points`) VALUES
(1, 1, 10, 0, 'clubs', 0),
(2, 2, 47, 44, 'diamonds', 18),
(3, 3, 22, 0, 'clubs', 0),
(4, 4, 31, 0, 'hearts', 0),
(5, 5, 11, 0, 'clubs', 77),
(6, 6, 67, 67, 'spades', 67);

-- --------------------------------------------------------

--
-- Table structure for table `battle_deck`
--

CREATE TABLE `battle_deck` (
  `deck_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `slot_no` int(10) NOT NULL,
  `card_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `battle_deck`
--

INSERT INTO `battle_deck` (`deck_id`, `user_id`, `slot_no`, `card_id`) VALUES
(101, 1, 1, 4),
(102, 1, 2, 3),
(103, 1, 3, 6),
(104, 1, 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `card`
--

CREATE TABLE `card` (
  `card_id` int(10) NOT NULL,
  `card_name` varchar(50) NOT NULL,
  `ability` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `card_image` varchar(255) DEFAULT NULL,
  `lvl_req` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `card`
--

INSERT INTO `card` (`card_id`, `card_name`, `ability`, `description`, `card_image`, `lvl_req`) VALUES
(1, 'Dimensional Slash', 'A**(B+C)', '1', 'Dimensional Slash.png', 10),
(2, 'Fireball', 'A*B*C', '1', 'Fireball.jpeg', 1),
(3, 'Knightly Strike', 'A+B+C', '1', 'Knightly Strike.jpeg\r\n', 1),
(4, 'Divine Intervention', 'A**2+B**2+C**2', '1', 'Divine Intervention.png\r\n', 4),
(5, 'Echo Rift', 'A-B-C', '1', 'Echo Rift.png', 5),
(6, 'Magic Missile', 'A/(B+C)', '5', 'Magic Missile.png\r\n', 1),
(8, 'Needle Shot', 'A/B/C', '5', 'Needle Shot.png', 15),
(9, 'Expose Weakness', '(A-B)/C', '5', 'Expose Weakness.png\r\n', 20),
(10, 'Meteorite Shower', '3*A*B+C', '5', 'Meteorite Shower.jpeg', 25),
(11, 'Ascension', 'A**(B/C)', '10', 'Ascension.png', 1),
(12, 'Wall of fire', '(A+B)*C', '10', 'Wall of fire.png', 35),
(13, 'Ancient Knowledge', '(Math.log(B/C))/(Math.log(A))', '10', 'Ancient Knowledge.png', 40),
(14, 'Stitch Wounds', 'A**(B/C)', '10', 'Stitch Wounds.png', 45),
(15, 'Precision Strike', '(Math.floor(A/B))+C', '10', 'Precision Strike.png', 50);

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE `game` (
  `game_id` int(10) NOT NULL,
  `match_id` int(10) NOT NULL,
  `session_id` int(10) NOT NULL,
  `card_id` int(10) NOT NULL,
  `gamerule` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `match_history`
--

CREATE TABLE `match_history` (
  `match_id` int(10) NOT NULL,
  `account_id` int(10) NOT NULL,
  `match_date` date NOT NULL,
  `result` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `match_history`
--

INSERT INTO `match_history` (`match_id`, `account_id`, `match_date`, `result`) VALUES
(5, 1, '2026-07-01', 'Level 1: Victory'),
(6, 1, '2026-07-01', 'Level 1: Victory'),
(7, 1, '2026-07-01', 'Level 2: Victory'),
(8, 1, '2026-07-01', 'Level 3: Victory'),
(9, 1, '2026-07-03', 'Level 1: Victory'),
(10, 1, '2026-07-04', 'Level 1: Victory'),
(11, 1, '2026-07-04', 'Level 2: Victory'),
(12, 1, '2026-07-04', 'Level 3: Victory'),
(13, 1, '2026-07-04', 'Level 4: Victory'),
(14, 1, '2026-07-04', 'Level 5: Victory'),
(15, 1, '2026-07-04', 'Level 1: Defeat');

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `session_id` int(10) NOT NULL,
  `session_start_time` datetime NOT NULL,
  `session_time` int(10) NOT NULL,
  `session_stop_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(10) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email_address`, `password`, `username`) VALUES
(1, 'jason@email.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Jason'),
(2, 'secondUser@gmail.com', '202cb962ac59075b964b07152d234b70', 'secondUser'),
(3, 'thirdUser@gmail.com', '202cb962ac59075b964b07152d234b70', 'thirdUser'),
(4, 'Ali@gmail.com', '202cb962ac59075b964b07152d234b70', 'Ali'),
(5, 'Abu@gmail.com', '202cb962ac59075b964b07152d234b70', 'Abu'),
(6, 'rifqi@gmail.com', '202cb962ac59075b964b07152d234b70', 'KiwiQiyy');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`account_id`),
  ADD KEY `user` (`user_id`);

--
-- Indexes for table `battle_deck`
--
ALTER TABLE `battle_deck`
  ADD PRIMARY KEY (`deck_id`),
  ADD KEY `user_deck` (`user_id`),
  ADD KEY `card_deck` (`card_id`);

--
-- Indexes for table `card`
--
ALTER TABLE `card`
  ADD PRIMARY KEY (`card_id`);

--
-- Indexes for table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`game_id`),
  ADD KEY `match` (`match_id`),
  ADD KEY `session` (`session_id`),
  ADD KEY `card` (`card_id`);

--
-- Indexes for table `match_history`
--
ALTER TABLE `match_history`
  ADD PRIMARY KEY (`match_id`),
  ADD KEY `account` (`account_id`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`session_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `account_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `battle_deck`
--
ALTER TABLE `battle_deck`
  MODIFY `deck_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `card`
--
ALTER TABLE `card`
  MODIFY `card_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `game`
--
ALTER TABLE `game`
  MODIFY `game_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `match_history`
--
ALTER TABLE `match_history`
  MODIFY `match_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
  MODIFY `session_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account`
--
ALTER TABLE `account`
  ADD CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `battle_deck`
--
ALTER TABLE `battle_deck`
  ADD CONSTRAINT `card_deck` FOREIGN KEY (`card_id`) REFERENCES `card` (`card_id`),
  ADD CONSTRAINT `user_deck` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `game`
--
ALTER TABLE `game`
  ADD CONSTRAINT `card` FOREIGN KEY (`card_id`) REFERENCES `card` (`card_id`),
  ADD CONSTRAINT `match` FOREIGN KEY (`match_id`) REFERENCES `match_history` (`match_id`),
  ADD CONSTRAINT `session` FOREIGN KEY (`session_id`) REFERENCES `session` (`session_id`);

--
-- Constraints for table `match_history`
--
ALTER TABLE `match_history`
  ADD CONSTRAINT `account` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
