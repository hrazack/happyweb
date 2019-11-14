-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:33067
-- Generation Time: Nov 14, 2019 at 08:40 PM
-- Server version: 5.6.40-log
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `happyweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `col`
--

CREATE TABLE IF NOT EXISTS `col` (
  `id` int(11) NOT NULL,
  `row_id` int(11) NOT NULL,
  `col_index` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `col`
--

INSERT INTO `col` (`id`, `row_id`, `col_index`) VALUES
(1, 2, 1),
(2, 2, 2),
(3, 2, 3),
(4, 1, 1),
(5, 1, 2),
(6, 1, 3),
(7, 3, 1),
(8, 3, 2),
(9, 3, 3),
(10, 4, 1),
(11, 4, 2),
(12, 4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `description` mediumtext CHARACTER SET latin1 NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `date`, `description`, `user_id`) VALUES
(1, 1499980563, 'signed out', 1),
(2, 1499980578, 'signed in', 1),
(3, 1499980682, 'signed out', 1),
(4, 1499980696, 'signed in', 1);

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

CREATE TABLE IF NOT EXISTS `page` (
  `id` int(11) NOT NULL,
  `title` varchar(400) CHARACTER SET latin1 NOT NULL,
  `url` varchar(400) CHARACTER SET latin1 NOT NULL,
  `description` varchar(400) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `browser_title` varchar(400) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `parent` int(11) NOT NULL DEFAULT '-1',
  `display_order` int(2) NOT NULL DEFAULT '0',
  `hidden` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `page`
--

INSERT INTO `page` (`id`, `title`, `url`, `description`, `browser_title`, `parent`, `display_order`, `hidden`) VALUES
(1, 'Home', 'home', '', '', 0, 0, 0),
(2, 'Page not found', 'page-not-found', '', '', -1, 0, 0),
(3, 'About us', 'about', '', '', 0, 1, 0),
(4, 'Contact us', 'contact-us', '', '', 0, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `row`
--

CREATE TABLE IF NOT EXISTS `row` (
  `id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `row_index` int(2) NOT NULL DEFAULT '0',
  `columns_size` varchar(200) CHARACTER SET latin1 NOT NULL DEFAULT 'one',
  `number_of_columns` int(2) NOT NULL DEFAULT '1',
  `heading` varchar(400) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `no_padding` int(2) NOT NULL DEFAULT '0',
  `center_heading` int(2) NOT NULL DEFAULT '0',
  `hidden` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `row`
--

INSERT INTO `row` (`id`, `page_id`, `row_index`, `columns_size`, `number_of_columns`, `heading`, `no_padding`, `center_heading`, `hidden`) VALUES
(1, 1, 1, 'two-large-small', 2, '', 0, 0, 0),
(2, 2, 1, 'two-large-small', 2, 'Oops...', 0, 0, 0),
(3, 3, 1, 'two', 2, '', 0, 0, 0),
(4, 4, 1, 'two-large-small', 2, '', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `name` varchar(400) CHARACTER SET latin1 NOT NULL,
  `value` varchar(400) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`name`, `value`) VALUES
