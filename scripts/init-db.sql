-- Initialize test database with sample data
CREATE DATABASE IF NOT EXISTS test_db;
USE test_db;

-- Create a sample users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample data
INSERT IGNORE INTO users (username, email) VALUES 
('admin', 'admin@example.com'),
('student1', 'student1@example.com'),
('student2', 'student2@example.com'),
('teacher', 'teacher@example.com');

-- Create a sample posts table
CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    title VARCHAR(200) NOT NULL,
    content TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Insert sample posts
INSERT IGNORE INTO posts (user_id, title, content) VALUES 
(1, 'Welcome to XAMPP Environment', 'This is a sample post in your new development environment.'),
(2, 'First Student Post', 'Hello from student1! The environment is working great.'),
(4, 'Teacher Announcement', 'Welcome students to our new GitHub Codespaces development environment.');

-- Create additional user with xampp credentials
CREATE USER IF NOT EXISTS 'xampp'@'%' IDENTIFIED BY 'xampp';
GRANT ALL PRIVILEGES ON test_db.* TO 'xampp'@'%';
GRANT SELECT, INSERT, UPDATE, DELETE ON *.* TO 'xampp'@'%';
FLUSH PRIVILEGES;

-- Display welcome message
SELECT 'XAMPP-like Environment Database Initialized Successfully!' AS message;
