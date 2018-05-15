-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2017 at 08:22 AM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.0.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `atsm`
--

-- --------------------------------------------------------

--
-- Table structure for table `licenses`
--

CREATE TABLE `licenses` (
  `id` int(11) NOT NULL,
  `license_number` varchar(60) NOT NULL COMMENT 'ライセンス番号',
  `unit_id` varchar(10) NOT NULL COMMENT 'ユニット端末ID',
  `type` tinyint(1) NOT NULL COMMENT '種別',
  `status` tinyint(1) NOT NULL COMMENT 'ライセンスステータス',
  `expiration_date` timestamp NULL DEFAULT NULL COMMENT '有効期限',
  `del_flag` tinyint(1) DEFAULT '0',
  `created` timestamp NULL DEFAULT NULL,
  `updated` timestamp NULL DEFAULT NULL,
  `del_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `licenses`
--

INSERT INTO `licenses` (`id`, `license_number`, `unit_id`, `type`, `status`, `expiration_date`, `del_flag`, `created`, `updated`, `del_date`) VALUES
(1, 'xxxx11111aaaaa', '123123', 1, 1, '2017-10-20 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(2, 'xxxx11112aaaaa', '123123', 0, 0, '2017-10-20 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(3, 'xxxx11113aaaaa', '123123', 1, 1, '2017-10-20 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(4, '1', '123123', 0, 0, '2017-10-20 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(5, '1', '123123', 1, 1, '2017-10-10 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(6, '1', '123123', 0, 0, '2017-10-20 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(7, '1', '123123', 1, 1, '2017-10-20 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(8, '1', '123123', 0, 0, '2017-10-02 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(9, '1', '123123', 1, 1, '2017-10-04 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(10, '1', '123123', 0, 0, '2017-10-20 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(11, '1', '123123', 1, 1, '2017-10-20 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(12, '1', '123123', 0, 0, '2017-10-20 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(13, '1', '123123', 0, 1, '2017-10-20 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(14, '1', '123123', 0, 0, '2017-10-20 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(15, '1', '123123', 1, 1, '2017-10-08 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(16, '1', '123123', 0, 0, '2017-10-20 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(17, '1', '123123', 1, 1, '2017-10-20 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(18, '1', '123123', 0, 0, '2017-10-20 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(19, '1', '123123', 1, 1, '2017-10-05 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(20, '1', '123123', 0, 0, '2017-10-20 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(21, '1', '123123', 1, 1, '2017-10-20 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(22, 'xxxx11126aaaaa', '123123', 0, 0, '2017-10-18 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(23, 'xxxx11125aaaaa', '123123', 0, 1, '2017-10-20 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(24, 'xxxx11124aaaaa', '123123', 1, 0, '2017-10-18 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(25, 'xxxx11111aaaaa', '123123', 1, 1, '2017-10-20 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(26, 'xxxx11112aaaaa', '123123', 0, 0, '2017-10-20 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(27, 'xxxx11113aaaaa', '123123', 1, 1, '2017-10-20 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(28, '1', '123123', 0, 0, '2017-10-20 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(29, '1', '123123', 1, 1, '2017-10-10 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(30, '1', '123123', 0, 0, '2017-10-20 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(31, '1', '123123', 1, 1, '2017-10-20 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(32, '1', '123123', 0, 0, '2017-10-02 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(33, '1', '123123', 1, 1, '2017-10-04 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(34, '1', '123123', 0, 0, '2017-10-20 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(35, '1', '123123', 1, 1, '2017-10-20 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(36, '1', '123123', 0, 0, '2017-10-20 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(37, '1', '123123', 0, 1, '2017-10-20 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(38, '1', '123123', 0, 0, '2017-10-20 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(39, '1', '123123', 1, 1, '2017-10-08 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(40, 'xxxx11126aaaaa', '123123', 0, 0, '2017-10-18 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(41, 'xxxx11125aaaaa', '123123', 0, 1, '2017-10-20 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(42, 'xxxx11124aaaaa', '123123', 1, 0, '2017-10-18 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(43, 'xxxx11111aaaaa', '123123', 1, 1, '2017-10-20 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(44, '1', '123123', 0, 0, '2017-10-20 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(45, '1', '123123', 1, 1, '2017-10-20 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(46, 'xxxx11126aaaaa', '123123', 0, 0, '2017-10-18 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(47, 'xxxx11125aaaaa', '123123', 0, 1, '2017-10-20 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(48, 'xxxx11124aaaaa', '123123', 1, 0, '2017-10-18 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(49, 'xxxx11111aaaaa', '123123', 1, 1, '2017-10-20 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(50, '1', '123123', 0, 0, '2017-10-20 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(51, '1', '123123', 1, 1, '2017-10-08 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(52, '1', '123123', 0, 0, '2017-10-20 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(53, '1', '123123', 1, 1, '2017-10-20 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL),
(54, '1', '123123', 0, 0, '2017-10-20 17:00:00', 0, '2017-10-13 17:00:00', '2017-10-19 17:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `monitoring_logs`
--

CREATE TABLE `monitoring_logs` (
  `id` int(11) NOT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `client_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `place` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `diff_pix` int(3) NOT NULL,
  `monitor_date` datetime NOT NULL,
  `monitor_flag` int(1) NOT NULL DEFAULT '0',
  `del_flag` int(11) NOT NULL DEFAULT '0',
  `created` timestamp NULL DEFAULT NULL,
  `del_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `id` int(11) NOT NULL,
  `organization_id` varchar(15) COLLATE utf8_unicode_ci NOT NULL COMMENT '組織ID',
  `organization_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL COMMENT '組織名',
  `position` varchar(60) COLLATE utf8_unicode_ci NOT NULL COMMENT ' 担当部署',
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '代表電話番号',
  `mail_address` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '代表メールアドレス',
  `del_flag` int(1) NOT NULL DEFAULT '0',
  `created` timestamp NULL DEFAULT NULL,
  `updated` timestamp NULL DEFAULT NULL,
  `del_date` timestamp NULL DEFAULT NULL,
  `last_login_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`id`, `organization_id`, `organization_name`, `position`, `phone`, `mail_address`, `del_flag`, `created`, `updated`, `del_date`, `last_login_date`) VALUES
(1, 'S-0000000000001', '1', '52', '14123123', '5@gmail.com', 0, '2017-10-30 03:43:44', '2017-10-30 04:00:12', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int(11) NOT NULL,
  `unit_id` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ユニット端末ID',
  `license_id` int(11) NOT NULL COMMENT 'ライセンスID',
  `organization_id` int(11) NOT NULL COMMENT '管理組織',
  `status` tinyint(1) NOT NULL COMMENT ' 稼働状況ステータス',
  `ip_address` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT ' IPアドレス',
  `diff_pix` int(2) NOT NULL,
  `authen_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `del_flag` int(1) NOT NULL DEFAULT '0',
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL,
  `del_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `unit_id`, `license_id`, `organization_id`, `status`, `ip_address`, `diff_pix`, `authen_code`, `del_flag`, `created`, `modified`, `del_date`) VALUES
(32, '9', 1, 1, 1, '192.168.1.107', 1, '2', 0, '2017-10-27 17:00:00', '2017-10-31 09:16:35', '2017-10-25 17:00:00'),
(33, '111', 1, 1, 1, '123123', 1, NULL, 0, '2017-10-27 17:00:00', '2017-10-26 17:00:00', '2017-10-25 17:00:00'),
(34, '111', 1, 1, 1, '123123', 1, NULL, 0, '2017-10-27 17:00:00', '2017-10-26 17:00:00', '2017-10-25 17:00:00'),
(35, '111', 1, 1, 1, '123123', 1, NULL, 0, '2017-10-27 17:00:00', '2017-10-26 17:00:00', '2017-10-25 17:00:00'),
(36, '111', 1, 1, 1, '123123', 1, NULL, 0, '2017-10-27 17:00:00', '2017-10-26 17:00:00', '2017-10-25 17:00:00'),
(37, '111', 1, 1, 1, '123123', 1, NULL, 0, '2017-10-27 17:00:00', '2017-10-26 17:00:00', '2017-10-25 17:00:00'),
(38, '111', 1, 1, 1, '123123', 1, NULL, 0, '2017-10-27 17:00:00', '2017-10-26 17:00:00', '2017-10-25 17:00:00'),
(39, '111', 1, 1, 1, '123123', 1, NULL, 0, '2017-10-27 17:00:00', '2017-10-26 17:00:00', '2017-10-25 17:00:00'),
(40, '111', 1, 1, 1, '123123', 1, NULL, 0, '2017-10-27 17:00:00', '2017-10-26 17:00:00', '2017-10-25 17:00:00'),
(41, '111', 1, 1, 1, '123123', 1, NULL, 0, '2017-10-27 17:00:00', '2017-10-26 17:00:00', '2017-10-25 17:00:00'),
(53, '111', 1, 1, 1, '123123', 1, NULL, 0, '2017-10-27 17:00:00', '2017-10-26 17:00:00', '2017-10-25 17:00:00'),
(54, '111', 1, 1, 1, '123123', 1, NULL, 0, '2017-10-27 17:00:00', '2017-10-26 17:00:00', '2017-10-25 17:00:00'),
(55, '111', 1, 1, 1, '123123', 1, NULL, 0, '2017-10-27 17:00:00', '2017-10-26 17:00:00', '2017-10-25 17:00:00'),
(56, '111', 1, 1, 1, '123123', 1, NULL, 0, '2017-10-27 17:00:00', '2017-10-26 17:00:00', '2017-10-25 17:00:00'),
(57, '111', 1, 1, 1, '123123', 1, NULL, 0, '2017-10-27 17:00:00', '2017-10-26 17:00:00', '2017-10-25 17:00:00'),
(58, '111', 1, 1, 1, '123123', 1, NULL, 0, '2017-10-27 17:00:00', '2017-10-26 17:00:00', '2017-10-25 17:00:00'),
(59, '111', 1, 1, 1, '123123', 1, NULL, 0, '2017-10-27 17:00:00', '2017-10-26 17:00:00', '2017-10-25 17:00:00'),
(60, '111', 1, 1, 1, '123123', 1, NULL, 0, '2017-10-27 17:00:00', '2017-10-26 17:00:00', '2017-10-25 17:00:00'),
(61, '111', 1, 1, 1, '123123', 1, NULL, 0, '2017-10-27 17:00:00', '2017-10-26 17:00:00', '2017-10-25 17:00:00'),
(62, '111', 1, 1, 1, '123123', 1, NULL, 0, '2017-10-27 17:00:00', '2017-10-26 17:00:00', '2017-10-25 17:00:00'),
(63, '111', 1, 1, 1, '123123', 1, NULL, 0, '2017-10-27 17:00:00', '2017-10-26 17:00:00', '2017-10-25 17:00:00'),
(64, '111', 1, 1, 1, '123123', 1, NULL, 0, '2017-10-27 17:00:00', '2017-10-26 17:00:00', '2017-10-25 17:00:00'),
(65, '111', 1, 1, 1, '123123', 1, NULL, 0, '2017-10-27 17:00:00', '2017-10-26 17:00:00', '2017-10-25 17:00:00'),
(66, '', 0, 0, 0, '', 0, NULL, 0, '2017-10-31 04:43:54', '2017-10-31 04:45:09', NULL),
(67, '', 0, 0, 0, '', 0, NULL, 0, '2017-10-31 04:46:06', '2017-10-31 04:46:06', NULL),
(68, '', 0, 0, 0, '', 0, NULL, 0, '2017-10-31 05:23:22', '2017-10-31 05:23:51', NULL),
(69, '', 0, 0, 0, '', 0, NULL, 0, '2017-10-31 05:23:59', '2017-10-31 05:29:07', NULL),
(70, '', 0, 0, 0, '', 0, NULL, 0, '2017-10-31 05:29:51', '2017-10-31 05:33:34', NULL),
(71, '', 0, 0, 0, '', 0, NULL, 0, '2017-10-31 05:33:46', '2017-10-31 05:33:46', NULL),
(72, '', 0, 0, 0, '', 0, NULL, 0, '2017-10-31 05:34:31', '2017-10-31 05:34:31', NULL),
(73, '', 0, 0, 0, '', 0, NULL, 0, '2017-10-31 05:35:32', '2017-10-31 05:35:32', NULL),
(74, '', 0, 0, 0, '', 0, NULL, 0, '2017-10-31 05:37:51', '2017-10-31 05:37:51', NULL),
(75, '', 0, 0, 0, '', 0, NULL, 0, '2017-10-31 07:35:25', '2017-10-31 07:35:25', NULL),
(76, '', 0, 0, 0, '', 0, NULL, 0, '2017-10-31 07:36:20', '2017-10-31 07:36:20', NULL),
(77, '', 0, 0, 0, '', 0, NULL, 0, '2017-10-31 07:37:21', '2017-10-31 07:37:21', NULL),
(78, '', 0, 0, 0, '', 0, NULL, 0, '2017-10-31 07:37:53', '2017-10-31 07:38:08', NULL),
(79, '', 0, 0, 1, '', 0, NULL, 0, '2017-10-31 08:56:43', '2017-10-31 08:56:43', NULL),
(80, '', 0, 0, 1, '', 0, NULL, 0, '2017-10-31 08:57:13', '2017-10-31 08:58:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_id` varchar(15) COLLATE utf8_unicode_ci NOT NULL COMMENT ' 担当者ID',
  `organization_id` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '組織ID',
  `login_pw` varchar(15) COLLATE utf8_unicode_ci NOT NULL COMMENT ' パスワード',
  `user_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '担当者名',
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT ' 緊急連絡先',
  `mail_address` varchar(51) COLLATE utf8_unicode_ci NOT NULL COMMENT 'メールアドレス',
  `role` int(1) NOT NULL,
  `del_flag` int(1) NOT NULL DEFAULT '0',
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL,
  `del_date` timestamp NULL DEFAULT NULL,
  `last_login_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `organization_id`, `login_pw`, `user_name`, `phone`, `mail_address`, `role`, `del_flag`, `created`, `modified`, `del_date`, `last_login_date`) VALUES
(1, '123456789a12345', '1', '123456', 'Chicharito', '0123456789', 'vietvv7292@gmail.com', 1, 0, '2017-10-28 17:00:00', '2017-10-31 06:07:21', '2017-10-17 17:00:00', '2017-10-24 17:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `licenses`
--
ALTER TABLE `licenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `search` (`license_number`,`type`,`status`,`expiration_date`);

--
-- Indexes for table `monitoring_logs`
--
ALTER TABLE `monitoring_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `search` (`organization_id`,`organization_name`,`position`,`phone`,`mail_address`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `search` (`unit_id`,`license_id`,`organization_id`,`status`,`ip_address`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `search` (`user_id`,`user_name`,`phone`,`mail_address`,`role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `licenses`
--
ALTER TABLE `licenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
--
-- AUTO_INCREMENT for table `monitoring_logs`
--
ALTER TABLE `monitoring_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
