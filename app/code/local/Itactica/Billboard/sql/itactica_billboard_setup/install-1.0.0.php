<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_Billboard
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('itactica_billboard/billboard'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Billboard ID')
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Title')

    ->addColumn('identifier', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Identifier')

    ->addColumn('custom_classname', Varien_Db_Ddl_Table::TYPE_TEXT, 50, array(
        'nullable'  => false,
        ), 'Custom class name')

    ->addColumn('columns', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'unsigned'  => true,
        ), 'Number of Columns')

    ->addColumn('billboard_type', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        ), 'Type of billboard')

    ->addColumn('image_options_small', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        ), 'Image options for small screens')

    ->addColumn('image_options_medium', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        ), 'Image options for medium screens')

    ->addColumn('images_to_show', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Specific images to show on medium screens')

    ->addColumn('background_color', Varien_Db_Ddl_Table::TYPE_TEXT, 7, array(
        'nullable'  => false,
        ), 'Background color of entire section')

    ->addColumn('padding_top', Varien_Db_Ddl_Table::TYPE_TEXT, 4, array(
        'nullable'  => true,
        ), 'Padding top')

    ->addColumn('padding_bottom', Varien_Db_Ddl_Table::TYPE_TEXT, 4, array(
        'nullable'  => true,
        ), 'Padding bottom')

    ->addColumn('image_large_first', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
        ), 'First large image filename')

    ->addColumn('image_large_second', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
        ), 'Second lerge image filename')

    ->addColumn('image_large_third', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
        ), 'Third large image filename')

    ->addColumn('image_large_fourth', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
        ), 'Fourth large image filename')

    ->addColumn('image_medium_first', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
        ), 'First medium image filename')

    ->addColumn('image_medium_second', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
        ), 'Second medium image filename')

    ->addColumn('image_medium_third', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
        ), 'Third medium image filename')

    ->addColumn('image_medium_fourth', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
        ), 'Fourth medium image filename')

    ->addColumn('alt_first', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
        ), 'Alt tag of first image')

    ->addColumn('alt_second', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
        ), 'Alt tag of second image')

    ->addColumn('alt_third', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
        ), 'Alt tag of third image')

    ->addColumn('alt_fourth', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
        ), 'Alt tag of fourth image')

    ->addColumn('link_first', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
        ), 'Link of first image')

    ->addColumn('link_second', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
        ), 'Link of second image')

    ->addColumn('link_third', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
        ), 'Link of third image')

    ->addColumn('link_fourth', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
        ), 'Link of fourth image')

    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        ), 'Billboard status')

    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            ), 'Billboard modification time')

    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        ), 'Billboard Creation Time') 

    ->setComment('Billboards Table');
$this->getConnection()->createTable($table);

$table = $this->getConnection()
    ->newTable($this->getTable('itactica_billboard/billboard_store'))
    ->addColumn('billboard_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'primary'   => true,
        ), 'Billboard ID')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Store ID')
    ->addIndex($this->getIdxName('itactica_billboard/billboard_store', array('store_id')), array('store_id'))
    ->addForeignKey($this->getFkName('itactica_billboard/billboard_store', 'billboard_id', 'itactica_billboard/billboard', 'entity_id'), 'billboard_id', $this->getTable('itactica_billboard/billboard'), 'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($this->getFkName('itactica_billboard/billboard_store', 'store_id', 'core/store', 'store_id'), 'store_id', $this->getTable('core/store'), 'store_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Billboard To Store Linkage Table');
$this->getConnection()->createTable($table);

$this->endSetup();
