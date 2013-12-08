-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2013 年 12 月 05 日 08:26
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
(4, 2, '2013-11-23 16:14:13', '可爱的小乌龟', '&lt;p&gt;&lt;strong style=&quot;line-height:1.6em&quot;&gt;&lt;a href=&quot;http://www.fudan.edu.cn&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;http://distilleryimage8.ak.instagram.com/68e9c8c05c3811e3b56312c03b4ac6f5_8.jpg&quot; style=&quot;height:250px; width:250px&quot; /&gt;&lt;/a&gt;&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;可爱的小乌龟&lt;/p&gt;\r\n', 3, 200),
(5, 2, '2013-11-24 13:00:05', '100%实木相框 6 7 8 10 12 16寸棕色木质相架 高档出口横竖放相框', '&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;http://img03.taobaocdn.com/bao/uploaded/i3/17841024930907320/T1pO8xFe0cXXXXXXXX_!!0-item_pic.jpg_250x250.jpg&quot; style=&quot;height:250px; width:250px&quot; /&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;a href=&quot;http://click.simba.taobao.com/cc_im?p=&amp;amp;s=1129806398&amp;amp;k=344&amp;amp;e=y74WocWlztgrDPAAdEH7w0iCbrh5Xy7ibadvZUuVLH67HukN3ks3HkrigRIDLJFlq%2B%2FTWUDES441ijaAozoeTe685S5%2BACQppQzavxKeH%2BUfKs4CY1g88jv3sKZo4oB07F5yshTqJh9hrdGa2E2XrEZ3pUZzePRCO1qXkUW2U2jBasLnRgmvG2mph1f1EYpAivw7q8ddIl2TiYXmQwyJLVXgxiROIuQuNosRMij5EBQoSeaxE3tdPP556G89%2Bn%2Boz0tcAf2B24gpofRnvUoIqqAOLK65r39%2FwOr%2B7yreHt7ThXotHQ%2BUTCnEndFRjRnMACbFv3E%2BcsHOVTqFtkLPxA%3D%3D&amp;amp;clk1=b1c612cd8ca227fbe9e8814c8034e31f&quot; style=&quot;text-decoration: none; color: rgb(102, 102, 102);&quot; target=&quot;_blank&quot;&gt;100%实木相框 6 7 8 10 12 16寸棕色木质相架 高档出口横竖放相框&lt;/a&gt;&lt;/p&gt;\r\n', 3, 200),
(6, 2, '2013-11-24 13:02:01', '皮革结婚礼品大s黏胶相册 粘贴式相簿 影集韩国diy 12寸大容包邮', '&lt;p&gt;&lt;a href=&quot;http://re.taobao.com/auction?keyword=%CF%E0%B2%E1%2F%CF%E0%B2%BE&amp;amp;catid=50003463&amp;amp;refpid=tt_15890324_3509534_11501995&amp;amp;digest=746FA4B3BC79D655283C481D3DBF1D29&amp;amp;crtid=117847373&amp;amp;itemid=13222177516&amp;amp;adgrid=111307126&amp;amp;eurl=http%3A%2F%2Fclick.simba.taobao.com%2Fcc_im%3Fp%3D%26s%3D1129806398%26k%3D352%26e%3De3qVHP7KEt8rDPAAdEH7w0iCbrh5Xy7ibadvZUuVLH67HukN3ks3HkrigRIDLJFlq%252B%252FTWUDES44h%252B%252Buh3Bl9BmkF93OetYWSPQNcT6XY8cQfKs4CY1g88jv3sKZo4oB07F5yshTqJh9hrdGa2E2XrEZ3pUZzePRCO1qXkUW2U2jBasLnRgmvG2mph1f1EYpAivw7q8ddIl2TiYXmQwyJLVXgxiROIuQuNosRMij5EBRdudR0slDzyq6XvnFdtOhlRz3z2Vke9Du7%252FD42PIVBd7G5vCN4QSiqW%252F2Ge5xk06gZEjzdQYeuA4SE9laTIN93uUDXcL8al%252FT%252B7ydbnpGh90UXMDEyho3S&amp;amp;refpos=1247_111949_17,n,i&amp;amp;clk1=1e3414789ec1fd036978f4d85b0ae175&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;http://img02.taobaocdn.com/bao/uploaded/i2/T1ikmAXnFnXXcHLyPa_121510.jpg_250x250.jpg&quot; /&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;a href=&quot;http://click.simba.taobao.com/cc_im?p=&amp;amp;s=1129806398&amp;amp;k=352&amp;amp;e=e3qVHP7KEt8rDPAAdEH7w0iCbrh5Xy7ibadvZUuVLH67HukN3ks3HkrigRIDLJFlq%2B%2FTWUDES44h%2B%2Buh3Bl9BmkF93OetYWSPQNcT6XY8cQfKs4CY1g88jv3sKZo4oB07F5yshTqJh9hrdGa2E2XrEZ3pUZzePRCO1qXkUW2U2jBasLnRgmvG2mph1f1EYpAivw7q8ddIl2TiYXmQwyJLVXgxiROIuQuNosRMij5EBRdudR0slDzyq6XvnFdtOhlRz3z2Vke9Du7%2FD42PIVBd7G5vCN4QSiqW%2F2Ge5xk06gZEjzdQYeuA4SE9laTIN93uUDXcL8al%2FT%2B7ydbnpGh90UXMDEyho3S&amp;amp;clk1=1e3414789ec1fd036978f4d85b0ae175&quot; style=&quot;text-decoration: none; color: rgb(102, 102, 102);&quot; target=&quot;_blank&quot;&gt;皮革结婚礼品大s黏胶相册 粘贴式相簿 影集韩国diy 12寸大容包邮&lt;/a&gt;&lt;/p&gt;\r\n', 3, 300),
(7, 2, '2013-11-24 13:09:02', '剪刀石头布shoot征友信息', '&lt;p&gt;&lt;a href=&quot;http://weibo.com/p/1005052042213621&quot; style=&quot;line-height: 1.6em;&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;http://ww4.sinaimg.cn/mw690/79b9b4f5gw1e2xdfdtxmmj.jpg&quot; style=&quot;height:165px; width:250px&quot; /&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;剪刀石头布shoot征友信息&lt;/p&gt;\r\n', 3, 2147483647);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=79 ;

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
(68, 3, 1, 2, 1, '', '2013-11-25 10:05:52'),
(69, 3, 1, 12, 1, '', '2013-12-05 04:04:47'),
(70, 3, 1, 12, 1, '', '2013-12-05 04:05:14'),
(71, 3, 1, 12, 2, '', '2013-12-05 04:06:26'),
(72, 3, 1, 6, 2, '', '2013-12-05 04:06:38'),
(73, 3, 3, 17, 1, '', '2013-12-05 06:58:04'),
(74, 3, 2, 17, 2, '', '2013-12-05 06:58:04'),
(75, 3, 6, 17, 1, '', '2013-12-05 06:58:05'),
(76, 3, 5, 17, 1, '', '2013-12-05 06:58:05'),
(77, 3, 9, 17, 1, '', '2013-12-05 06:58:05'),
(78, 3, 8, 17, 1, '', '2013-12-05 06:58:05');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

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
(18, 7, 1, 1, '2013-11-26 03:36:14', '@admin another reply'),
(19, 0, 14, 2, '2013-12-05 06:58:45', '张江校区！');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=45 ;

--
-- 转存表中的数据 `group_counter`
--

INSERT INTO `group_counter` (`cid`, `entity_id`, `entity_type_id`, `totalcount`, `daycount`, `weekcount`, `timestamp`) VALUES
(1, 7, 1, 37, 8, 10, '2013-12-05 07:25:41'),
(2, 8, 1, 3, 1, 1, '2013-11-25 07:05:36'),
(4, 13, 1, 20, 5, 5, '2013-12-05 07:14:22'),
(5, 5, 1, 40, 33, 33, '2013-11-25 07:44:42'),
(9, 10, 1, 35, 1, 2, '2013-11-30 17:19:33'),
(10, 9, 1, 3, 1, 1, '2013-11-25 07:07:24'),
(11, 11, 1, 3, 1, 3, '2013-11-23 17:33:42'),
(12, 6, 1, 2, 1, 1, '2013-11-26 02:47:36'),
(13, 10, 2, 20, 1, 3, '2013-12-05 04:07:53'),
(14, 3, 2, 3, 2, 2, '2013-11-25 09:05:42'),
(15, 5, 2, 10, 2, 2, '2013-12-04 11:26:39'),
(16, 2, 2, 112, 1, 6, '2013-12-05 03:42:55'),
(17, 4, 2, 13, 1, 1, '2013-12-04 07:54:07'),
(18, 6, 2, 11, 1, 10, '2013-11-26 03:38:50'),
(19, 7, 2, 10, 1, 4, '2013-11-30 16:37:29'),
(20, 3, 1, 7, 4, 4, '2013-11-25 07:17:34'),
(21, 1, 2, 9, 5, 8, '2013-11-30 16:45:01'),
(22, 8, 2, 6, 2, 2, '2013-12-04 11:41:08'),
(23, 6, 3, 6, 1, 1, '2013-11-24 16:08:30'),
(24, 7, 3, 7, 1, 2, '2013-12-05 07:01:52'),
(25, 14, 1, 19, 13, 13, '2013-12-05 07:03:32'),
(26, 4, 3, 1, 1, 1, '2013-11-25 07:46:15'),
(27, 1, 1, 20, 19, 20, '2013-11-26 03:36:41'),
(28, 1, 4, 138, 51, 85, '2013-12-05 05:48:06'),
(29, 2, 4, 14, 12, 12, '2013-12-05 07:11:07'),
(30, 10, 4, 21, 1, 1, '2013-12-05 07:25:50'),
(31, 8, 4, 4, 2, 4, '2013-11-30 17:20:06'),
(32, 3, 4, 3, 1, 2, '2013-12-05 06:57:14'),
(33, 12, 4, 4, 4, 4, '2013-11-30 16:50:52'),
(34, 5, 4, 2, 2, 2, '2013-11-30 17:49:26'),
(38, 7, 4, 1, 1, 1, '2013-12-04 18:04:18'),
(39, 4, 1, 3, 3, 3, '2013-12-05 03:45:19'),
(40, 9, 4, 5, 5, 5, '2013-12-05 04:08:58'),
(41, 13, 2, 1, 1, 1, '2013-12-05 06:39:43'),
(42, 15, 2, 2, 2, 2, '2013-12-05 06:44:17'),
(43, 16, 2, 3, 3, 3, '2013-12-05 06:57:17'),
(44, 17, 2, 6, 6, 6, '2013-12-05 07:11:00');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- 转存表中的数据 `group_groups`
--

