-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 25, 2020 at 07:28 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `concierge_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Apatly Admin', 'admin@admin.com', '$2y$10$cmERFRXN0yNGTaG29BrzJ.z4ECzZqokfTtHyrMKQuKVdcRHWo4lau', '2020-10-29 07:29:12', '2020-12-03 19:09:54');

-- --------------------------------------------------------

--
-- Table structure for table `adverts`
--

CREATE TABLE `adverts` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `redirect_url` text NOT NULL,
  `instagram_url` text DEFAULT NULL,
  `image` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `adverts`
--

INSERT INTO `adverts` (`id`, `title`, `redirect_url`, `instagram_url`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'test', 'https://laravel.com/docs/7.x/validation', 'https://www.instagram.com/p/CGsfb8QpEQz/?utm_source=ig_web_copy_link', '1607598124logo12.png', 1, '2020-12-10 16:02:04', '2020-12-10 16:02:04'),
(2, 'test', 'https://laravel.com/docs/7.x/validation', 'https://www.instagram.com/p/CGsfb8QpEQz/?utm_source=ig_web_copy_link', '1607598190logo12.png', 1, '2020-12-10 16:03:10', '2020-12-10 16:03:10'),
(3, 'test', 'https://www.sensodyne.co.uk/', 'https://www.instagram.com/p/CGsfb8QpEQz/?utm_source=ig_web_copy_link', '1607598251image.png', 1, '2020-12-10 16:04:11', '2020-12-10 16:04:11');

-- --------------------------------------------------------

--
-- Table structure for table `app_users`
--

CREATE TABLE `app_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date NOT NULL,
  `member_type` enum('owner','tenant','owner_family','tenant_family','care_taker') COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `member_image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `OTP` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deviceToken` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `app_users`
--

INSERT INTO `app_users` (`id`, `company_id`, `unit_id`, `email`, `password`, `first_name`, `middle_name`, `last_name`, `gender`, `date_of_birth`, `member_type`, `address`, `city`, `country`, `zip_code`, `phone_number`, `member_image`, `OTP`, `deviceToken`, `created_at`, `updated_at`) VALUES
(1, 5, 12, 'info@producerseye.com', '$2y$10$jV2bAN75AGIPSz7ZT4soc.0wWa.hHBD5eb/iLiayo/rQ7JFNF2YPK', 'Daniel ', NULL, 'Crabb', 'male', '1970-06-11', 'owner', 'Mannings, Lewis Road Ringmer, Lewes, East Sussex, BN8 5ER ', 'East Sussex', 'UK', 'BN8 5ER', '+380154964645', NULL, NULL, NULL, '2020-11-06 01:18:12', '2020-11-06 01:18:12'),
(2, 5, 12, 'david.taylore@gmail.com', '$2y$10$RFbemUbuGqCg3Pi60pmd0eoFgzdYxA3bzlTyPMsHqN2RBRtTjhZBq', 'David', '', 'Taylor', 'male', '1980-02-11', 'tenant', 'Braboeuf, Chestnut Avenue, Guildford, Surrey, England, GU2 4HF ', 'Surrey', 'UK', 'GU2 4HF', '01132242342', NULL, NULL, NULL, '2020-11-06 01:19:23', '2020-11-06 01:19:23'),
(3, 5, 13, 'ian@yahoo.com', '$2y$10$jV2bAN75AGIPSz7ZT4soc.0wWa.hHBD5eb/iLiayo/rQ7JFNF2YPK', 'Ian', NULL, 'Egerton', 'male', '1978-06-11', 'owner', '151 Whitehall Road, Woodford Green, Essex, IG8 0RH ', 'Essex', 'UK', 'IG8 0RH ', '+380154964645', NULL, NULL, NULL, '2020-11-06 01:18:12', '2020-11-06 01:18:12'),
(4, 5, 12, 'andrew.w@gmail.com', '$2y$10$leJAU9JP1Mo71B8tC96bqe8wqBGpGDimoRNEfNVdvO7eSQiNzKYFO', 'Andrew', '', 'Weir', 'male', '1991-02-11', 'tenant', '11 Forest Road, Forest Gate, London, United Kingdom, E7 0DN ', 'London', 'UK', 'E7 0DN', '98667736', NULL, NULL, NULL, '2020-11-06 01:19:23', '2020-11-06 01:19:23'),
(5, 5, 13, 'robert.gorden@gmail.com', '$2y$10$oyquF2anMMgC/vBzAoQZmO4i53Hmco9Cpnv9MtqD.ni81S6ZpHwaS', 'Robert', 'Allan', 'Gordon', 'male', '1989-01-11', 'owner', '17 Albert Road, Ashford, Kent, England, TN24 8NY', 'Kent', 'UK', 'TN24 8NY', '0808080878', '1606567348.png', NULL, NULL, '2020-11-07 01:46:48', '2020-11-28 18:42:43'),
(6, 5, 12, 'kevin@gmail.com', '$2y$10$8EO1tKZQ8wLW34dGoopqdOCxgG4DNs61VBc.7gX7Yng4UXqfQNf62', 'Alex', NULL, 'Kevin', 'male', '1985-07-10', 'tenant', '4 Lake View Road, Sevenoaks, Kent, England', 'Kent', 'UK', 'ME1 3SD ', '766543765', NULL, NULL, NULL, '2020-11-12 03:22:55', '2020-11-12 03:22:55'),
(7, 5, 13, 'david@gmail.com', '$2y$10$3xbx7askmgLExqFJntytBuDVa1WZuhk7RS68lLGvNWumqArTHd3gK', 'David', '', 'Terry', 'male', '1960-01-11', 'owner', '106 High Street North, Stewkley, Buckinghamshire, England, LU7 0EP ', 'Buckinghamshire', 'UK', 'LU7 0EP', '987765545', NULL, NULL, 'f8zfogSRQ5qddcErdNoX4d:APA91bGBLIQ4zKw0E698_MvEzkHR2PYwRMjAUUfvwvt9YQaZJL984ylDcYU0n_CacZ4sq8n1i1cfNdf_WH4Ja6zHMyyHuM-EEf0i7HdB8GWjGDrJji4XKuk8kO0iCU_eO5a6zShXKBNX', '2020-11-17 13:24:44', '2020-12-05 16:05:09'),
(8, 5, 12, 'same@gmail.com', '$2y$10$7CuJU.Xb5m964NPPAAFyOeq1sZAwRdqkTwnFdPaTtUi2dx0uJ1iCa', 'Diane', 'mike', 'Lennan', 'male', '1970-01-01', 'owner', 'sdfdsfds', 'sdfdsf', 'sdfdsf', '4325', '0113224237', '1606567408.png', NULL, 'fkJFPBDKT46Lviebz1FDv4:APA91bHUZzlKMi1QgKSz9Xe-ylyTsbkGoywbFyusyp_-f5bg8209UlzZCvpb4Ci6n0zCci6qxzhIzdWxqHWyx4xfqjAnOF-48gX7cRkaHoMSOnjt9oNpoWwUJZ-khQCwP6sou5EPdQa9', '2020-11-24 13:35:11', '2020-12-05 19:04:00'),
(9, 9, 14, 'ravi@joykal.com', '$2y$10$3xbx7askmgLExqFJntytBuDVa1WZuhk7RS68lLGvNWumqArTHd3gK', 'Chandlar', 'P', 'Smith', 'male', '1995-09-03', 'owner_family', '11 , indranil Apartment , ahmedabad', 'Ahmedabad', 'India', '363001', '9685478528', '1606369753.png', NULL, 'en_IYp9uTpKP4uN3Vdad0e:APA91bFvp7d1yEGgEelKp_skEuf1224B6QfKY0ePO_wJoJchAcqV0Jt2EMOB3leZ7bfP5NOg9gzhMFiQESLxQseA06HyMNoEBLNjadfZsgWDKQJfcUyHcvTDhuiAl8iK5sESqPak1ljf', '2020-11-26 11:49:30', '2020-12-05 11:41:06'),
(10, 5, 13, 'ravitests@gmail.com', '$2y$10$mFmroyPAoAjvrJyWkeY/TewuqJQa7.1EPleRGU67PdVBpF0M7if5K', 'test', 'Smith', 'testt', 'male', '2010-07-12', 'owner', '11 , indranil Apartment , ahmedabad', 'Ahmedabad', 'India', '363001', '0795623741', '1607417279.png', NULL, NULL, '2020-12-08 03:18:18', '2020-12-08 04:39:47');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `person_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `landline` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `building_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `building_image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apartment_count` int(11) NOT NULL,
  `subscription_amount` double NOT NULL,
  `per_apartment_amount` double NOT NULL,
  `subscription_time` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_status` tinyint(4) NOT NULL DEFAULT 0,
  `plan_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unique_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `user_id`, `company_name`, `person_name`, `email`, `mobile`, `landline`, `building_address`, `company_address`, `building_image`, `apartment_count`, `subscription_amount`, `per_apartment_amount`, `subscription_time`, `payment_status`, `plan_id`, `unique_id`, `created_at`, `updated_at`) VALUES
(5, 6, 'London Builders Merchants Ltd', 'Johnson Kamni', 'dhaval.bera@joykal.com', '0788637074', '4474033480', 'Providence Wharf Apartments, London Bridge, London SE1 2SX, United Kingdom', '45-47 Tower Bridge Rd, Bermondsey, London SE1 4TL, United Kingdom', '1606432385.png', 123, 6150, 50, 'year', 1, '7766644486', '1231262711', '2020-11-05 02:09:38', '2020-11-27 14:54:15'),
(6, 7, 'PQR Company', 'Adam Bings', 'dhaval@gmail.com', '0113224233', '01132242243', 'maliya, junagdh\r\njunagdh', 'maliya, junagdh\r\njunagdh', NULL, 123, 6150, 50, 'quarter', 1, '8287911131', '8290619030', '2020-11-17 00:34:36', '2020-11-21 13:06:32'),
(7, 8, 'ABC Company', 'John Mark', 'dhaval123@gmail.com', '011322423422', '011322422344', 'maliya, junagdh\r\njunagdh', 'maliya, junagdh\r\njunagdh', NULL, 134, 6700, 50, 'year', 1, '2736255759', '8660094404', '2020-11-17 12:11:23', '2020-11-21 13:05:12'),
(8, 9, 'Bitex Private LTD', 'Chandlar Bings', 'chandlarbings@gmail.com', '7539638574', '8574123658', 'Test', 'Test Address', '1606558105.png', 22, 0, 50, 'quarter', 0, '3545092248', '5941270895', '2020-11-28 16:07:17', '2020-11-28 16:08:28'),
(9, 10, 'Bytex Private LTD', 'John Williams', 'ravi@joykal.com', '7956237412', '7845857496', '11 , indranil Apartment , London', '11 , indranil Apartment , London', '1607060331.png', 24, 0, 50, 'quarter', 1, '3746533874', '-438002790', '2020-12-04 10:38:54', '2020-12-04 14:21:54'),
(10, 11, 'Wordlab PVT Ltd', 'keisha mason', 'ansley@gmail.com', '0784512033', '7845957496', '11 , indranil Apartment , ahmedabad', '11 , indranil Apartment , ahmedabad', '1608269245.png', 25, 0, 50, 'month', 0, '8227731551', '1315409058', '2020-12-17 23:57:32', '2020-12-17 23:57:33');

-- --------------------------------------------------------

--
-- Table structure for table `company_settings`
--

CREATE TABLE `company_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `loyalty_card_image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_numbers` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_captions` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_settings`
--

INSERT INTO `company_settings` (`id`, `company_id`, `loyalty_card_image`, `emergency_numbers`, `emergency_captions`, `created_at`, `updated_at`) VALUES
(1, 5, '1606460848.png', '[\"9685741252\",\"9685742356\",\"979797979\"]', '[\"Police\",\"Fire\",\"Medical\"]', NULL, '2020-11-27 13:07:33'),
(2, 9, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `concierges`
--

CREATE TABLE `concierges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `gate_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date NOT NULL,
  `phone_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `concierge_image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shift_start` time NOT NULL,
  `shift_end` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `concierges`
--

INSERT INTO `concierges` (`id`, `company_id`, `gate_id`, `email`, `first_name`, `last_name`, `gender`, `date_of_birth`, `phone_number`, `concierge_image`, `address`, `city`, `state`, `country`, `zip_code`, `shift_start`, `shift_end`, `created_at`, `updated_at`) VALUES
(1, 5, 8, 'kishan@gmail.com', 'Ross', 'Moinas', 'male', '2014-01-12', '01132242342', '1606398185.png', 'maliya', 'rajkot', 'Andhra Pradesh', 'India', '380001', '16:00:00', '22:00:00', '2020-11-07 10:55:56', '2020-11-26 19:43:10'),
(2, 5, 8, 'dsdsn@gmail.com', 'john', 'Mark', 'male', '2014-01-12', '01132244382', '1606398142.png', 'maliya', 'rajkot', 'Andhra Pradesh', 'India', '380001', '08:00:00', '15:00:00', '2020-11-07 10:55:56', '2020-11-26 19:42:27'),
(5, 5, 8, 'ddddd@gmail.com', 'Jackson', 'Bariga', 'male', '2014-01-12', '7878968574', '1606398115.png', 'maliya', 'rajkot', 'Andhra Pradesh', 'India', '380001', '23:00:00', '08:00:00', '2020-11-07 10:55:56', '2020-11-26 19:41:58'),
(6, 5, 8, 'carlos@gmail.com', 'Carlos', 'Gonzalez', 'male', '1971-02-06', '0987656', '1606398078.png', 'Street road', 'London', 'd', 'UK', 'SE7 H8K', '08:00:00', '17:00:00', '2020-11-22 04:07:33', '2020-11-27 13:06:17'),
(7, 6, 9, 'ansley@gmail.com', 'Olivia', 'Ansley', 'female', '2002-01-12', '7845120356', '1606815463.png', '11 , indranil Apartment , ahmedabad', 'Ahmedabad', 'Gujarat', 'India', '363001', '15:04:00', '15:04:00', '2020-12-01 14:37:58', '2020-12-01 14:46:15');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `first_name` varchar(200) DEFAULT NULL,
  `last_name` varchar(200) DEFAULT NULL,
  `company` varchar(200) DEFAULT NULL,
  `email` varchar(200) NOT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `first_name`, `last_name`, `company`, `email`, `message`, `created_at`, `updated_at`) VALUES
(1, 'Test', 'Test', 'test Company Name', 'ansley@gmail.com', 'Test', '2020-12-03 15:39:05', '2020-12-03 15:39:05'),
(2, 'Ravi', 'Makwana', 'Betrix PVT', 'ravi78@joykal.com', 'Test Message', '2020-12-03 15:41:00', '2020-12-03 15:41:00'),
(3, 'test', 'testt', 'Olivia', 'ravi@joykal.com', 'fd', '2020-12-03 15:44:31', '2020-12-03 15:44:31'),
(4, 'testsdas', 'testt', 'fds', 'ravi@joykal.com', 'sdfds', '2020-12-03 15:46:41', '2020-12-03 15:46:41'),
(5, 'John', 'Mark', 'Brtrix PVT', 'john@gmail.com', 'Hii , This is a test message', '2020-12-03 15:48:43', '2020-12-03 15:48:43');

-- --------------------------------------------------------

--
-- Table structure for table `emergency_alarms`
--

CREATE TABLE `emergency_alarms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `emergency_alarms`
--

INSERT INTO `emergency_alarms` (`id`, `company_id`, `description`, `created_at`, `updated_at`) VALUES
(274, 5, 'Fire !!!', '2020-12-05 16:09:23', '2020-12-05 16:09:23'),
(275, 5, 'Fire !!!', '2020-12-05 17:04:27', '2020-12-05 17:04:27'),
(276, 5, 'Fire !!!', '2020-12-05 17:10:44', '2020-12-05 17:10:44'),
(277, 5, 'Fire !!!', '2020-12-05 17:19:33', '2020-12-05 17:19:33'),
(278, 5, 'Fire !!!', '2020-12-05 17:21:19', '2020-12-05 17:21:19'),
(279, 5, 'Fire !!!', '2020-12-05 17:23:59', '2020-12-05 17:23:59'),
(280, 5, 'Fire !!!', '2020-12-05 17:24:52', '2020-12-05 17:24:52'),
(281, 5, 'Fire !!!', '2020-12-05 17:26:17', '2020-12-05 17:26:17'),
(282, 5, 'Fire !!!', '2020-12-05 17:26:33', '2020-12-05 17:26:33'),
(283, 5, 'Fire !!!', '2020-12-05 17:28:03', '2020-12-05 17:28:03'),
(284, 5, 'Fire !!!', '2020-12-05 17:29:44', '2020-12-05 17:29:44'),
(285, 5, 'Fire !!!', '2020-12-05 17:29:56', '2020-12-05 17:29:56'),
(286, 5, 'Fire !!!', '2020-12-05 17:30:26', '2020-12-05 17:30:26'),
(287, 5, 'Fire !!!', '2020-12-05 17:32:48', '2020-12-05 17:32:48'),
(288, 5, 'Fire !!!', '2020-12-05 17:34:17', '2020-12-05 17:34:17'),
(289, 5, 'Fire !!!', '2020-12-05 18:04:27', '2020-12-05 18:04:27'),
(290, 5, 'Fire !!!', '2020-12-05 18:08:32', '2020-12-05 18:08:32'),
(291, 5, 'Fire !!!', '2020-12-05 18:13:13', '2020-12-05 18:13:13'),
(292, 5, 'Fire !!', '2020-12-05 18:13:46', '2020-12-05 18:13:46'),
(293, 5, 'Fire !!', '2020-12-05 18:15:35', '2020-12-05 18:15:35'),
(294, 5, 'Fire !!', '2020-12-05 18:15:39', '2020-12-05 18:15:39'),
(295, 5, 'sadadssa', '2020-12-05 18:20:05', '2020-12-05 18:20:05'),
(296, 5, 'sadadssa', '2020-12-05 18:20:50', '2020-12-05 18:20:50'),
(297, 5, 'sadadssa', '2020-12-05 18:21:33', '2020-12-05 18:21:33'),
(298, 5, 'sadadssa', '2020-12-05 18:29:22', '2020-12-05 18:29:22'),
(299, 5, 'sadadssa', '2020-12-05 18:31:20', '2020-12-05 18:31:20'),
(300, 5, 'sadadssa', '2020-12-05 18:32:10', '2020-12-05 18:32:10'),
(301, 5, 'Fire !!', '2020-12-05 19:00:56', '2020-12-05 19:00:56'),
(302, 5, 'Fire !!', '2020-12-05 19:01:25', '2020-12-05 19:01:25'),
(303, 5, 'Fire !!', '2020-12-05 19:03:25', '2020-12-05 19:03:25');

-- --------------------------------------------------------

--
-- Table structure for table `emergency_alarms_responses`
--

CREATE TABLE `emergency_alarms_responses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `alarm_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `response_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `emergency_alarms_responses`
--

