<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_TextBoxes
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_TextBoxes_Model_Box_Attribute_Source_Fontweight extends Mage_Eav_Model_Entity_Attribute_Source_Table
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
                'label' => Mage::helper('itactica_orbitslider')->__('Normal'),
                'value' => 'normal'
            ),
            array(
                'label' => Mage::helper('itactica_orbitslider')->__('Bold'),
                'value' => 'bold'
            ),
            array(
                'label' => Mage::helper('itactica_orbitslider')->__('Bolder'),
                'value' => 'bolder'
            ),
            array(
                'label' => Mage::helper('itactica_orbitslider')->__('Lighter'),
                'value' => 'lighter'
            ),
            array(
                'label' => Mage::helper('itactica_orbitslider')->__('100'),
                'value' => '100'
            ),
            array(
                'label' => Mage::helper('itactica_orbitslider')->__('200'),
                'value' => '200'
            ),
            array(
                'label' => Mage::helper('itactica_orbitslider')->__('300'),
                'value' => '300'
            ),
            array(
                'label' => Mage::helper('itactica_orbitslider')->__('400'),
                'value' => '400'
            ),
            array(
                'label' => Mage::helper('itactica_orbitslider')->__('500'),
                'value' => '500'
            ),
            array(
                'label' => Mage::helper('itactica_orbitslider')->__('600'),
                'value' => '600'
            ),
            array(
                'label' => Mage::helper('itactica_orbitslider')->__('700'),
                'value' => '700'
            ),
            array(
                'label' => Mage::helper('itactica_orbitslider')->__('800'),
                'value' => '800'
            ),
            array(
                'label' => Mage::helper('itactica_orbitslider')->__('900'),
                'value' => '900'
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
