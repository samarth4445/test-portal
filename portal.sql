-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2024 at 11:02 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `currenttest`
--

CREATE TABLE `currenttest` (
  `id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `currenttest`
--

INSERT INTO `currenttest` (`id`, `test_id`) VALUES
(1, 17);

-- --------------------------------------------------------

--
-- Table structure for table `instructions`
--

CREATE TABLE `instructions` (
  `instruction_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `instruction` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instructions`
--

INSERT INTO `instructions` (`instruction_id`, `test_id`, `instruction`) VALUES
(1, 17, 'Hello! This test consists of 5 questions. You have 1 hour to complete this test. Make sure you have enough time and then start the test. Cheating in the test will not be tolerated. An anti-cheating system has been implemented, and the tests will immediately end if you have left the current tab.');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `op1` text NOT NULL,
  `op2` text NOT NULL,
  `op3` text NOT NULL,
  `op4` text NOT NULL,
  `correct_op` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `test_id`, `question`, `op1`, `op2`, `op3`, `op4`, `correct_op`) VALUES
(5, 15, 'oijoij', 'iojioj', 'oijoij', 'iojo', 'iojoij', 1),
(13, 0, '', '', '', '', '', 1),
(14, 0, '', '', '', '', '', 1),
(15, 0, '', '', '', '', '', 1),
(16, 0, '', '', '', '', '', 1),
(17, 0, '', '', '', '', '', 1),
(18, 0, '', '', '', '', '', 1),
(19, 0, '', '', '', '', '', 1),
(20, 0, '', '', '', '', '', 1),
(21, 0, '', '', '', '', '', 1),
(22, 0, '', '', '', '', '', 1),
(23, 0, '', '', '', '', '', 1),
(41, 16, 'xdrty78u', 'dftry789', 'dtr7689', 'dftry768', 'cfgty789', 1),
(42, 16, 'e5467yuhj', 'fgyt879', '5678uij', 'jhyt54', 'dfrt6578', 1),
(45, 16, '4567yu', 'r657yuhj', 'dfrt678', '5678uij', 'vgftr5e4', 1),
(47, 16, '4567yuh', '5678yuih', 'cxfdtry768', '5678uij', 'fdtr6789', 1),
(49, 16, 'e567yuhj', '765rtfgh', 'zsre6t78', '876tygh', 'zsdret678', 1),
(50, 15, 'dtfyu8i9o', 'er6t78', 'dre6578', '67yuhj', 'fgtre4567', 1),
(51, 1, '567yuhj', 'cfyt87', '78ui', 'dfre4567', '45678uijk', 1),
(52, 14, '567yuhj', 'drt6789', '5678uijk', 'cfyt789', '56t7yu', 1),
(57, 19, 'iuhuihi', 'iuhiuhiuh', 'ihiuhiuh', 'iuhiuhiuhu', 'uhiuhiuhiu', 1),
(58, 19, 'iuhiuhih', 'iuhiuhiuh', 'ihiuhiuh', 'ihiuhiuh', 'iuhiuh', 1),
(59, 19, 'iuhuihiu', 'iuhiuhiuh', 'iuhuihiuhh', 'iuhiuhiu', 'hihiuiuhiuh', 1),
(60, 20, 'uyghiuyg', 'ibuiuhbn', 'iuhhiuhiuh', 'iuhiuhiuh', 'iuhiuhiuh', 1),
(63, 20, 'lknklnln', 'lknlnnl', 'nlknlkn', 'lnlnlknklnlk', 'nlkn', 1),
(65, 18, 'iuhiuh', 'iuhiuh', 'iuhiuh', 'iuhiuh', 'iuhhihu', 1),
(67, 21, 'ljknkjn', 'jknkjn', 'jknjkn', 'kjnkjn', 'kjnjknjk', 1),
(69, 17, ' How is an array initialized in C language?', 'int a[3] = {1, 2, 3};', 'int a = {1, 2, 3};', 'int a[] = new int[3]', 'int a(3) = [1, 2, 3];', 1),
(70, 17, 'Which of the following is a linear data structure?', 'Array', 'AVL Trees', 'Binary Trees', 'Graphs', 1),
(71, 17, 'How is the 2nd element in an array accessed based on pointer notation?', '*a + 2', '*(a+2)', '*(*a+2)', '&(a+2)', 1),
(72, 17, 'Which of the following is not the type of queue?', 'Priority Queue', 'Single-ended Queue', 'Circular Queue', 'Ordinary Queue', 1),
(73, 17, 'From following which is not the operation of data structure?', 'Operations that manipulate data in some way', 'Operations that perform a computation', 'Operations that check for syntax errors', 'Operations that monitor an object for the occurrence of a controlling event', 1),
(77, 22, 'r6tyu', 'tfy789', '678iuk', 'ft7689', '768ujk', 1),
(78, 22, 'hgijop', 'yuiop[', 'gyuiop', 'ghuio09-', '678uijk', 1),
(79, 22, '6789uijk', 'fgyu89', 'gyu98', 'gyu89', 'guy980', 1),
(80, 22, 'yty8u90', 'gyu8790', 'gyu890', 'gyu879', 'gyu8790', 1),
(93, 16, 'rtfyguhiu', 'hihuiuhiuh', 'iuhiuhiuhiu', 'hiuhiuhih', 'iuhiuhiuhiuhiuh', 1),
(94, 16, 'aaaaaaaaaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaaaaaaa', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `test_id` int(11) NOT NULL,
  `test_name` varchar(100) NOT NULL,
  `test_date` date NOT NULL,
  `test_question_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`test_id`, `test_name`, `test_date`, `test_question_no`) VALUES
