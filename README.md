--
DESCRIPTION
--
This is a web application based on Zend Framework 2.
With it, a bow maker can manage his client list, bows collections he receives and operations made on bows.

* v1 : manage clients, collections and bows
* v1.1 : add attachments for collections and bows
* v1.1a : add bow number. When you add a bow to a collection a number is generate to identify it.
* v1.2 : display popup to load bows edit form from collection details page + fix bugs (add devise, remove backslashes...)
* v2.0 : Addition of the bill module. Bills are listed, can or not be attach to a collection. Big modification of the database.

--
TABLES STRUCTURES V2
--

* Structure de la table `bm_bill`

CREATE TABLE IF NOT EXISTS `bm_bill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `collection_id` int(11) NOT NULL,
  `amount` float NOT NULL,
  `reference` varchar(100) CHARACTER SET utf8 NOT NULL,
  `is_paid` tinyint(1) NOT NULL,
  `attachments` text CHARACTER SET utf8 NOT NULL,
  `creation_time` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

* Structure de la table `bm_bow`

CREATE TABLE IF NOT EXISTS `bm_bow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` int(11) NOT NULL,
  `collection_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `size` int(11) NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `work_to_do` text CHARACTER SET utf8 NOT NULL,
  `status` text CHARACTER SET utf8 NOT NULL,
  `is_done` tinyint(1) NOT NULL,
  `comments` text CHARACTER SET utf8 NOT NULL,
  `attachments` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

-- --------------------------------------------------------

* Structure de la table `bm_client`

CREATE TABLE IF NOT EXISTS `bm_client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `create_time` bigint(20) NOT NULL,
  `last_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `first_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `address` varchar(250) CHARACTER SET utf8 NOT NULL,
  `landline` varchar(30) CHARACTER SET utf8 NOT NULL,
  `mobile` varchar(30) CHARACTER SET utf8 NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 NOT NULL,
  `website` varchar(100) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

* Structure de la table `bm_collection`

CREATE TABLE IF NOT EXISTS `bm_collection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` int(11) NOT NULL,
  `reception_time` bigint(20) NOT NULL,
  `return_time` bigint(20) NOT NULL,
  `package_number` varchar(100) CHARACTER SET utf8 NOT NULL,
  `comments` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;