INSERT INTO `emergency_alarms_responses` (`id`, `alarm_id`, `user_id`, `status`, `note`, `response_date`, `created_at`, `updated_at`) VALUES
(2422, 274, 1, 0, NULL, NULL, '2020-12-05 16:09:23', '2020-12-05 16:09:23'),
(2423, 274, 2, 0, NULL, NULL, '2020-12-05 16:09:23', '2020-12-05 16:09:23'),
(2424, 274, 3, 0, NULL, NULL, '2020-12-05 16:09:23', '2020-12-05 16:09:23'),
(2425, 274, 4, 0, NULL, NULL, '2020-12-05 16:09:23', '2020-12-05 16:09:23'),
(2426, 274, 5, 0, NULL, NULL, '2020-12-05 16:09:23', '2020-12-05 16:09:23'),
(2427, 274, 6, 0, NULL, NULL, '2020-12-05 16:09:23', '2020-12-05 16:09:23'),
(2428, 274, 7, 1, '', '2020-12-05 11:09:55', '2020-12-05 16:09:23', '2020-12-05 16:09:55'),
(2429, 274, 8, 0, NULL, NULL, '2020-12-05 16:09:23', '2020-12-05 16:09:23'),
(2430, 274, 9, 0, NULL, NULL, '2020-12-05 16:09:23', '2020-12-05 16:09:23'),
(2431, 275, 1, 0, NULL, NULL, '2020-12-05 17:04:27', '2020-12-05 17:04:27'),
(2432, 275, 2, 0, NULL, NULL, '2020-12-05 17:04:27', '2020-12-05 17:04:27'),
(2433, 275, 3, 0, NULL, NULL, '2020-12-05 17:04:27', '2020-12-05 17:04:27'),
(2434, 275, 4, 0, NULL, NULL, '2020-12-05 17:04:27', '2020-12-05 17:04:27'),
(2435, 275, 5, 0, NULL, NULL, '2020-12-05 17:04:27', '2020-12-05 17:04:27'),
(2436, 275, 6, 0, NULL, NULL, '2020-12-05 17:04:27', '2020-12-05 17:04:27'),
(2437, 275, 7, 0, NULL, NULL, '2020-12-05 17:04:27', '2020-12-05 17:04:27'),
(2438, 275, 8, 0, NULL, NULL, '2020-12-05 17:04:27', '2020-12-05 17:04:27'),
(2439, 275, 9, 0, NULL, NULL, '2020-12-05 17:04:27', '2020-12-05 17:04:27'),
(2440, 276, 1, 0, NULL, NULL, '2020-12-05 17:10:44', '2020-12-05 17:10:44'),
(2441, 276, 2, 0, NULL, NULL, '2020-12-05 17:10:44', '2020-12-05 17:10:44'),
(2442, 276, 3, 0, NULL, NULL, '2020-12-05 17:10:44', '2020-12-05 17:10:44'),
(2443, 276, 4, 0, NULL, NULL, '2020-12-05 17:10:44', '2020-12-05 17:10:44'),
(2444, 276, 5, 0, NULL, NULL, '2020-12-05 17:10:44', '2020-12-05 17:10:44'),
(2445, 276, 6, 0, NULL, NULL, '2020-12-05 17:10:44', '2020-12-05 17:10:44'),
(2446, 276, 7, 0, NULL, NULL, '2020-12-05 17:10:44', '2020-12-05 17:10:44'),
(2447, 276, 8, 1, '', '2020-12-05 12:16:23', '2020-12-05 17:10:44', '2020-12-05 17:16:23'),
(2448, 276, 9, 0, NULL, NULL, '2020-12-05 17:10:44', '2020-12-05 17:10:44'),
(2449, 277, 1, 0, NULL, NULL, '2020-12-05 17:19:33', '2020-12-05 17:19:33'),
(2450, 277, 2, 0, NULL, NULL, '2020-12-05 17:19:33', '2020-12-05 17:19:33'),
(2451, 277, 3, 0, NULL, NULL, '2020-12-05 17:19:33', '2020-12-05 17:19:33'),
(2452, 277, 4, 0, NULL, NULL, '2020-12-05 17:19:33', '2020-12-05 17:19:33'),
(2453, 277, 5, 0, NULL, NULL, '2020-12-05 17:19:33', '2020-12-05 17:19:33'),
(2454, 277, 6, 0, NULL, NULL, '2020-12-05 17:19:33', '2020-12-05 17:19:33'),
(2455, 277, 7, 0, NULL, NULL, '2020-12-05 17:19:33', '2020-12-05 17:19:33'),
(2456, 277, 8, 0, NULL, NULL, '2020-12-05 17:19:33', '2020-12-05 17:19:33'),
(2457, 277, 9, 0, NULL, NULL, '2020-12-05 17:19:33', '2020-12-05 17:19:33'),
(2458, 278, 1, 0, NULL, NULL, '2020-12-05 17:21:19', '2020-12-05 17:21:19'),
(2459, 278, 2, 0, NULL, NULL, '2020-12-05 17:21:19', '2020-12-05 17:21:19'),
(2460, 278, 3, 0, NULL, NULL, '2020-12-05 17:21:19', '2020-12-05 17:21:19'),
(2461, 278, 4, 0, NULL, NULL, '2020-12-05 17:21:19', '2020-12-05 17:21:19'),
(2462, 278, 5, 0, NULL, NULL, '2020-12-05 17:21:19', '2020-12-05 17:21:19'),
(2463, 278, 6, 0, NULL, NULL, '2020-12-05 17:21:19', '2020-12-05 17:21:19'),
(2464, 278, 7, 0, NULL, NULL, '2020-12-05 17:21:19', '2020-12-05 17:21:19'),
(2465, 278, 8, 0, NULL, NULL, '2020-12-05 17:21:19', '2020-12-05 17:21:19'),
(2466, 278, 9, 0, NULL, NULL, '2020-12-05 17:21:19', '2020-12-05 17:21:19'),
(2467, 279, 1, 0, NULL, NULL, '2020-12-05 17:23:59', '2020-12-05 17:23:59'),
(2468, 279, 2, 0, NULL, NULL, '2020-12-05 17:23:59', '2020-12-05 17:23:59'),
(2469, 279, 3, 0, NULL, NULL, '2020-12-05 17:23:59', '2020-12-05 17:23:59'),
(2470, 279, 4, 0, NULL, NULL, '2020-12-05 17:23:59', '2020-12-05 17:23:59'),
(2471, 279, 5, 0, NULL, NULL, '2020-12-05 17:23:59', '2020-12-05 17:23:59'),
(2472, 279, 6, 0, NULL, NULL, '2020-12-05 17:23:59', '2020-12-05 17:23:59'),
(2473, 279, 7, 0, NULL, NULL, '2020-12-05 17:23:59', '2020-12-05 17:23:59'),
(2474, 279, 8, 0, NULL, NULL, '2020-12-05 17:23:59', '2020-12-05 17:23:59'),
(2475, 279, 9, 0, NULL, NULL, '2020-12-05 17:23:59', '2020-12-05 17:23:59'),
(2476, 280, 1, 0, NULL, NULL, '2020-12-05 17:24:52', '2020-12-05 17:24:52'),
(2477, 280, 2, 0, NULL, NULL, '2020-12-05 17:24:52', '2020-12-05 17:24:52'),
(2478, 280, 3, 0, NULL, NULL, '2020-12-05 17:24:52', '2020-12-05 17:24:52'),
(2479, 280, 4, 0, NULL, NULL, '2020-12-05 17:24:52', '2020-12-05 17:24:52'),
(2480, 280, 5, 0, NULL, NULL, '2020-12-05 17:24:52', '2020-12-05 17:24:52'),
(2481, 280, 6, 0, NULL, NULL, '2020-12-05 17:24:52', '2020-12-05 17:24:52'),
(2482, 280, 7, 0, NULL, NULL, '2020-12-05 17:24:52', '2020-12-05 17:24:52'),
(2483, 280, 8, 0, NULL, NULL, '2020-12-05 17:24:52', '2020-12-05 17:24:52'),
(2484, 280, 9, 0, NULL, NULL, '2020-12-05 17:24:52', '2020-12-05 17:24:52'),
(2485, 281, 1, 0, NULL, NULL, '2020-12-05 17:26:17', '2020-12-05 17:26:17'),
(2486, 281, 2, 0, NULL, NULL, '2020-12-05 17:26:17', '2020-12-05 17:26:17'),
(2487, 281, 3, 0, NULL, NULL, '2020-12-05 17:26:17', '2020-12-05 17:26:17'),
(2488, 281, 4, 0, NULL, NULL, '2020-12-05 17:26:17', '2020-12-05 17:26:17'),
(2489, 281, 5, 0, NULL, NULL, '2020-12-05 17:26:17', '2020-12-05 17:26:17'),
(2490, 281, 6, 0, NULL, NULL, '2020-12-05 17:26:17', '2020-12-05 17:26:17'),
(2491, 281, 7, 0, NULL, NULL, '2020-12-05 17:26:17', '2020-12-05 17:26:17'),
(2492, 281, 8, 0, NULL, NULL, '2020-12-05 17:26:17', '2020-12-05 17:26:17'),
(2493, 281, 9, 0, NULL, NULL, '2020-12-05 17:26:17', '2020-12-05 17:26:17'),
(2494, 282, 1, 0, NULL, NULL, '2020-12-05 17:26:33', '2020-12-05 17:26:33'),
(2495, 282, 2, 0, NULL, NULL, '2020-12-05 17:26:33', '2020-12-05 17:26:33'),
(2496, 282, 3, 0, NULL, NULL, '2020-12-05 17:26:33', '2020-12-05 17:26:33'),
(2497, 282, 4, 0, NULL, NULL, '2020-12-05 17:26:33', '2020-12-05 17:26:33'),
(2498, 282, 5, 0, NULL, NULL, '2020-12-05 17:26:33', '2020-12-05 17:26:33'),
(2499, 282, 6, 0, NULL, NULL, '2020-12-05 17:26:33', '2020-12-05 17:26:33'),
(2500, 282, 7, 0, NULL, NULL, '2020-12-05 17:26:33', '2020-12-05 17:26:33'),
(2501, 282, 8, 0, NULL, NULL, '2020-12-05 17:26:33', '2020-12-05 17:26:33'),
(2502, 282, 9, 0, NULL, NULL, '2020-12-05 17:26:33', '2020-12-05 17:26:33'),
(2503, 283, 1, 0, NULL, NULL, '2020-12-05 17:28:03', '2020-12-05 17:28:03'),
(2504, 283, 2, 0, NULL, NULL, '2020-12-05 17:28:03', '2020-12-05 17:28:03'),
(2505, 283, 3, 0, NULL, NULL, '2020-12-05 17:28:03', '2020-12-05 17:28:03'),
(2506, 283, 4, 0, NULL, NULL, '2020-12-05 17:28:03', '2020-12-05 17:28:03'),
(2507, 283, 5, 0, NULL, NULL, '2020-12-05 17:28:03', '2020-12-05 17:28:03'),
(2508, 283, 6, 0, NULL, NULL, '2020-12-05 17:28:03', '2020-12-05 17:28:03'),
(2509, 283, 7, 0, NULL, NULL, '2020-12-05 17:28:03', '2020-12-05 17:28:03'),
(2510, 283, 8, 0, NULL, NULL, '2020-12-05 17:28:03', '2020-12-05 17:28:03'),
(2511, 283, 9, 0, NULL, NULL, '2020-12-05 17:28:03', '2020-12-05 17:28:03'),
(2512, 284, 1, 0, NULL, NULL, '2020-12-05 17:29:44', '2020-12-05 17:29:44'),
(2513, 284, 2, 0, NULL, NULL, '2020-12-05 17:29:44', '2020-12-05 17:29:44'),
(2514, 284, 3, 0, NULL, NULL, '2020-12-05 17:29:44', '2020-12-05 17:29:44'),
(2515, 284, 4, 0, NULL, NULL, '2020-12-05 17:29:44', '2020-12-05 17:29:44'),
(2516, 284, 5, 0, NULL, NULL, '2020-12-05 17:29:44', '2020-12-05 17:29:44'),
(2517, 284, 6, 0, NULL, NULL, '2020-12-05 17:29:44', '2020-12-05 17:29:44'),
(2518, 284, 7, 0, NULL, NULL, '2020-12-05 17:29:44', '2020-12-05 17:29:44'),
(2519, 284, 8, 0, NULL, NULL, '2020-12-05 17:29:44', '2020-12-05 17:29:44'),
(2520, 284, 9, 0, NULL, NULL, '2020-12-05 17:29:44', '2020-12-05 17:29:44'),
(2521, 285, 1, 0, NULL, NULL, '2020-12-05 17:29:56', '2020-12-05 17:29:56'),
(2522, 285, 2, 0, NULL, NULL, '2020-12-05 17:29:56', '2020-12-05 17:29:56'),
(2523, 285, 3, 0, NULL, NULL, '2020-12-05 17:29:56', '2020-12-05 17:29:56'),
(2524, 285, 4, 0, NULL, NULL, '2020-12-05 17:29:56', '2020-12-05 17:29:56'),
(2525, 285, 5, 0, NULL, NULL, '2020-12-05 17:29:56', '2020-12-05 17:29:56'),
(2526, 285, 6, 0, NULL, NULL, '2020-12-05 17:29:56', '2020-12-05 17:29:56'),
(2527, 285, 7, 0, NULL, NULL, '2020-12-05 17:29:56', '2020-12-05 17:29:56'),
(2528, 285, 8, 0, NULL, NULL, '2020-12-05 17:29:56', '2020-12-05 17:29:56'),
(2529, 285, 9, 0, NULL, NULL, '2020-12-05 17:29:56', '2020-12-05 17:29:56'),
(2530, 286, 1, 0, NULL, NULL, '2020-12-05 17:30:26', '2020-12-05 17:30:26'),
(2531, 286, 2, 0, NULL, NULL, '2020-12-05 17:30:26', '2020-12-05 17:30:26'),
(2532, 286, 3, 0, NULL, NULL, '2020-12-05 17:30:26', '2020-12-05 17:30:26'),
(2533, 286, 4, 0, NULL, NULL, '2020-12-05 17:30:26', '2020-12-05 17:30:26'),
(2534, 286, 5, 0, NULL, NULL, '2020-12-05 17:30:26', '2020-12-05 17:30:26'),
(2535, 286, 6, 0, NULL, NULL, '2020-12-05 17:30:26', '2020-12-05 17:30:26'),
(2536, 286, 7, 0, NULL, NULL, '2020-12-05 17:30:26', '2020-12-05 17:30:26'),
(2537, 286, 8, 0, NULL, NULL, '2020-12-05 17:30:26', '2020-12-05 17:30:26'),
(2538, 286, 9, 0, NULL, NULL, '2020-12-05 17:30:26', '2020-12-05 17:30:26'),
(2539, 287, 1, 0, NULL, NULL, '2020-12-05 17:32:48', '2020-12-05 17:32:48'),
(2540, 287, 2, 0, NULL, NULL, '2020-12-05 17:32:48', '2020-12-05 17:32:48'),
(2541, 287, 3, 0, NULL, NULL, '2020-12-05 17:32:48', '2020-12-05 17:32:48'),
(2542, 287, 4, 0, NULL, NULL, '2020-12-05 17:32:48', '2020-12-05 17:32:48'),
(2543, 287, 5, 0, NULL, NULL, '2020-12-05 17:32:48', '2020-12-05 17:32:48'),
(2544, 287, 6, 0, NULL, NULL, '2020-12-05 17:32:48', '2020-12-05 17:32:48'),
(2545, 287, 7, 0, NULL, NULL, '2020-12-05 17:32:48', '2020-12-05 17:32:48'),
(2546, 287, 8, 1, '', '2020-12-05 12:33:36', '2020-12-05 17:32:48', '2020-12-05 17:33:36'),
(2547, 287, 9, 0, NULL, NULL, '2020-12-05 17:32:48', '2020-12-05 17:32:48'),
(2548, 288, 1, 0, NULL, NULL, '2020-12-05 17:34:17', '2020-12-05 17:34:17'),
(2549, 288, 2, 0, NULL, NULL, '2020-12-05 17:34:17', '2020-12-05 17:34:17'),
(2550, 288, 3, 0, NULL, NULL, '2020-12-05 17:34:17', '2020-12-05 17:34:17'),
(2551, 288, 4, 0, NULL, NULL, '2020-12-05 17:34:17', '2020-12-05 17:34:17'),
(2552, 288, 5, 0, NULL, NULL, '2020-12-05 17:34:17', '2020-12-05 17:34:17'),
(2553, 288, 6, 0, NULL, NULL, '2020-12-05 17:34:17', '2020-12-05 17:34:17'),
(2554, 288, 7, 0, NULL, NULL, '2020-12-05 17:34:17', '2020-12-05 17:34:17'),
(2555, 288, 8, 0, NULL, NULL, '2020-12-05 17:34:17', '2020-12-05 17:34:17'),
(2556, 288, 9, 0, NULL, NULL, '2020-12-05 17:34:17', '2020-12-05 17:34:17'),
(2557, 289, 1, 0, NULL, NULL, '2020-12-05 18:04:27', '2020-12-05 18:04:27'),
(2558, 289, 2, 0, NULL, NULL, '2020-12-05 18:04:27', '2020-12-05 18:04:27'),
(2559, 289, 3, 0, NULL, NULL, '2020-12-05 18:04:27', '2020-12-05 18:04:27'),
(2560, 289, 4, 0, NULL, NULL, '2020-12-05 18:04:27', '2020-12-05 18:04:27'),
(2561, 289, 5, 0, NULL, NULL, '2020-12-05 18:04:27', '2020-12-05 18:04:27'),
(2562, 289, 6, 0, NULL, NULL, '2020-12-05 18:04:27', '2020-12-05 18:04:27'),
(2563, 289, 7, 0, NULL, NULL, '2020-12-05 18:04:27', '2020-12-05 18:04:27'),
(2564, 289, 8, 0, NULL, NULL, '2020-12-05 18:04:27', '2020-12-05 18:04:27'),
(2565, 289, 9, 0, NULL, NULL, '2020-12-05 18:04:27', '2020-12-05 18:04:27'),
(2566, 290, 1, 0, NULL, NULL, '2020-12-05 18:08:32', '2020-12-05 18:08:32'),
(2567, 290, 2, 0, NULL, NULL, '2020-12-05 18:08:32', '2020-12-05 18:08:32'),
(2568, 290, 3, 0, NULL, NULL, '2020-12-05 18:08:32', '2020-12-05 18:08:32'),
(2569, 290, 4, 0, NULL, NULL, '2020-12-05 18:08:32', '2020-12-05 18:08:32'),
(2570, 290, 5, 0, NULL, NULL, '2020-12-05 18:08:32', '2020-12-05 18:08:32'),
(2571, 290, 6, 0, NULL, NULL, '2020-12-05 18:08:32', '2020-12-05 18:08:32'),
(2572, 290, 7, 0, NULL, NULL, '2020-12-05 18:08:32', '2020-12-05 18:08:32'),
(2573, 290, 8, 0, NULL, NULL, '2020-12-05 18:08:32', '2020-12-05 18:08:32'),
(2574, 290, 9, 0, NULL, NULL, '2020-12-05 18:08:32', '2020-12-05 18:08:32'),
(2575, 291, 1, 0, NULL, NULL, '2020-12-05 18:13:13', '2020-12-05 18:13:13'),
(2576, 291, 2, 0, NULL, NULL, '2020-12-05 18:13:13', '2020-12-05 18:13:13'),
(2577, 291, 3, 0, NULL, NULL, '2020-12-05 18:13:13', '2020-12-05 18:13:13'),
(2578, 291, 4, 0, NULL, NULL, '2020-12-05 18:13:13', '2020-12-05 18:13:13'),
(2579, 291, 5, 0, NULL, NULL, '2020-12-05 18:13:13', '2020-12-05 18:13:13'),
(2580, 291, 6, 0, NULL, NULL, '2020-12-05 18:13:13', '2020-12-05 18:13:13'),
(2581, 291, 7, 0, NULL, NULL, '2020-12-05 18:13:13', '2020-12-05 18:13:13'),
(2582, 291, 8, 0, NULL, NULL, '2020-12-05 18:13:13', '2020-12-05 18:13:13'),
(2583, 291, 9, 0, NULL, NULL, '2020-12-05 18:13:13', '2020-12-05 18:13:13'),
(2584, 292, 1, 0, NULL, NULL, '2020-12-05 18:13:46', '2020-12-05 18:13:46'),
(2585, 292, 2, 0, NULL, NULL, '2020-12-05 18:13:46', '2020-12-05 18:13:46'),
(2586, 292, 3, 0, NULL, NULL, '2020-12-05 18:13:46', '2020-12-05 18:13:46'),
(2587, 292, 4, 0, NULL, NULL, '2020-12-05 18:13:46', '2020-12-05 18:13:46'),
(2588, 292, 5, 0, NULL, NULL, '2020-12-05 18:13:46', '2020-12-05 18:13:46'),
(2589, 292, 6, 0, NULL, NULL, '2020-12-05 18:13:46', '2020-12-05 18:13:46'),
(2590, 292, 7, 0, NULL, NULL, '2020-12-05 18:13:46', '2020-12-05 18:13:46'),
(2591, 292, 8, 0, NULL, NULL, '2020-12-05 18:13:46', '2020-12-05 18:13:46'),
(2592, 292, 9, 0, NULL, NULL, '2020-12-05 18:13:46', '2020-12-05 18:13:46'),
(2593, 293, 1, 0, NULL, NULL, '2020-12-05 18:15:35', '2020-12-05 18:15:35'),
(2594, 293, 2, 0, NULL, NULL, '2020-12-05 18:15:35', '2020-12-05 18:15:35'),
(2595, 293, 3, 0, NULL, NULL, '2020-12-05 18:15:35', '2020-12-05 18:15:35'),
(2596, 293, 4, 0, NULL, NULL, '2020-12-05 18:15:35', '2020-12-05 18:15:35'),
(2597, 293, 5, 0, NULL, NULL, '2020-12-05 18:15:35', '2020-12-05 18:15:35'),
(2598, 293, 6, 0, NULL, NULL, '2020-12-05 18:15:35', '2020-12-05 18:15:35'),
(2599, 293, 7, 0, NULL, NULL, '2020-12-05 18:15:35', '2020-12-05 18:15:35'),
(2600, 293, 8, 0, NULL, NULL, '2020-12-05 18:15:35', '2020-12-05 18:15:35'),
(2601, 293, 9, 0, NULL, NULL, '2020-12-05 18:15:35', '2020-12-05 18:15:35'),
(2602, 294, 1, 0, NULL, NULL, '2020-12-05 18:15:39', '2020-12-05 18:15:39'),
(2603, 294, 2, 0, NULL, NULL, '2020-12-05 18:15:39', '2020-12-05 18:15:39'),
(2604, 294, 3, 0, NULL, NULL, '2020-12-05 18:15:39', '2020-12-05 18:15:39'),
(2605, 294, 4, 0, NULL, NULL, '2020-12-05 18:15:39', '2020-12-05 18:15:39'),
(2606, 294, 5, 0, NULL, NULL, '2020-12-05 18:15:39', '2020-12-05 18:15:39'),
(2607, 294, 6, 0, NULL, NULL, '2020-12-05 18:15:39', '2020-12-05 18:15:39'),
(2608, 294, 7, 0, NULL, NULL, '2020-12-05 18:15:39', '2020-12-05 18:15:39'),
(2609, 294, 8, 0, NULL, NULL, '2020-12-05 18:15:39', '2020-12-05 18:15:39'),
(2610, 294, 9, 0, NULL, NULL, '2020-12-05 18:15:39', '2020-12-05 18:15:39'),
(2611, 295, 1, 0, NULL, NULL, '2020-12-05 18:20:05', '2020-12-05 18:20:05'),
(2612, 295, 2, 0, NULL, NULL, '2020-12-05 18:20:05', '2020-12-05 18:20:05'),
(2613, 295, 3, 0, NULL, NULL, '2020-12-05 18:20:05', '2020-12-05 18:20:05'),
(2614, 295, 4, 0, NULL, NULL, '2020-12-05 18:20:05', '2020-12-05 18:20:05'),
(2615, 295, 5, 0, NULL, NULL, '2020-12-05 18:20:05', '2020-12-05 18:20:05'),
(2616, 295, 6, 0, NULL, NULL, '2020-12-05 18:20:05', '2020-12-05 18:20:05'),
(2617, 295, 7, 0, NULL, NULL, '2020-12-05 18:20:05', '2020-12-05 18:20:05'),
(2618, 295, 8, 0, NULL, NULL, '2020-12-05 18:20:05', '2020-12-05 18:20:05'),
(2619, 295, 9, 0, NULL, NULL, '2020-12-05 18:20:05', '2020-12-05 18:20:05'),
(2620, 296, 1, 0, NULL, NULL, '2020-12-05 18:20:50', '2020-12-05 18:20:50'),
(2621, 296, 2, 0, NULL, NULL, '2020-12-05 18:20:50', '2020-12-05 18:20:50'),
(2622, 296, 3, 0, NULL, NULL, '2020-12-05 18:20:50', '2020-12-05 18:20:50'),
(2623, 296, 4, 0, NULL, NULL, '2020-12-05 18:20:50', '2020-12-05 18:20:50'),
(2624, 296, 5, 0, NULL, NULL, '2020-12-05 18:20:50', '2020-12-05 18:20:50'),
(2625, 296, 6, 0, NULL, NULL, '2020-12-05 18:20:50', '2020-12-05 18:20:50'),
(2626, 296, 7, 0, NULL, NULL, '2020-12-05 18:20:50', '2020-12-05 18:20:50'),
(2627, 296, 8, 0, NULL, NULL, '2020-12-05 18:20:50', '2020-12-05 18:20:50'),
(2628, 296, 9, 0, NULL, NULL, '2020-12-05 18:20:50', '2020-12-05 18:20:50'),
(2629, 297, 1, 0, NULL, NULL, '2020-12-05 18:21:33', '2020-12-05 18:21:33'),
(2630, 297, 2, 0, NULL, NULL, '2020-12-05 18:21:33', '2020-12-05 18:21:33'),
(2631, 297, 3, 0, NULL, NULL, '2020-12-05 18:21:33', '2020-12-05 18:21:33'),
(2632, 297, 4, 0, NULL, NULL, '2020-12-05 18:21:33', '2020-12-05 18:21:33'),
(2633, 297, 5, 0, NULL, NULL, '2020-12-05 18:21:33', '2020-12-05 18:21:33'),
(2634, 297, 6, 0, NULL, NULL, '2020-12-05 18:21:33', '2020-12-05 18:21:33'),
(2635, 297, 7, 0, NULL, NULL, '2020-12-05 18:21:33', '2020-12-05 18:21:33'),
(2636, 297, 8, 0, NULL, NULL, '2020-12-05 18:21:33', '2020-12-05 18:21:33'),
(2637, 297, 9, 0, NULL, NULL, '2020-12-05 18:21:33', '2020-12-05 18:21:33'),
(2638, 298, 1, 0, NULL, NULL, '2020-12-05 18:29:22', '2020-12-05 18:29:22'),
(2639, 298, 2, 0, NULL, NULL, '2020-12-05 18:29:22', '2020-12-05 18:29:22'),
(2640, 298, 3, 0, NULL, NULL, '2020-12-05 18:29:22', '2020-12-05 18:29:22'),
(2641, 298, 4, 0, NULL, NULL, '2020-12-05 18:29:22', '2020-12-05 18:29:22'),
(2642, 298, 5, 0, NULL, NULL, '2020-12-05 18:29:22', '2020-12-05 18:29:22'),
(2643, 298, 6, 0, NULL, NULL, '2020-12-05 18:29:22', '2020-12-05 18:29:22'),
(2644, 298, 7, 0, NULL, NULL, '2020-12-05 18:29:22', '2020-12-05 18:29:22'),
(2645, 298, 8, 0, NULL, NULL, '2020-12-05 18:29:22', '2020-12-05 18:29:22'),
(2646, 298, 9, 0, NULL, NULL, '2020-12-05 18:29:22', '2020-12-05 18:29:22'),
(2647, 299, 1, 0, NULL, NULL, '2020-12-05 18:31:20', '2020-12-05 18:31:20'),
(2648, 299, 2, 0, NULL, NULL, '2020-12-05 18:31:20', '2020-12-05 18:31:20'),
(2649, 299, 3, 0, NULL, NULL, '2020-12-05 18:31:20', '2020-12-05 18:31:20'),
(2650, 299, 4, 0, NULL, NULL, '2020-12-05 18:31:20', '2020-12-05 18:31:20'),
(2651, 299, 5, 0, NULL, NULL, '2020-12-05 18:31:20', '2020-12-05 18:31:20'),
(2652, 299, 6, 0, NULL, NULL, '2020-12-05 18:31:20', '2020-12-05 18:31:20'),
(2653, 299, 7, 0, NULL, NULL, '2020-12-05 18:31:20', '2020-12-05 18:31:20'),
(2654, 299, 8, 0, NULL, NULL, '2020-12-05 18:31:20', '2020-12-05 18:31:20'),
(2655, 299, 9, 0, NULL, NULL, '2020-12-05 18:31:20', '2020-12-05 18:31:20'),
(2656, 300, 1, 0, NULL, NULL, '2020-12-05 18:32:10', '2020-12-05 18:32:10'),
(2657, 300, 2, 0, NULL, NULL, '2020-12-05 18:32:10', '2020-12-05 18:32:10'),
(2658, 300, 3, 0, NULL, NULL, '2020-12-05 18:32:10', '2020-12-05 18:32:10'),
(2659, 300, 4, 0, NULL, NULL, '2020-12-05 18:32:10', '2020-12-05 18:32:10'),
(2660, 300, 5, 0, NULL, NULL, '2020-12-05 18:32:10', '2020-12-05 18:32:10'),
(2661, 300, 6, 0, NULL, NULL, '2020-12-05 18:32:10', '2020-12-05 18:32:10'),
(2662, 300, 7, 0, NULL, NULL, '2020-12-05 18:32:10', '2020-12-05 18:32:10'),
(2663, 300, 8, 0, NULL, NULL, '2020-12-05 18:32:10', '2020-12-05 18:32:10'),
(2664, 300, 9, 0, NULL, NULL, '2020-12-05 18:32:10', '2020-12-05 18:32:10'),
(2665, 301, 1, 0, NULL, NULL, '2020-12-05 19:00:56', '2020-12-05 19:00:56'),
(2666, 301, 2, 0, NULL, NULL, '2020-12-05 19:00:56', '2020-12-05 19:00:56'),
(2667, 301, 3, 0, NULL, NULL, '2020-12-05 19:00:56', '2020-12-05 19:00:56'),
(2668, 301, 4, 0, NULL, NULL, '2020-12-05 19:00:56', '2020-12-05 19:00:56'),
(2669, 301, 5, 0, NULL, NULL, '2020-12-05 19:00:56', '2020-12-05 19:00:56'),
(2670, 301, 6, 0, NULL, NULL, '2020-12-05 19:00:56', '2020-12-05 19:00:56'),
(2671, 301, 7, 0, NULL, NULL, '2020-12-05 19:00:56', '2020-12-05 19:00:56'),
(2672, 301, 8, 0, NULL, NULL, '2020-12-05 19:00:56', '2020-12-05 19:00:56'),
(2673, 301, 9, 0, NULL, NULL, '2020-12-05 19:00:56', '2020-12-05 19:00:56'),
(2674, 302, 1, 0, NULL, NULL, '2020-12-05 19:01:25', '2020-12-05 19:01:25'),
(2675, 302, 2, 0, NULL, NULL, '2020-12-05 19:01:25', '2020-12-05 19:01:25'),
(2676, 302, 3, 0, NULL, NULL, '2020-12-05 19:01:25', '2020-12-05 19:01:25'),
(2677, 302, 4, 0, NULL, NULL, '2020-12-05 19:01:25', '2020-12-05 19:01:25'),
(2678, 302, 5, 0, NULL, NULL, '2020-12-05 19:01:25', '2020-12-05 19:01:25'),
(2679, 302, 6, 0, NULL, NULL, '2020-12-05 19:01:25', '2020-12-05 19:01:25'),
(2680, 302, 7, 0, NULL, NULL, '2020-12-05 19:01:25', '2020-12-05 19:01:25'),
(2681, 302, 8, 0, NULL, NULL, '2020-12-05 19:01:25', '2020-12-05 19:01:25'),
(2682, 302, 9, 0, NULL, NULL, '2020-12-05 19:01:25', '2020-12-05 19:01:25'),
(2683, 303, 1, 0, NULL, NULL, '2020-12-05 19:03:25', '2020-12-05 19:03:25'),
(2684, 303, 2, 0, NULL, NULL, '2020-12-05 19:03:25', '2020-12-05 19:03:25'),
(2685, 303, 3, 0, NULL, NULL, '2020-12-05 19:03:25', '2020-12-05 19:03:25'),
(2686, 303, 4, 0, NULL, NULL, '2020-12-05 19:03:25', '2020-12-05 19:03:25'),
(2687, 303, 5, 0, NULL, NULL, '2020-12-05 19:03:25', '2020-12-05 19:03:25'),
(2688, 303, 6, 0, NULL, NULL, '2020-12-05 19:03:25', '2020-12-05 19:03:25'),
(2689, 303, 7, 0, NULL, NULL, '2020-12-05 19:03:25', '2020-12-05 19:03:25'),
(2690, 303, 8, 1, '', '2020-12-05 14:03:31', '2020-12-05 19:03:25', '2020-12-05 19:03:31'),
(2691, 303, 9, 0, NULL, NULL, '2020-12-05 19:03:25', '2020-12-05 19:03:25');

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `facility_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `contact` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `availability` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`id`, `facility_name`, `company_id`, `status`, `contact`, `availability`, `description`, `created_at`, `updated_at`) VALUES
(3, 'Community center', 5, 1, 'Richard - richard@aptly.com', '10 AM to 07 PM', 'Community halls for group activities, social support', '2020-11-12 03:12:03', '2020-11-20 19:52:46'),
(4, 'Gym', 5, 1, 'Stephen - stephen@apatly.com', '08 AM to 1 PM and 5 PM to 10 PM', 'Regular guest instructors host new and regularly changing group classes from bootcamps to informative movement workshops and yoga.', '2020-11-12 07:31:21', '2020-11-12 07:37:06'),
(5, 'Laundry Room', 5, 1, 'John  Phone - 01889956', '10 AM to 5PM', 'Dry Cleanig & Laundry Service, environment friendly cleaning', '2020-11-12 03:12:03', '2020-11-12 03:12:03'),
(6, 'Party Lawn', 5, 1, 'Jack Phone - 09888345', '08 AM to  11: PM', 'Wedding party, Eevents, Birthday party', '2020-11-12 07:31:21', '2020-11-12 07:37:06'),
(9, 'Litile Child Care Center', 5, 1, 'Ally, Phone   77 414 9698', '11 AM to 05 PM', 'Different types of child care available including creches, childminders', '2020-11-12 07:31:21', '2020-11-22 03:43:04'),
(64, 'Community center', 5, 1, 'jack', 'Sunday', 'Community center', '2020-12-01 21:55:12', '2020-12-01 21:55:12'),
(65, 'Party Lawn', 5, 1, 'jack', 'Sunday', NULL, '2020-12-01 22:09:04', '2020-12-01 22:09:04'),
(66, 'Club house', 5, 1, '8585749632', '5:00', 'New Club Hose In Apartment', '2020-12-04 16:43:05', '2020-12-04 16:43:05');

-- --------------------------------------------------------

--
-- Table structure for table `facilities_options`
--

CREATE TABLE `facilities_options` (
  `id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `status` varchar(200) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `subtitle` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `feature_image` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `features`
