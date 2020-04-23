CREATE OR REPLACE VIEW `home_settlement_view` AS
SELECT
  `hsv`.`id` AS `id`,
  `hsv`.`settlement_id` AS `settlement_id`,
  `hsc`.`name` AS `name`,
  `hsc`.`description` AS `description`,
  `hsc`.`unit` AS `unit`,
  `hsv`.`price` AS `price`,
  `hsv`.`amount` AS `amount`,
  ROUND(`hsv`.`price` * `hsv`.`amount`,2) AS `val`
FROM `home_settlement_value` `hsv`
LEFT JOIN `home_settlement_component` `hsc` ON `hsc`.`id` = `hsv`.`component_id`;
