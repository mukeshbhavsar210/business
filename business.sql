-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2026 at 08:05 AM
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
-- Database: `business`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `model` varchar(50) DEFAULT NULL,
  `logo` varchar(50) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `description` varchar(50) DEFAULT NULL,
  `discount` varchar(50) DEFAULT NULL,
  `brand_order` int(3) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `slug`, `model`, `logo`, `status`, `description`, `discount`, `brand_order`, `created_at`, `updated_at`) VALUES
(45, 'H&M', 'hm', '45_hm_model.jpg', '45_hm_logo.png', 1, 'Cool Casuals', 'Flat 40% Off', 1, '2026-03-20 02:07:16', '2026-03-20 02:07:16'),
(46, 'Lux Cozi', 'lux-cozi', '46_lux-cozi_model.jpg', '46_lux-cozi_logo.png', 1, 'best', 'Min 50% Off', 1, '2026-03-20 08:59:57', '2026-03-20 08:59:57');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `category_slug` varchar(50) DEFAULT NULL,
  `image` varchar(50) DEFAULT NULL,
  `status` int(5) NOT NULL DEFAULT 1,
  `menu_order` int(3) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `category_slug`, `image`, `status`, `menu_order`, `created_at`, `updated_at`) VALUES
(82, 'Men', 'men', '82-men.jpg', 1, 1, '2023-11-23 23:55:20', '2026-02-28 06:33:51'),
(83, 'Women', 'women', '83-women.jpg', 1, 2, '2023-11-23 23:55:28', '2026-02-28 06:40:20'),
(149, 'Kids', 'kids', '149-kids-2.jpeg', 1, 3, '2026-02-16 23:27:00', '2026-03-24 00:39:32');

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(10) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(1, 'Black', '#36454f', NULL, NULL),
(2, 'White', '#FFFFFF', NULL, NULL),
(3, 'Blue', '#0074d9', NULL, NULL),
(4, 'Red', '#FF0000', NULL, NULL),
(5, 'Grey', '#9fa8ab', NULL, NULL),
(6, 'Navy Blue', '#3c4477', NULL, NULL),
(7, 'Brown', '#915039', NULL, NULL),
(8, 'Green', '#5eb160', NULL, NULL),
(9, 'Olive', '#3d9970', NULL, NULL),
(12, 'Yellow', '#3d9970', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `coupon_product`
--

CREATE TABLE `coupon_product` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `discount_coupons_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_addresses`
--

CREATE TABLE `customer_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `address_type` enum('Home','Office') DEFAULT 'Home',
  `default_address` int(3) DEFAULT 0,
  `name` varchar(50) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `address` text NOT NULL,
  `locality` varchar(50) DEFAULT NULL,
  `city` varchar(50) NOT NULL,
  `state_id` bigint(20) UNSIGNED DEFAULT NULL,
  `zip` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_addresses`
--

INSERT INTO `customer_addresses` (`id`, `user_id`, `address_type`, `default_address`, `name`, `mobile`, `address`, `locality`, `city`, `state_id`, `zip`, `created_at`, `updated_at`) VALUES
(1, 7, 'Home', 1, 'Dhruv Bhavsar', '9978812345', 'Shlok Heights, Next to Mirada Banquet hall, Mansarovar road, New Chandkheda', 'Gandhinagar', 'Ahmedabad', 7, '382424', NULL, '2026-03-17 08:42:48');

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `discount_percentages_id` bigint(20) UNSIGNED DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`id`, `product_id`, `discount_percentages_id`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`) VALUES
(9, 64, 5, '2026-03-24', '2026-04-23', 1, '2026-03-23 02:46:20', '2026-03-24 01:06:15'),
(10, 59, 3, '2026-03-24', '2026-04-23', 1, '2026-03-23 09:24:04', '2026-03-24 01:15:43'),
(11, 65, 5, '2026-03-24', '2026-04-23', 1, '2026-03-24 01:22:00', '2026-03-24 01:22:00'),
(12, 67, 5, '2026-03-24', '2026-04-23', 1, '2026-03-24 01:34:37', '2026-03-24 01:34:37');

-- --------------------------------------------------------

--
-- Table structure for table `discount_coupons`
--

CREATE TABLE `discount_coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(25) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(150) DEFAULT NULL,
  `max_uses` varchar(10) DEFAULT NULL,
  `max_uses_user` varchar(10) DEFAULT NULL,
  `type` enum('percent','fixed') NOT NULL DEFAULT 'fixed',
  `discount_amount` double(10,2) NOT NULL,
  `min_amount` double(10,2) DEFAULT NULL,
  `used_count` int(3) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `starts_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `discount_coupons`
--

INSERT INTO `discount_coupons` (`id`, `code`, `image`, `name`, `description`, `max_uses`, `max_uses_user`, `type`, `discount_amount`, `min_amount`, `used_count`, `status`, `starts_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(4, 'IND30', 'coupon1.jpg', 'Save 161', '30%  off on minimum purchase of Rs. 300 .', '10', '3', 'percent', 10.00, 999.00, 1, 1, '2023-11-27 11:36:57', '2026-03-31 11:36:59', '2023-11-28 06:07:01', '2023-11-29 02:18:46'),
(5, 'IND99', 'coupon2.jpg', 'Independence Day', '50%  off on minimum purchase of Rs. 300 .', '10', '2', 'fixed', 90.00, 1000.00, NULL, 1, '2023-11-28 11:39:33', '2026-04-30 11:36:59', '2023-11-28 06:09:46', '2023-11-29 02:17:51'),
(13, 'IND999', 'coupon2.jpg', 'Independence Day', '50%  off on minimum purchase of Rs. 300 .', '10', '2', 'fixed', 90.00, 1000.00, NULL, 1, '2023-11-28 11:39:33', '2026-04-30 11:36:59', '2023-11-28 06:09:46', '2023-11-29 02:17:51');

-- --------------------------------------------------------

--
-- Table structure for table `discount_percentages`
--

CREATE TABLE `discount_percentages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `percentage` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `discount_percentages`
--

INSERT INTO `discount_percentages` (`id`, `percentage`, `created_at`, `updated_at`) VALUES
(1, 10, NULL, NULL),
(2, 20, NULL, NULL),
(3, 30, NULL, NULL),
(4, 40, NULL, NULL),
(5, 50, NULL, NULL),
(6, 60, NULL, NULL),
(7, 70, NULL, NULL),
(8, 80, NULL, NULL),
(9, 90, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_11_18_051106_alter_users_table', 2),
(6, '2023_11_20_052052_create_categories_table', 3),
(7, '2023_11_20_091142_create_temp_images_table', 4),
(8, '2023_11_20_123339_create_sub_categories_table', 5),
(9, '2023_11_21_045811_create_brands_table', 6),
(10, '2023_11_21_063746_create_products_table', 7),
(11, '2023_11_21_063811_create_product_images_table', 7),
(12, '2023_11_23_101727_alter_categories_table', 8),
(13, '2023_11_23_102759_alter_products_table', 9),
(14, '2023_11_23_103442_alter_sub_categories_table', 10),
(15, '2023_11_24_064315_alter_products_table', 11),
(16, '2023_11_25_072939_create_countries_table', 12),
(17, '2023_11_25_075119_create_orders_table', 13),
(18, '2023_11_25_075155_create_orders_items_table', 13),
(19, '2023_11_25_075250_create_customer_addresses_table', 13),
(20, '2023_11_25_135444_create_shipping_charges_table', 14),
(21, '2023_11_28_090521_create_discount_coupons_table', 15),
(22, '2023_11_28_091637_create_discount_coupons_table', 16),
(23, '2023_11_28_091724_create_discount_coupons_table', 17),
(24, '2023_11_28_092025_create_discount_coupons_table', 18),
(25, '2023_11_28_092115_create_discount_coupons_table', 19),
(26, '2023_11_28_092301_create_discount_coupons_table', 20),
(27, '2023_11_29_084104_alter_orders_table', 21),
(28, '2023_11_29_104758_alter_orders_table', 22),
(29, '2023_11_30_051729_create_wishlists_table', 23),
(30, '2023_12_01_060717_alter_users_table', 24),
(31, '2023_12_01_072404_create_pages_table', 25),
(32, '2023_12_02_111056_create_product_ratings_table', 26),
(33, '2023_12_29_074318_create_payments_table', 27),
(34, '2025_01_15_105251_create_sessions_table', 27),
(35, '2026_02_16_073802_create_sub_sub_categories_table', 27),
(36, '2026_02_16_085459_create_sub_sub_categories_table', 28),
(37, '2026_02_17_105618_add_sub2_category_id_to_products_table', 29),
(38, '2026_02_17_110712_add_sub2_category_id_to_products_table', 30),
(39, '2026_02_17_111316_add_sub_sub_category_id_to_products_table', 31),
(40, '2026_02_17_112636_create_colors_table', 32),
(41, '2026_02_17_112942_create_sizes_table', 33),
(42, '2026_02_17_113153_add_color_id_to_products_table', 34),
(43, '2026_02_17_113319_add_size_id_to_products_table', 35),
(44, '2026_02_19_050146_create_states_table', 36),
(45, '2026_02_21_125624_create_ratings_table', 37),
(46, '2026_02_23_054037_create_reviews_table', 38),
(47, '2026_02_23_080323_create_product_variants_table', 39),
(48, '2026_02_25_123902_add_state_id_to_orders_table', 40),
(49, '2026_02_25_124841_add_variant_fields_to_order_items_table', 41),
(50, '2026_03_06_104029_add_customer_address_id_to_properties_table', 42),
(51, '2026_03_06_122940_create_order_status_histories_table', 43),
(52, '2026_03_09_065212_create_coupon_product_table', 44),
(53, '2026_03_10_124112_create_discounts_table', 45),
(54, '2026_03_11_041927_create_discount_percentages_table', 46),
(55, '2026_03_11_043119_add_discount_percentage_id_to_products_table', 47),
(56, '2026_03_12_130417_create_payments_table', 48),
(57, '2026_03_13_101312_add_product_variant_id_to_orders_table', 49),
(58, '2026_03_13_102116_add_product_variant_id_to_orders_table', 50),
(59, '2026_03_14_070156_create_carts_table', 51),
(60, '2026_03_20_142012_create_product_color_table', 52),
(61, '2026_03_20_142026_create_product_size_table', 52),
(62, '2026_03_21_141335_add_discount_percentages_id_to_properties_table', 53);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_address_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subtotal` double(10,2) NOT NULL,
  `shipping` double(10,2) NOT NULL,
  `coupon_code` varchar(30) DEFAULT NULL,
  `coupon_code_id` int(11) DEFAULT NULL,
  `discount` double(10,2) DEFAULT NULL,
  `grandtotal` double(10,2) NOT NULL,
  `payment_status` enum('Paid','Not Paid') NOT NULL DEFAULT 'Not Paid',
  `payment_method` varchar(25) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `product_id`, `product_variant_id`, `customer_address_id`, `subtotal`, `shipping`, `coupon_code`, `coupon_code_id`, `discount`, `grandtotal`, `payment_status`, `payment_method`, `created_at`, `updated_at`) VALUES