--

INSERT INTO `features` (`id`, `title`, `subtitle`, `content`, `feature_image`, `created_at`, `updated_at`) VALUES
(1, 'Emergency & Alerts', '[\"Fire Alert:\",\"Emergency Contact:\",\"Parcel:\",\"Notifications:\"]', '[\"If there is a fire, the concierge can send out an alert to all tenants living in the property to find out if they are safe. Mark as safe button\",\"Get in touch directly with the Concierge to alert them you need Emergency assistance in your Apartment.\",\"Just a small icon on home screen that will show how many parcels waiting to be collected\",\"Your app will deliver instant notifications from your Concierge if they need to send you any sort of message.\"]', '1607338647.jpg', '2020-12-07 10:57:27', '2020-12-07 05:27:27'),
(2, 'Social Network', '[\"Facilities & Activities:\",\"Polls:\",\"Services:\"]', '[\"Can post any activities happening in the local area - i.e yoga or football player needed etc\",\"Concierge can create polls to post which owners and tenants can vote on. For example, do we need solar panels yes or no etc\",\"Can have a list of nearby services in the area. i.e pet services, move in, laundry etc\"]', '1607338767.jpg', '2020-12-07 10:59:27', '2020-12-07 05:29:27'),
(3, 'Your Apartment & Building', '[\"Apartment Info:\",\"Bills Management:\",\"Building & Apartment Issues:\",\"Home Notes:\",\"Real Estate:\"]', '[\"Display info of apartment, parking bay, decor I.e type of paint, type of light bulb etc\",\"Can add info about bills and quick contact info, so all in one place easy to access\",\"Raise any issues have with the building or the flat - will go directly to the concierge\",\"Just a section for owners and tenants to write notes of their apartment if they need to - and can create topics where they can add notes. Ie garden, need to get flowers, kitchen - need to get saucepan\",\"Discover Home in your building or in the area partners with Anderson Rose.\"]', '1607338872.jpg', '2020-12-07 11:01:12', '2020-12-07 05:31:12'),
(4, 'Concierge', '[\"Online Live Chat:\",\"Manage Visitors:\",\"Message Board:\",\"Concierge working:\",\"Loyalty card:\"]', '[\"Owners & Tenants will be able to have direct contact with the concierge. When a message is sent the concierge team will get an alert and will be able to respond - and opposite way round.\",\"Notify the concierge of any visitors coming, who can access the keys etc\",\"Display important info regarding the building and area - i.e lift not working etc\",\"On home screen show who is working currently - can have a call concierge button which will link with the phone number.\",\"My building has a loyalty card already where we get discount at London restaurants, we just need a button which will link to an image we will attach of the card - so its online\"]', '1607338973.jpg', '2020-12-07 11:02:53', '2020-12-07 05:32:53');

