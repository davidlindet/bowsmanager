--
DESCRIPTION
--
This is a web application based on Zend Framework 2.
With it, a bow maker can manage his client list, bows collections he receives and operations made on bows.

v1 : manage clients, collections and bows

--
TABLES STRUCTURES
--


* Structure of table `bm_bow`

CREATE TABLE IF NOT EXISTS `bm_bow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `collection_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `size` int(11) NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `work_to_do` text CHARACTER SET utf8 NOT NULL,
  `status` text CHARACTER SET utf8 NOT NULL,
  `is_done` tinyint(1) NOT NULL,
  `comments` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

* Structure of table `bm_client`

CREATE TABLE IF NOT EXISTS `bm_client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `create_time` bigint(20) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `address` varchar(250) NOT NULL,
  `landline` varchar(30) NOT NULL,
  `mobile` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `website` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

-- --------------------------------------------------------


* Structure of table `bm_collection`

CREATE TABLE IF NOT EXISTS `bm_collection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` int(11) NOT NULL,
  `reception_time` bigint(20) NOT NULL,
  `return_time` bigint(20) NOT NULL,
  `package_number` varchar(100) CHARACTER SET utf8 NOT NULL,
  `bill_reference` varchar(100) CHARACTER SET utf8 NOT NULL,
  `bill_amount` float NOT NULL,
  `paid_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;