('404_page_id', '2'),
('colour_footer_bg', ''),
('colour_footer_text', ''),
('colour_h1', ''),
('colour_h2', ''),
('colour_h3', ''),
('colour_header_bg', ''),
('colour_header_text', ''),
('colour_links', ''),
('colour_nav_bg', ''),
('colour_nav_text', ''),
('current_update', '21'),
('footer_text', 'Copyright 2019 Happy Web'),
('home_page_id', '1'),
('side_nav_heading', 'Also see:'),
('site_name', 'Happy Web'),
('theme', 'happy_web');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `username` varchar(400) CHARACTER SET latin1 NOT NULL,
  `password` varchar(400) CHARACTER SET latin1 NOT NULL,
  `email` varchar(400) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`) VALUES
(1, 'Hubert', '$2y$10$/ObuTVoQz/4xjAGiadOEHuZ.F7lT7D2acy0nYusapiObAWJR4D.Zu', ''),
(2, 'admin', '$2y$10$7.Kxnz42I9rk2xz/4ZECVOpJfnu48bep81MkVTTj1ibAD.q8Fk2Ya', '');

-- --------------------------------------------------------

--
-- Table structure for table `widget`
--

CREATE TABLE IF NOT EXISTS `widget` (
  `id` int(11) NOT NULL,
  `col_id` varchar(11) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `widget_index` int(2) NOT NULL DEFAULT '0',
  `type` varchar(200) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `widget`
--

INSERT INTO `widget` (`id`, `col_id`, `widget_index`, `type`) VALUES
(1, '1', 1, 'text'),
(2, '4', 1, 'text'),
(3, '7', 1, 'text'),
(4, '10', 1, 'text');

-- --------------------------------------------------------

--
-- Table structure for table `widget_audio`
--

CREATE TABLE IF NOT EXISTS `widget_audio` (
  `widget_id` int(11) NOT NULL,
  `file` varchar(400) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `title` varchar(400) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `description` mediumtext CHARACTER SET latin1 NOT NULL,
  `url` varchar(400) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `type` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT 'upload'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `widget_code`
--

CREATE TABLE IF NOT EXISTS `widget_code` (
  `widget_id` int(11) NOT NULL,
  `filename` varchar(255) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `widget_form`
--

CREATE TABLE IF NOT EXISTS `widget_form` (
  `widget_id` int(11) NOT NULL,
  `name_from` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `email_from` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `email_to` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `submit_text` varchar(400) CHARACTER SET latin1 NOT NULL,
  `message` mediumtext CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `widget_image`
--

CREATE TABLE IF NOT EXISTS `widget_image` (
  `widget_id` int(11) NOT NULL,
  `file` varchar(400) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `size` varchar(100) CHARACTER SET latin1 NOT NULL DEFAULT 'large',
  `description` mediumtext CHARACTER SET latin1 NOT NULL,
  `align` varchar(400) CHARACTER SET latin1 NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `widget_imagelink`
--

CREATE TABLE IF NOT EXISTS `widget_imagelink` (
  `widget_id` int(11) NOT NULL,
  `file` varchar(400) CHARACTER SET latin1 NOT NULL,
  `heading` varchar(400) CHARACTER SET latin1 NOT NULL,
  `text` mediumtext CHARACTER SET latin1 NOT NULL,
  `url` varchar(400) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `widget_navigation`
--

CREATE TABLE IF NOT EXISTS `widget_navigation` (
  `widget_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `widget_quote`
--

CREATE TABLE IF NOT EXISTS `widget_quote` (
  `widget_id` int(11) NOT NULL,
  `text` mediumtext CHARACTER SET latin1 NOT NULL,
  `author` varchar(400) CHARACTER SET latin1 NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `widget_slideshow`
--

CREATE TABLE IF NOT EXISTS `widget_slideshow` (
  `widget_id` int(11) NOT NULL,
  `filenames` mediumtext CHARACTER SET latin1 NOT NULL,
  `disable_slideshow` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `widget_text`
--

CREATE TABLE IF NOT EXISTS `widget_text` (
  `widget_id` int(11) NOT NULL,
  `text` mediumtext CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `widget_text`
--

INSERT INTO `widget_text` (`widget_id`, `text`) VALUES
(1, '<p>It appears that this page was not found...</p><a href="/">Go back to the home page</a><p></p>'),
(2, '<p>Welcome to your new website!</p>\r\n<h2>&nbsp;</h2>'),
(3, '<p>Some content for this page</p>'),
(4, '<p>Some content for the contact us page</p>');

-- --------------------------------------------------------

--
-- Table structure for table `widget_video`
--

CREATE TABLE IF NOT EXISTS `widget_video` (
  `widget_id` int(11) NOT NULL,
  `video_url` varchar(400) CHARACTER SET latin1 NOT NULL,
  `video_description` varchar(400) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `popup` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `col`
--
ALTER TABLE `col`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `row`
--
ALTER TABLE `row`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `name_2` (`name`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `widget`
--
ALTER TABLE `widget`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `widget_audio`
--
ALTER TABLE `widget_audio`
  ADD UNIQUE KEY `widget_id` (`widget_id`);

--
-- Indexes for table `widget_image`
--
ALTER TABLE `widget_image`
  ADD UNIQUE KEY `widget_id` (`widget_id`);

--
-- Indexes for table `widget_navigation`
--
ALTER TABLE `widget_navigation`
  ADD UNIQUE KEY `widget_id` (`widget_id`);

--
-- Indexes for table `widget_quote`
--
ALTER TABLE `widget_quote`
  ADD UNIQUE KEY `widget_id` (`widget_id`);

--
-- Indexes for table `widget_slideshow`
--
ALTER TABLE `widget_slideshow`
  ADD UNIQUE KEY `widget_id` (`widget_id`);

--
-- Indexes for table `widget_text`
--
ALTER TABLE `widget_text`
  ADD UNIQUE KEY `id` (`widget_id`);

--
-- Indexes for table `widget_video`
--
ALTER TABLE `widget_video`
  ADD UNIQUE KEY `widget_id` (`widget_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `col`
--
ALTER TABLE `col`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `page`
--
ALTER TABLE `page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `row`
--
ALTER TABLE `row`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `widget`
--
ALTER TABLE `widget`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
