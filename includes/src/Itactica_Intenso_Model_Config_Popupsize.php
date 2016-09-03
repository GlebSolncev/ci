<?php
/**
 * Intenso Premium Theme
 *
 * @category    Itactica
 * @package     Itactica_Intenso
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */
class Itactica_Intenso_Model_Config_Popupsize
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'small',
                  'label' => Mage::helper('itactica_intenso')->__('Small')),

            array('value' => 'medium',
                  'label' => Mage::helper('itactica_intenso')->__('Medium')),

            array('value' => 'large',
                  'label' => Mage::helper('itactica_intenso')->__('Large')), 

            array('value' => 'xlarge',
                  'label' => Mage::helper('itactica_intenso')->__('Extra Large'))            
        );
    }
}