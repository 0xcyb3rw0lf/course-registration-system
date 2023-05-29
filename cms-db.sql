-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2023 at 02:57 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms-db`
--

-- --------------------------------------------------------

--
-- Table structure for table `building`
--

CREATE TABLE `building` (
  `building_id` int(10) NOT NULL,
  `building_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `building`
--

INSERT INTO `building` (`building_id`, `building_name`) VALUES
(1, 'S40 - IT College'),
(2, 'S41 - Science College'),
(3, 'S50 - Khonjy');

-- --------------------------------------------------------

--
-- Table structure for table `college`
--

CREATE TABLE `college` (
  `college_id` int(10) NOT NULL,
  `college_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `college`
--

INSERT INTO `college` (`college_id`, `college_name`) VALUES
(1, 'College of Information Techonology'),
(2, 'College of Science'),
(4, 'College of Arts'),
(5, 'College of Business Administration'),
(6, 'College of Law'),
(8, 'College of Engineering');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` int(10) NOT NULL,
  `course_code` varchar(10) NOT NULL,
  `course_name` varchar(50) NOT NULL,
  `credits` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `course_code`, `course_name`, `credits`) VALUES
(1, 'ITCS389', 'SOFTWARE ENGINEERING I', 3),
(2, 'ITCS489', 'SOFTWARE ENGINEERING II', 3),
(3, 'ITCS254', 'DISCRETE STRUCTURES I', 3),
(4, 'ITCS255', 'DISCRETE STRUCTURES II', 3),
(5, 'ITSE423', 'SOFTWARE QUALITY ASSURANCE', 3),
(6, 'ITSE365', 'OBJECT ORIENTED DESIGN', 3),
(9, 'PHYCS101', 'GENERAL PHYSICS I', 4),
(10, 'PHYCS102', 'GENERAL PHYSICS II', 4),
(11, 'ITCS113', 'COMPUTER PRGORAMMING I', 3),
(12, 'ITCS114', 'COMPUTER PROGRAMMING II', 3),
(13, 'ITCS214', 'DATA STRUCTURES', 3),
(17, 'LAW101', 'CIVIL LAW I', 3),
(18, 'ITSE202', 'OOP Programming', 3);

-- --------------------------------------------------------

--
-- Table structure for table `course_prereq`
--

