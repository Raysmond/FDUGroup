-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2013 年 11 月 23 日 15:42
-- 服务器版本: 5.5.32
-- PHP 版本: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `fdugroup`
--
CREATE DATABASE IF NOT EXISTS `fdugroup` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `fdugroup`;

-- --------------------------------------------------------

--
-- 表的结构 `group_ads`
--

CREATE TABLE IF NOT EXISTS `group_ads` (
  `ads_id` int(11) NOT NULL AUTO_INCREMENT,
  `ads_user_id` int(11) NOT NULL COMMENT 'vip user id',
  `ads_pub_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'post time',
  `ads_title` varchar(128) NOT NULL COMMENT 'label of content',
  `ads_content` text NOT NULL COMMENT 'content',
  `ads_status` int(11) NOT NULL DEFAULT '1' COMMENT '1: normal 2:blocked',
  `ads_paid_price` int(11) NOT NULL DEFAULT '0' COMMENT 'virtual money paid for ads',
  PRIMARY KEY (`ads_id`),
  KEY `ads_user_id` (`ads_user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `group_ads`
--

INSERT INTO `group_ads` (`ads_id`, `ads_user_id`, `ads_pub_time`, `ads_title`, `ads_content`, `ads_status`, `ads_paid_price`) VALUES
(1, 5, '2013-11-23 10:15:40', '测试', '测试\r\n广告推广，真情放送', 1, 0),
(2, 5, '2013-11-23 14:38:27', '新', '嘻嘻嘻', 1, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
