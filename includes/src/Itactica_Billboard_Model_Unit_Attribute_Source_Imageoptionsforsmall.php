<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_Billboard
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_Billboard_Model_Unit_Attribute_Source_Imageoptionsforsmall extends Mage_Eav_Model_Entity_Attribute_Source_Table
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
                'label' => Mage::helper('itactica_featuredproducts')->__('Show all images stacked'),
                'value' => 1
            ),
            array(
                'label' => Mage::helper('itactica_featuredproducts')->__('Show first image only'),
                'value' => 2
            ),
            array(
                'label' => Mage::helper('itactica_featuredproducts')->__('Show second image only'),
                'value' => 3
            ),
            array(
                'label' => Mage::helper('itactica_featuredproducts')->__('Show third image only'),
                'value' => 4
            ),
            array(
                'label' => Mage::helper('itactica_featuredproducts')->__('Show fourth image only'),
                'value' => 5
            ),
            array(
                'label' => Mage::helper('itactica_featuredproducts')->__('Show random image on every page load'),
                'value' => 6
            ),
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
