-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 13, 2024 at 10:22 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `user`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact_form`
--

CREATE TABLE `contact_form` (
  `id` int(100) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phoneno` int(100) NOT NULL,
  `question` varchar(255) DEFAULT NULL,
  `program` varchar(100) NOT NULL,
  `post_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contact_form`
--

INSERT INTO `contact_form` (`id`, `fullname`, `email`, `phoneno`, `question`, `program`, `post_time`) VALUES
(1, 'KUAN CHIN ZHONG', 'qinchong877@gmail.com', 129089908, 'How about the class time', 'english', '2024-07-12 19:16:36'),
(2, 'Ashton Lim Zhn Cong', 'ashton@gmail.com', 129021345, 'what is the recommended subject ', 'math', '2024-07-12 19:17:46'),
(3, 'Kim Jun Star', 'junstar@gmail.com', 120346423, 'how u guys teach worr', 'math', '2024-07-13 06:55:02'),
(5, 'June', 'kkjhhyu0405@gmail.com', 1127928821, 'How is the lecturer personality.', 'math', '2024-07-13 19:48:59'),
(6, 'Foo', 'Foo@gmail.com', 112227345, 'Is history important?', 'history', '2024-07-13 20:09:16');

-- --------------------------------------------------------

--
-- Table structure for table `program`
--

