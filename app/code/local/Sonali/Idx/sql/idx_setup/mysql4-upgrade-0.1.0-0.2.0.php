<?php
$installer = $this;
$installer->startSetup();
$installer->run("
	DROP TABLE IF EXISTS {$this->getTable('collection')};
	CREATE TABLE {$this->getTable('collection')} (
	  `collection_id` int(11) NOT NULL,
	  `name` varchar(255) NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
	ALTER TABLE {$this->getTable('collection')}
	  ADD PRIMARY KEY (`collection_id`);
	ALTER TABLE {$this->getTable('collection')}
	  MODIFY `collection_id` int(11) NOT NULL AUTO_INCREMENT;
");
$installer->endSetup();