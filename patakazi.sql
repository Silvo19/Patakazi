-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2026 at 11:46 AM
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
-- Database: `patakazi`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` int(10) UNSIGNED NOT NULL,
  `actor_id` int(10) UNSIGNED DEFAULT NULL,
  `action` varchar(50) NOT NULL,
  `entity_type` varchar(30) DEFAULT NULL,
  `entity_id` int(10) UNSIGNED DEFAULT NULL,
  `details` varchar(255) DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `actor_id`, `action`, `entity_type`, `entity_id`, `details`, `ip`, `created_at`) VALUES
(1, 1, 'user_registered', 'user', 1, 'worker: margret magucha', '::1', '2026-10-12 18:25:50'),
(2, 2, 'login', 'user', 2, '', '::1', '2026-10-12 18:28:23'),
(3, NULL, 'login_failed', 'user', NULL, 'email: finance.payroll@hospital.com', '::1', '2026-10-12 18:29:55'),
(4, 2, 'login', 'user', 2, '', '::1', '2026-10-12 18:30:26'),
(5, 1, 'login', 'user', 1, '', '::1', '2026-10-12 18:31:14'),
(6, 3, 'referral_created', 'user', 3, 'joined with a referral code from user #1', '::1', '2026-10-12 18:33:45'),
(7, 3, 'user_registered', 'user', 3, 'worker: jux shea love', '::1', '2026-10-12 18:33:45'),
(8, 3, 'login', 'user', 3, '', '::1', '2026-10-12 18:33:59'),
(9, NULL, 'login_failed', 'user', NULL, 'email: finance.billing@hospital.com', '::1', '2026-10-12 18:34:17'),
(10, 3, 'login', 'user', 3, '', '::1', '2026-10-12 18:34:23'),
(11, 1, 'login', 'user', 1, '', '::1', '2026-10-12 18:34:37'),
(12, NULL, 'subscription_activated', 'user', 5, 'Pro +30 days', '::1', '2026-10-12 18:36:12'),
(13, NULL, 'subscription_activated', 'user', 6, 'Business +30 days', '::1', '2026-10-12 18:36:12'),
(14, NULL, 'user_registered', 'user', 8, 'worker: Wanjiru Kamau', '::1', '2026-10-12 18:36:12'),
(15, NULL, 'listing_created', 'user', 6, 'job: Social Media Manager', '::1', '2026-10-12 18:36:12'),
(16, NULL, 'application_submitted', 'user', 8, 'Social Media Manager', '::1', '2026-10-12 18:36:12'),
(17, NULL, 'application_shortlisted', 'user', 6, 'status set to shortlisted', '::1', '2026-10-12 18:36:12'),
(18, NULL, 'login', 'user', 5, '', '::1', '2026-10-12 18:36:12'),
(19, NULL, 'login_failed', 'user', NULL, 'email: silvestarmagucha23@gmail.com', '::1', '2026-10-12 18:37:03'),
(20, 2, 'login', 'user', 2, '', '::1', '2026-10-12 18:37:13'),
(21, 2, 'admin_posted', 'listing', 12, 'task: media', '::1', '2026-10-12 18:38:22'),
(22, 3, 'login', 'user', 3, '', '::1', '2026-10-12 18:38:44'),
(23, NULL, 'login_failed', 'user', NULL, 'email: finance.billing@hospital.com', '::1', '2026-10-12 18:40:25'),
(24, 1, 'login', 'user', 1, '', '::1', '2026-10-12 18:40:34'),
(25, NULL, 'subscription_activated', 'user', 12, 'Pro +30 days', '::1', '2026-10-12 18:43:18'),
(26, NULL, 'subscription_activated', 'user', 13, 'Business +30 days', '::1', '2026-10-12 18:43:18'),
(27, NULL, 'user_registered', 'user', 15, 'worker: Wanjiru Kamau', '::1', '2026-10-12 18:43:18'),
(28, NULL, 'listing_created', 'user', 13, 'job: Social Media Manager', '::1', '2026-10-12 18:43:18'),
(29, NULL, 'application_submitted', 'user', 15, 'Social Media Manager', '::1', '2026-10-12 18:43:18'),
(30, NULL, 'application_shortlisted', 'user', 13, 'status set to shortlisted', '::1', '2026-10-12 18:43:18'),
(31, NULL, 'login', 'user', 12, '', '::1', '2026-10-12 18:43:18'),
(32, NULL, 'login', 'user', 11, '', '::1', '2026-10-12 18:43:49'),
(33, NULL, 'login', 'user', 12, '', '::1', '2026-10-12 18:44:44'),
(34, 2, 'login', 'user', 2, '', '::1', '2026-10-12 18:48:50'),
(35, 2, 'login', 'user', 2, '', '::1', '2026-10-14 08:58:12'),
(36, NULL, 'subscription_activated', 'user', 19, 'Pro +30 days', '::1', '2026-10-14 09:00:16'),
(37, NULL, 'subscription_activated', 'user', 20, 'Business +30 days', '::1', '2026-10-14 09:00:16'),
(38, NULL, 'user_registered', 'user', 22, 'worker: Wanjiru Kamau', '::1', '2026-10-14 09:00:16'),
(39, NULL, 'listing_created', 'user', 20, 'job: Social Media Manager', '::1', '2026-10-14 09:00:16'),
(40, NULL, 'application_submitted', 'user', 22, 'Social Media Manager', '::1', '2026-10-14 09:00:16'),
(41, NULL, 'application_shortlisted', 'user', 20, 'status set to shortlisted', '::1', '2026-10-14 09:00:16'),
(42, NULL, 'login', 'user', 19, '', '::1', '2026-10-14 09:00:16'),
(43, 2, 'listing_approve', 'listing', 29, 'by admin', '::1', '2026-10-14 09:00:39'),
(44, 2, 'withdrawal_rejected', 'withdrawal', 3, 'Rejected by admin', '::1', '2026-10-14 09:01:36'),
(45, NULL, 'login', 'user', 20, '', '::1', '2026-10-14 09:04:02'),
(46, NULL, 'payment_completed', 'transaction', 22, 'featured listing KSh 200 (wallet)', '::1', '2026-10-14 09:04:25'),
(47, NULL, 'login_failed', 'user', NULL, 'email: silvestarmagucha23@gmail.com', '::1', '2026-11-04 13:50:13'),
(48, 2, 'login', 'user', 2, '', '::1', '2026-11-04 13:51:01'),
(49, 2, 'user_suspended', 'user', 3, 'by admin', '::1', '2026-11-04 13:53:28'),
(50, 2, 'user_suspended', 'user', 1, 'by admin', '::1', '2026-11-04 13:53:31'),
(51, 2, 'referral_voided', 'user', 1, 'by admin', '::1', '2026-11-04 13:53:47'),
(52, 25, 'user_registered', 'user', 25, 'worker: margret magucha', '::1', '2026-11-04 13:58:09'),
(53, NULL, 'login_failed', 'user', NULL, 'email: silvestarmagucha23@gmail.com', '::1', '2026-11-09 10:09:30'),
(54, 2, 'login', 'user', 2, '', '::1', '2026-11-09 10:09:36');

-- --------------------------------------------------------

--
-- Table structure for table `admin_payouts`
--

CREATE TABLE `admin_payouts` (
  `id` int(10) UNSIGNED NOT NULL,
  `admin_id` int(10) UNSIGNED NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `status` enum('otp_pending','pending','processing','completed','failed','cancelled') NOT NULL DEFAULT 'otp_pending',
  `otp_hash` char(64) DEFAULT NULL,
  `otp_expires` datetime DEFAULT NULL,
  `otp_attempts` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `originator_conversation_id` varchar(80) DEFAULT NULL,
  `conversation_id` varchar(80) DEFAULT NULL,
  `mpesa_receipt` varchar(30) DEFAULT NULL,
  `result_desc` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `completed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(10) UNSIGNED NOT NULL,
  `listing_id` int(10) UNSIGNED NOT NULL,
  `worker_id` int(10) UNSIGNED NOT NULL,
  `message` text DEFAULT NULL,
  `status` enum('submitted','reviewed','shortlisted','selected','rejected') NOT NULL DEFAULT 'submitted',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(9, 'Admin & Office'),
