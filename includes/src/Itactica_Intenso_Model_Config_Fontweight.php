<?php
/**
 * Intenso Premium Theme
 *
 * @category    Itactica
 * @package     Itactica_Intenso
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */
class Itactica_Intenso_Model_Config_Fontweight
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'normal',
                  'label' => Mage::helper('itactica_intenso')->__('Normal')),

            array('value' => 'bold',
                  'label' => Mage::helper('itactica_intenso')->__('Bold')),

            array('value' => 'bolder',
                  'label' => Mage::helper('itactica_intenso')->__('Bolder')),

            array('value' => 'lighter',
                  'label' => Mage::helper('itactica_intenso')->__('Lighter')),

            array('value' => '100',
                  'label' => '100'),

            array('value' => '200',
                  'label' => '200'),

            array('value' => '300',
                  'label' => '300'),

            array('value' => '400',
                  'label' => '400'),

            array('value' => '500',
                  'label' => '500'),

            array('value' => '600',
                  'label' => '600'),

            array('value' => '700',
                  'label' => '700'),

            array('value' => '800',
                  'label' => '800'),

            array('value' => '900',
                  'label' => '900')            
        );
    }
}