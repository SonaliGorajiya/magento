<?php

$installer = $this;

$installer->startSetup();

$installer->run("--

ALTER TABLE `banner_group` ADD UNIQUE(`group_key`);

ALTER TABLE `banner` ADD FOREIGN KEY (`group_id`) REFERENCES `banner_group`(`group_id`) ON DELETE CASCADE ON UPDATE CASCADE;

");

$installer->endSetup();
