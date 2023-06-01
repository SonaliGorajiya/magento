<?php
$installer = $this;
$installer->startSetup();
$installer->run("
	DROP TABLE IF EXISTS {$this->getTable('import_product_idx')};
	CREATE TABLE {$this->getTable('import_product_idx')} (
	  `index` int(11) NOT NULL,
	  `product_id` int(11) NOT NULL,
	  `sku` varchar(50) NOT NULL,
	  `name` varchar(255) NOT NULL,
	  `price` decimal(12,4) NOT NULL,
	  `cost` decimal(12,4) NOT NULL,
	  `quantity` int(11) NOT NULL,
	  `brand` varchar(255) NOT NULL,
	  `brand_id` int(11) NOT NULL,
	  `collection` varchar(255) NOT NULL,
	  `collection_id` int(11) NOT NULL,
	  `description` varchar(255) NOT NULL,
	  `status` tinyint(4) NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
	ALTER TABLE {$this->getTable('import_product_idx')}
		ADD PRIMARY KEY (`index`);
	ALTER TABLE {$this->getTable('import_product_idx')}
  		MODIFY `index` int(11) NOT NULL AUTO_INCREMENT;
");
$installer->endSetup();