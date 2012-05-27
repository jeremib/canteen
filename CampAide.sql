DROP DATABASE IF EXISTS `campaide`;



CREATE DATABASE `campaide`;

USE `campaide`;

CREATE TABLE `aide_admins` (
  `admin_id` int(11) unsigned NOT NULL auto_increment,
  `admin_username` varchar(50) default NULL,
  `admin_password` varchar(50) default NULL,
  `admin_name` varchar(100) default NULL,
  `user_isAdmin` tinyint(1) default '0',
  PRIMARY KEY  (`admin_id`)
) TYPE=MyISAM;

INSERT INTO `aide_admins` (`admin_id`,`admin_username`,`admin_password`,`admin_name`,`user_isAdmin`) VALUES (1,'jeremi','intruder','Jeremi Bergman',1);
INSERT INTO `aide_admins` (`admin_id`,`admin_username`,`admin_password`,`admin_name`,`user_isAdmin`) VALUES (2,'registration','registration','Registration',0);
INSERT INTO `aide_admins` (`admin_id`,`admin_username`,`admin_password`,`admin_name`,`user_isAdmin`) VALUES (3,'canteen','canteen','Canteen',0);
INSERT INTO `aide_admins` (`admin_id`,`admin_username`,`admin_password`,`admin_name`,`user_isAdmin`) VALUES (4,'crafts','crafts','Crafts',0);

CREATE TABLE `aide_campers` (
  `cmpr_id` int(11) unsigned NOT NULL auto_increment,
  `cmpr_first` varchar(50) default NULL,
  `cmpr_last` varchar(50) default NULL,
  `cmpr_start_amount` double(6,2) default NULL,
  `cmpr_notes` text,
  `cmpr_week_id` int(11) default NULL,
  PRIMARY KEY  (`cmpr_id`)
) TYPE=MyISAM;

CREATE TABLE `aide_transactions` (
  `trans_id` int(11) unsigned NOT NULL auto_increment,
  `trans_cmpr_id` int(11) default NULL,
  `trans_dts` datetime NOT NULL default '0000-00-00 00:00:00',
  `trans_amount` double(6,2) default NULL,
  `trans_admin_name` varchar(100) default NULL,
  PRIMARY KEY  (`trans_id`)
) TYPE=MyISAM;


CREATE TABLE `aide_weeks` (
  `week_id` int(11) unsigned NOT NULL auto_increment,
  `week_name` varchar(50) default NULL,
  `week_start_date` date default NULL,
  `week_end_date` date default NULL,
  PRIMARY KEY  (`week_id`)
) TYPE=MyISAM;


INSERT INTO `aide_weeks` (`week_id`,`week_name`,`week_start_date`,`week_end_date`) VALUES (1,'STAFF','2000-01-01','2000-01-01');
INSERT INTO `aide_weeks` (`week_id`,`week_name`,`week_start_date`,`week_end_date`) VALUES (4,'Sr. High','2005-06-06','2005-06-10');
INSERT INTO `aide_weeks` (`week_id`,`week_name`,`week_start_date`,`week_end_date`) VALUES (5,'Junior I','2005-06-13','2005-06-17');
INSERT INTO `aide_weeks` (`week_id`,`week_name`,`week_start_date`,`week_end_date`) VALUES (6,'Junior II','2005-06-20','2005-06-24');
INSERT INTO `aide_weeks` (`week_id`,`week_name`,`week_start_date`,`week_end_date`) VALUES (7,'Junior High I','2005-06-27','2005-07-01');
INSERT INTO `aide_weeks` (`week_id`,`week_name`,`week_start_date`,`week_end_date`) VALUES (8,'Junior High II','2005-07-04','2005-07-08');
