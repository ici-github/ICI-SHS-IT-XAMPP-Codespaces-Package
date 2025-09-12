-- MySQL Initialization Script for XAMPP-like Environment
-- This script runs when the MySQL container starts for the first time

-- Create a sample database for students
CREATE DATABASE IF NOT EXISTS `student_projects` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create a sample table in the xampp database
USE `xampp`;

CREATE TABLE IF NOT EXISTS `sample_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample data
INSERT INTO `sample_users` (`username`, `email`) VALUES
('john_doe', 'john@example.com'),
('jane_smith', 'jane@example.com'),
('student1', 'student1@school.edu'),
('teacher', 'teacher@school.edu');

-- Create additional user for students (optional)
CREATE USER IF NOT EXISTS 'student'@'%' IDENTIFIED BY 'student123';
GRANT ALL PRIVILEGES ON `student_projects`.* TO 'student'@'%';
GRANT SELECT, INSERT, UPDATE, DELETE ON `xampp`.* TO 'student'@'%';
FLUSH PRIVILEGES;

-- Display completion message
SELECT 'Database initialization completed successfully!' as 'Status';
