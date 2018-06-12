-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2018-06-12 18:48:01
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `xiaoshuo`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `loginphone` varchar(11) NOT NULL,
  `password` varchar(64) NOT NULL,
  `ctime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`id`, `username`, `loginphone`, `password`, `ctime`) VALUES
(1, '管理员', '15920581277', '39f1204e8fd1073baf9e4ef922f8f4b4', 1528131576);

-- --------------------------------------------------------

--
-- 表的结构 `books`
--

CREATE TABLE IF NOT EXISTS `books` (
  `bookid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `setid` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `originalurl` varchar(300) NOT NULL,
  `bookname` varchar(30) NOT NULL,
  `isshow` tinyint(4) NOT NULL,
  `issort` int(11) NOT NULL,
  `description` varchar(500) NOT NULL,
  `author` varchar(20) NOT NULL,
  `bojiang` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `lastupdate` int(11) NOT NULL,
  `cover` varchar(200) NOT NULL,
  `ctime` int(11) NOT NULL,
  `todayrecommend` tinyint(4) NOT NULL,
  PRIMARY KEY (`bookid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `books`
--

INSERT INTO `books` (`bookid`, `setid`, `category_id`, `originalurl`, `bookname`, `isshow`, `issort`, `description`, `author`, `bojiang`, `status`, `lastupdate`, `cover`, `ctime`, `todayrecommend`) VALUES
(1, 0, 1, 'http://www.ting56.com/mp3/3178.html', '女配修仙记', 1, 0, '一边是传说中玛丽苏的女主——机遇无敌;一边是现实里的果断型女主——气运冲天，夹在其中的穿越“炮灰女”连葭葭决定保持距离是基础，努力升级是必须，扮猪吃老虎是王道!诸星元张了张嘴，多说多错，他识趣的闭上了嘴，葭葭笑过之后，也停了下来。仍然是来时的路，几人自应声墙里头出来的时候，时间已然不早了，与顾朗、秦雅告了个别，葭葭便回了自己的院子。转动了防护法阵，葭葭隐入空间之中，才一进去，就见玄灵不知从哪儿找了块巨石坐了下来，若非混沌遗世里头没有晨昏，葭葭倒是觉得，他这副悠闲的样子，配上夕阳的背景还是颇妙的。“坐。”见她进……', '漫漫步归', '猫小白', '', 1528816254, 'http://www.ting56.com/pic/images/2014-4/201441423403516054.jpg', 1528816254, 1),
(2, 15516, 1, 'http://www.ting56.com/mp3/15516.html', '妖怪记事簿', 1, 0, '妖怪的世界，比人类进步，还是……比人类进步的多？大唐年间，唐僧远行留学天竺，可一身金贵的肉，让多少妖怪垂涎？绝世妖王孙悟空叛变妖族，妖怪界的偶像空缺有谁来填补？', '敦煌', '从容不惑', '', 1528819587, 'http://www.ting56.com/pic/images/2018-4/20184217302795437.jpg', 1528819587, 0);

-- --------------------------------------------------------

--
-- 表的结构 `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `issort` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `isshow` tinyint(4) NOT NULL,
  `ctime` int(11) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `category`
--

INSERT INTO `category` (`category_id`, `issort`, `name`, `isshow`, `ctime`) VALUES
(1, 0, '玄幻武侠', 1, 1528816138),
(2, 0, '都市言情', 1, 1528816172);

-- --------------------------------------------------------

--
-- 表的结构 `voicelist`
--

CREATE TABLE IF NOT EXISTS `voicelist` (
  `voiceid` int(11) NOT NULL AUTO_INCREMENT,
  `defindex` int(11) NOT NULL,
  `voice` varchar(300) NOT NULL,
  `setid` int(11) NOT NULL,
  `bookid` int(11) NOT NULL,
  PRIMARY KEY (`voiceid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
