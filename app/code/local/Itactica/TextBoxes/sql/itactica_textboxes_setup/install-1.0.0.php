<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_TextBoxes
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('itactica_textboxes/box'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Text Box ID')
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Title')

    ->addColumn('identifier', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Identifier')

    ->addColumn('columns', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'unsigned'  => true,
        ), 'Number of Columns')

    ->addColumn('box_type', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        ), 'Type of Text Box')

    ->addColumn('background_color', Varien_Db_Ddl_Table::TYPE_TEXT, 7, array(
        'nullable'  => false,
        ), 'Background color of entire section')

    ->addColumn('padding_top', Varien_Db_Ddl_Table::TYPE_TEXT, 4, array(
        'nullable'  => true,
        ), 'Padding top')

    ->addColumn('padding_bottom', Varien_Db_Ddl_Table::TYPE_TEXT, 4, array(
        'nullable'  => true,
        ), 'Padding bottom')

    ->addColumn('icon_class_first', Varien_Db_Ddl_Table::TYPE_TEXT, 30, array(
        'nullable'  => false,
        ), 'First icon class name')

    ->addColumn('icon_class_second', Varien_Db_Ddl_Table::TYPE_TEXT, 30, array(
        'nullable'  => false,
        ), 'Second icon class name')

    ->addColumn('icon_class_third', Varien_Db_Ddl_Table::TYPE_TEXT, 30, array(
        'nullable'  => false,
        ), 'Third icon class name')

    ->addColumn('icon_color_first', Varien_Db_Ddl_Table::TYPE_TEXT, 7, array(
        'nullable'  => false,
        ), 'First icon color')

    ->addColumn('icon_color_second', Varien_Db_Ddl_Table::TYPE_TEXT, 7, array(
        'nullable'  => false,
        ), 'Second icon color')

    ->addColumn('icon_color_third', Varien_Db_Ddl_Table::TYPE_TEXT, 7, array(
        'nullable'  => false,
        ), 'Third icon color')

    ->addColumn('icon_style_first', Varien_Db_Ddl_Table::TYPE_TEXT, 30, array(
        'nullable'  => true,
        ), 'First icon style class name')

    ->addColumn('icon_style_second', Varien_Db_Ddl_Table::TYPE_TEXT, 30, array(
        'nullable'  => true,
        ), 'Second icon style class name')

    ->addColumn('icon_style_third', Varien_Db_Ddl_Table::TYPE_TEXT, 30, array(
        'nullable'  => true,
        ), 'Third icon style class name')

    ->addColumn('icon_size_first', Varien_Db_Ddl_Table::TYPE_TEXT, 3, array(
        'nullable'  => true,
        ), 'First icon font size')

    ->addColumn('icon_size_second', Varien_Db_Ddl_Table::TYPE_TEXT, 3, array(
        'nullable'  => true,
        ), 'Second icon font size')

    ->addColumn('icon_size_third', Varien_Db_Ddl_Table::TYPE_TEXT, 3, array(
        'nullable'  => true,
        ), 'Third icon font size')

    ->addColumn('icon_line_height_first', Varien_Db_Ddl_Table::TYPE_TEXT, 3, array(
        'nullable'  => true,
        ), 'First icon line height')

    ->addColumn('icon_line_height_second', Varien_Db_Ddl_Table::TYPE_TEXT, 3, array(
        'nullable'  => true,
        ), 'Second icon line height')

    ->addColumn('icon_line_height_third', Varien_Db_Ddl_Table::TYPE_TEXT, 3, array(
        'nullable'  => true,
        ), 'Third icon line height')

    ->addColumn('image_filename_first', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
        ), 'First image filename')

    ->addColumn('image_filename_second', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
        ), 'Second image filename')

    ->addColumn('image_filename_third', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
        ), 'Third image filename')

    ->addColumn('title_first', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
        ), 'Title of First Box')

    ->addColumn('title_second', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
        ), 'Title of Second Box')

    ->addColumn('title_third', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
        ), 'Title of Third Box')

    ->addColumn('title_color_first', Varien_Db_Ddl_Table::TYPE_TEXT, 7, array(
        'nullable'  => false,
        ), 'Title Color of First Box')

    ->addColumn('title_color_second', Varien_Db_Ddl_Table::TYPE_TEXT, 7, array(
        'nullable'  => false,
        ), 'Title Color of Second Box')

    ->addColumn('title_color_third', Varien_Db_Ddl_Table::TYPE_TEXT, 7, array(
        'nullable'  => false,
        ), 'Title Color of Third Box')

    ->addColumn('title_size_first', Varien_Db_Ddl_Table::TYPE_TEXT, 3, array(
        'nullable'  => true,
        ), 'Font Size of First Box Title')

    ->addColumn('title_size_second', Varien_Db_Ddl_Table::TYPE_TEXT, 3, array(
        'nullable'  => true,
        ), 'Font Size of Second Box Title')

    ->addColumn('title_size_third', Varien_Db_Ddl_Table::TYPE_TEXT, 3, array(
        'nullable'  => true,
        ), 'Font Size of Third Box Title')

    ->addColumn('title_style_first', Varien_Db_Ddl_Table::TYPE_TEXT, 10, array(
        'nullable'  => false,
        ), 'Title font-style of First Box')

    ->addColumn('title_style_second', Varien_Db_Ddl_Table::TYPE_TEXT, 10, array(
        'nullable'  => false,
        ), 'Title font-style of Second Box')

    ->addColumn('title_style_third', Varien_Db_Ddl_Table::TYPE_TEXT, 10, array(
        'nullable'  => false,
        ), 'Title font-style of Third Box')

    ->addColumn('title_weight_first', Varien_Db_Ddl_Table::TYPE_TEXT, 10, array(
        'nullable'  => false,
        ), 'Title font-weight of First Box')

    ->addColumn('title_weight_second', Varien_Db_Ddl_Table::TYPE_TEXT, 10, array(
        'nullable'  => false,
        ), 'Title font-weight of Second Box')

    ->addColumn('title_weight_third', Varien_Db_Ddl_Table::TYPE_TEXT, 10, array(
        'nullable'  => false,
        ), 'Title font-weight of Third Box')

    ->addColumn('text_first', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
        ), 'Text of First Box')

    ->addColumn('text_second', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
        ), 'Text of Second Box')

    ->addColumn('text_third', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
        ), 'Text of Third Box')

    ->addColumn('text_color_first', Varien_Db_Ddl_Table::TYPE_TEXT, 7, array(
        'nullable'  => false,
        ), 'Text Color of First Box')

    ->addColumn('text_color_second', Varien_Db_Ddl_Table::TYPE_TEXT, 7, array(
        'nullable'  => false,
        ), 'Text Color of Second Box')

    ->addColumn('text_color_third', Varien_Db_Ddl_Table::TYPE_TEXT, 7, array(
        'nullable'  => false,
        ), 'Text Color of Third Box')

    ->addColumn('text_size_first', Varien_Db_Ddl_Table::TYPE_TEXT, 3, array(
        'nullable'  => true,
        ), 'Text Size of First Box')

    ->addColumn('text_size_second', Varien_Db_Ddl_Table::TYPE_TEXT, 3, array(
        'nullable'  => true,
        ), 'Text Size of Second Box')

    ->addColumn('text_size_third', Varien_Db_Ddl_Table::TYPE_TEXT, 3, array(
        'nullable'  => true,
        ), 'Text Size of Third Box')

    ->addColumn('text_lineheight_first', Varien_Db_Ddl_Table::TYPE_TEXT, 3, array(
        'nullable'  => true,
        ), 'Text Line Height of First Box')

    ->addColumn('text_lineheight_second', Varien_Db_Ddl_Table::TYPE_TEXT, 3, array(
        'nullable'  => true,
        ), 'Text Line Height of Second Box')

    ->addColumn('text_lineheight_third', Varien_Db_Ddl_Table::TYPE_TEXT, 3, array(
        'nullable'  => true,
        ), 'Text Line Height of Third Box')

    ->addColumn('link_first', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
        ), 'Link of First Box')

    ->addColumn('link_second', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
        ), 'Link of Second Box')

    ->addColumn('link_third', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
        ), 'Link of Third Box')

    ->addColumn('link_text_first', Varien_Db_Ddl_Table::TYPE_TEXT, 100, array(
        'nullable'  => true,
        ), 'Link Text of First Box')

    ->addColumn('link_text_second', Varien_Db_Ddl_Table::TYPE_TEXT, 100, array(
        'nullable'  => true,
        ), 'Link Text of Second Box')

    ->addColumn('link_text_third', Varien_Db_Ddl_Table::TYPE_TEXT, 100, array(
        'nullable'  => true,
        ), 'Link Text of Third Box')

    ->addColumn('link_type_first', Varien_Db_Ddl_Table::TYPE_TEXT, 30, array(
        'nullable'  => false,
        ), 'Link Type for First Box')

    ->addColumn('link_type_second', Varien_Db_Ddl_Table::TYPE_TEXT, 30, array(
        'nullable'  => false,
        ), 'Link Type for Second Box')

    ->addColumn('link_type_third', Varien_Db_Ddl_Table::TYPE_TEXT, 30, array(
        'nullable'  => false,
        ), 'Link Type for Third Box')

    ->addColumn('button_bg_color_first', Varien_Db_Ddl_Table::TYPE_TEXT, 7, array(
        'nullable'  => false,
        ), 'Button Bg color for First Box')

    ->addColumn('button_bg_color_second', Varien_Db_Ddl_Table::TYPE_TEXT, 7, array(
        'nullable'  => false,
        ), 'Button Bg color for Second Box')

    ->addColumn('button_bg_color_third', Varien_Db_Ddl_Table::TYPE_TEXT, 7, array(
        'nullable'  => false,
        ), 'Button Bg color for Third Box')

    ->addColumn('button_text_color_first', Varien_Db_Ddl_Table::TYPE_TEXT, 7, array(
        'nullable'  => false,
        ), 'Button text color for First Box')

    ->addColumn('button_text_color_second', Varien_Db_Ddl_Table::TYPE_TEXT, 7, array(
        'nullable'  => false,
        ), 'Button text color for Second Box')

    ->addColumn('button_text_color_third', Varien_Db_Ddl_Table::TYPE_TEXT, 7, array(
        'nullable'  => false,
        ), 'Button text color for Third Box')

    ->addColumn('button_bgcolor_hover_first', Varien_Db_Ddl_Table::TYPE_TEXT, 7, array(
        'nullable'  => false,
        ), 'Button text color on hover for First Box')

    ->addColumn('button_bgcolor_hover_second', Varien_Db_Ddl_Table::TYPE_TEXT, 7, array(
        'nullable'  => false,
        ), 'Button text color on hover for Second Box')

    ->addColumn('button_bgcolor_hover_third', Varien_Db_Ddl_Table::TYPE_TEXT, 7, array(
        'nullable'  => false,
        ), 'Button text color on hover for Third Box')

    ->addColumn('button_textcolor_hover_first', Varien_Db_Ddl_Table::TYPE_TEXT, 7, array(
        'nullable'  => false,
        ), 'Button text color on hover for First Box')

    ->addColumn('button_textcolor_hover_second', Varien_Db_Ddl_Table::TYPE_TEXT, 7, array(
        'nullable'  => false,
        ), 'Button text color on hover for Second Box')

    ->addColumn('button_textcolor_hover_third', Varien_Db_Ddl_Table::TYPE_TEXT, 7, array(
        'nullable'  => false,
        ), 'Button text color on hover for Third Box')

    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        ), 'Box Status')

    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            ), 'Box Modification Time')

    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        ), 'Box Creation Time') 

    ->setComment('Text Boxes Table');
$this->getConnection()->createTable($table);

$table = $this->getConnection()
    ->newTable($this->getTable('itactica_textboxes/box_store'))
    ->addColumn('box_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'primary'   => true,
        ), 'Box ID')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Store ID')
    ->addIndex($this->getIdxName('itactica_textboxes/box_store', array('store_id')), array('store_id'))
    ->addForeignKey($this->getFkName('itactica_textboxes/box_store', 'box_id', 'itactica_textboxes/box', 'entity_id'), 'box_id', $this->getTable('itactica_textboxes/box'), 'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($this->getFkName('itactica_textboxes/box_store', 'store_id', 'core/store', 'store_id'), 'store_id', $this->getTable('core/store'), 'store_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Boxes To Store Linkage Table');
$this->getConnection()->createTable($table);

$this->endSetup();
