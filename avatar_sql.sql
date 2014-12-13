/*
Navicat MySQL Data Transfer

Source Server         : LOCALHOST
Source Server Version : 50538
Source Host           : localhost:3306
Source Database       : avatar

Target Server Type    : MYSQL
Target Server Version : 50538
File Encoding         : 65001

Date: 2014-12-12 16:25:48
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for avatar_images
-- ----------------------------
DROP TABLE IF EXISTS `avatar_images`;
CREATE TABLE `avatar_images` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) DEFAULT NULL,
  `layer` int(4) DEFAULT '1',
  `startX` int(5) DEFAULT '0',
  `startY` int(5) DEFAULT '0',
  `endX` int(5) DEFAULT '0',
  `endY` int(5) DEFAULT '0',
  `opacity` int(3) DEFAULT '100',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for avatar_item_groups
-- ----------------------------
DROP TABLE IF EXISTS `avatar_item_groups`;
CREATE TABLE `avatar_item_groups` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for avatar_items
-- ----------------------------
DROP TABLE IF EXISTS `avatar_items`;
CREATE TABLE `avatar_items` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `group_id` bigint(255) DEFAULT '0',
  `is_removable` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for avatar_items_to_images
-- ----------------------------
DROP TABLE IF EXISTS `avatar_items_to_images`;
CREATE TABLE `avatar_items_to_images` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `item_id` bigint(255) DEFAULT '0',
  `image_id` bigint(255) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for avatar_items_to_users
-- ----------------------------
DROP TABLE IF EXISTS `avatar_items_to_users`;
CREATE TABLE `avatar_items_to_users` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `item_id` bigint(255) DEFAULT '1',
  `user_id` bigint(255) DEFAULT '0',
  `isactive` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for avatar_users
-- ----------------------------
DROP TABLE IF EXISTS `avatar_users`;
CREATE TABLE `avatar_users` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
