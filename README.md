simple-php-mysql-helpdesk-ticketing
===================================

This is a simple HelpDesk or UserRequest ticketing system.
The application is in active developement.

This project use:
- jQuery
- bootstrap
- bootstrap-datatable
- bootstrap-select
- bootstrap-wysiwing
- fileinput

The target navigator is IE9 and Chrome.

The mysql schema
================

```SQL
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `support_line` varchar(256) NOT NULL,
  `user_name` varchar(14) NOT NULL,
  `user_id` varchar(14) NOT NULL,
  `email` varchar(256) NOT NULL,
  `application_code` varchar(8) NOT NULL,
  `request_domain` varchar(256) NOT NULL,
  `details` text NOT NULL,
  `files_id` int(11) NOT NULL,
  `assigned` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=241 ;


CREATE TABLE IF NOT EXISTS `upload` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `type` varchar(30) NOT NULL,
  `size` int(11) NOT NULL,
  `content` mediumblob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
```