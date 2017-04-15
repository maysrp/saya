-- phpMyAdmin SQL Dump
-- version 4.4.15.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2017-04-15 14:07:54
-- 服务器版本： 5.5.48-log
-- PHP Version: 5.6.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dplayer`
--

-- --------------------------------------------------------

--
-- 表的结构 `think_danmu`
--

CREATE TABLE IF NOT EXISTS `think_danmu` (
  `_id` int(11) NOT NULL,
  `__v` int(11) NOT NULL,
  `author` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  `time` varchar(64) NOT NULL,
  `text` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  `color` varchar(64) NOT NULL,
  `type` varchar(64) NOT NULL,
  `player` varchar(64) NOT NULL,
  `ip` varchar(64) NOT NULL,
  `atime` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `think_danmu`
--
ALTER TABLE `think_danmu`
  ADD PRIMARY KEY (`_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `think_danmu`
--
ALTER TABLE `think_danmu`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
