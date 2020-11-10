CREATE TABLE `covid19_poland` (
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

CREATE TABLE `covid19_poland_dead` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `age` int(3) DEFAULT NULL,
  `sex` char(1) DEFAULT NULL,
  `region_id` int(10) unsigned DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `removed` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `covid19_poland_infected` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `region_id` int(10) unsigned NOT NULL,
  `infected` int(10) unsigned NOT NULL,
  `dead` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `date_region_unique` (`date`,`region_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `covid19_poland_infected_correction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `region_id` int(11) unsigned NOT NULL,
  `infected` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

ALTER TABLE `covid_poland_infected`
DROP COLUMN `dead`,
ADD COLUMN `cell` VARCHAR(10) NULL AFTER `region_id`,
ADD COLUMN `infected_f` VARCHAR(50) NULL DEFAULT NULL AFTER `infected`,
ADD COLUMN `changed` DATETIME NULL DEFAULT NULL AFTER `dead`;

ALTER TABLE `covid_poland_infected` 
CHANGE COLUMN `infected` `infected` INT(10) NOT NULL ;

ALTER TABLE `covid_poland` 
ADD COLUMN `surveyed` INT(11) UNSIGNED NULL DEFAULT NULL COMMENT 'number of people surveyed' AFTER `tests`,
ADD COLUMN `respirator` INT(11) UNSIGNED NULL DEFAULT NULL COMMENT 'number of people under a respirator' AFTER `hospitalized`;
ADD COLUMN `changed` DATETIME NULL DEFAULT NULL AFTER `date`;

-- ALTER TABLE `covid_poland_dead` DROP COLUMN `checked`;

ALTER TABLE `covid_poland_dead` RENAME TO `covid_poland_dead_old` ;
ALTER TABLE `covid_poland_dead` ADD COLUMN `no` INT(11) UNSIGNED NOT NULL COMMENT 'case number' AFTER `id`;
ALTER TABLE `covid_poland_dead` ADD COLUMN `region_name` VARCHAR(50) NULL DEFAULT NULL AFTER `region_id`;

