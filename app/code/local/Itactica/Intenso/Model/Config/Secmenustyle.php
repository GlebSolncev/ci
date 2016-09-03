<?php
/**
 * Intenso Premium Theme
 *
 * @category    Itactica
 * @package     Itactica_Intenso
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */
class Itactica_Intenso_Model_Config_Secmenustyle
{
    public function toOptionArray()
    {
        return array(
            array('value' => 0,
                  'label' => Mage::helper('itactica_intenso')->__('Dropdown')),

            array('value' => 1,
                  'label' => Mage::helper('itactica_intenso')->__('Top Ribbon'))           
        );
    }
}