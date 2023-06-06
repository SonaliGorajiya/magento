<?php

$installer = $this;

$installer->startSetup();

$installer->run("
  
  DROP TABLE IF EXISTS {$this->getTable('banner_group')}; 
  CREATE TABLE {$this->getTable('banner_group')}  (
  `group_id` INT(11) NOT NULL , 
  `name` VARCHAR(100) NOT NULL , 
  `group_key` VARCHAR(255) NOT NULL , 
  `height` DECIMAL(10,2) NOT NULL , 
  `width` DECIMAL(10,2) NOT NULL , 
  `created_at` DATETIME NOT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE {$this->getTable('banner_group')}
  ADD PRIMARY KEY (`group_id`);

ALTER TABLE {$this->getTable('banner_group')}
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

DROP TABLE IF EXISTS {$this->getTable('banner')}; 
CREATE TABLE {$this->getTable('banner')}  (
  `banner_id` INT(11) NOT NULL , 
  `group_id` INT(11) NOT NULL , 
  `image` VARCHAR(50) NOT NULL , 
  `status` TINYINT(4) NOT NULL , 
  `position` INT(11) NOT NULL , 
  `created_at` DATETIME NOT NULL  
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE {$this->getTable('banner')}
  ADD PRIMARY KEY (`banner_id`);

ALTER TABLE {$this->getTable('banner')}
  MODIFY `banner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

    ");

$installer->endSetup();

