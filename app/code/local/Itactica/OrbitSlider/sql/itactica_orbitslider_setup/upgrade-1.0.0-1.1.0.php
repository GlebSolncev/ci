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

$this->getConnection()->addColumn(
    $this->getTable('itactica_orbitslider/slider'),
    'full_screen',
    array(
        'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        'comment'   => 'Full Screen'
    )
);

$this->getConnection()->addColumn(
    $this->getTable('itactica_orbitslider/slider'),
    'use_advanced',
    array(
        'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        'comment'   => 'Insert slides HTML manually'
    )
);

$table = $this->getConnection()
    ->newTable($this->getTable('itactica_orbitslider/slides'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Slide ID')

    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Name of the slide')

    ->addColumn('filename_for_large', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'Slide Image for large screens')

    ->addColumn('filename_for_medium', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'Slide Image for medium screens')

    ->addColumn('filename_for_small', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'Slide Image for small screens')

    ->addColumn('image_link', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Image link')

    ->addColumn('navigation_skin', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        ), 'Navigation Skin')

    ->addColumn('text_block_alignment', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Text Block Alignment')

    ->addColumn('custom_alignment', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        ), 'Custom block alignment')

    ->addColumn('title_for_large', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Title for medium and large screens')

    ->addColumn('title_for_large_color', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Color of title for medium and large screens')

    ->addColumn('title_for_large_size', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        ), 'Size of title for medium and large screens')

    ->addColumn('title_for_large_style', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Style of title for medium and large screens')

    ->addColumn('title_for_large_weight', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Font weight of title for medium and large screens')

    ->addColumn('text_for_large', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Text for medium and large screens')

    ->addColumn('text_for_large_color', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Color of text for medium and large screens')

    ->addColumn('text_for_large_size', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'nullable'  => false,
            ), 'Size of text for medium and large screens')

    ->addColumn('text_for_large_style', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Style of text for medium and large screens')

    ->addColumn('text_for_large_weight', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Font weight of text for medium and large screens')

    ->addColumn('text_block_color_for_small', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'Text block color for small screens')

    ->addColumn('title_for_small', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Title for small screens')

    ->addColumn('title_for_small_color', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Color of title for small screens')

    ->addColumn('title_for_small_size', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        ), 'Size of title for small screens')

    ->addColumn('title_for_small_style', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Style of title for small screens')

    ->addColumn('title_for_small_weight', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Font weight of title for small screens')

    ->addColumn('text_for_small', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Text for small screens')

    ->addColumn('text_for_small_color', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Color of text for small screens')

    ->addColumn('text_for_small_size', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'nullable'  => false,
            ), 'Size of text for small screens')

    ->addColumn('text_for_small_style', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Style of text for small screens')

    ->addColumn('text_for_small_weight', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Font weight of text for small screens')

    ->addColumn('button_one_text', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
        ), 'Text for button 1')

    ->addColumn('button_one_style', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Button 1 style')

    ->addColumn('button_one_size', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
        ), 'Button 1 size')

    ->addColumn('button_one_link', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Button 1 link')

    ->addColumn('button_one_text_color', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Button 1 text color')

    ->addColumn('button_one_text_color_hover', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Button 1 text color on hover')

    ->addColumn('button_one_background', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Button 1 background color')

    ->addColumn('button_one_background_hover', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Button 1 background color on hover')

    ->addColumn('button_two_text', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
        ), 'Text for button 2')

    ->addColumn('button_two_style', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Button 2 style')

    ->addColumn('button_two_size', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
        ), 'Button 2 size')

    ->addColumn('button_two_link', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Button 2 link')

    ->addColumn('button_two_text_color', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Button 2 text color')

    ->addColumn('button_two_text_color_hover', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Button 2 text color on hover')

    ->addColumn('button_two_background', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Button 2 background color')

    ->addColumn('button_two_background_hover', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Button 2 background color on hover')

    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        ), 'Slide Status')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            ), 'Slide Modification Time')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        ), 'Slide Creation Time') 
    ->setComment('Slides Table');
$this->getConnection()->createTable($table);

$table = $this->getConnection()
    ->newTable($this->getTable('itactica_orbitslider/slides_store'))
    ->addColumn('slide_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'primary'   => true,
        ), 'Slide ID')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Store ID')
    ->addIndex($this->getIdxName('itactica_orbitslider/slides_store', array('store_id')), array('store_id'))
    ->addForeignKey($this->getFkName('itactica_orbitslider/slides_store', 'slide_id', 'itactica_orbitslider/slides', 'entity_id'), 'slide_id', $this->getTable('itactica_orbitslider/slides'), 'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($this->getFkName('itactica_orbitslider/slides_store', 'store_id', 'core/store', 'store_id'), 'store_id', $this->getTable('core/store'), 'store_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Slides To Store Linkage Table');
$this->getConnection()->createTable($table);

$table = $this->getConnection()
    ->newTable($this->getTable('itactica_orbitslider/slider_slide'))
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
    ), 'Orbit Slider ID')
    ->addColumn('slide_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
    ), 'Slide ID')
    ->addColumn('position', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'default'   => '0',
    ), 'Position')
    ->addIndex($this->getIdxName('itactica_orbitslider/slider_slide', array('slide_id')), array('slide_id'))
    ->addForeignKey($this->getFkName('itactica_orbitslider/slider_slide', 'slider_id', 'itactica_orbitslider/slider', 'entity_id'), 'slider_id', $this->getTable('itactica_orbitslider/slider'), 'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($this->getFkName('itactica_orbitslider/slider_slide', 'slide_id', 'itactica_orbitslider/slides', 'entity_id'),    'slide_id', $this->getTable('itactica_orbitslider/slides'), 'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addIndex(
        $this->getIdxName(
            'itactica_orbitslider/slider_slide',
            array('slider_id', 'slide_id'),
            Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
        ),
        array('slider_id', 'slide_id'),
        array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))
    ->setComment('Orbit Slider to Slide Linkage Table');
$this->getConnection()->createTable($table);

$this->endSetup();
