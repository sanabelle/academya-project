-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2024 at 07:14 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `academya`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `answer_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer_text` text NOT NULL,
  `is_correct` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`answer_id`, `question_id`, `answer_text`, `is_correct`, `created_at`) VALUES
(1, 1, 'Paris', 1, '2024-06-16 21:22:02'),
(2, 1, 'London', 0, '2024-06-16 21:22:02'),
(3, 1, 'Berlin', 0, '2024-06-16 21:22:02'),
(4, 1, 'Madrid', 0, '2024-06-16 21:22:02'),
(5, 2, '3', 0, '2024-06-16 21:22:02'),
(6, 2, '4', 1, '2024-06-16 21:22:02'),
(7, 2, '5', 0, '2024-06-16 21:22:02'),
(8, 2, '6', 0, '2024-06-16 21:22:02'),
(9, 3, 'yes', 1, '2024-06-16 21:23:25'),
(10, 3, 'no', 0, '2024-06-16 21:23:25'),
(11, 3, 'maybe yes', 0, '2024-06-16 21:23:25'),
(12, 3, 'maybe no', 0, '2024-06-16 21:23:25'),
(13, 4, 'yes', 0, '2024-06-16 21:23:51'),
(14, 4, 'no ', 1, '2024-06-16 21:23:51'),
(15, 4, 'myes', 0, '2024-06-16 21:23:51'),
(16, 4, 'mno', 0, '2024-06-16 21:23:51'),
(17, 5, 'ahmed', 1, '2024-06-19 16:01:28'),
(18, 5, 'mahmoud', 0, '2024-06-19 16:01:28'),
(19, 5, 'ahl', 0, '2024-06-19 16:01:28'),
(20, 5, 'ali', 0, '2024-06-19 16:01:28'),
(21, 6, 'ahmed', 1, '2024-06-21 00:09:16'),
(22, 6, 'aa', 0, '2024-06-21 00:09:16'),
(23, 6, 'ahm', 0, '2024-06-21 00:09:16'),
(24, 6, 'kk', 0, '2024-06-21 00:09:16'),
(25, 7, 'yes', 1, '2024-06-21 02:57:41'),
(26, 7, 'no ', 0, '2024-06-21 02:57:41'),
(27, 7, 'ye', 0, '2024-06-21 02:57:41'),
(28, 7, 'yea', 0, '2024-06-21 02:57:41'),
(29, 8, 'ahmed', 1, '2024-06-21 02:58:32'),
(30, 8, 'aa', 0, '2024-06-21 02:58:32'),
(31, 8, 'ss', 0, '2024-06-21 02:58:32'),
(32, 8, 'dd', 0, '2024-06-21 02:58:32'),
(33, 9, 'ahmed', 1, '2024-06-21 14:04:17'),
(34, 9, 'ah', 0, '2024-06-21 14:04:17'),
(35, 9, 'ah', 0, '2024-06-21 14:04:17'),
(36, 9, 'kk', 0, '2024-06-21 14:04:17');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `Course Title` varchar(50) NOT NULL,
  `Course Duration` int(11) NOT NULL,
  `Course Description` varchar(255) NOT NULL,
  `Course Price` int(11) NOT NULL,
  `Number of lessons` int(11) NOT NULL,
  `Number of Quizes` int(11) NOT NULL,
  `Tracks` varchar(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `is_progress` tinyint(1) NOT NULL,
  `instructor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`Course Title`, `Course Duration`, `Course Description`, `Course Price`, `Number of lessons`, `Number of Quizes`, `Tracks`, `course_id`, `is_progress`, `instructor_id`) VALUES
('HTML 5', 12, 'Be specific about the skills you learned on Coursera. Recruiters and hiring managers need to know exactly what functions you\'re able to perform so they can determine if you\'re a good fit for the job\r\n', 50, 35, 10, 'Frontend', 1, 0, 1),
('CSS 3', 8, 'Be specific about the skills you learned on Coursera. Recruiters and hiring managers need to know exactly what functions you\'re able to perform so they can determine if you\'re a good fit for the job\r\n', 30, 15, 5, 'Frontend', 3, 0, 1),
('Javascript', 10, 'Be specific about the skills you learned on Coursera. Recruiters and hiring managers need to know exactly what functions you\'re able to perform so they can determine if you\'re a good fit for the job\r\n', 35, 25, 5, 'Frontend', 4, 0, 1),
('PHP', 15, 'Be specific about the skills you learned on Coursera. Recruiters and hiring managers need to know exactly what functions you\'re able to perform so they can determine if you\'re a good fit for the job\r\n', 60, 50, 10, 'Backend', 5, 0, 1),
('MySQL', 20, 'Be specific about the skills you learned on Coursera. Recruiters and hiring managers need to know exactly what functions you\'re able to perform so they can determine if you\'re a good fit for the job\r\n', 70, 35, 7, 'Backend', 6, 0, 2),
('BootStrap', 13, 'Be specific about the skills you learned on Coursera. Recruiters and hiring managers need to know exactly what functions you\'re able to perform so they can determine if you\'re a good fit for the job\r\n', 40, 30, 6, 'Frontend', 7, 0, 1),
('magnific', 33, '', 82, 5, 10, 'Frontend', 8, 0, 1),
('java android', 180, '', 999, 60, 5, 'Frontend', 9, 0, 1),
('das', 5, '', 6, 5, 66, 'Frontend', 10, 0, 2),
('sda', 44, '', 44, 44, 4, 'Frontend', 11, 0, 2),
('sadkj', 56, '', 66, 6, 55, 'Frontend', 12, 0, 3),
('test today21', 55, '', 55, 5, 66, 'Backend', 13, 0, 2),
('test certificat', 10, '', 10, 1, 10, 'Frontend', 14, 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `enrolment`
--

CREATE TABLE `enrolment` (
  `enrolment_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `enrolment_datetime` int(11) NOT NULL,
  `completed_datetime` int(11) NOT NULL,
  `attendance_status` varchar(10) NOT NULL DEFAULT 'absent'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `enrolment`
--

INSERT INTO `enrolment` (`enrolment_id`, `student_id`, `course_id`, `enrolment_datetime`, `completed_datetime`, `attendance_status`) VALUES
(1, 1, 3, 1718125971, 1718125971, 'enrolled'),
(2, 1, 4, 1718125981, 1718125981, 'enrolled'),
(3, 1, 5, 1718125994, 1718125994, 'enrolled'),
(4, 1, 1, 1718126010, 1718126010, 'enrolled'),
(5, 1, 6, 1718296169, 1718296169, 'enrolled'),
(6, 1, 8, 1718760740, 1718760740, 'enrolled'),
(7, 1, 11, 1718760774, 1718760774, 'enrolled'),
(8, 1, 12, 1718812959, 0, 'enrolled'),
(9, 1, 9, 1718839385, 0, 'enrolled'),
(10, 4, 6, 1718842565, 0, 'enrolled'),
(11, 4, 7, 1718842581, 0, 'enrolled'),
(12, 4, 10, 1718927445, 0, 'enrolled'),
(13, 4, 13, 1718928576, 0, 'enrolled'),
(14, 4, 14, 1718938617, 0, 'enrolled');

-- --------------------------------------------------------

--
-- Table structure for table `instructor`
--

CREATE TABLE `instructor` (
  `instructor_email` varchar(50) NOT NULL,
  `instructor_username` varchar(50) NOT NULL,
  `instructor_password` varchar(50) NOT NULL,
  `id` int(11) NOT NULL,
  `Phone Number` int(11) NOT NULL,
  `Experence` text NOT NULL,
  `profile_photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `instructor`
--

INSERT INTO `instructor` (`instructor_email`, `instructor_username`, `instructor_password`, `id`, `Phone Number`, `Experence`, `profile_photo`) VALUES
('mahmoud@cc.com', 'Mahmoud', '123', 1, 0, '', NULL),
('moustafa@cc.com', 'Mostafa', '44', 2, 0, '', NULL),
('sad@s', 'sara', '123456', 3, 1231321231, 'dfsad', 'hdd gm.PNG'),
('hsdah@fsdafd.com', 'hesham', '123456', 4, 110456669, 'good', 'hdd gm.PNG'),
('uu@uum', 'uuu', '123', 5, 111, '222', 'Screenshot 2024-06-18 181444.png');

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `Lesson Title` varchar(50) NOT NULL,
  `Lesson Duration` int(50) NOT NULL,
  `Lesson Description` varchar(50) NOT NULL,
  `The Order of lesson` int(11) NOT NULL,
  `video_url` varchar(255) NOT NULL,
  `file_url` varchar(255) NOT NULL,
  `course_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`Lesson Title`, `Lesson Duration`, `Lesson Description`, `The Order of lesson`, `video_url`, `file_url`, `course_id`, `lesson_id`) VALUES
('magnification', 130, 'magic', 4, 'uploads/Scr', '0', 1, 1),
('First lesson', 15, 'introduction', 3, '0', '0', 2, 3),
('magnification', 150, 'test', 5, 'uploads/hdd', '0', 1, 4),
('asjdh', 56, 'dasdasda', 9, 'uploads/uef', '0', 1, 5),
('magnification', 150, 'magic', 5, 'uploads/Unt', '0', 1, 6),
('sad', 88, 'dasda', 8, 'uploads/Unt', 'uploads/uef', 4, 7),
('test 19062024', 22, 'test 19062024', 2, 'uploads/Scr', 'uploads/Scr', 12, 8),
('edited lesson', 455, 'DASDASDAS', 4, 'uploads/IMG', 'uploads/ÙƒÙ', 6, 12),
('test2', 44, 'test for viddeo and files', 4, 'uploads/Ø§Ù„Ø´ÙŠØ® Ø¹Ø¨Ø¯Ø§Ù„Ù„Ù‡ ÙƒØ§Ù…Ù„ ØªÙ„Ø§ÙˆØ© Ù…Ø§ Ø§Ø¬Ù…Ù„Ù‡Ø§ - ÙˆÙŠÙˆÙ… ÙŠÙ†ÙØ® ÙÙŠ Ø§Ù„ØµÙˆØ± ÙÙØ²Ø¹ Ù…Ù† ÙÙŠ Ø§Ù„Ø³Ù…ÙˆØ§Øª ÙˆÙ…Ù† ÙÙ‰ Ø§Ù„Ø£Ø±Ø¶ - YouTube.MP4', 'uploads/pc.xlsx', 6, 14),
('test today', 44, 'test for viddeo and files sss', 4, 'uploads/Wondershare Dr.Fone - Backup & Restore (for iOS & Android Devices).mp4', 'uploads/pc.xlsx', 13, 15),
('test today 2', 445, 'test for viddeo and files', 6, 'uploads/Wondershare Dr.Fone - Backup & Restore (for iOS & Android Devices).mp4', 'uploads/pc.xlsx', 13, 16),
('test certificate', 10, 'dasdddddddddddddd', 1, 'uploads/Ø§Ù„Ø´ÙŠØ® Ø¹Ø¨Ø¯Ø§Ù„Ù„Ù‡ ÙƒØ§Ù…Ù„ ØªÙ„Ø§ÙˆØ© Ù…Ø§ Ø§Ø¬Ù…Ù„Ù‡Ø§ - ÙˆÙŠÙˆÙ… ÙŠÙ†ÙØ® ÙÙŠ Ø§Ù„ØµÙˆØ± ÙÙØ²Ø¹ Ù…Ù† ÙÙŠ Ø§Ù„Ø³Ù…ÙˆØ§Øª ÙˆÙ…Ù† ÙÙ‰ Ø§Ù„Ø£Ø±Ø¶ - YouTube.MP4', 'uploads/Active directory (1).xlsx', 14, 17);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `receiver` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `read_status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `course_id`, `username`, `sender`, `receiver`, `content`, `created_at`, `read_status`) VALUES
(1, 6, 'Mostafa', 'Mostafa', 'Mostafa', 'das', '2024-06-19 13:58:10', 0),
(2, 6, 'ahmed', 'ahmed', 'Mostafa', 'da', '2024-06-19 13:58:28', 0),
(3, 12, 'ahmed', 'ahmed', 'sara', 'hi', '2024-06-19 16:03:24', 0),
(4, 12, 'sara', 'sara', 'sara', 'hello', '2024-06-19 16:03:43', 0),
(5, 12, 'sara', 'sara', 'sara', 'dsa', '2024-06-19 16:36:13', 0),
(6, 12, 'sara', 'sara', 'sara', 'dsa', '2024-06-19 16:41:18', 0),
(7, 13, 'Ali', 'Ali', 'Mostafa', 'hi', '2024-06-21 00:10:32', 0),
(8, 13, 'Mostafa', 'Mostafa', 'Mostafa', 'help', '2024-06-21 00:10:45', 0),
(9, 13, 'Mostafa', 'Mostafa', 'Mostafa', 'sad', '2024-06-21 00:10:49', 0);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `quiz_id`, `question_text`, `created_at`) VALUES
(1, 1, 'What is the capital of France?', '2024-06-16 21:21:30'),
(2, 1, 'What is 2 + 2?', '2024-06-16 21:21:30'),
(3, 2, 'are you busy', '2024-06-16 21:23:25'),
(4, 2, 'it be tasty', '2024-06-16 21:23:51'),
(5, 3, 'wha am i', '2024-06-19 16:01:28'),
(6, 5, 'who im i i i ', '2024-06-21 00:09:16'),
(7, 6, 'my name is ahmed', '2024-06-21 02:57:41'),
(8, 7, 'my name is ', '2024-06-21 02:58:32'),
(9, 8, 'what is my name', '2024-06-21 14:04:17');

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `quiz_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `quiz_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`quiz_id`, `lesson_id`, `quiz_name`, `created_at`) VALUES
(1, 1, 'Sample Quiz', '2024-06-16 21:20:55'),
(2, 1, 'ahmed', '2024-06-16 21:22:43'),
(3, 8, 'ahmed', '2024-06-19 16:00:14'),
(4, 55, 'TEST', '2024-06-20 01:36:32'),
(5, 15, 'test', '2024-06-21 00:08:55'),
(6, 14, 'test', '2024-06-21 02:57:23'),
(7, 17, 'testtttttt', '2024-06-21 02:58:20'),
(8, 16, 'aaa', '2024-06-21 14:04:00');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `email` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` int(50) NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`email`, `username`, `password`, `student_id`) VALUES
('ewq@das.com', 'ahmed', 22, 1),
('asd@das', 'Mohamed', 0, 3),
('dasd@dsac', 'Ali', 0, 4);