(1, 'test-test', '2024-01-20', 1),
(14, 'test-test-test', '2024-12-24', 1),
(15, 'DSA', '2032-12-24', 2),
(16, 'DSA 2', '2024-12-24', 7),
(17, 'DSA3', '2032-12-24', 5),
(18, 'DSA 4', '2024-12-24', 1),
(19, 'DSA 10', '2024-12-24', 3),
(20, '8u7hy789h', '2024-12-24', 2),
(21, 'DSA 11', '2024-12-24', 1),
(22, 'DSA 15', '2032-12-24', 4);

-- --------------------------------------------------------

--
-- Table structure for table `test_status`
--

CREATE TABLE `test_status` (
  `relation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `test_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `test_status`
--

INSERT INTO `test_status` (`relation_id`, `user_id`, `test_id`, `test_status`) VALUES
(1, 1, 17, 1),
(14, 24, 17, 2),
(15, 25, 17, 1),
(16, 26, 17, 2),
(17, 27, 17, 1),
(18, 28, 16, 2),
(19, 29, 22, 2),
(20, 30, 19, 2);

-- --------------------------------------------------------

--
-- Table structure for table `time`
--

CREATE TABLE `time` (
  `relation_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `time` time NOT NULL,
  `test_over` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `useranswers`
--

CREATE TABLE `useranswers` (
  `relation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `user_option` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `useranswers`
--

INSERT INTO `useranswers` (`relation_id`, `user_id`, `question_id`, `user_option`) VALUES
(49, 1, 69, 1),
(50, 1, 73, 1),
(51, 1, 71, 1),
(52, 1, 72, 1),
(53, 24, 71, 1),
(54, 24, 70, 1),
(55, 26, 71, 3),
(56, 26, 73, 4),
(57, 26, 69, 3),
(58, 26, 70, 2),
(59, 26, 72, 2),
(60, 28, 54, 4),
(61, 28, 47, 4),
(62, 28, 41, 1),
(63, 1, 70, 1),
(64, 24, 73, 1),
(65, 24, 72, 1),
(66, 24, 69, 1),
(67, 28, 45, 2),
(68, 28, 42, 4),
(69, 28, 49, 2),
(70, 28, 93, 4),
(71, 28, 94, 3),
(72, 29, 78, 4),
(73, 29, 77, 2),
(74, 29, 80, 4),
(75, 29, 79, 1),
(76, 30, 59, 3),
(77, 30, 57, 4);

-- --------------------------------------------------------

--
-- Table structure for table `users_a`
--

CREATE TABLE `users_a` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_a`
--

INSERT INTO `users_a` (`id`, `name`, `username`, `password`) VALUES
(1, 'admin', 'admin', 'samarth7523');

-- --------------------------------------------------------

--
-- Table structure for table `users_u`
--

CREATE TABLE `users_u` (
  `user_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_u`
--

INSERT INTO `users_u` (`user_id`, `email`, `username`, `password`) VALUES
(1, 'nimbargisamarth@gmail.com', 'samarth6543', '12345678'),
(24, 'nimbargi.4445@gmail.com', 'samarth7523', '12345678'),
(25, 'bye@bitch.com', 'samarth1234', '12345678'),
(26, 'hi@bitch.com', 'yodude31', 'samarth324'),
(27, 'bye@bitch.com', 'lavdyabhokachya', 'adminahemejha2'),
(28, 'yoded@hehe.com', 'samarth4445', '12345678'),
(29, 'we@we.com', 'username123', '12345678'),
(30, 'we@we.com', 'username1234', '12345678');

-- --------------------------------------------------------

--
-- Table structure for table `usertests`
--

CREATE TABLE `usertests` (
  `relation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usertests`
--

INSERT INTO `usertests` (`relation_id`, `user_id`, `test_id`) VALUES
(1, 1, 17),
(4, 24, 17),
(5, 26, 17),
(6, 27, 17),
(7, 28, 16),
(8, 29, 22),
(9, 30, 19);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `currenttest`
--
ALTER TABLE `currenttest`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `instructions`
--
ALTER TABLE `instructions`
  ADD PRIMARY KEY (`instruction_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`test_id`);

--
-- Indexes for table `test_status`
--
ALTER TABLE `test_status`
  ADD PRIMARY KEY (`relation_id`);

--
-- Indexes for table `time`
--
ALTER TABLE `time`
  ADD PRIMARY KEY (`relation_id`);

--
-- Indexes for table `useranswers`
--
ALTER TABLE `useranswers`
  ADD PRIMARY KEY (`relation_id`);

--
-- Indexes for table `users_a`
--
ALTER TABLE `users_a`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_u`
--
ALTER TABLE `users_u`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `usertests`
--
ALTER TABLE `usertests`
  ADD PRIMARY KEY (`relation_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `currenttest`
--
ALTER TABLE `currenttest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `instructions`
--
ALTER TABLE `instructions`
  MODIFY `instruction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `test_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `test_status`
--
ALTER TABLE `test_status`
  MODIFY `relation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `time`
--
ALTER TABLE `time`
  MODIFY `relation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `useranswers`
--
ALTER TABLE `useranswers`
  MODIFY `relation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `users_a`
--
ALTER TABLE `users_a`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users_u`
--
ALTER TABLE `users_u`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `usertests`
--
ALTER TABLE `usertests`
  MODIFY `relation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
