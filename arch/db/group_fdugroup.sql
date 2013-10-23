-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 23, 2013 at 06:19 AM
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
-- Table structure for table `group_category`
--

CREATE TABLE IF NOT EXISTS `group_category` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(45) NOT NULL,
  `cat_pid` int(11) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=48 ;

--
-- Dumping data for table `group_category`
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
-- Table structure for table `group_comment`
--

CREATE TABLE IF NOT EXISTS `group_comment` (
  `com_id` int(11) NOT NULL AUTO_INCREMENT,
  `com_pid` int(11) NOT NULL,
  `top_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `com_created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `com_content` text NOT NULL,
  PRIMARY KEY (`com_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `group_comment`
--

INSERT INTO `group_comment` (`com_id`, `com_pid`, `top_id`, `u_id`, `com_created_time`, `com_content`) VALUES
(5, 0, 2, 1, '2013-10-17 10:10:15', 'asdfad'),
(6, 0, 3, 1, '2013-10-19 12:52:19', 'hello'),
(7, 0, 1, 1, '2013-10-22 15:24:08', 'This is a comment!'),
(8, 0, 1, 1, '2013-10-22 15:24:22', 'This is a another comment.');

-- --------------------------------------------------------

--
-- Table structure for table `group_entity_type`
--

CREATE TABLE IF NOT EXISTS `group_entity_type` (
  `typ_id` int(11) NOT NULL AUTO_INCREMENT,
  `typ_name` varchar(45) NOT NULL,
  PRIMARY KEY (`typ_id`),
  UNIQUE KEY `typ_name_UNIQUE` (`typ_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `group_entity_type`
--

INSERT INTO `group_entity_type` (`typ_id`, `typ_name`) VALUES
(2, 'group'),
(1, 'topic');

-- --------------------------------------------------------

--
-- Table structure for table `group_friends`
--

CREATE TABLE IF NOT EXISTS `group_friends` (
  `f_id` int(11) NOT NULL AUTO_INCREMENT,
  `f_uid` int(11) NOT NULL,
  `f_fid` int(11) NOT NULL,
  PRIMARY KEY (`f_id`),
  KEY `f_uid` (`f_uid`),
  KEY `f_fid` (`f_fid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `group_friends`
--

INSERT INTO `group_friends` (`f_id`, `f_uid`, `f_fid`) VALUES
(1, 3, 1),
(2, 1, 3),
(3, 1, 2),
(4, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `group_groups`
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
-- Dumping data for table `group_groups`
--

INSERT INTO `group_groups` (`gro_id`, `gro_creator`, `cat_id`, `gro_name`, `gro_member_count`, `gro_created_time`, `gro_intro`, `gro_picture`) VALUES
(1, 1, 1, 'FDUGroup Developers', 1, '2013-10-16 16:29:20', 'We develop wonderful web applications.', 'public/images/groups/group_1.jpg'),
(2, 1, 11, '美剧fans', 1, '2013-10-16 17:32:39', '美剧迷们请在此聚集！ Game of Thrones, The Big Bang Theory, Breaking bad, How I met your mother, 2 Broke Girls, Frie...', 'public/images/groups/group_2.jpg'),
(3, 1, 6, '张江campus', 1, '2013-10-16 17:34:35', '我们在张江职业技术学校！', 'public/images/groups/group_3.jpg'),
(4, 1, 11, 'The Vampire Diaries', 1, '2013-10-16 17:35:40', 'The Vampire Diaries is a supernatural drama television series developed by Kevin Williamson and Julie Plec, based on the book series of the same name written by L. J. Smith. The series premiered on The CW on September 10, 2009. The series takes place in Mystic Falls, Virginia, a fictional small town haunted by supernatural beings. The series narrative follows the protagonist Elena Gilbert (Nina Dobrev) as she falls in love with vampire Stefan Salvatore (Paul Wesley) and is drawn into the supernatural world as a result. As the series progresses, Elena finds herself drawn to Stefan&#039;s brother Damon Salvatore (Ian Somerhalder) resulting in a love triangle. As the narrative develops in the course of the series, the focal point shifts on the mysterious past of the town involving Elena&#039;s malevolent doppelgänger Katerina Petrova and the family of Original Vampires, all of which have an evil agenda of their own.', 'public/images/groups/group_4.jpg'),
(5, 1, 1, 'test group', 1, '2013-10-17 08:42:33', '&lt;p&gt;test&lt;/p&gt;&lt;p&gt;this is a test intro&lt;/p&gt;', ''),
(6, 2, 1, '沉睡谷 Sleepy Hollow', 2, '2013-10-22 08:18:14', '&lt;p&gt;官方网站:&amp;nbsp;&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.fox.com%2Fsleepy-hollow%2F&amp;amp;link2key=3b063982f9&quot;&gt;www.fox.com/sleepy-hollow/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;当你在痛苦中死去，却又在250年之后的未来时代突然醒来，那会是怎样一种情况？当你发现不可想象的事件导致世界正处在毁灭的边缘，而你自己是人类最后的希望，你会怎么做？&amp;nbsp;&lt;br /&gt;&lt;br /&gt;FOX科幻新剧#沉睡谷#（Sleepy Hollow），讲述沉睡多年的乔治华盛顿部下大战复活的无头骑士的故事。&lt;/p&gt;', 'public/images/groups/group_6.jpg'),
(7, 2, 10, '爱旅行爱摄影', 2, '2013-10-22 08:27:32', '&lt;p&gt;&lt;strong&gt;我们爱旅行，我们爱摄影，因为我们爱生活&amp;hellip;&amp;hellip;&amp;nbsp;&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;&lt;br /&gt;鉴于新人进组约伴出游及时发帖的要求，暂时开放不用申请即可加入&amp;hellip;&amp;hellip;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;注意：户外俱乐部广告、频繁自顶贴内容、借贴游记或者摄影内容加网址推广网站帖一律删除，酌情封禁，不单独解释。&amp;nbsp;&lt;br /&gt;&lt;br /&gt;【微米印】- 手机定制照片书工具，摄影控必备App&amp;rarr;&amp;nbsp;&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fgoo.gl%2FWzY2n&amp;amp;link2key=3b063982f9&quot;&gt;http://goo.gl/WzY2n&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;小组官方背包客淘宝店试营业（力荐漂亮行李牌）：&amp;nbsp;&lt;br /&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fibeibao.taobao.com%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://ibeibao.taobao.com/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;（力荐）明信片免费申领活动：&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.douban.com%2Fgroup%2Ftopic%2F37528635%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://www.douban.com/group/topic/37528635/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;爱旅行爱摄影主办方专题页面（在装修中）：&amp;nbsp;&lt;br /&gt;&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.douban.com%2Fhost%2Flvyou%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://www.douban.com/host/lvyou/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;出去旅行喜欢收藏可乐罐子的进来：&amp;nbsp;&lt;br /&gt;&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fsite.douban.com%2F131460%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://site.douban.com/131460/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;爱旅行爱摄影 新浪微博群：&amp;nbsp;&lt;br /&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fq.weibo.com%2F245808&amp;amp;link2key=3b063982f9&quot;&gt;http://q.weibo.com/245808&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;小组优质游记推荐：&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.douban.com%2Fgroup%2Ftopic%2F23637082%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://www.douban.com/group/topic/23637082/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;沙发主人登记汇总：&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.douban.com%2Fgroup%2Ftopic%2F23594578%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://www.douban.com/group/topic/23594578/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;小组成员相册汇总：&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.douban.com%2Fgroup%2Ftopic%2F3005107%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://www.douban.com/group/topic/3005107/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;大家来说说旅途中的雷人雷事：&amp;nbsp;&lt;br /&gt;&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.douban.com%2Fgroup%2Ftopic%2F13469372%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://www.douban.com/group/topic/13469372/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;你是因摄影而去旅行,还是因旅行而摄影呢?&amp;nbsp;&lt;br /&gt;&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.douban.com%2Fgroup%2Ftopic%2F3281670%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://www.douban.com/group/topic/3281670/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;以下，请根据各人特点选择加入（请勿多个同时加入，注意加入条件，加入时无详细说明的申请者均不批准，提供blog或者相册者优先批准，入群后请按要求修改群名片使用默认规范字体发言）：&amp;nbsp;&lt;br /&gt;&lt;br /&gt;印度旅行背包客：96392862（仅限热爱印度人文以及打算、去过印度旅行的同学加入）&amp;nbsp;&lt;br /&gt;旅行摄影（北京群）：3897932（北京的同学请加入，方便活动）&amp;nbsp;&lt;br /&gt;旅行摄影（华东群）：1653181（华东的同学请加入，方便活动）&amp;nbsp;&lt;br /&gt;旅行摄影（不限地域群）：106029788（1000人大群，重点谈旅行，谢绝疯狂灌水，加入时候说明旅行过的地方，疯狂灌水扯聊者直接删除不解释）&amp;nbsp;&lt;br /&gt;海外行摄QQ群：107251272（仅限热衷海外旅行并且有海外旅行经验的朋友加入，入群申请请说明有哪些海外旅行经验。）&amp;nbsp;&lt;br /&gt;&lt;br /&gt;MSN群：msngroup9998@hotmail.com（已满，人口众多，灌水谈生活比较多）&amp;nbsp;&lt;br /&gt;&lt;br /&gt;飞信群：3695910（比较沉默，可能和飞信群还不很流行有关）&amp;nbsp;&lt;br /&gt;&lt;br /&gt;小组主管理员QQ：1417159（添加好友时候务必说明原因）&amp;nbsp;&lt;br /&gt;微博：&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fweibo.com%2Fxiaotao&amp;amp;link2key=3b063982f9&quot;&gt;http://weibo.com/xiaotao&lt;/a&gt;&lt;/p&gt;&lt;p&gt;原豆瓣小组：&lt;a href=&quot;http://www.douban.com/group/lvxing/&quot;&gt;http://www.douban.com/group/lvxing/&lt;/a&gt;&lt;/p&gt;&lt;p&gt;&amp;nbsp;&lt;/p&gt;', 'public/images/groups/group_7.png'),
(8, 2, 11, '恐怖电影', 1, '2013-10-22 08:31:27', '&lt;p&gt;&lt;span style=&quot;line-height:1.6em&quot;&gt;小组主群：100075281&amp;nbsp;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;br /&gt;✪加入小组请先设好头像，谢谢✪&amp;nbsp;&lt;br /&gt;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;牛逼论坛/小组（众多珍贵稀缺资源）：&amp;nbsp;&lt;br /&gt;&lt;br /&gt;夜半子不语&amp;nbsp;&lt;br /&gt;&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fsite.douban.com%2F119603%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://site.douban.com/119603/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;非常恐怖电影首发站&amp;nbsp;&lt;br /&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.fckb.net%2Fforum.php&amp;amp;link2key=3b063982f9&quot;&gt;http://www.fckb.net/forum.php&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;老片分享&amp;nbsp;&lt;br /&gt;&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.douban.com%2Fgroup%2F182931%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://www.douban.com/group/182931/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;nbsp;&lt;br /&gt;☞本小组发言严禁重要剧情透露(若主题涉及剧透，请在主题处标明)，如果发现酌情删除&amp;nbsp;&lt;br /&gt;多次剧透不改者考虑封禁&amp;nbsp;&lt;br /&gt;不欢迎谩骂　&amp;nbsp;&lt;br /&gt;&lt;br /&gt;☞为给大家一个干净纯粹的交流空间，请尽量不要以发布网站链接、图片的形式，进行变相的广告宣传活动，如出现的话会酌情处理。&amp;nbsp;&lt;br /&gt;（我们会定期把下载资源站放在小组介绍处）&amp;nbsp;&lt;br /&gt;&lt;br /&gt;☞广告贴一律删除+举报广告店铺！&amp;nbsp;&lt;br /&gt;&lt;br /&gt;☞不欢迎敏感的政治话题。&amp;nbsp;&lt;br /&gt;&lt;br /&gt;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;mdash;&amp;nbsp;&lt;br /&gt;许多国内恐怖片在线观看：&amp;nbsp;&lt;br /&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.m1905.com%2Fvod%2Flist%2Ft_6%2Fo1u1p1.html&amp;amp;link2key=3b063982f9&quot;&gt;http://www.m1905.com/vod/list/t_6/o1u1p1.html&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;114恐怖电影下载：&amp;nbsp;&lt;br /&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.3i8i.net%2Flist%2Flist5.html&amp;amp;link2key=3b063982f9&quot;&gt;http://www.3i8i.net/list/list5.html&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;3E恐怖电影下载（速度稳定）：&amp;nbsp;&lt;br /&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.eee4.cc%2Fhtml%2Fkongbu%2Findex.html&amp;amp;link2key=3b063982f9&quot;&gt;http://www.eee4.cc/html/kongbu/index.html&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;博雅在线观看（之前较著名的稀缺恐怖片发行站 支持QVOD）：&amp;nbsp;&lt;br /&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.5944b.com%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://www.5944b.com/&lt;/a&gt;&amp;nbsp;&lt;br /&gt;&lt;br /&gt;&lt;br /&gt;&lt;br /&gt;【值得期待的新片】：&lt;a href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fmovie.douban.com%2Fdoulist%2F730752%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://movie.douban.com/doulist/730752/&lt;/a&gt;&lt;/p&gt;&lt;p&gt;原豆瓣小组：&lt;a href=&quot;http://www.douban.com/group/horrormovies/&quot;&gt;http://www.douban.com/group/horrormovies/&lt;/a&gt;&lt;/p&gt;', 'public/images/groups/group_8.png'),
(10, 2, 14, '吃喝玩乐在上海', 2, '2013-10-22 08:53:13', '&lt;p&gt;独乐乐不如众乐乐，一起来交流【上海】海吃海喝海玩海乐和的经验吧！&amp;nbsp;&lt;br /&gt;&lt;br /&gt;我们都是一群爱&amp;quot;腐败&amp;quot;的家伙~&amp;nbsp;&lt;br /&gt;&lt;br /&gt;我们爱K歌爱泡酒吧爱美食爱旅行~&amp;nbsp;&lt;br /&gt;&lt;br /&gt;没人陪？加入同城的我们吧!&amp;nbsp;&lt;br /&gt;&lt;br /&gt;欢迎大家把自己曾去过、玩过、吃过的好地方都晒出来,一起分享上海吃喝玩乐的好去处！&amp;nbsp;&lt;br /&gt;&lt;br /&gt;*本组并非只是旅游答疑小组。天气着装之类问题在本组问过上百次，其实搜索+经验判断即有答案，不必专门发帖询问。下列FAQ供各位参考：&amp;nbsp;&lt;br /&gt;上海介绍：&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fbaike.baidu.com%2Fview%2F1735.htm&amp;amp;link2key=3b063982f9&quot;&gt;http://baike.baidu.com/view/1735.htm&lt;/a&gt;&amp;nbsp;&lt;br /&gt;上海天气：&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.weather.com.cn%2Fweather%2F101020100.shtml&amp;amp;link2key=3b063982f9&quot;&gt;http://www.weather.com.cn/weather/101020100.shtml&lt;/a&gt;&amp;nbsp;&lt;br /&gt;上海美食：&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Fwww.dianping.com%2Fshanghai%2Ffood&amp;amp;link2key=3b063982f9&quot;&gt;http://www.dianping.com/shanghai/food&lt;/a&gt;&amp;nbsp;&lt;br /&gt;上海旅游：&lt;a target=&quot;_blank&quot; href=&quot;http://www.douban.com/link2?url=http%3A%2F%2Flvyou.baidu.com%2Fshanghai%2F&amp;amp;link2key=3b063982f9&quot;&gt;http://lvyou.baidu.com/shanghai/&lt;/a&gt;&amp;nbsp;&lt;/p&gt;&lt;p&gt;原豆瓣小组链接：http://www.douban.com/group/248655/&lt;/p&gt;', 'public/images/groups/group_10.png'),
(11, 1, 1, 'Test group', 1, '2013-10-22 15:18:46', '&lt;p&gt;This is a test group.&lt;/p&gt;&lt;p&gt;&lt;em&gt;&lt;strong&gt;We welcome everybody to join in our group!&lt;/strong&gt;&lt;/em&gt;&lt;/p&gt;', 'public/images/groups/group_11.png');

-- --------------------------------------------------------

--
-- Table structure for table `group_group_has_group`
--

CREATE TABLE IF NOT EXISTS `group_group_has_group` (
  `group_id1` int(11) NOT NULL,
  `group_id2` int(11) NOT NULL,
  PRIMARY KEY (`group_id1`,`group_id2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `group_group_has_users`
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
-- Dumping data for table `group_group_has_users`
--

INSERT INTO `group_group_has_users` (`gro_id`, `u_id`, `join_time`, `status`, `join_comment`) VALUES
(1, 1, '2013-10-16 16:29:20', 1, NULL),
(2, 1, '2013-10-16 17:32:39', 1, ''),
(3, 1, '2013-10-17 09:39:16', 1, ''),
(4, 1, '2013-10-16 17:35:40', 1, ''),
(5, 1, '2013-10-17 08:42:33', 1, ''),
(6, 1, '2013-10-23 03:17:33', 1, ''),
(7, 1, '2013-10-22 13:44:54', 1, ''),
(7, 2, '2013-10-22 08:36:32', 1, ''),
(10, 1, '2013-10-22 13:44:49', 1, ''),
(10, 2, '2013-10-22 08:53:13', 1, ''),
(11, 1, '2013-10-22 15:18:46', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `group_messages`
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `group_messages`
--

INSERT INTO `group_messages` (`msg_id`, `msg_type_id`, `msg_receiver_id`, `msg_sender_id`, `msg_title`, `msg_content`, `msg_status`, `msg_send_time`) VALUES
(1, 4, 1, 2, 'hello', 'a message from user', 2, '2013-10-16 16:29:20'),
(2, 1, 1, 0, 'system notification', 'a system notification', 1, '2013-10-16 16:29:20'),
(3, 1, 1, 0, 'welcome', 'a welcome message', 2, '2013-10-16 16:29:20'),
(4, 1, 3, 0, 'Welcome, Klaus', 'Dear Klaus : &lt;br/&gt;Welcome to join the FDUGroup bit family!&lt;br/&gt;&lt;br/&gt;--- FDUGroup team&lt;br/&gt;', 2, '2013-10-16 17:57:37'),
(5, 1, 3, 1, 'Friend request', 'admin wants to be friends with you.<br/><a  title="Confirm" href="http://localhost/FDUGroup/friend/confirm/1" >Confirm</a><br/><a  title="Decline" href="http://localhost/FDUGroup/friend/decline/1" >Decline</a>', 2, '2013-10-16 18:47:38'),
(6, 1, 1, 3, 'Friend confirmed', 'Klaus has accepted your friend request.', 1, '2013-10-16 18:49:31'),
(7, 1, 1, 2, 'Friend request', 'Raysmond wants to be friends with you.<br/><a  title="Confirm" href="http://localhost/FDUGroup/friend/confirm/2" >Confirm</a><br/><a  title="Decline" href="http://localhost/FDUGroup/friend/decline/2" >Decline</a>', 2, '2013-10-17 10:40:59'),
(8, 1, 2, 1, 'Friend confirmed', 'admin has accepted your friend request.', 2, '2013-10-17 10:41:13'),
(9, 4, 2, 1, 'Hello, Raysmond', 'Nice to meet you!', 1, '2013-10-22 15:22:45');

-- --------------------------------------------------------

--
-- Table structure for table `group_message_type`
--

CREATE TABLE IF NOT EXISTS `group_message_type` (
  `msg_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `msg_type_name` varchar(45) NOT NULL,
  PRIMARY KEY (`msg_type_id`),
  UNIQUE KEY `msg_type_name_UNIQUE` (`msg_type_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `group_message_type`
--

INSERT INTO `group_message_type` (`msg_type_id`, `msg_type_name`) VALUES
(3, 'group'),
(2, 'private'),
(1, 'system'),
(4, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `group_tag`
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
-- Table structure for table `group_topic`
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `group_topic`
--

INSERT INTO `group_topic` (`top_id`, `gro_id`, `u_id`, `top_title`, `top_created_time`, `top_content`, `top_last_comment_time`, `top_comment_count`) VALUES
(1, 1, 1, 'Test topic', '2013-10-16 18:32:10', '&lt;p&gt;This is a test topic.&lt;/p&gt;&lt;p&gt;&lt;strong&gt;Hello,World!&lt;/strong&gt;&lt;/p&gt;', '2013-10-22 15:24:22', 2),
(2, 1, 1, 'Test topic 1', '2013-10-16 18:32:10', 'test', '2013-10-17 10:10:15', 2),
(3, 4, 1, 'Test post', '2013-10-19 12:52:13', '&lt;p&gt;a test post.&lt;/p&gt;&lt;p&gt;&amp;nbsp;&lt;/p&gt;', '2013-10-19 12:52:19', 1),
(4, 1, 1, 'Test', '2013-10-19 13:16:15', '&lt;p&gt;test&lt;/p&gt;', '2013-10-19 13:16:15', 0),
(5, 6, 2, '沉睡谷 第一季的剧情简介', '2013-10-22 08:19:39', '&lt;p&gt;&amp;nbsp; &amp;nbsp; &amp;nbsp; 1781年，美国独立战争期间。乔治&amp;middot;华盛顿麾下的伊卡博德&amp;middot;克兰上尉（汤姆&amp;middot;米森 Tom Mison 饰）在战场上砍掉了一个手执利斧的面具骑士的头颅，自己也身负重伤失去意识。当他再度醒来，发现周遭早已翻天覆地，此时他正处在250年后的现代化美国社会。与此同时，断头谷治安官被残忍杀害，他的搭档艾比&amp;middot;米尔斯（妮可&amp;middot;贝哈瑞 Nicole Beharie 饰）意外邂逅伊卡博德，进而得知杀害治安官的正是阴森的无头骑士。伊卡博德了解到妻子卡特里娜（卡蒂亚&amp;middot;温特 Katia Winter 饰）在他受伤后所做的一切，并从圣经的记载中意识到邪恶的天启四骑士即将和来自地狱的邪魔军团莅临人间。在此之后，死亡和杀戮在断头谷肆意蔓延，女巫、血咒、恶魔，种种鬼魅迷雾萦绕着美国的历史，从古至今，影响深远&amp;hellip;&amp;hellip;&amp;nbsp;&lt;br /&gt;　　本片根据华盛顿&amp;middot;欧文创作的《断头谷传奇》改编。&lt;/p&gt;', '2013-10-22 08:19:39', 0),
(6, 8, 2, '一起看看《招魂》2013 英文名《The conjuring》', '2013-10-22 08:32:49', '&lt;p&gt;没看过的，赶紧看看吧！&lt;/p&gt;', '2013-10-22 08:32:49', 0),
(7, 2, 1, 'The vampire diaries S05', '2013-10-22 15:16:21', '&lt;p&gt;The vampire diaries S05 now returned.&lt;/p&gt;', '2013-10-22 15:16:21', 0),
(8, 2, 1, 'Sleep Hollow S01', '2013-10-22 15:16:38', '&lt;p&gt;Sleep Hollow S01&lt;/p&gt;', '2013-10-22 15:16:38', 0);

-- --------------------------------------------------------

--
-- Table structure for table `group_users`
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `group_users`
--

INSERT INTO `group_users` (`u_id`, `u_role_id`, `u_name`, `u_mail`, `u_password`, `u_region`, `u_mobile`, `u_qq`, `u_weibo`, `u_register_time`, `u_status`, `u_picture`, `u_intro`, `u_homepage`, `u_credits`, `u_permission`, `u_privacy`) VALUES
(1, 1, 'admin', 'admin@fudan.edu.cn', '96e79218965eb72c92a549dd5a330112', 'shanghai', NULL, NULL, NULL, '0000-00-00 00:00:00', 1, 'public/images/users/pic_u_1.jpg', NULL, NULL, 0, NULL, NULL),
(2, 2, 'Raysmond', 'jiankunlei@126.com', '', 'shanghai', '18801734441', '913282582', 'http://weibo.com/leijiankun', '2013-10-16 16:29:20', 1, 'public/images/users/pic_u_2.jpg', 'hello', 'http://raysmond.com', 0, 0, 0),
(3, 2, 'Klaus', 'klaus@fdugroup.com', '96e79218965eb72c92a549dd5a330112', '', '', '', '', '2013-10-16 17:57:37', 1, '', '', '', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `group_user_role`
--

CREATE TABLE IF NOT EXISTS `group_user_role` (
  `rol_id` int(11) NOT NULL AUTO_INCREMENT,
  `rol_name` varchar(45) NOT NULL,
  PRIMARY KEY (`rol_id`),
  UNIQUE KEY `rol_name_UNIQUE` (`rol_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `group_user_role`
--

INSERT INTO `group_user_role` (`rol_id`, `rol_name`) VALUES
(1, 'administrator'),
(3, 'anonymous user'),
(2, 'authenticated user'),
(4, 'vip user');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `group_friends`
--
ALTER TABLE `group_friends`
  ADD CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`f_uid`) REFERENCES `group_users` (`u_id`),
  ADD CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`f_fid`) REFERENCES `group_users` (`u_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
