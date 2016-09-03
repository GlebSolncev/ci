<?php
/**
 * Intenso Premium Theme
 *
 * @category    Itactica
 * @package     Itactica_Intenso
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */
class Itactica_Intenso_Model_Config_Fontfamily
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'google',
                  'label' => Mage::helper('itactica_intenso')->__('Google Fonts')),

            array('value' => 'custom',
                  'label' => Mage::helper('itactica_intenso')->__('Custom Stack')),

            array('value' => 'Arial, "Helvetica Neue", Helvetica, sans-serif',
                  'label' => Mage::helper('itactica_intenso')->__('Arial, "Helvetica Neue", Helvetica, sans-serif')),

            array('value' => 'Geneva, "Lucida Sans", "Lucida Grande", "Lucida Sans Unicode", Verdana, sans-serif',
                  'label' => Mage::helper('itactica_intenso')->__('Geneva, "Lucida Sans", "Lucida Grande", "Lucida Sans Unicode", Verdana, sans-serif')),

            array('value' => 'Baskerville, "Times New Roman", Times, serif',
                  'label' => Mage::helper('itactica_intenso')->__('Baskerville, "Times New Roman", Times, serif')),

            array('value' => '"Lucida Sans Unicode", "Lucida Grande", sans-serif',
                  'label' => Mage::helper('itactica_intenso')->__('"Lucida Sans Unicode", "Lucida Grande", sans-serif')),

            array('value' => '"Palatino Linotype", "Book Antiqua", Palatino, serif',
                  'label' => Mage::helper('itactica_intenso')->__('"Palatino Linotype", "Book Antiqua", Palatino, serif')),

            array('value' => 'Tahoma, Geneva, sans-serif',
                  'label' => Mage::helper('itactica_intenso')->__('Tahoma, Geneva, sans-serif')),

            array('value' => '"Trebuchet MS", Helvetica, sans-serif',
                  'label' => Mage::helper('itactica_intenso')->__('"Trebuchet MS", Helvetica, sans-serif'))

        );
    }
}