-- --------------------------------------------------------

--
-- Table structure for table `gates`
--

CREATE TABLE `gates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gates`
--

INSERT INTO `gates` (`id`, `company_id`, `name`, `created_at`, `updated_at`) VALUES
(8, 5, 'Gate1', '2020-11-05 08:36:17', '2020-11-05 08:36:17'),
(9, 5, 'Gate2', '2020-11-29 22:02:36', '2020-11-29 22:02:36');

-- --------------------------------------------------------

--
-- Table structure for table `loyalty_cards`
--

CREATE TABLE `loyalty_cards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `store_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_offers` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loyalty_cards`
--

INSERT INTO `loyalty_cards` (`id`, `company_id`, `store_name`, `store_address`, `store_offers`, `status`, `created_at`, `updated_at`) VALUES
(1, 5, 'Selfridges Food Hall', '400 Oxford Street, Fitzrovia, London W1A', '30 % Discount', '1', '2020-11-07 06:27:29', '2020-11-22 04:56:37'),
(2, 5, 'Grays Antiques', '1-7 Davies Mews, Mayfair, London W1K', '20 % Discount', '1', '2020-11-12 07:58:57', '2020-11-22 04:55:33'),
(3, 5, 'Test', 'Test Address', '100 %', '0', '2020-11-25 18:49:36', '2020-11-25 18:49:47'),
(6, 5, 'Grays Antiques', '1-7 Davies Mews, Mayfair, London W1K', '10% Off', '1', '2020-12-01 21:56:15', '2020-12-01 21:56:15'),
(7, 5, 'Test', 'Test', '24% flat off', '1', '2020-12-01 22:09:30', '2020-12-01 22:09:30'),
(8, 5, 'Praps Store', 'new 11th apartmets', '10% off', '1', '2020-12-04 16:46:42', '2020-12-04 16:46:42');

-- --------------------------------------------------------

--
-- Table structure for table `message_boards`
--

