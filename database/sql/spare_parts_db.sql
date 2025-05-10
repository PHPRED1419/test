-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 25, 2025 at 06:54 AM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spare_parts_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=active, 0=inactive',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_username_unique` (`username`),
  UNIQUE KEY `admins_email_unique` (`email`),
  KEY `admins_created_by_foreign` (`created_by`),
  KEY `admins_updated_by_foreign` (`updated_by`),
  KEY `admins_deleted_by_foreign` (`deleted_by`),
  KEY `admins_first_name_index` (`first_name`),
  KEY `admins_phone_no_index` (`phone_no`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `first_name`, `last_name`, `username`, `phone_no`, `email`, `email_verified_at`, `password`, `avatar`, `designation`, `status`, `remember_token`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`) VALUES
(1, 'Admin', NULL, 'superadmin', '019XXXXXXXX', 'superadmin@example.com', NULL, '$2y$10$ejvKdI0RZCi3lpyShifNbeeTH9X3Aci.WhMqY/MSlQ7EC0VEGuZV2', 'superadmin.jpg', 'Admin', 1, '2GufDpXMn7TCv1bL60obcDLbonNWMbxfvaaSDuuNqmiBQmJnDhBIWAOPdIsz', NULL, NULL, 1, NULL, '2021-09-14 10:29:42', '2025-02-24 23:42:40'),
(2, 'Admin', '', 'admin', '018XXXXXXXX', 'admin@example.com', NULL, '$2y$10$zcG5XXjUFjIS/Y/HsRdX7.ojNl2iqXoiJ1hqlIRlzcNY.GauKVbju', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '2021-09-14 10:29:42', '2021-09-14 10:29:42'),
(3, 'Editor', '', 'editor', '017XXXXXXXX', 'editor@example.com', NULL, '$2y$10$R1Mz6Ze17jClYcaOyAZ9uehiMe09V0tzL.qpk7zslE5Q2H4R51CxG', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '2021-09-14 10:29:42', '2021-09-14 10:29:42');

-- --------------------------------------------------------

--
-- Table structure for table `article_types`
--

DROP TABLE IF EXISTS `article_types`;
CREATE TABLE IF NOT EXISTS `article_types` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `billing_information`
--

DROP TABLE IF EXISTS `billing_information`;
CREATE TABLE IF NOT EXISTS `billing_information` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `booking_request_id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_no` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_code` int UNSIGNED DEFAULT NULL,
  `billing_message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `booking_hour` double(8,2) UNSIGNED NOT NULL DEFAULT '1.00',
  `booking_subtotal` double(8,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `booking_gst` double(8,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `grand_total` double(8,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `payment_status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `billing_information_booking_request_id_index` (`booking_request_id`),
  KEY `billing_information_payment_status_index` (`payment_status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

DROP TABLE IF EXISTS `blogs`;
CREATE TABLE IF NOT EXISTS `blogs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=>active, 0=>inactive',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blogs_slug_unique` (`slug`),
  KEY `blogs_created_by_foreign` (`created_by`),
  KEY `blogs_updated_by_foreign` (`updated_by`),
  KEY `blogs_deleted_by_foreign` (`deleted_by`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `slug`, `image`, `description`, `meta_description`, `status`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`) VALUES
(1, 'This is a simple blog from admin panel', 'this-is-a-simple-blog-from-admin-panel', NULL, '<div>Welcome to our blog <br /></div>', NULL, 1, NULL, NULL, NULL, NULL, '2021-09-14 10:29:43', '2021-09-14 10:29:43'),
(2, 'This is a another blog from admin panel', 'this-is-a-another-blog-from-admin-panel', NULL, '<div>Welcome to our blog <br /></div>', NULL, 1, NULL, NULL, NULL, NULL, '2021-09-14 10:29:43', '2021-09-14 10:29:43');

-- --------------------------------------------------------

--
-- Table structure for table `booking_rates`
--

DROP TABLE IF EXISTS `booking_rates`;
CREATE TABLE IF NOT EXISTS `booking_rates` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` double(8,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_requests`
--

DROP TABLE IF EXISTS `booking_requests`;
CREATE TABLE IF NOT EXISTS `booking_requests` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_no` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_id` bigint UNSIGNED NOT NULL,
  `service_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_category_id` bigint UNSIGNED NOT NULL,
  `service_category_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `booking_rate_id` bigint UNSIGNED NOT NULL,
  `booking_rate_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `booking_rate_value` double(8,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `start_date` date NOT NULL,
  `start_time` time NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `expired_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `booking_requests_service_id_index` (`service_id`),
  KEY `booking_requests_service_category_id_index` (`service_category_id`),
  KEY `booking_requests_booking_rate_id_index` (`booking_rate_id`),
  KEY `booking_requests_status_index` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  UNIQUE KEY `cache_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = not seen by admin, 1 = seen by admin',
  `admin_id` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contacts_updated_by_foreign` (`updated_by`),
  KEY `contacts_deleted_by_foreign` (`deleted_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `flag` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `countries_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `code`, `flag`) VALUES
(1, 'United States of America', 'en', 'en.png'),
(2, 'Finland', 'fi', 'fi.png'),
(3, 'Germany', 'de', 'de.png'),
(4, 'Sweden', 'se', 'se.png'),
(5, 'Norwegian', 'no', 'no.png'),
(6, 'Greenland', 'dk', 'dk.png'),
(7, 'France', 'fr', 'fr.png'),
(8, 'Italy', 'it', 'it.png'),
(9, 'Spain', 'es', 'es.png'),
(10, 'Albanian', 'al', 'al.png'),
(11, 'Bangladesh', 'bn', 'bn.png');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
CREATE TABLE IF NOT EXISTS `languages` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `flag` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner_caption` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `languages_code_unique` (`code`),
  KEY `languages_country_id_foreign` (`country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `short_name`, `code`, `flag`, `banner`, `banner_caption`, `country`, `country_id`) VALUES
(1, 'English', 'Eng', 'en', 'en.png', NULL, NULL, 'United States of America', 1),
(2, 'Finnish', 'Finnish', 'fi', 'fi.png', NULL, NULL, 'Finland', 2),
(3, 'German', 'Deutsch', 'de', 'de.png', NULL, NULL, 'Germany', 3),
(4, 'Svenska', 'Svenska', 'se', 'se.png', NULL, NULL, 'Sweden', 4),
(5, 'Norsk', 'Norsk', 'no', 'no.png', NULL, NULL, 'Norwegian', 5),
(6, 'Dansk', 'Dansk', 'dk', 'dk.png', NULL, NULL, 'Greenland', 6),
(7, 'Francais', 'Francais', 'fr', 'fr.png', NULL, NULL, 'France', 7),
(8, 'English', 'Eng', 'it', 'it.png', NULL, NULL, 'Italy', 8),
(9, 'Italiano', 'Italiano', 'es', 'es.png', NULL, NULL, 'Spain', 9),
(10, 'Spannish', 'Espanol', 'al', 'al.png', NULL, NULL, 'Albanian', 10),
(11, 'Bangla', 'Bangla', 'bn', 'bn.png', NULL, NULL, 'Bangladesh', 11);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(2, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(3, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(4, '2016_06_01_000004_create_oauth_clients_table', 1),
(5, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(6, '2020_05_01_000000_create_admins_table', 1),
(7, '2020_05_01_0000040_create_settings_table', 1),
(8, '2020_05_01_000010_create_users_table', 1),
(9, '2020_05_01_000020_create_failed_jobs_table', 1),
(10, '2020_05_01_000030_create_password_resets_table', 1),
(11, '2020_05_01_000050_create_categories_table', 1),
(12, '2020_05_01_000060_create_pages_table', 1),
(13, '2020_05_01_000070_create_blogs_table', 1),
(14, '2020_05_01_000080_create_contacts_table', 1),
(15, '2020_05_01_000090_create_tracks_table', 1),
(16, '2021_02_03_061323_create_article_types_table', 1),
(17, '2021_02_27_184353_create_permission_tables', 1),
(18, '2021_02_27_185000_create_countries_table', 1),
(19, '2021_02_27_185728_create_languages_table', 1),
(20, '2021_08_07_071049_create_cache_table', 1),
(21, '2021_08_07_101047_create_services_table', 1),
(22, '2021_09_16_014842_create_booking_requests_table', 2),
(23, '2021_09_20_171606_create_booking_rates_table', 2),
(24, '2021_09_20_193849_create_billing_information_table', 2),
(25, '2022_11_24_143537_delete_old_settings_table', 2),
(26, '2022_11_25_143537_create_settings_table', 2),
(27, '2022_11_25_151900_create_general_settings', 2),
(28, '2022_11_25_152111_create_contact_settings', 2),
(29, '2022_11_25_152117_create_social_settings', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(2, 'App\\Models\\Admin', 1),
(4, 'App\\Models\\Admin', 1),
(2, 'App\\Models\\Admin', 2),
(3, 'App\\Models\\Admin', 3);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
CREATE TABLE IF NOT EXISTS `oauth_access_tokens` (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

DROP TABLE IF EXISTS `oauth_auth_codes`;
CREATE TABLE IF NOT EXISTS `oauth_auth_codes` (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `scopes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_auth_codes_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
CREATE TABLE IF NOT EXISTS `oauth_clients` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

DROP TABLE IF EXISTS `oauth_personal_access_clients`;
CREATE TABLE IF NOT EXISTS `oauth_personal_access_clients` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
CREATE TABLE IF NOT EXISTS `oauth_refresh_tokens` (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL COMMENT 'Null if page has no category',
  `article_type_id` bigint UNSIGNED DEFAULT NULL COMMENT 'If Article Belongs to a Type',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=>active, 0=>inactive',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pages_slug_unique` (`slug`),
  KEY `pages_created_by_foreign` (`created_by`),
  KEY `pages_updated_by_foreign` (`updated_by`),
  KEY `pages_deleted_by_foreign` (`deleted_by`),
  KEY `pages_category_id_foreign` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `slug`, `description`, `meta_description`, `image`, `banner_image`, `category_id`, `article_type_id`, `status`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`) VALUES
(1, 'About Us', 'about-us', '<div>Welcome to our about us page <br /></div>', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '2021-09-14 10:29:43', '2021-09-14 10:29:43'),
(2, 'Contact Us', 'contact-us', '<div>Welcome to our contact us page <br /></div>', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '2021-09-14 10:29:43', '2021-09-14 10:29:43');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `group_name`, `created_at`, `updated_at`) VALUES
(1, 'dashboard.view', 'admin', 'dashboard', '2021-09-14 10:29:37', '2021-09-14 10:29:37'),
(2, 'settings.view', 'admin', 'settings', '2021-09-14 10:29:37', '2021-09-14 10:29:37'),
(3, 'settings.edit', 'admin', 'settings', '2021-09-14 10:29:37', '2021-09-14 10:29:37'),
(4, 'permission.view', 'admin', 'permission', '2021-09-14 10:29:37', '2021-09-14 10:29:37'),
(5, 'permission.create', 'admin', 'permission', '2021-09-14 10:29:37', '2021-09-14 10:29:37'),
(6, 'permission.edit', 'admin', 'permission', '2021-09-14 10:29:37', '2021-09-14 10:29:37'),
(7, 'permission.delete', 'admin', 'permission', '2021-09-14 10:29:37', '2021-09-14 10:29:37'),
(8, 'admin.view', 'admin', 'admin', '2021-09-14 10:29:37', '2021-09-14 10:29:37'),
(9, 'admin.create', 'admin', 'admin', '2021-09-14 10:29:37', '2021-09-14 10:29:37'),
(10, 'admin.edit', 'admin', 'admin', '2021-09-14 10:29:37', '2021-09-14 10:29:37'),
(11, 'admin.delete', 'admin', 'admin', '2021-09-14 10:29:37', '2021-09-14 10:29:37'),
(12, 'admin_profile.view', 'admin', 'admin_profile', '2021-09-14 10:29:37', '2021-09-14 10:29:37'),
(13, 'admin_profile.edit', 'admin', 'admin_profile', '2021-09-14 10:29:37', '2021-09-14 10:29:37'),
(14, 'role.view', 'admin', 'role_manage', '2021-09-14 10:29:37', '2021-09-14 10:29:37'),
(15, 'role.create', 'admin', 'role_manage', '2021-09-14 10:29:37', '2021-09-14 10:29:37'),
(16, 'role.edit', 'admin', 'role_manage', '2021-09-14 10:29:38', '2021-09-14 10:29:38'),
(17, 'role.delete', 'admin', 'role_manage', '2021-09-14 10:29:38', '2021-09-14 10:29:38'),
(18, 'user.view', 'admin', 'user', '2021-09-14 10:29:38', '2021-09-14 10:29:38'),
(19, 'user.create', 'admin', 'user', '2021-09-14 10:29:38', '2021-09-14 10:29:38'),
(20, 'user.edit', 'admin', 'user', '2021-09-14 10:29:38', '2021-09-14 10:29:38'),
(21, 'user.delete', 'admin', 'user', '2021-09-14 10:29:38', '2021-09-14 10:29:38'),
(22, 'category.view', 'admin', 'category', '2021-09-14 10:29:38', '2021-09-14 10:29:38'),
(23, 'category.create', 'admin', 'category', '2021-09-14 10:29:38', '2021-09-14 10:29:38'),
(24, 'category.edit', 'admin', 'category', '2021-09-14 10:29:38', '2021-09-14 10:29:38'),
(25, 'category.delete', 'admin', 'category', '2021-09-14 10:29:38', '2021-09-14 10:29:38'),
(26, 'page.view', 'admin', 'page', '2021-09-14 10:29:38', '2021-09-14 10:29:38'),
(27, 'page.create', 'admin', 'page', '2021-09-14 10:29:38', '2021-09-14 10:29:38'),
(28, 'page.edit', 'admin', 'page', '2021-09-14 10:29:38', '2021-09-14 10:29:38'),
(29, 'page.delete', 'admin', 'page', '2021-09-14 10:29:38', '2021-09-14 10:29:38'),
(30, 'service.view', 'admin', 'service', '2021-09-14 10:29:38', '2021-09-14 10:29:38'),
(31, 'service.create', 'admin', 'service', '2021-09-14 10:29:38', '2021-09-14 10:29:38'),
(32, 'service.edit', 'admin', 'service', '2021-09-14 10:29:39', '2021-09-14 10:29:39'),
(33, 'service.delete', 'admin', 'service', '2021-09-14 10:29:39', '2021-09-14 10:29:39'),
(34, 'blog.view', 'admin', 'blog', '2021-09-14 10:29:39', '2021-09-14 10:29:39'),
(35, 'blog.create', 'admin', 'blog', '2021-09-14 10:29:39', '2021-09-14 10:29:39'),
(36, 'blog.edit', 'admin', 'blog', '2021-09-14 10:29:39', '2021-09-14 10:29:39'),
(37, 'blog.delete', 'admin', 'blog', '2021-09-14 10:29:39', '2021-09-14 10:29:39'),
(38, 'slider.view', 'admin', 'slider', '2021-09-14 10:29:39', '2021-09-14 10:29:39'),
(39, 'slider.create', 'admin', 'slider', '2021-09-14 10:29:40', '2021-09-14 10:29:40'),
(40, 'slider.edit', 'admin', 'slider', '2021-09-14 10:29:40', '2021-09-14 10:29:40'),
(41, 'slider.delete', 'admin', 'slider', '2021-09-14 10:29:40', '2021-09-14 10:29:40'),
(42, 'tracking.view', 'admin', 'tracking', '2021-09-14 10:29:40', '2021-09-14 10:29:40'),
(43, 'tracking.delete', 'admin', 'tracking', '2021-09-14 10:29:40', '2021-09-14 10:29:40'),
(44, 'email_notification.view', 'admin', 'notifications', '2021-09-14 10:29:40', '2021-09-14 10:29:40'),
(45, 'email_notification.edit', 'admin', 'notifications', '2021-09-14 10:29:40', '2021-09-14 10:29:40'),
(46, 'email_message.view', 'admin', 'notifications', '2021-09-14 10:29:41', '2021-09-14 10:29:41'),
(47, 'email_message.edit', 'admin', 'notifications', '2021-09-14 10:29:41', '2021-09-14 10:29:41'),
(48, 'module.view', 'admin', 'module', '2021-09-14 10:29:41', '2021-09-14 10:29:41'),
(49, 'module.create', 'admin', 'module', '2021-09-14 10:29:41', '2021-09-14 10:29:41'),
(50, 'module.edit', 'admin', 'module', '2021-09-14 10:29:41', '2021-09-14 10:29:41'),
(51, 'module.delete', 'admin', 'module', '2021-09-14 10:29:41', '2021-09-14 10:29:41'),
(52, 'module.toggle', 'admin', 'module', '2021-09-14 10:29:41', '2021-09-14 10:29:41');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Subscriber', 'admin', '2021-09-14 10:29:36', '2021-09-14 10:29:36'),
(2, 'Admin', 'admin', '2021-09-14 10:29:36', '2021-09-14 10:29:36'),
(3, 'Editor', 'admin', '2021-09-14 10:29:36', '2021-09-14 10:29:36'),
(4, 'Super Admin', 'admin', '2021-09-14 10:29:37', '2021-09-14 10:29:37');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 4),
(2, 4),
(3, 4),
(4, 4),
(5, 4),
(6, 4),
(7, 4),
(8, 4),
(9, 4),
(10, 4),
(11, 4),
(12, 4),
(13, 4),
(14, 4),
(15, 4),
(16, 4),
(17, 4),
(18, 4),
(19, 4),
(20, 4),
(21, 4),
(22, 4),
(23, 4),
(24, 4),
(25, 4),
(26, 4),
(27, 4),
(28, 4),
(29, 4),
(30, 4),
(31, 4),
(32, 4),
(33, 4),
(34, 4),
(35, 4),
(36, 4),
(37, 4),
(38, 4),
(39, 4),
(40, 4),
(41, 4),
(42, 4),
(43, 4),
(44, 4),
(45, 4),
(46, 4),
(47, 4),
(48, 4),
(49, 4),
(50, 4),
(51, 4),
(52, 4);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL COMMENT 'Null if page has no category',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=>active, 0=>inactive',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `services_slug_unique` (`slug`),
  KEY `services_created_by_foreign` (`created_by`),
  KEY `services_updated_by_foreign` (`updated_by`),
  KEY `services_deleted_by_foreign` (`deleted_by`),
  KEY `services_category_id_foreign` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `title`, `slug`, `description`, `meta_description`, `image`, `banner_image`, `category_id`, `status`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`) VALUES
(1, 'Laptop/Macbook Repair', 'laptop-macbook-repair', 'In present day time almost every individual works on the laptop, no matter you are a college student, working professional or a businessman. With technological advancements, there are many new ranges and features of laptops seen coming up on the market, but like any other electronic goods, it too needs maintenance and repair. We brings for you customized solution to repair laptops anytime around the country. Our team has enough experience at the back, and they can help repairing any simple or complex laptop problems at ease.\n                    <br />\n                    We are popular for fast and friendly service, call us anytime, and we will offer laptop services on your doorstep. We are popular because of our customer friendly attitude and quick turnaround time. Apart from that, we offer an affordable solution for all your laptop repairing services. With We, you can find all original and genuine laptop parts and accessories. Our team is reachable around the clock, and we will make sure your device is functioning in quickest possible time.\n                    <br />\n                    Many clients around the country introduce us as \"laptop specialist\" and its all because of our dedication and professional in solving all problems at ease. We are presently reputed and popular laptop repairing and accessories network in the whole of Australia. At We, we make sure that you laptop repairing experience is easy, fast and hassle free. What\'s more interesting about our services is that we have a range of utility, quality and fashionable accessories that makeover and protects your close friend – your laptop.\n                    <br />\n                    Some of our services particularly aimed at for businesses\n                    <br />\n                    <ul>\n                        <li>Desktop support – Maintenance, installation and repair.</li>\n                        <li>Software support including installation, registration and provision.</li>\n                        <li>Hardware support including provision, installation, set up and repair.</li>\n                        <li>Network system set up and configuration.</li>\n                        <li>Application support- Web apps, mobile apps, etc.</li>\n                        <li>Virus prevention, protection and removal.</li>\n                        <li>Server installation and maintenance.</li>\n                        <li>WiFi network system set up.</li>\n                    </ul>', NULL, 'service-laptop-macbook-repair.jpg', 'service-laptop-macbook-repair-banner.jpg', NULL, 1, NULL, NULL, NULL, NULL, '2021-09-14 10:29:43', '2021-09-14 10:29:43'),
(2, 'Computer Repair', 'computer-repair', 'We can repair all models and ranges of computers.\n                Call us now, and our team will provide a great solution for desktops, server, computer, smartphone, game accessories and all peripherals such as cameras, scanners, and printers. Our team responds immediately after getting your call; we will make sure your system is back to work in quickest possible time. Our team is available anytime, and we don\'t charge anything extra for nights and weekends. Our computer repairing services are based in Australia, and our geeks are all certified computer repairing professionals.\n                <br />\n                We understand the importance of computer in your life; our experts will make sure that the device is functional in quickest possible time. We assure you of all repairing services; our geeks will reach your home or business location to fix the problem. We provides a full guarantee on work, and we are known in the market for our fast and flawless computer repairing services.\n                <br />\n                Have full trust on We; our team will never let you down.', NULL, 'service-computer-repair.jpg', 'service-computer-repair-banner.jpg', NULL, 1, NULL, NULL, NULL, NULL, '2021-09-14 10:29:43', '2021-09-14 10:29:43'),
(3, 'Web Application Development', 'web-application-development', 'Services for your future web or mobile applications.\n                <br />\n\n                Our services focuses on the following things -\n                <ul>\n                    <li>Web application development</li>\n                    <li>Mobile application development</li>\n                    <li>Website Design</li>\n                    <li>Mobile App Design</li>\n                    <li>Management of business IT infrastructure.</li>\n                </ul>\n                ', NULL, 'service-web-application.jpg', 'service-web-application-banner.jpg', NULL, 1, NULL, NULL, NULL, NULL, '2021-09-14 10:29:43', '2021-09-14 10:29:43'),
(4, 'Data Backup & Recovery', 'data-backup-recovery', 'We believe in providing the best possible solution for homes as well as businesses. We always believe in meeting the need of our clients and helping them get back to work in quickest possible time. Life is completely dependent on these gadgets these days, and we strive hard to provide an affordable and quality solution for your business and home. All our geeks are skilled and trained to offer top notch services.\n                <br />\n                We believe all important data are stored in computer systems; We will assure you of data recovery, the storage set up and back up in best possible manner. Our customer data recovery and backup services are designed for home and business; call our geeks today to help you provide the best of deals. Our professionals will make sure you lever lose your precious data by backing it up. We takes up every data recovery assignment with utmost proficiency.\n                <br />\n                Here are some of the services on offer with us:\n                <br />\n                We offer data recovery services for all media devices.\n                <br />\n                <ul>\n                    <li>All our data recovery systems are confidential and secure.</li>\n                    <li>We assure you of fastest data recovery services in the country.</li>\n                    <li>Our team uses some of the best and latest technologies for data recovery.</li>\n                    <li>Apart from that our team of geeks will help you by backing up useful files for your home or office.</li>\n                </ul>\n                ', NULL, 'service-data-recovery.jpg', 'service-data-recovery-banner.jpg', NULL, 1, NULL, NULL, NULL, NULL, '2021-09-14 10:29:43', '2021-09-14 10:29:43');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `group` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `locked` tinyint(1) NOT NULL,
  `payload` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `settings_group_index` (`group`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `group`, `name`, `locked`, `payload`, `created_at`, `updated_at`) VALUES
(1, 'general', 'name', 0, '\"Motor Spare Parts\"', '2025-02-21 23:58:11', '2025-02-25 00:24:17'),
(2, 'general', 'logo', 0, '\"logo.jpg\"', '2025-02-21 23:58:11', '2025-02-25 00:24:17'),
(3, 'general', 'favicon', 0, '\"favicon.ico\"', '2025-02-21 23:58:11', '2025-02-25 00:24:17'),
(4, 'general', 'description', 0, 'null', '2025-02-21 23:58:11', '2025-02-25 00:24:17'),
(5, 'general', 'copyright_text', 0, '\"&copy;2022 all rights reserved.\"', '2025-02-21 23:58:11', '2025-02-25 00:24:17'),
(6, 'general', 'meta_keywords', 0, 'null', '2025-02-21 23:58:11', '2025-02-25 00:24:17'),
(7, 'general', 'meta_description', 0, 'null', '2025-02-21 23:58:11', '2025-02-25 00:24:17'),
(8, 'general', 'meta_author', 0, '\"WEBLINK\"', '2025-02-21 23:58:11', '2025-02-25 00:24:17'),
(9, 'contact', 'contact_no', 0, '\"+00xxxxxx\"', '2025-02-21 23:58:11', '2025-02-25 00:24:17'),
(10, 'contact', 'phone', 0, '\"+xxxx\"', '2025-02-21 23:58:11', '2025-02-25 00:24:17'),
(11, 'contact', 'email_primary', 0, '\"email@example.com\"', '2025-02-21 23:58:11', '2025-02-25 00:24:17'),
(12, 'contact', 'email_secondary', 0, 'null', '2025-02-21 23:58:11', '2025-02-25 00:24:17'),
(13, 'contact', 'address', 0, '\"xxxx\"', '2025-02-21 23:58:11', '2025-02-25 00:24:17'),
(14, 'contact', 'working_day_hours', 0, '\"xxxx\"', '2025-02-21 23:58:11', '2025-02-25 00:24:17'),
(15, 'contact', 'map_lat', 0, 'null', '2025-02-21 23:58:11', '2025-02-25 00:24:17'),
(16, 'contact', 'map_long', 0, 'null', '2025-02-21 23:58:11', '2025-02-25 00:24:17'),
(17, 'contact', 'map_zoom', 0, '\"11\"', '2025-02-21 23:58:11', '2025-02-25 00:24:17'),
(18, 'social', 'facebook', 0, '\"https://facebook.com/example\"', '2025-02-21 23:58:11', '2025-02-25 00:24:17'),
(19, 'social', 'twitter', 0, '\"https://twitter.com/example\"', '2025-02-21 23:58:11', '2025-02-25 00:24:17'),
(20, 'social', 'youtube', 0, '\"https://youtube.com/example\"', '2025-02-21 23:58:11', '2025-02-25 00:24:17'),
(21, 'social', 'linkedin', 0, '\"https://linkedin.com/example\"', '2025-02-21 23:58:11', '2025-02-25 00:24:17'),
(22, 'social', 'pinterest', 0, '\"https://pinterest.com/example\"', '2025-02-21 23:58:11', '2025-02-25 00:24:17'),
(23, 'social', 'instagram', 0, '\"https://instagram.com/example\"', '2025-02-21 23:58:11', '2025-02-25 00:24:17');

-- --------------------------------------------------------

--
-- Table structure for table `tracks`
--

DROP TABLE IF EXISTS `tracks`;
CREATE TABLE IF NOT EXISTS `tracks` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'If there is possible to keep any reference link',
  `admin_id` bigint UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tracks_deleted_by_foreign` (`deleted_by`),
  KEY `tracks_admin_id_foreign` (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tracks`
--

INSERT INTO `tracks` (`id`, `title`, `description`, `reference_link`, `admin_id`, `deleted_at`, `deleted_by`, `created_at`, `updated_at`) VALUES
(1, 'computer', 'Category has been updated successfully !!', NULL, 1, NULL, NULL, '2021-09-14 11:31:17', '2021-09-14 11:31:17'),
(2, 'application', 'Category has been updated successfully !!', NULL, 1, NULL, NULL, '2021-09-14 11:31:52', '2021-09-14 11:31:52'),
(3, 'application-development', 'Category has been updated successfully !!', NULL, 1, NULL, NULL, '2021-09-14 11:32:24', '2021-09-14 11:32:24'),
(4, 'Other', 'New Category has been created', NULL, 1, NULL, NULL, '2021-09-14 11:32:37', '2021-09-14 11:32:37'),
(5, 'application-development', 'Category has been updated successfully !!', NULL, 1, NULL, NULL, '2021-09-14 11:32:54', '2021-09-14 11:32:54'),
(6, 'Settings', 'Setting was updated.', NULL, 1, NULL, NULL, '2025-02-23 22:57:46', '2025-02-23 22:57:46'),
(7, 'Settings', 'Setting was updated.', NULL, 1, NULL, NULL, '2025-02-23 22:59:35', '2025-02-23 22:59:35'),
(8, 'Settings', 'Setting was updated.', NULL, 1, NULL, NULL, '2025-02-23 23:00:15', '2025-02-23 23:00:15'),
(9, 'superadmin', 'Admin has been updated successfully !!', NULL, 1, NULL, NULL, '2025-02-23 23:44:05', '2025-02-23 23:44:05'),
(10, 'Test Parent Cate1', 'New Category has been created', NULL, 1, NULL, NULL, '2025-02-24 02:00:42', '2025-02-24 02:00:42'),
(11, 'Test Sub Cate1', 'New Category has been created', NULL, 1, NULL, NULL, '2025-02-24 02:01:29', '2025-02-24 02:01:29'),
(12, 'test-sub-cate1', 'Category has been updated successfully !!', NULL, 1, NULL, NULL, '2025-02-24 03:46:52', '2025-02-24 03:46:52'),
(13, 'test-sub-cate1', 'Category has been updated successfully !!', NULL, 1, NULL, NULL, '2025-02-24 05:06:20', '2025-02-24 05:06:20'),
(14, 'Motor Spare Parts', 'New Category has been created', NULL, 1, NULL, NULL, '2025-02-24 05:10:10', '2025-02-24 05:10:10'),
(15, 'motor-spare-parts', 'Category has been updated successfully !!', NULL, 1, NULL, NULL, '2025-02-24 05:11:03', '2025-02-24 05:11:03'),
(16, 'superadmin', 'Admin has been updated successfully !!', NULL, 1, NULL, NULL, '2025-02-24 23:42:40', '2025-02-24 23:42:40'),
(17, 'Settings', 'Setting was updated.', NULL, 1, NULL, NULL, '2025-02-25 00:13:27', '2025-02-25 00:13:27'),
(18, 'Settings', 'Setting was updated.', NULL, 1, NULL, NULL, '2025-02-25 00:24:17', '2025-02-25 00:24:17'),
(19, 'motor-spare-parts', 'Category has been updated successfully !!', NULL, 1, NULL, NULL, '2025-02-25 00:42:49', '2025-02-25 00:42:49');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=active, 0=inactive',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `language_id` bigint UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_first_name_index` (`first_name`),
  KEY `users_phone_no_index` (`phone_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wl_categories`
--

DROP TABLE IF EXISTS `wl_categories`;
CREATE TABLE IF NOT EXISTS `wl_categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `banner_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `parent_category_id` bigint UNSIGNED DEFAULT NULL COMMENT 'Null if category is parent, else parent id',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=>active, 0=>inactive',
  `enable_bg` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=>active, 0=>inactive',
  `bg_color` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'FFFFFF',
  `text_color` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '000000',
  `priority` bigint UNSIGNED NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`),
  KEY `categories_created_by_foreign` (`created_by`),
  KEY `categories_updated_by_foreign` (`updated_by`),
  KEY `categories_deleted_by_foreign` (`deleted_by`),
  KEY `categories_parent_category_id_foreign` (`parent_category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wl_categories`
--

INSERT INTO `wl_categories` (`id`, `name`, `slug`, `banner_image`, `logo_image`, `description`, `meta_description`, `parent_category_id`, `status`, `enable_bg`, `bg_color`, `text_color`, `priority`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`) VALUES
(1, 'Application Developement', 'application-development', NULL, NULL, NULL, NULL, NULL, 1, 0, 'FFFFFF', '000000', 2, NULL, NULL, 1, NULL, '2021-09-14 10:29:43', '2021-09-14 11:32:54'),
(3, 'Computer Service', 'computer', NULL, NULL, NULL, NULL, NULL, 1, 0, 'FFFFFF', '000000', 1, NULL, NULL, 1, NULL, '2021-09-14 10:29:43', '2021-09-14 11:31:17'),
(4, 'Other', 'other', NULL, NULL, NULL, NULL, NULL, 0, 0, 'FFFFFF', '000000', 3, '2025-02-24 05:12:48', 1, NULL, 1, '2021-09-14 11:32:37', '2025-02-24 05:12:48'),
(5, 'Test Parent Cate1', 'test-parent-cate1', 'Test Parent Cate1-1740382242-banner.jpg', 'Test Parent Cate1-1740382242-logo.jpg', '<p>test</p>', 'meta desc', 3, 1, 0, 'FFFFFF', '000000', 1, NULL, 1, NULL, NULL, '2025-02-24 02:00:42', '2025-02-24 02:00:42'),
(6, 'Test Sub Cate1', 'test-sub-cate1', 'Test Sub Cate1-1740382289-banner.jpg', 'Test Sub Cate1-1740382289-logo.jpg', '<p>test</p>', NULL, 5, 1, 0, 'FFFFFF', '000000', 2, NULL, 1, 1, NULL, '2025-02-24 02:01:29', '2025-02-24 05:06:20'),
(7, 'Motor Spare Parts', 'motor-spare-parts', 'Motor Spare Parts-1740393610-banner.jpg', 'Motor Spare Parts-1740393610-logo.jpg', '<p>Test</p>', 'tested', 5, 1, 0, 'FFFFFF', '000000', 3, NULL, 1, 1, NULL, '2025-02-24 05:10:10', '2025-02-25 00:42:49');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `admins_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `admins_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blogs_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blogs_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `contacts_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `languages`
--
ALTER TABLE `languages`
  ADD CONSTRAINT `languages_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`);

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `pages_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `wl_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pages_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pages_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pages_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `wl_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `services_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `services_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `services_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tracks`
--
ALTER TABLE `tracks`
  ADD CONSTRAINT `tracks_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tracks_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wl_categories`
--
ALTER TABLE `wl_categories`
  ADD CONSTRAINT `categories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `categories_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `categories_parent_category_id_foreign` FOREIGN KEY (`parent_category_id`) REFERENCES `wl_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `categories_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
