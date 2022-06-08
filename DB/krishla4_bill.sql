-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 08, 2022 at 06:43 AM
-- Server version: 10.3.34-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `krishla4_bill`
--

-- --------------------------------------------------------

--
-- Table structure for table `addons`
--

CREATE TABLE `addons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `version` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `author` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `files` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `purchase_username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(3) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `backend_menus`
--

CREATE TABLE `backend_menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `priority` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `backend_menus`
--

INSERT INTO `backend_menus` (`id`, `name`, `link`, `icon`, `status`, `parent_id`, `priority`, `created_at`, `updated_at`) VALUES
(1, 'dashboard', 'dashboard', 'fas fa-laptop', 1, 0, 500, NULL, NULL),
(2, 'shops', 'shop', 'fas fa-university', 1, 0, 510, NULL, NULL),
(3, 'categories', 'category', 'fas fa-list-ul', 1, 0, 400, NULL, NULL),
(4, 'products', '#', 'fas fa-gift', 1, 0, 460, NULL, NULL),
(5, 'units', 'unit', 'fas fa-star', 1, 4, 480, NULL, NULL),
(6, 'products', 'products', 'fas fa-gift', 1, 4, 460, NULL, NULL),
(7, 'barcode_level', 'barcode', 'fa fa-barcode', 1, 4, 460, NULL, NULL),
(8, 'purchase', 'purchase', 'fas fa-newspaper', 1, 0, 460, NULL, NULL),
(9, 'pos', 'pos', 'fas fa-th', 1, 0, 460, NULL, NULL),
(10, 'sales', 'sale', 'fas fa-newspaper', 1, 0, 440, NULL, NULL),
(11, 'stock', 'stock', 'fas fa-braille', 1, 0, 460, NULL, NULL),
(12, 'customers', '#', 'fas fa-address-book', 1, 0, 450, NULL, NULL),
(13, 'customers', 'customers', 'fas fa-user-secret', 1, 12, 490, NULL, NULL),
(14, 'deposit', 'deposit', 'fas fa-dollar-sign', 0, 12, 490, NULL, NULL),
(15, 'administrator', '#', 'fas fa-id-card ', 1, 0, 450, NULL, NULL),
(16, 'administrators', 'administrators', 'fas fa-users', 1, 15, 500, NULL, NULL),
(17, 'tax_rates', 'tax', 'fas fa-percent', 1, 15, 490, NULL, NULL),
(18, 'role', 'role', 'fas fa-star', 1, 15, 470, NULL, NULL),
(19, 'report', '#', 'fas fa-archive', 1, 0, 390, NULL, NULL),
(20, 'sales_report', 'sales-report', 'fas fa-list-alt', 1, 19, 380, NULL, NULL),
(21, 'purchases_report', 'purchases-report', 'fas fa-list-alt', 1, 19, 375, NULL, NULL),
(22, 'stock_report', 'stock-report', 'fas fa-list-alt', 1, 19, 370, NULL, NULL),
(23, 'language', 'language', 'fas fa-globe', 1, 0, 9000, NULL, NULL),
(24, 'settings', 'setting', 'fas fa-cogs', 1, 0, 360, NULL, NULL),
(25, 'addons', 'addons', 'fa fa-crosshairs', 0, 15, 88, NULL, NULL),
(27, 'phone_and_model', 'phone-model', 'fa fa-mobile', 1, 4, 480, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `balances`
--

CREATE TABLE `balances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 1,
  `balance` decimal(13,2) NOT NULL,
  `creator_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creator_id` bigint(20) UNSIGNED NOT NULL,
  `editor_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `editor_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `balances`
--

