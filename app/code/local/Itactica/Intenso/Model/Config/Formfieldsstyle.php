<?php
/**
 * Intenso Premium Theme
 *
 * @category    Itactica
 * @package     Itactica_Intenso
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */
class Itactica_Intenso_Model_Config_Formfieldsstyle
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'clformfields',
                  'label' => Mage::helper('itactica_intenso')->__('Classic')),

            array('value' => 'clrformfields',
                  'label' => Mage::helper('itactica_intenso')->__('Classic Rounded')),

            array('value' => 'mdformfields',
                  'label' => Mage::helper('itactica_intenso')->__('Material Design'))               
        );
    }
}