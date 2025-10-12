-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 30, 2025 at 03:30 PM
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
-- Database: `upang_feedback_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_periods`
--

CREATE TABLE `academic_periods` (
  `period_id` int(11) NOT NULL,
  `academic_year` varchar(9) NOT NULL,
  `term` enum('prelims','midterms','finals') NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `evaluation_start` date NOT NULL,
  `evaluation_end` date NOT NULL,
  `status` enum('upcoming','active','closed') DEFAULT 'upcoming',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `academic_periods`
--

INSERT INTO `academic_periods` (`period_id`, `academic_year`, `term`, `start_date`, `end_date`, `evaluation_start`, `evaluation_end`, `status`, `created_at`) VALUES
(1, '2024-2025', 'prelims', '2024-08-15', '2024-09-15', '2024-09-10', '2024-09-20', 'active', '2025-09-24 15:08:26'),
(2, '2024-2025', 'midterms', '2024-09-16', '2024-10-15', '2024-10-10', '2024-10-20', 'upcoming', '2025-09-24 15:08:26'),
(3, '2024-2025', 'finals', '2024-10-16', '2024-11-15', '2024-11-10', '2024-11-20', 'upcoming', '2025-09-24 15:08:26');

-- --------------------------------------------------------

--
-- Table structure for table `action_plans`
--

CREATE TABLE `action_plans` (
  `plan_id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `areas_for_improvement` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`areas_for_improvement`)),
  `action_items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`action_items`)),
  `target_completion` date DEFAULT NULL,
  `status` enum('draft','active','completed','cancelled') DEFAULT 'draft',
  `priority` enum('low','medium','high') DEFAULT 'medium',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `department_id` int(11) NOT NULL,
  `department_code` varchar(10) NOT NULL,
  `department_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`department_id`, `department_code`, `department_name`, `created_at`) VALUES
(1, 'CITE', 'College of Information Technology Education', '2025-09-24 14:21:51'),
(2, 'CEA', 'College of Engineering and Architecture', '2025-09-24 14:21:51');

-- --------------------------------------------------------

--
-- Table structure for table `faculty_assignments`
--

CREATE TABLE `faculty_assignments` (
  `assignment_id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `academic_year` varchar(9) NOT NULL,
  `term` enum('prelims','midterms','finals') NOT NULL,
  `block_section` varchar(20) DEFAULT NULL,
  `schedule_day` varchar(50) DEFAULT NULL,
  `schedule_time` varchar(50) DEFAULT NULL,
  `room` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty_assignments`
--

INSERT INTO `faculty_assignments` (`assignment_id`, `faculty_id`, `subject_id`, `academic_year`, `term`, `block_section`, `schedule_day`, `schedule_time`, `room`, `created_at`) VALUES
(1, 4, 1, '2024-2025', 'prelims', 'BSIT-1A', 'Monday/Wednesday', '8:00 AM - 10:00 AM', 'Room 101', '2025-09-24 15:23:41'),
(2, 4, 2, '2024-2025', 'prelims', 'BSIT-1B', 'Tuesday/Thursday', '10:00 AM - 12:00 PM', 'Room 102', '2025-09-24 15:23:41'),
(3, 4, 3, '2024-2025', 'prelims', 'BSIT-2A', 'Monday/Friday', '2:00 PM - 4:00 PM', 'Room 201', '2025-09-24 15:23:41');

-- --------------------------------------------------------

--
-- Table structure for table `feedback_comments`
--

CREATE TABLE `feedback_comments` (
  `comment_id` int(11) NOT NULL,
  `submission_id` int(11) NOT NULL,
  `comment_type` varchar(30) NOT NULL,
  `comment_text` text NOT NULL,
  `word_count` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback_keywords`
--

