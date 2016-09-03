<?php
/**
 * Intenso Premium Theme
 *
 * @category    Itactica
 * @package     Itactica_Intenso
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */
class Itactica_Intenso_Model_Config_Headerstyle
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'regular',
                  'label' => Mage::helper('itactica_intenso')->__('Regular')),

            array('value' => 'transparent',
                  'label' => Mage::helper('itactica_intenso')->__('Transparent'))           
        );
    }
}