CREATE OR REPLACE VIEW `covid_pl_total_from_details_view` AS 
SELECT
  `cpi`.`date` AS `date`,
  SUM(`cpi`.`infected`) AS `infected`,
  SUM(`cpi`.`dead`) AS `dead`
FROM `covid_poland_infected` `cpi`
GROUP BY `cpi`.`date`
ORDER BY `cpi`.`date` DESC;
