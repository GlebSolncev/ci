<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_TextBoxes
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_TextBoxes_Block_Adminhtml_Box extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * constructor
     * @access public
     * @return void
     */
    public function __construct(){
        $this->_controller         = 'adminhtml_box';
        $this->_blockGroup         = 'itactica_textboxes';
        parent::__construct();
        $this->_headerText         = Mage::helper('itactica_textboxes')->__('Text Boxes');
        $this->_updateButton('add', 'label', Mage::helper('itactica_textboxes')->__('Add Text Box'));

    }
}
