<?php
/**
 * Intenso Premium Theme
 *
 * @category    Itactica
 * @package     Itactica_Intenso
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */
class Itactica_Intenso_Model_Config_Mainmenustyle
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'horizontal',
                  'label' => Mage::helper('itactica_intenso')->__('Horizontal')),

            array('value' => 'vertical',
                  'label' => Mage::helper('itactica_intenso')->__('Vertical'))           
        );
    }
}