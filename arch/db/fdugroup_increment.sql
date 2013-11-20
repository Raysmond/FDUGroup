-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2013 年 11 月 20 日 15:27
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
-- 表的结构 `group_censor`
--

CREATE TABLE IF NOT EXISTS `group_censor` (
  `csr_id` int(11) NOT NULL AUTO_INCREMENT,
  `csr_type_id` int(11) NOT NULL,
  `csr_first_id` int(11) NOT NULL,
  `csr_second_id` int(11) DEFAULT NULL,
  `csr_status` int(11) NOT NULL DEFAULT '1',
  `csr_content` text,
  `csr_send_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`csr_id`),
  KEY `csr_type_id` (`csr_type_id`,`csr_first_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- 表的结构 `group_censor_type`
--

CREATE TABLE IF NOT EXISTS `group_censor_type` (
  `csr_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `csr_type_name` varchar(45) NOT NULL,
  PRIMARY KEY (`csr_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
