<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_CallToAction
 * @copyright   Copyright (c) 2014-2015 Itactica (https://www.getintenso.com)
 * @license     https://getintenso.com/license
 */

$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('itactica_calltoaction/calltoaction'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'CallToAction ID')
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Title')

    ->addColumn('identifier', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Identifier')

    ->addColumn('custom_classname', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Custom class name')

    ->addColumn('full_width', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        ), 'Full width')

    ->addColumn('columns', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'unsigned'  => true,
        ), 'Columns distribution')

    ->addColumn('background_color', Varien_Db_Ddl_Table::TYPE_TEXT, 7, array(
        'nullable'  => false,
        ), 'Background color ')

    ->addColumn('background_image', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'First large image filename')

    ->addColumn('margin_top', Varien_Db_Ddl_Table::TYPE_TEXT, 5, array(
        'nullable'  => false,
        ), 'Margin top')

    ->addColumn('margin_bottom', Varien_Db_Ddl_Table::TYPE_TEXT, 5, array(
        'nullable'  => false,
        ), 'Margin bottom')

    ->addColumn('text', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Text')

    ->addColumn('text_color', Varien_Db_Ddl_Table::TYPE_TEXT, 7, array(
        'nullable'  => false,
        ), 'Text color')

    ->addColumn('font_size', Varien_Db_Ddl_Table::TYPE_TEXT, 6, array(
        'nullable'  => false,
        ), 'Font size')

    ->addColumn('font_style', Varien_Db_Ddl_Table::TYPE_TEXT, 10, array(
        'nullable'  => false,
        ), 'Text style')

    ->addColumn('font_weight', Varien_Db_Ddl_Table::TYPE_TEXT, 10, array(
        'nullable'  => false,
        ), 'Text weight')

    ->addColumn('text_lineheight', Varien_Db_Ddl_Table::TYPE_TEXT, 6, array(
        'nullable'  => false,
        ), 'Text line height')

    ->addColumn('button_type', Varien_Db_Ddl_Table::TYPE_TEXT, 20, array(
        'nullable'  => false,
        ), 'Button type')

    ->addColumn('link', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Button link')

    ->addColumn('link_target', Varien_Db_Ddl_Table::TYPE_TEXT, 10, array(
        'nullable'  => false,
        ), 'Link target')

    ->addColumn('button_text', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Button text')

    ->addColumn('button_text_color', Varien_Db_Ddl_Table::TYPE_TEXT, 7, array(
        'nullable'  => false,
        ), 'Button text color')

    ->addColumn('button_text_color_hover', Varien_Db_Ddl_Table::TYPE_TEXT, 7, array(
        'nullable'  => false,
        ), 'Button text color on hover')

    ->addColumn('button_background_color', Varien_Db_Ddl_Table::TYPE_TEXT, 7, array(
        'nullable'  => false,
        ), 'Button background color')

    ->addColumn('button_background_color_hover', Varien_Db_Ddl_Table::TYPE_TEXT, 7, array(
        'nullable'  => false,
        ), 'Button background color on hover')

    ->addColumn('button_border_color', Varien_Db_Ddl_Table::TYPE_TEXT, 7, array(
        'nullable'  => false,
        ), 'Button border color')

    ->addColumn('button_border_color_hover', Varien_Db_Ddl_Table::TYPE_TEXT, 7, array(
        'nullable'  => false,
        ), 'Button border color hover')

    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        ), 'CallToAction status')

    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            ), 'CallToAction modification time')

    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        ), 'CallToAction Creation Time') 

    ->setComment('CallToActions Table');
$this->getConnection()->createTable($table);

$table = $this->getConnection()
    ->newTable($this->getTable('itactica_calltoaction/calltoaction_store'))
    ->addColumn('calltoaction_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'primary'   => true,
        ), 'CallToAction ID')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Store ID')
    ->addIndex($this->getIdxName('itactica_calltoaction/calltoaction_store', array('store_id')), array('store_id'))
    ->addForeignKey($this->getFkName('itactica_calltoaction/calltoaction_store', 'calltoaction_id', 'itactica_calltoaction/calltoaction', 'entity_id'), 'calltoaction_id', $this->getTable('itactica_calltoaction/calltoaction'), 'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($this->getFkName('itactica_calltoaction/calltoaction_store', 'store_id', 'core/store', 'store_id'), 'store_id', $this->getTable('core/store'), 'store_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('CallToAction To Store Linkage Table');
$this->getConnection()->createTable($table);

$this->endSetup();
