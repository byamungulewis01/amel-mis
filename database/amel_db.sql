-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 11, 2024 at 07:14 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `amel_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `contracts`
--

CREATE TABLE `contracts` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quoting_price` bigint(20) NOT NULL,
  `market_price` bigint(20) NOT NULL,
  `status` enum('pending','in_progress','complete') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `stored_by` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contracts`
--

INSERT INTO `contracts` (`id`, `name`, `item`, `quoting_price`, `market_price`, `status`, `stored_by`, `created_at`, `updated_at`) VALUES
('9bf84ce6-2073-40a2-b111-08c576d953c7', 'Gregory Landry', 'Voluptas rerum at ne', 580, 800, 'complete', '9bdf48c3-0ae8-4ed3-b943-08c7d3601402', '2024-05-05 08:10:43', '2024-05-05 08:26:36'),
('9bf84d17-82e5-44b5-96a4-2c44e1b24d36', 'Ulla Maxwell UPDAT E', 'Sed repellendus Aut UPDA', 442000, 725000, 'in_progress', '9bdf48c3-0ae8-4ed3-b943-08c7d3601402', '2024-05-05 08:11:15', '2024-05-05 08:25:11'),
('9bf84d1f-bb40-4476-910f-bf604caef605', 'Jaden Mccall', 'Dolor rerum non quia', 101, 48, 'pending', '9bdf48c3-0ae8-4ed3-b943-08c7d3601402', '2024-05-05 08:11:21', '2024-05-05 08:11:21');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(9, '2024_04_23_002237_create_weekly_reports_table', 2),
(10, '2024_04_28_060539_create_weekly_report_details_table', 2),
(11, '2024_04_23_001228_create_tenders_table', 3),
(12, '2024_05_04_222503_create_contracts_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tenders`
--

CREATE TABLE `tenders` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tender_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `request_amount` bigint(20) NOT NULL,
  `sold_amount` bigint(20) DEFAULT NULL,
  `sales_amount` bigint(20) DEFAULT NULL,
  `request_for` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_order_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estimated_badge_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','in_progress','complete') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stored_by` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `approved_by` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `closed_by` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tenders`
--

