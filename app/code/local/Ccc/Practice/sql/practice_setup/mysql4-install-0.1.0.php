<?php
require_once 'app/Mage.php';


$attributeOptions = array(
    'lal',
    'bhuro',
    'pilo',
    'nilo',
    'kesari',
    'lilo',
    'jambli',
    'gulabi',
    'popti',
    'dudhiyo'
);

$installer = new Mage_Eav_Model_Entity_Setup('core_setup');
$installer->startSetup();

$installer->addAttribute('catalog_product','top_color',
array(
    'group' => 'General',
    'type'  => 'int',
    'label' => 'Top Color',
    'user_defined' => true,
    'input' => 'select',
    'option' => array('values' => $attributeOptions) 

    )
);
$installer->endSetup();
