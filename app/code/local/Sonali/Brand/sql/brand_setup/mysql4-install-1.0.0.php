<?php

$installer = $this;

$installer->startSetup();

$installer->run("
  
  DROP TABLE IF EXISTS {$this->getTable('brand')}; 
  CREATE TABLE {$this->getTable('brand')}  (
  `brand_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_time` datetime NOT NULL,
  `update_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE {$this->getTable('brand')}
  ADD PRIMARY KEY (`brand_id`);

ALTER TABLE {$this->getTable('brand')}
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;
  
");

$installer->endSetup();