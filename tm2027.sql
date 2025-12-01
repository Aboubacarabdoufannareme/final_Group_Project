-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2025 at 03:29 PM
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
-- Database: `tm2027`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `read_status` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_projects`
--

CREATE TABLE `group_projects` (
  `id` int(11) NOT NULL,
  `project_name` varchar(200) NOT NULL,
  `leader_name` varchar(100) NOT NULL,
  `num_members` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `status` enum('planning','in-progress','completed') DEFAULT 'planning',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `group_projects`
--

INSERT INTO `group_projects` (`id`, `project_name`, `leader_name`, `num_members`, `description`, `created_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Web Development Final Project', 'Test User', 4, 'Build a complete task management system with modern UI', 1, 'in-progress', '2025-11-29 20:25:16', '2025-11-29 20:25:16');

-- --------------------------------------------------------

--
-- Table structure for table `group_tasks`
--

CREATE TABLE `group_tasks` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `task_name` varchar(200) NOT NULL,
  `assigned_to` varchar(100) DEFAULT NULL,
  `status` enum('pending','in-progress','completed') DEFAULT 'pending',
  `priority` enum('low','medium','high') DEFAULT 'medium',
  `due_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `group_tasks`
--

INSERT INTO `group_tasks` (`id`, `project_id`, `task_name`, `assigned_to`, `status`, `priority`, `due_date`, `created_at`, `updated_at`) VALUES
(1, 1, 'Design UI/UX mockups', 'Malika', 'completed', 'high', '2025-01-10', '2025-11-29 20:25:59', '2025-11-29 20:25:59'),
(2, 1, 'Implement backend API', 'Moctar', 'in-progress', 'high', '2025-01-25', '2025-11-29 20:25:59', '2025-11-29 20:25:59'),
(3, 1, 'Create frontend components', 'Peter', 'in-progress', 'high', '2025-01-28', '2025-11-29 20:25:59', '2025-11-29 20:25:59'),
(4, 1, 'Write documentation', 'Fannareme', 'pending', 'medium', '2025-02-05', '2025-11-29 20:25:59', '2025-11-29 20:25:59');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `completed` tinyint(1) DEFAULT 0,
  `priority` enum('low','medium','high') DEFAULT 'medium',
  `due_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `user_id`, `title`, `description`, `completed`, `priority`, `due_date`, `created_at`, `updated_at`) VALUES
(1, 1, 'Complete Database Design', 'Design and implement the database schema for the final project', 1, 'high', '2025-01-15', '2025-11-29 20:24:41', '2025-11-29 20:24:41'),
(2, 1, 'Study for Data Structures Exam', 'Review chapters 5-8, practice coding problems', 0, 'high', '2025-02-01', '2025-11-29 20:24:41', '2025-11-29 20:24:41'),
(3, 1, 'Submit Research Proposal', 'Write and submit research proposal for capstone project', 0, 'medium', '2025-02-10', '2025-11-29 20:24:41', '2025-11-29 20:24:41'),
(4, 1, 'Team Meeting Preparation', 'Prepare slides for weekly team sync meeting', 0, 'low', '2025-01-20', '2025-11-29 20:24:41', '2025-11-29 20:24:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `created_at`, `last_login`) VALUES
(1, 'nana', 'mohamedmalika189@gmail.com', '12345678', '2025-11-29 20:24:06', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_read_status` (`read_status`);

--
-- Indexes for table `group_projects`
--
ALTER TABLE `group_projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_created_by` (`created_by`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `group_tasks`
--
ALTER TABLE `group_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_project_id` (`project_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_completed` (`completed`),
  ADD KEY `idx_due_date` (`due_date`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_projects`
--
ALTER TABLE `group_projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `group_tasks`
--
ALTER TABLE `group_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `group_projects`
--
ALTER TABLE `group_projects`
  ADD CONSTRAINT `group_projects_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `group_tasks`
--
ALTER TABLE `group_tasks`
  ADD CONSTRAINT `group_tasks_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `group_projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
