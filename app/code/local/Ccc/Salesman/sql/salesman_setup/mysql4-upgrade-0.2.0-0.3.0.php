<?php

$installer = $this;

$installer->startSetup();

$installer->run("
DROP TABLE IF EXISTS `salesman_price`;
CREATE TABLE `salesman_price` (
  `entity_id` int(11) NOT NULL,
  `salesman_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `sku` varchar(255) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `salesman_price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

ALTER TABLE `salesman_price`
  ADD PRIMARY KEY (`entity_id`);

ALTER TABLE `salesman_price`
  MODIFY `entity_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `salesman_price` ADD FOREIGN KEY (`salesman_id`) REFERENCES `salesman`(`salesman_id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `salesman_price` ADD FOREIGN KEY (`product_id`) REFERENCES `product`(`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;
");
$installer->endSetup();

?>