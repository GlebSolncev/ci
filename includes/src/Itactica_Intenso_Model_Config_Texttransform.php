<?php
/**
 * Intenso Premium Theme
 *
 * @category    Itactica
 * @package     Itactica_Intenso
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */
class Itactica_Intenso_Model_Config_Texttransform
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'none',
                  'label' => Mage::helper('itactica_intenso')->__('None')),

            array('value' => 'capitalize',
                  'label' => Mage::helper('itactica_intenso')->__('Capitalize')),

            array('value' => 'uppercase',
                  'label' => Mage::helper('itactica_intenso')->__('Uppercase')),

            array('value' => 'lowercase',
                  'label' => Mage::helper('itactica_intenso')->__('Lowercase'))
        );
    }
}