(181, 7, NULL, NULL, 1, 250.00, 50.00, '', NULL, 0.00, 300.00, 'Not Paid', 'cod', '2026-03-23 02:47:01', '2026-03-23 02:47:01'),
(182, 7, NULL, NULL, 1, 250.00, 50.00, '', NULL, 0.00, 300.00, 'Not Paid', 'cod', '2026-03-23 02:48:31', '2026-03-23 02:48:31');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `color` varchar(20) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `price` double(10,2) NOT NULL,
  `total` double(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_variant_id`, `color`, `size`, `qty`, `price`, `total`, `created_at`, `updated_at`) VALUES
(19, 181, 64, NULL, 'Blue', 'M', 1, 500.00, 250.00, '2026-03-23 02:47:01', '2026-03-23 02:47:01'),
(20, 182, 64, NULL, 'Navy Blue', 'Extra Large', 1, 500.00, 250.00, '2026-03-23 02:48:31', '2026-03-23 02:48:31');

-- --------------------------------------------------------

--
-- Table structure for table `order_status_histories`
--

CREATE TABLE `order_status_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `tracking_number` varchar(20) DEFAULT NULL,
  `courier` varchar(50) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `cancel_reason` varchar(60) DEFAULT NULL,
  `cancel_comments` text DEFAULT NULL,
  `status` enum('Confirmed','Placed','Packed','Shipped','Out for Delivery','Delivered','Cancelled','Returned','Exchanged') NOT NULL DEFAULT 'Confirmed',
  `date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_status_histories`
--

INSERT INTO `order_status_histories` (`id`, `order_id`, `tracking_number`, `courier`, `note`, `cancel_reason`, `cancel_comments`, `status`, `date`, `created_at`, `updated_at`) VALUES
(146, 181, NULL, 'Shadofox', 'note', NULL, NULL, 'Confirmed', '2026-03-23 02:47:01', '2026-03-23 02:47:01', '2026-03-23 02:47:01'),
(147, 182, NULL, 'Shadofox', 'note', NULL, NULL, 'Confirmed', '2026-03-23 02:48:31', '2026-03-23 02:48:31', '2026-03-23 02:48:31');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `content` text DEFAULT NULL,
  `menu_order` int(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `slug`, `content`, `menu_order`, `created_at`, `updated_at`) VALUES
(2, 'About us', 'about-us', '<p><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p><p><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\"><br></span><br></p>', 2, '2023-12-01 03:33:50', '2023-12-01 03:33:50'),
(3, 'Contact', 'contact-us', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using Content.</p>\r\n                    <address>\r\n                    Cecilia Chapman <br>\r\n                    711-2880 Nulla St.<br>\r\n                    Mankato Mississippi 96522<br>\r\n                    <a href=\"tel:+xxxxxxxx\">(XXX) 555-2368</a><br>\r\n                    <a href=\"mailto:jim@rock.com\">jim@rock.com</a>\r\n                    </address>', 1, '2023-12-01 03:44:47', '2023-12-01 06:07:41'),
(5, 'FAQ', 'faq', '<p>test</p>', 3, '2026-02-26 23:16:46', '2026-02-26 23:22:54');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `variant_id` bigint(20) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `shipping_returns` text DEFAULT NULL,
  `related_products` text DEFAULT NULL,
  `price` double(10,2) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `sub_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sub_sub_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `discount_percentage_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_featured` enum('Yes','No') NOT NULL DEFAULT 'No',
  `sku` varchar(25) NOT NULL,
  `barcode` varchar(25) DEFAULT NULL,
  `track_qty` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `qty` int(11) DEFAULT NULL,
  `recommended` varchar(10) DEFAULT NULL,
  `views` varchar(10) DEFAULT NULL,
  `discount_percentage` varchar(10) DEFAULT NULL,
  `average_rating` varchar(10) DEFAULT NULL,
  `cod` int(10) DEFAULT 0,
  `is_returnable` int(1) DEFAULT 0,
  `return_days` enum('7 days','14 days') DEFAULT '7 days',
  `delivery_min_days` date DEFAULT NULL,
  `delivery_max_days` date DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `slug`, `description`, `short_description`, `shipping_returns`, `related_products`, `price`, `category_id`, `sub_category_id`, `sub_sub_category_id`, `brand_id`, `discount_percentage_id`, `is_featured`, `sku`, `barcode`, `track_qty`, `qty`, `recommended`, `views`, `discount_percentage`, `average_rating`, `cod`, `is_returnable`, `return_days`, `delivery_min_days`, `delivery_max_days`, `status`, `created_at`, `updated_at`) VALUES
(59, 'Park Avenue', 'park-avenue', 'test', 'Printed Polo Collar Slim Fit T-shirt', 'test', '', 1599.00, 82, 42, 1, 45, 3, 'Yes', 'tshirt_02', 'tshirt_000002', 'Yes', 100, NULL, NULL, NULL, NULL, 1, 1, '7 days', '2026-03-24', '2026-03-31', 1, '2026-03-20 02:52:28', '2026-03-24 01:15:43'),
(64, 'Lux Cozi', 'lux-cozi', 'test', 'Polo Collar Lounge Tshirts', 'test', '', 700.00, 82, 42, 1, 46, 5, 'Yes', 'tshirt_011', 'tshirt_11', 'Yes', 97, NULL, NULL, NULL, NULL, 1, 1, '7 days', '2026-03-24', '2026-03-31', 1, '2026-03-20 09:48:06', '2026-03-24 01:06:15'),
(65, 'Ponds', 'ponds', 'test', 'Polo Collar Lounge Tshirts', 'test', '', 500.00, 83, 46, 24, 46, 5, 'Yes', 'tshirt_011', 'tshirt_11', 'Yes', 99, NULL, NULL, NULL, NULL, 1, 1, '7 days', '2026-03-24', '2026-03-31', 1, '2026-03-20 09:48:06', '2026-03-24 01:22:00'),
(67, 'Kurtas', 'kurtas', 'test', 'Polo Collar Lounge Tshirts', 'test', '', 500.00, 83, 50, 26, 46, 5, 'Yes', 'tshirt_011', 'tshirt_11', 'Yes', 99, NULL, NULL, NULL, NULL, 1, 1, '7 days', '2026-03-24', '2026-03-31', 1, '2026-03-20 09:48:06', '2026-03-24 01:34:37');

-- --------------------------------------------------------

--
-- Table structure for table `product_colors`
--

CREATE TABLE `product_colors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `color_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_colors`
--

INSERT INTO `product_colors` (`id`, `product_id`, `color_id`) VALUES
(10, 64, 5),
(12, 64, 3),
(15, 59, 1),
(16, 59, 2),
(19, 64, 7),
(21, 64, 6);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image`, `sort_order`, `created_at`, `updated_at`) VALUES
(51, 64, '64-Lux Cozi-51-1774094908.jpg', NULL, '2026-03-21 06:38:28', '2026-03-21 06:38:28'),
(52, 64, '64-Lux Cozi-52-1774094908.jpg', NULL, '2026-03-21 06:38:28', '2026-03-21 06:38:28'),
(53, 64, '64-Lux Cozi-53-1774094908.jpg', NULL, '2026-03-21 06:38:28', '2026-03-21 06:38:28'),
(54, 59, '59-Park Avenue-54.jpg', NULL, '2026-03-21 06:41:28', '2026-03-21 06:41:28'),
(55, 59, '59-Park Avenue-55.jpg', NULL, '2026-03-21 06:41:28', '2026-03-21 06:41:28'),
(56, 67, '67-Kurtas-56.jpg', NULL, '2026-03-24 01:34:38', '2026-03-24 01:34:38');

-- --------------------------------------------------------

--
-- Table structure for table `product_ratings`
--

CREATE TABLE `product_ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `rating` double(3,2) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_sizes`
--

CREATE TABLE `product_sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `size_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_sizes`
--

INSERT INTO `product_sizes` (`id`, `product_id`, `size_id`) VALUES
(6, 59, 2),
(7, 64, 2),
(8, 59, 1),
(9, 59, 3),
(10, 64, 3),
(12, 64, 4);

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `image`, `created_at`, `updated_at`) VALUES
(28, 64, '64-28-1774078887.jpg', '2026-03-21 02:11:27', '2026-03-21 02:11:27'),
(29, 64, '64-29-1774093826.jpg', '2026-03-21 06:20:26', '2026-03-21 06:20:26'),
(30, 64, '64-30-1774093827.jpg', '2026-03-21 06:20:27', '2026-03-21 06:20:27'),
(33, 59, '59-Park Avenue-33.jpg', '2026-03-21 06:41:27', '2026-03-21 06:41:27'),
(34, 59, '59-Park Avenue-34.jpg', '2026-03-21 06:41:27', '2026-03-21 06:41:27'),
(35, 64, '64-Lux Cozi-35.jpg', '2026-03-24 00:10:35', '2026-03-24 00:10:35'),
(36, 64, 'lux-cozi_64_36.jpg', '2026-03-24 00:12:38', '2026-03-24 00:12:38'),
(37, 67, 'kurtas_67_37.jpg', '2026-03-24 01:34:37', '2026-03-24 01:34:37');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rating` tinyint(4) NOT NULL,
  `review` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(4) NOT NULL,
  `review` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_charges`
--

CREATE TABLE `shipping_charges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `state_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` double(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipping_charges`
--

INSERT INTO `shipping_charges` (`id`, `state_id`, `amount`, `created_at`, `updated_at`) VALUES
(13, 7, 50.00, '2023-11-28 00:49:44', '2023-11-28 02:49:48'),
(20, 22, 50.00, '2026-02-19 00:59:06', '2026-02-19 00:59:06'),
(21, 37, 11.00, '2026-02-19 01:02:59', '2026-02-19 01:02:59'),
(22, 3, 60.00, '2026-02-26 00:12:00', '2026-02-26 00:12:00'),
(23, 4, 55.00, '2026-02-26 00:12:43', '2026-02-26 00:12:43');

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `code` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(1, 'Small', 'S', NULL, NULL),
(2, 'Medium', 'M', NULL, NULL),
(3, 'Large', 'L', NULL, NULL),
(4, 'Extra Large', 'XL', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(1, 'Andhra Pradesh', 'AP', NULL, NULL),
(2, 'Arunachal Pradesh', 'AR', NULL, NULL),
(3, 'Assam', 'AS', NULL, NULL),
(4, 'Bihar', 'BR', NULL, NULL),
(5, 'Chhattisgarh', 'CG', NULL, NULL),
(6, 'Goa', 'GA', NULL, NULL),
(7, 'Gujarat', 'GJ', NULL, NULL),
(8, 'Haryana', 'HR', NULL, NULL),
(9, 'Himachal Pradesh', 'HP', NULL, NULL),
(10, 'Jharkhand', 'JH', NULL, NULL),
(11, 'Karnataka', 'KA', NULL, NULL),
(12, 'Kerala', 'KL', NULL, NULL),
(13, 'Madhya Pradesh', 'MP', NULL, NULL),
(14, 'Maharashtra', 'MH', NULL, NULL),
(15, 'Manipur', 'MN', NULL, NULL),
(16, 'Meghalaya', 'ML', NULL, NULL),
(17, 'Mizoram', 'MZ', NULL, NULL),
(18, 'Nagaland', 'NL', NULL, NULL),
(19, 'Odisha', 'OD', NULL, NULL),
(20, 'Punjab', 'PB', NULL, NULL),
(21, 'Rajasthan', 'RJ', NULL, NULL),
(22, 'Sikkim', 'SK', NULL, NULL),
(23, 'Tamil Nadu', 'TN', NULL, NULL),
(24, 'Telangana', 'TS', NULL, NULL),
(25, 'Tripura', 'TR', NULL, NULL),
(26, 'Uttar Pradesh', 'UP', NULL, NULL),
(27, 'Uttarakhand', 'UK', NULL, NULL),
(28, 'West Bengal', 'WB', NULL, NULL),
(29, 'Andaman and Nicobar Islands', 'AN', NULL, NULL),
(30, 'Chandigarh', 'CH', NULL, NULL),
(31, 'Dadra and Nagar Haveli and Daman and Diu', 'DN', NULL, NULL),
(32, 'Delhi', 'DL', NULL, NULL),
(33, 'Jammu and Kashmir', 'JK', NULL, NULL),
(34, 'Ladakh', 'LA', NULL, NULL),
(35, 'Lakshadweep', 'LD', NULL, NULL),
(36, 'Puducherry', 'PY', NULL, NULL),
(37, 'Rest of the state', 'RS', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sub_category_title` varchar(100) NOT NULL,
  `sub_category_name` varchar(100) NOT NULL,
  `sub_category_slug` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `image` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `sub_category_title`, `sub_category_name`, `sub_category_slug`, `status`, `category_id`, `created_at`, `image`, `updated_at`) VALUES
(36, 'Boys Clothing', 'Kids_Boys Clothing', 'kids-boys-clothing', 1, 149, '2026-03-24 00:40:25', NULL, '2026-03-24 00:40:25'),
(42, 'Top Wear', 'Men - Top Wear', 'men-top-wear', 1, 82, '2026-03-24 01:03:29', NULL, '2026-03-24 01:03:29'),
(43, 'Bottom Wear', 'Men - Bottom Wear', 'men-bottom-wear', 1, 82, '2026-03-24 01:11:26', NULL, '2026-03-24 01:11:26'),
(44, 'Jackets', 'Men - Jackets', 'men-jackets', 1, 82, '2026-03-24 01:17:02', NULL, '2026-03-24 01:17:02'),
(45, 'Watches', 'Men - Watches', 'men-watches', 1, 82, '2026-03-24 01:17:52', NULL, '2026-03-24 01:17:52'),
(46, 'Indian & Fushion Wear', 'Women - Indian & Fushion Wear', 'women-indian-fushion-wear', 1, 83, '2026-03-24 01:20:30', NULL, '2026-03-24 01:20:30'),
(47, 'Jewellery', 'Women - Jewellery', 'women-jewellery', 1, 83, '2026-03-24 01:22:41', NULL, '2026-03-24 01:22:41'),
(48, 'Sarees', 'Women - Sarees', 'women-sarees', 1, 83, '2026-03-24 01:23:28', NULL, '2026-03-24 01:23:28'),
(50, 'Western Wear', 'Women - Western Wear', 'women-western-wear', 1, 83, '2026-03-24 01:33:54', NULL, '2026-03-24 01:33:54');

-- --------------------------------------------------------

--
-- Table structure for table `sub_sub_categories`
--

CREATE TABLE `sub_sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `sub_category_id` bigint(20) UNSIGNED NOT NULL,
  `sub_sub_category_name` varchar(255) NOT NULL,
  `sub_sub_category_slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_sub_categories`
--

INSERT INTO `sub_sub_categories` (`id`, `category_id`, `sub_category_id`, `sub_sub_category_name`, `sub_sub_category_slug`, `created_at`, `updated_at`) VALUES
(1, 82, 42, 'T-shirt', 't-shirt', '2026-02-16 03:28:51', '2026-02-16 03:28:51'),
(10, 82, 43, 'Jeans', 'jeans', '2026-02-16 23:45:53', '2026-02-16 23:45:53'),
(11, 82, 43, 'Casual Shoes', 'casual-shoes', '2026-02-16 23:46:42', '2026-02-20 07:25:55'),
(21, 82, 42, 'Casual Shirt', 'casual_shirt', '2026-03-16 09:10:25', '2026-03-16 09:10:25'),
(23, 149, 36, 'Clothing Sets', 'clothing-sets', '2026-03-24 00:41:55', '2026-03-24 00:41:55'),
(24, 83, 46, 'Kurtas and Suits', 'kurtas-and-suits', '2026-03-24 01:21:37', '2026-03-24 01:21:37'),
(25, 83, 46, 'Ethnic Wear', 'ethnic-we', '2026-03-24 01:28:06', '2026-03-24 01:28:06'),
(26, 83, 50, 'Dresses', 'dresses', '2026-03-24 01:34:18', '2026-03-24 01:34:18');

-- --------------------------------------------------------

--
-- Table structure for table `temp_images`
--

CREATE TABLE `temp_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `temp_images`
--

INSERT INTO `temp_images` (`id`, `name`, `created_at`, `updated_at`) VALUES
(176, '1771507053.png', '2026-02-19 07:47:33', '2026-02-19 07:47:33'),
(177, '1771853843.png', '2026-02-23 08:07:23', '2026-02-23 08:07:23'),
(178, '1771853881.png', '2026-02-23 08:08:01', '2026-02-23 08:08:01'),
(179, '1771853884.png', '2026-02-23 08:08:04', '2026-02-23 08:08:04'),
(180, '1771853906.png', '2026-02-23 08:08:26', '2026-02-23 08:08:26'),
(181, '1771854010.png', '2026-02-23 08:10:10', '2026-02-23 08:10:10'),
(182, '1771854020.png', '2026-02-23 08:10:20', '2026-02-23 08:10:20'),
(183, '1771854029.png', '2026-02-23 08:10:29', '2026-02-23 08:10:29'),
(184, '1771854076.png', '2026-02-23 08:11:16', '2026-02-23 08:11:16'),
(185, '1772257475.jpg', '2026-02-28 00:14:35', '2026-02-28 00:14:35'),
(186, '1772279331.jpg', '2026-02-28 06:18:51', '2026-02-28 06:18:51'),
(187, '1772279525.jpg', '2026-02-28 06:22:05', '2026-02-28 06:22:05'),
(188, '1772279738.jpg', '2026-02-28 06:25:38', '2026-02-28 06:25:38'),
(189, '1772279794.jpg', '2026-02-28 06:26:34', '2026-02-28 06:26:34'),
(190, '1772279815.jpg', '2026-02-28 06:26:55', '2026-02-28 06:26:55'),
(191, '1772280034.jpg', '2026-02-28 06:30:34', '2026-02-28 06:30:34'),
(192, '1772280119.jpg', '2026-02-28 06:31:59', '2026-02-28 06:31:59'),
(193, '1772280157.jpg', '2026-02-28 06:32:37', '2026-02-28 06:32:37'),
(194, '1772280184.jpg', '2026-02-28 06:33:04', '2026-02-28 06:33:04'),
(195, '1772280229.jpg', '2026-02-28 06:33:49', '2026-02-28 06:33:49'),
(196, '1772280318.png', '2026-02-28 06:35:18', '2026-02-28 06:35:18'),
(197, '1772280411.jpg', '2026-02-28 06:36:51', '2026-02-28 06:36:51'),
(198, '1772280496.jpg', '2026-02-28 06:38:16', '2026-02-28 06:38:16'),
(199, '1772280580.jpg', '2026-02-28 06:39:40', '2026-02-28 06:39:40'),
(200, '1772280618.jpg', '2026-02-28 06:40:18', '2026-02-28 06:40:18'),
(201, '1772281708.jpg', '2026-02-28 06:58:28', '2026-02-28 06:58:28'),
(202, '1772283568.jpg', '2026-02-28 07:29:28', '2026-02-28 07:29:28'),
(203, '1772283745.jpg', '2026-02-28 07:32:25', '2026-02-28 07:32:25'),
(204, '1772283877.png', '2026-02-28 07:34:37', '2026-02-28 07:34:37'),
(205, '1772284002.png', '2026-02-28 07:36:42', '2026-02-28 07:36:42'),
(206, '1772284148.jpg', '2026-02-28 07:39:08', '2026-02-28 07:39:08'),
(207, '1772284713.JPG', '2026-02-28 07:48:33', '2026-02-28 07:48:33'),
(208, '1772284849.JPG', '2026-02-28 07:50:49', '2026-02-28 07:50:49'),
(209, '1772284909.JPG', '2026-02-28 07:51:49', '2026-02-28 07:51:49'),
(210, '1772284941.JPG', '2026-02-28 07:52:21', '2026-02-28 07:52:21'),
(211, '1772286537.JPG', '2026-02-28 08:18:57', '2026-02-28 08:18:57'),
(212, '1772286540.JPG', '2026-02-28 08:19:00', '2026-02-28 08:19:00'),
(213, '1772286548.JPG', '2026-02-28 08:19:08', '2026-02-28 08:19:08'),
(214, '1772286624.JPG', '2026-02-28 08:20:24', '2026-02-28 08:20:24'),
(215, '1772286693.jpg', '2026-02-28 08:21:33', '2026-02-28 08:21:33'),
(216, '1772286903.png', '2026-02-28 08:25:03', '2026-02-28 08:25:03'),
(217, '1772435118.jpg', '2026-03-02 01:35:18', '2026-03-02 01:35:18'),
(218, '1773666235.JPG', '2026-03-16 07:33:55', '2026-03-16 07:33:55'),
(219, '1773666294.JPG', '2026-03-16 07:34:54', '2026-03-16 07:34:54'),
(220, '1773666431.JPG', '2026-03-16 07:37:11', '2026-03-16 07:37:11'),
(221, '1773666617.JPG', '2026-03-16 07:40:17', '2026-03-16 07:40:17'),
(222, '1773666702.JPG', '2026-03-16 07:41:42', '2026-03-16 07:41:42'),
(223, '1773666820.JPG', '2026-03-16 07:43:40', '2026-03-16 07:43:40'),
(224, '1773667423.JPG', '2026-03-16 07:53:43', '2026-03-16 07:53:43'),
(225, '1773667494.JPG', '2026-03-16 07:54:54', '2026-03-16 07:54:54'),
(226, '1773667598.JPG', '2026-03-16 07:56:38', '2026-03-16 07:56:38'),
(227, '1773667661.JPG', '2026-03-16 07:57:41', '2026-03-16 07:57:41'),
(228, '1773667708.JPG', '2026-03-16 07:58:28', '2026-03-16 07:58:28'),
(229, '1773667739.JPG', '2026-03-16 07:58:59', '2026-03-16 07:58:59'),
(230, '1773671571.JPG', '2026-03-16 09:02:51', '2026-03-16 09:02:51'),
(231, '1773748506.JPG', '2026-03-17 06:25:06', '2026-03-17 06:25:06'),
(232, '1773748546.JPG', '2026-03-17 06:25:46', '2026-03-17 06:25:46'),
(233, '1773752668.JPG', '2026-03-17 07:34:28', '2026-03-17 07:34:28'),
(234, '1773989759.png', '2026-03-20 01:25:59', '2026-03-20 01:25:59'),
(235, '1773989763.png', '2026-03-20 01:26:03', '2026-03-20 01:26:03'),
(236, '1773989832.jpg', '2026-03-20 01:27:12', '2026-03-20 01:27:12'),
(237, '1773990132.jpg', '2026-03-20 01:32:12', '2026-03-20 01:32:12'),
(238, '1773990177.png', '2026-03-20 01:32:57', '2026-03-20 01:32:57'),
(239, '1773994921.jpg', '2026-03-20 02:52:01', '2026-03-20 02:52:01'),
(240, '1773994922.jpg', '2026-03-20 02:52:02', '2026-03-20 02:52:02'),
(241, '1773994923.jpg', '2026-03-20 02:52:03', '2026-03-20 02:52:03'),
(242, '1773994923.jpg', '2026-03-20 02:52:03', '2026-03-20 02:52:03'),
(243, '1773994923.jpg', '2026-03-20 02:52:03', '2026-03-20 02:52:03'),
(244, '1774017718.jpg', '2026-03-20 09:11:58', '2026-03-20 09:11:58'),
(245, '1774017718.jpg', '2026-03-20 09:11:58', '2026-03-20 09:11:58'),
(246, '1774017719.jpg', '2026-03-20 09:11:59', '2026-03-20 09:11:59'),
(247, '1774017730.jpg', '2026-03-20 09:12:10', '2026-03-20 09:12:10'),
(248, '1774017730.jpg', '2026-03-20 09:12:10', '2026-03-20 09:12:10'),
(249, '1774017731.jpg', '2026-03-20 09:12:11', '2026-03-20 09:12:11'),
(250, '1774017731.jpg', '2026-03-20 09:12:11', '2026-03-20 09:12:11'),
(251, '1774017731.jpg', '2026-03-20 09:12:11', '2026-03-20 09:12:11'),
(252, '1774017749.jpg', '2026-03-20 09:12:29', '2026-03-20 09:12:29'),
(253, '1774017752.jpg', '2026-03-20 09:12:32', '2026-03-20 09:12:32'),
(254, '1774017755.jpg', '2026-03-20 09:12:35', '2026-03-20 09:12:35'),
(255, '1774017762.jpg', '2026-03-20 09:12:42', '2026-03-20 09:12:42'),
(256, '1774017933.jpg', '2026-03-20 09:15:33', '2026-03-20 09:15:33'),
(257, '1774017985.jpg', '2026-03-20 09:16:25', '2026-03-20 09:16:25'),
(258, '1774018026.jpg', '2026-03-20 09:17:06', '2026-03-20 09:17:06'),
(259, '1774018029.jpg', '2026-03-20 09:17:09', '2026-03-20 09:17:09'),
(260, '1774018033.jpg', '2026-03-20 09:17:13', '2026-03-20 09:17:13'),
(261, '1774018035.jpg', '2026-03-20 09:17:15', '2026-03-20 09:17:15'),
(262, '1774018301.jpg', '2026-03-20 09:21:41', '2026-03-20 09:21:41'),
(263, '1774018302.jpg', '2026-03-20 09:21:42', '2026-03-20 09:21:42'),
(264, '1774018302.jpg', '2026-03-20 09:21:42', '2026-03-20 09:21:42'),
(265, '1774018310.jpg', '2026-03-20 09:21:50', '2026-03-20 09:21:50'),
(266, '1774018314.jpg', '2026-03-20 09:21:54', '2026-03-20 09:21:54'),
(267, '1774018316.jpg', '2026-03-20 09:21:56', '2026-03-20 09:21:56'),
(268, '1774018318.jpg', '2026-03-20 09:21:58', '2026-03-20 09:21:58'),
(269, '1774018321.jpg', '2026-03-20 09:22:01', '2026-03-20 09:22:01'),
(270, '1774018323.jpg', '2026-03-20 09:22:03', '2026-03-20 09:22:03'),
(271, '1774018440.jpg', '2026-03-20 09:24:00', '2026-03-20 09:24:00'),
(272, '1774018442.jpg', '2026-03-20 09:24:02', '2026-03-20 09:24:02'),
(273, '1774018445.jpg', '2026-03-20 09:24:05', '2026-03-20 09:24:05'),
(274, '1774018450.jpg', '2026-03-20 09:24:10', '2026-03-20 09:24:10'),
(275, '1774018453.jpg', '2026-03-20 09:24:13', '2026-03-20 09:24:13'),
(276, '1774018456.jpg', '2026-03-20 09:24:16', '2026-03-20 09:24:16'),
(277, '1774018458.jpg', '2026-03-20 09:24:18', '2026-03-20 09:24:18'),
(278, '1774018461.jpg', '2026-03-20 09:24:21', '2026-03-20 09:24:21'),
(279, '1774018684.jpg', '2026-03-20 09:28:04', '2026-03-20 09:28:04'),
(280, '1774018721.jpg', '2026-03-20 09:28:41', '2026-03-20 09:28:41'),
(281, '1774018723.jpg', '2026-03-20 09:28:43', '2026-03-20 09:28:43'),
(282, '1774018726.jpg', '2026-03-20 09:28:46', '2026-03-20 09:28:46'),
(283, '1774018729.jpg', '2026-03-20 09:28:49', '2026-03-20 09:28:49'),
(284, '1774018731.jpg', '2026-03-20 09:28:51', '2026-03-20 09:28:51'),
(285, '1774018733.jpg', '2026-03-20 09:28:53', '2026-03-20 09:28:53'),
(286, '1774018736.jpg', '2026-03-20 09:28:56', '2026-03-20 09:28:56'),
(287, '1774018964.jpg', '2026-03-20 09:32:44', '2026-03-20 09:32:44'),
(288, '1774018967.jpg', '2026-03-20 09:32:47', '2026-03-20 09:32:47'),
(289, '1774018969.jpg', '2026-03-20 09:32:49', '2026-03-20 09:32:49'),
(290, '1774018972.jpg', '2026-03-20 09:32:52', '2026-03-20 09:32:52'),
(291, '1774018974.jpg', '2026-03-20 09:32:54', '2026-03-20 09:32:54'),
(292, '1774019119.jpg', '2026-03-20 09:35:19', '2026-03-20 09:35:19'),
(293, '1774019122.jpg', '2026-03-20 09:35:22', '2026-03-20 09:35:22'),
(294, '1774019124.jpg', '2026-03-20 09:35:24', '2026-03-20 09:35:24'),
(295, '1774019128.jpg', '2026-03-20 09:35:28', '2026-03-20 09:35:28'),
(296, '1774019130.jpg', '2026-03-20 09:35:30', '2026-03-20 09:35:30'),
(297, '1774019526.jpg', '2026-03-20 09:42:06', '2026-03-20 09:42:06'),
(298, '1774019529.jpg', '2026-03-20 09:42:09', '2026-03-20 09:42:09'),
(299, '1774019562.jpg', '2026-03-20 09:42:42', '2026-03-20 09:42:42'),
(300, '1774019564.jpg', '2026-03-20 09:42:44', '2026-03-20 09:42:44'),
(301, '1774019567.jpg', '2026-03-20 09:42:47', '2026-03-20 09:42:47'),
(302, '1774019838.jpg', '2026-03-20 09:47:18', '2026-03-20 09:47:18'),
(303, '1774019841.jpg', '2026-03-20 09:47:21', '2026-03-20 09:47:21'),
(304, '1774019857.jpg', '2026-03-20 09:47:37', '2026-03-20 09:47:37'),
(305, '1774019860.jpg', '2026-03-20 09:47:40', '2026-03-20 09:47:40'),
(306, '1774019882.jpg', '2026-03-20 09:48:02', '2026-03-20 09:48:02'),
(307, '1774019884.jpg', '2026-03-20 09:48:04', '2026-03-20 09:48:04'),
(308, '1774078837.jpg', '2026-03-21 02:10:37', '2026-03-21 02:10:37'),
(309, '1774078885.jpg', '2026-03-21 02:11:25', '2026-03-21 02:11:25'),
(310, '1774093811.jpg', '2026-03-21 06:20:11', '2026-03-21 06:20:11'),
(311, '1774093814.jpg', '2026-03-21 06:20:14', '2026-03-21 06:20:14'),
(312, '1774093816.jpg', '2026-03-21 06:20:16', '2026-03-21 06:20:16'),
(313, '1774093819.jpg', '2026-03-21 06:20:19', '2026-03-21 06:20:19'),
(314, '1774093822.jpg', '2026-03-21 06:20:22', '2026-03-21 06:20:22'),
(315, '1774093824.jpg', '2026-03-21 06:20:24', '2026-03-21 06:20:24'),
(316, '1774094897.jpg', '2026-03-21 06:38:17', '2026-03-21 06:38:17'),
(317, '1774094902.jpg', '2026-03-21 06:38:22', '2026-03-21 06:38:22'),
(318, '1774094905.jpg', '2026-03-21 06:38:25', '2026-03-21 06:38:25'),
(319, '1774095059.jpg', '2026-03-21 06:40:59', '2026-03-21 06:40:59'),
(320, '1774095063.jpg', '2026-03-21 06:41:03', '2026-03-21 06:41:03'),
(321, '1774095070.jpg', '2026-03-21 06:41:10', '2026-03-21 06:41:10'),
(322, '1774095073.jpg', '2026-03-21 06:41:13', '2026-03-21 06:41:13'),
(323, '1774096952.jpg', '2026-03-21 07:12:32', '2026-03-21 07:12:32'),
(324, '1774097114.jpg', '2026-03-21 07:15:14', '2026-03-21 07:15:14'),
(325, '1774097891.jpg', '2026-03-21 07:28:11', '2026-03-21 07:28:11'),
(326, '1774097971.jpg', '2026-03-21 07:29:31', '2026-03-21 07:29:31'),
(327, '1774098044.jpg', '2026-03-21 07:30:44', '2026-03-21 07:30:44'),
(328, '1774329634.jpg', '2026-03-23 23:50:34', '2026-03-23 23:50:34'),
(329, '1774330701.jpg', '2026-03-24 00:08:21', '2026-03-24 00:08:21'),
(330, '1774330740.jpg', '2026-03-24 00:09:00', '2026-03-24 00:09:00'),
(331, '1774330806.jpg', '2026-03-24 00:10:06', '2026-03-24 00:10:06'),
(332, '1774330954.jpg', '2026-03-24 00:12:34', '2026-03-24 00:12:34'),
(333, '1774331109.jpg', '2026-03-24 00:15:09', '2026-03-24 00:15:09'),
(334, '1774331112.jpg', '2026-03-24 00:15:12', '2026-03-24 00:15:12'),
(335, '1774331154.jpg', '2026-03-24 00:15:54', '2026-03-24 00:15:54'),
(336, '1774331157.jpg', '2026-03-24 00:15:57', '2026-03-24 00:15:57'),
(337, '1774331220.jpg', '2026-03-24 00:17:00', '2026-03-24 00:17:00'),
(338, '1774331223.jpg', '2026-03-24 00:17:03', '2026-03-24 00:17:03'),
(339, '1774331244.jpg', '2026-03-24 00:17:24', '2026-03-24 00:17:24'),
(340, '1774331246.jpg', '2026-03-24 00:17:26', '2026-03-24 00:17:26'),
(341, '1774331249.jpg', '2026-03-24 00:17:29', '2026-03-24 00:17:29'),
(342, '1774331335.jpg', '2026-03-24 00:18:55', '2026-03-24 00:18:55'),
(343, '1774331338.jpg', '2026-03-24 00:18:58', '2026-03-24 00:18:58'),
(344, '1774331340.jpg', '2026-03-24 00:19:00', '2026-03-24 00:19:00'),
(345, '1774331352.jpg', '2026-03-24 00:19:12', '2026-03-24 00:19:12'),
(346, '1774331354.jpg', '2026-03-24 00:19:14', '2026-03-24 00:19:14'),
(347, '1774331357.jpg', '2026-03-24 00:19:17', '2026-03-24 00:19:17'),
(348, '1774331397.jpg', '2026-03-24 00:19:57', '2026-03-24 00:19:57'),
(349, '1774331400.jpg', '2026-03-24 00:20:00', '2026-03-24 00:20:00'),
(350, '1774331404.jpg', '2026-03-24 00:20:04', '2026-03-24 00:20:04'),
(351, '1774331422.jpg', '2026-03-24 00:20:22', '2026-03-24 00:20:22'),
(352, '1774331424.jpg', '2026-03-24 00:20:24', '2026-03-24 00:20:24'),
(353, '1774331427.jpg', '2026-03-24 00:20:27', '2026-03-24 00:20:27'),
(354, '1774331460.jpg', '2026-03-24 00:21:00', '2026-03-24 00:21:00'),
(355, '1774331462.jpg', '2026-03-24 00:21:02', '2026-03-24 00:21:02'),
(356, '1774331465.jpg', '2026-03-24 00:21:05', '2026-03-24 00:21:05'),
(357, '1774331564.jpg', '2026-03-24 00:22:44', '2026-03-24 00:22:44'),
(358, '1774331567.jpg', '2026-03-24 00:22:47', '2026-03-24 00:22:47'),
(359, '1774331663.jpg', '2026-03-24 00:24:23', '2026-03-24 00:24:23'),
(360, '1774331666.jpg', '2026-03-24 00:24:26', '2026-03-24 00:24:26'),
(361, '1774331668.jpg', '2026-03-24 00:24:28', '2026-03-24 00:24:28'),
(362, '1774331672.jpg', '2026-03-24 00:24:32', '2026-03-24 00:24:32'),
(363, '1774331674.jpg', '2026-03-24 00:24:34', '2026-03-24 00:24:34'),
(364, '1774331676.jpg', '2026-03-24 00:24:36', '2026-03-24 00:24:36'),
(365, '1774331679.jpg', '2026-03-24 00:24:39', '2026-03-24 00:24:39'),
(366, '1774331830.jpg', '2026-03-24 00:27:10', '2026-03-24 00:27:10'),
(367, '1774331833.jpg', '2026-03-24 00:27:13', '2026-03-24 00:27:13'),
(368, '1774331834.jpg', '2026-03-24 00:27:14', '2026-03-24 00:27:14'),
(369, '1774331838.jpg', '2026-03-24 00:27:18', '2026-03-24 00:27:18'),
(370, '1774331840.jpg', '2026-03-24 00:27:20', '2026-03-24 00:27:20'),
(371, '1774332220.jpeg', '2026-03-24 00:33:40', '2026-03-24 00:33:40'),
(372, '1774332254.jpeg', '2026-03-24 00:34:14', '2026-03-24 00:34:14'),
(373, '1774332288.jpeg', '2026-03-24 00:34:48', '2026-03-24 00:34:48'),
(374, '1774332326.jpeg', '2026-03-24 00:35:26', '2026-03-24 00:35:26'),
(375, '1774332516.jpeg', '2026-03-24 00:38:36', '2026-03-24 00:38:36'),
(376, '1774335872.jpg', '2026-03-24 01:34:32', '2026-03-24 01:34:32'),
(377, '1774335875.jpg', '2026-03-24 01:34:35', '2026-03-24 01:34:35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `mobile` varchar(11) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `gender` enum('male','female') DEFAULT 'male',
  `role` int(11) NOT NULL DEFAULT 1,
  `image` varchar(20) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `is_active` int(10) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `mobile`, `birthdate`, `gender`, `role`, `image`, `status`, `email_verified_at`, `password`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'mukeshbhavsar210@gmail.com', '', NULL, NULL, NULL, 2, 'mukesh.webp', 1, NULL, '$2y$12$Iy5Wh1TVAkCYAvaefrR71OEKD4QDjhnnWBxknqjwnioSSM6sAJMnO', 1, NULL, '2023-11-17 23:52:06', '2023-12-01 05:59:34'),
(3, 'Priyanka', 'p.bhavsar2610@gmail', '9538135005', '9978812324', '2026-02-18', 'female', 1, 'priyanka.png', 1, NULL, '$2y$12$Iy5Wh1TVAkCYAvaefrR71OEKD4QDjhnnWBxknqjwnioSSM6sAJMnO', 1, NULL, '2023-11-25 00:32:42', '2026-03-04 00:10:24'),
(7, 'Dhruv', 'dhruvbhavsar210@gmail.com', '9538135005', '9978812324', '2026-02-18', 'male', 1, 'priyanka.png', 1, NULL, '$2y$12$Iy5Wh1TVAkCYAvaefrR71OEKD4QDjhnnWBxknqjwnioSSM6sAJMnO', 1, NULL, '2023-11-25 00:32:42', '2026-03-17 08:37:16');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupon_product`
--
ALTER TABLE `coupon_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coupon_product_discount_coupons_id_foreign` (`discount_coupons_id`),
  ADD KEY `coupon_product_product_id_foreign` (`product_id`);

--
-- Indexes for table `customer_addresses`
--
ALTER TABLE `customer_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_addresses_user_id_foreign` (`user_id`),
  ADD KEY `customer_addresses_state_id_foreign` (`state_id`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `discounts_product_id_foreign` (`product_id`),
  ADD KEY `discounts_discount_percentages_id_foreign` (`discount_percentages_id`);

--
-- Indexes for table `discount_coupons`
--
ALTER TABLE `discount_coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discount_percentages`
--
ALTER TABLE `discount_percentages`
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
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_customer_address_id_foreign` (`customer_address_id`),
  ADD KEY `orders_product_id_foreign` (`product_id`),
  ADD KEY `orders_product_variant_id_foreign` (`product_variant_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `product_variant_id` (`product_variant_id`);

--
-- Indexes for table `order_status_histories`
--
ALTER TABLE `order_status_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_status_histories_order_id_foreign` (`order_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_order_id_foreign` (`order_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_sub_category_id_foreign` (`sub_category_id`),
  ADD KEY `products_brand_id_foreign` (`brand_id`),
  ADD KEY `products_sub_sub_category_id_foreign` (`sub_sub_category_id`),
  ADD KEY `products_discount_percentage_id_foreign` (`discount_percentage_id`);

--
-- Indexes for table `product_colors`
--
ALTER TABLE `product_colors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_color_product_id_foreign` (`product_id`),
  ADD KEY `product_color_color_id_foreign` (`color_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_ratings`
--
ALTER TABLE `product_ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_ratings_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_size_product_id_foreign` (`product_id`),
  ADD KEY `product_size_size_id_foreign` (`size_id`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_variants_product_id_foreign` (`product_id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ratings_product_id_foreign` (`product_id`),
  ADD KEY `ratings_user_id_foreign` (`user_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `shipping_charges`
--
ALTER TABLE `shipping_charges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipping_charges_state_id_foreign` (`state_id`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_categories_category_id_foreign` (`category_id`);

--
-- Indexes for table `sub_sub_categories`
--
ALTER TABLE `sub_sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sub_sub_categories_slug_unique` (`sub_sub_category_slug`),
  ADD KEY `sub_sub_categories_category_id_foreign` (`category_id`),
  ADD KEY `sub_sub_categories_sub_category_id_foreign` (`sub_category_id`);

--
-- Indexes for table `temp_images`
--
ALTER TABLE `temp_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wishlists_user_id_foreign` (`user_id`),
  ADD KEY `wishlists_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `coupon_product`
--
ALTER TABLE `coupon_product`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customer_addresses`
--
ALTER TABLE `customer_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `discount_coupons`
--
ALTER TABLE `discount_coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `discount_percentages`
--
ALTER TABLE `discount_percentages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `order_status_histories`
--
ALTER TABLE `order_status_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `product_colors`
--
ALTER TABLE `product_colors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `product_ratings`
--
ALTER TABLE `product_ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_sizes`
--
ALTER TABLE `product_sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shipping_charges`
--
ALTER TABLE `shipping_charges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `sub_sub_categories`
--
ALTER TABLE `sub_sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `temp_images`
--
ALTER TABLE `temp_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=378;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `coupon_product`
--
ALTER TABLE `coupon_product`
  ADD CONSTRAINT `coupon_product_discount_coupons_id_foreign` FOREIGN KEY (`discount_coupons_id`) REFERENCES `discount_coupons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coupon_product_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customer_addresses`
--
ALTER TABLE `customer_addresses`
  ADD CONSTRAINT `customer_addresses_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `customer_addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `discounts`
--
ALTER TABLE `discounts`
  ADD CONSTRAINT `discounts_discount_percentages_id_foreign` FOREIGN KEY (`discount_percentages_id`) REFERENCES `discount_percentages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `discounts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_customer_address_id_foreign` FOREIGN KEY (`customer_address_id`) REFERENCES `customer_addresses` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `order_status_histories`
--
ALTER TABLE `order_status_histories`
  ADD CONSTRAINT `order_status_histories_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_discount_percentage_id_foreign` FOREIGN KEY (`discount_percentage_id`) REFERENCES `discount_percentages` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_sub_category_id_foreign` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_sub_sub_category_id_foreign` FOREIGN KEY (`sub_sub_category_id`) REFERENCES `sub_sub_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `product_colors`
--
ALTER TABLE `product_colors`
  ADD CONSTRAINT `product_color_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_color_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_ratings`
--
ALTER TABLE `product_ratings`
  ADD CONSTRAINT `product_ratings_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD CONSTRAINT `product_size_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_size_size_id_foreign` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shipping_charges`
--
ALTER TABLE `shipping_charges`
  ADD CONSTRAINT `shipping_charges_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD CONSTRAINT `sub_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_sub_categories`
--
ALTER TABLE `sub_sub_categories`
  ADD CONSTRAINT `sub_sub_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sub_sub_categories_sub_category_id_foreign` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
