<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_OrbitSlider
 * @copyright   Copyright (c) 2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_OrbitSlider_Block_Adminhtml_Slides extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * constructor
     * @access public
     * @return void
     */
    public function __construct(){
        $this->_controller         = 'adminhtml_slides';
        $this->_blockGroup         = 'itactica_orbitslider';
        parent::__construct();
        $this->_headerText         = Mage::helper('itactica_orbitslider')->__('Image Slides');
        $this->_updateButton('add', 'label', Mage::helper('itactica_orbitslider')->__('Add Slide'));

    }
}
