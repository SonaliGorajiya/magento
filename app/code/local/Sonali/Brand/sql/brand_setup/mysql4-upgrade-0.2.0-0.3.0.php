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
$installer->getConnection()
    ->addColumn($installer->getTable('brand'),'sort_order', array(
        'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
        'nullable'  => false,
        'length'    => 11,
        'after'     => 'description', 
        'comment'   => 'Sort Order'
        ));
$installer->endSetup();