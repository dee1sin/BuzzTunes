-- phpMyAdmin SQL Dump
-- version 4.4.15
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 09, 2016 at 11:52 AM
-- Server version: 5.5.46
-- PHP Version: 5.4.45

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `TUNES_mu sic`
--

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `groupid` int(11) NOT NULL,
  `groupname` varchar(500) NOT NULL,
  `permission` varchar(500) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `log_activity`
--

CREATE TABLE IF NOT EXISTS `log_activity` (
  `activityid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `reason` varchar(5000) NOT NULL,
  `logid` int(11) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `log_browser_os`
--

CREATE TABLE IF NOT EXISTS `log_browser_os` (
  `id` int(11) NOT NULL,
  `browsername` varchar(1000) NOT NULL,
  `browserversion` varchar(1000) NOT NULL,
  `os` varchar(1000) NOT NULL,
  `desktop_mobile` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `log_ip`
--

CREATE TABLE IF NOT EXISTS `log_ip` (
  `id` int(11) NOT NULL,
  `ip1` varchar(50) NOT NULL,
  `ip2` varchar(50) NOT NULL,
  `browserid` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `bot` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `log_query_error`
--

CREATE TABLE IF NOT EXISTS `log_query_error` (
  `queryid` int(11) NOT NULL,
  `query` varchar(5000) NOT NULL,
  `error` varchar(5000) NOT NULL,
  `page` varchar(1000) NOT NULL,
  `seen` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `get_params` varchar(4000) NOT NULL,
  `post_params` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `music`
--

CREATE TABLE IF NOT EXISTS `music` (
  `musicid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `music` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `img` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `waveimg` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `title` varchar(500) COLLATE utf8_turkish_ci NOT NULL,
  `name` varchar(500) COLLATE utf8_turkish_ci NOT NULL,
  `time` int(11) NOT NULL,
  `descrption` varchar(3000) COLLATE utf8_turkish_ci NOT NULL,
  `url` varchar(1000) COLLATE utf8_turkish_ci NOT NULL,
  `wave_progress` int(11) NOT NULL DEFAULT '0',
  `view` int(11) NOT NULL DEFAULT '0',
  `logid` int(11) NOT NULL DEFAULT '0',
  `privacy` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `music_like`
--

CREATE TABLE IF NOT EXISTS `music_like` (
  `saveid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `musicid` int(11) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `playlist`
--

CREATE TABLE IF NOT EXISTS `playlist` (
  `id` int(11) NOT NULL,
  `playlistid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `musicid` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `logid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `playlistname`
--

CREATE TABLE IF NOT EXISTS `playlistname` (
  `playlistid` int(11) NOT NULL,
  `name` varchar(1000) NOT NULL,
  `userid` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `privacy` int(11) NOT NULL,
  `logid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE IF NOT EXISTS `tag` (
  `tagid` int(11) NOT NULL,
  `tagname` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `musicid` int(11) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usersignup`
--

CREATE TABLE IF NOT EXISTS `usersignup` (
  `userid` int(11) NOT NULL,
  `username` varchar(100) COLLATE utf8_turkish_ci DEFAULT NULL,
  `password` varchar(1000) COLLATE utf8_turkish_ci DEFAULT NULL,
  `img` varchar(1000) COLLATE utf8_turkish_ci DEFAULT 'default.jpg',
  `logininfo` varchar(1000) COLLATE utf8_turkish_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_turkish_ci DEFAULT NULL,
  `status` tinyint(4) DEFAULT '0',
  `time` int(11) DEFAULT NULL,
  `groups` tinyint(4) DEFAULT '1',
  `cover` varchar(500) COLLATE utf8_turkish_ci NOT NULL DEFAULT 'cover.jpg',
  `logid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`groupid`);

--
-- Indexes for table `log_activity`
--
ALTER TABLE `log_activity`
  ADD PRIMARY KEY (`activityid`);

--
-- Indexes for table `log_browser_os`
--
ALTER TABLE `log_browser_os`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_ip`
--
ALTER TABLE `log_ip`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_query_error`
--
ALTER TABLE `log_query_error`
  ADD PRIMARY KEY (`queryid`);

--
-- Indexes for table `music`
--
ALTER TABLE `music`
  ADD PRIMARY KEY (`musicid`);

--
-- Indexes for table `music_like`
--
ALTER TABLE `music_like`
  ADD PRIMARY KEY (`saveid`);

--
-- Indexes for table `playlist`
--
ALTER TABLE `playlist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `playlistname`
--
ALTER TABLE `playlistname`
  ADD PRIMARY KEY (`playlistid`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`tagid`);

--
-- Indexes for table `usersignup`
--
ALTER TABLE `usersignup`
  ADD PRIMARY KEY (`userid`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `groupid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `log_activity`
--
ALTER TABLE `log_activity`
  MODIFY `activityid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `log_browser_os`
--
ALTER TABLE `log_browser_os`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `log_ip`
--
ALTER TABLE `log_ip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `log_query_error`
--
ALTER TABLE `log_query_error`
  MODIFY `queryid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `music`
--
ALTER TABLE `music`
  MODIFY `musicid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `music_like`
--
ALTER TABLE `music_like`
  MODIFY `saveid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `playlist`
--
ALTER TABLE `playlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `playlistname`
--
ALTER TABLE `playlistname`
  MODIFY `playlistid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `tagid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `usersignup`
--
ALTER TABLE `usersignup`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
