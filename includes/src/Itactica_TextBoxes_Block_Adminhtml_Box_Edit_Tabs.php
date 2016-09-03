<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_TextBoxes
 * @copyright   Copyright (c) 2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_TextBoxes_Block_Adminhtml_Box_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Initialize Tabs
     * @access public
     */
    public function __construct() {
        parent::__construct();
        $this->setId('box_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('itactica_textboxes')->__('Advanced Text Boxes'));
    }
    /**
     * before render html
     * @access protected
     * @return Itactica_TextBoxes_Block_Adminhtml_Box_Edit_Tabs
     */
    protected function _beforeToHtml(){
        $this->addTab('form_box', array(
            'label'        => Mage::helper('itactica_textboxes')->__('Content'),
            'title'        => Mage::helper('itactica_textboxes')->__('Content'),
            'content'     => $this->getLayout()->createBlock('itactica_textboxes/adminhtml_box_edit_tab_form')->toHtml(),
        ));
        if (!Mage::app()->isSingleStoreMode()){
            $this->addTab('form_store_box', array(
                'label'        => Mage::helper('itactica_textboxes')->__('Store views'),
                'title'        => Mage::helper('itactica_textboxes')->__('Store views'),
                'content'     => $this->getLayout()->createBlock('itactica_textboxes/adminhtml_box_edit_tab_stores')->toHtml(),
            ));
        }
        return parent::_beforeToHtml();
    }
    /**
     * Retrieve box entity
     * @access public
     * @return Itactica_TextBoxes_Model_Box
     */
    public function getBox(){
        return Mage::registry('current_box');
    }
}
