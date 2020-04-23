CREATE OR REPLACE VIEW `covid_pl_total_infected_view` AS 
SELECT
  SUM(`cpi`.`infected`) AS `infected`,
  SUM(`cpi`.`dead`) AS `dead`
FROM `covid_poland_infected` `cpi`;