CREATE TABLE `feedback_keywords` (
  `keyword_id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `academic_year` varchar(9) NOT NULL,
  `term` enum('prelims','midterms','finals') NOT NULL,
  `keyword` varchar(50) NOT NULL,
  `frequency` int(11) DEFAULT 1,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback_ratings`
--

CREATE TABLE `feedback_ratings` (
  `rating_id` int(11) NOT NULL,
  `submission_id` int(11) NOT NULL,
  `criteria_name` varchar(50) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` >= 1 and `rating` <= 5)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback_submissions`
--

CREATE TABLE `feedback_submissions` (
  `submission_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL,
  `academic_year` varchar(9) NOT NULL,
  `term` enum('prelims','midterms','finals') NOT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_anonymous` tinyint(1) DEFAULT 1,
  `status` enum('submitted','processed','archived') DEFAULT 'submitted',
  `ip_address` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `recipient_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `type` enum('info','success','warning','error') DEFAULT 'info',
  `is_read` tinyint(1) DEFAULT 0,
  `action_url` varchar(200) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `read_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sentiment_analysis`
--

CREATE TABLE `sentiment_analysis` (
  `analysis_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `sentiment_score` decimal(3,2) DEFAULT NULL,
  `sentiment_label` enum('positive','neutral','negative') NOT NULL,
  `confidence_score` decimal(3,2) DEFAULT NULL,
  `key_themes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`key_themes`)),
  `processed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_enrollments`
--

CREATE TABLE `student_enrollments` (
  `enrollment_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL,
  `academic_year` varchar(9) NOT NULL,
  `term` enum('prelims','midterms','finals') NOT NULL,
  `enrollment_status` enum('enrolled','dropped','completed') DEFAULT 'enrolled',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_enrollments`
--

INSERT INTO `student_enrollments` (`enrollment_id`, `student_id`, `assignment_id`, `academic_year`, `term`, `enrollment_status`, `created_at`) VALUES
(1, 2, 1, '2024-2025', 'prelims', 'enrolled', '2025-09-24 15:24:04'),
(2, 2, 2, '2024-2025', 'prelims', 'enrolled', '2025-09-24 15:24:04');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` int(11) NOT NULL,
  `subject_code` varchar(20) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `department_id` int(11) NOT NULL,
  `units` int(11) DEFAULT 3,
  `year_level` int(11) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_name`, `department_id`, `units`, `year_level`, `status`, `created_at`) VALUES
(1, 'ITE260', 'Introduction to Programming', 1, 3, 1, 'active', '2025-09-24 15:22:41'),
(2, 'ITE031', 'Data Structures and Algorithms', 1, 3, 1, 'active', '2025-09-24 15:22:41'),
(3, 'ITE298', 'Information Management', 1, 3, 2, 'active', '2025-09-24 15:22:41'),
(4, 'ITE292', 'Networking 1', 1, 3, 2, 'active', '2025-09-24 15:22:41'),
(5, 'ITE300', 'Object Oriented Programming', 1, 3, 2, 'active', '2025-09-24 15:22:41'),
(6, 'ITE083', 'IT Project Management', 1, 3, 3, 'active', '2025-09-24 15:22:41');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `setting_id` int(11) NOT NULL,
  `setting_key` varchar(50) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `setting_type` varchar(20) DEFAULT 'string',
  `description` text DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`setting_id`, `setting_key`, `setting_value`, `setting_type`, `description`, `updated_by`, `updated_at`) VALUES
(1, 'feedback_rating_scale', '5', 'number', 'Maximum rating scale (1-5 stars)', NULL, '2025-09-24 15:07:35'),
(2, 'min_comment_length', '10', 'number', 'Minimum comment length in characters', NULL, '2025-09-24 15:07:35'),
(3, 'max_comment_length', '500', 'number', 'Maximum comment length in characters', NULL, '2025-09-24 15:07:35'),
(4, 'enable_anonymous_feedback', 'true', 'boolean', 'Allow anonymous feedback submissions', NULL, '2025-09-24 15:07:35'),
(5, 'sentiment_analysis_enabled', 'true', 'boolean', 'Enable AI sentiment analysis', NULL, '2025-09-24 15:07:35'),
(6, 'current_academic_year', '2024-2025', 'string', 'Current academic year', NULL, '2025-09-24 15:07:35'),
(7, 'current_term', 'prelims', 'string', 'Current term (prelims/midterms/finals)', NULL, '2025-09-24 15:07:35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `student_id` varchar(20) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `user_type` enum('student','faculty','department_head','admin') NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `year_level` int(11) DEFAULT NULL,
  `course` varchar(100) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `last_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `student_id`, `email`, `password_hash`, `first_name`, `last_name`, `user_type`, `department_id`, `year_level`, `course`, `status`, `created_at`, `updated_at`, `last_login`) VALUES
(1, NULL, 'admin@upang.edu.ph', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'System', 'Administrator', 'admin', NULL, NULL, NULL, 'active', '2025-09-24 14:20:15', '2025-09-24 14:20:15', NULL),
(2, NULL, 'student@upang.edu.ph', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Juan', 'Dela Cruz', 'student', NULL, NULL, NULL, 'active', '2025-09-24 14:20:58', '2025-09-24 14:20:58', NULL),
(10, 'DEPT001', 'dept@upang.edu.ph', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Maria', 'Santos', 'department_head', 1, NULL, NULL, 'active', '2025-09-24 15:17:24', '2025-09-24 15:17:24', NULL),
(11, 'FAC001', 'faculty@upang.edu.ph', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Jose', 'Rizal', 'faculty', 1, NULL, NULL, 'active', '2025-09-24 15:17:24', '2025-09-24 15:17:24', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_periods`
--
ALTER TABLE `academic_periods`
  ADD PRIMARY KEY (`period_id`),
  ADD UNIQUE KEY `unique_term` (`academic_year`,`term`);

--
-- Indexes for table `action_plans`
--
ALTER TABLE `action_plans`
  ADD PRIMARY KEY (`plan_id`),
  ADD KEY `idx_faculty` (`faculty_id`),
  ADD KEY `idx_created_by` (`created_by`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`department_id`),
  ADD UNIQUE KEY `department_code` (`department_code`);

--
-- Indexes for table `faculty_assignments`
--
ALTER TABLE `faculty_assignments`
  ADD PRIMARY KEY (`assignment_id`),
  ADD UNIQUE KEY `unique_assignment` (`faculty_id`,`subject_id`,`academic_year`,`term`,`block_section`),
  ADD KEY `idx_faculty` (`faculty_id`),
  ADD KEY `idx_subject` (`subject_id`),
  ADD KEY `idx_term` (`academic_year`,`term`);

--
-- Indexes for table `feedback_comments`
--
ALTER TABLE `feedback_comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `idx_submission` (`submission_id`);

--
-- Indexes for table `feedback_keywords`
--
ALTER TABLE `feedback_keywords`
  ADD PRIMARY KEY (`keyword_id`),
  ADD UNIQUE KEY `unique_keyword` (`faculty_id`,`subject_id`,`academic_year`,`term`,`keyword`),
  ADD KEY `idx_faculty` (`faculty_id`),
  ADD KEY `idx_subject` (`subject_id`),
  ADD KEY `idx_term` (`academic_year`,`term`);

--
-- Indexes for table `feedback_ratings`
--
ALTER TABLE `feedback_ratings`
  ADD PRIMARY KEY (`rating_id`),
  ADD UNIQUE KEY `unique_criteria_rating` (`submission_id`,`criteria_name`),
  ADD KEY `idx_submission` (`submission_id`);

--
-- Indexes for table `feedback_submissions`
--
ALTER TABLE `feedback_submissions`
  ADD PRIMARY KEY (`submission_id`),
  ADD UNIQUE KEY `unique_feedback` (`student_id`,`assignment_id`,`academic_year`,`term`),
  ADD KEY `idx_student` (`student_id`),
  ADD KEY `idx_assignment` (`assignment_id`),
  ADD KEY `idx_term` (`academic_year`,`term`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `idx_recipient` (`recipient_id`),
  ADD KEY `idx_read_status` (`is_read`);

--
-- Indexes for table `sentiment_analysis`
--
ALTER TABLE `sentiment_analysis`
  ADD PRIMARY KEY (`analysis_id`),
  ADD KEY `idx_comment` (`comment_id`),
  ADD KEY `idx_sentiment` (`sentiment_label`);

--
-- Indexes for table `student_enrollments`
--
ALTER TABLE `student_enrollments`
  ADD PRIMARY KEY (`enrollment_id`),
  ADD UNIQUE KEY `unique_enrollment` (`student_id`,`assignment_id`,`academic_year`,`term`),
  ADD KEY `idx_student` (`student_id`),
  ADD KEY `idx_assignment` (`assignment_id`),
  ADD KEY `idx_term` (`academic_year`,`term`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`),
  ADD UNIQUE KEY `subject_code` (`subject_code`),
  ADD KEY `idx_department` (`department_id`),
  ADD KEY `idx_subject_code` (`subject_code`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`setting_id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`),
  ADD KEY `idx_key` (`setting_key`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `student_id` (`student_id`),
  ADD KEY `idx_department` (`department_id`),
  ADD KEY `idx_user_type` (`user_type`),
  ADD KEY `idx_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_periods`
--
ALTER TABLE `academic_periods`
  MODIFY `period_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `action_plans`
--
ALTER TABLE `action_plans`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `faculty_assignments`
--
ALTER TABLE `faculty_assignments`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `feedback_comments`
--
ALTER TABLE `feedback_comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback_keywords`
--
ALTER TABLE `feedback_keywords`
  MODIFY `keyword_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback_ratings`
--
ALTER TABLE `feedback_ratings`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback_submissions`
--
ALTER TABLE `feedback_submissions`
  MODIFY `submission_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sentiment_analysis`
--
ALTER TABLE `sentiment_analysis`
  MODIFY `analysis_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_enrollments`
--
ALTER TABLE `student_enrollments`
  MODIFY `enrollment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `fk_subjects_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