CREATE TABLE `message_boards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `notice_valid_until` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `message_boards`
--

INSERT INTO `message_boards` (`id`, `company_id`, `title`, `description`, `status`, `notice_valid_until`, `created_at`, `updated_at`) VALUES
(14, 5, 'GYM will close', 'GYM service will be close in this week', 1, '2020-12-23', '2020-11-22 04:33:58', '2020-11-22 04:33:58'),
(15, 5, 'Water Supply Issue', 'No Water or Very Low Pressure for two days', 1, '2020-12-31', '2020-11-22 04:35:38', '2020-11-22 04:35:38'),
(16, 5, 'Lift is not working', 'Lift is not working', 1, '2020-12-23', '2020-11-22 04:33:58', '2020-11-22 04:33:58'),
(17, 5, 'electricity failure', 'Electricity failure for two days', 1, '2020-12-31', '2020-11-22 04:35:38', '2020-11-22 04:35:38'),
(20, 5, 'Lift is not working', 'Lift is not working', 1, '2020-12-03', '2020-12-01 21:45:39', '2020-12-01 21:45:39'),
(21, 5, 'Water Supply Issue', 'Water Supply Issue', 1, '2020-12-02', '2020-12-01 21:53:45', '2020-12-01 21:53:45'),
(22, 5, 'Lift is not working', 'Lift is not working', 1, '2020-12-03', '2020-12-01 22:08:13', '2020-12-01 22:08:13');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(8, '2019_05_03_000001_create_customer_columns', 1),
(9, '2019_05_03_000002_create_subscriptions_table', 1),
(10, '2019_05_03_000003_create_subscription_items_table', 1),
(11, '2019_08_19_000000_create_failed_jobs_table', 1),
(12, '2020_10_27_084407_admin', 1),
(13, '2020_10_27_112146_create_companies_table', 1),
(14, '2020_10_28_031834_add_payment_status_to_companies_table', 1),
(15, '2020_10_28_044549_add_plan_details_to_companies_table', 1),
(16, '2020_10_29_105453_create_transactions_table', 1),
(17, '2020_10_29_112129_create_notifications_table', 1),
(18, '2020_10_30_113713_create_settings_table', 2),
(33, '2020_11_02_101134_create_units_table', 3),
(34, '2020_11_02_101334_create_app_users_table', 3),
(35, '2020_11_02_130850_create_services_table', 3),
(36, '2020_11_02_140506_create_facilities_table', 3),
(37, '2020_11_03_062027_create_gates_table', 3),
(38, '2020_11_03_062110_create_reason_for_visits_table', 3),
(40, '2020_11_03_062127_create_visitors_table', 4),
(41, '2020_11_04_111108_create_concierges_table', 5),
(42, '2020_11_04_133729_create_message_boards_table', 6),
(44, '2020_11_05_065023_create_loyalty_cards_table', 7),
(45, '2020_11_05_110531_create_polls_table', 8),
(46, '2020_11_05_111149_create_polls_options_table', 8),
(48, '2020_11_05_111324_create_polls_votes_table', 9),
(49, '2020_11_06_063501_create_parcels_table', 9),
(50, '2020_11_06_131139_create_emergency_alarms_table', 10),
(51, '2020_11_06_131552_create_emergency_alarms_responses_table', 10),
(52, '2020_11_07_110730_create_company_settings_table', 11),
(53, '2020_11_09_053934_create_unit_issue_requests_table', 12);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('0000c032-3042-491d-8cef-c0df26301577', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-02 17:37:24', '2020-12-02 20:25:10'),
('00fce083-c2ad-4d8e-8f4b-cdfaaab2000e', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-01 22:00:01', '2020-12-02 20:25:10'),
('015c9fc1-1d15-4d12-8b73-44d2c3a9052a', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Chandlar Smith is safe\",\"user_id\":9}', NULL, '2020-12-04 17:00:52', '2020-12-04 17:00:52'),
('0576f12f-6d3d-43a8-a0d1-eb932e4c69d6', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Chandlar Smith is not safe help him\\/her\",\"user_id\":9}', NULL, '2020-12-04 17:00:24', '2020-12-04 17:00:24'),
('05ac5302-c985-4f28-8f1f-5e16153e5c75', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is not safe\",\"user_id\":8}', '2020-12-01 21:44:51', '2020-12-01 20:56:36', '2020-12-01 21:44:51'),
('0a7f685b-2a8b-4a4f-960b-3693a484696d', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-02 19:51:27', '2020-12-02 20:25:10'),
('0be2d259-b91c-4d8d-9fc9-508f5c3659a9', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is not safe help him\\/her\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-02 17:04:09', '2020-12-02 20:25:10'),
('0eeaa6cd-2605-42c2-95cc-5ae3a3072f9b', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-02 17:14:51', '2020-12-02 20:25:10'),
('100bcb60-e25e-4c02-87ea-dcbdfa1e37db', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', NULL, '2020-12-05 17:16:23', '2020-12-05 17:16:23'),
('15f29c72-ae41-46b3-8a02-ef4eec14db4f', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-04 16:41:52', '2020-12-04 07:57:35', '2020-12-04 16:41:52'),
('1687ea28-5261-4f92-a1af-fb13ffcedc21', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Chandlar Smith is safe\",\"user_id\":9}', '2020-12-04 16:41:46', '2020-12-04 16:40:18', '2020-12-04 16:41:46'),
('16c83e5d-90fe-4229-b272-b525d32b25a7', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-04 16:41:52', '2020-12-03 19:48:06', '2020-12-04 16:41:52'),
('1a9a84c5-2d8f-4128-9a8f-7e5169faf325', 'App\\Notifications\\MemberIssueRequest', 'App\\User', 6, '{\"data\":\"Diane Lennan Rise new issue\",\"user_id\":8}', '2020-12-04 16:41:52', '2020-12-03 20:19:54', '2020-12-04 16:41:52'),
('1f76bbc5-f9dc-4b33-9922-eba94b081d41', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-04 16:41:52', '2020-12-03 19:39:13', '2020-12-04 16:41:52'),
('2148f8e5-42c3-4694-9214-3a1bb8de4047', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-04 16:41:52', '2020-12-02 20:51:00', '2020-12-04 16:41:52'),
('265e5b7e-71aa-4e1f-b6c4-6bf094c943e0', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-02 15:07:51', '2020-12-02 20:25:10'),
('26bea63f-0d93-4667-b15f-01ff90b17f8a', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-04 16:41:52', '2020-12-03 19:47:24', '2020-12-04 16:41:52'),
('26c9bc2e-4998-4a07-8002-80075e482a97', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-04 16:41:52', '2020-12-03 12:47:12', '2020-12-04 16:41:52'),
('287ee0fe-ae6c-474d-b9a0-571dcd295405', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', NULL, '2020-12-05 17:33:36', '2020-12-05 17:33:36'),
('2a3372bb-d4af-4d18-8237-bae6006b7ecc', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is not safe help him\\/her\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-02 16:58:49', '2020-12-02 20:25:10'),
('2d9f97ee-c6e9-4eb7-8e9d-fc10c28035dd', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-04 16:41:52', '2020-12-03 19:40:12', '2020-12-04 16:41:52'),
('2fa27101-b44a-467b-a6a9-6fe4c686bc8d', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is not safe help him\\/her\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-02 16:55:41', '2020-12-02 20:25:10'),
('300eef8e-349c-4aff-9215-9de7e95403cd', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-02 17:33:04', '2020-12-02 20:25:10'),
('32f204e3-cadc-4653-a8ad-1da5cdfd7609', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is not safe help him\\/her\",\"user_id\":8}', '2020-12-04 16:41:52', '2020-12-02 20:51:29', '2020-12-04 16:41:52'),
('3388e2be-4a19-4604-bd14-037ea9841cf8', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-02 17:12:00', '2020-12-02 20:25:10'),
('348c1dad-ff23-4942-9364-37aa99dd9a26', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-01 21:53:22', '2020-12-02 20:25:10'),
('3e8d8240-55b1-4260-bf1d-27311a118bf2', 'App\\Notifications\\NewSubscriptionNotification', 'App\\Admin', 1, '{\"data\":\"New Company Subscription\",\"user_id\":10}', NULL, '2020-12-04 14:21:56', '2020-12-04 14:21:56'),
('3f648a8c-a7d7-40eb-8cb8-6c117f3a1db5', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-02 19:46:50', '2020-12-02 20:25:10'),
('41621bf6-53cb-416b-b0c5-b408724966f0', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-04 16:41:52', '2020-12-03 07:03:03', '2020-12-04 16:41:52'),
('41d3dc8c-5efb-4b7c-908a-c11ba62253bb', 'App\\Notifications\\MemberIssueRequest', 'App\\User', 6, '{\"data\":\"Diane Lennan Rise new issue\",\"user_id\":8}', '2020-12-01 19:25:49', '2020-12-01 15:20:39', '2020-12-01 19:25:49'),
('4241934e-59e2-4764-98f9-105e61093ab3', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-02 14:51:07', '2020-12-02 20:25:10'),
('429eb234-cb81-416a-9e43-86c73fe37602', 'App\\Notifications\\MemberIssueRequest', 'App\\User', 6, '{\"data\":\"Diane Lennan Rise new issue\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-01 21:51:40', '2020-12-02 20:25:10'),
('432b5989-3fb5-4cee-97a0-7a716464a432', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-02 17:32:08', '2020-12-02 20:25:10'),
('441e0e89-c1de-4b65-9b41-c161198d0ee2', 'App\\Notifications\\NewSubscriptionNotification', 'App\\Admin', 1, '{\"data\":\"New Company Subscription\",\"user_id\":8}', NULL, '2020-11-17 12:12:47', '2020-11-17 12:12:47'),
('45ab29cc-1bea-46c3-a189-9578f00d3aed', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', NULL, '2020-12-05 15:43:56', '2020-12-05 15:43:56'),
('460333cb-4d4f-4656-95a9-f02ce79ba08e', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-04 16:41:52', '2020-12-03 12:48:51', '2020-12-04 16:41:52'),
('4a4ab063-7acd-4fa2-a108-21cb75ece06e', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-04 16:41:52', '2020-12-03 19:54:31', '2020-12-04 16:41:52'),
('4b61efb7-6030-4636-92d8-4de8aa70e362', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-02 17:12:42', '2020-12-02 20:25:10'),
('4c3a9247-557b-489a-a3d5-7b2e9f6c03b8', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-01 21:49:51', '2020-12-02 20:25:10'),
('4cc1c77e-a7ad-4fe9-b612-af286dc65763', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is not safe help him\\/her\",\"user_id\":8}', '2020-12-04 16:41:52', '2020-12-03 19:48:56', '2020-12-04 16:41:52'),
('4cfd059f-21e2-4294-b029-b6e061d32985', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', NULL, '2020-12-05 15:54:57', '2020-12-05 15:54:57'),
('4d19ac7f-41c2-426c-8dbf-087eede7ccba', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is not safe help him\\/her\",\"user_id\":8}', '2020-12-02 16:54:46', '2020-12-02 16:54:28', '2020-12-02 16:54:46'),
('50badf0b-3700-4029-951d-c1473dfc0775', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-02 15:05:39', '2020-12-02 20:25:10'),
('52e324f5-17de-49fd-b17d-875e4865a7a2', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-01 22:07:14', '2020-12-02 20:25:10'),
('553d58a1-dcb0-4602-b3a8-90a92028dee6', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-04 16:41:52', '2020-12-03 19:38:35', '2020-12-04 16:41:52'),
('56515bbf-5fc2-4f58-af4b-84d781edb5ba', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', NULL, '2020-12-05 15:58:32', '2020-12-05 15:58:32'),
('57dafcb2-a581-48e2-8127-b50fd7ce494d', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is not safe\",\"user_id\":8}', '2020-12-01 21:44:51', '2020-12-01 20:56:08', '2020-12-01 21:44:51'),
('58dd8933-f461-4041-85ab-57d5f2d9b319', 'App\\Notifications\\MemberIssueRequest', 'App\\User', 6, '{\"data\":\"Chandlar Smith Rise new issue\",\"user_id\":9}', NULL, '2020-12-04 16:50:56', '2020-12-04 16:50:56'),
('5ba56051-6f6d-454d-b5dd-edd49f3d179f', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-04 16:41:52', '2020-12-03 19:54:25', '2020-12-04 16:41:52'),
('608bd29e-40d6-4364-8147-833158b33e29', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is not safe help him\\/her\",\"user_id\":8}', '2020-12-04 16:41:52', '2020-12-03 12:48:19', '2020-12-04 16:41:52'),
('625a4538-420b-4a4f-a840-c5740e6dea5e', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-02 15:03:10', '2020-12-02 20:25:10'),
('661a5793-0ef3-498a-8283-1b304dc612b1', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-02 15:06:45', '2020-12-02 20:25:10'),
('66bcb526-c3df-437c-8205-b996a9f14e9a', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-02 17:19:14', '2020-12-02 20:25:10'),
('675c9cab-f2e6-4408-8724-674e789f83bd', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is not safe help him\\/her\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-02 16:59:10', '2020-12-02 20:25:10'),
('6ced3720-f247-4e29-b1a5-6858013be7a8', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"David Terry is not safe help him\\/her\",\"user_id\":7}', NULL, '2020-12-05 16:09:42', '2020-12-05 16:09:42'),
('6d100bbd-36cf-4a84-9395-3f3adbd6039a', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"David Terry is safe\",\"user_id\":7}', NULL, '2020-12-05 16:09:55', '2020-12-05 16:09:55'),
('6f8ab08f-99fa-4ad2-9c9a-62e056057ea2', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', NULL, '2020-12-05 15:46:03', '2020-12-05 15:46:03'),
('6f9940d2-236c-49a6-a3b1-324dd423ae76', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-02 17:33:12', '2020-12-02 20:25:10'),
('711c1f64-8183-49bb-a353-ee77d470e44b', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-02 19:32:05', '2020-12-02 20:25:10'),
('7616acfa-2dcb-4291-9e9a-84ae8abc4095', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-02 19:36:21', '2020-12-02 20:25:10'),
('7635458e-b148-4bd5-a60e-05301b589b8a', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-02 19:31:56', '2020-12-02 20:25:10'),
('76f97132-e8f8-46d6-8cf6-a907178e41b2', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is not safe help him\\/her\",\"user_id\":8}', '2020-12-04 16:41:52', '2020-12-02 20:50:50', '2020-12-04 16:41:52'),
('7b14f068-e585-4761-98d8-a4d3bb1178cc', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-01 22:07:52', '2020-12-02 20:25:10'),
('7d031e82-4376-4c38-9a62-ee7cce939219', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Chandlar Smith is safe\",\"user_id\":9}', NULL, '2020-12-04 16:59:52', '2020-12-04 16:59:52'),
('7f29a389-14be-4a83-b4b5-66dc7b1c4429', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-02 19:47:27', '2020-12-02 20:25:10'),
('7fac8c4d-58af-4726-8e9d-2eea7921b7af', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-04 16:41:52', '2020-12-03 12:25:03', '2020-12-04 16:41:52'),
('84d05c37-38d6-4a17-86ab-4263809c4a34', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-04 16:41:52', '2020-12-03 19:54:44', '2020-12-04 16:41:52'),
('86a21897-b365-4088-8958-edf572008b87', 'App\\Notifications\\MemberIssueRequest', 'App\\User', 6, '{\"data\":\"Diane Lennan Rise new issue\",\"user_id\":8}', '2020-12-01 19:25:49', '2020-12-01 15:20:50', '2020-12-01 19:25:49'),
('8b42b7c3-86c2-4a0c-a64d-d3743221e643', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-02 15:10:55', '2020-12-02 20:25:10'),
('8c98cd70-5dfa-4a85-893d-91afc2152d57', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', NULL, '2020-12-05 15:44:49', '2020-12-05 15:44:49'),
('8f7c3f76-b79e-4f61-9ce5-013aeebc3af3', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', NULL, '2020-12-05 15:59:55', '2020-12-05 15:59:55'),
('9141ecb8-fadf-4b1d-863a-775797f8a476', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Chandlar Smith is not safe help him\\/her\",\"user_id\":9}', '2020-12-04 17:20:35', '2020-12-04 17:01:30', '2020-12-04 17:20:35'),
('9171ce26-eee6-4761-b93f-ae84857a4ea9', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', NULL, '2020-12-05 15:44:49', '2020-12-05 15:44:49'),
('923a3817-f7d0-431a-9251-5c73e59195f3', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-04 16:41:52', '2020-12-03 07:02:40', '2020-12-04 16:41:52'),
('a1aa7933-ae8a-4400-a0ad-5c29c67cb7bd', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-04 16:41:52', '2020-12-03 19:40:51', '2020-12-04 16:41:52'),
('a2f6caca-a4e4-450d-9b65-1b3bf991971a', 'App\\Notifications\\NewSubscriptionNotification', 'App\\Admin', 1, '{\"data\":\"New Company Subscription\",\"user_id\":2}', NULL, '2020-10-29 07:39:31', '2020-10-29 07:39:31'),
('a7b62c9f-4d6e-4236-beac-92d68388cc65', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is not safe help him\\/her\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-02 19:37:25', '2020-12-02 20:25:10'),
('a7ec5a9b-6a2c-4a3a-965b-431a2bf3e208', 'App\\Notifications\\MemberIssueRequest', 'App\\User', 6, '{\"data\":\"Diane Lennan Rise new issue\",\"user_id\":8}', '2020-12-01 19:25:49', '2020-12-01 12:21:18', '2020-12-01 19:25:49'),
('a8496ce2-4a0e-4700-ae01-ee1f0769ec08', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-02 12:07:13', '2020-12-01 22:00:00', '2020-12-02 12:07:13'),
('b137ab50-9ad8-454f-a6bd-c222dd5d6d59', 'App\\Notifications\\MemberIssueRequest', 'App\\User', 6, '{\"data\":\"Chandlar Smith Rise new issue\",\"user_id\":9}', NULL, '2020-12-04 16:57:42', '2020-12-04 16:57:42'),
('b6481ecf-4242-4afd-a64d-559e48ce81e1', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-02 15:05:22', '2020-12-02 20:25:10'),
('ba4a3d4e-9d1b-4068-a104-b54327292041', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Chandlar Smith is safe\",\"user_id\":9}', NULL, '2020-12-04 16:55:07', '2020-12-04 16:55:07'),
('bb19fb24-ff3d-4740-833b-6582c46e8746', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Chandlar Smith is safe\",\"user_id\":9}', '2020-12-04 16:41:52', '2020-12-04 16:39:47', '2020-12-04 16:41:52'),
('bc35410e-8836-4b5a-87ea-ffe9b065927d', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is not safe\",\"user_id\":8}', '2020-12-01 21:44:51', '2020-12-01 20:57:04', '2020-12-01 21:44:51'),
('bee47ba1-1d33-4b50-9338-d3adc3cde8c7', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-02 19:46:32', '2020-12-02 20:25:10'),
('c36e1c6e-49e1-425c-a605-8614693b17dd', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-04 16:41:52', '2020-12-03 19:41:33', '2020-12-04 16:41:52'),
('c616c3e4-437b-48e7-8b02-9cd09e8e5990', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-04 16:41:52', '2020-12-03 12:25:12', '2020-12-04 16:41:52'),
('c9998482-c718-4e7b-acc2-fadb8ce0fde3', 'App\\Notifications\\MemberIssueRequest', 'App\\User', 6, '{\"data\":\"Chandlar Smith Rise new issue\",\"user_id\":9}', '2020-12-04 16:40:05', '2020-12-04 16:22:39', '2020-12-04 16:40:05'),
('cc23f053-95de-471b-b37e-eb1f00cd0a42', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-02 17:17:11', '2020-12-02 20:25:10'),
('ce76d019-31c7-4532-bea6-67d05a987493', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-02 17:31:11', '2020-12-02 20:25:10'),
('ce80cf1d-70a3-40cc-8769-3757203d9de5', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Chandlar Smith is safe\",\"user_id\":9}', NULL, '2020-12-05 11:41:08', '2020-12-05 11:41:08'),
('d37e44b5-6774-4e09-8e30-6c585d31a634', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-04 16:41:52', '2020-12-03 19:48:12', '2020-12-04 16:41:52'),
('d4b28488-a1ee-4b26-a21d-934f9e70d506', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-02 15:06:20', '2020-12-02 20:25:10'),
('d5e16757-c7b2-4e96-a937-1fb1192f195d', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is not safe help him\\/her\",\"user_id\":8}', '2020-12-04 16:41:52', '2020-12-03 19:40:43', '2020-12-04 16:41:52'),
('d645c71d-17e6-49ac-ad4d-0876355b4785', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-01 21:53:23', '2020-12-02 20:25:10'),
('dd1cba81-b671-40e8-bf58-19d82765c532', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', NULL, '2020-12-05 19:03:31', '2020-12-05 19:03:31'),
('dd81bf76-f7b5-412d-910a-3183e5adcc52', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-04 16:41:52', '2020-12-03 12:48:30', '2020-12-04 16:41:52'),
('e023220b-0ab2-4529-b025-ca61c9b83d35', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-02 14:54:13', '2020-12-02 20:25:10'),
('e0e4d295-34e9-4f26-83fb-0ee97a25de69', 'App\\Notifications\\NewSubscriptionNotification', 'App\\Admin', 1, '{\"data\":\"New Company Subscription\",\"user_id\":5}', NULL, '2020-11-04 01:27:48', '2020-11-04 01:27:48'),
('e1cabe51-8297-4ef9-a49c-4a9bbedaf0ec', 'App\\Notifications\\NewSubscriptionNotification', 'App\\Admin', 1, '{\"data\":\"New Company Subscription\",\"user_id\":7}', NULL, '2020-11-17 00:35:45', '2020-11-17 00:35:45'),
('e666195e-140f-44a6-bd22-0bddd2cda3f4', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-02 17:33:57', '2020-12-02 20:25:10'),
('ea4bb276-8264-4980-acd1-84f18d8d5897', 'App\\Notifications\\NewSubscriptionNotification', 'App\\Admin', 1, '{\"data\":\"New Company Subscription\",\"user_id\":6}', NULL, '2020-11-05 02:11:03', '2020-11-05 02:11:03'),
('f2609151-a990-4e17-b2b9-4dca85e7e8c7', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', NULL, '2020-12-05 11:41:04', '2020-12-05 11:41:04'),
('f2c3b66a-12cd-46d6-b63a-4d32d546b30b', 'App\\Notifications\\NewSubscriptionNotification', 'App\\Admin', 1, '{\"data\":\"New Company Subscription\",\"user_id\":4}', NULL, '2020-10-31 01:12:43', '2020-10-31 01:12:43'),
('f34daf2d-64c7-4bdc-b285-a91a4122c1c3', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-02 17:17:11', '2020-12-02 20:25:10'),
('f4f2bb23-88ba-4962-836d-4bde05136a6f', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-04 16:41:52', '2020-12-03 12:46:53', '2020-12-04 16:41:52'),
('f97b6390-dfb3-45e4-8450-55b4b2f86066', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-02 19:37:02', '2020-12-02 20:25:10'),
('fb597ed4-e812-4f41-96ff-9f556ca74e6c', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-04 16:41:52', '2020-12-02 20:51:36', '2020-12-04 16:41:52'),
('fcd9a690-2534-4233-89fa-9ca5e069a333', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-02 17:17:29', '2020-12-02 20:25:10'),
('fdaa7da8-eeb8-4dd5-933c-158f6c2146b2', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-02 14:53:17', '2020-12-02 20:25:10'),
('fdabddd6-7702-4abc-8e46-2a646c851d12', 'App\\Notifications\\EmergencyAlarmResponse', 'App\\User', 6, '{\"data\":\"Diane Lennan is safe\",\"user_id\":8}', '2020-12-02 20:25:10', '2020-12-02 19:31:57', '2020-12-02 20:25:10');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('0084d5a6182db92c87a3192f2934c56cbf5338806895f7127d0249ca2c2b32766fba61c1e325084f', 7, 1, 'MyApp', '[]', 0, '2020-11-21 21:49:34', '2020-11-21 21:49:34', '2021-11-21 15:49:34'),
('03d1a11a610d7983c32e60c1256991ca8f402a4b745df0880ca6fbf7c66aceaddb76373ff81dd654', 7, 1, 'MyApp', '[]', 0, '2020-11-17 22:05:13', '2020-11-17 22:05:13', '2021-11-17 16:05:13'),
('0536aaee4bf5b5c8c884ea4ce0f1e55bba586b974ccdbce7ae7c7f41fa2db35d3ef3b1bbcbd92e2e', 8, 1, 'MyApp', '[]', 0, '2020-12-02 09:58:02', '2020-12-02 09:58:02', '2021-12-02 04:58:02'),
('065fe279cf88c7ca96644b7da1519c6534b605c2c2c0a76fe4d3d3593eac5987557f3d2d645a3431', 8, 1, 'MyApp', '[]', 0, '2020-11-26 18:11:18', '2020-11-26 18:11:18', '2021-11-26 12:11:18'),
('0a54138b7ee95079a2d1b44c70bd233a572ac043e241db0c459b4b98c33cf72b0bfec365fff52f18', 9, 1, 'MyApp', '[]', 0, '2020-12-04 16:57:01', '2020-12-04 16:57:01', '2021-12-04 11:57:01'),
('0d1a95a45b9f476d3da4d7c39a7e08698a30ca0e01456b0dbb8438f02c80ca5ae6cbc62c619ac61d', 7, 1, 'MyApp', '[]', 0, '2020-11-21 05:17:27', '2020-11-21 05:17:27', '2021-11-20 23:17:27'),
('0d339112152400162eac8f0110adc2c4a00383f2903fcff039c4305333ee21d4596d53bb0e2bf844', 7, 1, 'MyApp', '[]', 0, '2020-11-20 20:48:31', '2020-11-20 20:48:31', '2021-11-20 14:48:31'),
('0f6c67fb3ff3f5ece20b80ce087097481a4b1ce0d79e3c6b7bd94141524520930a805ef78ad34473', 9, 1, 'MyApp', '[]', 0, '2020-12-04 16:34:02', '2020-12-04 16:34:02', '2021-12-04 11:34:02'),
('10f8965ee1724e133c8199047e8606458f59e944800fa96b0143da6a14b86e0ae46b9571f12c74f8', 8, 1, 'MyApp', '[]', 0, '2020-11-25 16:13:14', '2020-11-25 16:13:14', '2021-11-25 10:13:14'),
('12e6100efdf5599e7f216c2b9236af3b8d6b008f31260eca17cfbf3697911d47f89d7b755f09883e', 7, 1, 'MyApp', '[]', 0, '2020-11-21 03:29:11', '2020-11-21 03:29:11', '2021-11-20 21:29:11'),
('187fe3a96fd34657da89fa77a5cc25d9855dd99c176fe95ac7effbc18fea887298a9ce9e1dd8d4bc', 8, 1, 'MyApp', '[]', 0, '2020-12-01 22:07:03', '2020-12-01 22:07:03', '2021-12-01 17:07:03'),
('1988ba5a0da1942e413b7d8ce6602ec295e325c86b6195bfae9106a2d7ebda5893ecaa32eec8cde1', 8, 1, 'MyApp', '[]', 0, '2020-12-02 11:05:02', '2020-12-02 11:05:02', '2021-12-02 06:05:02'),
('19d861d7a572d0d7f2b5b31eef54103835895fdac62caf396c06df9b51099ca049a3c24016a3e12c', 8, 1, 'MyApp', '[]', 0, '2020-11-28 18:50:32', '2020-11-28 18:50:32', '2021-11-28 12:50:32'),
('1aa31115eea812957765079a934d153b4ed85249e670ced26480ada374aaa73e06f6fb928a235c24', 8, 1, 'MyApp', '[]', 0, '2020-11-24 13:35:43', '2020-11-24 13:35:43', '2021-11-24 07:35:43'),
('1c35090457dca9fb7b6d5fa78bd968cfbd20582787af09400ca78e66dcab4b2f08f74b8c832b274e', 8, 1, 'MyApp', '[]', 0, '2020-11-27 17:19:42', '2020-11-27 17:19:42', '2021-11-27 11:19:42'),
('1ce9e6008059bec722a1a5d258851bb5a80e82ec9398ee9327ea1f6191adb77fe76c517f75c8ca7e', 9, 1, 'MyApp', '[]', 0, '2020-12-04 16:39:17', '2020-12-04 16:39:17', '2021-12-04 11:39:17'),
('1daaccc54f71739e247625354c0eb0895b2ea130c9e4d0c9f805c849910f9e7885a205af03216a6e', 8, 1, 'MyApp', '[]', 0, '2020-12-01 09:46:16', '2020-12-01 09:46:16', '2021-12-01 04:46:16'),
('1e41949acce2448008e6f68b5021348db639f023d065752badbff57fd98f6b8a857157b5b0a44e2c', 8, 1, 'MyApp', '[]', 0, '2020-11-27 16:24:31', '2020-11-27 16:24:31', '2021-11-27 10:24:31'),
('1eaab43faedf8dd772f5075663192598e652202b9292af7e627c0c725d9aedf77f6b6e9f874318b8', 8, 1, 'MyApp', '[]', 0, '2020-11-27 17:19:43', '2020-11-27 17:19:43', '2021-11-27 11:19:43'),
('1eb2d844aa97d174118fb673babafdb5c7893f1ddd23e3807adc36618028add4db993e258b606704', 7, 1, 'MyApp', '[]', 0, '2020-11-17 13:25:13', '2020-11-17 13:25:13', '2021-11-17 07:25:13'),
('258cfb694b4d220ae33c96addf82a0658d9a0f4972ca023b946aa9515bd88cd4cb8340214eb3d5f9', 8, 1, 'MyApp', '[]', 0, '2020-12-03 19:46:19', '2020-12-03 19:46:19', '2021-12-03 14:46:19'),
('27c29ec54a90c56c8738a247c7b09be82bc0e3f95389431e35bcb0069b9a1390eac8671004657c81', 7, 1, 'MyApp', '[]', 0, '2020-11-18 21:01:05', '2020-11-18 21:01:05', '2021-11-18 15:01:05'),
('29b474205856e41d0eebab9a24a8a113b2879f9667e9a98ef4d11fe8e20d7336b6991d716ee3de08', 8, 1, 'MyApp', '[]', 0, '2020-11-27 16:34:46', '2020-11-27 16:34:46', '2021-11-27 10:34:46'),
('2a638fd7c44a41a114c56f330e24deb20024e63625c6498487856449b07eb4d4676695ab57e3365c', 8, 1, 'MyApp', '[]', 0, '2020-12-02 20:50:12', '2020-12-02 20:50:12', '2021-12-02 15:50:12'),
('2ac663280bb58b7b3b442778b14e7cd0133921d2ab297ebab91d06b369ae85f4af3ac36f5b6907aa', 8, 1, 'MyApp', '[]', 0, '2020-11-27 17:19:41', '2020-11-27 17:19:41', '2021-11-27 11:19:41'),
('2d93806e6e726dc09437d9e01d7f01e7e08fbcfecd4b769cc592a104f00f85edc5fbb5d8248cab5e', 5, 1, 'MyApp', '[]', 0, '2020-11-07 04:47:08', '2020-11-07 04:47:08', '2021-11-07 10:17:08'),
('2f8910b9c69f1a149440cebfbc76ea62766cd2820fab4cc311717abd44adbc834b371e606ec96ed0', 7, 1, 'MyApp', '[]', 0, '2020-11-17 22:34:31', '2020-11-17 22:34:31', '2021-11-17 16:34:31'),
('2f8fe45df2937b0d2fa9468d96f49bf2ee64029a1788ddcc162da80f4e139e41b2d18a05073599a8', 8, 1, 'MyApp', '[]', 0, '2020-11-25 14:40:30', '2020-11-25 14:40:30', '2021-11-25 08:40:30'),
('304e2f0c31edf5a70880b5315270808067c878e98247463f0c3c97c40605c3982adfcd3874943f99', 8, 1, 'MyApp', '[]', 0, '2020-11-26 09:51:03', '2020-11-26 09:51:03', '2021-11-26 03:51:03'),
('34add21b1127bc51340f318e2968849880d10f966834397846db7a4f4c85a3f1be7b362efa3af482', 7, 1, 'MyApp', '[]', 0, '2020-11-21 17:30:10', '2020-11-21 17:30:10', '2021-11-21 11:30:10'),
('373417b35c537fea91d181ecaa2f92868b0fe0911ddce5bb873fdd8d5fa2e0e39a37b5ab5fe1b72e', 8, 1, 'MyApp', '[]', 0, '2020-11-27 16:28:55', '2020-11-27 16:28:55', '2021-11-27 10:28:55'),
('38115b5d35b801e2a26fa23c319c7203e05953aa918cac2e749cd2c3a9fc842cddcb4242878825ca', 9, 1, 'MyApp', '[]', 0, '2020-12-04 16:20:49', '2020-12-04 16:20:49', '2021-12-04 11:20:49'),
('40c98acdac2eda312a89d9383d38ad807acedf31391525bb9786f3499f9fe11e165c5e5935a70aa2', 8, 1, 'MyApp', '[]', 0, '2020-11-26 11:02:31', '2020-11-26 11:02:31', '2021-11-26 05:02:31'),
('4102152b4399a7c02c3f427ec8b227041c576cb17873d71cc3e273400a2b54eaa8b0f77716a64fd5', 8, 1, 'MyApp', '[]', 0, '2020-11-24 13:40:08', '2020-11-24 13:40:08', '2021-11-24 07:40:08'),
('4128c9f82a00f0472e398e212950694eab148039f921884cfaf25a20a3571f76ca3e5de2fc5d0e21', 7, 1, 'MyApp', '[]', 0, '2020-11-17 22:15:50', '2020-11-17 22:15:50', '2021-11-17 16:15:50'),
('46b084cc1c6391d9a7175126b10506a1c43fea408b98b53a0712df9a4b546bbe34b506cba22a2014', 7, 1, 'MyApp', '[]', 0, '2020-12-02 13:29:50', '2020-12-02 13:29:50', '2021-12-02 08:29:50'),
('4d3a5560b8b7446582208eeb71fa3648dc3d3d3549a1e63fb053d64aa7cf100765aa4b2d0f1ff78d', 8, 1, 'MyApp', '[]', 0, '2020-11-26 15:09:53', '2020-11-26 15:09:53', '2021-11-26 09:09:53'),
('5158bdf503e9403884dc2f2ff59218fa025df1bbaecdfd9de4f1fc8fddcad0d8c5b967003e5370a0', 8, 1, 'MyApp', '[]', 0, '2020-12-02 09:58:02', '2020-12-02 09:58:02', '2021-12-02 04:58:02'),
('541652167f28ef8f1c2d2067892946e2efdbff5afe8c17e546ced387819c025a79083e964422f175', 8, 1, 'MyApp', '[]', 0, '2020-11-27 16:31:39', '2020-11-27 16:31:39', '2021-11-27 10:31:39'),
('54a425a238543fb5980be54b4003c618451630208f8ada5b1c1f7ab4152bf508e26bc445028b4cd7', 7, 1, 'MyApp', '[]', 0, '2020-11-20 20:42:09', '2020-11-20 20:42:09', '2021-11-20 14:42:09'),
('555e377b671c4468fde5a9eaeae80dc781a1ec041192c9e8ca52922604439755e0c52182946a8512', 7, 1, 'MyApp', '[]', 0, '2020-11-19 21:44:44', '2020-11-19 21:44:44', '2021-11-19 15:44:44'),
('581205c9cf3a3e227c7a6df9065c1daa5e6b35b3cb8abef55d07f3cfe37e8043d2bd0d4de8f31d11', 8, 1, 'MyApp', '[]', 0, '2020-12-03 20:18:34', '2020-12-03 20:18:34', '2021-12-03 15:18:34'),
('58488851324740a5be0dcc5d45ef4c25eb74e290945ac17d887a2b74962eabe5a34bda3c0fbd458f', 8, 1, 'MyApp', '[]', 0, '2020-12-01 17:26:20', '2020-12-01 17:26:20', '2021-12-01 12:26:20'),
('58dc5f108eb9344f100a855acf2c98e8c5586dd794ded184d0395c20fa781bcd61036492d08db827', 7, 1, 'MyApp', '[]', 0, '2020-11-18 12:15:44', '2020-11-18 12:15:44', '2021-11-18 06:15:44'),
('5a14e1519571a4fb806be65c4ffaa0b2d5726025e5b0424be7a4bbd604307080ebd72ffdadca46b0', 7, 1, 'MyApp', '[]', 0, '2020-11-17 14:54:08', '2020-11-17 14:54:08', '2021-11-17 08:54:08'),
('5c0c3fd18b84ef827c4f8d46e123b480bdcff4200ce7dd12cd0baee6346b5707ae446c56d8b3ddf9', 7, 1, 'MyApp', '[]', 0, '2020-11-25 04:38:23', '2020-11-25 04:38:23', '2021-11-24 22:38:23'),
('5d949247288266c18ac97c506de9021122389752212ecfa9299002d711dae507286b62f2eba083cf', 8, 1, 'MyApp', '[]', 0, '2020-12-02 19:18:57', '2020-12-02 19:18:57', '2021-12-02 14:18:57'),
('5db96ef35b8f19a68ac6702b15a1bfef1843d91d074a1a57055901ea5f4bd036b17a68e907a8a1de', 8, 1, 'MyApp', '[]', 0, '2020-12-02 09:58:02', '2020-12-02 09:58:02', '2021-12-02 04:58:02'),
('5fa687b19ae73dde8d9e060c940549f2dc6946edf9c755071dd79f696d25c468355139b8a1ee47f9', 8, 1, 'MyApp', '[]', 0, '2020-12-04 16:17:51', '2020-12-04 16:17:51', '2021-12-04 11:17:51'),
('611b0f06bc24e3fc6eb14303085960524c2a13c453e421c7e36be33c66182286d300767eb855b8ee', 8, 1, 'MyApp', '[]', 0, '2020-11-26 16:35:08', '2020-11-26 16:35:08', '2021-11-26 10:35:08'),
('659d37542effc77d1d27660465eb7de376cfb71021f0d9ea678722473929d0ac7043cf8d52928ff4', 8, 1, 'MyApp', '[]', 0, '2020-12-02 18:12:19', '2020-12-02 18:12:19', '2021-12-02 13:12:19'),
('69bc7698e86db189e8ee3f013750dd46a7c2e20c6b1c637037f689cbb3a03cb57e1445793e2c6dea', 8, 1, 'MyApp', '[]', 0, '2020-11-27 17:19:41', '2020-11-27 17:19:41', '2021-11-27 11:19:41'),
('7449ee071e3b0335dc7ff3bfb2b89abf8ec72cb919ae630fa944e6efddfd24a5a232492f3f9abaf5', 8, 1, 'MyApp', '[]', 0, '2020-11-24 20:55:17', '2020-11-24 20:55:17', '2021-11-24 14:55:17'),
('7683194e5201aad1bb3d9a29ef7ded2d769550d542af5a67ef5d89777e9b759a19d6bdb7bb6406c9', 8, 1, 'MyApp', '[]', 0, '2020-12-03 19:54:06', '2020-12-03 19:54:06', '2021-12-03 14:54:06'),
('7ac816f5b369fdda2046d59ae535aa4c60d1c8d29e22f184801e1df0488f398d895a2b97c11482d2', 8, 1, 'MyApp', '[]', 0, '2020-12-02 09:58:03', '2020-12-02 09:58:03', '2021-12-02 04:58:03'),
('7baadee475eb2770e0f163d83df2900a30cd1b824d02891ff4859f471e2556264ca6d8c4bb50d7d3', 7, 1, 'MyApp', '[]', 0, '2020-11-29 17:48:34', '2020-11-29 17:48:34', '2021-11-29 11:48:34'),
('7e3541e7cece5597867a429186c48aee91c0b2ce23920c78f4e5f519793cab4c5a560c33082bced2', 8, 1, 'MyApp', '[]', 0, '2020-11-28 18:28:06', '2020-11-28 18:28:06', '2021-11-28 12:28:06'),
('800f6f924e4b42f84d5d49721c5495ec81530275366b1aee6bd73270249b1e2ec63ccd8a92fa9fb7', 8, 1, 'MyApp', '[]', 0, '2020-12-02 18:13:50', '2020-12-02 18:13:50', '2021-12-02 13:13:50'),
('802c24cfc1423adbc98f4384baf8349f60aee0775ef4ccd07e54e3221d411e40eb768c5a3ddd8146', 9, 1, 'MyApp', '[]', 0, '2020-12-04 16:34:58', '2020-12-04 16:34:58', '2021-12-04 11:34:58'),
('83090792693dc8d4b925bb0edefbe2a3e8a81a52437ac0e78e04bba515739638dd5b99b517da3145', 5, 1, 'MyApp', '[]', 0, '2020-11-07 03:51:30', '2020-11-07 03:51:30', '2021-11-07 09:21:30'),
('91ef5979dddb3674ef389e69562b750b0c6df865ce1b28e1dd2f12a70d6809dbed1a5bba3849a753', 8, 1, 'MyApp', '[]', 0, '2020-11-28 18:05:09', '2020-11-28 18:05:09', '2021-11-28 12:05:09'),
('920b3de10dd58856bd8469655a36642608171178c0b778c8e6c0c45d9f43419488d90bea69861bbd', 7, 1, 'MyApp', '[]', 0, '2020-11-17 22:03:11', '2020-11-17 22:03:11', '2021-11-17 16:03:11'),
('930010a60e073eea7730d2e75ce05ad7e27bdf1f9dbc5fe83cbf3b7f85f7d682a8730707a2d43dd0', 7, 1, 'MyApp', '[]', 0, '2020-12-05 16:05:08', '2020-12-05 16:05:08', '2021-12-05 11:05:08'),
('95c0f6b70f984ab9208a0999e839f260a5a70708bf7b8731c4a4f724bb358cb5cbb69bf35a3f8a04', 8, 1, 'MyApp', '[]', 0, '2020-11-27 16:24:29', '2020-11-27 16:24:29', '2021-11-27 10:24:29'),
('96cc775c1cce36a8f8db7d0077f45fc0abe90863388e183b943f3dc9ca639214589ea09077f39371', 8, 1, 'MyApp', '[]', 0, '2020-12-01 11:25:07', '2020-12-01 11:25:07', '2021-12-01 06:25:07'),
('9887d3036dca9494e48034e04dff0f3752bab1c6520c64ea2675638714e9eb8ad4de227aba47bf36', 7, 1, 'MyApp', '[]', 0, '2020-11-17 22:20:02', '2020-11-17 22:20:02', '2021-11-17 16:20:02'),
('9a0eae30d681b4e796bd173f938cc9a3b047d2072ab3a12d9940784e7bf9383d4668a5e2fd87ba36', 8, 1, 'MyApp', '[]', 0, '2020-11-27 14:17:18', '2020-11-27 14:17:18', '2021-11-27 08:17:18'),
('9ae3c8131f0a1f375ce958d24bd140fdfae55036aab5594544169fed4aaba77f8a20eded0d82cff7', 7, 1, 'MyApp', '[]', 0, '2020-11-22 01:46:40', '2020-11-22 01:46:40', '2021-11-21 19:46:40'),
('9b4f82c6c8ac501a3c6641250b6907f9b402b4dfcba909069e44896551385eab0f02cdd4e33245a9', 7, 1, 'MyApp', '[]', 0, '2020-11-20 20:08:30', '2020-11-20 20:08:30', '2021-11-20 14:08:30'),
('9ce843500822c966009a33908c30c6e5d8404001b2677150c5783277c02e331b9a939e359d1a0033', 8, 1, 'MyApp', '[]', 0, '2020-12-05 15:15:54', '2020-12-05 15:15:54', '2021-12-05 10:15:54'),
('9e549e7d6f27a30d78a86cc97290d9a86e01253b067078bab9c1cc24214f3818a954dee24734eefa', 5, 1, 'MyApp', '[]', 0, '2020-11-07 04:47:19', '2020-11-07 04:47:19', '2021-11-07 10:17:19'),
('a1e2561c1418217b01dbe813ca9cc3589b8c55a68b8d5a27632370b54f36eedb227ed6949bc6cbcf', 7, 1, 'MyApp', '[]', 0, '2020-12-01 13:24:15', '2020-12-01 13:24:15', '2021-12-01 08:24:15'),
('a32224e2f0296b309b31efa468e8678af2cd618faa3cda070b5e0e086860c032c5778ad461ca4a73', 8, 1, 'MyApp', '[]', 0, '2020-12-01 16:19:02', '2020-12-01 16:19:02', '2021-12-01 11:19:02'),
('a3e0bc2d882860c6dc22b8fc58eb5b2fa6443c85edde2bca17dd9c5e43816181130d7aa66cbda4e7', 9, 1, 'MyApp', '[]', 0, '2020-12-04 16:49:53', '2020-12-04 16:49:53', '2021-12-04 11:49:53'),
('a5e528b58b51bddba270dbab89302c64238cbc5b4ca7ddbeacb6ada8b80ef0291dd11e8b901cd24c', 8, 1, 'MyApp', '[]', 0, '2020-12-02 09:58:03', '2020-12-02 09:58:03', '2021-12-02 04:58:03'),
('a7f4e982eaadceccbb7b2127e796f384d6cbb3dfee57fb460d060ff9d9a2d28cf26df8908edfc98c', 8, 1, 'MyApp', '[]', 0, '2020-12-05 11:31:37', '2020-12-05 11:31:37', '2021-12-05 06:31:37'),
('abe592637f2574088efc7cc15568fa3a5f41ecadc6d3b53dd2fbd2117b78b3665a1c7d5a84b18862', 8, 1, 'MyApp', '[]', 0, '2020-11-26 18:18:22', '2020-11-26 18:18:22', '2021-11-26 12:18:22'),
('ad2d31773fa13b0a324a81a378303dde0f53c63843c356ec5a8da4433dcce514e1480c5abbe61911', 8, 1, 'MyApp', '[]', 0, '2020-11-28 21:13:05', '2020-11-28 21:13:05', '2021-11-28 15:13:05'),
('b39e8bf89c7c8b6e2e11e4f19cf7da2c7156c9f2b2b66fa8387b7c9e185520fa1bd86fdbb2df9cab', 8, 1, 'MyApp', '[]', 0, '2020-11-25 16:03:37', '2020-11-25 16:03:37', '2021-11-25 10:03:37'),
('b5f7f9089ee59677565e48b4840f00740c4aae3deb86c37cc518a7a8e1adcb454b7c3c00cc05015c', 8, 1, 'MyApp', '[]', 0, '2020-12-02 11:40:41', '2020-12-02 11:40:41', '2021-12-02 06:40:41'),
('b64255a62ee501ba06a15529d32f05ae75a456ee6dc15e6c384831a5bab39b072994e46e4f1471d6', 7, 1, 'MyApp', '[]', 0, '2020-11-20 15:28:20', '2020-11-20 15:28:20', '2021-11-20 09:28:20'),
('bfb2f4d19755a899c6c9d2207174b16d50da76166c3813777e7c196dd37fb23bd9bff224448f1b97', 7, 1, 'MyApp', '[]', 0, '2020-11-20 20:16:16', '2020-11-20 20:16:16', '2021-11-20 14:16:16'),
('c2f4133437e90faa1d50a542fa9d3c8582e37284a35f61aba97b7fa2c32749258c8a099082154373', 5, 1, 'MyApp', '[]', 0, '2020-11-07 02:11:55', '2020-11-07 02:11:55', '2021-11-07 07:41:55'),
('c819b9fdb59d3817e9e413db78b4a0c65e560b954b3a206666659665bc5ba605a01d6211555eea4f', 7, 1, 'MyApp', '[]', 0, '2020-11-21 16:34:42', '2020-11-21 16:34:42', '2021-11-21 10:34:42'),
('c9e36ae409b16a8cd8ebb752c954c4bb0a256d9abc75bf2e7f304e4a19b58fe4ca2a6c8647f73661', 8, 1, 'MyApp', '[]', 0, '2020-11-28 13:01:08', '2020-11-28 13:01:08', '2021-11-28 07:01:08'),
('cb88315cf9ddecf841e54144d481f93e2d728543415f6ddc1d6ec312ace913b345424744df0c5d2e', 7, 1, 'MyApp', '[]', 0, '2020-11-18 11:15:55', '2020-11-18 11:15:55', '2021-11-18 05:15:55'),
('cc339b04f3ac6f0400ce5f070409ec13924930154fbe6bd864ed6a3138330a6ccf935df118a78f43', 8, 1, 'MyApp', '[]', 0, '2020-12-03 20:37:27', '2020-12-03 20:37:27', '2021-12-03 15:37:27'),
('ced73ab559413f5cc0fafdc9384a68aa3db18f947fd1581210d412957addb5f2538e5d2ddf76fc0d', 7, 1, 'MyApp', '[]', 0, '2020-11-29 21:54:34', '2020-11-29 21:54:34', '2021-11-29 15:54:34'),
('d090acaf031e365ece9823a1ad42b958754c4956f6b15cadf85028a30bebf1ee81885be7053af599', 8, 1, 'MyApp', '[]', 0, '2020-11-25 20:07:50', '2020-11-25 20:07:50', '2021-11-25 14:07:50'),
('d28b9d4795561b72a3d049d0aaf17f8b1788214c531bed69e9473fbc2c2716911f04f471b4ef135a', 8, 1, 'MyApp', '[]', 0, '2020-11-28 17:44:48', '2020-11-28 17:44:48', '2021-11-28 11:44:48'),
('d3734532092b5396e3adaa76c66457bd5bb1543fd3a9d0f5049ff000f426c55b9aa7fc9926b72412', 8, 1, 'MyApp', '[]', 0, '2020-12-01 12:39:41', '2020-12-01 12:39:41', '2021-12-01 07:39:41'),
('d6f46d9f177322e2dd8dba29badd41d9bd7c7f46c628994aaca995ee4d256d83fc286a9b4bd70674', 7, 1, 'MyApp', '[]', 0, '2020-11-21 14:50:05', '2020-11-21 14:50:05', '2021-11-21 08:50:05'),
('d851a4d8088369f9520bb7dc1429aa319ff07cbd994b52a5d33186c687d546f5b29e59cac7640e35', 8, 1, 'MyApp', '[]', 0, '2020-11-27 20:13:10', '2020-11-27 20:13:10', '2021-11-27 14:13:10'),
('d9dbffba24b31f5bd2dfe96dc7f6ee9f8c116465b7ae07e5cf9c2891b3b55f0fa784dac27f516c51', 7, 1, 'MyApp', '[]', 0, '2020-11-17 22:02:05', '2020-11-17 22:02:05', '2021-11-17 16:02:05'),
('da431737c4e8d493a59be78aeed38daab7d6a8e8d0940b142d0f3bdc20305442e4db3a6845dcb539', 8, 1, 'MyApp', '[]', 0, '2020-11-28 13:01:08', '2020-11-28 13:01:08', '2021-11-28 07:01:08'),
('da896b397af58b157238f478eb07d640e8fc252cf618377e3f38bfc6773f89453fb0205db502e640', 8, 1, 'MyApp', '[]', 0, '2020-12-05 17:32:25', '2020-12-05 17:32:25', '2021-12-05 12:32:25'),
('db4e62601990acce2e1e6989c1c2c69ae81408b385e0d60cc3cdf3e26e4560402d07c63f891590a2', 8, 1, 'MyApp', '[]', 0, '2020-11-28 15:06:10', '2020-11-28 15:06:10', '2021-11-28 09:06:10'),
('dcc61073abbefc8b48a7dd1864e620a459a25ad2741eef199acbbad426380bb191e4a28a367e6a13', 7, 1, 'MyApp', '[]', 0, '2020-11-20 14:56:05', '2020-11-20 14:56:05', '2021-11-20 08:56:05'),
('e22e59bcbeeb2c5600ed6ba373b027dfd823184f7a6202889c888cdf3ee4afbad66e4f8111c02228', 7, 1, 'MyApp', '[]', 0, '2020-11-21 11:36:54', '2020-11-21 11:36:54', '2021-11-21 05:36:54'),
('e4f772f0616cf280b8344746501e1077728a3b6116291c2c61c0c0caa44f40305e93e12a8231bdb2', 7, 1, 'MyApp', '[]', 0, '2020-12-03 12:20:39', '2020-12-03 12:20:39', '2021-12-03 07:20:39'),
('e848fe913e0189021d8ccd60f199f585856dc501a9964ade506fdb53922bda7a080908249a1b1657', 7, 1, 'MyApp', '[]', 0, '2020-11-26 04:20:17', '2020-11-26 04:20:17', '2021-11-25 22:20:17'),
('ed5c8982a42eaeecbf5c7154a2232743ff68ff5c0b85e40488ad53cc73b82b2d18423e16400722c3', 8, 1, 'MyApp', '[]', 0, '2020-11-27 17:19:32', '2020-11-27 17:19:32', '2021-11-27 11:19:32'),
('f16568a55f6a4a6311d27c86a630bdafbaa80172ebb39555006680023fffd3212b3179aaefea7ef8', 8, 1, 'MyApp', '[]', 0, '2020-12-02 18:14:55', '2020-12-02 18:14:55', '2021-12-02 13:14:55'),
('f41b47e07857ac561c8f41f7dde87569d2b82cbbfd3709988ac2279d291da4086ebe14906576195a', 8, 1, 'MyApp', '[]', 0, '2020-12-02 08:34:20', '2020-12-02 08:34:20', '2021-12-02 03:34:20'),
('f44bd173c23665d1793dff636a9795683131d817c67cc4755ee17e52c951ecf56908c8556fb15d33', 8, 1, 'MyApp', '[]', 0, '2020-11-27 16:24:28', '2020-11-27 16:24:28', '2021-11-27 10:24:28'),
('f4a9e175c0db7575af643016d7fcefda2d6a866d81687a7fd0f19ca5c3ac0800354215f76d9b2d49', 8, 1, 'MyApp', '[]', 0, '2020-11-28 12:48:18', '2020-11-28 12:48:18', '2021-11-28 06:48:18'),
('f5daef869135d448dc59923c4ebaba930ba0fce288970b6df8ff8d017f052e0703c91f776409f9f0', 5, 1, 'MyApp', '[]', 0, '2020-11-07 04:47:30', '2020-11-07 04:47:30', '2021-11-07 10:17:30'),
('f9c8c13b56a234f5da550092af96619fdaf7a7892f186ca48d07725b8f8e69a1a3f2a3049112b7e1', 8, 1, 'MyApp', '[]', 0, '2020-11-26 18:21:00', '2020-11-26 18:21:00', '2021-11-26 12:21:00'),
('fbd3d719e09c1454501e0d4f356d435dd5c111deee27a1536866b3e28952029fb1505238b0228cd6', 8, 1, 'MyApp', '[]', 0, '2020-12-05 19:03:02', '2020-12-05 19:03:02', '2021-12-05 14:03:02');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Concierge Personal Access Client', 'YXakwCed5hu26gRKOCAZg8KSuiVStjYtSAeAAjfD', NULL, 'http://localhost', 1, 0, 0, '2020-11-07 01:26:34', '2020-11-07 01:26:34'),
(2, NULL, 'Concierge Password Grant Client', 'Q8Fa7lc5aJ7OylsStTgZCBxbjqUT3hqiLvmnOmz5', 'users', 'http://localhost', 0, 1, 0, '2020-11-07 01:26:34', '2020-11-07 01:26:34');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2020-11-07 01:26:34', '2020-11-07 01:26:34');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `content` text DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `content`, `status`, `created_at`, `updated_at`) VALUES
(1, 'about us', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '1', '2020-12-03 07:03:56', '2020-12-03 01:33:56');

-- --------------------------------------------------------

--
-- Table structure for table `parcels`
--

CREATE TABLE `parcels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `total_parcel` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `parcels`
--

