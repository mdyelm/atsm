/*
Navicat MySQL Data Transfer

Source Server         : mystic
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : atsmd_system

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-10-27 15:50:21
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for licenses
-- ----------------------------
DROP TABLE IF EXISTS `licenses`;
CREATE TABLE `licenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `license_number` varchar(60) NOT NULL COMMENT 'ライセンス番号',
  `device_id` varchar(10) NOT NULL COMMENT 'ユニット端末ID',
  `type` tinyint(1) NOT NULL COMMENT '種別',
  `status` tinyint(1) NOT NULL COMMENT 'ライセンスステータス',
  `expiration_date` timestamp NULL DEFAULT NULL COMMENT '有効期限',
  `deleted_flag` tinyint(1) DEFAULT '0',
  `created_date` timestamp NULL DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `deleted_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `search` (`license_number`,`type`,`status`,`expiration_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for monitoring_logs
-- ----------------------------
DROP TABLE IF EXISTS `monitoring_logs`;
CREATE TABLE `monitoring_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `client_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `place` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `diff_pix` int(3) NOT NULL,
  `monitor_date` datetime NOT NULL,
  `monitor_flag` int(1) NOT NULL DEFAULT '0',
  `deleted_flag` int(11) NOT NULL DEFAULT '0',
  `created_date` timestamp NULL DEFAULT NULL,
  `deleted_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for organizations
-- ----------------------------
DROP TABLE IF EXISTS `organizations`;
CREATE TABLE `organizations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organization_id` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '組織ID',
  `organization_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL COMMENT '組織名',
  `position` varchar(60) COLLATE utf8_unicode_ci NOT NULL COMMENT ' 担当部署',
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '代表電話番号',
  `mail_address` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '代表メールアドレス',
  `deleted_flag` int(1) NOT NULL DEFAULT '0',
  `created_date` timestamp NULL DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `deleted_date` timestamp NULL DEFAULT NULL,
  `last_login_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `search` (`organization_id`,`organization_name`,`position`,`phone`,`mail_address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for units
-- ----------------------------
DROP TABLE IF EXISTS `units`;
CREATE TABLE `units` (
  `id` int(11) NOT NULL,
  `unit_id` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ユニット端末ID',
  `license_id` int(11) NOT NULL COMMENT 'ライセンスID',
  `organization_name` tinyint(4) NOT NULL COMMENT '管理組織',
  `status` tinyint(1) NOT NULL COMMENT ' 稼働状況ステータス',
  `ip_address` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT ' IPアドレス',
  `diff_pix` int(2) NOT NULL,
  `deleted_flag` int(1) NOT NULL DEFAULT '0',
  `created_date` timestamp NULL DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `deleted_date` timestamp NULL DEFAULT NULL,
  KEY `search` (`unit_id`,`license_id`,`organization_name`,`status`,`ip_address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT ' 担当者ID',
  `organization_id` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '組織ID',
  `login_pw` varchar(15) COLLATE utf8_unicode_ci NOT NULL COMMENT ' パスワード',
  `user_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '担当者名',
  `position` varchar(60) COLLATE utf8_unicode_ci NOT NULL COMMENT 'システム権限',
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT ' 緊急連絡先',
  `mail_address` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'メールアドレス',
  `authority` int(1) NOT NULL,
  `deleted_flag` int(1) NOT NULL DEFAULT '0',
  `created_date` timestamp NULL DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `deleted_date` timestamp NULL DEFAULT NULL,
  `last_login_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `search` (`user_id`,`user_name`,`position`,`phone`,`mail_address`,`authority`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
