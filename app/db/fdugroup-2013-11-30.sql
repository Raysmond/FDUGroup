-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 11 月 30 日 18:10
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
CREATE DATABASE IF NOT EXISTS `fdugroup` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `fdugroup`;

-- --------------------------------------------------------

--
-- 表的结构 `group_accesslog`
--

CREATE TABLE IF NOT EXISTS `group_accesslog` (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` int(11) NOT NULL DEFAULT '0' COMMENT '0 for anonymous users',
  `host` varchar(45) NOT NULL COMMENT 'the hostname of the user who''s visiting the page',
  `title` varchar(255) NOT NULL COMMENT 'the title of this page',
  `path` varchar(255) NOT NULL COMMENT 'the internal path of the page',
  `uri` varchar(255) DEFAULT NULL COMMENT 'Referrer URI',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`aid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `group_ads`
--

INSERT INTO `group_ads` (`ads_id`, `ads_user_id`, `ads_pub_time`, `ads_title`, `ads_content`, `ads_status`, `ads_paid_price`) VALUES
(1, 5, '2013-11-23 10:15:40', '测试', '测试\r\n广告推广，真情放送', 1, 0),
(2, 5, '2013-11-23 14:38:27', '新', '嘻嘻嘻', 1, 0),
(3, 2, '2013-11-23 15:41:34', 'Test ads', '&lt;p&gt;&lt;strong&gt;Test Ads by Raysmond&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;blockquote&gt;\r\n&lt;p&gt;You pay more and you can get more!&lt;/p&gt;\r\n&lt;/blockquote&gt;\r\n', 1, 100000),
(4, 2, '2013-11-23 16:14:13', 'Test ads 2', '&lt;p&gt;&lt;strong&gt;My desktop&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;&lt;a href=&quot;http://www.fudan.edu.cn&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;/FDUGroup/files/userfiles/images/2013-11-16%20221753.jpg&quot; style=&quot;height:300px; width:400px&quot; /&gt;&lt;/a&gt;&lt;/strong&gt;&lt;/p&gt;\r\n', 3, 200),
(5, 2, '2013-11-24 13:00:05', '100%实木相框 6 7 8 10 12 16寸棕色木质相架 高档出口横竖放相框', '&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;http://img03.taobaocdn.com/bao/uploaded/i3/17841024930907320/T1pO8xFe0cXXXXXXXX_!!0-item_pic.jpg_250x250.jpg&quot; style=&quot;height:250px; width:250px&quot; /&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;a href=&quot;http://click.simba.taobao.com/cc_im?p=&amp;amp;s=1129806398&amp;amp;k=344&amp;amp;e=y74WocWlztgrDPAAdEH7w0iCbrh5Xy7ibadvZUuVLH67HukN3ks3HkrigRIDLJFlq%2B%2FTWUDES441ijaAozoeTe685S5%2BACQppQzavxKeH%2BUfKs4CY1g88jv3sKZo4oB07F5yshTqJh9hrdGa2E2XrEZ3pUZzePRCO1qXkUW2U2jBasLnRgmvG2mph1f1EYpAivw7q8ddIl2TiYXmQwyJLVXgxiROIuQuNosRMij5EBQoSeaxE3tdPP556G89%2Bn%2Boz0tcAf2B24gpofRnvUoIqqAOLK65r39%2FwOr%2B7yreHt7ThXotHQ%2BUTCnEndFRjRnMACbFv3E%2BcsHOVTqFtkLPxA%3D%3D&amp;amp;clk1=b1c612cd8ca227fbe9e8814c8034e31f&quot; style=&quot;text-decoration: none; color: rgb(102, 102, 102);&quot; target=&quot;_blank&quot;&gt;100%实木相框 6 7 8 10 12 16寸棕色木质相架 高档出口横竖放相框&lt;/a&gt;&lt;/p&gt;\r\n', 3, 200),
(6, 2, '2013-11-24 13:02:01', '皮革结婚礼品大s黏胶相册 粘贴式相簿 影集韩国diy 12寸大容包邮', '&lt;p&gt;&lt;a href=&quot;http://re.taobao.com/auction?keyword=%CF%E0%B2%E1%2F%CF%E0%B2%BE&amp;amp;catid=50003463&amp;amp;refpid=tt_15890324_3509534_11501995&amp;amp;digest=746FA4B3BC79D655283C481D3DBF1D29&amp;amp;crtid=117847373&amp;amp;itemid=13222177516&amp;amp;adgrid=111307126&amp;amp;eurl=http%3A%2F%2Fclick.simba.taobao.com%2Fcc_im%3Fp%3D%26s%3D1129806398%26k%3D352%26e%3De3qVHP7KEt8rDPAAdEH7w0iCbrh5Xy7ibadvZUuVLH67HukN3ks3HkrigRIDLJFlq%252B%252FTWUDES44h%252B%252Buh3Bl9BmkF93OetYWSPQNcT6XY8cQfKs4CY1g88jv3sKZo4oB07F5yshTqJh9hrdGa2E2XrEZ3pUZzePRCO1qXkUW2U2jBasLnRgmvG2mph1f1EYpAivw7q8ddIl2TiYXmQwyJLVXgxiROIuQuNosRMij5EBRdudR0slDzyq6XvnFdtOhlRz3z2Vke9Du7%252FD42PIVBd7G5vCN4QSiqW%252F2Ge5xk06gZEjzdQYeuA4SE9laTIN93uUDXcL8al%252FT%252B7ydbnpGh90UXMDEyho3S&amp;amp;refpos=1247_111949_17,n,i&amp;amp;clk1=1e3414789ec1fd036978f4d85b0ae175&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;http://img02.taobaocdn.com/bao/uploaded/i2/T1ikmAXnFnXXcHLyPa_121510.jpg_250x250.jpg&quot; /&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;a href=&quot;http://click.simba.taobao.com/cc_im?p=&amp;amp;s=1129806398&amp;amp;k=352&amp;amp;e=e3qVHP7KEt8rDPAAdEH7w0iCbrh5Xy7ibadvZUuVLH67HukN3ks3HkrigRIDLJFlq%2B%2FTWUDES44h%2B%2Buh3Bl9BmkF93OetYWSPQNcT6XY8cQfKs4CY1g88jv3sKZo4oB07F5yshTqJh9hrdGa2E2XrEZ3pUZzePRCO1qXkUW2U2jBasLnRgmvG2mph1f1EYpAivw7q8ddIl2TiYXmQwyJLVXgxiROIuQuNosRMij5EBRdudR0slDzyq6XvnFdtOhlRz3z2Vke9Du7%2FD42PIVBd7G5vCN4QSiqW%2F2Ge5xk06gZEjzdQYeuA4SE9laTIN93uUDXcL8al%2FT%2B7ydbnpGh90UXMDEyho3S&amp;amp;clk1=1e3414789ec1fd036978f4d85b0ae175&quot; style=&quot;text-decoration: none; color: rgb(102, 102, 102);&quot; target=&quot;_blank&quot;&gt;皮革结婚礼品大s黏胶相册 粘贴式相簿 影集韩国diy 12寸大容包邮&lt;/a&gt;&lt;/p&gt;\r\n', 3, 300),
(7, 2, '2013-11-24 13:09:02', '剪刀石头布shoot征友信息', '&lt;p&gt;&lt;a href=&quot;http://weibo.com/p/1005052042213621&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;/FDUGroup/files/userfiles/images/Screen%20Shot%202013-11-24%20at%20%E4%B8%8B%E5%8D%889_05_43.png&quot; style=&quot;height:240px; width:250px&quot; /&gt;&lt;/a&gt;&lt;/p&gt;\r\n', 3, 2147483647);

-- --------------------------------------------------------

--
-- 表的结构 `group_category`
--

CREATE TABLE IF NOT EXISTS `group_category` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(45) NOT NULL,
  `cat_pid` int(11) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=52 ;

--
-- 转存表中的数据 `group_category`
--

INSERT INTO `group_category` (`cat_id`, `cat_name`, `cat_pid`) VALUES
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
(46, '八卦', 8),
(47, '发泄', 8),
(48, 'Others', 0),
(51, '影视', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=69 ;

--
-- 转存表中的数据 `group_censor`
--

INSERT INTO `group_censor` (`csr_id`, `csr_type_id`, `csr_first_id`, `csr_second_id`, `csr_status`, `csr_content`, `csr_send_time`) VALUES
(4, 0, 6, 2, 2, '', '2013-11-20 14:56:10'),
(5, 0, 6, 1, 2, '', '2013-11-20 14:56:13'),
(6, 0, 1, 7, 2, '', '2013-11-20 15:07:02'),
(7, 0, 1, 5, 2, '', '2013-11-20 15:07:11'),
(8, 0, 1, 4, 2, '', '2013-11-20 15:07:16'),
(9, 0, 4, 7, 1, '', '2013-11-20 16:57:17'),
(10, 0, 4, 2, 2, '', '2013-11-20 16:57:24'),
(11, 0, 6, 5, 1, '', '2013-11-20 17:01:22'),
(12, 0, 5, 2, 2, '', '2013-11-20 17:02:22'),
(13, 0, 1, 8, 3, '', '2013-11-21 15:45:18'),
(14, 0, 2, 11, 1, '', '2013-11-21 15:48:22'),
(15, 0, 2, 11, 1, '', '2013-11-21 15:48:57'),
(16, 0, 2, 11, 1, '', '2013-11-21 15:49:36'),
(17, 0, 8, 2, 2, '', '2013-11-22 03:25:25'),
(18, 0, 8, 1, 2, '', '2013-11-22 03:25:28'),
(19, 0, 9, 8, 1, '', '2013-11-22 03:25:56'),
(20, 0, 9, 1, 2, '', '2013-11-22 03:26:01'),
(21, 0, 9, 2, 2, '', '2013-11-22 03:26:03'),
(22, 0, 1, 2, 1, '', '2013-11-22 12:29:13'),
(23, 0, 1, 4, 1, '', '2013-11-22 12:29:13'),
(24, 0, 1, 6, 1, '', '2013-11-22 12:29:13'),
(25, 0, 2, 2, 1, '', '2013-11-22 12:29:13'),
(26, 0, 2, 4, 1, '', '2013-11-22 12:29:13'),
(27, 0, 2, 6, 1, '', '2013-11-22 12:29:13'),
(28, 0, 1, 2, 1, '', '2013-11-22 12:30:20'),
(29, 0, 1, 4, 1, '', '2013-11-22 12:30:20'),
(30, 0, 1, 6, 1, '', '2013-11-22 12:30:20'),
(31, 0, 2, 2, 1, '', '2013-11-22 12:30:20'),
(32, 0, 2, 4, 1, '', '2013-11-22 12:30:20'),
(33, 0, 2, 6, 1, '', '2013-11-22 12:30:20'),
(34, 3, 1, 2, 1, '', '2013-11-22 12:38:30'),
(35, 3, 1, 3, 1, '', '2013-11-22 12:38:30'),
(36, 3, 1, 4, 1, '', '2013-11-22 12:38:30'),
(37, 3, 1, 6, 1, '', '2013-11-22 12:38:30'),
(38, 3, 1, 1, 1, '', '2013-11-22 12:41:00'),
(39, 3, 1, 2, 1, '', '2013-11-22 12:41:00'),
(40, 3, 1, 3, 1, '', '2013-11-22 12:41:00'),
(41, 3, 1, 4, 1, '', '2013-11-22 12:41:00'),
(42, 3, 1, 6, 1, '', '2013-11-22 12:41:00'),
(43, 3, 1, 1, 1, '', '2013-11-22 12:43:13'),
(44, 3, 1, 2, 1, '', '2013-11-22 12:43:13'),
(45, 3, 1, 3, 1, '', '2013-11-22 12:43:13'),
(46, 3, 1, 4, 1, '', '2013-11-22 12:43:13'),
(47, 3, 1, 5, 1, '', '2013-11-22 12:43:13'),
(48, 3, 1, 6, 2, '', '2013-11-22 12:43:13'),
(49, 3, 1, 1, 1, '', '2013-11-22 12:55:43'),
(50, 3, 1, 2, 2, '', '2013-11-22 12:55:43'),
(51, 3, 1, 3, 1, '', '2013-11-22 12:55:43'),
(52, 3, 1, 4, 1, '', '2013-11-22 12:55:43'),
(53, 3, 1, 6, 2, '', '2013-11-22 12:55:43'),
(54, 3, 1, 1, 1, '', '2013-11-22 13:12:20'),
(55, 3, 1, 2, 1, '', '2013-11-22 13:12:20'),
(56, 3, 1, 1, 1, '', '2013-11-22 13:18:02'),
(57, 3, 1, 2, 1, '', '2013-11-22 13:18:02'),
(58, 2, 2, 0, 2, 'I&#039;m awesome!', '2013-11-22 16:36:38'),
(59, 3, 1, 1, 1, '', '2013-11-24 02:58:54'),
(60, 3, 1, 2, 1, '', '2013-11-24 02:58:54'),
(61, 3, 1, 4, 1, '', '2013-11-24 02:58:54'),
(62, 3, 1, 6, 1, '', '2013-11-24 02:58:54'),
(63, 3, 2, 1, 1, '', '2013-11-24 02:58:54'),
(64, 3, 2, 2, 1, '', '2013-11-24 02:58:54'),
(65, 3, 2, 4, 1, '', '2013-11-24 02:58:54'),
(66, 3, 2, 6, 1, '', '2013-11-24 02:58:54'),
(67, 3, 2, 6, 2, '', '2013-11-25 07:38:01'),
(68, 3, 1, 2, 1, '', '2013-11-25 10:05:52');

-- --------------------------------------------------------

--
-- 表的结构 `group_censor_type`
--

CREATE TABLE IF NOT EXISTS `group_censor_type` (
  `csr_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `csr_type_name` varchar(45) NOT NULL,
  PRIMARY KEY (`csr_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `group_censor_type`
--

INSERT INTO `group_censor_type` (`csr_type_id`, `csr_type_name`) VALUES
(1, 'add_friend'),
(2, 'apply_vip'),
(3, 'join_group'),
(4, 'post_ads');

-- --------------------------------------------------------

--
-- 表的结构 `group_comment`
--

CREATE TABLE IF NOT EXISTS `group_comment` (
  `com_id` int(11) NOT NULL AUTO_INCREMENT,
  `com_pid` int(11) NOT NULL,
  `top_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `com_created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `com_content` text NOT NULL,
  PRIMARY KEY (`com_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- 转存表中的数据 `group_comment`
--

INSERT INTO `group_comment` (`com_id`, `com_pid`, `top_id`, `u_id`, `com_created_time`, `com_content`) VALUES
(6, 0, 3, 1, '2013-10-19 12:52:19', 'hello'),
(7, 0, 1, 1, '2013-10-22 15:24:08', 'This is a comment!'),
(8, 0, 1, 1, '2013-10-22 15:24:22', 'This is a another comment.'),
(9, 0, 5, 1, '2013-11-18 14:53:29', 'Hello'),
(10, 9, 5, 1, '2013-11-18 14:53:40', '@admin hello, too'),
(11, 0, 5, 2, '2013-11-19 01:51:54', 'hello2'),
(12, 9, 5, 2, '2013-11-19 06:04:19', '@admin 1781年，美国独立战争期间。乔治·华盛顿麾下的伊卡博德·克兰上尉......'),
(13, 0, 10, 1, '2013-11-20 13:56:19', 'Good!'),
(15, 0, 7, 1, '2013-11-22 10:28:22', 'test'),
(16, 15, 7, 1, '2013-11-22 10:28:35', '@admin hello'),
(17, 7, 1, 1, '2013-11-26 03:34:01', '@admin this is a reply'),
(18, 7, 1, 1, '2013-11-26 03:36:14', '@admin another reply');

-- --------------------------------------------------------

--
-- 表的结构 `group_counter`
--

CREATE TABLE IF NOT EXISTS `group_counter` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `entity_id` int(11) NOT NULL,
  `entity_type_id` int(11) NOT NULL,
  `totalcount` bigint(20) NOT NULL DEFAULT '0',
  `daycount` int(11) NOT NULL DEFAULT '0',
  `weekcount` int(11) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT 'last view time',
  PRIMARY KEY (`cid`),
  KEY `fk_group_counter_group_entity_type1_idx` (`entity_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- 转存表中的数据 `group_counter`
--

INSERT INTO `group_counter` (`cid`, `entity_id`, `entity_type_id`, `totalcount`, `daycount`, `weekcount`, `timestamp`) VALUES
(1, 7, 1, 27, 3, 14, '2013-11-30 15:20:42'),
(2, 8, 1, 3, 1, 1, '2013-11-25 07:05:36'),
(4, 13, 1, 15, 13, 13, '2013-11-25 07:34:23'),
(5, 5, 1, 40, 33, 33, '2013-11-25 07:44:42'),
(9, 10, 1, 34, 1, 1, '2013-11-25 07:07:28'),
(10, 9, 1, 3, 1, 1, '2013-11-25 07:07:24'),
(11, 11, 1, 3, 1, 3, '2013-11-23 17:33:42'),
(12, 6, 1, 2, 1, 1, '2013-11-26 02:47:36'),
(13, 10, 2, 16, 1, 3, '2013-11-29 03:56:09'),
(14, 3, 2, 3, 2, 2, '2013-11-25 09:05:42'),
(15, 5, 2, 8, 1, 1, '2013-11-25 07:37:02'),
(16, 2, 2, 106, 51, 79, '2013-11-30 16:38:44'),
(17, 4, 2, 12, 4, 4, '2013-11-25 07:07:29'),
(18, 6, 2, 11, 1, 10, '2013-11-26 03:38:50'),
(19, 7, 2, 10, 1, 4, '2013-11-30 16:37:29'),
(20, 3, 1, 7, 4, 4, '2013-11-25 07:17:34'),
(21, 1, 2, 9, 5, 8, '2013-11-30 16:45:01'),
(22, 8, 2, 4, 2, 2, '2013-11-26 02:47:44'),
(23, 6, 3, 6, 1, 1, '2013-11-24 16:08:30'),
(24, 7, 3, 5, 5, 5, '2013-11-24 14:47:33'),
(25, 14, 1, 6, 3, 6, '2013-11-30 16:37:25'),
(26, 4, 3, 1, 1, 1, '2013-11-25 07:46:15'),
(27, 1, 1, 20, 19, 20, '2013-11-26 03:36:41'),
(28, 1, 4, 46, 18, 46, '2013-11-30 16:25:31'),
(29, 2, 4, 2, 1, 2, '2013-11-30 17:10:04'),
(30, 10, 4, 20, 20, 20, '2013-11-28 12:08:25'),
(31, 8, 4, 2, 2, 2, '2013-11-28 12:08:46'),
(32, 3, 4, 1, 1, 1, '2013-11-29 02:26:16'),
(33, 12, 4, 4, 4, 4, '2013-11-30 16:50:52');

-- --------------------------------------------------------

--
-- 表的结构 `group_entity_type`
--

CREATE TABLE IF NOT EXISTS `group_entity_type` (
  `typ_id` int(11) NOT NULL AUTO_INCREMENT,
  `typ_name` varchar(45) NOT NULL,
  PRIMARY KEY (`typ_id`),
  UNIQUE KEY `typ_name_UNIQUE` (`typ_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `group_entity_type`
--

INSERT INTO `group_entity_type` (`typ_id`, `typ_name`) VALUES
(3, 'ads_hit'),
(2, 'group'),
(1, 'topic');

-- --------------------------------------------------------

--
-- 表的结构 `group_friends`
--

CREATE TABLE IF NOT EXISTS `group_friends` (
  `f_id` int(11) NOT NULL AUTO_INCREMENT,
  `f_uid` int(11) NOT NULL,
  `f_fid` int(11) NOT NULL,
  PRIMARY KEY (`f_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- 转存表中的数据 `group_friends`
--

INSERT INTO `group_friends` (`f_id`, `f_uid`, `f_fid`) VALUES
(1, 3, 1),
(2, 1, 3),
(3, 1, 2),
(4, 2, 1),
(7, 3, 2),
(8, 2, 3),
(10, 1, 6),
(11, 6, 1),
(12, 5, 1),
(13, 1, 5),
(14, 7, 1),
(15, 1, 7),
(16, 4, 1),
(17, 1, 4),
(18, 2, 6),
(19, 6, 2),
(20, 2, 5),
(21, 5, 2),
(22, 2, 8),
(23, 8, 2),
(24, 2, 9),
(25, 9, 2),
(26, 1, 9),
(27, 9, 1),
(28, 1, 8),
(29, 8, 1);

-- --------------------------------------------------------

--
-- 表的结构 `group_groups`
--

CREATE TABLE IF NOT EXISTS `group_groups` (
  `gro_id` int(11) NOT NULL AUTO_INCREMENT,
  `gro_creator` int(11) NOT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `gro_name` varchar(45) NOT NULL,
  `gro_member_count` int(11) NOT NULL,
  `gro_created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `gro_intro` longtext,
  `gro_picture` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`gro_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `group_groups`
--

INSERT INTO `group_groups` (`gro_id`, `gro_creator`, `cat_id`, `gro_name`, `gro_member_count`, `gro_created_time`, `gro_intro`, `gro_picture`) VALUES
(1, 1, 1, 'FDUGroup Developers', 1, '2013-10-16 16:29:20', 'We develop wonderful web applications.', 'files/images/groups/group_1.jpg'),
(2, 1, 51, '美剧fans', 2, '2013-10-16 17:32:39', '&lt;p&gt;美剧迷们请在此聚集！ Game of Thrones, The Big Bang Theory, Breaking bad, How I met your mother, 2 Broke Girls, Frie...&lt;/p&gt;', 'files/images/groups/group_2.jpg'),
(3, 1, 6, '张江campus', 1, '2013-10-16 17:34:35', '我们在张江职业技术学校！', 'files/images/groups/group_3.jpg'),
(4, 1, 51, 'The Vampire Diaries', 2, '2013-10-16 17:35:40', '&lt;p&gt;The Vampire Diaries is a supernatural drama television series developed by Kevin Williamson and Julie Plec, based on the book series of the same name written by L. J. Smith. The series premiered on The CW on September 10, 2009. The series takes place in Mystic Falls, Virginia, a fictional small town haunted by supernatural beings. The series narrative follows the protagonist Elena Gilbert (Nina Dobrev) as she falls in love with vampire Stefan Salvatore (Paul Wesley) and is drawn into the supernatural world as a result. As the series progresses, Elena finds herself drawn to Stefan&amp;#39;s brother Damon Salvatore (Ian Somerhalder) resulting in a love triangle. As the narrative develops in the course of the series, the focal point shifts on the mysterious past of the town involving Elena&amp;#39;s malevolent doppelg&amp;auml;nger Katerina Petrova and the family of Original Vampires, all of which have an evil agenda of their own.&lt;/p&gt;', 'files/images/groups/group_4.jpg'),
(5, 1, 1, 'test group', 1, '2013-10-17 08:42:33', '&lt;p&gt;test&lt;/p&gt;&lt;p&gt;this is a test intro&lt;/p&gt;', 'files/images/groups/group_group_5.jpg'),
(6, 2, 1, '沉睡谷 Sleepy Hollow', 4, '2013-10-22 08:18:14', '&lt;p&gt;官方网站:&amp;nbsp;&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.fox.com%2Fsleepy-hollow%2F&amp;amp;link2key=3b063982f9&quot;&gt;www.fox.com/sleepy-hollow/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;当你在痛苦中死去，却又在250年之后的未来时代突然醒来，那会是怎样一种情况？当你发现不可想象的事件导致世界正处在毁灭的边缘，而你自己是人类最后的希望，你会怎么做？&amp;nbsp;&lt;br /&gt;&lt;br /&gt;FOX科幻新剧#沉睡谷#（Sleepy Hollow），讲述沉睡多年的乔治华盛顿部下大战复活的无头骑士的故事。&lt;/p&gt;', 'files/images/groups/group_6.jpg'),
(7, 2, 10, '爱旅行爱摄影', 2, '2013-10-22 08:27:32', '&lt;p&gt;&lt;strong&gt;我们爱旅行，我们爱摄影，因为我们爱生活&amp;hellip;&amp;hellip;&amp;nbsp;&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;&lt;br /&gt;鉴于新人进组约伴出游及时发帖的要求，暂时开放不用申请即可加入&amp;hellip;&amp;hellip;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;注意：户外俱乐部广告、频繁自顶贴内容、借贴游记或者摄影内容加网址推广网站帖一律删除，酌情封禁，不单独解释。&amp;nbsp;&lt;br /&gt;&lt;br /&gt;【微米印】- 手机定制照片书工具，摄影控必备App&amp;rarr;&amp;nbsp;&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fgoo.gl%2FWzY2n&amp;amp;link2key=3b063982f9&quot;&gt;http://goo.gl/WzY2n&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;小组官方背包客淘宝店试营业（力荐漂亮行李牌）：&amp;nbsp;&lt;br /&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fibeibao.taobao.com%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://ibeibao.taobao.com/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;（力荐）明信片免费申领活动：&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.douban.com%2Fgroup%2Ftopic%2F37528635%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://www.douban.com/group/topic/37528635/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;爱旅行爱摄影主办方专题页面（在装修中）：&amp;nbsp;&lt;br /&gt;&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.douban.com%2Fhost%2Flvyou%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://www.douban.com/host/lvyou/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;出去旅行喜欢收藏可乐罐子的进来：&amp;nbsp;&lt;br /&gt;&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fsite.douban.com%2F131460%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://site.douban.com/131460/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;爱旅行爱摄影 新浪微博群：&amp;nbsp;&lt;br /&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fq.weibo.com%2F245808&amp;amp;link2key=3b063982f9&quot;&gt;http://q.weibo.com/245808&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;小组优质游记推荐：&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.douban.com%2Fgroup%2Ftopic%2F23637082%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://www.douban.com/group/topic/23637082/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;沙发主人登记汇总：&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.douban.com%2Fgroup%2Ftopic%2F23594578%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://www.douban.com/group/topic/23594578/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;小组成员相册汇总：&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.douban.com%2Fgroup%2Ftopic%2F3005107%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://www.douban.com/group/topic/3005107/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;大家来说说旅途中的雷人雷事：&amp;nbsp;&lt;br /&gt;&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.douban.com%2Fgroup%2Ftopic%2F13469372%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://www.douban.com/group/topic/13469372/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;你是因摄影而去旅行,还是因旅行而摄影呢?&amp;nbsp;&lt;br /&gt;&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.douban.com%2Fgroup%2Ftopic%2F3281670%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://www.douban.com/group/topic/3281670/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;以下，请根据各人特点选择加入（请勿多个同时加入，注意加入条件，加入时无详细说明的申请者均不批准，提供blog或者相册者优先批准，入群后请按要求修改群名片使用默认规范字体发言）：&amp;nbsp;&lt;br /&gt;&lt;br /&gt;印度旅行背包客：96392862（仅限热爱印度人文以及打算、去过印度旅行的同学加入）&amp;nbsp;&lt;br /&gt;旅行摄影（北京群）：3897932（北京的同学请加入，方便活动）&amp;nbsp;&lt;br /&gt;旅行摄影（华东群）：1653181（华东的同学请加入，方便活动）&amp;nbsp;&lt;br /&gt;旅行摄影（不限地域群）：106029788（1000人大群，重点谈旅行，谢绝疯狂灌水，加入时候说明旅行过的地方，疯狂灌水扯聊者直接删除不解释）&amp;nbsp;&lt;br /&gt;海外行摄QQ群：107251272（仅限热衷海外旅行并且有海外旅行经验的朋友加入，入群申请请说明有哪些海外旅行经验。）&amp;nbsp;&lt;br /&gt;&lt;br /&gt;MSN群：msngroup9998@hotmail.com（已满，人口众多，灌水谈生活比较多）&amp;nbsp;&lt;br /&gt;&lt;br /&gt;飞信群：3695910（比较沉默，可能和飞信群还不很流行有关）&amp;nbsp;&lt;br /&gt;&lt;br /&gt;小组主管理员QQ：1417159（添加好友时候务必说明原因）&amp;nbsp;&lt;br /&gt;微博：&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fweibo.com%2Fxiaotao&amp;amp;link2key=3b063982f9&quot;&gt;http://weibo.com/xiaotao&lt;/a&gt;&lt;/p&gt;&lt;p&gt;原豆瓣小组：&lt;a href=&quot;http://www.douban.com/group/lvxing/&quot;&gt;http://www.douban.com/group/lvxing/&lt;/a&gt;&lt;/p&gt;&lt;p&gt;&amp;nbsp;&lt;/p&gt;', 'files/images/groups/group_7.png'),
(8, 2, 48, '恐怖电影', 3, '2013-10-22 08:31:27', '&lt;p&gt;&lt;span style=&quot;line-height:1.6em&quot;&gt;小组主群：100075281&amp;nbsp;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;br /&gt;✪加入小组请先设好头像，谢谢✪&amp;nbsp;&lt;br /&gt;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;牛逼论坛/小组（众多珍贵稀缺资源）：&amp;nbsp;&lt;br /&gt;&lt;br /&gt;夜半子不语&amp;nbsp;&lt;br /&gt;&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fsite.douban.com%2F119603%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://site.douban.com/119603/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;非常恐怖电影首发站&amp;nbsp;&lt;br /&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.fckb.net%2Fforum.php&amp;amp;link2key=3b063982f9&quot;&gt;http://www.fckb.net/forum.php&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;老片分享&amp;nbsp;&lt;br /&gt;&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.douban.com%2Fgroup%2F182931%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://www.douban.com/group/182931/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;nbsp;&lt;br /&gt;☞本小组发言严禁重要剧情透露(若主题涉及剧透，请在主题处标明)，如果发现酌情删除&amp;nbsp;&lt;br /&gt;多次剧透不改者考虑封禁&amp;nbsp;&lt;br /&gt;不欢迎谩骂　&amp;nbsp;&lt;br /&gt;&lt;br /&gt;☞为给大家一个干净纯粹的交流空间，请尽量不要以发布网站链接、图片的形式，进行变相的广告宣传活动，如出现的话会酌情处理。&amp;nbsp;&lt;br /&gt;（我们会定期把下载资源站放在小组介绍处）&amp;nbsp;&lt;br /&gt;&lt;br /&gt;☞广告贴一律删除+举报广告店铺！&amp;nbsp;&lt;br /&gt;&lt;br /&gt;☞不欢迎敏感的政治话题。&amp;nbsp;&lt;br /&gt;&lt;br /&gt;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;nbsp;&lt;br /&gt;许多国内恐怖片在线观看：&amp;nbsp;&lt;br /&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.m1905.com%2Fvod%2Flist%2Ft_6%2Fo1u1p1.html&amp;amp;link2key=3b063982f9&quot;&gt;http://www.m1905.com/vod/list/t_6/o1u1p1.html&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;114恐怖电影下载：&amp;nbsp;&lt;br /&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.3i8i.net%2Flist%2Flist5.html&amp;amp;link2key=3b063982f9&quot;&gt;http://www.3i8i.net/list/list5.html&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;3E恐怖电影下载（速度稳定）：&amp;nbsp;&lt;br /&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.eee4.cc%2Fhtml%2Fkongbu%2Findex.html&amp;amp;link2key=3b063982f9&quot;&gt;http://www.eee4.cc/html/kongbu/index.html&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;博雅在线观看（之前较著名的稀缺恐怖片发行站 支持QVOD）：&amp;nbsp;&lt;br /&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.5944b.com%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://www.5944b.com/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;&lt;br /&gt;&lt;br /&gt;【值得期待的新片】：&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fmovie.douban.com%2Fdoulist%2F730752%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://movie.douban.com/doulist/730752/&lt;/a&gt;&lt;/p&gt;&lt;p&gt;原豆瓣小组：&lt;a href=&quot;http://www.douban.com/group/horrormovies/&quot;&gt;http://www.douban.com/group/horrormovies/&lt;/a&gt;&lt;/p&gt;', 'files/images/groups/group_8.png'),
(10, 2, 14, '吃喝玩乐在上海', 3, '2013-10-22 08:53:13', '&lt;p&gt;独乐乐不如众乐乐，一起来交流【上海】海吃海喝海玩海乐和的经验吧！&amp;nbsp;&lt;br /&gt;&lt;br /&gt;我们都是一群爱&amp;quot;腐败&amp;quot;的家伙~&amp;nbsp;&lt;br /&gt;&lt;br /&gt;我们爱K歌爱泡酒吧爱美食爱旅行~&amp;nbsp;&lt;br /&gt;&lt;br /&gt;没人陪？加入同城的我们吧!&amp;nbsp;&lt;br /&gt;&lt;br /&gt;欢迎大家把自己曾去过、玩过、吃过的好地方都晒出来,一起分享上海吃喝玩乐的好去处！&amp;nbsp;&lt;br /&gt;&lt;br /&gt;*本组并非只是旅游答疑小组。天气着装之类问题在本组问过上百次，其实搜索+经验判断即有答案，不必专门发帖询问。下列FAQ供各位参考：&amp;nbsp;&lt;br /&gt;上海介绍：&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fbaike.baidu.com%2Fview%2F1735.htm&amp;amp;link2key=3b063982f9&quot;&gt;http://baike.baidu.com/view/1735.htm&lt;/a&gt;&amp;nbsp;&lt;br /&gt;上海天气：&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.weather.com.cn%2Fweather%2F101020100.shtml&amp;amp;link2key=3b063982f9&quot;&gt;http://www.weather.com.cn/weather/101020100.shtml&lt;/a&gt;&amp;nbsp;&lt;br /&gt;上海美食：&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.dianping.com%2Fshanghai%2Ffood&amp;amp;link2key=3b063982f9&quot;&gt;http://www.dianping.com/shanghai/food&lt;/a&gt;&amp;nbsp;&lt;br /&gt;上海旅游：&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Flvyou.baidu.com%2Fshanghai%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://lvyou.baidu.com/shanghai/&lt;/a&gt;&amp;nbsp;&lt;/p&gt;&lt;p&gt;原豆瓣小组链接：http://www.douban.com/group/248655/&lt;/p&gt;', 'files/images/groups/group_10.png'),
(11, 1, 1, 'Test group', 1, '2013-10-22 15:18:46', '&lt;p&gt;This is a test group.&lt;/p&gt;&lt;p&gt;&lt;em&gt;&lt;strong&gt;We welcome everybody to join in our group!&lt;/strong&gt;&lt;/em&gt;&lt;/p&gt;', 'files/images/groups/group_11.png');

-- --------------------------------------------------------

--
-- 表的结构 `group_group_has_group`
--

CREATE TABLE IF NOT EXISTS `group_group_has_group` (
  `group_id1` int(11) NOT NULL,
  `group_id2` int(11) NOT NULL,
  PRIMARY KEY (`group_id1`,`group_id2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `group_group_has_users`
--

CREATE TABLE IF NOT EXISTS `group_group_has_users` (
  `gro_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `join_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '加入时间',
  `status` int(11) NOT NULL,
  `join_comment` text,
  PRIMARY KEY (`gro_id`,`u_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `group_group_has_users`
--

INSERT INTO `group_group_has_users` (`gro_id`, `u_id`, `join_time`, `status`, `join_comment`) VALUES
(1, 1, '2013-10-16 16:29:20', 1, NULL),
(2, 1, '2013-10-16 17:32:39', 1, ''),
(2, 4, '2013-11-20 15:38:26', 1, ''),
(3, 1, '2013-10-17 09:39:16', 1, ''),
(4, 1, '2013-10-16 17:35:40', 1, ''),
(4, 2, '2013-11-19 05:52:55', 1, ''),
(5, 1, '2013-10-17 08:42:33', 1, ''),
(6, 1, '2013-11-22 12:46:27', 1, ''),
(6, 2, '2013-11-25 07:38:31', 1, ''),
(7, 1, '2013-10-22 13:44:54', 1, ''),
(7, 2, '2013-10-22 08:36:32', 1, ''),
(8, 1, '2013-11-21 15:45:49', 1, ''),
(8, 2, '2013-11-19 06:06:00', 1, ''),
(10, 1, '2013-10-22 13:44:49', 1, ''),
(10, 2, '2013-10-22 08:53:13', 1, ''),
(10, 3, '2013-11-19 15:35:00', 1, ''),
(11, 1, '2013-10-22 15:18:46', 1, '');

-- --------------------------------------------------------

--
-- 表的结构 `group_messages`
--

CREATE TABLE IF NOT EXISTS `group_messages` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=98 ;

--
-- 转存表中的数据 `group_messages`
--

INSERT INTO `group_messages` (`msg_id`, `msg_type_id`, `msg_receiver_id`, `msg_sender_id`, `msg_title`, `msg_content`, `msg_status`, `msg_send_time`) VALUES
(4, 1, 3, 0, 'Welcome, Klaus', 'Dear Klaus : &lt;br/&gt;Welcome to join the FDUGroup bit family!&lt;br/&gt;&lt;br/&gt;--- FDUGroup team&lt;br/&gt;', 2, '2013-10-16 17:57:37'),
(5, 1, 3, 1, 'Friend request', 'admin wants to be friends with you.<br/><a  title="Confirm" href="http://localhost/FDUGroup/friend/confirm/1" >Confirm</a><br/><a  title="Decline" href="http://localhost/FDUGroup/friend/decline/1" >Decline</a>', 2, '2013-10-16 18:47:38'),
(6, 1, 1, 3, 'Friend confirmed', 'Klaus has accepted your friend request.', 2, '2013-10-16 18:49:31'),
(8, 1, 2, 1, 'Friend confirmed', 'admin has accepted your friend request.', 3, '2013-10-17 10:41:13'),
(9, 4, 2, 1, 'Hello, Raysmond', 'Nice to meet you!', 3, '2013-10-22 15:22:45'),
(10, 1, 4, 0, 'Welcome, raysmond1', 'Dear raysmond1 : &lt;br/&gt;Welcome to join the FDUGroup bit family!&lt;br/&gt;&lt;br/&gt;--- FDUGroup team&lt;br/&gt;', 1, '2013-11-17 03:13:56'),
(11, 4, 2, 1, 'New Comment', 'admin has replied to your topic <a  title="沉睡谷 第一季的剧情简介" href="http://localhost/FDUGroup/post/view/5?reply=9" >沉睡谷 第一季的剧情简介</a>', 2, '2013-11-18 14:53:29'),
(12, 4, 1, 1, 'New reply', 'admin has replied to your comment <a  title="沉睡谷 第一季的剧情简介" href="http://localhost/FDUGroup/post/view/5?reply=10" >沉睡谷 第一季的剧情简介</a>', 2, '2013-11-18 14:53:40'),
(13, 1, 3, 2, 'Friend request', 'Raysmond wants to be friends with you.<br/><a  title="Confirm" href="http://localhost/FDUGroup/friend/confirm/2" >Confirm</a><br/><a  title="Decline" href="http://localhost/FDUGroup/friend/decline/2" >Decline</a>', 1, '2013-11-19 05:10:27'),
(14, 1, 4, 2, 'Friend request', 'Raysmond wants to be friends with you.<br/><a  title="Confirm" href="http://localhost/FDUGroup/friend/confirm/2" >Confirm</a><br/><a  title="Decline" href="http://localhost/FDUGroup/friend/decline/2" >Decline</a>', 1, '2013-11-19 05:10:31'),
(15, 1, 1, 3, 'Friend confirmed', 'Klaus has accepted your friend request.', 2, '2013-11-19 05:11:08'),
(16, 1, 2, 3, 'Friend confirmed', 'Klaus has accepted your friend request.', 2, '2013-11-19 05:11:10'),
(17, 4, 1, 2, 'New reply', 'Raysmond has replied to your comment <a  title="沉睡谷 第一季的剧情简介" href="http://localhost/FDUGroup/post/view/5?reply=12" >沉睡谷 第一季的剧情简介</a>', 2, '2013-11-19 06:04:19'),
(18, 1, 4, 2, 'Friend request', 'Raysmond wants to be friends with you.<br/><a  title="Confirm" href="http://localhost/FDUGroup/friend/confirm/2" >Confirm</a><br/><a  title="Decline" href="http://localhost/FDUGroup/friend/decline/2" >Decline</a>', 1, '2013-11-19 08:56:57'),
(19, 1, 4, 2, 'Friend request', 'Raysmond wants to be friends with you.<br/><a  title="Confirm" href="http://localhost/FDUGroup/friend/confirm/2" >Confirm</a><br/><a  title="Decline" href="http://localhost/FDUGroup/friend/decline/2" >Decline</a>', 1, '2013-11-19 08:57:00'),
(20, 3, 3, 2, 'new group invitation', '<a  title="Raysmond" href="http://localhost/FDUGroup/user/view/2" >Raysmond</a> invited you to join group <a  title="吃喝玩乐在上海" href="http://localhost/FDUGroup/group/detail/10" >吃喝玩乐在上海</a>&nbsp;&nbsp;<a class="btn btn-xs btn-info"  title="Accept invitation" href="http://localhost/FDUGroup/group/join/10" >Accept invitation</a></br>hello', 1, '2013-11-19 15:34:18'),
(21, 4, 1, 1, 'New reply', 'admin has replied to your comment <a  title="topic 1" href="http://localhost/FDUGroup/post/view/10?reply=15" >topic 1</a>', 2, '2013-11-20 02:29:08'),
(22, 4, 1, 1, 'New reply', 'admin has replied to your comment <a  title="hello122" href="http://localhost/FDUGroup/post/view/11?reply=17" >hello122</a>', 2, '2013-11-20 02:29:20'),
(23, 1, 5, 0, 'Welcome, Damon', 'Dear Damon : &lt;br/&gt;Welcome to join the FDUGroup bit family!&lt;br/&gt;&lt;br/&gt;--- FDUGroup team&lt;br/&gt;', 1, '2013-11-20 14:46:08'),
(24, 1, 6, 0, 'Welcome, Stefan', 'Dear Stefan : &lt;br/&gt;Welcome to join the FDUGroup bit family!&lt;br/&gt;&lt;br/&gt;--- FDUGroup team&lt;br/&gt;', 1, '2013-11-20 14:46:23'),
(25, 1, 7, 0, 'Welcome, God Thor', 'Dear God Thor : &lt;br/&gt;Welcome to join the FDUGroup bit family!&lt;br/&gt;&lt;br/&gt;--- FDUGroup team&lt;br/&gt;', 1, '2013-11-20 14:46:59'),
(26, 1, 2, 6, 'Friend request', 'Stefan wants to be friends with you.<br/><a  title="Confirm" href="http://localhost/FDUGroup/friend/confirm/6" >Confirm</a><br/><a  title="Decline" href="http://localhost/FDUGroup/friend/decline/6" >Decline</a>', 2, '2013-11-20 14:56:10'),
(28, 1, 6, 1, 'Friend confirmed', 'admin has accepted your friend request.', 1, '2013-11-20 14:56:50'),
(29, 1, 7, 1, 'Friend request', 'admin wants to be friends with you.<br/><a  title="Confirm" href="http://localhost/FDUGroup/friend/confirm/1" >Confirm</a><br/><a  title="Decline" href="http://localhost/FDUGroup/friend/decline/1" >Decline</a>', 1, '2013-11-20 15:07:02'),
(30, 1, 5, 1, 'Friend request', 'admin wants to be friends with you.<br/><a  title="Confirm" href="http://localhost/FDUGroup/friend/confirm/1" >Confirm</a><br/><a  title="Decline" href="http://localhost/FDUGroup/friend/decline/1" >Decline</a>', 2, '2013-11-20 15:07:11'),
(31, 1, 4, 1, 'Friend request', 'admin wants to be friends with you.<br/><a  title="Confirm" href="http://localhost/FDUGroup/friend/confirm/1" >Confirm</a><br/><a  title="Decline" href="http://localhost/FDUGroup/friend/decline/1" >Decline</a>', 1, '2013-11-20 15:07:16'),
(32, 1, 1, 5, 'Friend confirmed', 'Damon has accepted your friend request.', 2, '2013-11-20 15:07:54'),
(33, 1, 1, 7, 'Friend confirmed', 'God Thor has accepted your friend request.', 2, '2013-11-20 15:08:16'),
(34, 1, 1, 4, 'Friend confirmed', 'raysmond1 has accepted your friend request.', 2, '2013-11-20 15:08:40'),
(35, 3, 5, 1, 'new group invitation', '&lt;a  title=&quot;admin&quot; href=&quot;http://localhost/FDUGroup/user/view/1&quot; &gt;admin&lt;/a&gt; invited you to join group &lt;a  title=&quot;美剧fans&quot; href=&quot;http://localhost/FDUGroup/group/detail/2&quot; &gt;美剧fans&lt;/a&gt;&amp;nbsp;&amp;nbsp;&lt;a class=&quot;btn btn-xs btn-info&quot;  title=&quot;Accept invitation&quot; href=&quot;http://localhost/FDUGroup/group/join/2&quot; &gt;Accept invitation&lt;/a&gt;&lt;/br&gt;', 1, '2013-11-20 15:56:31'),
(36, 1, 7, 4, 'Friend request', 'raysmond1 wants to be friends with you.<br/><a  title="Confirm" href="http://localhost/FDUGroup/friend/confirm/4" >Confirm</a><br/><a  title="Decline" href="http://localhost/FDUGroup/friend/decline/4" >Decline</a>', 1, '2013-11-20 16:57:17'),
(38, 1, 6, 2, 'Friend confirmed', '<a  title="Raysmond" href="http://localhost/FDUGroup/user/view/2" >Raysmond</a> has accepted your friend request.', 1, '2013-11-20 16:57:54'),
(39, 1, 5, 6, 'Friend request', '<a  title="Stefan" href="http://localhost/FDUGroup/user/view/6" >Stefan</a> wants to be friends with you.<br/><a class="btn btn-xs btn-success"  title="Confirm" href="http://localhost/FDUGroup/friend/confirm/6" >Confirm</a><a class="btn btn-xs btn-danger"  title="Decline" href="http://localhost/FDUGroup/friend/decline/6" >Decline</a>', 1, '2013-11-20 17:01:22'),
(40, 1, 2, 5, 'Friend request', '<a  title="Damon" href="http://localhost/FDUGroup/user/view/5" >Damon</a> wants to be friends with you.<br/><a class="btn btn-xs btn-success"  title="Confirm" href="http://localhost/FDUGroup/friend/confirm/5" >Confirm</a>&nbsp;&nbsp;<a class="btn btn-xs btn-danger"  title="Decline" href="http://localhost/FDUGroup/friend/decline/5" >Decline</a>', 2, '2013-11-20 17:02:22'),
(41, 1, 5, 2, 'Friend confirmed', '<a  title="Raysmond" href="http://localhost/FDUGroup/user/view/2" >Raysmond</a> has accepted your friend request.', 1, '2013-11-20 17:03:03'),
(43, 3, 2, 8, 'Join group request', '<a  title="admin" href="http://localhost/FDUGroup/user/view/1" >admin</a> wants to join your group <a  title="恐怖电影" href="http://localhost/FDUGroup/group/detail/8" >恐怖电影</a><br/><a  title="Accept" href="http://localhost/FDUGroup/group/accept/13" >Accept</a><br/><a  title="Decline" href="http://localhost/FDUGroup/group/decline/13" >Decline</a>', 3, '2013-11-21 15:45:18'),
(44, 3, 1, 8, 'Join group request accepted', 'Group creator has accepted your request of joining in group <a  title="恐怖电影" href="http://localhost/FDUGroup/group/detail/8" >恐怖电影</a>', 2, '2013-11-21 15:45:49'),
(46, 3, 1, 11, 'Join group request', '<a  title="Raysmond" href="http://localhost/FDUGroup/user/view/2" >Raysmond</a> wants to join your group <a  title="Test group" href="http://localhost/FDUGroup/group/detail/11" >Test group</a><br/><a class="btn btn-xs btn-info"  title="Accept" href="http://localhost/FDUGroup/group/accept/15" >Accept</a>&nbsp;&nbsp;<a class="btn btn-xs btn-danger"  title="Decline" href="http://localhost/FDUGroup/group/decline/15" >Decline</a>', 3, '2013-11-21 15:48:57'),
(47, 3, 1, 11, 'Join group request', '<a  title="Raysmond" href="http://localhost/FDUGroup/user/view/2" >Raysmond</a> wants to join your group <a  title="Test group" href="http://localhost/FDUGroup/group/detail/11" >Test group</a><br/><a class="btn btn-xs btn-success"  title="Accept" href="http://localhost/FDUGroup/group/accept/16" >Accept</a>&nbsp;&nbsp;<a class="btn btn-xs btn-danger"  title="Decline" href="http://localhost/FDUGroup/group/decline/16" >Decline</a>', 3, '2013-11-21 15:49:36'),
(48, 1, 8, 0, 'Welcome, Renchu Song', 'Dear Renchu Song : &lt;br/&gt;Welcome to join the FDUGroup bit family!&lt;br/&gt;&lt;br/&gt;--- FDUGroup team&lt;br/&gt;', 1, '2013-11-22 03:06:20'),
(49, 1, 9, 0, 'Welcome, Junshi Guo', 'Dear Junshi Guo : &lt;br/&gt;Welcome to join the FDUGroup bit family!&lt;br/&gt;&lt;br/&gt;--- FDUGroup team&lt;br/&gt;', 1, '2013-11-22 03:22:41'),
(50, 1, 2, 8, 'Friend request', '<a  title="Renchu Song" href="http://localhost/FDUGroup/user/view/8" >Renchu Song</a> wants to be friends with you.<br/><a class="btn btn-xs btn-success"  title="Confirm" href="http://localhost/FDUGroup/friend/confirm/8" >Confirm</a>&nbsp;&nbsp;<a class="btn btn-xs btn-danger"  title="Decline" href="http://localhost/FDUGroup/friend/decline/8" >Decline</a>', 1, '2013-11-22 03:25:25'),
(51, 1, 1, 8, 'Friend request', '<a  title="Renchu Song" href="http://localhost/FDUGroup/user/view/8" >Renchu Song</a> wants to be friends with you.<br/><a class="btn btn-xs btn-success"  title="Confirm" href="http://localhost/FDUGroup/friend/confirm/8" >Confirm</a>&nbsp;&nbsp;<a class="btn btn-xs btn-danger"  title="Decline" href="http://localhost/FDUGroup/friend/decline/8" >Decline</a>', 3, '2013-11-22 03:25:28'),
(52, 1, 8, 9, 'Friend request', '<a  title="Junshi Guo" href="http://localhost/FDUGroup/user/view/9" >Junshi Guo</a> wants to be friends with you.<br/><a class="btn btn-xs btn-success"  title="Confirm" href="http://localhost/FDUGroup/friend/confirm/9" >Confirm</a>&nbsp;&nbsp;<a class="btn btn-xs btn-danger"  title="Decline" href="http://localhost/FDUGroup/friend/decline/9" >Decline</a>', 1, '2013-11-22 03:25:56'),
(53, 1, 1, 9, 'Friend request', '<a  title="Junshi Guo" href="http://localhost/FDUGroup/user/view/9" >Junshi Guo</a> wants to be friends with you.<br/><a class="btn btn-xs btn-success"  title="Confirm" href="http://localhost/FDUGroup/friend/confirm/9" >Confirm</a>&nbsp;&nbsp;<a class="btn btn-xs btn-danger"  title="Decline" href="http://localhost/FDUGroup/friend/decline/9" >Decline</a>', 2, '2013-11-22 03:26:01'),
(54, 1, 2, 9, 'Friend request', '<a  title="Junshi Guo" href="http://localhost/FDUGroup/user/view/9" >Junshi Guo</a> wants to be friends with you.<br/><a class="btn btn-xs btn-success"  title="Confirm" href="http://localhost/FDUGroup/friend/confirm/9" >Confirm</a>&nbsp;&nbsp;<a class="btn btn-xs btn-danger"  title="Decline" href="http://localhost/FDUGroup/friend/decline/9" >Decline</a>', 1, '2013-11-22 03:26:03'),
(55, 1, 8, 2, 'Friend confirmed', '<a  title="Raysmond" href="http://localhost/FDUGroup/user/view/2" >Raysmond</a> has accepted your friend request.', 1, '2013-11-22 03:26:23'),
(56, 1, 9, 2, 'Friend confirmed', '<a  title="Raysmond" href="http://localhost/FDUGroup/user/view/2" >Raysmond</a> has accepted your friend request.', 1, '2013-11-22 03:26:24'),
(57, 1, 9, 1, 'Friend confirmed', '<a  title="admin" href="http://localhost/FDUGroup/user/view/1" >admin</a> has accepted your friend request.', 1, '2013-11-22 04:21:20'),
(58, 1, 8, 1, 'Friend confirmed', '<a  title="admin" href="http://localhost/FDUGroup/user/view/1" >admin</a> has accepted your friend request.', 1, '2013-11-22 04:21:23'),
(59, 3, 6, 1, 'new group invitation', '&lt;a  title=&quot;admin&quot; href=&quot;http://localhost/FDUGroup/user/view/1&quot; &gt;admin&lt;/a&gt; invited you to join group &lt;a  title=&quot;美剧fans&quot; href=&quot;http://localhost/FDUGroup/group/detail/2&quot; &gt;美剧fans&lt;/a&gt;&amp;nbsp;&amp;nbsp;&lt;a class=&quot;btn btn-xs btn-info&quot;  title=&quot;Accept invitation&quot; href=&quot;http://localhost/FDUGroup/group/join/2&quot; &gt;Accept invitation&lt;/a&gt;&lt;/br&gt;', 1, '2013-11-22 10:24:08'),
(60, 3, 5, 1, 'new group invitation', '&lt;a  title=&quot;admin&quot; href=&quot;http://localhost/FDUGroup/user/view/1&quot; &gt;admin&lt;/a&gt; invited you to join group &lt;a  title=&quot;美剧fans&quot; href=&quot;http://localhost/FDUGroup/group/detail/2&quot; &gt;美剧fans&lt;/a&gt;&amp;nbsp;&amp;nbsp;&lt;a class=&quot;btn btn-xs btn-info&quot;  title=&quot;Accept invitation&quot; href=&quot;http://localhost/FDUGroup/group/join/2&quot; &gt;Accept invitation&lt;/a&gt;&lt;/br&gt;', 1, '2013-11-22 10:24:13'),
(61, 3, 6, 1, 'new group invitation', '&lt;a  title=&quot;admin&quot; href=&quot;http://localhost/FDUGroup/user/view/1&quot; &gt;admin&lt;/a&gt; invited you to join group &lt;a  title=&quot;美剧fans&quot; href=&quot;http://localhost/FDUGroup/group/detail/2&quot; &gt;美剧fans&lt;/a&gt;&amp;nbsp;&amp;nbsp;&lt;a class=&quot;btn btn-xs btn-info&quot;  title=&quot;Accept invitation&quot; href=&quot;http://localhost/FDUGroup/group/join/2&quot; &gt;Accept invitation&lt;/a&gt;&lt;/br&gt;', 1, '2013-11-22 10:25:15'),
(62, 3, 6, 1, 'new group invitation', '&lt;a  title=&quot;admin&quot; href=&quot;http://localhost/FDUGroup/user/view/1&quot; &gt;admin&lt;/a&gt; invited you to join group &lt;a  title=&quot;美剧fans&quot; href=&quot;http://localhost/FDUGroup/group/detail/2&quot; &gt;美剧fans&lt;/a&gt;&amp;nbsp;&amp;nbsp;&lt;a class=&quot;btn btn-xs btn-info&quot;  title=&quot;Accept invitation&quot; href=&quot;http://localhost/FDUGroup/group/join/2&quot; &gt;Accept invitation&lt;/a&gt;&lt;/br&gt;', 1, '2013-11-22 10:26:53'),
(63, 3, 5, 1, 'new group invitation', '&lt;a  title=&quot;admin&quot; href=&quot;http://localhost/FDUGroup/user/view/1&quot; &gt;admin&lt;/a&gt; invited you to join group &lt;a  title=&quot;美剧fans&quot; href=&quot;http://localhost/FDUGroup/group/detail/2&quot; &gt;美剧fans&lt;/a&gt;&amp;nbsp;&amp;nbsp;&lt;a class=&quot;btn btn-xs btn-info&quot;  title=&quot;Accept invitation&quot; href=&quot;http://localhost/FDUGroup/group/join/2&quot; &gt;Accept invitation&lt;/a&gt;&lt;/br&gt;', 1, '2013-11-22 10:27:25'),
(64, 4, 1, 1, 'New reply', 'admin has replied to your comment <a  title="The vampire diaries S05" href="http://localhost/FDUGroup/post/view/7?reply=16" >The vampire diaries S05</a>', 2, '2013-11-22 10:28:35'),
(65, 3, 6, 1, 'new group invitation', '&lt;a  title=&quot;admin&quot; href=&quot;http://localhost/FDUGroup/user/view/1&quot; &gt;admin&lt;/a&gt; invited you to join group &lt;a  title=&quot;美剧fans&quot; href=&quot;http://localhost/FDUGroup/group/detail/2&quot; &gt;美剧fans&lt;/a&gt;&amp;nbsp;&amp;nbsp;&lt;a class=&quot;btn btn-xs btn-info&quot;  title=&quot;Accept invitation&quot; href=&quot;http://localhost/FDUGroup/group/join/2&quot; &gt;Accept invitation&lt;/a&gt;&lt;/br&gt;', 1, '2013-11-22 10:31:26'),
(66, 3, 2, 1, 'new group invitation', '&lt;a  title=&quot;admin&quot; href=&quot;http://localhost/FDUGroup/user/view/1&quot; &gt;admin&lt;/a&gt; invited you to join group &lt;a  title=&quot;美剧fans&quot; href=&quot;http://localhost/FDUGroup/group/detail/2&quot; &gt;美剧fans&lt;/a&gt;&amp;nbsp;&amp;nbsp;&lt;a class=&quot;btn btn-xs btn-info&quot;  title=&quot;Accept invitation&quot; href=&quot;http://localhost/FDUGroup/group/join/2&quot; &gt;Accept invitation&lt;/a&gt;&lt;/br&gt;', 1, '2013-11-22 10:32:11'),
(67, 3, 6, 1, 'new group invitation', '&lt;a  title=&quot;admin&quot; href=&quot;http://localhost/FDUGroup/user/view/1&quot; &gt;admin&lt;/a&gt; invited you to join group &lt;a  title=&quot;美剧fans&quot; href=&quot;http://localhost/FDUGroup/group/detail/2&quot; &gt;美剧fans&lt;/a&gt;&amp;nbsp;&amp;nbsp;&lt;a class=&quot;btn btn-xs btn-info&quot;  title=&quot;Accept invitation&quot; href=&quot;http://localhost/FDUGroup/group/join/2&quot; &gt;Accept invitation&lt;/a&gt;&lt;/br&gt;', 1, '2013-11-22 10:35:04'),
(68, 3, 2, 1, 'new group invitation', '&lt;a  title=&quot;admin&quot; href=&quot;http://localhost/FDUGroup/user/view/1&quot; &gt;admin&lt;/a&gt; invited you to join group &lt;a  title=&quot;美剧fans&quot; href=&quot;http://localhost/FDUGroup/group/detail/2&quot; &gt;美剧fans&lt;/a&gt;&amp;nbsp;&amp;nbsp;&lt;a class=&quot;btn btn-xs btn-info&quot;  title=&quot;Accept invitation&quot; href=&quot;http://localhost/FDUGroup/group/join/2&quot; &gt;Accept invitation&lt;/a&gt;&lt;/br&gt;', 1, '2013-11-22 10:56:02'),
(69, 3, 6, 1, 'new group invitation', '&lt;a  title=&quot;admin&quot; href=&quot;http://localhost/FDUGroup/user/view/1&quot; &gt;admin&lt;/a&gt; invited you to join group &lt;a  title=&quot;美剧fans&quot; href=&quot;http://localhost/FDUGroup/group/detail/2&quot; &gt;美剧fans&lt;/a&gt;&amp;nbsp;&amp;nbsp;&lt;a class=&quot;btn btn-xs btn-info&quot;  title=&quot;Accept invitation&quot; href=&quot;http://localhost/FDUGroup/group/join/2&quot; &gt;Accept invitation&lt;/a&gt;&lt;/br&gt;', 1, '2013-11-22 10:56:02'),
(70, 3, 2, 1, 'new group invitation', '&lt;a  title=&quot;admin&quot; href=&quot;http://localhost/FDUGroup/user/view/1&quot; &gt;admin&lt;/a&gt; invited you to join group &lt;a  title=&quot;美剧fans&quot; href=&quot;http://localhost/FDUGroup/group/detail/2&quot; &gt;美剧fans&lt;/a&gt;&amp;nbsp;&amp;nbsp;&lt;a class=&quot;btn btn-xs btn-info&quot;  title=&quot;Accept invitation&quot; href=&quot;http://localhost/FDUGroup/group/join/2&quot; &gt;Accept invitation&lt;/a&gt;&lt;/br&gt;', 1, '2013-11-22 10:56:36'),
(71, 3, 6, 1, 'new group invitation', '&lt;a  title=&quot;admin&quot; href=&quot;http://localhost/FDUGroup/user/view/1&quot; &gt;admin&lt;/a&gt; invited you to join group &lt;a  title=&quot;美剧fans&quot; href=&quot;http://localhost/FDUGroup/group/detail/2&quot; &gt;美剧fans&lt;/a&gt;&amp;nbsp;&amp;nbsp;&lt;a class=&quot;btn btn-xs btn-info&quot;  title=&quot;Accept invitation&quot; href=&quot;http://localhost/FDUGroup/group/join/2&quot; &gt;Accept invitation&lt;/a&gt;&lt;/br&gt;', 1, '2013-11-22 10:56:36'),
(73, 3, 2, 0, 'Groups recommendation', '<div class="row"><div class="col-lg-4"><img src="http://localhost/FDUGroup/public/images/groups/group_2.jpg" title="" style="width: 95%;"  /><br/><a  title="美剧fans" href="http://localhost/FDUGroup/group/detail/2" >美剧fans</a><a class="btn btn-xs btn-success"  title="Join" href="http://localhost/FDUGroup/group/accept/25" >Join</a></div><div class="col-lg-4"><img src="http://localhost/FDUGroup/public/images/groups/group_4.jpg" title="" style="width: 95%;"  /><br/><a  title="The Vampire Diaries" href="http://localhost/FDUGroup/group/detail/4" >The Vampire Diaries</a><a class="btn btn-xs btn-success"  title="Join" href="http://localhost/FDUGroup/group/accept/26" >Join</a></div><div class="col-lg-4"><img src="http://localhost/FDUGroup/public/images/groups/group_6.jpg" title="" style="width: 95%;"  /><br/><a  title="沉睡谷 Sleepy Hollow" href="http://localhost/FDUGroup/group/detail/6" >沉睡谷 Sleepy Hollow</a><a class="btn btn-xs btn-success"  title="Join" href="http://localhost/FDUGroup/group/accept/27" >Join</a></div></div>', 3, '2013-11-22 12:29:13'),
(79, 3, 1, 6, 'Join group request accepted', 'Group creator has accepted your request of joining in group <a  title="沉睡谷 Sleepy Hollow" href="http://localhost/FDUGroup/group/detail/6" >沉睡谷 Sleepy Hollow</a>', 3, '2013-11-22 12:46:27'),
(81, 3, 6, 1, 'new group invitation', '&lt;a  title=&quot;admin&quot; href=&quot;http://localhost/FDUGroup/user/view/1&quot; &gt;admin&lt;/a&gt; invited you to join group &lt;a  title=&quot;美剧fans&quot; href=&quot;http://localhost/FDUGroup/group/detail/2&quot; &gt;美剧fans&lt;/a&gt;&amp;nbsp;&amp;nbsp;&lt;a class=&quot;btn btn-xs btn-info&quot;  title=&quot;Accept invitation&quot; href=&quot;http://localhost/FDUGroup/group/join/2&quot; &gt;Accept invitation&lt;/a&gt;&lt;/br&gt;', 1, '2013-11-22 13:05:00'),
(84, 1, 10, 0, 'Welcome Jiankun Lei', 'Dear Jiankun Lei : &lt;br/&gt;Welcome to join the FDUGroup big family!&lt;br/&gt;&lt;br/&gt;--- FDUGroup team&lt;br/&gt;', 1, '2013-11-22 15:31:16'),
(85, 1, 11, 0, 'Welcome Bonne', 'Dear Bonne : &lt;br/&gt;Welcome to join the FDUGroup big family!&lt;br/&gt;&lt;br/&gt;--- &lt;b&gt;FDUGroup team&lt;/b&gt;&lt;br/&gt;2013-11-22 23:32:56', 1, '2013-11-22 15:32:56'),
(86, 1, 2, 0, 'VIP application accepted', 'Congratulations, <a  title="Raysmond" href="http://localhost/FDUGroup/user/view/2" >Raysmond</a>!<br/> Your VIP application is accepted by Administrator.', 1, '2013-11-22 17:03:15'),
(88, 1, 2, 0, 'Groups recommendation', '<div class="row recommend-groups"><div class="col-lg-3 recommend-group-item" style="padding: 5px;"><img src="http://localhost/FDUGroup/public/images/groups/group_1.jpg" title="FDUGroup Developers"  /><br/><a  title="FDUGroup Developers" href="http://localhost/FDUGroup/group/detail/1" >FDUGroup Developers</a><br/><a class="btn btn-xs btn-success"  title="Accept" href="http://localhost/FDUGroup/group/accept/63" >Accept</a></div><div class="col-lg-3 recommend-group-item" style="padding: 5px;"><img src="http://localhost/FDUGroup/public/images/groups/group_2.jpg" title="美剧fans"  /><br/><a  title="美剧fans" href="http://localhost/FDUGroup/group/detail/2" >美剧fans</a><br/><a class="btn btn-xs btn-success"  title="Accept" href="http://localhost/FDUGroup/group/accept/64" >Accept</a></div><div class="col-lg-3 recommend-group-item" style="padding: 5px;"><img src="http://localhost/FDUGroup/public/images/groups/group_4.jpg" title="The Vampire Diaries"  /><br/><a  title="The Vampire Diaries" href="http://localhost/FDUGroup/group/detail/4" >The Vampire Diaries</a><br/><a class="btn btn-xs btn-success"  title="Accept" href="http://localhost/FDUGroup/group/accept/65" >Accept</a></div><div class="col-lg-3 recommend-group-item" style="padding: 5px;"><img src="http://localhost/FDUGroup/public/images/groups/group_6.jpg" title="沉睡谷 Sleepy Hollow"  /><br/><a  title="沉睡谷 Sleepy Hollow" href="http://localhost/FDUGroup/group/detail/6" >沉睡谷 Sleepy Hollow</a><br/><a class="btn btn-xs btn-success"  title="Accept" href="http://localhost/FDUGroup/group/accept/66" >Accept</a></div></div><div class="recommend-content">&lt;p&gt;Hello, guys! Please &lt;strong&gt;join&lt;/strong&gt; the above groups for your interest and good!&amp;nbsp;&lt;img alt=&quot;smiley&quot; src=&quot;http://localhost/FDUGroup/arch/modules/ckeditor/plugins/smiley/images/regular_smile.gif&quot; style=&quot;height:20px; width:20px&quot; title=&quot;smiley&quot; /&gt;&lt;/p&gt;\r\n</div>', 1, '2013-11-24 02:58:54'),
(89, 1, 2, 1, 'Hello, Raysmond', '&lt;blockquote&gt;\r\n&lt;p&gt;&lt;strong&gt;Hello, Raysmond&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;How are you ?&lt;/strong&gt;&lt;/p&gt;\r\n&lt;/blockquote&gt;', 1, '2013-11-24 07:30:10'),
(90, 3, 2, 6, 'Join group request', '<a  title="Raysmond" href="http://localhost/FDUGroup/user/view/2" >Raysmond</a> wants to join your group <a  title="沉睡谷 Sleepy Hollow" href="http://localhost/FDUGroup/group/detail/6" >沉睡谷 Sleepy Hollow</a><br/><a class="btn btn-xs btn-success"  title="Accept" href="http://localhost/FDUGroup/group/accept/67" >Accept</a>&nbsp;&nbsp;<a class="btn btn-xs btn-danger"  title="Decline" href="http://localhost/FDUGroup/group/decline/67" >Decline</a>', 1, '2013-11-25 07:38:01'),
(91, 3, 2, 6, 'Join group request accepted', 'Group creator has accepted your request of joining in group &lt;a  title=&quot;沉睡谷 Sleepy Hollow&quot; href=&quot;http://localhost/FDUGroup/group/detail/6&quot; &gt;沉睡谷 Sleepy Hollow&lt;/a&gt;', 1, '2013-11-25 07:38:31'),
(92, 3, 1, 2, 'Join group request', '<a  title="admin" href="/FDUGroup/user/view/1" >admin</a> wants to join your group <a  title="美剧fans" href="/FDUGroup/group/detail/2" >美剧fans</a><br/><a class="btn btn-xs btn-success"  title="Accept" href="http://localhost/FDUGroup/group/accept/68" >Accept</a>&nbsp;&nbsp;<a class="btn btn-xs btn-danger"  title="Decline" href="http://localhost/FDUGroup/group/decline/68" >Decline</a>', 1, '2013-11-25 10:05:52'),
(93, 1, 12, 0, 'Welcome testuser', 'Dear testuser : &lt;br/&gt;Welcome to join the FDUGroup big family!&lt;br/&gt;&lt;br/&gt;--- &lt;b&gt;FDUGroup team&lt;/b&gt;&lt;br/&gt;2013-11-26 00:34:37', 1, '2013-11-25 16:34:37'),
(94, 1, 13, 0, 'Welcome testuser2', 'Dear testuser2 : &lt;br/&gt;Welcome to join the FDUGroup big family!&lt;br/&gt;&lt;br/&gt;--- &lt;b&gt;FDUGroup team&lt;/b&gt;&lt;br/&gt;2013-11-26 00:35:06', 1, '2013-11-25 16:35:06'),
(95, 1, 14, 0, 'Welcome hello1', 'Dear hello1 : &lt;br/&gt;Welcome to join the FDUGroup big family!&lt;br/&gt;&lt;br/&gt;--- &lt;b&gt;FDUGroup team&lt;/b&gt;&lt;br/&gt;2013-11-26 00:36:29', 1, '2013-11-25 16:36:29'),
(96, 4, 1, 1, 'New reply', 'admin has replied to your comment <a  title="Test topic" href="/FDUGroup/post/view/1?reply=17" >Test topic</a>', 1, '2013-11-26 03:34:01'),
(97, 4, 1, 1, 'New reply', 'admin has replied to your comment <a  title="Test topic" href="/FDUGroup/post/view/1?reply=18" >Test topic</a>', 1, '2013-11-26 03:36:14');

-- --------------------------------------------------------

--
-- 表的结构 `group_message_type`
--

CREATE TABLE IF NOT EXISTS `group_message_type` (
  `msg_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `msg_type_name` varchar(45) NOT NULL,
  PRIMARY KEY (`msg_type_id`),
  UNIQUE KEY `msg_type_name_UNIQUE` (`msg_type_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `group_message_type`
--

INSERT INTO `group_message_type` (`msg_type_id`, `msg_type_name`) VALUES
(3, 'group'),
(2, 'private'),
(1, 'system'),
(4, 'user');

-- --------------------------------------------------------

--
-- 表的结构 `group_rating`
--

CREATE TABLE IF NOT EXISTS `group_rating` (
  `rating_id` int(11) NOT NULL AUTO_INCREMENT,
  `entity_type` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `value_type` varchar(45) NOT NULL,
  `tag` varchar(45) NOT NULL,
  `u_id` int(11) NOT NULL,
  `host` varchar(255) NOT NULL,
  `timestamp` varchar(45) NOT NULL,
  PRIMARY KEY (`rating_id`),
  KEY `fk_group_rating_group_entity_type1_idx` (`entity_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `group_rating_statistic`
--

CREATE TABLE IF NOT EXISTS `group_rating_statistic` (
  `stat_id` int(11) NOT NULL AUTO_INCREMENT,
  `stat_type` varchar(45) DEFAULT NULL,
  `entity_type` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `value_type` varchar(45) NOT NULL,
  `value` int(11) NOT NULL,
  `tag` varchar(45) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`stat_id`),
  KEY `fk_group_rating_statistic_group_entity_type1_idx` (`entity_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `group_syslog`
--

CREATE TABLE IF NOT EXISTS `group_syslog` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` int(11) NOT NULL DEFAULT '0',
  `type` varchar(45) NOT NULL COMMENT 'the type of the log message, like system, php, user, etc',
  `message` text NOT NULL,
  `severity` int(11) NOT NULL COMMENT 'emrgency severity',
  `path` varchar(255) NOT NULL,
  `referer_uri` varchar(255) DEFAULT NULL,
  `host` varchar(45) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `group_tag`
--

CREATE TABLE IF NOT EXISTS `group_tag` (
  `tag_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(45) NOT NULL,
  `group_entity_type` int(11) NOT NULL,
  `entity_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `group_topic`
--

CREATE TABLE IF NOT EXISTS `group_topic` (
  `top_id` int(11) NOT NULL AUTO_INCREMENT,
  `gro_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `top_title` varchar(45) NOT NULL,
  `top_created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `top_content` longtext NOT NULL,
  `top_last_comment_time` timestamp NULL DEFAULT NULL,
  `top_comment_count` int(11) NOT NULL,
  PRIMARY KEY (`top_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- 转存表中的数据 `group_topic`
--

INSERT INTO `group_topic` (`top_id`, `gro_id`, `u_id`, `top_title`, `top_created_time`, `top_content`, `top_last_comment_time`, `top_comment_count`) VALUES
(1, 1, 1, 'Test topic', '2013-10-16 18:32:10', '&lt;p&gt;This is a test topic.&lt;/p&gt;&lt;p&gt;&lt;strong&gt;Hello,World!&lt;/strong&gt;&lt;/p&gt;', '2013-11-26 03:36:14', 4),
(3, 4, 1, 'Jeremy的扮演者Steven R. McQueen即将加入《绿箭侠》', '2013-10-19 12:52:13', '&lt;p&gt;【独家资讯】《&lt;a href=&quot;http://huati.weibo.com/k/%E5%90%B8%E8%A1%80%E9%AC%BC%E6%97%A5%E8%AE%B0?from=501&quot;&gt;#吸血鬼日记#&lt;/a&gt;》Jeremy的扮演者Steven R. McQueen即将加入《绿箭侠》！他将出演超级英雄【夜翼】这个角色！目前他已与执行制片人讨论了关于该角色的相关事宜，并为夜翼进行肌肉训练！其他演员也将各种跨剧！你期待吗？【美剧频道&amp;nbsp;&lt;a href=&quot;http://weibo.com/n/%E5%85%A8%E7%90%83%E7%BE%8E%E5%89%A7%E7%94%B5%E5%BD%B1&quot;&gt;@全球美剧电影&lt;/a&gt;&amp;nbsp;联合&amp;nbsp;&lt;a href=&quot;http://weibo.com/n/%E5%90%B8%E8%A1%80%E9%AC%BC%E6%97%A5%E8%AE%B0&quot;&gt;@吸血鬼日记&lt;/a&gt;&amp;nbsp;官方微博 每周全网首播】&lt;/p&gt;&lt;p&gt;&amp;nbsp;&lt;/p&gt;', '2013-10-19 12:52:19', 1),
(4, 1, 1, 'Test', '2013-10-19 13:16:15', '&lt;p&gt;test&lt;/p&gt;', '2013-10-19 13:16:15', 0),
(5, 6, 2, '沉睡谷 第一季的剧情简介', '2013-10-22 08:19:39', '&lt;p&gt;&amp;nbsp; &amp;nbsp; &amp;nbsp; 1781年，美国独立战争期间。乔治&amp;middot;华盛顿麾下的伊卡博德&amp;middot;克兰上尉（汤姆&amp;middot;米森 Tom Mison 饰）在战场上砍掉了一个手执利斧的面具骑士的头颅，自己也身负重伤失去意识。当他再度醒来，发现周遭早已翻天覆地，此时他正处在250年后的现代化美国社会。与此同时，断头谷治安官被残忍杀害，他的搭档艾比&amp;middot;米尔斯（妮可&amp;middot;贝哈瑞 Nicole Beharie 饰）意外邂逅伊卡博德，进而得知杀害治安官的正是阴森的无头骑士。伊卡博德了解到妻子卡特里娜（卡蒂亚&amp;middot;温特 Katia Winter 饰）在他受伤后所做的一切，并从圣经的记载中意识到邪恶的天启四骑士即将和来自地狱的邪魔军团莅临人间。在此之后，死亡和杀戮在断头谷肆意蔓延，女巫、血咒、恶魔，种种鬼魅迷雾萦绕着美国的历史，从古至今，影响深远&amp;hellip;&amp;hellip;&amp;nbsp;&lt;br /&gt;　　本片根据华盛顿&amp;middot;欧文创作的《断头谷传奇》改编。&lt;/p&gt;', '2013-11-19 06:04:19', 4),
(6, 8, 2, '一起看看《招魂》2013 英文名《The conjuring》', '2013-10-22 08:32:49', '&lt;p&gt;没看过的，赶紧看看吧！&lt;/p&gt;', '2013-10-22 08:32:49', 0),
(7, 2, 1, 'The vampire diaries S05', '2013-10-22 15:16:21', '&lt;p&gt;The vampire diaries S05 now returned.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;/FDUGroup/public/userfiles/images/20110824050647224.jpg&quot; style=&quot;height:313px; width:500px&quot; /&gt;&lt;/p&gt;\r\n', '2013-11-22 10:28:35', 2),
(8, 2, 1, 'Sleep Hollow S01', '2013-10-22 15:16:38', '&lt;p&gt;Sleep Hollow S01&lt;/p&gt;', '2013-10-22 15:16:38', 0),
(9, 4, 2, 'It’s always nice to have someone in your life', '2013-11-19 05:58:01', '&lt;p&gt;It&amp;rsquo;s always nice to have someone in your life who can make you smile even when they&amp;rsquo;re not around. 生命中，有些人即使不在你身边，也能让你微笑。这样真好。 &amp;mdash;&amp;mdash; 《&lt;a href=&quot;http://huati.weibo.com/k/%E5%90%B8%E8%A1%80%E9%AC%BC%E6%97%A5%E8%AE%B0?from=501&quot;&gt;#吸血鬼日记#&lt;/a&gt;》&lt;/p&gt;', '2013-11-19 05:58:01', 0),
(10, 4, 1, '《吸血鬼日记》 TXT 中英文下载', '2013-11-20 13:53:58', '&lt;ul&gt;\r\n	&lt;li&gt;中英文小说1~4部&amp;nbsp;&lt;/li&gt;\r\n	&lt;li&gt;这是下载页面：&amp;nbsp;&lt;br /&gt;\r\n	&lt;a href=&quot;http://www.rayfile.com/zh-cn/files/2793bd57-eb23-11df-925f-0015c55db73d/a1c5a521/&quot; target=&quot;_blank&quot;&gt;http://www.rayfile.com/zh-cn/files/2793bd57-eb23-11df-925f-0015c55db73d/a1c5a521/&lt;/a&gt;&lt;/li&gt;\r\n&lt;/ul&gt;\r\n', '2013-11-20 13:56:19', 1),
(11, 4, 1, 'Katherine', '2013-11-20 13:55:35', '&lt;p&gt;头发变白，掉了牙齿，总是感到饥饿。可怜的人类。&lt;/p&gt;', '2013-11-20 13:55:35', 0),
(13, 7, 2, '旅行的心情', '2013-11-25 07:18:27', '&lt;blockquote&gt;\r\n&lt;p&gt;&lt;strong&gt;旅行的心情很重要&lt;/strong&gt;&lt;/p&gt;\r\n&lt;/blockquote&gt;\r\n', '2013-11-25 07:18:27', 0),
(14, 7, 1, '旅游真爽', '2013-11-25 07:34:57', '&lt;ul&gt;\r\n	&lt;li&gt;&lt;strong&gt;旅游真爽&lt;/strong&gt;&lt;/li&gt;\r\n&lt;/ul&gt;\r\n', '2013-11-25 07:34:57', 0);

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
  `u_permission` int(11) DEFAULT NULL,
  `u_privacy` int(11) DEFAULT NULL,
  PRIMARY KEY (`u_id`,`u_role_id`),
  UNIQUE KEY `u_name_UNIQUE` (`u_name`),
  UNIQUE KEY `u_mail_UNIQUE` (`u_mail`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- 转存表中的数据 `group_users`
--

INSERT INTO `group_users` (`u_id`, `u_role_id`, `u_name`, `u_mail`, `u_password`, `u_region`, `u_mobile`, `u_qq`, `u_weibo`, `u_register_time`, `u_status`, `u_picture`, `u_intro`, `u_homepage`, `u_credits`, `u_permission`, `u_privacy`) VALUES
(1, 1, 'admin', 'admin@fudan.edu.cn', '96e79218965eb72c92a549dd5a330112', '上海', '18801730000', '10300240000', 'http://weibo.com/fdugroup', '0000-00-00 00:00:00', 1, 'files/images/users/pic_u_1.png', 'FDUGroup administrator!', 'http://localhost/FDUGroup', 0, 0, 0),
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

-- --------------------------------------------------------

--
-- 表的结构 `group_user_role`
--

CREATE TABLE IF NOT EXISTS `group_user_role` (
  `rol_id` int(11) NOT NULL AUTO_INCREMENT,
  `rol_name` varchar(45) NOT NULL,
  PRIMARY KEY (`rol_id`),
  UNIQUE KEY `rol_name_UNIQUE` (`rol_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `group_user_role`
--

INSERT INTO `group_user_role` (`rol_id`, `rol_name`) VALUES
(1, 'administrator'),
(3, 'anonymous user'),
(2, 'authenticated user'),
(4, 'vip user');

-- --------------------------------------------------------

--
-- 表的结构 `group_wallet`
--

CREATE TABLE IF NOT EXISTS `group_wallet` (
  `u_id` int(11) NOT NULL AUTO_INCREMENT,
  `w_type` varchar(45) NOT NULL,
  `w_money` int(11) NOT NULL DEFAULT '0',
  `w_frozen_money` int(11) NOT NULL,
  `w_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`u_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `group_wallet`
--

INSERT INTO `group_wallet` (`u_id`, `w_type`, `w_money`, `w_frozen_money`, `w_timestamp`) VALUES
(1, '', 0, 0, '2013-11-24 16:18:23'),
(2, '', 0, 0, '2013-11-24 16:17:06');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
