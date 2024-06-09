-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.21-MariaDB-log - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for vacation-manager
CREATE DATABASE IF NOT EXISTS `vacation-manager` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `vacation-manager`;

-- Dumping structure for table vacation-manager.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table vacation-manager.migrations: ~6 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2013_06_07_182957_create_roles_table', 1),
	(2, '2013_06_07_184650_create_teams_table', 1),
	(3, '2014_10_12_000000_create_users_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2024_06_07_185335_create_team_manager_table', 1),
	(6, '2024_06_07_202359_create_requests_table', 1);

-- Dumping structure for table vacation-manager.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table vacation-manager.personal_access_tokens: ~2 rows (approximately)
INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
	(1, 'App\\Models\\User', 2, 'menadzer1-AuthToken', '16901bab64d86f95600e895946513bef70bd1a987f2f38f3e8913c9b7148d014', '["*"]', '2024-06-09 08:14:23', NULL, '2024-06-08 14:27:58', '2024-06-09 08:14:23'),
	(2, 'App\\Models\\User', 4, 'korisnik1-AuthToken', '4443756294b89a1b21e56cce4bc64e1c3cc5aa1437e02a1902c2fc4fd8001805', '["*"]', '2024-06-09 08:22:41', NULL, '2024-06-09 08:20:54', '2024-06-09 08:22:41');

-- Dumping structure for table vacation-manager.requests
CREATE TABLE IF NOT EXISTS `requests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `working_days` int(11) NOT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT 1,
  `type` enum('vacation','days') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `requests_user_id_foreign` (`user_id`),
  CONSTRAINT `requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table vacation-manager.requests: ~4 rows (approximately)
INSERT INTO `requests` (`id`, `user_id`, `date_from`, `date_to`, `working_days`, `comment`, `status`, `type`, `created_at`, `updated_at`) VALUES
	(1, 4, '2024-01-10', '2024-01-20', 5, NULL, 3, 'days', '2024-06-08 14:27:55', '2024-06-09 08:22:48'),
	(2, 4, '2024-05-01', '2024-05-30', 25, NULL, 1, 'days', '2024-06-08 14:27:55', '2024-06-08 14:27:55'),
	(3, 5, '2024-06-21', '2024-06-25', 8, NULL, 1, 'vacation', '2024-06-08 14:27:55', '2024-06-08 14:27:55'),
	(4, 6, '2024-06-01', '2024-06-10', 6, NULL, 1, 'vacation', '2024-06-08 14:27:55', '2024-06-08 14:27:55');

-- Dumping structure for table vacation-manager.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table vacation-manager.roles: ~3 rows (approximately)
INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'Administrator', '2024-06-08 14:27:55', '2024-06-08 14:27:55'),
	(2, 'Menadzer', '2024-06-08 14:27:55', '2024-06-08 14:27:55'),
	(3, 'Korisnik', '2024-06-08 14:27:55', '2024-06-08 14:27:55');

-- Dumping structure for table vacation-manager.teams
CREATE TABLE IF NOT EXISTS `teams` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table vacation-manager.teams: ~2 rows (approximately)
INSERT INTO `teams` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'Team 1', '2024-06-08 14:27:55', '2024-06-08 14:27:55'),
	(2, 'Team 2', '2024-06-08 14:27:55', '2024-06-08 14:27:55');

-- Dumping structure for table vacation-manager.team_manager
CREATE TABLE IF NOT EXISTS `team_manager` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `team_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `team_manager_team_id_foreign` (`team_id`),
  KEY `team_manager_user_id_foreign` (`user_id`),
  CONSTRAINT `team_manager_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`),
  CONSTRAINT `team_manager_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table vacation-manager.team_manager: ~3 rows (approximately)
INSERT INTO `team_manager` (`id`, `team_id`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, 1, 2, NULL, NULL),
	(2, 2, 2, NULL, NULL),
	(3, 2, 3, NULL, NULL);

-- Dumping structure for table vacation-manager.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `role_id` bigint(20) unsigned NOT NULL DEFAULT 3,
  `team_id` bigint(20) unsigned DEFAULT NULL,
  `days` int(11) NOT NULL DEFAULT 5,
  `vacation` int(11) NOT NULL DEFAULT 20,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_id_foreign` (`role_id`),
  KEY `users_team_id_foreign` (`team_id`),
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  CONSTRAINT `users_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table vacation-manager.users: ~7 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `role_id`, `team_id`, `days`, `vacation`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'admin', 'admin@localhost', NULL, 1, NULL, 5, 20, '$2y$10$SCC2qztvSQDhMQ3.LLaMVObfGR/NcqUqbxLLs8FBlodBH7TvMDt9m', NULL, '2024-06-08 14:27:55', '2024-06-08 14:27:55'),
	(2, 'menadzer1', 'menadzer1@localhost', NULL, 2, NULL, 5, 20, '$2y$10$n3w3pmTCfjqgu6/Bb6ArqOhx8DzcT2D39kR5HC5nYkyKmpxcjfp3u', NULL, '2024-06-08 14:27:55', '2024-06-08 14:27:55'),
	(3, 'menadzer2', 'menadzer2@localhost', NULL, 2, NULL, 5, 20, '$2y$10$xuCD/QGSmNM9lE0P24C6cOVRzy1KNcvoFy/Mmax23Kv6pqf3jvQE.', NULL, '2024-06-08 14:27:55', '2024-06-08 14:27:55'),
	(4, 'korisnik1', 'korisnik1@localhost', NULL, 3, 1, 0, 14, '$2y$10$ADPsj7TZKkJbethCZqKoRe/oQ61.yaLolx46NCqIRJ0c7NCD16HnW', NULL, '2024-06-08 14:27:55', '2024-06-09 08:03:38'),
	(5, 'korisnik2', 'korisnik2@localhost', NULL, 3, 1, 5, 20, '$2y$10$Hx2bH0dktDVM1g1wKc4qmu5giUEQLtaq4.f.JTkVcpaiz7y4DQUVa', NULL, '2024-06-08 14:27:55', '2024-06-08 14:27:55'),
	(6, 'korisnik3', 'korisnik3@localhost', NULL, 3, 2, 5, 20, '$2y$10$jkkR4icZ6QI7uUkLkAct9uBK4HWX6ZWdckfJHKSpaphbnggkEWTGu', NULL, '2024-06-08 14:27:55', '2024-06-08 14:27:55'),
	(7, 'korisnik4', 'korisnik4@localhost', NULL, 3, 2, 5, 20, '$2y$10$1Gq1WhEJd8W5eQKf3XmQS.uZOP/mCSa1Ekwrc/6vCg8.ElrwI8Ao2', NULL, '2024-06-08 14:27:55', '2024-06-08 14:27:55');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
