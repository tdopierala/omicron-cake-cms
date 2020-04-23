CREATE TABLE `covid_poland` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `tests` int(11) unsigned DEFAULT NULL,
  `hospitalized` int(11) unsigned NOT NULL DEFAULT 0 COMMENT 'number of people hospitalized',
  `quarantined` int(11) unsigned NOT NULL DEFAULT 0 COMMENT 'number of people quarantined',
  `quarantined2` int(11) unsigned DEFAULT NULL COMMENT 'number of people in quarantine after returning from abroad',
  `surveillance` int(11) unsigned NOT NULL DEFAULT 0 COMMENT 'number of people covered by epidemiological surveillance',
  `infected` int(11) unsigned NOT NULL DEFAULT 0 COMMENT 'number of confirmed infections',
  `dead` int(11) unsigned NOT NULL DEFAULT 0,
  `recover` int(11) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `date_unique` (`date`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
