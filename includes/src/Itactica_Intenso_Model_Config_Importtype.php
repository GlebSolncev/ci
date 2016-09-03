<?php
/**
 * Intenso Premium Theme
 *
 * @category    Itactica
 * @package     Itactica_Intenso
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */
class Itactica_Intenso_Model_Config_Importtype
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'all',
                  'label' => Mage::helper('itactica_intenso')->__('All')),

            array('value' => 'products',
                  'label' => Mage::helper('itactica_intenso')->__('Products and Categories')),

            array('value' => 'cmspages',
                  'label' => Mage::helper('itactica_intenso')->__('CMS Pages')),

            array('value' => 'staticblocks',
                  'label' => Mage::helper('itactica_intenso')->__('Static Blocks')),

            array('value' => 'imagesliders',
                  'label' => Mage::helper('itactica_intenso')->__('Image Sliders')),

            array('value' => 'logosliders',
                  'label' => Mage::helper('itactica_intenso')->__('Logo Sliders')),

            array('value' => 'textboxes',
                  'label' => Mage::helper('itactica_intenso')->__('Text Boxes')),

            array('value' => 'billboard',
                  'label' => Mage::helper('itactica_intenso')->__('Billboards')),

            array('value' => 'calltoaction',
                  'label' => Mage::helper('itactica_intenso')->__('CallToActions')),

            array('value' => 'configuration',
                  'label' => Mage::helper('itactica_intenso')->__('Configuration Options')),
        );
    }
}