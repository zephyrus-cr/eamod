# Ceres Control Panel
# 
# This is a control pannel program for Athena and Freya
# Copyright (C) 2005 by Beowulf and Nightroad
# 
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
# 
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# 
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
# 
# To contact any of the authors about special permissions send
# an e-mail to cerescp@gmail.com

CREATE TABLE `server_status` (
  `last_checked` datetime NOT NULL default '0000-00-00 00:00:00',
  `status` tinyint(1) NOT NULL default '0'
) TYPE=MyISAM;

CREATE TABLE `query_log` (
  `action_id` int(11) NOT NULL auto_increment,
  `Date` datetime NOT NULL default '0000-00-00 00:00:00',
  `User` varchar(24) NOT NULL default '',
  `IP` varchar(20) NOT NULL default '',
  `page` varchar(24) NOT NULL default '',
  `query` text NOT NULL,
  PRIMARY KEY  (`action_id`),
  KEY `action_id` (`action_id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

CREATE TABLE `links` (
  `cod` int(11) NOT NULL auto_increment,
  `name` varchar(30) NOT NULL,
  `url` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `size` int(11) default '0',
  PRIMARY KEY  (`cod`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

CREATE TABLE `bruteforce` (
  `action_id` int(11) NOT NULL auto_increment,
  `user` varchar(24) NOT NULL default '',
  `IP` varchar(20) NOT NULL default '',
  `date` int(11) NOT NULL default '0',
  `ban` int(11) NOT NULL default '0',
  PRIMARY KEY  (`action_id`),
  KEY `user` (`user`),
  KEY `IP` (`IP`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;
