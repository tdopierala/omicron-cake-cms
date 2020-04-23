CREATE TABLE `covid_poland_infected` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `region_id` int(10) unsigned NOT NULL,
  `infected` int(10) unsigned NOT NULL,
  `dead` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `date_region_unique` (`date`,`region_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
