<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_OrbitSlider
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

$this->startSetup();

$this->getConnection()->addColumn(
    $this->getTable('itactica_orbitslider/slides'),
    'vertical_alignment',
    array(
        'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        'comment'   => 'Vertical alignment of text block'
    )
);

$this->getConnection()->addColumn(
    $this->getTable('itactica_orbitslider/slides'),
    'text_block_top',
    array(
        'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length'    => 10,
        'nullable'  => false,
        'comment'   => 'Text block top in pixels or percentage'
    )
);

// increase text_for_large field length
$this->getConnection()->changeColumn(
    $this->getTable('itactica_orbitslider/slides'), 
    'text_for_large', 'text_for_large', array(
        'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length'    => '64k',
        'comment'   => 'Text for medium and large screens'
    )
);

// increase text_for_small field length
$this->getConnection()->changeColumn(
    $this->getTable('itactica_orbitslider/slides'), 
    'text_for_small', 'text_for_small', array(
        'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length'    => '64k',
        'comment'   => 'Text for small screens'
    )
);

// add custom class field
$this->getConnection()->addColumn(
    $this->getTable('itactica_orbitslider/slider'),
    'custom_classname',
    array(
        'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length'    => 50,
        'nullable'  => false,
        'comment'   => 'Custom class name'
    )
);

$this->endSetup();
