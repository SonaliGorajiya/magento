<?php
$installer = $this;
$installer->startSetup();
$installer->run("
	DROP TABLE IF EXISTS {$this->getTable('banner_group')};

	CREATE TABLE {$this->getTable('banner_group')} (
	  `group_id` int(11) NOT NULL,
	  `name` varchar(255) NOT NULL,
	  `group_key` varchar(255) NOT NULL,
	  `height` decimal(5,2) NOT NULL,
	  `width` decimal(5,2) NOT NULL,
	  `created_at` datetime NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

	ALTER TABLE {$this->getTable('banner_group')}
	  ADD PRIMARY KEY (`group_id`),
	  ADD UNIQUE KEY `group_key` (`group_key`);

	ALTER TABLE {$this->getTable('banner_group')}
	  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT;

	DROP TABLE IF EXISTS {$this->getTable('banner')};

	CREATE TABLE {$this->getTable('banner')} (
	  `banner_id` int(11) NOT NULL,
	  `group_id` int(11) NOT NULL,
	  `image` varchar(255) NOT NULL,
	  `status` tinyint(4) NOT NULL,
	  `position` int(11) NOT NULL,
	  `created_at` datetime NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

	ALTER TABLE {$this->getTable('banner')}
	  ADD PRIMARY KEY (`banner_id`);

	ALTER TABLE {$this->getTable('banner')}
	  MODIFY `banner_id` int(11) NOT NULL AUTO_INCREMENT;

	ALTER TABLE {$this->getTable('banner')} ADD FOREIGN KEY (`group_id`) REFERENCES {$this->getTable('banner_group')}(`group_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

");
$installer->endSetup();