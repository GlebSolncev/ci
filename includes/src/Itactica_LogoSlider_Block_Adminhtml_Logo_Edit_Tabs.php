<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_LogoSlider
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_LogoSlider_Block_Adminhtml_Logo_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Initialize Tabs
     * @access public
     */
    public function __construct() {
        parent::__construct();
        $this->setId('logo_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('itactica_logoslider')->__('Images'));
    }
    /**
     * before render html
     * @access protected
     * @return Itactica_LogoSlider_Block_Adminhtml_Logo_Edit_Tabs
     */
    protected function _beforeToHtml(){
        $this->addTab('form_logo', array(
            'label'        => Mage::helper('itactica_logoslider')->__('General Information'),
            'title'        => Mage::helper('itactica_logoslider')->__('General Information'),
            'content'     => $this->getLayout()->createBlock('itactica_logoslider/adminhtml_logo_edit_tab_form')->toHtml(),
        ));
        if (!Mage::app()->isSingleStoreMode()){
            $this->addTab('form_store_logo', array(
                'label'        => Mage::helper('itactica_logoslider')->__('Store views'),
                'title'        => Mage::helper('itactica_logoslider')->__('Store views'),
                'content'     => $this->getLayout()->createBlock('itactica_logoslider/adminhtml_logo_edit_tab_stores')->toHtml(),
            ));
        }
        return parent::_beforeToHtml();
    }
    /**
     * Retrieve brand logos entity
     * @access public
     * @return Itactica_LogoSlider_Model_Logo
     */
    public function getLogo(){
        return Mage::registry('current_logo');
    }
}
