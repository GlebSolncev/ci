<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_TextBoxes
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_TextBoxes_Model_Box_Attribute_Source_Linktype extends Mage_Eav_Model_Entity_Attribute_Source_Table
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
                'label' => Mage::helper('itactica_featuredproducts')->__('Regular link'),
                'value' => 'arrow-right'
            ),
            array(
                'label' => Mage::helper('itactica_featuredproducts')->__('Button tiny'),
                'value' => 'button tiny'
            ),
            array(
                'label' => Mage::helper('itactica_featuredproducts')->__('Button small'),
                'value' => 'button small'
            ),
            array(
                'label' => Mage::helper('itactica_featuredproducts')->__('Button regular'),
                'value' => 'button'
            ),
            array(
                'label' => Mage::helper('itactica_featuredproducts')->__('Button large'),
                'value' => 'button large'
            ),
            array(
                'label' => Mage::helper('itactica_featuredproducts')->__('Button ghost tiny'),
                'value' => 'button ghost tiny'
            ),
            array(
                'label' => Mage::helper('itactica_featuredproducts')->__('Button ghost small'),
                'value' => 'button ghost small'
            ),
            array(
                'label' => Mage::helper('itactica_featuredproducts')->__('Button ghost regular'),
                'value' => 'button ghost'
            ),
            array(
                'label' => Mage::helper('itactica_featuredproducts')->__('Button ghost large'),
                'value' => 'button ghost large'
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
