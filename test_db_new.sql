-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2025 at 06:25 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `business_db_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `feedback` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `facebookfeeds`
--

CREATE TABLE `facebookfeeds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `page_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `facebookfeeds`
--

INSERT INTO `facebookfeeds` (`id`, `page_id`, `access_token`, `created_at`, `updated_at`) VALUES
(1, '123456789', 'exampleaccesstoken123', '2025-02-26 10:07:50', '2025-02-26 10:07:50');

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
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2023_09_04_110227_create_m_obj_type_table', 1),
(7, '2023_09_04_111126_create_m_obj_hierarchy_table', 1),
(8, '2023_09_28_064614_create_m_obj_def_table', 1),
(9, '2023_11_06_162450_add_role_to_users_table', 1),
(10, '2024_02_12_142433_add_unique_constraint_to_obj_def_table', 1),
(11, '2024_02_29_055132_change_obj_name_to_text_in_m_obj_def_table', 1),
(12, '2024_02_29_055929_change_display_name_to_text_in_m_obj_hierarchy_table', 1),
(13, '2024_05_03_075536_create_contact_table', 1),
(14, '2025_01_08_073953_add_icon_code_to_m_obj_hierarchy_table', 1),
(15, '2025_01_08_091323_add_brand_to_m_obj_hierarchy_table', 1),
(16, '2025_01_10_065426_add_seo_tags_to_m_obj_hierarchy', 1),
(17, '2025_02_04_092622_add_background_image_to_m_obj_hierarchy_table', 1),
(18, '2025_01_15_065516_create_facebook_feeds_table', 2),
(19, '2025_01_16_120708_create_twitterposts_table', 2),
(20, '2025_01_17_072226_create_facebook_posts_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `m_obj_def`
--

CREATE TABLE `m_obj_def` (
  `obj_id` bigint(20) UNSIGNED NOT NULL,
  `obj_type_id` bigint(20) DEFAULT NULL,
  `obj_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_obj_def`
--

INSERT INTO `m_obj_def` (`obj_id`, `obj_type_id`, `obj_name`, `created_by`, `updated_by`, `content`, `created_at`, `updated_at`) VALUES
(1, 0, 'Business Website', 'admin', NULL, NULL, '2025-03-01 12:37:35', '2025-03-01 12:37:35'),
(2, 0, 'Home Page', 'admin', NULL, NULL, '2025-03-01 12:37:45', '2025-03-01 12:37:45'),
(3, 0, 'Banner Section', 'admin', NULL, NULL, '2025-03-01 12:38:00', '2025-03-01 12:38:00'),
(4, 0, 'Banner 1', 'admin', 'admin', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod,</p><p>veritatis tempore nostrum id officia quaerat eum corrupti,</p><p>ipsa aliquam velit.</p>', '2025-03-01 12:38:08', '2025-03-01 23:44:54'),
(5, 0, 'Banner 2', 'admin', 'admin', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod,</p><p>veritatis tempore nostrum id officia quaerat eum corrupti,</p><p>ipsa aliquam velit.</p>', '2025-03-01 12:38:17', '2025-03-02 01:27:42'),
(6, 0, 'What we Offer', 'admin', NULL, NULL, '2025-03-01 12:38:42', '2025-03-01 12:38:42'),
(7, 0, 'Time Management', 'admin', NULL, NULL, '2025-03-01 12:38:58', '2025-03-01 12:38:58'),
(8, 0, 'Marketing Ideas', 'admin', NULL, NULL, '2025-03-01 12:39:12', '2025-03-01 12:39:12'),
(9, 0, 'Mail Support', 'admin', NULL, NULL, '2025-03-01 12:39:22', '2025-03-01 12:39:22'),
(10, 0, 'Secure System', 'admin', NULL, NULL, '2025-03-01 12:39:36', '2025-03-01 12:39:36'),
(11, 0, 'What we are', 'admin', 'admin', '<p>a</p>', '2025-03-01 12:39:55', '2025-03-02 09:37:35'),
(12, 0, 'What we are Desc', 'admin', 'admin', '<ul><li>Donec sed odio dui. Aenean eu leo quam. Pellentesque ornare sem laca quam venenatis vestibulum.</li><li>Aenean quam. Pellentesque ornare sem laca quam venenatis vestibulum.</li><li>Donec sed odio dui. Aenean eu leo quam. Pellentesque ornare sem laca quam venenatis vestibulum.</li><li>Etiam porta sem multipage evint landing magna mollis euismod a pharetra augue.</li><li>Aenean quam. Pellentesque ornare sem laca quam venenatis vestibulum.</li></ul><p><br></p>', '2025-03-01 12:40:12', '2025-03-02 09:40:34'),
(13, 0, 'Create Together', 'admin', NULL, '<p><span style=\"background-color: rgb(255, 255, 255);\">Proin gravida nibh vel velit auctor aliquet. Aenean sollicudin bibendum auctor, nisi elit consequat ipsum, nesagittis sem nid elit. Duis sed odio sitain elit.</span></p>', '2025-03-01 12:40:54', '2025-03-01 12:40:54'),
(14, 0, 'Achievements', 'admin', NULL, NULL, '2025-03-01 12:41:15', '2025-03-01 12:41:15'),
(15, 0, 'Happy Clients', 'admin', NULL, NULL, '2025-03-01 12:41:31', '2025-03-01 12:41:31'),
(16, 0, 'Projects completed', 'admin', NULL, NULL, '2025-03-01 12:41:42', '2025-03-01 12:41:42'),
(17, 0, 'Positive feedback', 'admin', NULL, NULL, '2025-03-01 12:41:51', '2025-03-01 12:41:51'),
(18, 0, 'Cups of Coffee', 'admin', NULL, NULL, '2025-03-01 12:42:01', '2025-03-01 12:42:01'),
(19, 0, 'Latest Posts', 'admin', NULL, NULL, '2025-03-01 12:42:21', '2025-03-01 12:42:21'),
(20, 0, 'Latest Posts1', 'admin', NULL, NULL, '2025-03-01 12:42:36', '2025-03-01 12:42:36'),
(21, 0, 'Latest Posts2', 'admin', NULL, NULL, '2025-03-01 12:42:42', '2025-03-01 12:42:42'),
(22, 0, 'Latest Posts3', 'admin', NULL, NULL, '2025-03-01 12:42:49', '2025-03-01 12:42:49');

-- --------------------------------------------------------

--
-- Table structure for table `m_obj_hierarchy`
--

CREATE TABLE `m_obj_hierarchy` (
  `obj_hierarchy_id` bigint(20) UNSIGNED NOT NULL,
  `obj_id` bigint(20) NOT NULL,
  `parent_obj_id` bigint(20) NOT NULL,
  `display_order` int(11) DEFAULT NULL,
  `displayable` tinyint(1) DEFAULT NULL,
  `displayed` tinyint(1) DEFAULT NULL,
  `display_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `route_path` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_name` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `icon_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand` bigint(20) DEFAULT NULL,
  `seo_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `background_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_obj_hierarchy`