CREATE TABLE `course_prereq` (
  `course_id` int(10) NOT NULL,
  `prereq_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course_prereq`
--

INSERT INTO `course_prereq` (`course_id`, `prereq_id`) VALUES
(4, 3),
(2, 1),
(10, 9);

-- --------------------------------------------------------

--
-- Table structure for table `course_section`
--

CREATE TABLE `course_section` (
  `section_id` int(10) NOT NULL,
  `sem_id` int(10) NOT NULL,
  `course_id` int(10) NOT NULL,
  `Sec_num` int(3) NOT NULL,
  `professor_id` int(10) DEFAULT NULL,
  `room_id` int(10) DEFAULT NULL,
  `lec_days` varchar(3) NOT NULL,
  `lec_time` time NOT NULL,
  `capacity` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course_section`
--

INSERT INTO `course_section` (`section_id`, `sem_id`, `course_id`, `Sec_num`, `professor_id`, `room_id`, `lec_days`, `lec_time`, `capacity`) VALUES
(7, 2, 2, 6, 4, 7, 'UTH', '19:00:00', 45),
(8, 2, 1, 3, 4, 5, 'UTH', '15:00:00', 100),
(9, 2, 1, 1, 4, 7, 'UTH', '20:00:00', 45),
(10, 2, 3, 1, 4, 7, 'UTH', '21:00:00', 45),
(14, 2, 4, 1, 4, 6, 'MW', '15:00:00', 45),
(15, 2, 3, 2, 4, 5, 'MW', '13:00:00', 119),
(17, 2, 11, 1, 4, 5, 'UTH', '14:00:00', 44),
(18, 2, 1, 1, 4, 4, 'UTH', '16:00:00', 45),
(19, 2, 18, 1, 4, 11, 'UTH', '17:00:00', 0),
(20, 2, 13, 1, 4, 6, 'MW', '20:00:00', 0),
(21, 2, 6, 1, 4, 13, 'UTH', '18:00:00', 50);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `dep_id` int(10) NOT NULL,
  `dep_name` varchar(150) NOT NULL,
  `college_id` int(10) NOT NULL,
  `hod_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`dep_id`, `dep_name`, `college_id`, `hod_id`) VALUES
(1, 'Department of Computer Science', 1, 5),
(2, 'Department of Physics', 2, 7),
(3, 'Department of Computer Engineering', 1, NULL),
(4, 'Department of Information System', 1, 18),
(5, 'Department of Finance', 5, 19),
(7, 'Department of Mathematics', 2, 22);

-- --------------------------------------------------------

--
-- Table structure for table `program_college`
--

CREATE TABLE `program_college` (
  `program_id` int(10) NOT NULL,
  `college_id` int(10) DEFAULT NULL,
  `program_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `program_college`
--

INSERT INTO `program_college` (`program_id`, `college_id`, `program_name`) VALUES
(1, 1, 'Bachelor in Computer Science'),
(2, 1, 'Bachelor in Software Engineering'),
(3, 2, 'Bachelor in Physics'),
(4, 4, 'Bachelor in Arts'),
(5, 8, 'Bachelor in Mechanical Engineering'),
(8, 6, 'Bachelor in Law');

-- --------------------------------------------------------

--
-- Table structure for table `program_course`
--

CREATE TABLE `program_course` (
  `program_id` int(10) NOT NULL,
  `course_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `program_course`
--

INSERT INTO `program_course` (`program_id`, `course_id`) VALUES
(1, 1),
(1, 2),
(1, 11),
(1, 12),
(1, 13),
(2, 3),
(2, 4),
(2, 5),
(2, 6),
(2, 11),
(2, 12),
(2, 13),
(2, 18),
(3, 9),
(3, 10),
(8, 17);

-- --------------------------------------------------------

--
-- Table structure for table `registration_courses`
--

CREATE TABLE `registration_courses` (
  `sem_id` int(10) NOT NULL,
  `course_id` int(10) NOT NULL,
  `section_id` int(10) NOT NULL,
  `student_id` int(10) NOT NULL,
  `grade` decimal(5,2) DEFAULT NULL,
  `appeal_state` int(1) NOT NULL DEFAULT 0,
  `payment_status` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `registration_courses`
--

INSERT INTO `registration_courses` (`sem_id`, `course_id`, `section_id`, `student_id`, `grade`, `appeal_state`, `payment_status`) VALUES
(2, 2, 7, 3, '91.00', 2, 0),
(2, 2, 7, 9, '70.00', 0, 0),
(2, 3, 15, 3, NULL, 0, 0),
(2, 11, 17, 3, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_id` int(10) NOT NULL,
  `building_id` int(10) NOT NULL,
  `room_name` varchar(50) NOT NULL,
  `capacity` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_id`, `building_id`, `room_name`, `capacity`) VALUES
(1, 1, '1001', 45),
(2, 2, '1001', 45),
(3, 1, '1002', 45),
(4, 1, '2001', 45),
(5, 1, '2002', 45),
(6, 1, '2003', 45),
(7, 1, '2004', 45),
(8, 2, '1002', 45),
(9, 2, '2001', 45),
(10, 2, '2002', 45),
(11, 2, '2003', 45),
(12, 2, '2004', 45),
(13, 3, '1001', 500);

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `sem_id` int(10) NOT NULL,
  `sem_name` varchar(50) NOT NULL,
  `sem_status` int(1) NOT NULL DEFAULT 0,
  `appeal_start` date DEFAULT NULL,
  `appeal_end` date DEFAULT NULL,
  `reg_start` date DEFAULT NULL,
  `reg_end` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`sem_id`, `sem_name`, `sem_status`, `appeal_start`, `appeal_end`, `reg_start`, `reg_end`) VALUES
(1, '2022/2023-1', 0, NULL, NULL, NULL, NULL),
(2, '2022/2023-2', 1, '2023-05-10', '2023-05-27', '2023-05-28', '2023-05-31'),
(3, '2022/2023-S', 0, NULL, NULL, NULL, NULL),
(6, '2030/2031-1', 0, NULL, NULL, NULL, NULL),
(7, '2023/2024-1', 0, NULL, NULL, NULL, NULL),
(9, '2021/2022-1', 0, NULL, NULL, NULL, NULL),
(10, '2023/2024-S', 0, NULL, NULL, NULL, NULL),
(11, '2024/2025-1', 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `semester_course`
--

CREATE TABLE `semester_course` (
  `sem_id` int(10) NOT NULL,
  `course_id` int(10) NOT NULL,
  `exam_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `student_info`
--

CREATE TABLE `student_info` (
  `student_id` int(10) NOT NULL,
  `gpa` decimal(4,2) NOT NULL,
  `prog_id` int(10) DEFAULT NULL,
  `credits_done` int(3) NOT NULL,
  `year` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_info`
--

INSERT INTO `student_info` (`student_id`, `gpa`, `prog_id`, `credits_done`, `year`) VALUES
(3, '3.00', 2, 0, 2020),
(9, '3.50', 1, 0, 2021),
(24, '0.00', 1, 0, 2023);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) NOT NULL,
  `type_id` int(10) NOT NULL,
  `username` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `college_id` int(10) DEFAULT NULL,
  `dep_id` int(10) DEFAULT NULL,
  `gender` enum('M','F') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `type_id`, `username`, `email`, `password`, `college_id`, `dep_id`, `gender`) VALUES
(1, 0, 'admin1', 'admin1@uob.edu.bh', 'admin1', NULL, NULL, ''),
(2, 4, 'dean1', 'dean1@uob.edu.bh', 'dean1', 1, NULL, ''),
(3, 3, 'student1', 'student1@stu.uob.edu.bh', 'student1', 1, 1, ''),
(4, 1, 'professor1', 'professor1@uob.edu.bh', 'professor1', 1, 1, ''),
(5, 5, 'hod1', 'hod1@uob.edu.bh', 'hod1', 1, 1, ''),
(6, 4, 'physics-dean', 'physics-dean@uob.edu.bh', 'physics-dean', 2, NULL, ''),
(7, 5, 'hod2', 'hod2@uob.edu.bh', 'hod2', 2, 2, ''),
(8, 1, 'professor2', 'professor2@uob.edu.bh', 'professor2', 2, 2, ''),
(9, 3, 'student2', 'student2@stu.uob.edu.bh', 'student2', 1, 1, ''),
(10, 1, 'professor33', 'professor33@uob.edu.bh', 'professor33', 1, 1, 'F'),
(11, 3, 'student3', 'student3@stu.uob.edu.bh', '$2y$10$5E.2/g7DaFonXl3SJV0OteKln4DuqzwOvWpW8q4UTI5IKOt.FKyAq', 1, 1, 'F'),
(13, 4, 'arts-dean', 'arts-dean@uob.edu.bh', '$2y$10$ZW8wuhpFVpa5znYuYGSF4ectBu/pbRFD55I9I2Cz/7.FdVolweNVS', 4, NULL, 'F'),
(14, 0, 'admin2', 'admin2@uob.edu.bh', '$2y$10$EitoR7r3VhKnqk4LRgpma.lLa88.0veWGtSLdmjq0l/iHLPMfaZOu', NULL, NULL, 'M'),
(17, 5, 'cd-hod', 'ce-hod@uob.edu.bh', '$2y$10$DZXHe6bRKoE2F9YkeTduOeelXTvYUZteRHSNMQa4fCwkyFJ/Q0bhy', 1, 3, 'M'),
(18, 5, 'is-hod', 'is-hod@uob.edu.bh', '$2y$10$knrK5jHn7Gy7owkPQkhOj.XVU0uNVpG6eC2z.5m0PC4QpB2lCGoSi', 1, 4, 'F'),
(19, 5, 'finance-hod', 'finance-hod@uob.edu.bh', '$2y$10$V3beCOMwpvgpqIgraIcfaegtKI00458QOfraz37UVyqPxxgx1B/Ee', 5, 5, 'F'),
(20, 5, 'bio-hod', 'bio-hod@uob.edu.bh', '$2y$10$co921EiXNWY0j80pP25STeB8IBUFiPUIprG7pyEijkTfgzRrhBmoe', 2, NULL, 'F'),
(22, 5, 'math-hod', 'math-hod@uob.edu.bh', '$2y$10$cWFru/lpJmGhc5Vgw9Sfmu9m7aPg.qwNrtTU7AMq6dNdtaG63ADKK', 2, 7, 'M'),
(24, 3, 'student4', 'student4@stu.uob.edu.bh', '$2y$10$wjogdY6YAIenvf9lyipadecRNm51obQtDrMgP8OnvnKVAfQ1TlGZS', 1, 1, 'M');

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `type_id` int(10) NOT NULL,
  `user_type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`type_id`, `user_type`) VALUES
(0, 'admin'),
(1, 'professor'),
(3, 'student'),
(4, 'dean'),
(5, 'head of department');

-- --------------------------------------------------------

--
-- Table structure for table `wait_reqs`
--

CREATE TABLE `wait_reqs` (
  `request_id` int(10) NOT NULL,
  `sem_id` int(10) NOT NULL,
  `course_id` int(10) NOT NULL,
  `section_id` int(10) NOT NULL,
  `student_id` int(10) NOT NULL,
  `request_state` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wait_reqs`
--

INSERT INTO `wait_reqs` (`request_id`, `sem_id`, `course_id`, `section_id`, `student_id`, `request_state`) VALUES
(1, 3, 12, 15, 3, 0),
(2, 2, 4, 14, 3, 0),
(7, 2, 13, 20, 24, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `building`
--
ALTER TABLE `building`
  ADD PRIMARY KEY (`building_id`);

--
-- Indexes for table `college`
--
ALTER TABLE `college`
  ADD PRIMARY KEY (`college_id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`),
  ADD UNIQUE KEY `course_code` (`course_code`);

--
-- Indexes for table `course_prereq`
--
ALTER TABLE `course_prereq`
  ADD KEY `course_id` (`course_id`),
  ADD KEY `prereq_id` (`prereq_id`);

--
-- Indexes for table `course_section`
--
ALTER TABLE `course_section`
  ADD PRIMARY KEY (`section_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `sem_id` (`sem_id`),
  ADD KEY `professor_id` (`professor_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`dep_id`),
  ADD UNIQUE KEY `dep_name` (`dep_name`,`hod_id`),
  ADD KEY `college_id` (`college_id`),
  ADD KEY `hod_id` (`hod_id`);

--
-- Indexes for table `program_college`
--
ALTER TABLE `program_college`
  ADD PRIMARY KEY (`program_id`),
  ADD KEY `college_id` (`college_id`);

--
-- Indexes for table `program_course`
--
ALTER TABLE `program_course`
  ADD PRIMARY KEY (`program_id`,`course_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `registration_courses`
--
ALTER TABLE `registration_courses`
  ADD PRIMARY KEY (`sem_id`,`course_id`,`section_id`,`student_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `section_id` (`section_id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`),
  ADD KEY `building_id` (`building_id`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`sem_id`),
  ADD UNIQUE KEY `sem_name` (`sem_name`),
  ADD UNIQUE KEY `sem_name_2` (`sem_name`);

--
-- Indexes for table `semester_course`
--
ALTER TABLE `semester_course`
  ADD KEY `sem_id` (`sem_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `student_info`
--
ALTER TABLE `student_info`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `prog_id` (`prog_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `college_id` (`college_id`),
  ADD KEY `dep_id` (`dep_id`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `wait_reqs`
--
ALTER TABLE `wait_reqs`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `sem_id` (`sem_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `section_id` (`section_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `building`
--
ALTER TABLE `building`
  MODIFY `building_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `college`
--
ALTER TABLE `college`
  MODIFY `college_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `course_section`
--
ALTER TABLE `course_section`
  MODIFY `section_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `dep_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `program_college`
--
ALTER TABLE `program_college`
  MODIFY `program_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `sem_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `wait_reqs`
--
ALTER TABLE `wait_reqs`
  MODIFY `request_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course_prereq`
--
ALTER TABLE `course_prereq`
  ADD CONSTRAINT `course_prereq_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `course_prereq_ibfk_2` FOREIGN KEY (`prereq_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `course_section`
--
ALTER TABLE `course_section`
  ADD CONSTRAINT `course_section_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `course_section_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `room` (`room_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `course_section_ibfk_3` FOREIGN KEY (`sem_id`) REFERENCES `semester` (`sem_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `course_section_ibfk_4` FOREIGN KEY (`professor_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `department_ibfk_1` FOREIGN KEY (`college_id`) REFERENCES `college` (`college_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `program_college`
--
ALTER TABLE `program_college`
  ADD CONSTRAINT `program_college_ibfk_1` FOREIGN KEY (`college_id`) REFERENCES `college` (`college_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `program_course`
--
ALTER TABLE `program_course`
  ADD CONSTRAINT `program_course_ibfk_2` FOREIGN KEY (`program_id`) REFERENCES `program_college` (`program_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `program_course_ibfk_3` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `registration_courses`
--
ALTER TABLE `registration_courses`
  ADD CONSTRAINT `registration_courses_ibfk_1` FOREIGN KEY (`sem_id`) REFERENCES `semester` (`sem_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `registration_courses_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `registration_courses_ibfk_3` FOREIGN KEY (`student_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `registration_courses_ibfk_4` FOREIGN KEY (`section_id`) REFERENCES `course_section` (`section_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `room_ibfk_1` FOREIGN KEY (`building_id`) REFERENCES `building` (`building_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `semester_course`
--
ALTER TABLE `semester_course`
  ADD CONSTRAINT `semester_course_ibfk_1` FOREIGN KEY (`sem_id`) REFERENCES `semester` (`sem_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `semester_course_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_info`
--
ALTER TABLE `student_info`
  ADD CONSTRAINT `student_info_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_info_ibfk_2` FOREIGN KEY (`prog_id`) REFERENCES `program_college` (`program_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `user_type` (`type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`college_id`) REFERENCES `college` (`college_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `users_ibfk_3` FOREIGN KEY (`dep_id`) REFERENCES `department` (`dep_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `wait_reqs`
--
ALTER TABLE `wait_reqs`
  ADD CONSTRAINT `wait_reqs_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wait_reqs_ibfk_2` FOREIGN KEY (`sem_id`) REFERENCES `semester` (`sem_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wait_reqs_ibfk_3` FOREIGN KEY (`student_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wait_reqs_ibfk_4` FOREIGN KEY (`section_id`) REFERENCES `course_section` (`section_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
