CREATE OR REPLACE VIEW `covid_pl_case_by_region_view` AS
SELECT
  `cpi`.`region_id` AS `region_id`,
  `cpr`.`name` AS `name`,
  `cpr`.`code` AS `code`,
  SUM(`cpi`.`infected`) AS `infected`,
  SUM(`cpi`.`dead`) AS `dead`
FROM `covid_poland_infected` `cpi`
INNER JOIN `covid_poland_regions` `cpr` on `cpr`.`id` = `cpi`.`region_id`
GROUP BY `cpi`.`region_id`
ORDER BY `cpi`.`region_id` ASC;
