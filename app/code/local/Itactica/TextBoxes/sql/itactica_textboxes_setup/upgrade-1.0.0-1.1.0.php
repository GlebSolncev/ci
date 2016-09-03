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

// increase text_first field length
$this->getConnection()->changeColumn(
    $this->getTable('itactica_textboxes/box'), 
    'text_first', 'text_first', array(
        'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length'    => '64k',
        'comment'   => 'Text of First Box'
    )
);

// increase text_second field length
$this->getConnection()->changeColumn(
    $this->getTable('itactica_textboxes/box'), 
    'text_second', 'text_second', array(
        'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length'    => '64k',
        'comment'   => 'Text of Second Box'
    )
);

// increase text_third field length
$this->getConnection()->changeColumn(
    $this->getTable('itactica_textboxes/box'), 
    'text_third', 'text_third', array(
        'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length'    => '64k',
        'comment'   => 'Text of Third Box'
    )
);

// add custom class field
$this->getConnection()->addColumn(
    $this->getTable('itactica_textboxes/box'),
    'custom_classname',
    array(
        'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length'    => 50,
        'nullable'  => false,
        'comment'   => 'Custom class name'
    )
);

$this->endSetup();
