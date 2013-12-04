-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 12 月 04 日 09:55
-- 服务器版本: 5.5.31
-- PHP 版本: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `fdugroup`
--

-- --------------------------------------------------------

--
-- 表的结构 `group_users`
--

CREATE TABLE IF NOT EXISTS `group_users` (
  `u_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_role_id` int(11) NOT NULL,
  `u_name` varchar(45) NOT NULL,
  `u_mail` varchar(45) NOT NULL,
  `u_password` varchar(255) NOT NULL,
  `u_region` varchar(45) DEFAULT NULL COMMENT '地区',
  `u_mobile` varchar(45) DEFAULT NULL COMMENT '手机号',
  `u_qq` varchar(45) DEFAULT NULL,
  `u_weibo` varchar(45) DEFAULT NULL,
  `u_register_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `u_status` int(11) NOT NULL DEFAULT '0' COMMENT '0: 无效用户\n1: 激活用户',
  `u_picture` varchar(45) DEFAULT NULL COMMENT '头像 url',
  `u_intro` text,
  `u_homepage` varchar(45) DEFAULT NULL,
  `u_credits` int(11) DEFAULT '0' COMMENT '积分',
  `u_gender` tinyint(4) DEFAULT '0' COMMENT '0 for unkown;1 for boy; 2 for girls',
  `u_privacy` int(11) DEFAULT NULL,
  PRIMARY KEY (`u_id`,`u_role_id`),
  UNIQUE KEY `u_name_UNIQUE` (`u_name`),
  UNIQUE KEY `u_mail_UNIQUE` (`u_mail`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- 转存表中的数据 `group_users`
--

INSERT INTO `group_users` (`u_id`, `u_role_id`, `u_name`, `u_mail`, `u_password`, `u_region`, `u_mobile`, `u_qq`, `u_weibo`, `u_register_time`, `u_status`, `u_picture`, `u_intro`, `u_homepage`, `u_credits`, `u_gender`, `u_privacy`) VALUES
(1, 1, 'admin', 'admin@fudan.edu.cn', '96e79218965eb72c92a549dd5a330112', '上海', '18801730000', '10300240000', 'http://weibo.com/fdugroup', '0000-00-00 00:00:00', 1, 'files/images/users/pic_u_1.png', 'FDUGroup administrator!', 'http://localhost/FDUGroup', 0, 2, 0),
(2, 4, 'Raysmond', 'jiankunlei@126.com', '96e79218965eb72c92a549dd5a330112', 'shanghai', '18801734441', '913282582', 'http://weibo.com/leijiankun', '2013-10-16 16:29:20', 1, 'files/images/users/pic_u_2.jpg', '"The task was appointed to you. If you do not find a way, no one will."', 'http://raysmond.com', 0, 0, 0),
(3, 2, 'Klaus', 'klaus@fdugroup.com', '96e79218965eb72c92a549dd5a330112', '', '', '', '', '2013-10-16 17:57:37', 1, '', '', '', 1, 0, 0),
(4, 2, 'raysmond1', 'raysmond1@126.com', '96e79218965eb72c92a549dd5a330112', '', '', '', '', '2013-11-17 03:13:56', 1, '', '', '', 1, 0, 0),
(5, 2, 'Damon', 'damon@gmail.com', '96e79218965eb72c92a549dd5a330112', '', '', '', '', '2013-11-20 14:46:08', 1, 'files/images/users/pic_u_5.jpg', '', '', 1, 0, 0),
(6, 2, 'Stefan', 'stefan@gmail.com', '96e79218965eb72c92a549dd5a330112', '', '', '', '', '2013-11-20 14:46:23', 1, 'files/images/users/pic_u_6.jpg', '', '', 1, 0, 0),
(7, 2, 'God Thor', 'thor@gmail.com', '96e79218965eb72c92a549dd5a330112', '', '', '', '', '2013-11-20 14:46:59', 0, 'files/images/users/pic_u_7.jpg', '', '', 1, 0, 0),
(8, 2, 'Renchu Song', 'songrenchu@sina.com', '96e79218965eb72c92a549dd5a330112', '', '', '', '', '2013-11-22 03:06:20', 1, 'files/images/users/pic_u_8.jpg', '', '', 1, 0, 0),
(9, 2, 'Junshi Guo', '10300240031@fudan.edu.cn', '96e79218965eb72c92a549dd5a330112', '', '', '', '', '2013-11-22 03:22:41', 1, 'files/images/users/pic_u_9.jpg', '', '', 1, 0, 0),
(10, 2, 'Jiankun Lei', 'test@asasd.com', '96e79218965eb72c92a549dd5a330112', '', '', '', '', '2013-11-22 15:31:16', 1, 'files/images/default_pic.png', '', '', 1, 0, 0),
(11, 2, 'Bonne', 'bonne@bonne.com', '96e79218965eb72c92a549dd5a330112', '', '', '', '', '2013-11-22 15:32:56', 1, 'files/images/default_pic.png', '', '', 1, 0, 0),
(12, 2, 'testuser', 'testuser212@fudan.edu.cn', '96e79218965eb72c92a549dd5a330112', '', '', '', '', '2013-11-25 16:34:37', 0, 'files/images/default_pic.png', '', '', 1, 0, 0),
(13, 2, 'testuser2', 'testue@s.com', '96e79218965eb72c92a549dd5a330112', '', '', '', '', '2013-11-25 16:35:06', 0, 'files/images/default_pic.png', '', '', 1, 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
