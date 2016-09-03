<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_CallToAction
 * @copyright   Copyright (c) 2014-2015 Itactica (https://www.getintenso.com)
 * @license     https://getintenso.com/license
 */

class Itactica_CallToAction_Block_Adminhtml_Cta extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * constructor
     * @access public
     * @return void
     */
    public function __construct(){
        $this->_controller         = 'adminhtml_cta';
        $this->_blockGroup         = 'itactica_calltoaction';
        parent::__construct();
        $this->_headerText         = Mage::helper('itactica_calltoaction')->__('CallToAction');
        $this->_updateButton('add', 'label', Mage::helper('itactica_calltoaction')->__('Add CallToAction'));
    }
}