CREATE TABLE `program` (
  `Program_id` int(11) NOT NULL,
  `Program_Name` varchar(200) NOT NULL,
  `Price` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `program`
--

INSERT INTO `program` (`Program_id`, `Program_Name`, `Price`) VALUES
(1001, 'Malay Language', 199),
(1002, 'English Language', 199),
(1003, 'Mathematics', 199),
(1004, 'History', 199),
(1005, 'Science', 199);

-- --------------------------------------------------------

--
-- Table structure for table `teacher_profile`
--

CREATE TABLE `teacher_profile` (
  `TeachID` int(100) NOT NULL,
  `Teachname` varchar(100) NOT NULL,
  `TeachEdu` varchar(100) NOT NULL,
  `TeachUNI` varchar(100) NOT NULL,
  `Slogan` varchar(100) NOT NULL,
  `file_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teacher_profile`
--

INSERT INTO `teacher_profile` (`TeachID`, `Teachname`, `TeachEdu`, `TeachUNI`, `Slogan`, `file_path`) VALUES
(7, 'Nur Aisyah', 'Bachelor of Education in Primary Education', 'Universiti Pendidikan Sultan Idris', 'Empowering young minds to reach new heights', '../Aboutus/uploads/t1.jpg'),
(8, 'Ahmad Zulfiqar', 'Bachelor of Science in Mathematics', 'University of Malaya', 'Unlocking the potential within every student', '../Aboutus/uploads/t2.png'),
(9, 'Lim Mei Ying', 'Bachelor of Science in Biology', 'Tsinghua University', 'Nurturing curiosity and a love for learning', '../Aboutus/uploads/t3.png'),
(10, 'Rajesh Kumar', 'Bachelor of Engineering in Mechanical Engineering', 'Indian Institute of Technology', 'Engineering brighter futures.', '../Aboutus/uploads/t5.png'),
(11, 'Chen Wei', 'Bachelor of Arts in English Literature', 'National University of Singapore', 'Inspiring minds, one lesson at a time.', '../Aboutus/uploads/t4.png'),
(12, 'Priya Nair', 'Bachelor of Commerce in Accounting', 'University of Mumbai', 'Guiding students towards academic excellence.', '../Aboutus/uploads/t6.png'),
(15, 'Yi. Lin', 'Bachelor of Language in Malay ', 'Bejing University', 'Always trust yourself! Malaysia Boleh!', '../Aboutus/uploads/yinan.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `up_load`
--

CREATE TABLE `up_load` (
  `UserID` int(100) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `upload_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `up_load`
--

INSERT INTO `up_load` (`UserID`, `file_name`, `file_path`, `upload_time`) VALUES
(25, 'jun.jpg', '../UserProfile/uploads/25_1720899166.jpg', '2024-07-13 19:32:46'),
(26, 'qin.jpg', '../UserProfile/uploads/26_1720901201.jpg', '2024-07-13 20:06:41'),
(27, 'minion jun.jpg', '../UserProfile/uploads/27_1720900263.jpg', '2024-07-13 19:51:03'),
(28, 'AYANE.jpg', '../UserProfile/uploads/28_1720900627.jpg', '2024-07-13 19:57:07'),
(29, 'tasha.jpg', '../UserProfile/uploads/29_1720901064.jpg', '2024-07-13 20:04:24');

-- --------------------------------------------------------

--
-- Table structure for table `user_optional`
--

CREATE TABLE `user_optional` (
  `user_id` int(100) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `bio` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_optional`
--

INSERT INTO `user_optional` (`user_id`, `nickname`, `bio`) VALUES
(25, 'Zc', 'Rhytm'),
(27, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_program`
--

CREATE TABLE `user_program` (
  `user_id` int(20) NOT NULL,
  `program_id` int(255) NOT NULL,
  `payment_id` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `purchase_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_program`
--

INSERT INTO `user_program` (`user_id`, `program_id`, `payment_id`, `amount`, `purchase_date`) VALUES
(25, 1002, 'pay_OYEVICbOtZHcIL', '398.00', '2024-07-13 19:32:07'),
(25, 1005, 'pay_OYEVICbOtZHcIL', '398.00', '2024-07-13 19:32:07'),
(26, 1003, 'pay_OYEbgxYeOUrrah', '199.00', '2024-07-13 19:38:10'),
(27, 1002, 'pay_OYEl5ruumk9xfY', '398.00', '2024-07-13 19:47:05'),
(27, 1005, 'pay_OYEl5ruumk9xfY', '398.00', '2024-07-13 19:47:05'),
(28, 1001, 'pay_OYEtDqba5hzphg', '599.00', '2024-07-13 19:54:46'),
(28, 1002, 'pay_OYEtDqba5hzphg', '599.00', '2024-07-13 19:54:46'),
(28, 1003, 'pay_OYEtDqba5hzphg', '599.00', '2024-07-13 19:54:46'),
(28, 1004, 'pay_OYEtDqba5hzphg', '599.00', '2024-07-13 19:54:46'),
(28, 1005, 'pay_OYEtDqba5hzphg', '599.00', '2024-07-13 19:54:46'),
(29, 1001, 'pay_OYF16HCiGTfk4D', '398.00', '2024-07-13 20:02:13'),
(29, 1003, 'pay_OYF16HCiGTfk4D', '398.00', '2024-07-13 20:02:13');

-- --------------------------------------------------------

--
-- Table structure for table `user_registration`
--

CREATE TABLE `user_registration` (
  `UserID` int(100) NOT NULL,
  `Username` varchar(100) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `PhoneNumber` int(100) NOT NULL,
  `Birth` date NOT NULL,
  `Gender` varchar(10) NOT NULL,
  `resetPassword` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_registration`
--

INSERT INTO `user_registration` (`UserID`, `Username`, `Email`, `Password`, `PhoneNumber`, `Birth`, `Gender`, `resetPassword`) VALUES
(0, 'Admin', 'admin1507@smartstudysport.com', '$2y$10$GTpuReJNfH8UsnaFld3KJe93KYdg7p4OZQvLe9Mgjw9rEDaH15iIG', 41885338, '2024-07-01', 'male', 0),
(25, 'Ashton lim', 'ashton@gmail.com', '$2y$10$kmFLDeZWm0D9q7qEHigWmumb.jrXQC7AZ3k/EI28DCcNfjNqyMUg6', 122372586, '2004-10-05', 'male', 41005),
(26, 'MrQin', 'qinchong877@gmail.com', '$2y$10$dmgZFZCtJOh06erXb3AvTerZuOEsrGe185EUZb3QOEXB1s1JvDI.e', 109223632, '2004-08-01', 'other', 40801),
(27, 'June', 'kkjhhyu0405@gmail.com', '$2y$10$jpX0x4az2UiSTl9q/jAMRuT17j2PGc4zhp2aP2pUwXLAUiLdhI.DO', 1127928821, '2003-05-04', 'male', 200304),
(28, 'Ayane', 'AYA@gmail.com', '$2y$10$KZUKcusC.rRppo4eIQf3reKle7bAq9dcPNQcvwUToIVgKUHf3f8JS', 124871563, '2024-07-03', 'female', 123456),
(29, 'Tasha', 'tasha@gmail.com', '$2y$10$DE6gLYsZlZkpm.taVEx.K.Ef/yhypHSI0GXnty0qHhW3H37I15DSS', 123455788, '2004-06-05', 'female', 345678);

-- --------------------------------------------------------

--
-- Table structure for table `user_review`
--

CREATE TABLE `user_review` (
  `reviewID` int(100) NOT NULL,
  `review` varchar(255) NOT NULL,
  `star` int(5) NOT NULL,
  `program` varchar(255) NOT NULL,
  `saved_time` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_review`
--

INSERT INTO `user_review` (`reviewID`, `review`, `star`, `program`, `saved_time`) VALUES
(2, 'I think math is so easy for me', 1, 'Mathematics', '2024-07-13 21:37:17.000000'),
(3, 'This is the best class I have taken !', 5, 'English Language', '2024-07-13 21:47:43.000000'),
(4, 'I love Malay Language!!!', 4, 'Malay Language', '2024-07-13 22:03:08.000000'),
(5, 'Malay language is so hard to understand........', 2, 'Malay Language', '2024-07-13 22:03:45.000000'),
(6, 'History is really important, happy to be learning here hehe', 3, 'History', '2024-07-13 22:18:44.000000'),
(7, 'The lecturer study material is so exciting. ', 5, 'History', '2024-07-13 22:19:47.000000'),
(8, 'Science study material is well prepared here!!', 5, 'Science', '2024-07-13 22:20:24.000000'),
(9, 'The Science is bored....', 1, 'Science', '2024-07-13 22:21:08.000000'),
(10, 'The environment is so good ! ', 5, 'History', '2024-07-13 22:22:18.000000');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_form`
--
ALTER TABLE `contact_form`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `program`
--
ALTER TABLE `program`
  ADD PRIMARY KEY (`Program_id`);

--
-- Indexes for table `teacher_profile`
--
ALTER TABLE `teacher_profile`
  ADD PRIMARY KEY (`TeachID`);

--
-- Indexes for table `up_load`
--
ALTER TABLE `up_load`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `user_optional`
--
ALTER TABLE `user_optional`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_program`
--
ALTER TABLE `user_program`
  ADD PRIMARY KEY (`user_id`,`program_id`),
  ADD KEY `fk_pro_program_id` (`program_id`);

--
-- Indexes for table `user_registration`
--
ALTER TABLE `user_registration`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `user_review`
--
ALTER TABLE `user_review`
  ADD PRIMARY KEY (`reviewID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_form`
--
ALTER TABLE `contact_form`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `program`
--
ALTER TABLE `program`
  MODIFY `Program_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1006;

--
-- AUTO_INCREMENT for table `teacher_profile`
--
ALTER TABLE `teacher_profile`
  MODIFY `TeachID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user_registration`
--
ALTER TABLE `user_registration`
  MODIFY `UserID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `user_review`
--
ALTER TABLE `user_review`
  MODIFY `reviewID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `up_load`
--
ALTER TABLE `up_load`
  ADD CONSTRAINT `fk-imguser` FOREIGN KEY (`UserID`) REFERENCES `user_registration` (`UserID`);

--
-- Constraints for table `user_optional`
--
ALTER TABLE `user_optional`
  ADD CONSTRAINT `fk_uop_user` FOREIGN KEY (`user_id`) REFERENCES `user_registration` (`UserID`);

--
-- Constraints for table `user_program`
--
ALTER TABLE `user_program`
  ADD CONSTRAINT `fk_pro_program_id` FOREIGN KEY (`program_id`) REFERENCES `program` (`Program_id`),
  ADD CONSTRAINT `fk_user_id_resgis` FOREIGN KEY (`user_id`) REFERENCES `user_registration` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
