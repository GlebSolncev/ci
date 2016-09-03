<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_CallToAction
 * @copyright   Copyright (c) 2014-2015 Itactica (https://www.getintenso.com)
 * @license     https://getintenso.com/license
 */

class Itactica_CallToAction_Block_Adminhtml_Cta_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Initialize Tabs
     * @access public
     */
    public function __construct() {
        parent::__construct();
        $this->setId('cta_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('itactica_calltoaction')->__('CallToAction'));
    }
    /**
     * before render html
     * @access protected
     * @return Itactica_CallToAction_Block_Adminhtml_Cta_Edit_Tabs
     */
    protected function _beforeToHtml(){
        $this->addTab('form_cta', array(
            'label'        => Mage::helper('itactica_calltoaction')->__('Content'),
            'title'        => Mage::helper('itactica_calltoaction')->__('Content'),
            'content'     => $this->getLayout()->createBlock('itactica_calltoaction/adminhtml_cta_edit_tab_form')->toHtml(),
        ));
        if (!Mage::app()->isSingleStoreMode()){
            $this->addTab('form_store_cta', array(
                'label'        => Mage::helper('itactica_calltoaction')->__('Store views'),
                'title'        => Mage::helper('itactica_calltoaction')->__('Store views'),
                'content'     => $this->getLayout()->createBlock('itactica_calltoaction/adminhtml_cta_edit_tab_stores')->toHtml(),
            ));
        }
        return parent::_beforeToHtml();
    }
    /**
     * Retrieve calltoaction entity
     * @access public
     * @return Itactica_CallToAction_Model_CallToAction
     */
    public function getCta(){
        return Mage::registry('current_calltoaction');
    }
}
