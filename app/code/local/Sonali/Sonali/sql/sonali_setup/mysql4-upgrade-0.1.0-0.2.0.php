<?php

$installer = new Mage_Eav_Model_Entity_Setup('core_setup');
/** @var $installer Mage_Catalog_Model_Resource_Setup */

$installer->startSetup();

$installer->addAttribute(9, 'email', array(
    'group'         => 'General',
    'backend'       => 'catalog/product_attribute_backend_groupprice',
    'label'         => 'Email',
    'input'         => 'email',
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_WEBSITE,
    'visible'       => true,
    'required'      => false,
));

$installer->endSetup();