INSERT INTO `group_groups` (`gro_id`, `gro_creator`, `cat_id`, `gro_name`, `gro_member_count`, `gro_created_time`, `gro_intro`, `gro_picture`) VALUES
(1, 1, 1, 'FDUGroup Developers', 1, '2013-10-16 16:29:20', 'We develop wonderful web applications.', 'files/images/groups/group_1.jpg'),
(2, 1, 51, '美剧fans', 2, '2013-10-16 17:32:39', '&lt;p&gt;美剧迷们请在此聚集！ Game of Thrones, The Big Bang Theory, Breaking bad, How I met your mother, 2 Broke Girls, Frie...&lt;/p&gt;', 'files/images/groups/group_2.jpg'),
(3, 1, 6, '张江campus', 1, '2013-10-16 17:34:35', '我们在张江职业技术学校！', 'files/images/groups/group_3.jpg'),
(4, 1, 51, 'The Vampire Diaries', 2, '2013-10-16 17:35:40', '&lt;p&gt;The Vampire Diaries is a supernatural drama television series developed by Kevin Williamson and Julie Plec, based on the book series of the same name written by L. J. Smith. The series premiered on The CW on September 10, 2009. The series takes place in Mystic Falls, Virginia, a fictional small town haunted by supernatural beings. The series narrative follows the protagonist Elena Gilbert (Nina Dobrev) as she falls in love with vampire Stefan Salvatore (Paul Wesley) and is drawn into the supernatural world as a result. As the series progresses, Elena finds herself drawn to Stefan&amp;#39;s brother Damon Salvatore (Ian Somerhalder) resulting in a love triangle. As the narrative develops in the course of the series, the focal point shifts on the mysterious past of the town involving Elena&amp;#39;s malevolent doppelg&amp;auml;nger Katerina Petrova and the family of Original Vampires, all of which have an evil agenda of their own.&lt;/p&gt;', 'files/images/groups/group_4.jpg'),
(5, 1, 1, 'test group', 1, '2013-10-17 08:42:33', '&lt;p&gt;test&lt;/p&gt;\r\n\r\n&lt;p&gt;this is a test intro&lt;/p&gt;', 'files/images/groups/group_5.jpg'),
(6, 2, 1, '沉睡谷 Sleepy Hollow', 4, '2013-10-22 08:18:14', '&lt;p&gt;官方网站:&amp;nbsp;&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.fox.com%2Fsleepy-hollow%2F&amp;amp;link2key=3b063982f9&quot;&gt;www.fox.com/sleepy-hollow/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;当你在痛苦中死去，却又在250年之后的未来时代突然醒来，那会是怎样一种情况？当你发现不可想象的事件导致世界正处在毁灭的边缘，而你自己是人类最后的希望，你会怎么做？&amp;nbsp;&lt;br /&gt;&lt;br /&gt;FOX科幻新剧#沉睡谷#（Sleepy Hollow），讲述沉睡多年的乔治华盛顿部下大战复活的无头骑士的故事。&lt;/p&gt;', 'files/images/groups/group_6.jpg'),
(7, 2, 10, '爱旅行爱摄影', 2, '2013-10-22 08:27:32', '&lt;p&gt;&lt;strong&gt;我们爱旅行，我们爱摄影，因为我们爱生活&amp;hellip;&amp;hellip;&amp;nbsp;&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;&lt;br /&gt;鉴于新人进组约伴出游及时发帖的要求，暂时开放不用申请即可加入&amp;hellip;&amp;hellip;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;注意：户外俱乐部广告、频繁自顶贴内容、借贴游记或者摄影内容加网址推广网站帖一律删除，酌情封禁，不单独解释。&amp;nbsp;&lt;br /&gt;&lt;br /&gt;【微米印】- 手机定制照片书工具，摄影控必备App&amp;rarr;&amp;nbsp;&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fgoo.gl%2FWzY2n&amp;amp;link2key=3b063982f9&quot;&gt;http://goo.gl/WzY2n&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;小组官方背包客淘宝店试营业（力荐漂亮行李牌）：&amp;nbsp;&lt;br /&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fibeibao.taobao.com%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://ibeibao.taobao.com/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;（力荐）明信片免费申领活动：&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.douban.com%2Fgroup%2Ftopic%2F37528635%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://www.douban.com/group/topic/37528635/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;爱旅行爱摄影主办方专题页面（在装修中）：&amp;nbsp;&lt;br /&gt;&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.douban.com%2Fhost%2Flvyou%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://www.douban.com/host/lvyou/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;出去旅行喜欢收藏可乐罐子的进来：&amp;nbsp;&lt;br /&gt;&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fsite.douban.com%2F131460%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://site.douban.com/131460/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;爱旅行爱摄影 新浪微博群：&amp;nbsp;&lt;br /&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fq.weibo.com%2F245808&amp;amp;link2key=3b063982f9&quot;&gt;http://q.weibo.com/245808&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;小组优质游记推荐：&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.douban.com%2Fgroup%2Ftopic%2F23637082%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://www.douban.com/group/topic/23637082/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;沙发主人登记汇总：&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.douban.com%2Fgroup%2Ftopic%2F23594578%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://www.douban.com/group/topic/23594578/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;小组成员相册汇总：&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.douban.com%2Fgroup%2Ftopic%2F3005107%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://www.douban.com/group/topic/3005107/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;大家来说说旅途中的雷人雷事：&amp;nbsp;&lt;br /&gt;&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.douban.com%2Fgroup%2Ftopic%2F13469372%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://www.douban.com/group/topic/13469372/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;你是因摄影而去旅行,还是因旅行而摄影呢?&amp;nbsp;&lt;br /&gt;&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.douban.com%2Fgroup%2Ftopic%2F3281670%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://www.douban.com/group/topic/3281670/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;以下，请根据各人特点选择加入（请勿多个同时加入，注意加入条件，加入时无详细说明的申请者均不批准，提供blog或者相册者优先批准，入群后请按要求修改群名片使用默认规范字体发言）：&amp;nbsp;&lt;br /&gt;&lt;br /&gt;印度旅行背包客：96392862（仅限热爱印度人文以及打算、去过印度旅行的同学加入）&amp;nbsp;&lt;br /&gt;旅行摄影（北京群）：3897932（北京的同学请加入，方便活动）&amp;nbsp;&lt;br /&gt;旅行摄影（华东群）：1653181（华东的同学请加入，方便活动）&amp;nbsp;&lt;br /&gt;旅行摄影（不限地域群）：106029788（1000人大群，重点谈旅行，谢绝疯狂灌水，加入时候说明旅行过的地方，疯狂灌水扯聊者直接删除不解释）&amp;nbsp;&lt;br /&gt;海外行摄QQ群：107251272（仅限热衷海外旅行并且有海外旅行经验的朋友加入，入群申请请说明有哪些海外旅行经验。）&amp;nbsp;&lt;br /&gt;&lt;br /&gt;MSN群：msngroup9998@hotmail.com（已满，人口众多，灌水谈生活比较多）&amp;nbsp;&lt;br /&gt;&lt;br /&gt;飞信群：3695910（比较沉默，可能和飞信群还不很流行有关）&amp;nbsp;&lt;br /&gt;&lt;br /&gt;小组主管理员QQ：1417159（添加好友时候务必说明原因）&amp;nbsp;&lt;br /&gt;微博：&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fweibo.com%2Fxiaotao&amp;amp;link2key=3b063982f9&quot;&gt;http://weibo.com/xiaotao&lt;/a&gt;&lt;/p&gt;&lt;p&gt;原豆瓣小组：&lt;a href=&quot;http://www.douban.com/group/lvxing/&quot;&gt;http://www.douban.com/group/lvxing/&lt;/a&gt;&lt;/p&gt;&lt;p&gt;&amp;nbsp;&lt;/p&gt;', 'files/images/groups/group_7.png'),
(8, 2, 48, '恐怖电影', 3, '2013-10-22 08:31:27', '&lt;p&gt;&lt;span style=&quot;line-height:1.6em&quot;&gt;小组主群：100075281&amp;nbsp;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;br /&gt;✪加入小组请先设好头像，谢谢✪&amp;nbsp;&lt;br /&gt;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;牛逼论坛/小组（众多珍贵稀缺资源）：&amp;nbsp;&lt;br /&gt;&lt;br /&gt;夜半子不语&amp;nbsp;&lt;br /&gt;&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fsite.douban.com%2F119603%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://site.douban.com/119603/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;非常恐怖电影首发站&amp;nbsp;&lt;br /&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.fckb.net%2Fforum.php&amp;amp;link2key=3b063982f9&quot;&gt;http://www.fckb.net/forum.php&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;老片分享&amp;nbsp;&lt;br /&gt;&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.douban.com%2Fgroup%2F182931%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://www.douban.com/group/182931/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;nbsp;&lt;br /&gt;☞本小组发言严禁重要剧情透露(若主题涉及剧透，请在主题处标明)，如果发现酌情删除&amp;nbsp;&lt;br /&gt;多次剧透不改者考虑封禁&amp;nbsp;&lt;br /&gt;不欢迎谩骂　&amp;nbsp;&lt;br /&gt;&lt;br /&gt;☞为给大家一个干净纯粹的交流空间，请尽量不要以发布网站链接、图片的形式，进行变相的广告宣传活动，如出现的话会酌情处理。&amp;nbsp;&lt;br /&gt;（我们会定期把下载资源站放在小组介绍处）&amp;nbsp;&lt;br /&gt;&lt;br /&gt;☞广告贴一律删除+举报广告店铺！&amp;nbsp;&lt;br /&gt;&lt;br /&gt;☞不欢迎敏感的政治话题。&amp;nbsp;&lt;br /&gt;&lt;br /&gt;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;nbsp;&lt;br /&gt;许多国内恐怖片在线观看：&amp;nbsp;&lt;br /&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.m1905.com%2Fvod%2Flist%2Ft_6%2Fo1u1p1.html&amp;amp;link2key=3b063982f9&quot;&gt;http://www.m1905.com/vod/list/t_6/o1u1p1.html&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;114恐怖电影下载：&amp;nbsp;&lt;br /&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.3i8i.net%2Flist%2Flist5.html&amp;amp;link2key=3b063982f9&quot;&gt;http://www.3i8i.net/list/list5.html&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;3E恐怖电影下载（速度稳定）：&amp;nbsp;&lt;br /&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.eee4.cc%2Fhtml%2Fkongbu%2Findex.html&amp;amp;link2key=3b063982f9&quot;&gt;http://www.eee4.cc/html/kongbu/index.html&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;博雅在线观看（之前较著名的稀缺恐怖片发行站 支持QVOD）：&amp;nbsp;&lt;br /&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.5944b.com%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://www.5944b.com/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;&lt;br /&gt;&lt;br /&gt;【值得期待的新片】：&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fmovie.douban.com%2Fdoulist%2F730752%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://movie.douban.com/doulist/730752/&lt;/a&gt;&lt;/p&gt;&lt;p&gt;原豆瓣小组：&lt;a href=&quot;http://www.douban.com/group/horrormovies/&quot;&gt;http://www.douban.com/group/horrormovies/&lt;/a&gt;&lt;/p&gt;', 'files/images/groups/group_8.png'),
(10, 2, 14, '吃喝玩乐在上海', 3, '2013-10-22 08:53:13', '&lt;p&gt;独乐乐不如众乐乐，一起来交流【上海】海吃海喝海玩海乐和的经验吧！&amp;nbsp;&lt;br /&gt;&lt;br /&gt;我们都是一群爱&amp;quot;腐败&amp;quot;的家伙~&amp;nbsp;&lt;br /&gt;&lt;br /&gt;我们爱K歌爱泡酒吧爱美食爱旅行~&amp;nbsp;&lt;br /&gt;&lt;br /&gt;没人陪？加入同城的我们吧!&amp;nbsp;&lt;br /&gt;&lt;br /&gt;欢迎大家把自己曾去过、玩过、吃过的好地方都晒出来,一起分享上海吃喝玩乐的好去处！&amp;nbsp;&lt;br /&gt;&lt;br /&gt;*本组并非只是旅游答疑小组。天气着装之类问题在本组问过上百次，其实搜索+经验判断即有答案，不必专门发帖询问。下列FAQ供各位参考：&amp;nbsp;&lt;br /&gt;上海介绍：&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fbaike.baidu.com%2Fview%2F1735.htm&amp;amp;link2key=3b063982f9&quot;&gt;http://baike.baidu.com/view/1735.htm&lt;/a&gt;&amp;nbsp;&lt;br /&gt;上海天气：&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.weather.com.cn%2Fweather%2F101020100.shtml&amp;amp;link2key=3b063982f9&quot;&gt;http://www.weather.com.cn/weather/101020100.shtml&lt;/a&gt;&amp;nbsp;&lt;br /&gt;上海美食：&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.dianping.com%2Fshanghai%2Ffood&amp;amp;link2key=3b063982f9&quot;&gt;http://www.dianping.com/shanghai/food&lt;/a&gt;&amp;nbsp;&lt;br /&gt;上海旅游：&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Flvyou.baidu.com%2Fshanghai%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://lvyou.baidu.com/shanghai/&lt;/a&gt;&amp;nbsp;&lt;/p&gt;&lt;p&gt;原豆瓣小组链接：http://www.douban.com/group/248655/&lt;/p&gt;', 'files/images/groups/group_10.png'),
(11, 1, 1, 'Test group', 1, '2013-10-22 15:18:46', '&lt;p&gt;This is a test group.&lt;/p&gt;&lt;p&gt;&lt;em&gt;&lt;strong&gt;We welcome everybody to join in our group!&lt;/strong&gt;&lt;/em&gt;&lt;/p&gt;', 'files/images/groups/group_11.png'),
(12, 2, 10, '爱旅行爱摄影', 3, '2013-10-22 08:27:32', '&lt;p&gt;&lt;strong&gt;我们爱旅行，我们爱摄影，因为我们爱生活&amp;hellip;&amp;hellip;&amp;nbsp;&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;&lt;br /&gt;鉴于新人进组约伴出游及时发帖的要求，暂时开放不用申请即可加入&amp;hellip;&amp;hellip;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;注意：户外俱乐部广告、频繁自顶贴内容、借贴游记或者摄影内容加网址推广网站帖一律删除，酌情封禁，不单独解释。&amp;nbsp;&lt;br /&gt;&lt;br /&gt;【微米印】- 手机定制照片书工具，摄影控必备App&amp;rarr;&amp;nbsp;&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fgoo.gl%2FWzY2n&amp;amp;link2key=3b063982f9&quot;&gt;http://goo.gl/WzY2n&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;小组官方背包客淘宝店试营业（力荐漂亮行李牌）：&amp;nbsp;&lt;br /&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fibeibao.taobao.com%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://ibeibao.taobao.com/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;（力荐）明信片免费申领活动：&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.douban.com%2Fgroup%2Ftopic%2F37528635%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://www.douban.com/group/topic/37528635/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;爱旅行爱摄影主办方专题页面（在装修中）：&amp;nbsp;&lt;br /&gt;&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.douban.com%2Fhost%2Flvyou%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://www.douban.com/host/lvyou/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;出去旅行喜欢收藏可乐罐子的进来：&amp;nbsp;&lt;br /&gt;&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fsite.douban.com%2F131460%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://site.douban.com/131460/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;爱旅行爱摄影 新浪微博群：&amp;nbsp;&lt;br /&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fq.weibo.com%2F245808&amp;amp;link2key=3b063982f9&quot;&gt;http://q.weibo.com/245808&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;小组优质游记推荐：&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.douban.com%2Fgroup%2Ftopic%2F23637082%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://www.douban.com/group/topic/23637082/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;沙发主人登记汇总：&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.douban.com%2Fgroup%2Ftopic%2F23594578%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://www.douban.com/group/topic/23594578/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;小组成员相册汇总：&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.douban.com%2Fgroup%2Ftopic%2F3005107%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://www.douban.com/group/topic/3005107/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;大家来说说旅途中的雷人雷事：&amp;nbsp;&lt;br /&gt;&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.douban.com%2Fgroup%2Ftopic%2F13469372%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://www.douban.com/group/topic/13469372/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;你是因摄影而去旅行,还是因旅行而摄影呢?&amp;nbsp;&lt;br /&gt;&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.douban.com%2Fgroup%2Ftopic%2F3281670%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://www.douban.com/group/topic/3281670/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;以下，请根据各人特点选择加入（请勿多个同时加入，注意加入条件，加入时无详细说明的申请者均不批准，提供blog或者相册者优先批准，入群后请按要求修改群名片使用默认规范字体发言）：&amp;nbsp;&lt;br /&gt;&lt;br /&gt;印度旅行背包客：96392862（仅限热爱印度人文以及打算、去过印度旅行的同学加入）&amp;nbsp;&lt;br /&gt;旅行摄影（北京群）：3897932（北京的同学请加入，方便活动）&amp;nbsp;&lt;br /&gt;旅行摄影（华东群）：1653181（华东的同学请加入，方便活动）&amp;nbsp;&lt;br /&gt;旅行摄影（不限地域群）：106029788（1000人大群，重点谈旅行，谢绝疯狂灌水，加入时候说明旅行过的地方，疯狂灌水扯聊者直接删除不解释）&amp;nbsp;&lt;br /&gt;海外行摄QQ群：107251272（仅限热衷海外旅行并且有海外旅行经验的朋友加入，入群申请请说明有哪些海外旅行经验。）&amp;nbsp;&lt;br /&gt;&lt;br /&gt;MSN群：msngroup9998@hotmail.com（已满，人口众多，灌水谈生活比较多）&amp;nbsp;&lt;br /&gt;&lt;br /&gt;飞信群：3695910（比较沉默，可能和飞信群还不很流行有关）&amp;nbsp;&lt;br /&gt;&lt;br /&gt;小组主管理员QQ：1417159（添加好友时候务必说明原因）&amp;nbsp;&lt;br /&gt;微博：&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fweibo.com%2Fxiaotao&amp;amp;link2key=3b063982f9&quot;&gt;http://weibo.com/xiaotao&lt;/a&gt;&lt;/p&gt;&lt;p&gt;原豆瓣小组：&lt;a href=&quot;http://www.douban.com/group/lvxing/&quot;&gt;http://www.douban.com/group/lvxing/&lt;/a&gt;&lt;/p&gt;&lt;p&gt;&amp;nbsp;&lt;/p&gt;', 'files/images/groups/group_7.png'),
(13, 1, 36, 'Instagram', 1, '2013-12-05 06:39:25', '&lt;p&gt;Instagram is an online photo-sharing, video-sharing and social networking service that enables its users to take pictures and videos, apply digital filters to them, and share them on a variety of social networking services, such as Facebook, Twitter, Tumblr and Flickr.&lt;/p&gt;', 'files/images/groups/group_13.jpeg'),
(14, 1, 36, 'Tumblr', 1, '2013-12-05 06:41:23', '&lt;p&gt;Tumblr, stylized in its logo as tumblr., is a microblogging platform and social networking website founded by David Karp and owned by Yahoo! Inc. The service allows users to post multimedia and other content to a short-form blog. Users can follow other users&amp;#39; blogs, as well as make their blogs private.[4][5] Much of the website&amp;#39;s features are accessed from the &amp;quot;dashboard&amp;quot; interface, where the option to post content and posts of followed blogs appear.&lt;/p&gt;', 'files/images/groups/group_14.png'),
(15, 1, 51, 'walking dead season 4', 1, '2013-12-05 06:43:55', '&lt;p&gt;《行尸走肉》主要讲述的是主人公Rick是亚特兰大城郊一座小镇的副警长。在执行公务的过程中，Rick遭到枪击，伤势严重，被人紧急送往当地医院进行抢救。当Rick醒来之后，发现医院里已经空无一人。他意识到外面一定出了大事，但又不清楚到底是什么事。全剧围绕主人公Rick在丧尸蔓延、危机四伏的美国四处逃亡时与他的同伴的经历展开，剧情扣人心弦。&lt;/p&gt;', 'files/images/groups/group_15.jpg'),
(16, 1, 1, '绿箭侠 第二季 Arrow Season 2 (2013)', 1, '2013-12-05 06:46:20', '&lt;p&gt;CW热门美剧《绿箭侠》的金童玉女斯蒂芬&amp;middot;阿梅尔和凯蒂&amp;middot;卡西迪声称。两人在剧中本是一对旧情人，不过因为各种原因分手当前任。英雄配美女这样老套的搭配并没有出现在剧中，而是升华为&amp;ldquo;英雄惜英雄&amp;rdquo;&amp;mdash;&amp;mdash;凯蒂饰演绿箭侠前女友Laurel，在剧中表面是一个不向恶势力低头的正义女律师，而 实际上却是超级女英雄&amp;ldquo;黑金丝雀&amp;rdquo;Black Canary。俗话说男女搭配干活不累，男女英雄亦是如此。&lt;/p&gt;', 'files/images/groups/group_16.jpg'),
(17, 1, 51, '魔戒电影三部曲', 2, '2013-12-05 06:49:14', '&lt;p&gt;&lt;strong&gt;魔戒电影三部曲&lt;/strong&gt;包括三部实景真人的奇幻&lt;a class=&quot;new&quot; href=&quot;http://zh.wikipedia.org/w/index.php?title=%E5%8F%B2%E8%A9%A9%E9%9B%BB%E5%BD%B1&amp;amp;action=edit&amp;amp;redlink=1&quot; style=&quot;text-decoration: none; color: rgb(165, 88, 88); background-image: none; background-position: initial initial; background-repeat: initial initial;&quot; title=&quot;史诗电影（页面不存在）&quot;&gt;史诗电影&lt;/a&gt;：《&lt;a class=&quot;mw-redirect&quot; href=&quot;http://zh.wikipedia.org/wiki/%E9%AD%94%E6%88%92%E9%A6%96%E9%83%A8%E6%9B%B2%EF%BC%9A%E9%AD%94%E6%88%92%E7%8F%BE%E8%BA%AB&quot; style=&quot;text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;&quot; title=&quot;指环王：护戒使者&quot;&gt;指环王：护戒使者&lt;/a&gt;》（&lt;a href=&quot;http://zh.wikipedia.org/wiki/2001%E5%B9%B4&quot; style=&quot;text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;&quot; title=&quot;2001年&quot;&gt;2001年&lt;/a&gt;）、《&lt;a class=&quot;mw-redirect&quot; href=&quot;http://zh.wikipedia.org/wiki/%E9%AD%94%E6%88%92%E4%BA%8C%E9%83%A8%E6%9B%B2%EF%BC%9A%E9%9B%99%E5%9F%8E%E5%A5%87%E8%AC%80&quot; style=&quot;text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;&quot; title=&quot;指环王：双塔奇兵&quot;&gt;指环王：双塔奇兵&lt;/a&gt;》（&lt;a href=&quot;http://zh.wikipedia.org/wiki/2002%E5%B9%B4&quot; style=&quot;text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;&quot; title=&quot;2002年&quot;&gt;2002年&lt;/a&gt;）及《&lt;a class=&quot;mw-redirect&quot; href=&quot;http://zh.wikipedia.org/wiki/%E9%AD%94%E6%88%92%E4%B8%89%E9%83%A8%E6%9B%B2%EF%BC%9A%E7%8E%8B%E8%80%85%E5%86%8D%E8%87%A8&quot; style=&quot;text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;&quot; title=&quot;指环王：王者归来&quot;&gt;指环王：王者归来&lt;/a&gt;》（&lt;a href=&quot;http://zh.wikipedia.org/wiki/2003%E5%B9%B4&quot; style=&quot;text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;&quot; title=&quot;2003年&quot;&gt;2003年&lt;/a&gt;）（三部曲常被缩写成&lt;strong&gt;LotR&lt;/strong&gt;，&lt;strong&gt;FotR&lt;/strong&gt;、&lt;strong&gt;TTT&lt;/strong&gt;及&lt;strong&gt;RotK&lt;/strong&gt;分别指三部电影）&lt;a href=&quot;http://zh.wikipedia.org/wiki/%E9%AD%94%E6%88%92%E9%9B%BB%E5%BD%B1%E4%B8%89%E9%83%A8%E6%9B%B2#cite_note-1&quot; style=&quot;text-decoration: none; color: rgb(11, 0, 128); background-image: none; white-space: nowrap; background-position: initial initial; background-repeat: initial initial;&quot;&gt;[1]&lt;/a&gt;。魔戒三部曲是以&lt;a href=&quot;http://zh.wikipedia.org/wiki/J%C2%B7R%C2%B7R%C2%B7%E6%89%98%E5%B0%94%E9%87%91&quot; style=&quot;text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;&quot; title=&quot;J·R·R·托尔金&quot;&gt;J&amp;middot;R&amp;middot;R&amp;middot;托尔金&lt;/a&gt;著作的小说《&lt;a href=&quot;http://zh.wikipedia.org/wiki/%E9%AD%94%E6%88%92&quot; style=&quot;text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;&quot; title=&quot;魔戒&quot;&gt;魔戒&lt;/a&gt;》的三册书改编而成，电影大抵依循小说的主线故事，但也加入了一些新元素及一些偏离原著的情节&lt;a href=&quot;http://zh.wikipedia.org/wiki/%E9%AD%94%E6%88%92%E9%9B%BB%E5%BD%B1%E4%B8%89%E9%83%A8%E6%9B%B2#cite_note-2&quot; style=&quot;text-decoration: none; color: rgb(11, 0, 128); background-image: none; white-space: nowrap; background-position: initial initial; background-repeat: initial initial;&quot;&gt;[2]&lt;/a&gt;。&lt;/p&gt;\r\n\r\n&lt;p&gt;故事背景是虚构的&lt;a href=&quot;http://zh.wikipedia.org/wiki/%E4%B8%AD%E5%9C%9F%E5%A4%A7%E9%99%B8&quot; style=&quot;text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;&quot; title=&quot;中土大陆&quot;&gt;中土大陆&lt;/a&gt;，电影三部曲的焦点都集中在年轻的&lt;a href=&quot;http://zh.wikipedia.org/wiki/%E5%93%88%E6%AF%94%E4%BA%BA&quot; style=&quot;text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;&quot; title=&quot;霍比特人&quot;&gt;霍比特人&lt;/a&gt;&lt;a href=&quot;http://zh.wikipedia.org/wiki/%E4%BD%9B%E7%BD%97%E5%A4%9A%C2%B7%E5%B7%B4%E9%87%91%E6%96%AF&quot; style=&quot;text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;&quot; title=&quot;佛罗多·巴金斯&quot;&gt;佛罗多&amp;middot;巴金斯&lt;/a&gt;及&lt;a href=&quot;http://zh.wikipedia.org/wiki/%E9%AD%94%E6%88%92%E9%81%A0%E5%BE%81%E9%9A%8A&quot; style=&quot;text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;&quot; title=&quot;魔戒远征队&quot;&gt;魔戒远征队&lt;/a&gt;执行摧毁&lt;a href=&quot;http://zh.wikipedia.org/wiki/%E8%87%B3%E5%B0%8A%E9%AD%94%E6%88%92&quot; style=&quot;text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;&quot; title=&quot;至尊魔戒&quot;&gt;至尊魔戒&lt;/a&gt;的任务，以及消灭至尊魔戒的制造者黑暗魔君&lt;a href=&quot;http://zh.wikipedia.org/wiki/%E7%B4%A2%E5%80%AB&quot; style=&quot;text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;&quot; title=&quot;索伦&quot;&gt;索伦&lt;/a&gt;&lt;a href=&quot;http://zh.wikipedia.org/wiki/%E9%AD%94%E6%88%92%E9%9B%BB%E5%BD%B1%E4%B8%89%E9%83%A8%E6%9B%B2#cite_note-3&quot; style=&quot;text-decoration: none; color: rgb(11, 0, 128); background-image: none; white-space: nowrap; background-position: initial initial; background-repeat: initial initial;&quot;&gt;[3]&lt;/a&gt;。随着情节的发展，魔戒远征队分崩析离，佛罗多、他的忠实伙伴&lt;a href=&quot;http://zh.wikipedia.org/wiki/%E5%B1%B1%E5%A7%86%C2%B7%E8%A9%B9%E5%90%89&quot; style=&quot;text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;&quot; title=&quot;山姆·詹吉&quot;&gt;山姆&lt;/a&gt;及奸诈的&lt;a href=&quot;http://zh.wikipedia.org/wiki/%E5%92%95%E5%9A%95&quot; style=&quot;text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;&quot; title=&quot;古鲁姆&quot;&gt;古鲁姆&lt;/a&gt;继续执行任务。同时，巫师&lt;a href=&quot;http://zh.wikipedia.org/wiki/%E7%94%98%E9%81%93%E5%A4%AB&quot; style=&quot;text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;&quot; title=&quot;甘道夫&quot;&gt;甘道夫&lt;/a&gt;、流亡的&lt;a href=&quot;http://zh.wikipedia.org/wiki/%E5%89%9B%E9%90%B8&quot; style=&quot;text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;&quot; title=&quot;刚铎&quot;&gt;刚铎&lt;/a&gt;王位继承者&lt;a href=&quot;http://zh.wikipedia.org/wiki/%E4%BA%9E%E6%8B%89%E5%B2%A1_(%E9%AD%94%E6%88%92)&quot; style=&quot;text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;&quot; title=&quot;阿拉贡 (魔戒)&quot;&gt;阿拉贡&lt;/a&gt;联合中土大陆的自由子民对抗索伦，最终在&lt;a href=&quot;http://zh.wikipedia.org/wiki/%E9%AD%94%E6%88%92%E8%81%96%E6%88%B0&quot; style=&quot;text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;&quot; title=&quot;魔戒圣战&quot;&gt;魔戒圣战&lt;/a&gt;取得胜利。&lt;/p&gt;\r\n\r\n&lt;p&gt;魔戒三部曲由&lt;a href=&quot;http://zh.wikipedia.org/wiki/%E5%BD%BC%E5%BE%97%C2%B7%E6%9D%B0%E5%85%8B%E9%80%8A&quot; style=&quot;text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;&quot; title=&quot;彼得·杰克逊&quot;&gt;彼得&amp;middot;杰克逊&lt;/a&gt;执导，&lt;a href=&quot;http://zh.wikipedia.org/wiki/%E6%96%B0%E7%B7%9A%E5%BD%B1%E6%A5%AD&quot; style=&quot;text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;&quot; title=&quot;新线影业&quot;&gt;新线影业&lt;/a&gt;发行&lt;a href=&quot;http://zh.wikipedia.org/wiki/%E9%AD%94%E6%88%92%E9%9B%BB%E5%BD%B1%E4%B8%89%E9%83%A8%E6%9B%B2#cite_note-4&quot; style=&quot;text-decoration: none; color: rgb(11, 0, 128); background-image: none; white-space: nowrap; background-position: initial initial; background-repeat: initial initial;&quot;&gt;[4]&lt;/a&gt;&lt;a href=&quot;http://zh.wikipedia.org/wiki/%E9%AD%94%E6%88%92%E9%9B%BB%E5%BD%B1%E4%B8%89%E9%83%A8%E6%9B%B2#cite_note-5&quot; style=&quot;text-decoration: none; color: rgb(11, 0, 128); background-image: none; white-space: nowrap; background-position: initial initial; background-repeat: initial initial;&quot;&gt;[5]&lt;/a&gt;。魔戒三部曲被视为规模最宏大的电影之一&lt;a href=&quot;http://zh.wikipedia.org/wiki/%E9%AD%94%E6%88%92%E9%9B%BB%E5%BD%B1%E4%B8%89%E9%83%A8%E6%9B%B2#cite_note-6&quot; style=&quot;text-decoration: none; color: rgb(11, 0, 128); background-image: none; white-space: nowrap; background-position: initial initial; background-repeat: initial initial;&quot;&gt;[6]&lt;/a&gt;，共投入了2.85亿美元，整个电影拍摄计划历时八年，三部电影的拍摄工作都在杰克逊的祖国新西兰进行&lt;a href=&quot;http://zh.wikipedia.org/wiki/%E9%AD%94%E6%88%92%E9%9B%BB%E5%BD%B1%E4%B8%89%E9%83%A8%E6%9B%B2#cite_note-Film-7&quot; style=&quot;text-decoration: none; color: rgb(11, 0, 128); background-image: none; white-space: nowrap; background-position: initial initial; background-repeat: initial initial;&quot;&gt;[7]&lt;/a&gt;。三部曲的每一部电影都有特别加长版，特别加长版在电影公映的一年后以DVD形式发行&lt;a href=&quot;http://zh.wikipedia.org/wiki/%E9%AD%94%E6%88%92%E9%9B%BB%E5%BD%B1%E4%B8%89%E9%83%A8%E6%9B%B2#cite_note-Film-7&quot; style=&quot;text-decoration: none; color: rgb(11, 0, 128); background-image: none; white-space: nowrap; background-position: initial initial; background-repeat: initial initial;&quot;&gt;[7]&lt;/a&gt;。&lt;/p&gt;\r\n\r\n&lt;p&gt;魔戒三部曲取得相当高的电影票房收入，三部电影分别名列&lt;a href=&quot;http://zh.wikipedia.org/wiki/%E6%9C%80%E9%AB%98%E9%9B%BB%E5%BD%B1%E7%A5%A8%E6%88%BF%E6%94%B6%E5%85%A5%E5%88%97%E8%A1%A8&quot; style=&quot;text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;&quot; title=&quot;最高电影票房收入列表&quot;&gt;最高电影票房收入&lt;/a&gt;的第27位、第20位及第6位，排名不考虑通货膨胀&lt;a href=&quot;http://zh.wikipedia.org/wiki/%E9%AD%94%E6%88%92%E9%9B%BB%E5%BD%B1%E4%B8%89%E9%83%A8%E6%9B%B2#cite_note-8&quot; style=&quot;text-decoration: none; color: rgb(11, 0, 128); background-image: none; white-space: nowrap; background-position: initial initial; background-repeat: initial initial;&quot;&gt;[8]&lt;/a&gt;。魔戒三部曲得到好评，在30项&lt;a class=&quot;mw-redirect&quot; href=&quot;http://zh.wikipedia.org/wiki/%E5%A5%A7%E6%96%AF%E5%8D%A1%E9%87%91%E5%83%8F%E7%8D%8E&quot; style=&quot;text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;&quot; title=&quot;奥斯卡金像奖&quot;&gt;奥斯卡金像奖&lt;/a&gt;提名里赢得17项&lt;a href=&quot;http://zh.wikipedia.org/wiki/%E9%AD%94%E6%88%92%E9%9B%BB%E5%BD%B1%E4%B8%89%E9%83%A8%E6%9B%B2#cite_note-9&quot; style=&quot;text-decoration: none; color: rgb(11, 0, 128); background-image: none; white-space: nowrap; background-position: initial initial; background-repeat: initial initial;&quot;&gt;[9]&lt;/a&gt;，电影的演员、创新性的技术运用及&lt;a class=&quot;mw-redirect&quot; href=&quot;http://zh.wikipedia.org/wiki/%E9%9B%BB%E8%85%A6%E7%B9%AA%E5%9C%96&quot; style=&quot;text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;&quot; title=&quot;电脑绘图&quot;&gt;电脑绘图&lt;/a&gt;效果都得到广泛的称赞。而该系列的终结片，《王者归来》，更在十一项奥斯卡奖的提名的基础上获得十一项奖项，成为继《&lt;a href=&quot;http://zh.wikipedia.org/wiki/%E6%B3%B0%E5%9D%A6%E5%B0%BC%E5%85%8B%E5%8F%B7_(1997%E5%B9%B4%E7%94%B5%E5%BD%B1)&quot; style=&quot;text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;&quot; title=&quot;泰坦尼克号 (1997年电影)&quot;&gt;泰坦尼克号&lt;/a&gt;》和《&lt;a href=&quot;http://zh.wikipedia.org/wiki/%E8%B3%93%E6%BC%A2&quot; style=&quot;text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;&quot; title=&quot;宾汉&quot;&gt;宾汉&lt;/a&gt;》外，第三部获得十一项奥斯卡奖的电影。&lt;/p&gt;\r\n\r\n&lt;p&gt;杰克逊又拍摄了前传《&lt;a href=&quot;http://zh.wikipedia.org/wiki/%E9%9C%8D%E6%AF%94%E7%89%B9%E4%BA%BA%E7%94%B5%E5%BD%B1%E7%B3%BB%E5%88%97&quot; style=&quot;text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;&quot; title=&quot;霍比特人电影系列&quot;&gt;霍比特人历险记&lt;/a&gt;》三部，第一部在2012年12月上映&lt;a href=&quot;http://zh.wikipedia.org/wiki/%E9%AD%94%E6%88%92%E9%9B%BB%E5%BD%B1%E4%B8%89%E9%83%A8%E6%9B%B2#cite_note-10&quot; style=&quot;text-decoration: none; color: rgb(11, 0, 128); background-image: none; white-space: nowrap; background-position: initial initial; background-repeat: initial initial;&quot;&gt;[10]&lt;/a&gt;。&lt;/p&gt;', 'files/images/groups/group_17.jpg');

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
(6, 1, '2013-12-05 07:05:54', 1, ''),
(7, 1, '2013-10-22 13:44:54', 1, ''),
(7, 2, '2013-10-22 08:36:32', 1, ''),
(8, 1, '2013-11-21 15:45:49', 1, ''),
(8, 2, '2013-11-19 06:06:00', 1, ''),
(10, 1, '2013-10-22 13:44:49', 1, ''),
(10, 2, '2013-10-22 08:53:13', 1, ''),
(10, 3, '2013-11-19 15:35:00', 1, ''),
(11, 1, '2013-10-22 15:18:46', 1, ''),
(12, 1, '2013-12-05 07:06:03', 1, ''),
(13, 1, '2013-12-05 06:39:25', 1, ''),
(14, 1, '2013-12-05 06:41:23', 1, ''),
(15, 1, '2013-12-05 06:43:55', 1, ''),
(16, 1, '2013-12-05 06:46:20', 1, ''),
(17, 1, '2013-12-05 06:49:14', 1, ''),
(17, 2, '2013-12-05 07:05:47', 1, '');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=111 ;