INSERT INTO `balances` (`id`, `name`, `type`, `balance`, `creator_type`, `creator_id`, `editor_type`, `editor_id`, `created_at`, `updated_at`) VALUES
(1, 'admin', 1, 0.00, '1', 1, '1', 1, '2022-05-23 01:23:33', '2022-05-23 01:23:33'),
(2, 'Mee5353936583852', 1, 0.00, '1', 1, '1', 1, '2022-05-30 10:50:00', '2022-05-30 10:50:00'),
(3, 'harry', 1, 0.00, '1', 1, '1', 1, '2022-06-04 09:34:52', '2022-06-04 09:34:52'),
(4, 'zerry', 1, 0.00, '1', 1, '1', 1, '2022-06-04 09:37:31', '2022-06-04 09:37:31'),
(5, 'poter', 1, 0.00, '1', 1, '1', 1, '2022-06-04 09:39:56', '2022-06-04 09:39:56'),
(6, 'harry', 1, 0.00, '1', 1, '1', 1, '2022-06-04 09:46:49', '2022-06-04 09:46:49'),
(7, 'testing', 1, 0.00, '1', 1, '1', 1, '2022-06-04 09:49:48', '2022-06-04 09:49:48'),
(8, 'zerry', 1, 0.00, '1', 1, '1', 1, '2022-06-04 09:58:15', '2022-06-04 09:58:15');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `depth` int(10) UNSIGNED NOT NULL,
  `left` int(10) UNSIGNED NOT NULL,
  `right` int(10) UNSIGNED NOT NULL,
  `shop_id` int(10) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL,
  `creator_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creator_id` bigint(20) UNSIGNED NOT NULL,
  `editor_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `editor_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `depth`, `left`, `right`, `shop_id`, `parent_id`, `status`, `creator_type`, `creator_id`, `editor_type`, `editor_id`, `created_at`, `updated_at`) VALUES
(1, 'category one', 'category-one', '', 0, 0, 0, 1, 0, 5, 'App\\Models\\User', 1, 'App\\Models\\User', 1, '2022-06-06 16:52:49', '2022-06-06 16:52:49');

-- --------------------------------------------------------

--
-- Table structure for table `category_products`
--

