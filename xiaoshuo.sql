-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2018-05-31 19:24:53
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
-- 表的结构 `books`
--

CREATE TABLE IF NOT EXISTS `books` (
  `bookid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `originalurl` varchar(300) NOT NULL,
  `bookname` varchar(30) NOT NULL,
  `isshow` tinyint(4) NOT NULL,
  `issort` int(11) NOT NULL,
  `description` int(11) NOT NULL,
  `author` varchar(20) NOT NULL,
  `bojiang` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `lastupdate` int(11) NOT NULL,
  `cover` varchar(200) NOT NULL,
  `ctime` int(11) NOT NULL,
  PRIMARY KEY (`bookid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `books`
--

INSERT INTO `books` (`bookid`, `category_id`, `originalurl`, `bookname`, `isshow`, `issort`, `description`, `author`, `bojiang`, `status`, `lastupdate`, `cover`, `ctime`) VALUES
(1, 0, '', '', 0, 0, 0, '', '', '', 0, '', 1527778700),
(2, 0, '', '', 0, 0, 0, '', '', '', 0, '', 1527778702),
(3, 0, '', '', 0, 0, 0, '', '', '', 0, '', 1527778705),
(4, 0, '', '', 0, 0, 0, '', '', '', 0, '', 1527778710),
(5, 0, '', '', 0, 0, 0, '', '', '', 0, '', 1527778711),
(6, 0, '', '', 0, 0, 0, '', '', '', 0, '', 1527778766),
(7, 0, '', '', 0, 0, 0, '', '', '', 0, '', 1527778853),
(8, 0, '', '', 0, 0, 0, '', '', '', 0, '', 1527778855),
(9, 0, '', '', 0, 0, 0, '', '', '', 0, '', 1527778856),
(10, 0, '', '', 0, 0, 0, '', '', '', 0, '', 1527778857),
(11, 0, '', '', 0, 0, 0, '', '', '', 0, '', 1527778858);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- 转存表中的数据 `category`
--

INSERT INTO `category` (`category_id`, `issort`, `name`, `isshow`, `ctime`) VALUES
(1, 0, '武侠', 0, 1527701963),
(2, 0, '仙侠', 0, 1527702045),
(3, 0, '搞笑', 0, 1527702118),
(4, 0, '都市', 0, 1527702368),
(5, 0, '言情', 0, 1527702495),
(6, 0, '', 0, 1527703632),
(7, 0, '', 0, 1527703696),
(8, 0, '', 0, 1527703743),
(9, 0, '', 0, 1527703748),
(10, 0, '', 0, 1527778955),
(11, 0, '', 0, 1527779234),
(12, 0, '', 0, 1527779241),
(13, 0, '', 0, 1527779246),
(14, 0, '', 0, 1527779313);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
