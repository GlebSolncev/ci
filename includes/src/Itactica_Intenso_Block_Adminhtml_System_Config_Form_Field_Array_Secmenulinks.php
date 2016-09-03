<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_Intenso
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_Intenso_Block_Adminhtml_System_Config_Form_Field_Array_Secmenulinks extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{
    public function __construct() {
        // create columns
        $this->addColumn('menu_item', array(
            'label' => Mage::helper('adminhtml')->__('Name'),
            'size' => 40,
        ));
        $this->addColumn('url', array(
            'label' => Mage::helper('adminhtml')->__('URL Key'),
            'size' => 40
        ));
        $this->_addAfter = false;
        $this->_addButtonLabel = Mage::helper('adminhtml')->__('Add menu item');

        parent::__construct();
        $this->setTemplate('itactica/intenso/system/config/form/field/array_dropdown.phtml');
    }

    protected function _renderCellTemplate($columnName) {
        if (empty($this->_columns[$columnName])) {
            throw new Exception('Wrong column name specified.');
        }
        $column = $this->_columns[$columnName];
        $inputName = $this->getElement()->getName() . '[#{_id}][' . $columnName . ']';

        return '<input type="text" name="' . $inputName . '" value="#{' . $columnName . '}" ' . ($column['size'] ? 'size="' . $column['size'] . '"' : '') . '/>';
    }
}


