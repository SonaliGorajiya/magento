<?php
$installer = new Mage_Eav_Model_Entity_Setup('core_setup');
$installer->startSetup();
$installer->addAttribute(4, 'brand', array(
    'type'          => 'int',
    'input'         => 'select',
    'label'         => 'Brand',
    'required'      => 0,
    'group'         => 'General',
    'source'        => 'sonali_brand_model_source_model',
    'sort_order'    => '100',
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible'       => true,
    'user_defined'  => true,
));
$installer->endSetup();