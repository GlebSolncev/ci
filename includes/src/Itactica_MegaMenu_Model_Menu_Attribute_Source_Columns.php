<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_MegaMenu
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_MegaMenu_Model_Menu_Attribute_Source_Columns extends Mage_Eav_Model_Entity_Attribute_Source_Table
{
    /**
     * get possible values
     * @access public
     * @param bool $withEmpty
     * @param bool $defaultValues
     * @return array
     */
    public function getAllOptions($withEmpty = true, $defaultValues = false){
        $options =  array(
            array(
                'label' => Mage::helper('itactica_megamenu')->__('6 Columns'),
                'value' => 6
            ),
            array(
                'label' => Mage::helper('itactica_megamenu')->__('5 Columns'),
                'value' => 5
            ),
            array(
                'label' => Mage::helper('itactica_megamenu')->__('4 Columns'),
                'value' => 4
            ),
            array(
                'label' => Mage::helper('itactica_megamenu')->__('3 Columns'),
                'value' => 3
            ),
            array(
                'label' => Mage::helper('itactica_megamenu')->__('2 Columns'),
                'value' => 2
            ),
            array(
                'label' => Mage::helper('itactica_megamenu')->__('1 Column'),
                'value' => 1
            ),
            array(
                'label' => Mage::helper('itactica_megamenu')->__('Hide Subcategories'),
                'value' => 10
            )
        );
        if ($withEmpty) {
            array_unshift($options, array('label'=>'', 'value'=>''));
        }
        return $options;

    }
    /**
     * get options as array
     * @access public
     * @param bool $withEmpty
     * @return string
     */
    public function getOptionsArray($withEmpty = true) {
        $options = array();
        foreach ($this->getAllOptions($withEmpty) as $option) {
            $options[$option['value']] = $option['label'];
        }
        return $options;
    }
    /**
     * get option text
     * @access public
     * @param mixed $value
     * @return string
     */
    public function getOptionText($value) {
        $options = $this->getOptionsArray();
        if (!is_array($value)) {
            $value = array($value);
        }
        $texts = array();
        foreach ($value as $v) {
            if (isset($options[$v])) {
                $texts[] = $options[$v];
            }
        }
        return implode(', ', $texts);
    }
}
