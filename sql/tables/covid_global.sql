CREATE TABLE `covid_global` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `time` time NOT NULL DEFAULT current_timestamp(),
  `nation_id` int(10) unsigned NOT NULL,
  `infected` int(10) unsigned NOT NULL,
  `dead` int(10) unsigned NOT NULL,
  `recover` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