(7, 'Agriculture'),
(1, 'Casual & Manual Work'),
(8, 'Creative & Design'),
(5, 'Education & Tutoring'),
(10, 'Health & Care'),
(2, 'Hospitality'),
(3, 'Sales & Marketing'),
(4, 'Technology'),
(6, 'Transport & Delivery');

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` int(10) UNSIGNED NOT NULL,
  `listing_id` int(10) UNSIGNED DEFAULT NULL,
  `owner_id` int(10) UNSIGNED NOT NULL,
  `other_id` int(10) UNSIGNED NOT NULL,
  `last_message_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employer_profiles`
--

CREATE TABLE `employer_profiles` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `business_name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `website` varchar(190) DEFAULT NULL,
  `county` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `listings`
--

CREATE TABLE `listings` (
  `id` int(10) UNSIGNED NOT NULL,
  `owner_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `type` enum('job','task','service') NOT NULL,
  `title` varchar(160) NOT NULL,
  `description` text NOT NULL,
  `county` varchar(60) DEFAULT NULL,
  `pay_amount` decimal(10,2) DEFAULT NULL,
  `pay_note` varchar(100) DEFAULT NULL,
  `posting_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `deadline` date DEFAULT NULL,
  `status` enum('awaiting_payment','pending','approved','rejected','closed') NOT NULL DEFAULT 'pending',
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `featured_until` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `listings`
--

INSERT INTO `listings` (`id`, `owner_id`, `category_id`, `type`, `title`, `description`, `county`, `pay_amount`, `pay_note`, `posting_fee`, `deadline`, `status`, `is_featured`, `featured_until`, `created_at`) VALUES
(12, 2, 4, 'task', 'media', 'give 1 rules of media', 'Kisii', 1564.00, 'task', 0.00, '2026-10-29', 'approved', 1, '2026-10-19', '2026-10-12 18:38:22');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `conversation_id` int(10) UNSIGNED NOT NULL,
  `sender_id` int(10) UNSIGNED NOT NULL,
  `body` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `read_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(120) NOT NULL,
  `body` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `body`, `link`, `is_read`, `created_at`) VALUES
(1, 1, 'Someone joined with your code 🎉', 'You\'ll earn your reward once they finish their profile and apply to an opportunity.', 'referrals.php', 1, '2026-10-12 18:33:45');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `token_hash` char(64) NOT NULL,
  `expires_at` datetime NOT NULL,
  `used_at` datetime DEFAULT NULL,
  `request_ip` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `referrals`
--

CREATE TABLE `referrals` (
  `id` int(10) UNSIGNED NOT NULL,
  `referrer_id` int(10) UNSIGNED NOT NULL,
  `referred_id` int(10) UNSIGNED NOT NULL,
  `role` enum('worker','employer') NOT NULL,
  `status` enum('pending','rewarded','void') NOT NULL DEFAULT 'pending',
  `reward_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `bonus_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `note` varchar(120) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `rewarded_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `referrals`
--

INSERT INTO `referrals` (`id`, `referrer_id`, `referred_id`, `role`, `status`, `reward_amount`, `bonus_amount`, `note`, `created_at`, `rewarded_at`) VALUES
(1, 1, 3, 'worker', 'void', 0.00, 0.00, 'Voided by admin', '2026-10-12 18:33:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(10) UNSIGNED NOT NULL,
  `reporter_id` int(10) UNSIGNED NOT NULL,
  `listing_id` int(10) UNSIGNED DEFAULT NULL,
  `reason` varchar(255) NOT NULL,
  `status` enum('open','investigating','resolved') NOT NULL DEFAULT 'open',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `saved_listings`
--

CREATE TABLE `saved_listings` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `listing_id` int(10) UNSIGNED NOT NULL,
  `saved_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `skey` varchar(60) NOT NULL,
  `svalue` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `plan` enum('business','pro') NOT NULL,
  `status` enum('active','cancelled') NOT NULL DEFAULT 'active',
  `starts_at` datetime NOT NULL,
  `expires_at` datetime NOT NULL,
  `last_transaction_id` int(10) UNSIGNED DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `listing_id` int(10) UNSIGNED DEFAULT NULL,
  `purpose` enum('featured_listing','subscription','promoted_service','service_fee','wallet_deposit') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `plan_days` smallint(5) UNSIGNED DEFAULT NULL,
  `meta` varchar(30) DEFAULT NULL,
  `checkout_request_id` varchar(64) DEFAULT NULL,
  `merchant_request_id` varchar(64) DEFAULT NULL,
  `mpesa_receipt` varchar(30) DEFAULT NULL,
  `status` enum('pending','completed','failed','refunded') NOT NULL DEFAULT 'pending',
  `result_desc` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(120) NOT NULL,
  `email` varchar(190) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_changed_at` datetime DEFAULT NULL,
  `referral_code` varchar(12) DEFAULT NULL,
  `referred_by` int(10) UNSIGNED DEFAULT NULL,
  `role` enum('worker','employer','admin') NOT NULL DEFAULT 'worker',
  `status` enum('active','suspended') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `phone`, `password_hash`, `password_changed_at`, `referral_code`, `referred_by`, `role`, `status`, `created_at`) VALUES
(1, 'margret magucha', 'finance.cashier@hospital.com', '254708660304', '$2y$10$.elEnCfc2E9.xnXg9tBHQuqI7jJmjRG8Zq9vjXy8HGbkfn9l4Fddu', NULL, '89VK9BK', NULL, 'worker', 'suspended', '2026-10-12 18:25:50'),
(2, 'Silvester Magucha', 'silvestermagucha23@gmail.com', NULL, '$2y$10$4iMNDg5ymVozuv3XDOEMCOItpilAwSMCGlFRAfL7i5w4oTBOVftLi', NULL, NULL, NULL, 'admin', 'active', '2026-10-12 18:28:15'),
(3, 'jux shea love', 'finance.payroll@hospital.com', '254710737421', '$2y$10$JcbWE1t.llGC2K.mnJcSfOHlIgSeIZA9Jun5aJaNk/nfKkl0gaFWG', NULL, '54XW29U', 1, 'worker', 'suspended', '2026-10-12 18:33:45'),
(25, 'margret magucha', 'secretary@hospital.com', '254704739916', '$2y$10$ldzdEAYzwtIZhrdBfN0vGu/rs5ZN.bv2s1SXwizpJWMNHC3jw6/nG', NULL, 'W53RXA8', NULL, 'worker', 'active', '2026-11-04 13:58:09');

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE `wallets` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `balance` decimal(12,2) NOT NULL DEFAULT 0.00,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wallet_ledger`
--

CREATE TABLE `wallet_ledger` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `type` enum('deposit','withdrawal','withdrawal_refund','feature_payment','subscription_payment','referral_bonus','posting_fee_payment','posting_fee_refund','adjustment') NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `balance_after` decimal(12,2) NOT NULL,
  `ref_type` varchar(30) DEFAULT NULL,
  `ref_id` int(10) UNSIGNED DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `fee` decimal(12,2) NOT NULL DEFAULT 0.00,
  `phone` varchar(15) NOT NULL,
  `status` enum('pending','processing','completed','rejected','failed') NOT NULL DEFAULT 'pending',
  `originator_conversation_id` varchar(80) DEFAULT NULL,
  `conversation_id` varchar(80) DEFAULT NULL,
  `mpesa_receipt` varchar(30) DEFAULT NULL,
  `result_desc` varchar(255) DEFAULT NULL,
  `admin_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `completed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `worker_profiles`
--

CREATE TABLE `worker_profiles` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `headline` varchar(150) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `skills` varchar(500) DEFAULT NULL,
  `experience` text DEFAULT NULL,
  `county` varchar(60) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `worker_profiles`
--

INSERT INTO `worker_profiles` (`user_id`, `headline`, `bio`, `skills`, `experience`, `county`, `updated_at`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, '2026-10-12 18:25:50'),
(3, 'Social media manager', '', 'design', '', 'Kisii', '2026-10-12 18:39:05'),
(25, NULL, NULL, NULL, NULL, NULL, '2026-11-04 13:58:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_created` (`created_at`),
  ADD KEY `idx_action` (`action`),
  ADD KEY `idx_actor` (`actor_id`);

--
-- Indexes for table `admin_payouts`
--
ALTER TABLE `admin_payouts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_apply` (`listing_id`,`worker_id`),
  ADD KEY `worker_id` (`worker_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_conv` (`listing_id`,`owner_id`,`other_id`),
  ADD KEY `idx_owner` (`owner_id`),
  ADD KEY `idx_other` (`other_id`);

--
-- Indexes for table `employer_profiles`
--
ALTER TABLE `employer_profiles`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `listings`
--
ALTER TABLE `listings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_id` (`owner_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `idx_type_status` (`type`,`status`);
ALTER TABLE `listings` ADD FULLTEXT KEY `ft_search` (`title`,`description`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_conv` (`conversation_id`,`id`),
  ADD KEY `sender_id` (`sender_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_read` (`user_id`,`is_read`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_token` (`token_hash`),
  ADD KEY `idx_user` (`user_id`);

--
-- Indexes for table `referrals`
--
ALTER TABLE `referrals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_referred` (`referred_id`),
  ADD KEY `idx_referrer` (`referrer_id`,`status`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reporter_id` (`reporter_id`),
  ADD KEY `listing_id` (`listing_id`);

--
-- Indexes for table `saved_listings`
--
ALTER TABLE `saved_listings`
  ADD PRIMARY KEY (`user_id`,`listing_id`),
  ADD KEY `listing_id` (`listing_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`skey`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `idx_expiry` (`expires_at`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_checkout` (`checkout_request_id`),
  ADD KEY `idx_user_created` (`user_id`,`created_at`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `uq_refcode` (`referral_code`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `wallet_ledger`
--
ALTER TABLE `wallet_ledger`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user` (`user_id`,`id`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_user` (`user_id`);

--
-- Indexes for table `worker_profiles`
--
ALTER TABLE `worker_profiles`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `admin_payouts`
--
ALTER TABLE `admin_payouts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `listings`
--
ALTER TABLE `listings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `referrals`
--
ALTER TABLE `referrals`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `wallet_ledger`
--
ALTER TABLE `wallet_ledger`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD CONSTRAINT `activity_log_ibfk_1` FOREIGN KEY (`actor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `admin_payouts`
--
ALTER TABLE `admin_payouts`
  ADD CONSTRAINT `admin_payouts_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`listing_id`) REFERENCES `listings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`worker_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `conversations`
--
ALTER TABLE `conversations`
  ADD CONSTRAINT `conversations_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `conversations_ibfk_2` FOREIGN KEY (`other_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `conversations_ibfk_3` FOREIGN KEY (`listing_id`) REFERENCES `listings` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `employer_profiles`
--
ALTER TABLE `employer_profiles`
  ADD CONSTRAINT `employer_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `listings`
--
ALTER TABLE `listings`
  ADD CONSTRAINT `listings_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `listings_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `referrals`
--
ALTER TABLE `referrals`
  ADD CONSTRAINT `referrals_ibfk_1` FOREIGN KEY (`referrer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `referrals_ibfk_2` FOREIGN KEY (`referred_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`reporter_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`listing_id`) REFERENCES `listings` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `saved_listings`
--
ALTER TABLE `saved_listings`
  ADD CONSTRAINT `saved_listings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `saved_listings_ibfk_2` FOREIGN KEY (`listing_id`) REFERENCES `listings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wallets`
--
ALTER TABLE `wallets`
  ADD CONSTRAINT `wallets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wallet_ledger`
--
ALTER TABLE `wallet_ledger`
  ADD CONSTRAINT `wallet_ledger_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD CONSTRAINT `withdrawals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `worker_profiles`
--
ALTER TABLE `worker_profiles`
  ADD CONSTRAINT `worker_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