--

INSERT INTO `m_obj_hierarchy` (`obj_hierarchy_id`, `obj_id`, `parent_obj_id`, `display_order`, `displayable`, `displayed`, `display_name`, `created_by`, `updated_by`, `route_path`, `image_name`, `created_at`, `updated_at`, `icon_code`, `brand`, `seo_title`, `seo_description`, `seo_keywords`, `background_image`) VALUES
(1, 2, 1, 1, 1, NULL, 'Home', 'admin', NULL, 'home', NULL, '2025-03-01 12:43:30', '2025-03-01 12:43:30', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 3, 2, 1, 1, NULL, 'Banner Section', 'admin', NULL, 'banner', NULL, '2025-03-01 12:44:03', '2025-03-01 12:44:03', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 4, 3, 1, 1, NULL, 'We Combine Design', 'admin', 'admin', 'Banner Section 1', 'http://127.0.0.1:8000/storage/images/1740898628.jpg', '2025-03-01 12:44:41', '2025-03-02 01:45:13', NULL, NULL, NULL, NULL, NULL, NULL),
(4, 5, 3, 2, 1, NULL, 'We Combine Design', 'admin', 'admin', 'Banner Section 2', 'http://127.0.0.1:8000/storage/images/1740898735.jpg', '2025-03-01 12:45:02', '2025-03-02 01:28:55', NULL, NULL, NULL, NULL, NULL, NULL),
(5, 6, 2, 2, 1, NULL, 'What we Offer', 'admin', NULL, '/what we offer', NULL, '2025-03-01 12:46:06', '2025-03-01 12:46:06', NULL, NULL, NULL, NULL, NULL, NULL),
(6, 7, 6, 1, 1, NULL, 'Time Management', 'admin', NULL, '/Time Management', NULL, '2025-03-01 12:46:55', '2025-03-01 12:46:55', NULL, NULL, NULL, NULL, NULL, NULL),
(7, 8, 6, 2, 1, NULL, 'Marketing Ideas', 'admin', NULL, '/Marketing Ideas', NULL, '2025-03-01 12:47:33', '2025-03-01 12:47:33', NULL, NULL, NULL, NULL, NULL, NULL),
(8, 9, 6, 3, 1, NULL, 'Mail Support', 'admin', NULL, 'mailsupport', NULL, '2025-03-01 12:48:23', '2025-03-01 12:48:23', NULL, NULL, NULL, NULL, NULL, NULL),
(9, 10, 6, 4, 0, NULL, 'Secure System', 'admin', 'admin', 'securesystem', NULL, '2025-03-01 12:49:15', '2025-03-02 09:39:10', NULL, NULL, NULL, NULL, NULL, NULL),
(10, 11, 2, 3, 1, NULL, 'What we are', 'admin', NULL, 'whatweare', NULL, '2025-03-01 12:49:51', '2025-03-01 12:49:51', NULL, NULL, NULL, NULL, NULL, NULL),
(11, 12, 11, 1, 1, NULL, 'What we are Desc', 'admin', NULL, 'whatwearedesc', NULL, '2025-03-01 12:50:46', '2025-03-01 12:50:46', NULL, NULL, NULL, NULL, NULL, NULL),
(12, 13, 2, 4, 1, NULL, 'Create Together', 'admin', NULL, 'createtogether', NULL, '2025-03-01 12:51:37', '2025-03-01 12:51:37', NULL, NULL, NULL, NULL, NULL, NULL),
(13, 14, 2, 5, 1, NULL, 'Achievements', 'admin', NULL, 'achievements', NULL, '2025-03-01 12:52:11', '2025-03-01 12:52:11', NULL, NULL, NULL, NULL, NULL, NULL),
(14, 15, 14, 1, 1, NULL, 'Happy Clients', 'admin', NULL, '/clients', NULL, '2025-03-01 12:53:03', '2025-03-01 12:53:03', NULL, NULL, NULL, NULL, NULL, NULL),
(15, 16, 14, 2, 1, NULL, 'Projects Completed', 'admin', NULL, '/achivements', NULL, '2025-03-01 12:53:51', '2025-03-01 12:53:51', NULL, NULL, NULL, NULL, NULL, NULL),
(16, 17, 14, 3, 1, NULL, 'Positive feedback', 'admin', NULL, 'feedback', NULL, '2025-03-01 12:54:29', '2025-03-01 12:54:29', NULL, NULL, NULL, NULL, NULL, NULL),
(17, 18, 14, 4, 1, NULL, 'Cups of Coffee', 'admin', NULL, 'coffee', NULL, '2025-03-01 12:55:05', '2025-03-01 12:55:05', NULL, NULL, NULL, NULL, NULL, NULL),
(18, 19, 2, 7, 1, NULL, 'Latest Posts', 'admin', NULL, 'latestposts', NULL, '2025-03-01 12:55:42', '2025-03-01 12:55:42', NULL, NULL, NULL, NULL, NULL, NULL),
(19, 20, 19, 1, 1, NULL, 'Latest Post 1', 'admin', NULL, '/latestpost1', NULL, '2025-03-01 12:56:38', '2025-03-01 12:56:38', NULL, NULL, NULL, NULL, NULL, NULL),
(20, 21, 19, 2, 1, NULL, 'Latest Post 2', 'admin', NULL, 'latestposts2', NULL, '2025-03-01 12:57:08', '2025-03-01 12:57:08', NULL, NULL, NULL, NULL, NULL, NULL),
(21, 22, 19, 3, 1, NULL, 'latest posts 3', 'admin', NULL, 'latestpost3', NULL, '2025-03-01 12:57:35', '2025-03-01 12:57:35', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_obj_type`
--

CREATE TABLE `m_obj_type` (
  `obj_type_id` bigint(20) UNSIGNED NOT NULL,
  `obj_type_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `obj_type_desc` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `twitterposts`
--

CREATE TABLE `twitterposts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `urls` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`urls`)),
  `post_created` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'admin', 'admin@gmail.com', NULL, '$2y$10$XSgDmxIkNqLBqeOnrFkyduVJLex.kKeo.ycl2rFq.bxSRROiKyXKW', NULL, '2023-10-12 20:35:36', '2023-10-12 20:35:36', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `facebookfeeds`
--
ALTER TABLE `facebookfeeds`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `m_obj_def`
--
ALTER TABLE `m_obj_def`
  ADD PRIMARY KEY (`obj_id`),
  ADD UNIQUE KEY `m_obj_def_obj_name_unique` (`obj_name`) USING HASH;

--
-- Indexes for table `m_obj_hierarchy`
--
ALTER TABLE `m_obj_hierarchy`
  ADD PRIMARY KEY (`obj_hierarchy_id`);

--
-- Indexes for table `m_obj_type`
--
ALTER TABLE `m_obj_type`
  ADD PRIMARY KEY (`obj_type_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

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
-- Indexes for table `twitterposts`
--
ALTER TABLE `twitterposts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `facebookfeeds`
--
ALTER TABLE `facebookfeeds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `m_obj_def`
--
ALTER TABLE `m_obj_def`
  MODIFY `obj_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `m_obj_hierarchy`
--
ALTER TABLE `m_obj_hierarchy`
  MODIFY `obj_hierarchy_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `m_obj_type`
--
ALTER TABLE `m_obj_type`
  MODIFY `obj_type_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `twitterposts`
--
ALTER TABLE `twitterposts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
