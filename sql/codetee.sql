/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : codetee

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-07-21 19:23:33
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admin_users
-- ----------------------------
DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员用户表ID',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='后台用户表_@wda';

-- ----------------------------
-- Records of admin_users
-- ----------------------------
INSERT INTO `admin_users` VALUES ('1', 'code', 'tcode.163.com', '$2y$10$1m7HSE2CHZxposY06sOOF.LKYiVCmUPETvPB6vjK7hlB7ZmkwH9t6', 'Saip19lA2i24uHc079du3JSIY2kBkAhLGkDPHKHSi9IYyRSkOs3U2PN12bgo', '2017-07-07 12:05:23', '2017-07-07 12:05:25');

-- ----------------------------
-- Table structure for admin_users_34234
-- ----------------------------
DROP TABLE IF EXISTS `admin_users_34234`;
CREATE TABLE `admin_users_34234` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_users_34234
-- ----------------------------
INSERT INTO `admin_users_34234` VALUES ('1', 'root', '$2y$10$1m7HSE2CHZxposY06sOOF.LKYiVCmUPETvPB6vjK7hlB7ZmkwH9t6', '2017-07-21 15:24:28', '2017-07-21 15:24:28');

-- ----------------------------
-- Table structure for goods
-- ----------------------------
DROP TABLE IF EXISTS `goods`;
CREATE TABLE `goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品id',
  `cat_id` int(11) DEFAULT '0' COMMENT '商品分类',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `sn` varchar(200) NOT NULL DEFAULT '0' COMMENT '商品码',
  `name` varchar(255) NOT NULL,
  `images` varchar(255) DEFAULT NULL COMMENT '商品图片 json',
  `number` tinyint(3) NOT NULL DEFAULT '0' COMMENT '商品数量',
  `weight` tinyint(2) NOT NULL DEFAULT '1' COMMENT '商品权重',
  `market_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场价格',
  `shop_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品价格',
  `promote_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '促销价格',
  `description` text COMMENT '商品描述',
  `rember` varchar(255) DEFAULT NULL COMMENT '商品扼要',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '商品状态  0 下架 1 出售中',
  `info_all` varchar(255) NOT NULL COMMENT '商品信息 [款式 颜色 尺码 克数]',
  `shelf_time` timestamp NULL DEFAULT '0000-00-00 00:00:00' COMMENT '上架时间',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品表_@wda';

-- ----------------------------
-- Records of goods
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('1', '2014_10_12_100000_create_password_resets_table', '1');
INSERT INTO `migrations` VALUES ('3', '2017_07_20_172326_create_admin_users_table', '2');

-- ----------------------------
-- Table structure for operation_log
-- ----------------------------
DROP TABLE IF EXISTS `operation_log`;
CREATE TABLE `operation_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `admin_id` int(11) DEFAULT NULL,
  `type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '操作类型 1、add  2、del 3、del ',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态 1、订单 2、用户 3、二维码',
  `content` varchar(255) DEFAULT NULL COMMENT '内容',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='操作日志_@wda';

-- ----------------------------
-- Records of operation_log
-- ----------------------------

-- ----------------------------
-- Table structure for order
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` int(11) NOT NULL COMMENT '订单号',
  `goods_id` int(11) NOT NULL COMMENT '商品id',
  `user_id` int(11) NOT NULL,
  `order_info` varchar(255) NOT NULL COMMENT '订单信息',
  `amount` int(11) DEFAULT NULL COMMENT '订单数量',
  `model` tinyint(1) NOT NULL DEFAULT '1' COMMENT '订单模块 1图文 2视文',
  `model_content` varchar(255) NOT NULL COMMENT '模块内容',
  `distribution` varchar(255) NOT NULL COMMENT '配送地址',
  `order_sutatus` varchar(50) NOT NULL DEFAULT '100' COMMENT '订单状态 100待支付 101取消订单 200支付成功 201 退款',
  `freight` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '生成运费',
  `total` decimal(10,2) NOT NULL COMMENT '支付金额',
  `order_func` tinyint(1) NOT NULL DEFAULT '0' COMMENT '支付方式  1微信 2 支付宝 3 其他',
  `order_status` tinyint(1) NOT NULL COMMENT '支付状态 0 未支付 1支付失败 2 支付成功',
  `waybill` varchar(50) DEFAULT NULL COMMENT '运单号',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '生成时间',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单_@wda';

-- ----------------------------
-- Records of order
-- ----------------------------

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`(250))
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for payment_log
-- ----------------------------
DROP TABLE IF EXISTS `payment_log`;
CREATE TABLE `payment_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `order_id` int(11) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '类别 1、下单 2、修改',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '支付金额',
  `pay_func` tinyint(1) NOT NULL DEFAULT '0' COMMENT '支付方式  1微信 2 支付宝 3 其他',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='支付日志_@wda';

-- ----------------------------
-- Records of payment_log
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'uuid',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` char(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '手机号码',
  `avatar` varchar(400) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '头像',
  `sex` int(1) NOT NULL DEFAULT '0' COMMENT '0 未知 1 男 2女',
  `address` varchar(400) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '地址',
  `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `channel_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '注册类型 0 个人账号 1后台账号 ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户列表_@wda';

-- ----------------------------
-- Records of users
-- ----------------------------