INSERT INTO `parcels` (`id`, `company_id`, `unit_id`, `total_parcel`, `name`, `comment`, `status`, `created_at`, `updated_at`) VALUES
(7, 5, 12, '2', 'John', NULL, 1, '2020-11-12 08:21:55', '2020-11-12 08:46:28'),
(9, 5, 12, '12', NULL, NULL, 0, '2020-11-24 15:39:25', '2020-11-24 15:39:25'),
(10, 5, 14, '10', 'Smith', 'Parcel Collected', 1, '2020-11-25 18:50:29', '2020-11-25 18:53:55'),
(11, 5, 12, '12', NULL, NULL, 0, '2020-11-28 21:13:51', '2020-11-28 21:13:51'),
(12, 5, 12, '12', NULL, NULL, 0, '2020-11-28 21:13:59', '2020-11-28 21:13:59'),
(13, 5, 12, '10', NULL, NULL, 0, '2020-11-28 21:16:10', '2020-11-28 21:16:10'),
(14, 5, 13, '1', NULL, NULL, 0, '2020-11-29 22:02:06', '2020-12-01 13:06:19'),
(15, 5, 12, '10', NULL, NULL, 0, '2020-12-01 21:47:56', '2020-12-01 21:47:56'),
(16, 5, 12, '12', NULL, NULL, 0, '2020-12-01 21:57:16', '2020-12-01 21:57:16'),
(17, 5, 14, '10', NULL, NULL, 0, '2020-12-04 16:48:14', '2020-12-04 16:48:14'),
(18, 5, 12, '12', NULL, NULL, 0, '2020-12-05 11:27:26', '2020-12-05 11:27:26'),
(19, 5, 12, '10', NULL, NULL, 0, '2020-12-05 11:27:40', '2020-12-05 11:27:40'),
(20, 5, 12, '14', NULL, NULL, 0, '2020-12-05 11:30:00', '2020-12-05 11:30:00'),
(21, 5, 12, '14', NULL, NULL, 0, '2020-12-05 11:32:23', '2020-12-05 11:32:23'),
(22, 5, 12, '14', NULL, NULL, 0, '2020-12-05 11:32:39', '2020-12-05 11:32:39');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `polls`
--

