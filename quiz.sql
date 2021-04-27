-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2021 at 03:29 PM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quiz`
--

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `question_id` int(4) NOT NULL,
  `question` varchar(200) NOT NULL,
  `c1` varchar(200) NOT NULL,
  `c2` varchar(200) NOT NULL,
  `c3` varchar(200) NOT NULL,
  `c4` varchar(200) NOT NULL,
  `correct_ans` varchar(200) NOT NULL,
  `room_id` varchar(4) NOT NULL,
  `created` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`question_id`, `question`, `c1`, `c2`, `c3`, `c4`, `correct_ans`, `room_id`, `created`) VALUES
(98, 'question', 'this is c2', 'this is c3', 'this is c4', 'correct', 'correct', '3395', NULL),
(996, 'question', 'this is c4', 'this is c3', 'this is c2', 'correct', 'correct', '3395', NULL),
(309, 'question', 'correct', 'this is c4', 'this is c3', 'this is c2', 'correct', '3395', NULL),
(320, 'question', 'this is c4', 'correct', 'this is c3', 'this is c2', 'correct', '3395', NULL),
(35, 'question', 'this is c4', 'this is c2', 'correct', 'this is c3', 'correct', '3395', NULL),
(15, 'question', 'this is c3', 'this is c4', 'this is c2', 'correct', 'correct', '3395', NULL),
(712, 'question', 'correct', 'this is c2', 'this is c4', 'this is c3', 'correct', '3395', NULL),
(519, 'question', 'this is c3', 'correct', 'this is c4', 'this is c2', 'correct', '3395', NULL),
(949, 'question', 'correct', 'this is c4', 'this is c2', 'this is c3', 'correct', '3395', NULL),
(133, 'question', 'this is c2', 'this is c4', 'this is c1', 'this is c3', 'this is c2', '3395', NULL),
(587, 'question', 'this is c1', 'this is c2', 'this is c3', 'this is c4', 'this is c1', '3395', NULL),
(852, 'question', 'this is c3', 'this is c4', 'this is c1', 'this is c2', 'this is c3', '3395', NULL),
(188, 'question', 'this is c2', 'this is c1', 'this is c3', 'this is c4', 'this is c1', '3395', NULL),
(596, 'question', 'this is c4', 'this is c2', 'this is c3', 'this is c1', 'this is c1', '3395', NULL),
(635, 'question', 'this is c2', 'this is c1', 'this is c3', 'this is c4', 'this is c1', '3395', NULL),
(408, 'question', 'this is c1', 'this is c2', 'this is c4', 'this is c3', '0', '3395', '2021-04-27'),
(329, 'question', 'this is c4', 'this is c2', 'this is c3', 'this is c1', '3', '3395', '2021-04-27'),
(645, 'question', 'this is c3', 'this is c4', 'this is c2', 'this is c1', '3', '3395', '2021-04-27'),
(415, 'question', 'this is c3', 'this is c1', 'this is c4', 'this is c2', '1', '3395', '2021-04-27'),
(48, 'question', 'this is c3', 'this is c2', 'this is c1', 'this is c4', '2', '3395', '2021-04-27');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_id` varchar(4) NOT NULL,
  `inv_code` varchar(13) NOT NULL,
  `max_player` int(2) NOT NULL,
  `status` varchar(10) NOT NULL,
  `current_q` int(2) NOT NULL,
  `now_no` int(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_id`, `inv_code`, `max_player`, `status`, `current_q`, `now_no`) VALUES
('9714', '60867a444a388', 20, 'created', 0, 2),
('3395', '6086d23d8cdc0', 20, 'finished', 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` varchar(4) NOT NULL,
  `name` varchar(20) NOT NULL,
  `created_at` date NOT NULL,
  `room_id` varchar(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `created_at`, `room_id`) VALUES
('2529', 'abc', '2021-04-26', '3395'),
('4841', 'abc', '2021-04-26', '3395'),
('4222', 'abc', '2021-04-26', '3395');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`question_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `question_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=997;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
