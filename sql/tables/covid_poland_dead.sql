CREATE TABLE `covid_poland_dead` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `age` int(3) DEFAULT NULL,
  `sex` char(1) DEFAULT NULL,
  `region_id` int(10) unsigned DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