CREATE TABLE `polls` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `poll_valid_until` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `polls`
--

INSERT INTO `polls` (`id`, `company_id`, `title`, `status`, `poll_valid_until`, `created_at`, `updated_at`) VALUES
(2, 5, 'Bike Parking', 1, '2020-11-27', '2020-11-05 07:55:02', '2020-11-27 15:11:43'),
(8, 5, 'Car Parking', 1, '2020-12-11', '2020-12-01 21:47:34', '2020-12-01 21:47:34'),
(9, 5, 'Nee a Gym ?', 1, '2020-12-05', '2020-12-01 21:56:51', '2020-12-01 21:56:51'),
(10, 5, 'Need a Swimming Pull', 1, '2020-12-11', '2020-12-04 16:47:39', '2020-12-04 16:47:39');

-- --------------------------------------------------------

--
-- Table structure for table `polls_options`
--

CREATE TABLE `polls_options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `poll_id` bigint(20) UNSIGNED NOT NULL,
  `option` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `polls_options`
--

INSERT INTO `polls_options` (`id`, `poll_id`, `option`, `created_at`, `updated_at`) VALUES
(14, 2, 'Yes', '2020-11-05 07:55:02', '2020-11-24 16:25:22'),
(15, 2, 'No', '2020-11-05 07:55:02', '2020-11-24 16:25:22'),
(16, 2, 'Don\'t know', '2020-11-05 07:55:02', '2020-11-24 16:25:22'),
(29, 8, 'yes', '2020-12-01 21:47:34', '2020-12-01 21:47:34'),
(30, 8, 'No', '2020-12-01 21:47:34', '2020-12-01 21:47:34'),
(31, 9, 'Yes', '2020-12-01 21:56:51', '2020-12-01 21:56:51'),
(32, 9, 'NO', '2020-12-01 21:56:51', '2020-12-01 21:56:51'),
(33, 10, 'Yes', '2020-12-04 16:47:39', '2020-12-04 16:47:39'),
(34, 10, 'No', '2020-12-04 16:47:39', '2020-12-04 16:47:39');

-- --------------------------------------------------------

--
-- Table structure for table `polls_votes`
--

CREATE TABLE `polls_votes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `poll_id` bigint(20) UNSIGNED NOT NULL,
  `option_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `polls_votes`
--

INSERT INTO `polls_votes` (`id`, `user_id`, `poll_id`, `option_id`, `created_at`, `updated_at`) VALUES
(14, 8, 2, 14, '2020-11-27 15:52:17', '2020-11-27 15:52:17'),
(17, 7, 9, 31, '2020-12-03 12:26:38', '2020-12-03 12:26:38'),
(23, 8, 9, 31, '2020-12-03 14:19:52', '2020-12-03 14:19:52'),
(24, 8, 8, 30, '2020-12-03 14:25:31', '2020-12-03 14:25:31'),
(25, 9, 10, 33, '2020-12-04 16:52:21', '2020-12-04 16:52:21'),
(26, 9, 8, 29, '2020-12-04 16:59:14', '2020-12-04 16:59:14'),
(27, 7, 10, 33, '2020-12-05 16:12:18', '2020-12-05 16:12:18');

-- --------------------------------------------------------

--
-- Table structure for table `real_estates`
--

CREATE TABLE `real_estates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `beds` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `baths` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lease_length` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `furnished` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL,
  `facilities` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `images` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `availability` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enquiry_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Active','Inactive','Let Agreed','Sale Agreed') COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiry_date` datetime NOT NULL,
  `property_type` enum('For Rent','For Sale') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `real_estates`
--

