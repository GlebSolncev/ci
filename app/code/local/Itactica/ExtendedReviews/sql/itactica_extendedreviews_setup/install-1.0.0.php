<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_ExtendedReviews
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('itactica_extendedreviews/comments'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Comment ID')
    ->addColumn('review_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false
        ), 'Review Id')
    ->addColumn('user_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false
        ), 'User Id')
    ->addColumn('nickname', Varien_Db_Ddl_Table::TYPE_TEXT, 128, array(
        'nullable'  => false,
        ), 'Nickname')
    ->addColumn('text', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
        'nullable'  => false,
        ), 'Text')
    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        ), 'Enabled')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        ), 'Comment Creation Time') 
    ->setComment('Comments Table');
$this->getConnection()->createTable($table);

$table = $this->getConnection()
    ->newTable($this->getTable('itactica_extendedreviews/vote'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Vote ID')
    ->addColumn('review_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false
        ), 'Review Id')
    ->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false
        ), 'Customer Id')
    ->addColumn('guest_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false
        ), 'Guest Id')
    ->addColumn('helpful', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        ), 'Helpful')
    ->setComment('Vote Table');
$this->getConnection()->createTable($table);

$table = $this->getConnection()
    ->newTable($this->getTable('itactica_extendedreviews/summary'))
    ->addColumn('review_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Review ID')
    ->addColumn('rating_summary', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'default'   => '0',
        ), 'Rating Summary')
    ->addColumn('helpful', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'default'   => '0',
        ), 'Helpful')
    ->addColumn('nothelpful', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'default'   => '0',
        ), 'Not Helpful')
    ->addColumn('comments', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'default'   => '0',
        ), 'Comments')
    ->setComment('Summary');
$this->getConnection()->createTable($table);

$table = $this->getConnection()
    ->newTable($this->getTable('itactica_extendedreviews/userdata'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Userdata ID')
    ->addColumn('ip', Varien_Db_Ddl_Table::TYPE_BIGINT, null, array(
        ), 'User IP')
    ->addColumn('http_user_agent', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'HTTP User Agent')
    ->addColumn('cookie', Varien_Db_Ddl_Table::TYPE_TEXT, 32, array(
        'nullable'  => false,
        ), 'Cookie')
    ->setComment('Userdata');
$this->getConnection()->createTable($table);

$this->endSetup();
$this->syncReviews();
