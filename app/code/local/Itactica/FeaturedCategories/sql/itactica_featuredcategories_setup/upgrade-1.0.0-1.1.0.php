<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_FeaturedCategories
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

$this->startSetup();

// on some installations the default attribute "thumbnail" is missing due to an unknown bug.
// addAttribute() will check whether the attribute exists and will insert or update it accordingly
$this->addAttribute('catalog_category', 'thumbnail', array(
    'type'          => 'varchar',
    'label'         => 'Thumbnail Image',
    'input'         => 'image',
    'backend'       => 'catalog/category_attribute_backend_image',
    'required'      => false,
    'sort_order'    => 4,
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'group'         => 'General Information'
));

$this->endSetup();
