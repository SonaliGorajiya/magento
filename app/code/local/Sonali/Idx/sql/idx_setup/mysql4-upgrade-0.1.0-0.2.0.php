<?php
$installer = new Mage_Eav_Model_Entity_Setup('core_setup');
$installer->startSetup();
$entityTypeId = $installer->getEntityTypeId('catalog_product');
$installer->addAttribute($entityTypeId, 'collection', array(
    'group'                       => 'General',
    'type'                        => 'int',
    'backend'                        => '',
    'frontend'                        => '',
    'input'                       => 'select',
    'label'                       => 'Select Collection',
    'required'                    => 0,
    'visible'                     => 1,
    'user_defined'                => 1,
    'searchable'                  => 1,
    'filterable'                  => 1,
    'visible_on_front'            => 0,
    'visible_in_advanced_search'  => 0,
    'is_html_allowed_on_front'    => 1,
    'comparable'                  => 1,
    'global'                      => 1
));
$installer->endSetup();