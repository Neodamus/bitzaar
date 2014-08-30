<?php

$installer = $this;	
$installer->startSetup();

$authorTable = $installer->getTable('author/author');

$table = $installer->getConnection()
	->newTable($authorTable)
	->addColumn('author_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		'identity' => true,
		'unsigned' => true,
		'nullable' => false,
		'primary'  => true,
		), 'Author ID')
	->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		'unsigned' => true,
		'nullable' => false
		), 'Customer ID')
	->addColumn('username', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
		'unsigned' => true,
		'nullable' => false
		), 'Username')
	->addColumn('address', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
		'unsigned' => true,
		'nullable' => false
		), 'Bitcoin Address')
	->addColumn('balance', Varien_Db_Ddl_Table::TYPE_DOUBLE, null, array(
		'unsigned' => true,
		'nullable' => false
		), 'Balance')		
	;
	
$installer->getConnection()->createTable($table);
$installer->endSetup();