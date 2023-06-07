<?php
$installer = new Mage_Eav_Model_Entity_Setup('core_setup');
$installer->startSetup();
$installer->addAttribute(4, 'brand', array(
    'group'                       => 'General',
    'type'                        => 'int',
    'input'                       => 'select',
    'label'                       => 'Brand',
    'required'                    => 0,
    'sort_order'                  => '100',
    'source'                      => 'Sonali_Brand_Model_Source_Model',
    'global'                      => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'required'                    => 0,
    'visible'                     => 1,
    'user_defined'                => 1,
    'searchable'                  => 1,
    'filterable'                  => 1,
    'visible_on_front'            => 1,
    'visible_in_advanced_search'  => 0,
    'is_html_allowed_on_front'    => 1,
    'comparable'                  => ''
));
$installer->endSetup();