INSERT INTO `tenders` (`id`, `tender_name`, `request_amount`, `sold_amount`, `sales_amount`, `request_for`, `purchase_order_file`, `estimated_badge_file`, `status`, `description`, `stored_by`, `approved_by`, `closed_by`, `created_at`, `updated_at`) VALUES
('9bf047f3-3c8b-487b-b3e4-14fd425fb02b', 'Troy Pennington', 78, NULL, NULL, 'Similique et ducimus', 'upload_files/PD6H38DqWkXCqMbXBKIhhvHs5hXk9FRlnsZUihWv.png', 'upload_files/ogy8R3BLNoa7dPJp8EeXZmrpxSKkYoO1rc2V5j6p.png', 'pending', NULL, '9be135d9-4bcf-4e82-9cf8-81d2d5e1e1b6', NULL, NULL, '2024-05-01 08:30:15', '2024-05-01 08:30:15'),
('9bf04884-9021-4d78-a9b4-de0a6f4b4cfa', 'CIMENT Tender', 50000, 1222, 125000, 'Construction', 'upload_files/J0qbu87R3qhpwul5v3LvEdst3RlrYfXLhz8NXZtx.png', 'upload_files/2b9e9RlACEucAhCygZJk6Tj2UsoFMy36AFyUKPhP.png', 'in_progress', NULL, '9be13348-ea37-47a5-8591-8d4830b16c57', '9bdf48c3-0ae8-4ed3-b943-08c7d3601402', '9bdf48c3-0ae8-4ed3-b943-08c7d3601402', '2024-05-01 08:31:51', '2024-05-01 08:34:10'),
('9bf048d4-f922-4981-a006-9863b42672c3', 'Holly Bass', 82, 2300, 6700, 'Consequat Aut ea et', 'upload_files/SQxuBjb1RYF4k7JQwOB8gNfuvNguPchk2fALdaNk.png', 'upload_files/zKmUTdh5V3ItMk8poiF5DV9aEYC8319QAoQKlSSY.png', 'complete', 'Deleniti dolorem omn', '9be135d9-4bcf-4e82-9cf8-81d2d5e1e1b6', '9bdf48c3-0ae8-4ed3-b943-08c7d3601402', '9bdf48c3-0ae8-4ed3-b943-08c7d3601402', '2024-05-01 08:32:43', '2024-05-01 09:03:05'),
('9bf721af-891a-4a3e-b7fc-8132fcc5d90e', 'Lucian Odom', 6800, NULL, NULL, 'Ipsa consequat Con', 'upload_files/5qSOF4RWn2cuBEtAeex1XL1akTzbNCLWaeL28me7.pdf', 'upload_files/yVYLdidyyhmJY1tKahfC3Y7A33lsqhXcwqbGYU7O.pdf', 'pending', NULL, '9be94966-cb07-4af4-a146-976ec6bc9e22', NULL, NULL, '2024-05-04 18:14:03', '2024-05-04 18:14:03'),
('9bf721e8-907f-430b-a520-73fa3ca51bef', 'Dana Church UPDATE', 60000, NULL, NULL, 'Et lorem ratione vit', 'upload_files/zZQ6oh2wz6XvDmESEKOypTQNV2cA44f8zsf6IXbk.png', 'upload_files/vMGeRoIRtcrOSqkImHdaI9YL2N5gpFi2hAfut9Iw.png', 'in_progress', NULL, '9be94966-cb07-4af4-a146-976ec6bc9e22', '9bdf48c3-0ae8-4ed3-b943-08c7d3601402', NULL, '2024-05-04 18:14:41', '2024-05-04 18:15:11'),
('9c2b344d-f896-4a69-a724-e8f4a7c77aae', '10000', 10000, 12000, 20000, 'hrthid', 'upload_files/yvBK7TKo2JUGqnlAH8YcNPakZ1ABdH6SEWpdmynO.pdf', 'upload_files/ZRKRTIaJc2l5XFACflWIHxECGrZu833ppChNPSfL.jpg', 'complete', 'desff', '9c2b31c9-cdaf-481b-9e97-4253d92c1ea3', '9bdf48c3-0ae8-4ed3-b943-08c7d3601402', '9bdf48c3-0ae8-4ed3-b943-08c7d3601402', '2024-05-30 16:29:10', '2024-05-30 16:43:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department` enum('field','finance','manager','admin') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `email_verified_at`, `password`, `profile_image`, `department`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
('9bdf48c3-0ae8-4ed3-b943-08c7d3601402', 'BYAMUNGU Lewis', 'byamungulewis@gmail.com', '0785436135', '2024-04-22 22:43:26', '$2y$12$2M/JQuPR.BkeFxDq/jUjz.AuToJ/lugccPvVhEoF8w6PZxZWQsc16', NULL, 'admin', 'active', 'SrMc0GYXhac9DrIJ7n4PW3xf1YplgtfgoFnKlNkaV0ObzErWVSbdWjYdzxPk', '2024-04-22 22:43:27', '2024-04-22 22:43:27'),
('9bdf514b-bb12-453a-8db5-9e92d731b177', 'Cyrus Cobb', 'mimasit@mailinator.com', '0785522112', NULL, '$2y$12$wCN.MTTAKHfmdNuAe8srWuDVtYJJyeFuMZuO97dFRY3upWAwxOP/.', NULL, 'field', 'active', NULL, '2024-04-22 23:07:19', '2024-04-23 21:34:34'),
('9be13348-ea37-47a5-8591-8d4830b16c57', 'Kelly Monroe', 'zixo@mailinator.com', '0785522100', NULL, '$2y$12$5Z49IzsK3XpJWGVG2dQLguERnAghvF.uc0mUFs5js5mo5.uiR1B2G', NULL, 'field', 'active', NULL, '2024-04-23 21:35:03', '2024-04-27 20:29:14'),
('9be13405-c58f-45d7-ad24-7b4f001f233f', 'NYINAWASE Anne', 'annenyinawase@gmail.com', '0785566332', NULL, '$2y$12$p6g3VI6hRQVz3mbA.BpizuGm0wmuzn4Ni6B4KgT0UtBvk.1k7ogDe', NULL, 'finance', 'inactive', NULL, '2024-04-23 21:37:07', '2024-04-27 21:08:10'),
('9be13480-2478-4630-b485-75a6df3cc281', 'Acton Dawson UPDATE', 'liqy@mailinator.com', '0785522145', NULL, '$2y$12$f6DNxzBOa0fd/HL/GiTW0eWYrjRytOio8nLA6ppi3HGGp9oKdqLSG', NULL, 'field', 'active', NULL, '2024-04-23 21:38:27', '2024-04-27 08:39:01'),
('9be135d9-4bcf-4e82-9cf8-81d2d5e1e1b6', 'Cameran Browning', 'wecol@mailinator.com', '0785522140', NULL, '$2y$12$x83FtL/2CfiA3S.ldzxqGuEV98VYLG.cxt8yP2y72D80.gfhfYar2', NULL, 'field', 'active', NULL, '2024-04-23 21:42:13', '2024-05-04 19:15:29'),
('9be93e3b-8909-46b6-b810-aa674bfa8b01', 'Demetrius Rose', 'vusixelez@mailinator.com', '0785412545', NULL, '$2y$12$X8vuLLhiDsY/aR7Cz4KPjeFI8EFX9EGIQv/vg2Z25DbawlUk1P.Sq', NULL, 'manager', 'inactive', NULL, '2024-04-27 20:32:18', '2024-04-27 21:07:59'),
('9be94966-cb07-4af4-a146-976ec6bc9e22', 'Dominic Wyatt', 'tecyrifop@mailinator.com', '0785422255', NULL, '$2y$12$qi1GqWPFozKRUDZ/Z.OoAuWRvJJFZVD2DPcYxCGl8AIKI6jOZf0QC', NULL, 'field', 'active', NULL, '2024-04-27 21:03:31', '2024-04-27 21:03:57'),
('9c2b31c9-cdaf-481b-9e97-4253d92c1ea3', 'BYAMUNGU theo', 'ntezeyo@gmail.com', '0783555299', NULL, '$2y$12$3yn59bnq0efYbiJxeE1G..VWj4r9onxggu3W4WTP7lU4LuOdNMmFi', NULL, 'field', 'active', NULL, '2024-05-30 16:22:08', '2024-05-30 16:22:08'),
('9c2b37ba-67fa-49b1-913e-16caacf4473a', 'theo', 'theo@12gmail.com', '0787010203', NULL, '$2y$12$nbYLUE2h53P4qzIqfbq0uuaFwxCqxwFuLqlv9qKMN5.HefI6lNKWq', NULL, 'finance', 'active', NULL, '2024-05-30 16:38:44', '2024-05-30 16:38:44');

-- --------------------------------------------------------

--
-- Table structure for table `weekly_reports`
--

CREATE TABLE `weekly_reports` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `week_number` int(11) NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `tender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `used_money` bigint(20) NOT NULL DEFAULT 0,
  `transport` bigint(20) NOT NULL DEFAULT 0,
  `accommodation` bigint(20) NOT NULL DEFAULT 0,
  `status` enum('sent','rejected','approved') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sent',
  `stored_by` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `approved_by` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `weekly_reports`
--

INSERT INTO `weekly_reports` (`id`, `week_number`, `date_from`, `date_to`, `tender`, `used_money`, `transport`, `accommodation`, `status`, `stored_by`, `approved_by`, `created_at`, `updated_at`) VALUES
('9bf72980-78c6-41c0-8242-10ad54592e8f', 1, '2024-04-29', '2024-05-03', NULL, 6500, 560, 7000, 'approved', '9be94966-cb07-4af4-a146-976ec6bc9e22', '9bdf48c3-0ae8-4ed3-b943-08c7d3601402', '2024-05-04 18:35:55', '2024-05-30 16:23:46'),
('9bf73135-81e7-4789-a85c-99501ca63737', 1, '2024-04-29', '2024-05-03', NULL, 72, 91, 63, 'approved', '9be13348-ea37-47a5-8591-8d4830b16c57', '9bdf48c3-0ae8-4ed3-b943-08c7d3601402', '2024-05-04 18:57:28', '2024-05-04 19:11:22'),
('9c2b34c1-8da3-4320-9082-247637d392c5', 5, '2024-05-27', '2024-05-31', NULL, 2000, 2000, 20000, 'approved', '9c2b31c9-cdaf-481b-9e97-4253d92c1ea3', '9bdf48c3-0ae8-4ed3-b943-08c7d3601402', '2024-05-30 16:30:26', '2024-05-30 16:32:47');

-- --------------------------------------------------------

--
-- Table structure for table `weekly_report_details`
--

CREATE TABLE `weekly_report_details` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weekly_report_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `activities` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hours` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contracts_stored_by_foreign` (`stored_by`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `tenders`
--
ALTER TABLE `tenders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tenders_stored_by_foreign` (`stored_by`),
  ADD KEY `tenders_approved_by_foreign` (`approved_by`),
  ADD KEY `tenders_closed_by_foreign` (`closed_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`);

--
-- Indexes for table `weekly_reports`
--
ALTER TABLE `weekly_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `weekly_reports_stored_by_foreign` (`stored_by`),
  ADD KEY `weekly_reports_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `weekly_report_details`
--
ALTER TABLE `weekly_report_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `weekly_report_details_weekly_report_id_foreign` (`weekly_report_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contracts`
--
ALTER TABLE `contracts`
  ADD CONSTRAINT `contracts_stored_by_foreign` FOREIGN KEY (`stored_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `tenders`
--
ALTER TABLE `tenders`
  ADD CONSTRAINT `tenders_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tenders_closed_by_foreign` FOREIGN KEY (`closed_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tenders_stored_by_foreign` FOREIGN KEY (`stored_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `weekly_reports`
--
ALTER TABLE `weekly_reports`
  ADD CONSTRAINT `weekly_reports_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `weekly_reports_stored_by_foreign` FOREIGN KEY (`stored_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `weekly_report_details`
--
ALTER TABLE `weekly_report_details`
  ADD CONSTRAINT `weekly_report_details_weekly_report_id_foreign` FOREIGN KEY (`weekly_report_id`) REFERENCES `weekly_reports` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