INSERT INTO `real_estates` (`id`, `company_id`, `user_id`, `title`, `description`, `price`, `address`, `beds`, `baths`, `lease_length`, `furnished`, `facilities`, `images`, `availability`, `email`, `phone`, `enquiry_by`, `status`, `expiry_date`, `property_type`, `created_at`, `updated_at`) VALUES
(1, 5, 8, 'Lorem Ipsum', 'simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever.', 325, 'middle east andhra Uk', '2', '3', '3 Months', 'No', '', '16079613120.png', '3 Months', 'test1@gmail.com', '12324324324', 'Email only', 'Active', '0000-00-00 00:00:00', 'For Rent', '2020-12-12 18:24:18', '2020-12-12 18:24:18'),
(2, 9, 9, 'Simply Dummy', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum', 421, '23/4 apartment Uk', '2', '3', '3 Months', 'No', '', '16079613120.png	', '3 Months', 'testemail@gmail.com', '12324324324', 'Email only', 'Active', '0000-00-00 00:00:00', 'For Rent', '2020-12-12 18:25:42', '2020-12-12 18:25:42'),
(3, 5, 8, 'Nonfreehold Estates', 'Also known as a leasehold estate, nonfreehold estates are created through written and oral leases and rental agreements.', 854, '22 peoples bank UK', '1', '2', '3 Months', 'No', '', '16079613120.png', 'Immediately', 'fhdfgfg@gmail.com', '1288658886', 'Email only', 'Inactive', '0000-00-00 00:00:00', 'For Sale', '2020-12-14 20:55:12', '2020-12-14 20:55:12'),
(4, 5, 8, 'Real Property', 'Real property is the land, everything that is permanently attached to the land, and all of the rights of ownership, including the right to possess, sell, lease, and enjoy the land.', 1547, '22/02 greenset USA', '1', '2', '3 Months', 'No', '', '16079613130.png', 'Immediately', 'fhdfgfg@gmail.com', '1288658886', 'Email only', 'Inactive', '0000-00-00 00:00:00', 'For Sale', '2020-12-14 20:55:13', '2020-12-14 20:55:13');

-- --------------------------------------------------------

--
-- Table structure for table `reason_for_visits`
--

CREATE TABLE `reason_for_visits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `reason` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reason_for_visits`
--

INSERT INTO `reason_for_visits` (`id`, `company_id`, `reason`, `created_at`, `updated_at`) VALUES
(5, 5, 'Meeting', '2020-11-05 08:36:29', '2020-11-05 08:36:29');

-- --------------------------------------------------------

--
-- Table structure for table `seos`
--

CREATE TABLE `seos` (
  `id` int(11) DEFAULT NULL,
  `page_title` text DEFAULT NULL,
  `seo_title` text DEFAULT NULL,
  `seo_keyword` text DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `seos`
--

INSERT INTO `seos` (`id`, `page_title`, `seo_title`, `seo_keyword`, `seo_description`, `created_at`, `updated_at`) VALUES
(1, 'General SEO', 'General SEO Title', '<p>General SEO Keyword</p>', '<p>General SEO Description</p>', '2020-12-02 12:46:55', '2020-12-02 17:46:55');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `service_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_provider_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `company_id`, `service_name`, `service_provider_name`, `contact_number`, `mobile_number`, `email`, `address`, `status`, `created_at`, `updated_at`) VALUES
(7, 5, 'Electrical Repair', 'Electro Services', '01132242342', '98668838', 'Electro@gmail.com', 'Electro Services, London, UK', 1, '2020-11-12 07:03:18', '2020-11-12 07:21:36'),
(8, 5, 'Repair of Windows', 'SOftech', '01834567', '988933450', 'softech@gmail.com', 'Softech, , London, UK', 1, '2020-11-12 07:03:18', '2020-11-12 07:21:36'),
(9, 5, 'Home Repair Services', 'Handyman', '01822345', '8078293440', 'handyman@gmail.com', ' Seattle, Northeast Seattle', 1, '2020-11-12 07:03:18', '2020-11-12 07:21:36'),
(10, 5, 'Water Filtration & Purification', 'Natures Water', '02038690234', '999234560', 'Natures@gmail.com', ' Drury Lane, London, WC2B 5TA', 1, '2020-11-12 07:03:18', '2020-11-12 07:21:36'),
(11, 5, 'cleaning services test', 'Egham cleaning services test', '0748598345', '88834509', 'egham@gmail.com', 'Shelton St, London, WC2H 9JQ', 0, '2020-11-12 07:03:18', '2020-11-27 14:56:30'),
(35, 7, 'Demo', 'Demo Name', '7956237412', '7956237418', 'demo@joykal.com', 'test', 1, '2020-11-19 20:01:56', '2020-11-22 02:17:19'),
(43, 8, 'Demo', 'Demo Name', '079562374', '079562374', 'ravi78@joykal.com', '11 , indranil Apartment , ahmedabad', 1, '2020-12-02 17:17:19', '2020-12-02 17:17:19'),
(45, 5, 'Accommodation Service', 'william Smith', '8557496321', '07956237412', 'smith@joykal.com', '11 , indranil Apartment , london', 1, '2020-12-04 16:38:45', '2020-12-04 16:38:45'),
(46, 5, 'New Cleaning Services', 'Mark josua', '0784512035', '07956237412', 'ansley@gmail.com', '11 , indranil Apartment , ahmedabad', 1, '2020-12-04 16:44:22', '2020-12-04 16:44:22');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contact_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_apartment_price` double DEFAULT NULL,
  `currency_symbol` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firebase_server_key` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `contact_no`, `email`, `address`, `logo`, `default_apartment_price`, `currency_symbol`, `firebase_server_key`, `created_at`, `updated_at`) VALUES
(1, '01980460', 'contact@apatly.co.uk.', 'Thames River, tower bridge, London UK', '1604063529aptly.png', 50, '£', 'AAAA9wUAtUE:APA91bFmwxEfm5FX_kmgaSSQRBUlM8sxww9tRGJLKlaWshNGY56SHvJiY02Jwow1OjtSl_VTX6T9ohdFRscUzi-EVZDfMUCV7da01GI1ovKwaFWdHizP64cM0eHMBynZe15f8CU5gPvG', NULL, '2020-11-28 20:46:10');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_plan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `user_id`, `name`, `stripe_id`, `stripe_status`, `stripe_plan`, `quantity`, `trial_ends_at`, `ends_at`, `created_at`, `updated_at`) VALUES
(4, 6, 'main', 'sub_IKiWygQt1uXTjJ', 'active', '7766644486', 1, NULL, NULL, '2020-11-05 02:10:49', '2020-11-05 02:10:49'),
(5, 7, 'main', 'sub_IPBhNNtng6hs8T', 'active', '8287911131', 1, NULL, NULL, '2020-11-17 00:35:36', '2020-11-17 00:35:36'),
(6, 8, 'main', 'sub_IPBonzcSJtuy4t', 'active', '2736255759', 1, NULL, NULL, '2020-11-17 12:12:44', '2020-11-17 12:12:44'),
(7, 10, 'main', 'sub_IVbh2idayRIr3c', 'active', '3746533874', 1, NULL, NULL, '2020-12-04 14:21:54', '2020-12-04 14:21:54');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_items`
--

CREATE TABLE `subscription_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subscription_id` bigint(20) UNSIGNED NOT NULL,
  `stripe_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_plan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscription_items`
--

INSERT INTO `subscription_items` (`id`, `subscription_id`, `stripe_id`, `stripe_plan`, `quantity`, `created_at`, `updated_at`) VALUES
(4, 4, 'si_IKiWquzuITIHGd', '7766644486', 1, '2020-11-05 02:10:49', '2020-11-05 02:10:49'),
(5, 5, 'si_IPBh8vjdA9ZVF7', '8287911131', 1, '2020-11-17 00:35:36', '2020-11-17 00:35:36'),
(6, 6, 'si_IPBo5PcpHPGUmv', '2736255759', 1, '2020-11-17 12:12:45', '2020-11-17 12:12:45'),
(7, 7, 'si_IVbhC6O6Onxnnx', '3746533874', 1, '2020-12-04 14:21:54', '2020-12-04 14:21:54');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `payment_status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `payment_status`, `amount`, `note`, `created_at`, `updated_at`) VALUES
(4, 6, '1', '6150', NULL, '2020-11-05 02:10:49', '2020-11-05 02:10:49'),
(5, 7, '1', '6150', NULL, '2020-11-17 00:35:36', '2020-11-17 00:35:36'),
(6, 8, '1', '6700', NULL, '2020-11-17 12:12:45', '2020-11-17 12:12:45'),
(7, 10, '1', '0', NULL, '2020-12-04 14:21:54', '2020-12-04 14:21:54');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `block_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `flat_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `company_id`, `block_number`, `flat_number`, `created_at`, `updated_at`) VALUES
(12, 5, 'A', '101', '2020-11-05 08:37:09', '2020-11-05 08:37:09'),
(13, 5, 'A', '102', '2020-11-06 08:55:11', '2020-11-06 08:55:11'),
(14, 5, 'C', '301', '2020-11-22 04:26:46', '2020-11-22 04:26:46');

-- --------------------------------------------------------

--
-- Table structure for table `unit_issue_requests`
--

CREATE TABLE `unit_issue_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `issue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `unit_issue_requests`
--

INSERT INTO `unit_issue_requests` (`id`, `company_id`, `unit_id`, `user_id`, `issue`, `status`, `comment`, `created_at`, `updated_at`) VALUES
(3, 5, 12, 5, 'Water leakage', 1, NULL, '2020-11-10 18:30:00', '2020-11-10 23:52:18'),
(4, 5, 13, 7, 'Lift is not working', 0, NULL, '2020-11-10 18:30:00', '2020-11-10 23:52:18'),
(5, 5, 12, 8, 'Water leakage', 1, 'Test', '2020-11-10 18:30:00', '2020-11-25 18:58:05'),
(11, 5, 12, 8, 'Electricity Problem', 0, NULL, '2020-11-28 18:31:54', '2020-11-28 18:31:54'),
(12, 5, 13, 7, 'Fire alarm is not working in Block1', 0, NULL, '2020-11-29 21:53:38', '2020-11-29 21:53:38'),
(23, 5, 12, 8, 'water leakage', 2, 'ss', '2020-12-01 12:21:18', '2020-12-01 13:06:29'),
(28, 5, 12, 8, 'Electricity problem', 0, NULL, '2020-12-03 20:19:54', '2020-12-03 20:19:54'),
(29, 5, 14, 9, 'water leaks problem', 0, NULL, '2020-12-04 16:22:39', '2020-12-04 16:22:39'),
(30, 5, 14, 9, 'Electricity Problem', 0, NULL, '2020-12-04 16:50:56', '2020-12-04 16:50:56'),
(31, 5, 14, 9, 'water Pump Problem', 0, NULL, '2020-12-04 16:57:42', '2020-12-04 16:57:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` enum('company','owner','gatekeeper','tenant') COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stripe_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_brand` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_last_four` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `user_type`, `remember_token`, `created_at`, `updated_at`, `stripe_id`, `card_brand`, `card_last_four`, `trial_ends_at`) VALUES
(6, 'Johnson Kamni', 'dhaval.bera@joykal.com', NULL, '$2y$10$RFbemUbuGqCg3Pi60pmd0eoFgzdYxA3bzlTyPMsHqN2RBRtTjhZBq', 'company', 'im5lA6emwUd3XW5Vzw2tvXxsGTcntdKVejnpkLWv7lHQHUQMzLNicONqEPF1', '2020-11-05 02:09:38', '2020-11-21 13:07:43', 'cus_IKiWbPWasmy0jc', 'visa', '4242', NULL),
(7, 'Adam Bings', 'dhaval@gmail.com', NULL, '$2y$10$L5omnyAca4KepG2EgUAtX.vGEshzkIXkF7UKfzERsscXFyeCEjoVK', 'company', NULL, '2020-11-17 00:34:36', '2020-11-21 13:06:32', 'cus_IPBhL1TmT5qCDz', 'visa', '4242', NULL),
(8, 'John Mark', 'dhaval123@gmail.com', NULL, '$2y$10$PGj95BJI4cBZpAl.db/8wuRDYzthha56hsAQSSEkkIZfxP6uJJSfy', 'company', NULL, '2020-11-17 12:11:23', '2020-11-21 13:05:12', 'cus_IPBo4z1cSC1iU8', 'visa', '4242', NULL),
(9, 'Chandlar Bings', 'chandlarbings@gmail.com', NULL, '$2y$10$.6t/Yg9mJg9pkVT7mTAopOP1n2WNW2e1YCkRMy2S2MJTE8woSpKnG', 'company', NULL, '2020-11-28 16:07:17', '2020-11-28 16:07:17', NULL, NULL, NULL, NULL),
(10, 'John Williams', 'ravi@joykal.com', NULL, '$2y$10$S7IUM3bd/Af7IS9Qlf72F.rsp3gYpMeH00biXghy.Gus0JYO2yknK', 'company', NULL, '2020-12-04 10:38:54', '2020-12-04 14:23:30', 'cus_IVbhoF69T5uu0d', 'visa', '4242', NULL),
(11, 'keisha mason', 'ansley@gmail.com', NULL, '$2y$10$FAZdNl1fD1KzvX2u58.SpuoWjq9VVaYPqOC7BNnO9gVTGO8cfNGxe', 'company', NULL, '2020-12-17 23:57:32', '2020-12-17 23:57:32', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_feeds`
--

CREATE TABLE `user_feeds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `feed` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `properties` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `feed_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_feeds`
--

INSERT INTO `user_feeds` (`id`, `user_id`, `feed`, `properties`, `feed_type`, `created_at`, `updated_at`) VALUES
(2, 9, 'Hello', '{\"image\":\"160879518385786c0f-9d6b-48e4-9cb0-589cd1717b94-145e0c53-f23b-4506-9f43-4930edb588b9_compressed_40.jpg\"}', 'status', '2020-12-24 02:03:03', '2020-12-24 03:16:50');

-- --------------------------------------------------------

--
-- Table structure for table `user_feeds_likes`
--

CREATE TABLE `user_feeds_likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `feed_id` bigint(20) UNSIGNED NOT NULL,
  `friend_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_feeds_likes`
--

INSERT INTO `user_feeds_likes` (`id`, `feed_id`, `friend_id`, `created_at`, `updated_at`) VALUES
(2, 2, 7, '2020-12-24 03:28:52', '2020-12-24 03:28:52'),
(3, 2, 8, '2020-12-24 03:29:41', '2020-12-24 03:29:41');

-- --------------------------------------------------------

--
-- Table structure for table `user_feed_comments`
--

CREATE TABLE `user_feed_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `feed_id` bigint(20) UNSIGNED NOT NULL,
  `friend_id` bigint(20) UNSIGNED NOT NULL,
  `comment` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_feed_comments`
--

INSERT INTO `user_feed_comments` (`id`, `feed_id`, `friend_id`, `comment`, `created_at`, `updated_at`) VALUES
(1, 2, 7, 'Hello new', '2020-12-24 03:43:56', '2020-12-24 03:43:56'),
(2, 2, 6, 'Hello new', '2020-12-24 03:45:37', '2020-12-24 03:45:37');

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `gate_id` bigint(20) UNSIGNED NOT NULL,
  `reason_id` bigint(20) UNSIGNED NOT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `check_in_date` date NOT NULL,
  `check_in_time` time NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visitor_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vehicle_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check_out_date` date DEFAULT NULL,
  `check_out_time` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`id`, `company_id`, `gate_id`, `reason_id`, `unit_id`, `check_in_date`, `check_in_time`, `description`, `visitor_name`, `id_number`, `id_name`, `vehicle_number`, `check_out_date`, `check_out_time`, `created_at`, `updated_at`) VALUES
(6, 5, 8, 5, 13, '2020-11-10', '11:25:00', 'Lynns Wood, The Ham, Westbury, Wiltshire, BA13 4HD', 'Ale Sanchez', '116080257', NULL, 'GMG 77', '2020-11-10', '17:41:00', '2020-11-11 00:26:08', '2020-11-22 04:42:24'),
(33, 5, 8, 5, 12, '2020-11-19', '22:39:00', '29 Kings Road, Walton On Thames, Surrey, KT12 2RB', 'Maria Arbona', '2C9821', NULL, 'MS839', '2020-11-19', '22:41:00', '2020-11-22 04:41:13', '2020-11-22 04:41:33'),
(34, 5, 8, 5, 14, '2020-11-04', '16:32:00', 'test address', 'Mark Henry', '852741', 'Proof ID', '96854', '2020-11-18', '16:33:00', '2020-11-25 17:03:09', '2020-11-28 17:59:43'),
(35, 5, 9, 5, 13, '2020-11-29', '16:02:00', 'London', 'Martin', '0808080', 'Driving License', NULL, NULL, NULL, '2020-11-29 22:05:19', '2020-11-29 22:05:19'),
(36, 5, 8, 5, 14, '2020-12-04', '17:14:00', '11 post apartments', 'Mark Henry', '852741', 'Proof ID', '96854', NULL, NULL, '2020-12-04 16:45:28', '2020-12-04 16:45:28'),
(38, 5, 8, 5, 12, '2020-12-05', '19:34:00', 'sdsad', 'asd', 'asdas', 'aasdsa', 'asd', NULL, NULL, '2020-12-05 19:04:43', '2020-12-05 19:04:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `adverts`
--
ALTER TABLE `adverts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_users`
--
ALTER TABLE `app_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `app_users_email_unique` (`email`),
  ADD KEY `app_users_company_id_foreign` (`company_id`),
  ADD KEY `app_users_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `companies_email_unique` (`email`),
  ADD UNIQUE KEY `companies_mobile_unique` (`mobile`),
  ADD KEY `companies_user_id_foreign` (`user_id`);

--
-- Indexes for table `company_settings`
--
ALTER TABLE `company_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_settings_company_id_foreign` (`company_id`);

--
-- Indexes for table `concierges`
--
ALTER TABLE `concierges`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `concierges_email_unique` (`email`),
  ADD KEY `concierges_company_id_foreign` (`company_id`),
  ADD KEY `concierges_gate_id_foreign` (`gate_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emergency_alarms`
--
ALTER TABLE `emergency_alarms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emergency_alarms_company_id_foreign` (`company_id`);

--
-- Indexes for table `emergency_alarms_responses`
--
ALTER TABLE `emergency_alarms_responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emergency_alarms_responses_alarm_id_foreign` (`alarm_id`),
  ADD KEY `emergency_alarms_responses_user_id_foreign` (`user_id`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `facilities_options`
--
ALTER TABLE `facilities_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gates`
--
ALTER TABLE `gates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gates_company_id_foreign` (`company_id`);

--
-- Indexes for table `loyalty_cards`
--
ALTER TABLE `loyalty_cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loyalty_cards_company_id_foreign` (`company_id`);

--
-- Indexes for table `message_boards`
--
ALTER TABLE `message_boards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_boards_company_id_foreign` (`company_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parcels`
--
ALTER TABLE `parcels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parcels_company_id_foreign` (`company_id`),
  ADD KEY `parcels_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `polls`
--
ALTER TABLE `polls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `polls_company_id_foreign` (`company_id`);

--
-- Indexes for table `polls_options`
--
ALTER TABLE `polls_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `polls_options_poll_id_foreign` (`poll_id`);

--
-- Indexes for table `polls_votes`
--
ALTER TABLE `polls_votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `polls_votes_user_id_foreign` (`user_id`),
  ADD KEY `polls_votes_poll_id_foreign` (`poll_id`),
  ADD KEY `polls_votes_option_id_foreign` (`option_id`);

--
-- Indexes for table `real_estates`
--
ALTER TABLE `real_estates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `real_estates_company_id_foreign` (`company_id`),
  ADD KEY `real_estates_user_id_foreign` (`user_id`);

--
-- Indexes for table `reason_for_visits`
--
ALTER TABLE `reason_for_visits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reason_for_visits_company_id_foreign` (`company_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscriptions_user_id_stripe_status_index` (`user_id`,`stripe_status`);

--
-- Indexes for table `subscription_items`
--
ALTER TABLE `subscription_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscription_items_subscription_id_stripe_plan_unique` (`subscription_id`,`stripe_plan`),
  ADD KEY `subscription_items_stripe_id_index` (`stripe_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_user_id_foreign` (`user_id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `units_company_id_foreign` (`company_id`);

--
-- Indexes for table `unit_issue_requests`
--
ALTER TABLE `unit_issue_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `unit_issue_requests_company_id_foreign` (`company_id`),
  ADD KEY `unit_issue_requests_unit_id_foreign` (`unit_id`),
  ADD KEY `unit_issue_requests_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_stripe_id_index` (`stripe_id`);

--
-- Indexes for table `user_feeds`
--
ALTER TABLE `user_feeds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_feeds_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_feeds_likes`
--
ALTER TABLE `user_feeds_likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_feeds_likes_feed_id_foreign` (`feed_id`),
  ADD KEY `user_feeds_likes_friend_id_foreign` (`friend_id`);

--
-- Indexes for table `user_feed_comments`
--
ALTER TABLE `user_feed_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_feed_comments_feed_id_foreign` (`feed_id`),
  ADD KEY `user_feed_comments_friend_id_foreign` (`friend_id`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `visitors_company_id_foreign` (`company_id`),
  ADD KEY `visitors_gate_id_foreign` (`gate_id`),
  ADD KEY `visitors_reason_id_foreign` (`reason_id`),
  ADD KEY `visitors_unit_id_foreign` (`unit_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `adverts`
--
ALTER TABLE `adverts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `app_users`
--
ALTER TABLE `app_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `company_settings`
--
ALTER TABLE `company_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `concierges`
--
ALTER TABLE `concierges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `emergency_alarms`
--
ALTER TABLE `emergency_alarms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=304;

--
-- AUTO_INCREMENT for table `emergency_alarms_responses`
--
ALTER TABLE `emergency_alarms_responses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2692;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `facilities_options`
--
ALTER TABLE `facilities_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `gates`
--
ALTER TABLE `gates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `loyalty_cards`
--
ALTER TABLE `loyalty_cards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `message_boards`
--
ALTER TABLE `message_boards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `parcels`
--
ALTER TABLE `parcels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `polls`
--
ALTER TABLE `polls`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `polls_options`
--
ALTER TABLE `polls_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `polls_votes`
--
ALTER TABLE `polls_votes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `real_estates`
--
ALTER TABLE `real_estates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reason_for_visits`
--
ALTER TABLE `reason_for_visits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `subscription_items`
--
ALTER TABLE `subscription_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `unit_issue_requests`
--
ALTER TABLE `unit_issue_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_feeds`
--
ALTER TABLE `user_feeds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_feeds_likes`
--
ALTER TABLE `user_feeds_likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_feed_comments`
--
ALTER TABLE `user_feed_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `app_users`
--
ALTER TABLE `app_users`
  ADD CONSTRAINT `app_users_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `app_users_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `companies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `company_settings`
--
ALTER TABLE `company_settings`
  ADD CONSTRAINT `company_settings_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `concierges`
--
ALTER TABLE `concierges`
  ADD CONSTRAINT `concierges_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `concierges_gate_id_foreign` FOREIGN KEY (`gate_id`) REFERENCES `gates` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `emergency_alarms`
--
ALTER TABLE `emergency_alarms`
  ADD CONSTRAINT `emergency_alarms_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `emergency_alarms_responses`
--
ALTER TABLE `emergency_alarms_responses`
  ADD CONSTRAINT `emergency_alarms_responses_alarm_id_foreign` FOREIGN KEY (`alarm_id`) REFERENCES `emergency_alarms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `emergency_alarms_responses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `app_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gates`
--
ALTER TABLE `gates`
  ADD CONSTRAINT `gates_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `loyalty_cards`
--
ALTER TABLE `loyalty_cards`
  ADD CONSTRAINT `loyalty_cards_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `message_boards`
--
ALTER TABLE `message_boards`
  ADD CONSTRAINT `message_boards_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `parcels`
--
ALTER TABLE `parcels`
  ADD CONSTRAINT `parcels_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `parcels_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `polls`
--
ALTER TABLE `polls`
  ADD CONSTRAINT `polls_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `polls_options`
--
ALTER TABLE `polls_options`
  ADD CONSTRAINT `polls_options_poll_id_foreign` FOREIGN KEY (`poll_id`) REFERENCES `polls` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `polls_votes`
--
ALTER TABLE `polls_votes`
  ADD CONSTRAINT `polls_votes_option_id_foreign` FOREIGN KEY (`option_id`) REFERENCES `polls_options` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `polls_votes_poll_id_foreign` FOREIGN KEY (`poll_id`) REFERENCES `polls` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `polls_votes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `app_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `real_estates`
--
ALTER TABLE `real_estates`
  ADD CONSTRAINT `real_estates_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `real_estates_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `app_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reason_for_visits`
--
ALTER TABLE `reason_for_visits`
  ADD CONSTRAINT `reason_for_visits_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `units`
--
ALTER TABLE `units`
  ADD CONSTRAINT `units_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `unit_issue_requests`
--
ALTER TABLE `unit_issue_requests`
  ADD CONSTRAINT `unit_issue_requests_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `unit_issue_requests_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `unit_issue_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `app_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `visitors`
--
ALTER TABLE `visitors`
  ADD CONSTRAINT `visitors_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `visitors_gate_id_foreign` FOREIGN KEY (`gate_id`) REFERENCES `gates` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `visitors_reason_id_foreign` FOREIGN KEY (`reason_id`) REFERENCES `reason_for_visits` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `visitors_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
