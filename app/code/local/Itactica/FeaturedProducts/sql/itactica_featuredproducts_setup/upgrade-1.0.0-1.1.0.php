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
    $this->getTable('itactica_featuredproducts/slider'),
    'image_height',
    array(
        'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '404',
        'comment'   => 'Image height'
    )
);

$this->getConnection()->addColumn(
    $this->getTable('itactica_featuredproducts/slider'),
    'has_padding',
    array(
        'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '1',
        'comment'   => 'Has padding around image'
    )
);

$this->getConnection()->addColumn(
    $this->getTable('itactica_featuredproducts/slider'),
    'enable_adaptive_resize',
    array(
        'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        'comment'   => 'Enable adaptive resize'
    )
);

$this->getConnection()->addColumn(
    $this->getTable('itactica_featuredproducts/slider'),
    'adaptive_resize_position',
    array(
        'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '1',
        'comment'   => 'Adaptive resize position'
    )
);

// add custom class field
$this->getConnection()->addColumn(
    $this->getTable('itactica_featuredproducts/slider'),
    'custom_classname',
    array(
        'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length'    => 50,
        'nullable'  => false,
        'comment'   => 'Custom class name'
    )
);

$this->endSetup();
