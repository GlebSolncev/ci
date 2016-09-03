<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_OrbitSlider
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('itactica_orbitslider/slider'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Slider ID')
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Title')

    ->addColumn('identifier', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Identifier')

    ->addColumn('animation_type', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        ), 'Animation Type')

    ->addColumn('animation_speed', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'unsigned'  => true,
        ), 'Animation Speed')

    ->addColumn('timer_speed', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'unsigned'  => true,
        ), 'Timer Speed')

    ->addColumn('pause_on_hover', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        ), 'Pause on Hover')

    ->addColumn('circular', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        ), 'Loop')

    ->addColumn('swipe', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        ), 'Touch Swipe')

    ->addColumn('content', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
        'nullable'  => false,
        ), 'Content')

    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        ), 'Enabled')

     ->addColumn('status', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        ), 'Slider Status')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            ), 'Slider Modification Time')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        ), 'Slider Creation Time') 
    ->setComment('Slider Table');
$this->getConnection()->createTable($table);
$table = $this->getConnection()
    ->newTable($this->getTable('itactica_orbitslider/slider_store'))
    ->addColumn('slider_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'primary'   => true,
        ), 'Slider ID')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Store ID')
    ->addIndex($this->getIdxName('itactica_orbitslider/slider_store', array('store_id')), array('store_id'))
    ->addForeignKey($this->getFkName('itactica_orbitslider/slider_store', 'slider_id', 'itactica_orbitslider/slider', 'entity_id'), 'slider_id', $this->getTable('itactica_orbitslider/slider'), 'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($this->getFkName('itactica_orbitslider/slider_store', 'store_id', 'core/store', 'store_id'), 'store_id', $this->getTable('core/store'), 'store_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Sliders To Store Linkage Table');
$this->getConnection()->createTable($table);

$this->addAttribute('catalog_category', 'category_orbitslider', array(
    'backend'           => '',
    'frontend'          => '',
    'class'             => '',
    'default'           => '',
    'label'             => 'Image Slider',
    'input'             => 'select',
    'type'              => 'int',
    'source'            => 'itactica_orbitslider/slider_source',
    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'group'             => 'Display Settings',
    'sort-order'        => 25,
    'required'          => 0,
    'unique'            => 0,
    'user_defined'      => 1,
));

$this->endSetup();
