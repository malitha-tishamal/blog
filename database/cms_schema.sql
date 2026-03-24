-- CMS Database Schema Migration

-- Admin Users Table
CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` varchar(20) DEFAULT 'admin',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Insert default admin (username: admin, password: password123)
-- Hash generated using default PHP password_hash('password123', PASSWORD_BCRYPT)
INSERT IGNORE INTO `admin_users` (`username`, `password_hash`, `email`) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@example.com');

-- Site Settings Table
CREATE TABLE IF NOT EXISTS `site_settings` (
  `id` int NOT NULL DEFAULT 1,
  `site_name` varchar(100) NOT NULL DEFAULT 'Malitha Tishamal',
  `hero_title` varchar(255) NOT NULL DEFAULT 'Designer, Full-Stack Developer, Mobile App Developer',
  `hero_description` text,
  `contact_email` varchar(100) DEFAULT 'malithatishamal@gmail.com',
  `contact_phone1` varchar(50) DEFAULT '+94 5590992',
  `contact_phone2` varchar(50) DEFAULT '+94 1295976',
  `address` varchar(255) DEFAULT 'Denipitiya, Weligama, Sri Lanka',
  `cv_link` varchar(255) DEFAULT '#',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT IGNORE INTO `site_settings` (`id`, `hero_description`) VALUES (1, 'I create digital experiences that inspire and engage. With a passion for clean design, modern development, and innovative solutions, I transform ideas into beautiful, secure, and functional realities.');

-- About Section Table
CREATE TABLE IF NOT EXISTS `about_section` (
  `id` int NOT NULL DEFAULT 1,
  `title` varchar(255) DEFAULT 'About Me',
  `bio` text,
  `profile_image` varchar(255) DEFAULT 'assets/img/profile/profile-malitha.jpg',
  `stat_projects` int DEFAULT 15,
  `stat_experience` int DEFAULT 2,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT IGNORE INTO `about_section` (`id`, `bio`) VALUES (1, 'Hello! I’m Malitha Tishamal, a passionate developer based in Sri Lanka.');

-- Resume Entries Table
CREATE TABLE IF NOT EXISTS `resume_entries` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` enum('education','experience') NOT NULL,
  `title` varchar(255) NOT NULL,
  `organization` varchar(255) NOT NULL,
  `duration` varchar(100) NOT NULL,
  `description` text,
  `display_order` int DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Portfolio Projects Table
CREATE TABLE IF NOT EXISTS `portfolio_projects` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `short_description` text,
  `main_image` varchar(255) NOT NULL,
  `details_link` varchar(255) DEFAULT '#',
  `display_order` int DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Services Table
CREATE TABLE IF NOT EXISTS `services` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `icon_class` varchar(100) DEFAULT 'bi bi-briefcase',
  `display_order` int DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Contact Messages Table
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('unread','read') DEFAULT 'unread',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
