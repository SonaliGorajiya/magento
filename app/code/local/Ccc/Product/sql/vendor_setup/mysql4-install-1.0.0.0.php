<?php 

$installer = $this; 

$installer->startSetup(); 

$table = $installer->getConnection()
    ->newTable($installer->getTable('vendor/manage'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Id')
    ->addColumn('vendor', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable'  => true,
        ), 'Vendor');
$installer->getConnection()->createTable($table);

$installer->endSetup();