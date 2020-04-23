CREATE TABLE `home_settlement_value` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `settlement_id` int(11) unsigned NOT NULL,
  `component_id` int(11) unsigned NOT NULL,
  `state` float unsigned DEFAULT NULL,
  `price` float NOT NULL,
  `amount` float NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settlement_id` (`settlement_id`,`component_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
