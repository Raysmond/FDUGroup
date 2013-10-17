-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 17, 2013 at 08:41 AM
-- Server version: 5.5.31
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `fdugroup`
--
CREATE DATABASE IF NOT EXISTS `fdugroup` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `fdugroup`;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(45) NOT NULL,
  `cat_pid` int(11) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=48 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_id`, `cat_name`, `cat_pid`) VALUES
(1, '兴趣', 0),
(2, '生活', 0),
(3, '购物', 0),
(4, '社会', 0),
(5, '艺术', 0),
(6, '学术', 0),
(7, '情感', 0),
(8, '闲聊', 0),
(9, '旅行', 1),
(10, '摄影', 1),
(11, '影视', 1),
(12, '音乐', 1),
(13, '健康', 2),
(14, '美食', 2),
(15, '汽车', 2),
(16, '求职', 4),
(17, '出国', 4),
(18, '留学', 4),
(19, '淘宝', 3),
(20, '团购', 3),
(21, '数码', 3),
(22, '品牌', 3),
(23, '创业', 4),
(24, '传媒', 4),
(25, '考试', 4),
(26, '设计', 5),
(27, '手工', 5),
(28, '舞蹈', 5),
(29, '雕塑', 5),
(30, '人文', 6),
(31, '社科', 6),
(32, '自然', 6),
(33, '建筑', 6),
(34, '哲学', 6),
(35, '国学', 6),
(36, '互联网', 6),
(37, '软件', 6),
(38, '恋爱', 7),
(39, '心情', 7),
(40, '心理学', 7),
(41, '星座', 7),
(42, 'LES', 7),
(43, 'GAY', 7),
(44, '吐槽', 8),
(45, '笑话', 6),
(46, '八卦', 8),
(47, '发泄', 8);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `com_id` int(11) NOT NULL AUTO_INCREMENT,
  `com_pid` int(11) NOT NULL,
  `top_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `com_created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `com_content` text NOT NULL,
  PRIMARY KEY (`com_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`com_id`, `com_pid`, `top_id`, `u_id`, `com_created_time`, `com_content`) VALUES
(1, 0, 2, 1, '2013-10-17 06:40:56', 'hello');

-- --------------------------------------------------------

--
-- Table structure for table `entity_type`
--

