<?php

$installer = $this;

$installer->startSetup();

$installer->run("
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `sku` varchar(50) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 100,
  `description` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 2,
  `color` tinyint(4) NOT NULL,
  `material` tinyint(4) NOT NULL,
  `small_id` int(11) DEFAULT NULL,
  `thumb_id` int(11) DEFAULT NULL,
  `base_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);


ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT;
  
");
$installer->endSetup();

?>