--
-- 转存表中的数据 `group_messages`
--

INSERT INTO `group_messages` (`msg_id`, `msg_type_id`, `msg_receiver_id`, `msg_sender_id`, `msg_title`, `msg_content`, `msg_status`, `msg_send_time`) VALUES
(4, 1, 3, 0, 'Welcome, Klaus', 'Dear Klaus : &lt;br/&gt;Welcome to join the FDUGroup bit family!&lt;br/&gt;&lt;br/&gt;--- FDUGroup team&lt;br/&gt;', 2, '2013-10-16 17:57:37'),
(5, 1, 3, 1, 'Friend request', 'admin wants to be friends with you.<br/><a  title="Confirm" href="http://localhost/FDUGroup/friend/confirm/1" >Confirm</a><br/><a  title="Decline" href="http://localhost/FDUGroup/friend/decline/1" >Decline</a>', 2, '2013-10-16 18:47:38'),
(6, 1, 1, 3, 'Friend confirmed', 'Klaus has accepted your friend request.', 2, '2013-10-16 18:49:31'),
(8, 1, 2, 1, 'Friend confirmed', 'admin has accepted your friend request.', 3, '2013-10-17 10:41:13'),
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
(26, 1, 2, 6, 'Friend request', 'Stefan wants to be friends with you.<br/><a  title="Confirm" href="http://localhost/FDUGroup/friend/confirm/6" >Confirm</a><br/><a  title="Decline" href="http://localhost/FDUGroup/friend/decline/6" >Decline</a>', 3, '2013-11-20 14:56:10'),
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
(79, 3, 1, 6, 'Join group request accepted', 'Group creator has accepted your request of joining in group <a  title="沉睡谷 Sleepy Hollow" href="http://localhost/FDUGroup/group/detail/6" >沉睡谷 Sleepy Hollow</a>', 3, '2013-11-22 12:46:27'),
(81, 3, 6, 1, 'new group invitation', '&lt;a  title=&quot;admin&quot; href=&quot;http://localhost/FDUGroup/user/view/1&quot; &gt;admin&lt;/a&gt; invited you to join group &lt;a  title=&quot;美剧fans&quot; href=&quot;http://localhost/FDUGroup/group/detail/2&quot; &gt;美剧fans&lt;/a&gt;&amp;nbsp;&amp;nbsp;&lt;a class=&quot;btn btn-xs btn-info&quot;  title=&quot;Accept invitation&quot; href=&quot;http://localhost/FDUGroup/group/join/2&quot; &gt;Accept invitation&lt;/a&gt;&lt;/br&gt;', 1, '2013-11-22 13:05:00'),
(84, 1, 10, 0, 'Welcome Jiankun Lei', 'Dear Jiankun Lei : &lt;br/&gt;Welcome to join the FDUGroup big family!&lt;br/&gt;&lt;br/&gt;--- FDUGroup team&lt;br/&gt;', 1, '2013-11-22 15:31:16'),
(85, 1, 11, 0, 'Welcome Bonne', 'Dear Bonne : &lt;br/&gt;Welcome to join the FDUGroup big family!&lt;br/&gt;&lt;br/&gt;--- &lt;b&gt;FDUGroup team&lt;/b&gt;&lt;br/&gt;2013-11-22 23:32:56', 1, '2013-11-22 15:32:56'),
(86, 1, 2, 0, 'VIP application accepted', 'Congratulations, <a  title="Raysmond" href="http://localhost/FDUGroup/user/view/2" >Raysmond</a>!<br/> Your VIP application is accepted by Administrator.', 1, '2013-11-22 17:03:15'),
(88, 1, 2, 0, 'Groups recommendation', '<div class="row recommend-groups"><div class="col-lg-3 recommend-group-item" style="padding: 5px;"><img src="http://localhost/FDUGroup/public/images/groups/group_1.jpg" title="FDUGroup Developers"  /><br/><a  title="FDUGroup Developers" href="http://localhost/FDUGroup/group/detail/1" >FDUGroup Developers</a><br/><a class="btn btn-xs btn-success"  title="Accept" href="http://localhost/FDUGroup/group/accept/63" >Accept</a></div><div class="col-lg-3 recommend-group-item" style="padding: 5px;"><img src="http://localhost/FDUGroup/public/images/groups/group_2.jpg" title="美剧fans"  /><br/><a  title="美剧fans" href="http://localhost/FDUGroup/group/detail/2" >美剧fans</a><br/><a class="btn btn-xs btn-success"  title="Accept" href="http://localhost/FDUGroup/group/accept/64" >Accept</a></div><div class="col-lg-3 recommend-group-item" style="padding: 5px;"><img src="http://localhost/FDUGroup/public/images/groups/group_4.jpg" title="The Vampire Diaries"  /><br/><a  title="The Vampire Diaries" href="http://localhost/FDUGroup/group/detail/4" >The Vampire Diaries</a><br/><a class="btn btn-xs btn-success"  title="Accept" href="http://localhost/FDUGroup/group/accept/65" >Accept</a></div><div class="col-lg-3 recommend-group-item" style="padding: 5px;"><img src="http://localhost/FDUGroup/public/images/groups/group_6.jpg" title="沉睡谷 Sleepy Hollow"  /><br/><a  title="沉睡谷 Sleepy Hollow" href="http://localhost/FDUGroup/group/detail/6" >沉睡谷 Sleepy Hollow</a><br/><a class="btn btn-xs btn-success"  title="Accept" href="http://localhost/FDUGroup/group/accept/66" >Accept</a></div></div><div class="recommend-content">&lt;p&gt;Hello, guys! Please &lt;strong&gt;join&lt;/strong&gt; the above groups for your interest and good!&amp;nbsp;&lt;img alt=&quot;smiley&quot; src=&quot;http://localhost/FDUGroup/arch/modules/ckeditor/plugins/smiley/images/regular_smile.gif&quot; style=&quot;height:20px; width:20px&quot; title=&quot;smiley&quot; /&gt;&lt;/p&gt;\r\n</div>', 3, '2013-11-24 02:58:54'),
(89, 1, 2, 1, 'Hello, Raysmond', '&lt;blockquote&gt;\r\n&lt;p&gt;&lt;strong&gt;Hello, Raysmond&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;How are you ?&lt;/strong&gt;&lt;/p&gt;\r\n&lt;/blockquote&gt;', 1, '2013-11-24 07:30:10'),
(90, 3, 2, 6, 'Join group request', '<a  title="Raysmond" href="http://localhost/FDUGroup/user/view/2" >Raysmond</a> wants to join your group <a  title="沉睡谷 Sleepy Hollow" href="http://localhost/FDUGroup/group/detail/6" >沉睡谷 Sleepy Hollow</a><br/><a class="btn btn-xs btn-success"  title="Accept" href="http://localhost/FDUGroup/group/accept/67" >Accept</a>&nbsp;&nbsp;<a class="btn btn-xs btn-danger"  title="Decline" href="http://localhost/FDUGroup/group/decline/67" >Decline</a>', 3, '2013-11-25 07:38:01'),
(91, 3, 2, 6, 'Join group request accepted', 'Group creator has accepted your request of joining in group &lt;a  title=&quot;沉睡谷 Sleepy Hollow&quot; href=&quot;http://localhost/FDUGroup/group/detail/6&quot; &gt;沉睡谷 Sleepy Hollow&lt;/a&gt;', 3, '2013-11-25 07:38:31'),
(92, 3, 1, 2, 'Join group request', '<a  title="admin" href="/FDUGroup/user/view/1" >admin</a> wants to join your group <a  title="美剧fans" href="/FDUGroup/group/detail/2" >美剧fans</a><br/><a class="btn btn-xs btn-success"  title="Accept" href="http://localhost/FDUGroup/group/accept/68" >Accept</a>&nbsp;&nbsp;<a class="btn btn-xs btn-danger"  title="Decline" href="http://localhost/FDUGroup/group/decline/68" >Decline</a>', 1, '2013-11-25 10:05:52'),
(93, 1, 12, 0, 'Welcome testuser', 'Dear testuser : &lt;br/&gt;Welcome to join the FDUGroup big family!&lt;br/&gt;&lt;br/&gt;--- &lt;b&gt;FDUGroup team&lt;/b&gt;&lt;br/&gt;2013-11-26 00:34:37', 1, '2013-11-25 16:34:37'),
(94, 1, 13, 0, 'Welcome testuser2', 'Dear testuser2 : &lt;br/&gt;Welcome to join the FDUGroup big family!&lt;br/&gt;&lt;br/&gt;--- &lt;b&gt;FDUGroup team&lt;/b&gt;&lt;br/&gt;2013-11-26 00:35:06', 1, '2013-11-25 16:35:06'),
(95, 1, 14, 0, 'Welcome hello1', 'Dear hello1 : &lt;br/&gt;Welcome to join the FDUGroup big family!&lt;br/&gt;&lt;br/&gt;--- &lt;b&gt;FDUGroup team&lt;/b&gt;&lt;br/&gt;2013-11-26 00:36:29', 1, '2013-11-25 16:36:29'),
(96, 4, 1, 1, 'New reply', 'admin has replied to your comment <a  title="Test topic" href="/FDUGroup/post/view/1?reply=17" >Test topic</a>', 1, '2013-11-26 03:34:01'),
(97, 4, 1, 1, 'New reply', 'admin has replied to your comment <a  title="Test topic" href="/FDUGroup/post/view/1?reply=18" >Test topic</a>', 1, '2013-11-26 03:36:14'),
(98, 3, 2, 12, 'Join group request', '<a  title="admin" href="/FDUGroup/user/view/1" >admin</a> wants to join your group <a  title="爱旅行爱摄影" href="/FDUGroup/group/detail/12" >爱旅行爱摄影</a><br/><a class="btn btn-xs btn-success"  title="Accept" href="/FDUGroup/group/accept/69" >Accept</a>&nbsp;&nbsp;<a class="btn btn-xs btn-danger"  title="Decline" href="/FDUGroup/group/decline/69" >Decline</a>', 2, '2013-12-05 04:04:47'),
(99, 3, 2, 12, 'Join group request', '<a  title="admin" href="/FDUGroup/user/view/1" >admin</a> wants to join your group <a  title="爱旅行爱摄影" href="/FDUGroup/group/detail/12" >爱旅行爱摄影</a><br/><a class="btn btn-xs btn-success"  title="Accept" href="/FDUGroup/group/accept/70" >Accept</a>&nbsp;&nbsp;<a class="btn btn-xs btn-danger"  title="Decline" href="/FDUGroup/group/decline/70" >Decline</a>', 3, '2013-12-05 04:05:14'),
(100, 3, 2, 12, 'Join group request', '<a  title="admin" href="/FDUGroup/user/view/1" >admin</a> wants to join your group <a  title="爱旅行爱摄影" href="/FDUGroup/group/detail/12" >爱旅行爱摄影</a><br/><a class="btn btn-xs btn-success"  title="Accept" href="/FDUGroup/group/accept/71" >Accept</a>&nbsp;&nbsp;<a class="btn btn-xs btn-danger"  title="Decline" href="/FDUGroup/group/decline/71" >Decline</a>', 3, '2013-12-05 04:06:26'),
(101, 3, 2, 6, 'Join group request', '<a  title="admin" href="/FDUGroup/user/view/1" >admin</a> wants to join your group <a  title="沉睡谷 Sleepy Hollow" href="/FDUGroup/group/detail/6" >沉睡谷 Sleepy Hollow</a><br/><a class="btn btn-xs btn-success"  title="Accept" href="/FDUGroup/group/accept/72" >Accept</a>&nbsp;&nbsp;<a class="btn btn-xs btn-danger"  title="Decline" href="/FDUGroup/group/decline/72" >Decline</a>', 2, '2013-12-05 04:06:38'),
(102, 3, 3, 1, 'new group invitation', '&lt;a  title=&quot;admin&quot; href=&quot;/FDUGroup/user/view/1&quot; &gt;admin&lt;/a&gt; invited you to join group &lt;a  title=&quot;魔戒电影三部曲&quot; href=&quot;/FDUGroup/group/detail/17&quot; &gt;魔戒电影三部曲&lt;/a&gt;&amp;nbsp;&amp;nbsp;&lt;a class=&quot;btn btn-xs btn-info&quot;  title=&quot;Accept invitation&quot; href=&quot;/FDUGroup/group/acceptInvite/73&quot; &gt;Accept invitation&lt;/a&gt;&lt;/br&gt;经典的史诗电影！', 1, '2013-12-05 06:58:04'),
(103, 3, 2, 1, 'new group invitation', '&lt;a  title=&quot;admin&quot; href=&quot;/FDUGroup/user/view/1&quot; &gt;admin&lt;/a&gt; invited you to join group &lt;a  title=&quot;魔戒电影三部曲&quot; href=&quot;/FDUGroup/group/detail/17&quot; &gt;魔戒电影三部曲&lt;/a&gt;&amp;nbsp;&amp;nbsp;&lt;a class=&quot;btn btn-xs btn-info&quot;  title=&quot;Accept invitation&quot; href=&quot;/FDUGroup/group/acceptInvite/74&quot; &gt;Accept invitation&lt;/a&gt;&lt;/br&gt;经典的史诗电影！', 2, '2013-12-05 06:58:05'),
(104, 3, 6, 1, 'new group invitation', '&lt;a  title=&quot;admin&quot; href=&quot;/FDUGroup/user/view/1&quot; &gt;admin&lt;/a&gt; invited you to join group &lt;a  title=&quot;魔戒电影三部曲&quot; href=&quot;/FDUGroup/group/detail/17&quot; &gt;魔戒电影三部曲&lt;/a&gt;&amp;nbsp;&amp;nbsp;&lt;a class=&quot;btn btn-xs btn-info&quot;  title=&quot;Accept invitation&quot; href=&quot;/FDUGroup/group/acceptInvite/75&quot; &gt;Accept invitation&lt;/a&gt;&lt;/br&gt;经典的史诗电影！', 1, '2013-12-05 06:58:05'),
(105, 3, 5, 1, 'new group invitation', '&lt;a  title=&quot;admin&quot; href=&quot;/FDUGroup/user/view/1&quot; &gt;admin&lt;/a&gt; invited you to join group &lt;a  title=&quot;魔戒电影三部曲&quot; href=&quot;/FDUGroup/group/detail/17&quot; &gt;魔戒电影三部曲&lt;/a&gt;&amp;nbsp;&amp;nbsp;&lt;a class=&quot;btn btn-xs btn-info&quot;  title=&quot;Accept invitation&quot; href=&quot;/FDUGroup/group/acceptInvite/76&quot; &gt;Accept invitation&lt;/a&gt;&lt;/br&gt;经典的史诗电影！', 1, '2013-12-05 06:58:05'),
(106, 3, 9, 1, 'new group invitation', '&lt;a  title=&quot;admin&quot; href=&quot;/FDUGroup/user/view/1&quot; &gt;admin&lt;/a&gt; invited you to join group &lt;a  title=&quot;魔戒电影三部曲&quot; href=&quot;/FDUGroup/group/detail/17&quot; &gt;魔戒电影三部曲&lt;/a&gt;&amp;nbsp;&amp;nbsp;&lt;a class=&quot;btn btn-xs btn-info&quot;  title=&quot;Accept invitation&quot; href=&quot;/FDUGroup/group/acceptInvite/77&quot; &gt;Accept invitation&lt;/a&gt;&lt;/br&gt;经典的史诗电影！', 1, '2013-12-05 06:58:05'),
(107, 3, 8, 1, 'new group invitation', '&lt;a  title=&quot;admin&quot; href=&quot;/FDUGroup/user/view/1&quot; &gt;admin&lt;/a&gt; invited you to join group &lt;a  title=&quot;魔戒电影三部曲&quot; href=&quot;/FDUGroup/group/detail/17&quot; &gt;魔戒电影三部曲&lt;/a&gt;&amp;nbsp;&amp;nbsp;&lt;a class=&quot;btn btn-xs btn-info&quot;  title=&quot;Accept invitation&quot; href=&quot;/FDUGroup/group/acceptInvite/78&quot; &gt;Accept invitation&lt;/a&gt;&lt;/br&gt;经典的史诗电影！', 1, '2013-12-05 06:58:05'),
(108, 4, 1, 2, 'New Comment', 'Raysmond has replied to your topic <a  title="旅游真爽" href="/FDUGroup/post/view/14?reply=19" >旅游真爽</a>', 1, '2013-12-05 06:58:45'),
(109, 3, 1, 6, 'Join group request accepted', 'Group creator has accepted your request of joining in group &lt;a  title=&quot;沉睡谷 Sleepy Hollow&quot; href=&quot;/FDUGroup/group/detail/6&quot; &gt;沉睡谷 Sleepy Hollow&lt;/a&gt;', 1, '2013-12-05 07:05:54'),
(110, 3, 1, 12, 'Join group request accepted', 'Group creator has accepted your request of joining in group &lt;a  title=&quot;爱旅行爱摄影&quot; href=&quot;/FDUGroup/group/detail/12&quot; &gt;爱旅行爱摄影&lt;/a&gt;', 1, '2013-12-05 07:06:03');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- 转存表中的数据 `group_rating`
--

