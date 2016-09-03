<?php
/**
 * Intenso Premium Theme
 *
 * @category    Itactica
 * @package     Itactica_Intenso
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */
class Itactica_Intenso_Model_Config_Rating
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'turquoise',
                  'label' => Mage::helper('itactica_intenso')->__('Turquoise')),

            array('value' => 'yellow',
                  'label' => Mage::helper('itactica_intenso')->__('Yellow')),

            array('value' => 'red',
                  'label' => Mage::helper('itactica_intenso')->__('Red')),

            array('value' => 'green',
                  'label' => Mage::helper('itactica_intenso')->__('Green')),

            array('value' => 'blue',
                  'label' => Mage::helper('itactica_intenso')->__('Blue')),

            array('value' => 'gray',
                  'label' => Mage::helper('itactica_intenso')->__('Gray')),

            array('value' => 'purple',
                  'label' => Mage::helper('itactica_intenso')->__('Purple')),

            array('value' => 'pink',
                  'label' => Mage::helper('itactica_intenso')->__('Pink'))
        );
    }
}