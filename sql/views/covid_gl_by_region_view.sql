CREATE OR REPLACE VIEW `covid_gl_by_region_view` AS 
SELECT
  `cgr`.`name` AS `_name`,
  SUM(`cg`.`infected`) AS `_infected`,
  SUM(`cg`.`dead`) AS `_dead`,
  SUM(`cg`.`recover`) AS `_recover`,
  `cg`.`date` AS `_date`
FROM `covid_global` `cg`
LEFT JOIN `covid_global_nations` `cgn` ON `cgn`.`id` = `cg`.`nation_id`
LEFT JOIN `covid_global_regions` `cgr` ON `cgr`.`id` = `cgn`.`region`
GROUP BY `cgr`.`id`,`cg`.`date`
ORDER BY `cg`.`date`, SUM(`cg`.`infected`) DESC;
