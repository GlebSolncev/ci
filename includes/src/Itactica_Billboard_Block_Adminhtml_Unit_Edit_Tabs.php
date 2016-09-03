<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_Billboard
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_Billboard_Block_Adminhtml_Unit_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Initialize Tabs
     * @access public
     */
    public function __construct() {
        parent::__construct();
        $this->setId('unit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('itactica_billboard')->__('Billboard'));
    }
    /**
     * before render html
     * @access protected
     * @return Itactica_Billboard_Block_Adminhtml_Unit_Edit_Tabs
     */
    protected function _beforeToHtml(){
        $this->addTab('form_unit', array(
            'label'        => Mage::helper('itactica_billboard')->__('Content'),
            'title'        => Mage::helper('itactica_billboard')->__('Content'),
            'content'     => $this->getLayout()->createBlock('itactica_billboard/adminhtml_unit_edit_tab_form')->toHtml(),
        ));
        if (!Mage::app()->isSingleStoreMode()){
            $this->addTab('form_store_unit', array(
                'label'        => Mage::helper('itactica_billboard')->__('Store views'),
                'title'        => Mage::helper('itactica_billboard')->__('Store views'),
                'content'     => $this->getLayout()->createBlock('itactica_billboard/adminhtml_unit_edit_tab_stores')->toHtml(),
            ));
        }
        return parent::_beforeToHtml();
    }
    /**
     * Retrieve billboard entity
     * @access public
     * @return Itactica_Billboard_Model_Billboard
     */
    public function getUnit(){
        return Mage::registry('current_billboard');
    }
}