-- --------------------------------------------------------

--
-- Table structure for table `students_certificates`
--

CREATE TABLE `students_certificates` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `certificate_url` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students_certificates`
--

INSERT INTO `students_certificates` (`id`, `student_id`, `course_id`, `certificate_url`, `created_at`) VALUES
(1, 4, 14, 'certificates/4_14.pdf', '2024-06-21 12:51:01'),
(2, 4, 14, 'certificates/4_14.pdf', '2024-06-21 12:58:02'),
(3, 4, 14, 'certificates/4_14.pdf', '2024-06-21 12:59:26'),
(4, 4, 14, 'certificates/4_14.pdf', '2024-06-21 12:59:30'),
(5, 4, 14, 'certificates/4_14.pdf', '2024-06-21 13:03:20'),
(6, 4, 14, 'certificates/4_14.pdf', '2024-06-21 13:03:20'),
(7, 4, 13, 'certificates/4_13.pdf', '2024-06-21 14:16:47'),
(8, 4, 13, 'certificates/4_13.pdf', '2024-06-21 14:16:47'),
(9, 4, 13, 'certificates/4_13.pdf', '2024-06-21 14:28:18'),
(10, 4, 13, 'certificates/4_13.pdf', '2024-06-21 14:28:18'),
(11, 4, 13, 'certificates/4_13.pdf', '2024-06-21 14:28:25'),
(12, 4, 13, 'certificates/4_13.pdf', '2024-06-21 14:28:25'),
(13, 4, 13, 'certificates/4_13.pdf', '2024-06-21 14:28:46'),
(14, 4, 13, 'certificates/4_13.pdf', '2024-06-21 14:28:50'),
(15, 4, 13, 'certificates/4_13.pdf', '2024-06-21 14:29:13'),
(16, 4, 13, 'certificates/4_13.pdf', '2024-06-21 14:29:13'),
(17, 4, 13, 'certificates/4_13.pdf', '2024-06-21 15:15:34'),
(18, 4, 13, 'certificates/4_13.pdf', '2024-06-21 15:16:34'),
(19, 4, 13, 'certificates/4_13.pdf', '2024-06-21 15:19:56'),
(20, 4, 13, 'certificates/4_13.pdf', '2024-06-21 15:19:56'),
(21, 4, 13, 'certificates/4_13.pdf', '2024-06-21 15:20:23'),
(22, 4, 13, 'certificates/4_13.pdf', '2024-06-21 15:23:36'),
(23, 4, 13, 'certificates/4_13.pdf', '2024-06-21 15:23:36');

-- --------------------------------------------------------

--
-- Table structure for table `students_lesson`
--

CREATE TABLE `students_lesson` (
  `completed_datetime` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students_lesson`