CREATE TABLE IF NOT EXISTS `entity_type` (
  `typ_id` int(11) NOT NULL AUTO_INCREMENT,
  `typ_name` varchar(45) NOT NULL,
  PRIMARY KEY (`typ_id`),
  UNIQUE KEY `typ_name_UNIQUE` (`typ_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `entity_type`
--

INSERT INTO `entity_type` (`typ_id`, `typ_name`) VALUES
(2, 'group'),
(1, 'topic');

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
  `f_id` int(11) NOT NULL AUTO_INCREMENT,
  `f_uid` int(11) NOT NULL,
  `f_fid` int(11) NOT NULL,
  PRIMARY KEY (`f_id`),
  KEY `f_uid` (`f_uid`),
  KEY `f_fid` (`f_fid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`f_id`, `f_uid`, `f_fid`) VALUES
(1, 3, 1),
(2, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `gro_id` int(11) NOT NULL AUTO_INCREMENT,
  `gro_creator` int(11) NOT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `gro_name` varchar(45) NOT NULL,
  `gro_member_count` int(11) NOT NULL,
  `gro_created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `gro_intro` longtext,
  `gro_picture` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`gro_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`gro_id`, `gro_creator`, `cat_id`, `gro_name`, `gro_member_count`, `gro_created_time`, `gro_intro`, `gro_picture`) VALUES
(1, 1, 1, 'FDUGroup Developers', 1, '2013-10-16 16:29:20', 'We develop wonderful web applications.', 'public/images/groups/group_1.jpg'),
(2, 1, 11, '美剧fans', 1, '2013-10-16 17:32:39', '美剧迷们请在此聚集！ Game of Thrones, The Big Bang Theory, Breaking bad, How I met your mother, 2 Broke Girls, Frie...', 'public/images/groups/group_2.jpg'),
(3, 1, 6, '张江campus', 1, '2013-10-16 17:34:35', '我们在张江职业技术学校！', 'public/images/groups/group_3.jpg'),
(4, 1, 11, 'The Vampire Diaries', 1, '2013-10-16 17:35:40', 'The Vampire Diaries is a supernatural drama television series developed by Kevin Williamson and Julie Plec, based on the book series of the same name written by L. J. Smith. The series premiered on The CW on September 10, 2009. The series takes place in Mystic Falls, Virginia, a fictional small town haunted by supernatural beings. The series narrative follows the protagonist Elena Gilbert (Nina Dobrev) as she falls in love with vampire Stefan Salvatore (Paul Wesley) and is drawn into the supernatural world as a result. As the series progresses, Elena finds herself drawn to Stefan&#039;s brother Damon Salvatore (Ian Somerhalder) resulting in a love triangle. As the narrative develops in the course of the series, the focal point shifts on the mysterious past of the town involving Elena&#039;s malevolent doppelgänger Katerina Petrova and the family of Original Vampires, all of which have an evil agenda of their own.', 'public/images/groups/group_4.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `group_has_group`
--

CREATE TABLE IF NOT EXISTS `group_has_group` (
  `group_id1` int(11) NOT NULL,
  `group_id2` int(11) NOT NULL,
  PRIMARY KEY (`group_id1`,`group_id2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `group_has_users`
--

CREATE TABLE IF NOT EXISTS `group_has_users` (
  `gro_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `join_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '加入时间',
  `status` int(11) NOT NULL,
  `comment` text,
  PRIMARY KEY (`gro_id`,`u_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `group_has_users`
--

INSERT INTO `group_has_users` (`gro_id`, `u_id`, `join_time`, `status`, `comment`) VALUES
(1, 1, '2013-10-16 16:29:20', 1, NULL),
(2, 1, '2013-10-16 17:32:39', 1, ''),
(3, 1, '2013-10-16 17:34:36', 1, ''),
(4, 1, '2013-10-16 17:35:40', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `msg_id` int(11) NOT NULL AUTO_INCREMENT,
  `msg_type_id` int(11) NOT NULL,
  `msg_receiver_id` int(11) NOT NULL,
  `msg_sender_id` int(11) NOT NULL COMMENT 'According to message_type\ntype=''system'', sender_id=0\ntype=''group'', sender_id=group_id\ntype=''user'', sender_id = user_id',
  `msg_title` varchar(45) DEFAULT NULL,
  `msg_content` text NOT NULL,
  `msg_status` int(11) NOT NULL DEFAULT '0' COMMENT '1: not read\n2: read\nothers..',
  `msg_send_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`msg_id`,`msg_type_id`,`msg_receiver_id`),
  UNIQUE KEY `msg_id_UNIQUE` (`msg_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`msg_id`, `msg_type_id`, `msg_receiver_id`, `msg_sender_id`, `msg_title`, `msg_content`, `msg_status`, `msg_send_time`) VALUES
(1, 4, 1, 2, 'hello', 'a message from user', 2, '2013-10-16 16:29:20'),
(2, 1, 1, 0, 'system notification', 'a system notification', 1, '2013-10-16 16:29:20'),
(3, 1, 1, 0, 'welcome', 'a welcome message', 2, '2013-10-16 16:29:20'),
(4, 1, 3, 0, 'Welcome, Klaus', 'Dear Klaus : &lt;br/&gt;Welcome to join the FDUGroup bit family!&lt;br/&gt;&lt;br/&gt;--- FDUGroup team&lt;br/&gt;', 2, '2013-10-16 17:57:37'),
(5, 1, 3, 1, 'Friend request', 'admin wants to be friends with you.<br/><a  title="Confirm" href="http://localhost/FDUGroup/friend/confirm/1" >Confirm</a><br/><a  title="Decline" href="http://localhost/FDUGroup/friend/decline/1" >Decline</a>', 2, '2013-10-16 18:47:38'),
(6, 1, 1, 3, 'Friend confirmed', 'Klaus has accepted your friend request.', 1, '2013-10-16 18:49:31');

-- --------------------------------------------------------

--
-- Table structure for table `message_type`
--

CREATE TABLE IF NOT EXISTS `message_type` (
  `msg_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `msg_type_name` varchar(45) NOT NULL,
  PRIMARY KEY (`msg_type_id`),
  UNIQUE KEY `msg_type_name_UNIQUE` (`msg_type_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `message_type`
--

INSERT INTO `message_type` (`msg_type_id`, `msg_type_name`) VALUES
(3, 'group'),
(2, 'private'),
(1, 'system'),
(4, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE IF NOT EXISTS `tag` (
  `tag_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(45) NOT NULL,
  `entity_type` int(11) NOT NULL,
  `entity_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `topic`
--

CREATE TABLE IF NOT EXISTS `topic` (
  `top_id` int(11) NOT NULL AUTO_INCREMENT,
  `gro_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `top_title` varchar(45) NOT NULL,
  `top_created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `top_content` longtext NOT NULL,
  `top_last_comment_time` timestamp NULL DEFAULT NULL,
  `top_comment_count` int(11) NOT NULL,
  PRIMARY KEY (`top_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `topic`
--

INSERT INTO `topic` (`top_id`, `gro_id`, `u_id`, `top_title`, `top_created_time`, `top_content`, `top_last_comment_time`, `top_comment_count`) VALUES
(1, 1, 1, 'Test topic', '2013-10-16 18:32:10', 'test', '2013-10-16 18:32:10', 0),
(2, 1, 1, 'Test topic 1', '2013-10-16 18:32:10', 'test', '2013-10-17 06:40:56', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
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
  `u_permission` int(11) DEFAULT NULL,
  `u_privacy` int(11) DEFAULT NULL,
  PRIMARY KEY (`u_id`,`u_role_id`),
  UNIQUE KEY `u_name_UNIQUE` (`u_name`),
  UNIQUE KEY `u_mail_UNIQUE` (`u_mail`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `u_role_id`, `u_name`, `u_mail`, `u_password`, `u_region`, `u_mobile`, `u_qq`, `u_weibo`, `u_register_time`, `u_status`, `u_picture`, `u_intro`, `u_homepage`, `u_credits`, `u_permission`, `u_privacy`) VALUES
(1, 1, 'admin', 'admin@fudan.edu.cn', '96e79218965eb72c92a549dd5a330112', 'shanghai', NULL, NULL, NULL, '0000-00-00 00:00:00', 1, 'public/images/users/pic_u_1.jpg', NULL, NULL, 0, NULL, NULL),
(2, 2, 'Raysmond', 'jiankunlei@126.com', '96e79218965eb72c92a549dd5a330112', 'shanghai', '18801734441', '913282582', 'http://weibo.com/leijiankun', '2013-10-16 16:29:20', 1, '', NULL, 'http://raysmond.com', 0, NULL, NULL),
(3, 2, 'Klaus', 'klaus@fdugroup.com', '96e79218965eb72c92a549dd5a330112', '', '', '', '', '2013-10-16 17:57:37', 1, '', '', '', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `rol_id` int(11) NOT NULL AUTO_INCREMENT,
  `rol_name` varchar(45) NOT NULL,
  PRIMARY KEY (`rol_id`),
  UNIQUE KEY `rol_name_UNIQUE` (`rol_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`rol_id`, `rol_name`) VALUES
(1, 'administrator'),
(3, 'anonymous user'),
(2, 'authenticated user'),
(4, 'vip user');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `friends`
--
ALTER TABLE `friends`
  ADD CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`f_uid`) REFERENCES `users` (`u_id`),
  ADD CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`f_fid`) REFERENCES `users` (`u_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
