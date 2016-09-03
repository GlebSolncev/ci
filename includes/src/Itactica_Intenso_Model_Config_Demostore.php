<?php
/**
 * Intenso Premium Theme
 *
 * @category    Itactica
 * @package     Itactica_Intenso
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */
class Itactica_Intenso_Model_Config_Demostore
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'demo',
                  'label' => Mage::helper('itactica_intenso')->__('Clothing Store')),

            array('value' => 'electronics',
                  'label' => Mage::helper('itactica_intenso')->__('Electronics Store')),

            array('value' => 'makeup',
                  'label' => Mage::helper('itactica_intenso')->__('Makeup Store')),

            array('value' => 'furniture',
                  'label' => Mage::helper('itactica_intenso')->__('Furniture Store'))             
        );
    }
}