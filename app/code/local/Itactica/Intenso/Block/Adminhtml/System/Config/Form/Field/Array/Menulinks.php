<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_Intenso
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_Intenso_Block_Adminhtml_System_Config_Form_Field_Array_Menulinks extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{
    protected $staticBlocks;

    public function __construct() {
        // create columns
        $this->addColumn('menu_item', array(
            'label' => Mage::helper('adminhtml')->__('Name'),
            'size' => 16,
        ));
        $this->addColumn('url', array(
            'label' => Mage::helper('adminhtml')->__('URL Key'),
            'size' => 20
        ));
        $this->addColumn('static_block', array(
            'label' => Mage::helper('adminhtml')->__('Static Block'),
            'size' => 20
        ));
        $this->_addAfter = false;
        $this->_addButtonLabel = Mage::helper('adminhtml')->__('Add menu item');

        parent::__construct();
        $this->setTemplate('itactica/intenso/system/config/form/field/array_dropdown.phtml');

        // static blocks
        $blocks = Mage::getModel('cms/block')->getCollection()
            ->addFieldToFilter('is_active', 1);

        $this->staticBlocks = array();
        foreach ($blocks as $key => $value) {
            $this->staticBlocks[$value->getIdentifier()] = $value->getTitle();
        }
        asort($this->staticBlocks); // sort labels alphabetically
        array_unshift($this->staticBlocks, "None");
    }

    protected function _renderCellTemplate($columnName) {
        if (empty($this->_columns[$columnName])) {
            throw new Exception('Wrong column name specified.');
        }
        $column = $this->_columns[$columnName];
        $inputName = $this->getElement()->getName() . '[#{_id}][' . $columnName . ']';

        if ($columnName == 'static_block') {
            $rendered = '<select name="' . $inputName . '">';
            foreach ($this->staticBlocks as $att => $name) {
                $rendered .= '<option value="' . $att . '">' . addslashes($name) . '</option>';
            }
            $rendered .= '</select>';
        } else {
            return '<input type="text" name="' . $inputName . '" value="#{' . $columnName . '}" ' . ($column['size'] ? 'size="' . $column['size'] . '"' : '') . '/>';
        }

        return $rendered;
    }
}


