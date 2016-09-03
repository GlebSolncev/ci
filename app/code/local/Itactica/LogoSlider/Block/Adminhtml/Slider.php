<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_LogoSlider
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_LogoSlider_Block_Adminhtml_Slider extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * constructor
     * @access public
     * @return void
     */
    public function __construct(){
        $this->_controller         = 'adminhtml_slider';
        $this->_blockGroup         = 'itactica_logoslider';
        parent::__construct();
        $this->_headerText         = Mage::helper('itactica_logoslider')->__('Logo Sliders');
        $this->_updateButton('add', 'label', Mage::helper('itactica_logoslider')->__('Add New Slider'));

    }
}
