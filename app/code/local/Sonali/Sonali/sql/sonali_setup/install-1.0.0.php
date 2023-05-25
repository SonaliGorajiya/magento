<?php 

$this->startSetup();

$this->addEntityType(Sonali_Sonali_Model_Resource_Sonali::ENTITY,[
	'entity_model'=>'sonali/sonali',
	'attribute_model'=>'sonali/attribute',
	'table'=>'sonali/sonali',
	'increment_per_store'=> '0',
	'additional_attribute_table' => 'sonali/eav_attribute',
	'entity_attribute_collection' => 'sonali/sonali_attribute_collection'
]);

$this->createEntityTables('sonali');
$this->installEntities();

$default_attribute_set_id = Mage::getModel('eav/entity_setup', 'core_setup')
    						->getAttributeSetId('sonali', 'Default');

$this->run("UPDATE `eav_entity_type` SET `default_attribute_set_id` = {$default_attribute_set_id} WHERE `entity_type_code` = 'sonali'");

$this->endSetup();