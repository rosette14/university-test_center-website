-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2022 at 10:53 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--
CREATE DATABASE IF NOT EXISTS `project` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `project`;

-- --------------------------------------------------------

--
-- Table structure for table `material`
--

DROP TABLE IF EXISTS `material`;
CREATE TABLE IF NOT EXISTS `material` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `material_name` varchar(45) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `materialcol_UNIQUE` (`material_name`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `material`
--

INSERT INTO `material` (`id`, `material_name`, `description`) VALUES
(19, 'math', 'important to learn'),
(25, 'physics', 'inetresting to learn'),
(28, 'english', 'linguistic skills'),
(29, 'informatics tech', 'for smart people'),
(30, 'chemistry', NULL),
(32, 'psychology', 'very interesting');

-- --------------------------------------------------------

--
-- Table structure for table `option`
--

DROP TABLE IF EXISTS `option`;
CREATE TABLE IF NOT EXISTS `option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option_text` varchar(45) NOT NULL,
  `is_correct` varchar(3) NOT NULL,
  `question_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `question_fk1_idx` (`question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=253 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `option`
--

INSERT INTO `option` (`id`, `option_text`, `is_correct`, `question_id`) VALUES
(211, '4', 'no', 50),
(212, '6', 'yes', 50),
(213, 'mean=0, variance=1', 'yes', 51),
(214, 'mean=1, variance=0', 'no', 51),
(215, 'mean=1, variance=1', 'no', 51),
(216, 'mean=0, variance=0', 'no', 51),
(217, 'cos(x)', 'no', 52),
(218, '-cos(x)', 'yes', 52),
(219, '(sin(x))^2', 'no', 52),
(220, 'Einstien', 'yes', 53),
(221, 'Tesla', 'no', 53),
(227, 'yes', 'no', 56),
(228, 'no', 'yes', 56),
(229, 'no', 'no', 57),
(230, 'yes', 'yes', 57),
(231, '6*(x^2)', 'no', 58),
(232, '6*(x^2)+5*x', 'no', 58),
(233, '9*(x^2)', 'yes', 58),
(234, 'The amount of energy.', 'yes', 59),
(235, 'The rotational equivalent of linear force.', 'no', 59),
(236, 'force', 'no', 60),
(237, 'impose', 'no', 60),
(238, 'drive', 'no', 60),
(239, 'lie', 'yes', 60),
(240, 'make', 'no', 60),
(241, '2/3', 'no', 61),
(242, '3', 'no', 61),
(243, '2', 'yes', 61),
(244, 'F=mass*acceleration', 'yes', 62),
(245, 'F=mass*velocity', 'no', 62),
(246, 'F=mass*(acceleration^2)', 'no', 62),
(247, 'yes', 'no', 63),
(248, 'no', 'yes', 63),
(249, 'q', 'yes', 64),
(250, 'qet', 'no', 64),
(251, 'qe', 'no', 64),
(252, 'e', 'no', 64);

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

DROP TABLE IF EXISTS `permission`;
CREATE TABLE IF NOT EXISTS `permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idpermission_UNIQUE` (`id`),
  UNIQUE KEY `permission_name_UNIQUE` (`permission_name`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`id`, `permission_name`) VALUES
(5, 'Add Material'),
(9, 'Add Question'),
(20, 'Add Role'),
(15, 'Add Test'),
(28, 'Add Test Center'),
(24, 'Add Topic'),
(1, 'Add User'),
(19, 'Ask For Test'),
(7, 'Delete Material'),
(11, 'Delete Question'),
(21, 'Delete Role'),
(16, 'Delete Test'),
(30, 'Delete Test Center'),
(26, 'Delete Topic'),
(3, 'Delete User'),
(8, 'Display Materials'),
(12, 'Display Questions'),
(23, 'Display Roles'),
(31, 'Display Test Centers'),
(18, 'Display Tests'),
(27, 'Display Topics'),
(4, 'Display Users'),
(33, 'Enter University Website'),
(13, 'See Own Results'),
(14, 'See Students Results'),
(32, 'Take Test'),
(6, 'Update Material'),
(10, 'Update Question'),
(22, 'Update Role'),
(17, 'Update Test'),
(29, 'Update Test Center'),
(25, 'Update Topic'),
(2, 'Update User');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

DROP TABLE IF EXISTS `question`;
CREATE TABLE IF NOT EXISTS `question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_text` varchar(500) NOT NULL,
  `options_number` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `question_text_UNIQUE` (`question_text`),
  KEY `fk_question_topic1_idx` (`topic_id`),
  KEY `fk_question_material1_idx` (`material_id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id`, `question_text`, `options_number`, `topic_id`, `material_id`) VALUES
(50, 'what is the area of a rectangle with height=3 and width=2 ?', 2, 34, 19),
(51, 'Normal distribution has:', 4, 33, 19),
(52, 'What is the integral of sin(x)?', 3, 31, 19),
(53, 'who is the father of relativity?', 2, 38, 25),
(56, 'is y(x)=x^2 a monotone function?', 2, 31, 19),
(57, 'Are all sides of a square equal?', 2, 34, 19),
(58, 'What is the derivative of 3*(x^3)+5 ?', 3, 31, 19),
(59, 'What is power?', 2, 39, 25),
(60, 'which of these is NOT a synonym of \"oblige\"?', 5, 42, 28),
(61, 'what is the value of x so this equation will hold: 2x+1=x+3', 3, 30, 19),
(62, 'What is Newton\'s second law of motion?', 3, 39, 25),
(63, 'can probability be greater than 1?', 2, 40, 19),
(64, 'What is the formula of propan?', 4, 37, 30);

-- --------------------------------------------------------

--
-- Table structure for table `result_file`
--

DROP TABLE IF EXISTS `result_file`;
CREATE TABLE IF NOT EXISTS `result_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `test_id` int(11) NOT NULL,
  `test_date` date NOT NULL,
  `material_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `test_center_id` int(11) NOT NULL,
  `result` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_result_file_test1_idx` (`test_id`),
  KEY `fk_result_file_material1_idx` (`material_id`),
  KEY `fk_result_file_student1_idx` (`student_id`),
  KEY `fk_result_file_test_center1_idx` (`test_center_id`)
) ENGINE=InnoDB AUTO_INCREMENT=495 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `result_file`
--

INSERT INTO `result_file` (`id`, `test_id`, `test_date`, `material_id`, `student_id`, `test_center_id`, `result`) VALUES
(481, 43, '2022-04-11', 19, 9, 9, 15),
(482, 43, '2022-04-11', 19, 9, 9, 0),
(483, 43, '2022-04-11', 19, 9, 9, 5),
(484, 43, '2022-04-11', 19, 9, 9, 5),
(485, 43, '2022-04-11', 19, 9, 9, 10),
(486, 43, '2022-04-11', 19, 9, 9, 5),
(487, 43, '2022-04-11', 19, 9, 9, 0),
(488, 43, '2022-04-11', 19, 9, 9, 5),
(489, 43, '2022-04-11', 19, 9, 9, 20),
(490, 43, '2022-04-11', 19, 9, 9, 15),
(491, 43, '2022-04-11', 19, 9, 9, 15),
(492, 43, '2022-04-11', 19, 9, 9, 20),
(493, 43, '2022-04-11', 19, 9, 9, 5);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idrole_UNIQUE` (`id`),
  UNIQUE KEY `role_name_UNIQUE` (`role_name`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `role_name`) VALUES
(1, 'Admin'),
(31, 'Secratary'),
(3, 'Student'),
(34, 'test'),
(2, 'Test Center Admin');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permission`
--

DROP TABLE IF EXISTS `role_has_permission`;
CREATE TABLE IF NOT EXISTS `role_has_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_role_has_permission_role1_idx` (`role_id`),
  KEY `fk_role_has_permission_permission1_idx` (`permission_id`)
) ENGINE=InnoDB AUTO_INCREMENT=296 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role_has_permission`
--

INSERT INTO `role_has_permission` (`id`, `role_id`, `permission_id`) VALUES
(103, 1, 5),
(104, 1, 9),
(105, 1, 20),
(106, 1, 15),
(107, 1, 28),
(108, 1, 24),
(109, 1, 1),
(110, 1, 7),
(111, 1, 11),
(112, 1, 21),
(113, 1, 16),
(114, 1, 30),
(115, 1, 26),
(116, 1, 3),
(117, 1, 8),
(118, 1, 12),
(119, 1, 23),
(120, 1, 31),
(121, 1, 18),
(122, 1, 27),
(123, 1, 4),
(124, 1, 33),
(125, 1, 6),
(126, 1, 10),
(127, 1, 22),
(128, 1, 17),
(129, 1, 29),
(130, 1, 25),
(131, 1, 2),
(138, 3, 13),
(139, 3, 32),
(140, 2, 19),
(142, 2, 14),
(290, 31, 8),
(291, 31, 33),
(292, 31, 6),
(293, 34, 5),
(294, 34, 8),
(295, 34, 33);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idstudent_UNIQUE` (`id`),
  KEY `fk_student_user1_idx` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `user_id`) VALUES
(9, 27),
(10, 31);

-- --------------------------------------------------------

--
-- Table structure for table `student_question_answer`
--

DROP TABLE IF EXISTS `student_question_answer`;
CREATE TABLE IF NOT EXISTS `student_question_answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `option_id` int(11) DEFAULT NULL,
  `result_file_id` int(11) NOT NULL,
  `creation_time` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `idquestion_answer_UNIQUE` (`id`),
  KEY `question_fk_idx` (`question_id`),
  KEY `option_fk_idx` (`option_id`),
  KEY `result_file_fk_idx` (`result_file_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1759 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

DROP TABLE IF EXISTS `test`;
CREATE TABLE IF NOT EXISTS `test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `test_name` varchar(45) NOT NULL,
  `duration` double NOT NULL,
  `questions_number` varchar(45) NOT NULL,
  `material_id` int(11) NOT NULL,
  `test_center_id` int(11) DEFAULT NULL,
  `total_grade` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `test_name_UNIQUE` (`test_name`),
  KEY `fk_test_material1_idx` (`material_id`),
  KEY `fk_test_test_center1_idx` (`test_center_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`id`, `test_name`, `duration`, `questions_number`, `material_id`, `test_center_id`, `total_grade`) VALUES
(43, 'test1', 0.01, '5', 19, 9, 25);

-- --------------------------------------------------------

--
-- Table structure for table `test_center`
--

DROP TABLE IF EXISTS `test_center`;
CREATE TABLE IF NOT EXISTS `test_center` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `center_name` varchar(45) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `test_name_UNIQUE` (`center_name`),
  KEY `fk_test_center_user1_idx` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `test_center`
--

INSERT INTO `test_center` (`id`, `center_name`, `user_id`) VALUES
(9, 'center1', 26),
(10, 'center2', 28);

-- --------------------------------------------------------

--
-- Table structure for table `test_question`
--

DROP TABLE IF EXISTS `test_question`;
CREATE TABLE IF NOT EXISTS `test_question` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `mark` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_test_question_test1_idx` (`test_id`),
  KEY `fk_test_question_question1_idx` (`question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `test_question`
--

INSERT INTO `test_question` (`id`, `mark`, `test_id`, `question_id`) VALUES
(117, 5, 43, 61),
(118, 5, 43, 52),
(119, 5, 43, 51),
(120, 5, 43, 50),
(121, 5, 43, 63);

-- --------------------------------------------------------

--
-- Table structure for table `topic`
--

DROP TABLE IF EXISTS `topic`;
CREATE TABLE IF NOT EXISTS `topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic_name` varchar(45) NOT NULL,
  `material_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idtopic_UNIQUE` (`id`),
  UNIQUE KEY `topic_name_UNIQUE` (`topic_name`),
  KEY `fk_topic_material_idx` (`material_id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `topic`
--

INSERT INTO `topic` (`id`, `topic_name`, `material_id`) VALUES
(30, 'algebra', 19),
(31, 'analysis', 19),
(32, 'waves', 25),
(33, 'statistics', 19),
(34, 'geometry', 19),
(35, 'electronics', 25),
(37, 'organic', 30),
(38, 'relativity', 25),
(39, 'mechanic', 25),
(40, 'probabilites', 19),
(42, 'reading', 28);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `password` varchar(45) NOT NULL,
  `image` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `iduser_UNIQUE` (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  UNIQUE KEY `image_UNIQUE` (`image`),
  UNIQUE KEY `phone_UNIQUE` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `email`, `phone`, `password`, `image`) VALUES
(25, 'Judy', 'Al-Ashqar', 'CHGU3355@gmail.com', NULL, 'c20ad4d76fe97759aa27a0c99bff6710', '1.jpg'),
(26, 'Nabil', 'Ali', 'nabil@gmail.com', NULL, 'c20ad4d76fe97759aa27a0c99bff6710', NULL),
(27, 'rozet', 'alwazzeh', 'rozet@gmail.com', NULL, 'c20ad4d76fe97759aa27a0c99bff6710', '3.jpg'),
(28, 'lana', 'Al-Wazzah', 'lana@gmail.com', NULL, 'c20ad4d76fe97759aa27a0c99bff6710', '2.jpg'),
(31, 'Mohammad', 'Mohammad', 'mohammad@gmail.com', '0912121212', 'c20ad4d76fe97759aa27a0c99bff6710', NULL),
(33, 'taher', 'taher', 'taher@gmail.com', NULL, 'c20ad4d76fe97759aa27a0c99bff6710', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_has_role`
--

DROP TABLE IF EXISTS `user_has_role`;
CREATE TABLE IF NOT EXISTS `user_has_role` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_has_role_role1_idx` (`role_id`),
  KEY `fk_user_has_role_user1_idx` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_has_role`
--

INSERT INTO `user_has_role` (`id`, `role_id`, `user_id`) VALUES
(17, 1, 25),
(18, 2, 26),
(19, 3, 27),
(20, 2, 28),
(23, 31, 31),
(25, 2, 33);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `option`
--
ALTER TABLE `option`
  ADD CONSTRAINT `fk_option_question1` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `fk_question_material1` FOREIGN KEY (`material_id`) REFERENCES `material` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_question_topic1` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `result_file`
--
ALTER TABLE `result_file`
  ADD CONSTRAINT `fk_result_file_material1` FOREIGN KEY (`material_id`) REFERENCES `material` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_result_file_student1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_result_file_test1` FOREIGN KEY (`test_id`) REFERENCES `test` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_result_file_test_center1` FOREIGN KEY (`test_center_id`) REFERENCES `test_center` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `role_has_permission`
--
ALTER TABLE `role_has_permission`
  ADD CONSTRAINT `fk_role_has_permission_permission1` FOREIGN KEY (`permission_id`) REFERENCES `permission` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_role_has_permission_role1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `fk_student_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `student_question_answer`
--
ALTER TABLE `student_question_answer`
  ADD CONSTRAINT `option_fk` FOREIGN KEY (`option_id`) REFERENCES `option` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `question_fk` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `result_file_fk` FOREIGN KEY (`result_file_id`) REFERENCES `result_file` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `test`
--
ALTER TABLE `test`
  ADD CONSTRAINT `fk_test_material1` FOREIGN KEY (`material_id`) REFERENCES `material` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_test_test_center1` FOREIGN KEY (`test_center_id`) REFERENCES `test_center` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `test_center`
--
ALTER TABLE `test_center`
  ADD CONSTRAINT `fk_test_center_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `test_question`
--
ALTER TABLE `test_question`
  ADD CONSTRAINT `fk_test_question_question1` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_test_question_test1` FOREIGN KEY (`test_id`) REFERENCES `test` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `topic`
--
ALTER TABLE `topic`
  ADD CONSTRAINT `fk_topic_material` FOREIGN KEY (`material_id`) REFERENCES `material` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_has_role`
--
ALTER TABLE `user_has_role`
  ADD CONSTRAINT `fk_user_has_role_role1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_has_role_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
