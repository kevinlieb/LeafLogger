-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 22, 2014 at 05:18 PM
-- Server version: 5.0.89
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `leaflogs`
--

-- --------------------------------------------------------

--
-- Table structure for table `evstatus`
--

CREATE TABLE IF NOT EXISTS `evstatus` (
  `evstatus_id` int(11) NOT NULL auto_increment,
  `evstatus_users_id` int(11) NOT NULL,
  `evstatus_locked` int(1) NOT NULL,
  PRIMARY KEY  (`evstatus_id`),
  KEY `evstatus_id` (`evstatus_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `leaflogs`
--

CREATE TABLE IF NOT EXISTS `leaflogs` (
  `leaflogs_id` int(11) NOT NULL auto_increment,
  `leaflogs_user_id` int(11) NOT NULL,
  `leaflogs_ignore` tinyint(1) NOT NULL,
  `leaflogs_elevation_checked` tinyint(1) NOT NULL,
  `leaflogs_timestamp` datetime NOT NULL,
  `leaflogs_lat` decimal(9,6) NOT NULL,
  `leaflogs_lon` decimal(9,6) NOT NULL,
  `leaflogs_elevation` int(11) NOT NULL,
  `leaflogs_elevation_lookedup` decimal(8,3) NOT NULL,
  `leaflogs_speed` int(11) NOT NULL,
  `leaflogs_gids` int(11) NOT NULL,
  `leaflogs_soc` int(11) NOT NULL,
  `leaflogs_ahr` int(11) NOT NULL,
  `leaflogs_pack_volts` decimal(9,6) NOT NULL,
  `leaflogs_pack_amps` decimal(9,6) NOT NULL,
  `leaflogs_max_cp_mv` int(11) NOT NULL,
  `leaflogs_min_cp_mv` int(11) NOT NULL,
  `leaflogs_avg_cp_mv` int(11) NOT NULL,
  `leaflogs_cp_mv_diff` int(11) NOT NULL,
  `leaflogs_judgement_value` int(11) NOT NULL,
  `leaflogs_pack_t1_f` decimal(6,4) NOT NULL,
  `leaflogs_pack_t1_c` decimal(6,4) NOT NULL,
  `leaflogs_pack_t2_f` decimal(6,4) NOT NULL,
  `leaflogs_pack_t2_c` decimal(6,4) NOT NULL,
  `leaflogs_pack_t3_f` decimal(6,4) NOT NULL,
  `leaflogs_pack_t3_c` decimal(6,4) NOT NULL,
  `leaflogs_pack_t4_f` decimal(6,4) NOT NULL,
  `leaflogs_pack_t4_c` decimal(6,4) NOT NULL,
  `leaflogs_cp01` int(11) NOT NULL,
  `leaflogs_cp02` int(11) NOT NULL,
  `leaflogs_cp03` int(11) NOT NULL,
  `leaflogs_cp04` int(11) NOT NULL,
  `leaflogs_cp05` int(11) NOT NULL,
  `leaflogs_cp06` int(11) NOT NULL,
  `leaflogs_cp07` int(11) NOT NULL,
  `leaflogs_cp08` int(11) NOT NULL,
  `leaflogs_cp09` int(11) NOT NULL,
  `leaflogs_cp10` int(11) NOT NULL,
  `leaflogs_cp11` int(11) NOT NULL,
  `leaflogs_cp12` int(11) NOT NULL,
  `leaflogs_cp13` int(11) NOT NULL,
  `leaflogs_cp14` int(11) NOT NULL,
  `leaflogs_cp15` int(11) NOT NULL,
  `leaflogs_cp16` int(11) NOT NULL,
  `leaflogs_cp17` int(11) NOT NULL,
  `leaflogs_cp18` int(11) NOT NULL,
  `leaflogs_cp19` int(11) NOT NULL,
  `leaflogs_cp20` int(11) NOT NULL,
  `leaflogs_cp21` int(11) NOT NULL,
  `leaflogs_cp22` int(11) NOT NULL,
  `leaflogs_cp23` int(11) NOT NULL,
  `leaflogs_cp24` int(11) NOT NULL,
  `leaflogs_cp25` int(11) NOT NULL,
  `leaflogs_cp26` int(11) NOT NULL,
  `leaflogs_cp27` int(11) NOT NULL,
  `leaflogs_cp28` int(11) NOT NULL,
  `leaflogs_cp29` int(11) NOT NULL,
  `leaflogs_cp30` int(11) NOT NULL,
  `leaflogs_cp31` int(11) NOT NULL,
  `leaflogs_cp32` int(11) NOT NULL,
  `leaflogs_cp33` int(11) NOT NULL,
  `leaflogs_cp34` int(11) NOT NULL,
  `leaflogs_cp35` int(11) NOT NULL,
  `leaflogs_cp36` int(11) NOT NULL,
  `leaflogs_cp37` int(11) NOT NULL,
  `leaflogs_cp38` int(11) NOT NULL,
  `leaflogs_cp39` int(11) NOT NULL,
  `leaflogs_cp40` int(11) NOT NULL,
  `leaflogs_cp41` int(11) NOT NULL,
  `leaflogs_cp42` int(11) NOT NULL,
  `leaflogs_cp43` int(11) NOT NULL,
  `leaflogs_cp44` int(11) NOT NULL,
  `leaflogs_cp45` int(11) NOT NULL,
  `leaflogs_cp46` int(11) NOT NULL,
  `leaflogs_cp47` int(11) NOT NULL,
  `leaflogs_cp48` int(11) NOT NULL,
  `leaflogs_cp49` int(11) NOT NULL,
  `leaflogs_cp50` int(11) NOT NULL,
  `leaflogs_cp51` int(11) NOT NULL,
  `leaflogs_cp52` int(11) NOT NULL,
  `leaflogs_cp53` int(11) NOT NULL,
  `leaflogs_cp54` int(11) NOT NULL,
  `leaflogs_cp55` int(11) NOT NULL,
  `leaflogs_cp56` int(11) NOT NULL,
  `leaflogs_cp57` int(11) NOT NULL,
  `leaflogs_cp58` int(11) NOT NULL,
  `leaflogs_cp59` int(11) NOT NULL,
  `leaflogs_cp60` int(11) NOT NULL,
  `leaflogs_cp61` int(11) NOT NULL,
  `leaflogs_cp62` int(11) NOT NULL,
  `leaflogs_cp63` int(11) NOT NULL,
  `leaflogs_cp64` int(11) NOT NULL,
  `leaflogs_cp65` int(11) NOT NULL,
  `leaflogs_cp66` int(11) NOT NULL,
  `leaflogs_cp67` int(11) NOT NULL,
  `leaflogs_cp68` int(11) NOT NULL,
  `leaflogs_cp69` int(11) NOT NULL,
  `leaflogs_cp70` int(11) NOT NULL,
  `leaflogs_cp71` int(11) NOT NULL,
  `leaflogs_cp72` int(11) NOT NULL,
  `leaflogs_cp73` int(11) NOT NULL,
  `leaflogs_cp74` int(11) NOT NULL,
  `leaflogs_cp75` int(11) NOT NULL,
  `leaflogs_cp76` int(11) NOT NULL,
  `leaflogs_cp77` int(11) NOT NULL,
  `leaflogs_cp78` int(11) NOT NULL,
  `leaflogs_cp79` int(11) NOT NULL,
  `leaflogs_cp80` int(11) NOT NULL,
  `leaflogs_cp81` int(11) NOT NULL,
  `leaflogs_cp82` int(11) NOT NULL,
  `leaflogs_cp83` int(11) NOT NULL,
  `leaflogs_cp84` int(11) NOT NULL,
  `leaflogs_cp85` int(11) NOT NULL,
  `leaflogs_cp86` int(11) NOT NULL,
  `leaflogs_cp87` int(11) NOT NULL,
  `leaflogs_cp88` int(11) NOT NULL,
  `leaflogs_cp89` int(11) NOT NULL,
  `leaflogs_cp90` int(11) NOT NULL,
  `leaflogs_cp91` int(11) NOT NULL,
  `leaflogs_cp92` int(11) NOT NULL,
  `leaflogs_cp93` int(11) NOT NULL,
  `leaflogs_cp94` int(11) NOT NULL,
  `leaflogs_cp95` int(11) NOT NULL,
  `leaflogs_cp96` int(11) NOT NULL,
  `leaflogs_batvolt` decimal(6,4) NOT NULL,
  `leaflogs_vin` varchar(20) NOT NULL,
  `leaflogs_health` decimal(8,3) NOT NULL,
  `leaflogs_raw_12_batt` decimal(8,3) NOT NULL,
  `leaflogs_odometer` int(11) NOT NULL,
  `leaflogs_qc` int(11) NOT NULL,
  `leaflogs_l1l2` int(11) NOT NULL,
  `leaflogs_tp_fl` decimal(8,3) NOT NULL,
  `leaflogs_tp_fr` decimal(8,3) NOT NULL,
  `leaflogs_tp_rr` decimal(8,3) NOT NULL,
  `leaflogs_tp_rl` decimal(8,3) NOT NULL,
  `leaflogs_ambient` int(11) NOT NULL,
  `leaflogs_soh` int(11) NOT NULL,
  `leaflogs_regen` int(11) NOT NULL,
  `leaflogs_epoch` bigint(20) NOT NULL,
  `leaflogs_android_batt` int(11) NOT NULL,
  `leaflogs_power_motor` int(11) NOT NULL,
  `leaflogs_power_aux` int(11) NOT NULL,
  `leaflogs_power_ac` int(11) NOT NULL,
  `leaflogs_psi_ac_compressor` int(11) NOT NULL,
  `leaflogs_est_power_ac` int(11) NOT NULL,
  `leaflogs_est_power_heater` int(11) NOT NULL,
  `leaflogs_plug_state` int(11) NOT NULL,
  `leaflogs_charge_mode` int(11) NOT NULL,
  `leaflogs_onboard_charger_power` int(11) NOT NULL,
  `leaflogs_drive_mode` int(11) NOT NULL,
  `leaflogs_hvolt1` decimal(8,3) NOT NULL,
  `leaflogs_hvolt2` decimal(8,3) NOT NULL,
  PRIMARY KEY  (`leaflogs_id`),
  KEY `leaflogs_timestamp` (`leaflogs_timestamp`),
  KEY `leaflogs_user_id` (`leaflogs_user_id`),
  KEY `leaflogs_lat` (`leaflogs_lat`),
  KEY `leaflogs_lon` (`leaflogs_lon`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=346376 ;

-- --------------------------------------------------------

--
-- Table structure for table `loginlog`
--

CREATE TABLE IF NOT EXISTS `loginlog` (
  `loginlog_id` int(11) NOT NULL auto_increment,
  `loginlog_timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `loginlog_users_id` int(11) NOT NULL,
  PRIMARY KEY  (`loginlog_id`),
  KEY `loginlog_id` (`loginlog_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=54 ;

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

CREATE TABLE IF NOT EXISTS `trips` (
  `trips_id` int(11) NOT NULL auto_increment,
  `trips_users_id` int(11) NOT NULL,
  `trips_name` varchar(200) NOT NULL,
  `trips_datetime_start` datetime NOT NULL,
  `trips_datetime_end` datetime NOT NULL,
  PRIMARY KEY  (`trips_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1926 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `users_id` int(11) NOT NULL auto_increment,
  `users_email` varchar(35) NOT NULL,
  `users_password` varchar(50) NOT NULL,
  `users_fullname` varchar(50) NOT NULL,
  `users_privatedata` tinyint(4) NOT NULL default '1',
  `users_is_admin` tinyint(4) NOT NULL,
  `users_account_disabled` tinyint(4) NOT NULL,
  `users_units` char(6) NOT NULL,
  `users_units_distance` varchar(10) NOT NULL,
  `users_units_temperature` varchar(10) NOT NULL,
  `users_trip_delimiter` int(11) NOT NULL,
  PRIMARY KEY  (`users_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=66 ;

