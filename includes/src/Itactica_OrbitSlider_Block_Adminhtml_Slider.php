<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_OrbitSlider
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_OrbitSlider_Block_Adminhtml_Slider extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * constructor
     * @access public
     * @return void
     */
    public function __construct(){
        $this->_controller         = 'adminhtml_slider';
        $this->_blockGroup         = 'itactica_orbitslider';
        parent::__construct();
        $this->_headerText         = Mage::helper('itactica_orbitslider')->__('Image Sliders');
        $this->_updateButton('add', 'label', Mage::helper('itactica_orbitslider')->__('Add Slider'));

    }
}
