<?php
require_once 'app/Mage.php';


$attributeOptions = array(
    'Option1',
    'Option2',
    'Option3',
    'Option4',
    'Option5',
    'Option6',
    'Option7',
    'Option8',
    'Option9',
    'Option10'
);

$installer = new Mage_Eav_Model_Entity_Setup('core_setup');
$installer->startSetup();

$installer->addAttribute('catalog_product','bottom_color',
array(
    'group' => 'General',
    'type'  => 'int',
    'label' => 'Bottom Color',
    'user_defined' => true,
    'input' => 'select',
    'option' => array('values' => $attributeOptions) 

    )
);
$installer->endSetup();
