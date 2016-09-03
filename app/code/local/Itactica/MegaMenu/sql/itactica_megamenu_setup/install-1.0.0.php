<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_MegaMenu
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

$this->startSetup();

$this->addAttribute('catalog_category', 'intenso_menu_style', array(
    'group'             => 'Menu',
    'backend'           => '',
    'frontend'          => '',
    'class'             => '',
    'default'           => '',
    'label'             => 'Menu Style',
    'input'             => 'select',
    'type'              => 'int',
    'source'            => 'itactica_megamenu/menu_attribute_source_menustyle',
    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'searchable'        => 0,
    'filterable'        => 0,
    'comparable'        => 0,
    'required'          => 0,
    'unique'            => 0,
    'user_defined'      => 1,
));

$this->addAttribute('catalog_category', 'intenso_menu_columns_large', array(
    'group'             => 'Menu',
    'backend'           => '',
    'frontend'          => '',
    'class'             => '',
    'default'           => '',
    'label'             => 'Number of Columns on Large Screens',
    'note'              => 'Sets the number of columns for the subcategories in the menu.',
    'input'             => 'select',
    'type'              => 'int',
    'source'            => 'itactica_megamenu/menu_attribute_source_columns',
    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'searchable'        => 0,
    'filterable'        => 0,
    'comparable'        => 0,
    'required'          => 0,
    'unique'            => 0,
    'user_defined'      => 1,
));

$this->addAttribute('catalog_category', 'intenso_menu_columns_medium', array(
    'group'             => 'Menu',
    'backend'           => '',
    'frontend'          => '',
    'class'             => '',
    'default'           => '',
    'label'             => 'Number of Columns on Medium Screens',
    'note'              => 'Sets the number of columns for the subcategories in the menu.',
    'input'             => 'select',
    'type'              => 'int',
    'source'            => 'itactica_megamenu/menu_attribute_source_columns',
    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'searchable'        => 0,
    'filterable'        => 0,
    'comparable'        => 0,
    'required'          => 0,
    'unique'            => 0,
    'user_defined'      => 1,
));

$this->addAttribute('catalog_category', 'intenso_menu_right_block_width', array(
    'group'             => 'Menu',
    'backend'           => '',
    'frontend'          => '',
    'class'             => '',
    'default'           => '',
    'label'             => 'Width of the Right Block',
    'note'              => 'Sets the width of the right block in pixels or percentage. <strong>Enter "px" or "%" after the number (e.g. 350px or 30%)</strong>',
    'input'             => 'text',
    'type'              => 'text',
    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'searchable'        => 0,
    'filterable'        => 0,
    'comparable'        => 0,
    'required'          => 0,
    'unique'            => 0,
    'user_defined'      => 1,
));

$this->addAttribute('catalog_category', 'intenso_menu_right_block', array(
    'group'             => 'Menu',
    'backend'           => '',
    'frontend'          => '',
    'class'             => '',
    'default'           => '',
    'label'             => 'Right Block',
    'input'             => 'textarea',
    'type'              => 'text',
    'wysiwyg_enabled'   => 1,
    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'searchable'        => 0,
    'filterable'        => 0,
    'comparable'        => 0,
    'required'          => 0,
    'unique'            => 0,
    'user_defined'      => 1,
    'visible_on_front'  => 1,
    'is_html_allowed_on_front'  => 1
));

$this->addAttribute('catalog_category', 'intenso_menu_top_block', array(
    'group'             => 'Menu',
    'backend'           => '',
    'frontend'          => '',
    'class'             => '',
    'default'           => '',
    'label'             => 'Top Block',
    'input'             => 'textarea',
    'type'              => 'text',
    'wysiwyg_enabled'   => 1,
    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'searchable'        => 0,
    'filterable'        => 0,
    'comparable'        => 0,
    'required'          => 0,
    'unique'            => 0,
    'user_defined'      => 1,
    'visible_on_front'  => 1,
    'is_html_allowed_on_front'  => 1
));

$this->addAttribute('catalog_category', 'intenso_menu_bottom_block', array(
    'group'             => 'Menu',
    'backend'           => '',
    'frontend'          => '',
    'class'             => '',
    'default'           => '',
    'label'             => 'Bottom Block',
    'input'             => 'textarea',
    'type'              => 'text',
    'wysiwyg_enabled'   => 1,
    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'searchable'        => 0,
    'filterable'        => 0,
    'comparable'        => 0,
    'required'          => 0,
    'unique'            => 0,
    'user_defined'      => 1,
    'visible_on_front'  => 1,
    'is_html_allowed_on_front'  => 1
));

$this->endSetup();
