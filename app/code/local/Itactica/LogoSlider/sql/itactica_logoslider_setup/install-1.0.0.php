<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_LogoSlider
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('itactica_logoslider/logo'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Brand Logos ID')
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Title')

    ->addColumn('filename', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'Logo Image')

    ->addColumn('search_by_key', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        ), 'Action When Logo is Clicked')

    ->addColumn('url_to_redirect', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'URL to Redirect on Click')

    ->addColumn('search_key', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Product Search Key')

    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        ), 'Enabled')

     ->addColumn('status', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        ), 'Brand Logos Status')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            ), 'Brand Logos Modification Time')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        ), 'Brand Logos Creation Time') 
    ->setComment('Brand Logos Table');
$this->getConnection()->createTable($table);

$table = $this->getConnection()
    ->newTable($this->getTable('itactica_logoslider/slider'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Brand Sliders ID')
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Title')

    ->addColumn('identifier', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Identifier')

    ->addColumn('min_item_width', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'unsigned'  => true,
        ), 'Minimum Width')

    ->addColumn('animation_speed', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'unsigned'  => true,
        ), 'Animation Speed')

    ->addColumn('show_bullets', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        ), 'Show Navigation Bullets')

    ->addColumn('show_arrows', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        ), 'Show Navigation Arrows')

    ->addColumn('swipe', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        ), 'Touch Swipe')

    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        ), 'Enabled')

     ->addColumn('status', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        ), 'Brand Sliders Status')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            ), 'Brand Sliders Modification Time')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        ), 'Brand Sliders Creation Time') 
    ->setComment('Brand Sliders Table');
$this->getConnection()->createTable($table);

$table = $this->getConnection()
    ->newTable($this->getTable('itactica_logoslider/logo_store'))
    ->addColumn('logo_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'primary'   => true,
        ), 'Brand Logos ID')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Store ID')
    ->addIndex($this->getIdxName('itactica_logoslider/logo_store', array('store_id')), array('store_id'))
    ->addForeignKey($this->getFkName('itactica_logoslider/logo_store', 'logo_id', 'itactica_logoslider/logo', 'entity_id'), 'logo_id', $this->getTable('itactica_logoslider/logo'), 'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($this->getFkName('itactica_logoslider/logo_store', 'store_id', 'core/store', 'store_id'), 'store_id', $this->getTable('core/store'), 'store_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Brand Logos To Store Linkage Table');
$this->getConnection()->createTable($table);

$table = $this->getConnection()
    ->newTable($this->getTable('itactica_logoslider/slider_store'))
    ->addColumn('slider_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'primary'   => true,
        ), 'Brand Sliders ID')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Store ID')
    ->addIndex($this->getIdxName('itactica_logoslider/slider_store', array('store_id')), array('store_id'))
    ->addForeignKey($this->getFkName('itactica_logoslider/slider_store', 'slider_id', 'itactica_logoslider/slider', 'entity_id'), 'slider_id', $this->getTable('itactica_logoslider/slider'), 'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($this->getFkName('itactica_logoslider/slider_store', 'store_id', 'core/store', 'store_id'), 'store_id', $this->getTable('core/store'), 'store_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Brand Sliders To Store Linkage Table');
$this->getConnection()->createTable($table);

$table = $this->getConnection()
    ->newTable($this->getTable('itactica_logoslider/slider_logos'))
    ->addColumn('rel_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Relation ID')
    ->addColumn('slider_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
    ), 'Brand Sliders ID')
    ->addColumn('logo_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
    ), 'Product ID')
    ->addColumn('position', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'default'   => '0',
    ), 'Position')
    ->addIndex($this->getIdxName('itactica_logoslider/slider_logos', array('logo_id')), array('logo_id'))
    ->addForeignKey($this->getFkName('itactica_logoslider/slider_logos', 'slider_id', 'itactica_logoslider/slider', 'entity_id'), 'slider_id', $this->getTable('itactica_logoslider/slider'), 'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($this->getFkName('itactica_logoslider/slider_logos', 'logo_id', 'itactica_logoslider/logo', 'entity_id'),    'logo_id', $this->getTable('itactica_logoslider/logo'), 'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addIndex(
        $this->getIdxName(
            'itactica_logoslider/slider_logos',
            array('slider_id', 'logo_id'),
            Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
        ),
        array('slider_id', 'logo_id'),
        array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))
    ->setComment('Brand Sliders to Logo Linkage Table');
$this->getConnection()->createTable($table);

$this->addAttribute('catalog_product', 'brand_logo', array(
    'group'             => 'General',
    'backend'           => '',
    'frontend'          => '',
    'class'             => '',
    'default'           => '',
    'label'             => 'Brand Logo',
    'input'             => 'select',
    'type'              => 'int',
    'source'            => 'itactica_logoslider/logo_source',
    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'is_configurable'   => false,
    'is_visible'        => 1,
    'required'          => 0,
    'searchable'        => 0,
    'filterable'        => 0,
    'unique'            => 0,
    'comparable'        => 0,
    'visible_on_front'  => 0,
    'user_defined'      => 1,
));

$this->addAttribute('catalog_category', 'category_logoslider', array(
    'backend'           => '',
    'frontend'          => '',
    'class'             => '',
    'default'           => '',
    'label'             => 'Logo Slider',
    'input'             => 'select',
    'type'              => 'int',
    'source'            => 'itactica_logoslider/slider_source',
    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'group'             => 'Display Settings',
    'sort-order'        => 28,
    'required'          => 0,
    'unique'            => 0,
    'user_defined'      => 1,
));
$this->endSetup();
