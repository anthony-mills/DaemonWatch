-- phpMyAdmin SQL Dump
-- version 3.3.7deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 30, 2011 at 02:22 PM
-- Server version: 5.1.49
-- PHP Version: 5.3.3-1ubuntu9.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `serverwatch`
--

-- --------------------------------------------------------

--
-- Table structure for table `application_logs`
--

CREATE TABLE IF NOT EXISTS `application_logs` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `log_level` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `user_id` int(10) NOT NULL,
  `timestamp` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=82 ;

-- --------------------------------------------------------

--
-- Table structure for table `hosts`
--

CREATE TABLE IF NOT EXISTS `hosts` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `hostname` varchar(200) NOT NULL,
  `user_id` bigint(10) NOT NULL,
  `created` int(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `port` smallint(5) NOT NULL,
  `created` int(15) NOT NULL,
  `updated` int(15) NOT NULL,
  `user_id` int(10) NOT NULL,
  `host_id` int(10) NOT NULL,
  `frequency` int(10) NOT NULL,
  `sms` int(1) DEFAULT '0',
  `active` int(1) NOT NULL DEFAULT '1',
  `checked` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_hosts` (`id`),
  KEY `FK_services` (`host_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `service_checks`
--

CREATE TABLE IF NOT EXISTS `service_checks` (
  `id` bigint(30) NOT NULL AUTO_INCREMENT,
  `host_id` bigint(10) NOT NULL,
  `service_id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `checked` int(20) NOT NULL,
  `timetaken` decimal(20,2) NOT NULL,
  `result` int(11) NOT NULL,
  `node` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=161 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) NOT NULL,
  `salt` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `user_role` int(4) NOT NULL,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(200) NOT NULL,
  `max_hosts` int(10) NOT NULL,
  `max_services` int(20) NOT NULL,
  `sms_credits` int(11) DEFAULT '0',
  `active` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_action_logs`
--

CREATE TABLE IF NOT EXISTS `user_action_logs` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `log_level` varchar(20) NOT NULL,
  `description` varchar(200) NOT NULL,
  `user_id` int(10) NOT NULL,
  `timestamp` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=77 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE IF NOT EXISTS `user_roles` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `value` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `FK_services` FOREIGN KEY (`host_id`) REFERENCES `hosts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

INSERT INTO `users` (`id`, `email`, `salt`, `password`, `user_role`, `first_name`, `last_name`, `max_hosts`, `max_services`, `sms_credits`, `active`) VALUES
(1, 'test@test.com', '3PC3UOPS4KWSUJWNHS6E0FMK8TULA4KBTUCRJ4KMMHHI3E6K7A', '0ed7c2d147a9bb18f5d0f02693bba7fa6c11cd3b', 1, 'Jim', 'Davis', 5, 10, 0, 1);