INSERT INTO `group_rating` (`rating_id`, `entity_type`, `entity_id`, `value`, `value_type`, `tag`, `u_id`, `host`, `timestamp`) VALUES
(1, 1, 14, 1, 'integer', 'plus', 2, '::1', '2013-12-01 01:18:32'),
(2, 1, 13, 1, 'integer', 'plus', 2, '::1', '2013-12-01 01:18:33'),
(3, 1, 11, 1, 'integer', 'plus', 2, '::1', '2013-12-01 01:18:34'),
(4, 1, 10, 1, 'integer', 'plus', 2, '::1', '2013-12-01 01:18:36'),
(5, 1, 9, 1, 'integer', 'plus', 2, '::1', '2013-12-01 01:18:37'),
(6, 1, 10, 1, 'integer', 'plus', 1, '::1', '2013-12-01 01:19:24'),
(7, 1, 9, 1, 'integer', 'plus', 1, '::1', '2013-12-01 01:19:30'),
(8, 2, 153, 1, 'integer', 'plus', 1, '::1', '2013-12-04 21:16:39'),
(9, 2, 152, 1, 'integer', 'plus', 1, '::1', '2013-12-04 21:16:46'),
(10, 2, 154, 1, 'integer', 'plus', 1, '::1', '2013-12-04 21:20:13'),
(11, 2, 151, 1, 'integer', 'plus', 1, '::1', '2013-12-04 21:20:26'),
(12, 2, 149, 1, 'integer', 'plus', 1, '::1', '2013-12-04 21:20:32'),
(13, 2, 150, 1, 'integer', 'plus', 1, '::1', '2013-12-04 21:20:48'),
(14, 2, 155, 1, 'integer', 'plus', 1, '::1', '2013-12-04 21:21:05'),
(15, 2, 144, 1, 'integer', 'plus', 1, '::1', '2013-12-04 21:22:37'),
(16, 1, 4, 1, 'integer', 'plus', 1, '::1', '2013-12-04 21:38:40'),
(17, 2, 11, 1, 'integer', 'plus', 1, '::1', '2013-12-04 22:33:49'),
(18, 2, 5, 1, 'integer', 'plus', 1, '::1', '2013-12-04 22:33:52'),
(19, 2, 6, 1, 'integer', 'plus', 1, '::1', '2013-12-04 22:33:56'),
(20, 2, 21, 1, 'integer', 'plus', 1, '::1', '2013-12-04 22:35:05'),
(21, 2, 35, 1, 'integer', 'plus', 1, '::1', '2013-12-04 22:35:07'),
(22, 1, 6, 1, 'integer', 'plus', 2, '::1', '2013-12-05 00:34:17'),
(23, 1, 7, 1, 'integer', 'plus', 1, '::1', '2013-12-05 02:00:31'),
(24, 1, 5, 1, 'integer', 'plus', 1, '::1', '2013-12-05 02:00:46'),
(25, 2, 8, 1, 'integer', 'plus', 1, '::1', '2013-12-05 11:39:41'),
(26, 1, 8, 1, 'integer', 'plus', 1, '::1', '2013-12-05 11:44:50'),
(27, 1, 1, 1, 'integer', 'plus', 1, '::1', '2013-12-05 12:46:54'),
(28, 1, 14, 1, 'integer', 'plus', 1, '::1', '2013-12-05 12:55:59'),
(29, 1, 3, 1, 'integer', 'plus', 1, '::1', '2013-12-05 13:54:40'),
(30, 2, 13, 1, 'integer', 'plus', 1, '::1', '2013-12-05 14:39:41'),
(31, 2, 16, 1, 'integer', 'plus', 1, '::1', '2013-12-05 14:51:22'),
(32, 2, 17, 1, 'integer', 'plus', 1, '::1', '2013-12-05 14:51:22');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- 转存表中的数据 `group_rating_statistic`
--

