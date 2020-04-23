CREATE OR REPLACE VIEW `covid_pl_today_details_view` AS 
SELECT
  `cpi`.`id` AS `id`,
  `cpi`.`date` AS `date`,
  `cpi`.`region_id` AS `region_id`,
  `cpi`.`infected` AS `infected`,
  `cpi`.`dead` AS `dead`
FROM `covid_poland_infected` `cpi`
WHERE `cpi`.`date` = curdate();
