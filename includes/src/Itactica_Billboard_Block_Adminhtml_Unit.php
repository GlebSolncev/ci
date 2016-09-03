<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_Billboard
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_Billboard_Block_Adminhtml_Unit extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * constructor
     * @access public
     * @return void
     */
    public function __construct(){
        $this->_controller         = 'adminhtml_unit';
        $this->_blockGroup         = 'itactica_billboard';
        parent::__construct();
        $this->_headerText         = Mage::helper('itactica_billboard')->__('Billboard');
        $this->_updateButton('add', 'label', Mage::helper('itactica_billboard')->__('Add Billboard'));
    }
}