INSERT INTO `group_rating_statistic` (`stat_id`, `stat_type`, `entity_type`, `entity_id`, `value_type`, `value`, `tag`, `timestamp`) VALUES
(1, 'count', 1, 14, 'integer', 2, 'plus', '2013-12-05 04:55:59'),
(2, 'count', 1, 13, 'integer', 1, 'plus', '2013-11-30 17:18:33'),
(3, 'count', 1, 11, 'integer', 1, 'plus', '2013-11-30 17:18:34'),
(4, 'count', 1, 10, 'integer', 2, 'plus', '2013-11-30 17:19:24'),
(5, 'count', 1, 9, 'integer', 2, 'plus', '2013-11-30 17:19:30'),
(6, 'count', 2, 153, 'integer', 1, 'plus', '2013-12-04 13:16:39'),
(7, 'count', 2, 152, 'integer', 1, 'plus', '2013-12-04 13:16:46'),
(8, 'count', 2, 154, 'integer', 1, 'plus', '2013-12-04 13:20:13'),
(9, 'count', 2, 151, 'integer', 1, 'plus', '2013-12-04 13:20:26'),
(10, 'count', 2, 149, 'integer', 1, 'plus', '2013-12-04 13:20:32'),
(11, 'count', 2, 150, 'integer', 1, 'plus', '2013-12-04 13:20:48'),
(12, 'count', 2, 155, 'integer', 1, 'plus', '2013-12-04 13:21:05'),
(13, 'count', 2, 144, 'integer', 1, 'plus', '2013-12-04 13:22:37'),
(14, 'count', 1, 4, 'integer', 1, 'plus', '2013-12-04 13:38:40'),
(15, 'count', 2, 11, 'integer', 1, 'plus', '2013-12-04 14:33:49'),
(16, 'count', 2, 5, 'integer', 1, 'plus', '2013-12-04 14:33:52'),
(17, 'count', 2, 6, 'integer', 1, 'plus', '2013-12-04 14:33:56'),
(18, 'count', 2, 21, 'integer', 1, 'plus', '2013-12-04 14:35:05'),
(19, 'count', 2, 35, 'integer', 1, 'plus', '2013-12-04 14:35:07'),
(20, 'count', 1, 6, 'integer', 1, 'plus', '2013-12-04 16:34:17'),
(21, 'count', 1, 7, 'integer', 1, 'plus', '2013-12-04 18:00:31'),
(22, 'count', 1, 5, 'integer', 1, 'plus', '2013-12-04 18:00:46'),
(23, 'count', 2, 8, 'integer', 1, 'plus', '2013-12-05 03:39:41'),
(24, 'count', 1, 8, 'integer', 1, 'plus', '2013-12-05 03:44:50'),
(25, 'count', 1, 1, 'integer', 1, 'plus', '2013-12-05 04:46:54'),
(26, 'count', 1, 3, 'integer', 1, 'plus', '2013-12-05 05:54:40'),
(27, 'count', 2, 13, 'integer', 1, 'plus', '2013-12-05 06:39:41'),
(28, 'count', 2, 16, 'integer', 1, 'plus', '2013-12-05 06:51:22'),
(29, 'count', 2, 17, 'integer', 1, 'plus', '2013-12-05 06:51:22');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `group_syslog`
--

