<?php

$installer = $this;

$installer->startSetup();

$installer->run("
DROP TABLE IF EXISTS `vendor_address`;
CREATE TABLE `vendor_address` (
  `address_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `zip_code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

ALTER TABLE `vendor_address`
  ADD PRIMARY KEY (`address_id`);

ALTER TABLE `vendor_address`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `vendor_address` ADD FOREIGN KEY (`vendor_id`) REFERENCES `vendor`(`vendor_id`) ON DELETE CASCADE ON UPDATE CASCADE;
");
$installer->endSetup();

?>