CREATE TABLE `category_products` (
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_products`
--

INSERT INTO `category_products` (`category_id`, `product_id`) VALUES
(1, 1),
(1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `amount` decimal(13,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creator_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creator_id` bigint(20) UNSIGNED NOT NULL,
  `editor_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `editor_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `flag_icon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `flag_icon`, `status`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', '🇬🇧', 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ledgers`
--

CREATE TABLE `ledgers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `balance_id` bigint(20) UNSIGNED NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 1,
  `amount` decimal(13,2) NOT NULL,
  `balance` decimal(13,2) NOT NULL,
  `creator_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creator_id` bigint(20) UNSIGNED NOT NULL,
  `editor_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `editor_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ltm_translations`
--

CREATE TABLE `ltm_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `locale` varchar(191) COLLATE utf8mb4_bin NOT NULL,
  `group` varchar(191) COLLATE utf8mb4_bin NOT NULL,
  `key` text COLLATE utf8mb4_bin NOT NULL,
  `value` text COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  `collection_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disk` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` bigint(20) UNSIGNED NOT NULL,
  `manipulations` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `custom_properties` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `responsive_images` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_column` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `model_type`, `model_id`, `collection_name`, `name`, `file_name`, `mime_type`, `disk`, `size`, `manipulations`, `custom_properties`, `responsive_images`, `order_column`, `created_at`, `updated_at`) VALUES
(2, 'App\\Models\\Category', 1, 'categories', 'photo-1604668915840-580c30026e5f', 'photo-1604668915840-580c30026e5f.jpg', 'image/jpeg', 'public', 94231, '[]', '[]', '[]', 1, '2022-06-06 16:52:49', '2022-06-06 16:52:49'),
(3, 'App\\Models\\Product', 1, 'products', 'download (4)', 'download-(4).jpg', 'image/jpeg', 'public', 2556, '[]', '[]', '[]', 2, '2022-06-06 16:56:22', '2022-06-06 16:56:22'),
(4, 'App\\Models\\Product', 2, 'products', 'download (4)', 'download-(4).jpg', 'image/jpeg', 'public', 2556, '[]', '[]', '[]', 3, '2022-06-06 18:26:24', '2022-06-06 18:26:24');

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
(1, '2014_04_02_193005_create_translations_table', 1),
(2, '2014_10_12_000000_create_users_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2017_08_24_000000_create_settings_table', 1),
(5, '2019_08_19_000000_create_failed_jobs_table', 1),
(6, '2020_04_16_055437_create_categories_table', 1),
(7, '2020_04_16_055951_create_shops_table', 1),
(8, '2020_04_16_061409_create_products_table', 1),
(9, '2020_04_16_061410_create_product_items_table', 1),
(10, '2020_04_16_062121_create_category_products_table', 1),
(11, '2020_04_16_062315_create_purchases_table', 1),
(12, '2020_04_16_062315_create_sales_table', 1),
(13, '2020_04_16_063024_create_purchase_items_table', 1),
(14, '2020_04_16_063024_create_sale_items_table', 1),
(15, '2020_04_16_064701_create_media_table', 1),
(16, '2020_04_16_113855_create_jobs_table', 1),
(17, '2020_05_03_074532_create_balances_table', 1),
(18, '2020_05_03_074808_create_invoices_table', 1),
(19, '2020_05_03_074929_create_ledgers_table', 1),
(20, '2020_05_03_075008_create_transactions_table', 1),
(21, '2020_05_07_111209_create_notifications_table', 1),
(22, '2020_07_20_054253_create_taxs_table', 1),
(23, '2020_07_20_054253_create_units_table', 1),
(24, '2020_09_09_043116_create_permission_tables', 1),
(25, '2020_09_10_080029_create_backend_menus_table', 1),
(26, '2020_4_12_000020_create_deposits_table', 1),
(27, '2022_02_19_063019_create_languages_table', 1),
(28, '2022_02_20_061004_create_addons_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_permissions`
--

INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 1),
(3, 'App\\Models\\User', 1),
(4, 'App\\Models\\User', 1),
(5, 'App\\Models\\User', 1),
(6, 'App\\Models\\User', 1),
(7, 'App\\Models\\User', 1),
(8, 'App\\Models\\User', 1),
(9, 'App\\Models\\User', 1),
(10, 'App\\Models\\User', 1),
(11, 'App\\Models\\User', 1),
(12, 'App\\Models\\User', 1),
(13, 'App\\Models\\User', 1),
(14, 'App\\Models\\User', 1),
(15, 'App\\Models\\User', 1),
(16, 'App\\Models\\User', 1),
(18, 'App\\Models\\User', 1),
(19, 'App\\Models\\User', 1),
(20, 'App\\Models\\User', 1),
(21, 'App\\Models\\User', 1),
(22, 'App\\Models\\User', 1),
(23, 'App\\Models\\User', 1),
(24, 'App\\Models\\User', 1),
(25, 'App\\Models\\User', 1),
(26, 'App\\Models\\User', 1),
(27, 'App\\Models\\User', 1),
(28, 'App\\Models\\User', 1),
(29, 'App\\Models\\User', 1),
(30, 'App\\Models\\User', 1),
(31, 'App\\Models\\User', 1),
(32, 'App\\Models\\User', 1),
(33, 'App\\Models\\User', 1),
(34, 'App\\Models\\User', 1),
(35, 'App\\Models\\User', 1),
(36, 'App\\Models\\User', 1),
(37, 'App\\Models\\User', 1),
(38, 'App\\Models\\User', 1),
(39, 'App\\Models\\User', 1),
(40, 'App\\Models\\User', 1),
(41, 'App\\Models\\User', 1),
(42, 'App\\Models\\User', 1),
(43, 'App\\Models\\User', 1),
(44, 'App\\Models\\User', 1),
(45, 'App\\Models\\User', 1),
(46, 'App\\Models\\User', 1),
(47, 'App\\Models\\User', 1),
(48, 'App\\Models\\User', 1),
(49, 'App\\Models\\User', 1),
(50, 'App\\Models\\User', 1),
(51, 'App\\Models\\User', 1),
(52, 'App\\Models\\User', 1),
(53, 'App\\Models\\User', 1),
(54, 'App\\Models\\User', 1),
(55, 'App\\Models\\User', 1),
(56, 'App\\Models\\User', 1),
(57, 'App\\Models\\User', 1),
(58, 'App\\Models\\User', 1),
(59, 'App\\Models\\User', 1),
(60, 'App\\Models\\User', 1),
(61, 'App\\Models\\User', 1),
(62, 'App\\Models\\User', 1),
(63, 'App\\Models\\User', 1),
(64, 'App\\Models\\User', 1),
(65, 'App\\Models\\User', 1),
(66, 'App\\Models\\User', 1),
(67, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 3),
(3, 'App\\Models\\User', 2);

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
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'dashboard', 'web', NULL, NULL),
(2, 'category', 'web', NULL, NULL),
(3, 'category_create', 'web', NULL, NULL),
(4, 'category_edit', 'web', NULL, NULL),
(5, 'category_delete', 'web', NULL, NULL),
(6, 'barcode', 'web', NULL, NULL),
(7, 'products', 'web', NULL, NULL),
(8, 'products_create', 'web', NULL, NULL),
(9, 'products_edit', 'web', NULL, NULL),
(10, 'products_delete', 'web', NULL, NULL),
(11, 'products_show', 'web', NULL, NULL),
(12, 'purchase', 'web', NULL, NULL),
(13, 'purchase_create', 'web', NULL, NULL),
(14, 'purchase_edit', 'web', NULL, NULL),
(15, 'purchase_delete', 'web', NULL, NULL),
(16, 'purchase_show', 'web', NULL, NULL),
(17, 'pos', 'web', NULL, NULL),
(18, 'sale', 'web', NULL, NULL),
(19, 'sale_create', 'web', NULL, NULL),
(20, 'sale_edit', 'web', NULL, NULL),
(21, 'sale_delete', 'web', NULL, NULL),
(22, 'sale_show', 'web', NULL, NULL),
(23, 'stock', 'web', NULL, NULL),
(24, 'shop', 'web', NULL, NULL),
(25, 'shop_create', 'web', NULL, NULL),
(26, 'shop_edit', 'web', NULL, NULL),
(27, 'shop_delete', 'web', NULL, NULL),
(28, 'shop_show', 'web', NULL, NULL),
(29, 'administrators', 'web', NULL, NULL),
(30, 'administrators_create', 'web', NULL, NULL),
(31, 'administrators_edit', 'web', NULL, NULL),
(32, 'administrators_delete', 'web', NULL, NULL),
(33, 'administrators_show', 'web', NULL, NULL),
(34, 'customers', 'web', NULL, NULL),
(35, 'customers_create', 'web', NULL, NULL),
(36, 'customers_edit', 'web', NULL, NULL),
(37, 'customers_delete', 'web', NULL, NULL),
(38, 'customers_show', 'web', NULL, NULL),
(39, 'deposit', 'web', NULL, NULL),
(40, 'deposit_create', 'web', NULL, NULL),
(41, 'deposit_edit', 'web', NULL, NULL),
(42, 'deposit_delete', 'web', NULL, NULL),
(43, 'deposit_show', 'web', NULL, NULL),
(44, 'role', 'web', NULL, NULL),
(45, 'role_create', 'web', NULL, NULL),
(46, 'role_edit', 'web', NULL, NULL),
(47, 'role_delete', 'web', NULL, NULL),
(48, 'role_show', 'web', NULL, NULL),
(49, 'unit', 'web', NULL, NULL),
(50, 'unit_create', 'web', NULL, NULL),
(51, 'unit_edit', 'web', NULL, NULL),
(52, 'unit_delete', 'web', NULL, NULL),
(53, 'tax', 'web', NULL, NULL),
(54, 'tax_create', 'web', NULL, NULL),
(55, 'tax_edit', 'web', NULL, NULL),
(56, 'tax_delete', 'web', NULL, NULL),
(57, 'purchases-report', 'web', NULL, NULL),
(58, 'sales-report', 'web', NULL, NULL),
(59, 'stock-report', 'web', NULL, NULL),
(60, 'setting', 'web', NULL, NULL),
(61, 'language', 'web', NULL, NULL),
(62, 'language_create', 'web', NULL, NULL),
(63, 'language_edit', 'web', NULL, NULL),
(64, 'language_delete', 'web', NULL, NULL),
(65, 'addons', 'web', NULL, NULL),
(66, 'addons_create', 'web', NULL, NULL),
(67, 'addons_delete', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cost` decimal(13,2) NOT NULL,
  `price` decimal(13,2) NOT NULL,
  `barcode_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit_id` int(10) UNSIGNED NOT NULL,
  `tax_id` int(10) UNSIGNED DEFAULT NULL,
  `shop_id` int(10) UNSIGNED NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` int(10) UNSIGNED NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL,
  `extra` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `proof_of_seller` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creator_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creator_id` bigint(20) UNSIGNED NOT NULL,
  `editor_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `editor_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `description`, `cost`, `price`, `barcode_type`, `barcode`, `unit_id`, `tax_id`, `shop_id`, `phone`, `model`, `type`, `status`, `extra`, `proof_of_seller`, `creator_type`, `creator_id`, `editor_type`, `editor_id`, `created_at`, `updated_at`) VALUES
(1, 'testing name', 'testing-name', '', 21000.00, 22000.00, 'C39', '19031', 1, 0, 1, '1', '5', 5, 5, 'Phone Box,Bill', NULL, 'App\\Models\\User', 1, 'App\\Models\\User', 1, '2022-06-06 16:56:22', '2022-06-06 16:56:22'),
(2, 'product two', 'product-two', '', 12000.00, 12000.00, 'C39', '19012', 1, NULL, 1, '2', '7', 5, 5, 'Phone Box,Bill,Charger,Earphones', 'proof', 'App\\Models\\User', 1, 'App\\Models\\User', 1, '2022-06-06 18:26:23', '2022-06-06 18:26:44');

-- --------------------------------------------------------

--
-- Table structure for table `product_details`
--

CREATE TABLE `product_details` (
  `id` bigint(20) NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `type` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_details`
--

INSERT INTO `product_details` (`id`, `name`, `type`, `created_at`, `updated_at`) VALUES
(1, 'apple', 'phone', NULL, NULL),
(2, 'samsung', 'phone', NULL, NULL),
(3, 'OnePlus', 'phone', NULL, NULL),
(4, 'Xiaomi', 'phone', NULL, NULL),
(5, 'iPhone 12', 'model', NULL, NULL),
(6, 'iPhone 13', 'model', NULL, NULL),
(7, 'Galaxy M13', 'model', NULL, NULL),
(8, 'Galaxy Tab S6 Lite', 'model', NULL, NULL),
(9, 'Galaxy M53', 'model', NULL, NULL),
(10, 'Galaxy A73 5G', 'model', NULL, NULL),
(11, 'Galaxy A53', 'model', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_items`
--

CREATE TABLE `product_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shop_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `price` decimal(13,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` bigint(20) UNSIGNED NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extra` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `proof_of_seller` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchases_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_total` double DEFAULT 0,
  `creator_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creator_id` bigint(20) UNSIGNED NOT NULL,
  `editor_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `editor_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `shop_id`, `phone`, `model`, `extra`, `proof_of_seller`, `purchases_no`, `date`, `description`, `sub_total`, `creator_type`, `creator_id`, `editor_type`, `editor_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2', '7', '', 'proof', '123', '2022-06-07', '', 0, 'App\\Models\\User', 1, 'App\\Models\\User', 1, '2022-06-06 18:30:14', '2022-06-06 18:34:31'),
(2, 1, '2', '8', '', 'demo', '123987', '2022-06-06', '', 21000, 'App\\Models\\User', 1, 'App\\Models\\User', 1, '2022-06-06 18:36:07', '2022-06-06 18:36:07');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_items`
--

CREATE TABLE `purchase_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` double NOT NULL,
  `unit_price` double(13,2) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_items`
--

INSERT INTO `purchase_items` (`id`, `shop_id`, `purchase_id`, `product_id`, `product_item_id`, `quantity`, `unit_price`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 0, 1, 21000.00, '2022-06-06 18:30:14', '2022-06-06 18:30:14'),
(2, 1, 2, 1, 0, 1, 21000.00, '2022-06-06 18:36:07', '2022-06-06 18:36:07');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', '2022-05-23 01:23:33', '2022-05-23 01:23:33'),
(2, 'Customer', 'web', '2022-05-23 01:23:33', '2022-05-23 01:23:33'),
(3, 'Shop Owner', 'web', '2022-05-23 01:23:33', '2022-05-23 01:23:33'),
(4, 'Receptionist', 'web', '2022-05-23 01:23:33', '2022-05-23 01:23:33');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 3),
(1, 4),
(2, 1),
(2, 3),
(3, 1),
(3, 3),
(4, 1),
(4, 3),
(5, 1),
(5, 3),
(6, 1),
(6, 3),
(7, 1),
(7, 3),
(8, 1),
(8, 3),
(9, 1),
(9, 3),
(10, 1),
(10, 3),
(11, 1),
(11, 3),
(12, 1),
(12, 3),
(13, 1),
(13, 3),
(14, 1),
(14, 3),
(15, 1),
(15, 3),
(16, 1),
(16, 3),
(17, 1),
(17, 3),
(18, 1),
(18, 3),
(19, 1),
(19, 3),
(20, 1),
(20, 3),
(21, 1),
(21, 3),
(22, 1),
(22, 3),
(23, 1),
(23, 3),
(24, 1),
(24, 3),
(25, 1),
(25, 3),
(26, 1),
(26, 3),
(27, 1),
(27, 3),
(28, 1),
(28, 3),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(34, 4),
(35, 1),
(35, 4),
(36, 1),
(36, 4),
(37, 1),
(37, 4),
(38, 1),
(38, 4),
(39, 1),
(39, 4),
(40, 1),
(40, 4),
(41, 1),
(41, 4),
(42, 1),
(42, 4),
(43, 1),
(43, 4),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(49, 3),
(50, 1),
(50, 3),
(51, 1),
(51, 3),
(52, 1),
(52, 3),
(53, 1),
(53, 3),
(54, 1),
(54, 3),
(55, 1),
(55, 3),
(56, 1),
(56, 3),
(57, 1),
(57, 3),
(58, 1),
(58, 3),
(59, 1),
(59, 3),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` bigint(20) UNSIGNED NOT NULL,
  `sub_total` decimal(8,2) DEFAULT NULL,
  `discount` decimal(8,2) DEFAULT NULL,
  `total` decimal(8,2) DEFAULT NULL,
  `tax_amount` decimal(8,2) DEFAULT NULL,
  `paid_amount` decimal(8,2) DEFAULT NULL,
  `paid_credit_amount` decimal(8,2) DEFAULT NULL,
  `paid_cash_amount` decimal(8,2) DEFAULT NULL,
  `reference` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sale_no` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_id` int(10) UNSIGNED DEFAULT NULL,
  `description` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(3) UNSIGNED DEFAULT NULL,
  `payment_status` tinyint(3) UNSIGNED DEFAULT NULL,
  `payment_type` tinyint(3) UNSIGNED DEFAULT NULL,
  `creator_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creator_id` bigint(20) UNSIGNED NOT NULL,
  `editor_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `editor_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_items`
--

CREATE TABLE `sale_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `tax_id` int(10) UNSIGNED DEFAULT NULL,
  `tax_amount` decimal(8,2) DEFAULT NULL,
  `product_item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `unit_price` decimal(13,2) NOT NULL,
  `total_amount` decimal(13,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`) VALUES
(1, 'site_name', 'KrishLabs'),
(2, 'site_email', 'saikrishnap@krishlabs.in'),
(3, 'site_phone_number', '919550083889'),
(4, 'site_logo', 'image1.png'),
(5, 'site_footer', '@ All Rights Reserved'),
(6, 'site_description', 'krishlabs Billing Software'),
(7, 'site_address', '#26/4/3345 Melapuram, Hindupur, Andhra Pradesh, India - 515201'),
(8, 'currency_name', 'INR'),
(9, 'currency_code', 'Rs'),
(10, 'mail_disabled', '1'),
(11, 'web_purchase_username', 'saikrishnap'),
(12, 'web_purchase_code', '7f942c33-8f5d-4725-932d-ac3fdad0ef42'),
(13, 'timezone', 'GMT'),
(14, 'locale', 'en');

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

CREATE TABLE `shops` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL,
  `creator_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creator_id` bigint(20) UNSIGNED NOT NULL,
  `editor_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `editor_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shops`
--

INSERT INTO `shops` (`id`, `user_id`, `name`, `description`, `address`, `status`, `creator_type`, `creator_id`, `editor_type`, `editor_id`, `created_at`, `updated_at`) VALUES
(1, 2, 'A.G.S', '', 'Hindupur', 5, 'App\\Models\\User', 1, 'App\\Models\\User', 1, '2022-05-30 10:50:00', '2022-05-30 10:50:00');

-- --------------------------------------------------------

--
-- Table structure for table `taxs`
--

CREATE TABLE `taxs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_rate` decimal(13,2) NOT NULL,
  `type` tinyint(3) UNSIGNED NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL,
  `shop_id` int(10) UNSIGNED NOT NULL,
  `creator_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creator_id` bigint(20) UNSIGNED NOT NULL,
  `editor_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `editor_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 1,
  `source_balance_id` bigint(20) UNSIGNED DEFAULT NULL,
  `destination_balance_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(13,2) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `meta` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sale_id` bigint(20) UNSIGNED DEFAULT NULL,
  `shop_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `creator_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creator_id` bigint(20) UNSIGNED NOT NULL,
  `editor_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `editor_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL,
  `shop_id` int(10) UNSIGNED NOT NULL,
  `creator_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creator_id` bigint(20) UNSIGNED NOT NULL,
  `editor_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `editor_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `name`, `status`, `shop_id`, `creator_type`, `creator_id`, `editor_type`, `editor_id`, `created_at`, `updated_at`) VALUES
(1, 'test unit', 5, 1, 'App\\Models\\User', 1, 'App\\Models\\User', 1, '2022-06-06 16:54:06', '2022-06-06 16:54:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `balance_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 5,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `phone`, `address`, `email`, `email_verified_at`, `username`, `password`, `balance_id`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Raja', 'Reddy', '+91 8008888838', 'Hindupur, India', 'rajasekharreddyh@gmail.com', NULL, 'Raja', '$2y$10$FLjBTSwrASbCjxlSoGsmd.1pdGf7nNUEU47nXavs1LcX6hOVdPr0u', 1, 5, 'kkpXnKl18CXjLGMadxTULEXsmgMuaEsrXjSTrtnJ3AXPaGETaam65W1LqrW2', '2022-05-23 01:23:33', '2022-05-23 04:17:46'),
(2, 'Admin', 'Admin', '8088888838', 'Hindupur', 'Mee5353@gmail.com', NULL, 'Mee5353936583852', '$2y$10$vdWELeyq7sLuNQ0OjlMsj.UFKTZL3op.u75aeAaCCmfH4h2IE16lq', 2, 5, NULL, '2022-05-30 10:50:00', '2022-05-30 10:50:00'),
(3, 'harry', 'patel', '919726977958', NULL, NULL, NULL, 'harry', '$2y$10$hqjFIHsiYI2yIlbckGqEoe2Y5Eg16401mBl7IVZlpPtx7TyNXs1P.', 3, 5, NULL, '2022-06-04 09:34:52', '2022-06-04 09:34:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addons`
--
ALTER TABLE `addons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `backend_menus`
--
ALTER TABLE `backend_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `balances`
--
ALTER TABLE `balances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `balances_creator_type_creator_id_index` (`creator_type`,`creator_id`),
  ADD KEY `balances_editor_type_editor_id_index` (`editor_type`,`editor_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_creator_type_creator_id_index` (`creator_type`,`creator_id`),
  ADD KEY `categories_editor_type_editor_id_index` (`editor_type`,`editor_id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoices_creator_type_creator_id_index` (`creator_type`,`creator_id`),
  ADD KEY `invoices_editor_type_editor_id_index` (`editor_type`,`editor_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `languages_name_unique` (`name`),
  ADD UNIQUE KEY `languages_code_unique` (`code`);

--
-- Indexes for table `ledgers`
--
ALTER TABLE `ledgers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ledgers_creator_type_creator_id_index` (`creator_type`,`creator_id`),
  ADD KEY `ledgers_editor_type_editor_id_index` (`editor_type`,`editor_id`);

--
-- Indexes for table `ltm_translations`
--
ALTER TABLE `ltm_translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_model_type_model_id_index` (`model_type`,`model_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_creator_type_creator_id_index` (`creator_type`,`creator_id`),
  ADD KEY `products_editor_type_editor_id_index` (`editor_type`,`editor_id`);

--
-- Indexes for table `product_details`
--
ALTER TABLE `product_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_items`
--
ALTER TABLE `product_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_items_name_unique` (`name`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchases_creator_type_creator_id_index` (`creator_type`,`creator_id`),
  ADD KEY `purchases_editor_type_editor_id_index` (`editor_type`,`editor_id`);

--
-- Indexes for table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_creator_type_creator_id_index` (`creator_type`,`creator_id`),
  ADD KEY `sales_editor_type_editor_id_index` (`editor_type`,`editor_id`);

--
-- Indexes for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shops_creator_type_creator_id_index` (`creator_type`,`creator_id`),
  ADD KEY `shops_editor_type_editor_id_index` (`editor_type`,`editor_id`);

--
-- Indexes for table `taxs`
--
ALTER TABLE `taxs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `taxs_creator_type_creator_id_index` (`creator_type`,`creator_id`),
  ADD KEY `taxs_editor_type_editor_id_index` (`editor_type`,`editor_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_creator_type_creator_id_index` (`creator_type`,`creator_id`),
  ADD KEY `transactions_editor_type_editor_id_index` (`editor_type`,`editor_id`),
  ADD KEY `transactions_invoice_id_index` (`invoice_id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `units_creator_type_creator_id_index` (`creator_type`,`creator_id`),
  ADD KEY `units_editor_type_editor_id_index` (`editor_type`,`editor_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addons`
--
ALTER TABLE `addons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `backend_menus`
--
ALTER TABLE `backend_menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `balances`
--
ALTER TABLE `balances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ledgers`
--
ALTER TABLE `ledgers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ltm_translations`
--
ALTER TABLE `ltm_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_details`
--
ALTER TABLE `product_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `product_items`
--
ALTER TABLE `product_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `purchase_items`
--
ALTER TABLE `purchase_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `taxs`
--
ALTER TABLE `taxs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

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
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
