<?php 

$installer = $this;

$installer->startSetup();

$installer->getConnection()->addKey($installer->getTable('sonali/sonali_decimal'),
    'UNQ_MEET_DECIMAL', array('entity_id','attribute_id', 'store_id'), 'unique');

$installer->getConnection()->addKey($installer->getTable('sonali/sonali_datetime'),
    'UNQ_MEET_DECIMAL', array('entity_id','attribute_id', 'store_id'), 'unique');

$installer->getConnection()->addKey($installer->getTable('sonali/sonali_int'),
    'UNQ_MEET_DECIMAL', array('entity_id','attribute_id', 'store_id'), 'unique');

$installer->getConnection()->addKey($installer->getTable('sonali/sonali_text'),
    'UNQ_MEET_DECIMAL', array('entity_id','attribute_id', 'store_id'), 'unique');

$installer->endSetup();

?>