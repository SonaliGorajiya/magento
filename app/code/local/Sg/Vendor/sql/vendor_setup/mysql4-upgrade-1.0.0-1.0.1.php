<?php

$installer = $this;

$installer->startSetup();

$installer->run("
    
    DROP TABLE IF EXISTS {$this->getTable('vendor_address')};
    CREATE TABLE {$this->getTable('vendor_address')} (
       `address_id` int(11) NOT NULL,
    `vendor_id` int(11) NOT NULL,
    `address` varchar(255) NOT NULL,
    `postal_code` varchar(20) NOT NULL,
    `city` varchar(50) NOT NULL,
    `state` varchar(50) NOT NULL,
    `country` varchar(50) NOT NULL,
    `created_at` datetime NOT NULL,
    `updated_at` datetime DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ALTER TABLE {$this->getTable('vendor_address')}
        ADD PRIMARY KEY (`address_id`);

    ALTER TABLE {$this->getTable('vendor_address')}
        MODIFY `address_id` int(10) NOT NULL AUTO_INCREMENT;

    ALTER TABLE {$this->getTable('vendor_address')} 
        ADD  FOREIGN KEY (`vendor_id`) 
        REFERENCES {$this->getTable('vendor')}(`vendor_id`)
        ON DELETE CASCADE ON UPDATE CASCADE;

");

$installer->endSetup();

?>