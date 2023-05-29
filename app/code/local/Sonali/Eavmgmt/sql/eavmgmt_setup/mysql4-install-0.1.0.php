<?php

$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();

$installer->run("
--
DROP TABLE IF EXISTS `{$this->getTable('eavmgmt')}`;
CREATE TABLE `{$this->getTable('eavmgmt')}` (
  `eavmgmt_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `{$this->getTable('eavmgmt')}`
  ADD PRIMARY KEY (`eavmgmt_id`);

ALTER TABLE `{$this->getTable('eavmgmt')}`
  MODIFY `eavmgmt_id` int(11) NOT NULL AUTO_INCREMENT;
");

$installer->endSetup();