--

INSERT INTO `students_lesson` (`completed_datetime`, `student_id`, `lesson_id`) VALUES
(1718979358, 4, 12),
(1718979401, 4, 15),
(1718979374, 4, 16);

-- --------------------------------------------------------

--
-- Table structure for table `students_quiz_attempts`
--

CREATE TABLE `students_quiz_attempts` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `attempted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students_quiz_attempts`
--

INSERT INTO `students_quiz_attempts` (`id`, `student_id`, `quiz_id`, `score`, `attempted_at`) VALUES
(1, 0, 1, 100, '2024-06-16 22:39:34'),
(2, 0, 1, 0, '2024-06-16 23:02:40'),
(3, 0, 1, 50, '2024-06-16 23:03:07'),
(4, 0, 1, 50, '2024-06-16 23:05:31'),
(5, 1, 1, 50, '2024-06-16 23:08:11'),
(6, 1, 1, 50, '2024-06-19 02:31:19'),
(7, 1, 1, 50, '2024-06-19 03:31:52'),
(8, 1, 1, 100, '2024-06-19 03:42:23'),
(9, 1, 1, 100, '2024-06-19 03:43:03'),
(10, 1, 1, 100, '2024-06-19 03:45:56'),
(11, 1, 1, 100, '2024-06-19 03:46:19'),
(12, 1, 3, 100, '2024-06-19 16:02:59'),
(13, 4, 5, 100, '2024-06-21 00:10:16'),
(14, 4, 7, 100, '2024-06-21 02:58:57'),
(15, 4, 5, 100, '2024-06-21 14:02:00'),
(16, 4, 8, 100, '2024-06-21 14:04:33'),
(17, 4, 6, 100, '2024-06-21 14:05:30'),
(18, 4, 5, 100, '2024-06-21 14:05:57'),
(19, 4, 8, 100, '2024-06-21 14:06:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`answer_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `enrolment`
--
ALTER TABLE `enrolment`
  ADD PRIMARY KEY (`enrolment_id`),
  ADD UNIQUE KEY `unique_enrollment` (`student_id`,`course_id`),
  ADD KEY `fk_course_enrolment` (`course_id`);

--
-- Indexes for table `instructor`
--
ALTER TABLE `instructor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`lesson_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`quiz_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `students_certificates`
--
ALTER TABLE `students_certificates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `students_lesson`
--
ALTER TABLE `students_lesson`
  ADD UNIQUE KEY `student_lesson_unique` (`student_id`,`lesson_id`);

--
-- Indexes for table `students_quiz_attempts`
--
ALTER TABLE `students_quiz_attempts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `enrolment`
--
ALTER TABLE `enrolment`
  MODIFY `enrolment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `instructor`
--
ALTER TABLE `instructor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `lesson_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `students_certificates`
--
ALTER TABLE `students_certificates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `students_quiz_attempts`
--
ALTER TABLE `students_quiz_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`question_id`) ON DELETE CASCADE;

--
-- Constraints for table `enrolment`
--
ALTER TABLE `enrolment`
  ADD CONSTRAINT `fk_course_enrolment` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_student_enrolment` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`quiz_id`) ON DELETE CASCADE;

--
-- Constraints for table `students_certificates`
--
ALTER TABLE `students_certificates`
  ADD CONSTRAINT `students_certificates_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `students_certificates_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
