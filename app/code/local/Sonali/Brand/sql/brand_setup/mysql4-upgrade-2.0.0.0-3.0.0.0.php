<?php
$installer = $this;
$installer->startSetup();
$installer->getConnection()
->addColumn($installer->getTable('brand'),'url_key', array(
    'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
    'nullable'  => false,
    'length'    => 255,
    'after'     => 'brand_id', 
    'comment'   => 'URL Key'
    ));
$installer->getConnection()
->addColumn($installer->getTable('brand'),'banner', array(
    'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
    'nullable'  => false,
    'length'    => 255,
    'after'     => 'image', 
    'comment'   => 'Banner'
    ));
$installer->endSetup();