INSERT INTO `group_syslog` (`log_id`, `u_id`, `type`, `message`, `severity`, `path`, `referer_uri`, `host`, `timestamp`) VALUES
(1, 1, 'system', 'Page not found!', 1, 'category/groups', 'http://localhost/FDUGroup/category/groups/1', '::1', '2013-12-04 14:25:20'),
(2, 1, 'system', 'Page not found!', 1, 'category/groups', 'http://localhost/FDUGroup/category/groups/1', '::1', '2013-12-04 14:25:20'),
(3, 1, 'system', 'Page not found!', 1, 'category/groups', 'http://localhost/FDUGroup/category/groups/1', '::1', '2013-12-04 14:25:20'),
(4, 1, 'system', 'Page not found!', 1, 'category/groups', 'http://localhost/FDUGroup/category/groups/1', '::1', '2013-12-04 14:25:20'),
(5, 1, 'system', 'Page not found!', 1, 'category/groups', 'http://localhost/FDUGroup/category/groups/1', '::1', '2013-12-04 14:27:42'),
(6, 1, 'system', 'Page not found!', 1, 'category/groups', 'http://localhost/FDUGroup/category/groups/1', '::1', '2013-12-04 14:27:42'),
(7, 1, 'system', 'Page not found!', 1, 'category/groups', 'http://localhost/FDUGroup/category/groups/1', '::1', '2013-12-04 14:27:42'),
(8, 1, 'system', 'Page not found!', 1, 'category/groups', 'http://localhost/FDUGroup/category/groups/1', '::1', '2013-12-04 14:27:42'),
(9, 1, 'system', 'Page not found!', 1, 'category/groups', 'http://localhost/FDUGroup/category/groups/1', '::1', '2013-12-04 14:29:04'),
(10, 1, 'system', 'Page not found!', 1, 'category/groups', 'http://localhost/FDUGroup/category/groups/1', '::1', '2013-12-04 14:29:04'),
(11, 1, 'system', 'Page not found!', 1, 'category/groups', 'http://localhost/FDUGroup/category/groups/1', '::1', '2013-12-04 14:29:04'),
(12, 1, 'system', 'Page not found!', 1, 'category/groups', 'http://localhost/FDUGroup/category/groups/1', '::1', '2013-12-04 14:29:04');

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
(7, 2, 1, 'The vampire diaries S05', '2013-10-22 15:16:21', '&lt;p&gt;The vampire diaries S05 now returned.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;http://img31.mtime.cn/CMS/Gallery/2013/09/16/093927.83154902_900.jpg&quot; style=&quot;height:354px; width:500px&quot; /&gt;&lt;/p&gt;\r\n', '2013-11-22 10:28:35', 2),
(8, 2, 1, 'Sleep Hollow S01', '2013-10-22 15:16:38', '&lt;p&gt;Sleep Hollow S01&lt;/p&gt;', '2013-10-22 15:16:38', 0),
(9, 4, 2, 'It’s always nice to have someone in your life', '2013-11-19 05:58:01', '&lt;p&gt;It&amp;rsquo;s always nice to have someone in your life who can make you smile even when they&amp;rsquo;re not around. 生命中，有些人即使不在你身边，也能让你微笑。这样真好。 &amp;mdash;&amp;mdash; 《&lt;a href=&quot;http://huati.weibo.com/k/%E5%90%B8%E8%A1%80%E9%AC%BC%E6%97%A5%E8%AE%B0?from=501&quot;&gt;#吸血鬼日记#&lt;/a&gt;》&lt;/p&gt;', '2013-11-19 05:58:01', 0),
(10, 4, 1, '《吸血鬼日记》 TXT 中英文下载', '2013-11-20 13:53:58', '&lt;ul&gt;\r\n	&lt;li&gt;中英文小说1~4部&amp;nbsp;&lt;/li&gt;\r\n	&lt;li&gt;这是下载页面：&amp;nbsp;&lt;br /&gt;\r\n	&lt;a href=&quot;http://www.rayfile.com/zh-cn/files/2793bd57-eb23-11df-925f-0015c55db73d/a1c5a521/&quot; target=&quot;_blank&quot;&gt;http://www.rayfile.com/zh-cn/files/2793bd57-eb23-11df-925f-0015c55db73d/a1c5a521/&lt;/a&gt;&lt;/li&gt;\r\n&lt;/ul&gt;\r\n', '2013-11-20 13:56:19', 1),
(11, 4, 1, 'Katherine', '2013-11-20 13:55:35', '&lt;p&gt;头发变白，掉了牙齿，总是感到饥饿。可怜的人类。&lt;/p&gt;', '2013-11-20 13:55:35', 0),
(13, 7, 2, '旅行的心情', '2013-11-25 07:18:27', '&lt;blockquote&gt;\r\n&lt;p&gt;&lt;strong&gt;旅行的心情很重要&lt;/strong&gt;&lt;/p&gt;\r\n&lt;/blockquote&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;&lt;img alt=&quot;&quot; src=&quot;http://distilleryimage4.ak.instagram.com/3504a0e25d0111e38ee312c5088542ac_7.jpg&quot; style=&quot;height:612px; width:612px&quot; /&gt;&lt;/strong&gt;&lt;/p&gt;\r\n', '2013-11-25 07:18:27', 0),
(14, 7, 1, '旅游真爽', '2013-11-25 07:34:57', '&lt;p&gt;&lt;strong&gt;旅游真爽&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong style=&quot;line-height:1.6em&quot;&gt;​&lt;img alt=&quot;&quot; src=&quot;http://distilleryimage5.ak.instagram.com/50bc45405c3b11e389ef12ac79f96301_8.jpg&quot; /&gt;&lt;/strong&gt;&lt;/p&gt;\r\n', '2013-12-05 06:58:45', 1);

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
(2, 4, 'Raysmond', 'jiankunlei@126.com', '96e79218965eb72c92a549dd5a330112', 'shanghai', '18801734441', '913282582', 'http://weibo.com/leijiankun', '2013-10-16 16:29:20', 1, 'files/images/users/pic_u_2.jpg', '"The task was appointed to you. If you do not find a way, no one will."', 'http://raysmond.com', 0, 1, 0),
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
(2, '', 2, 0, '2013-12-05 07:01:52');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
