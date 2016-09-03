<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_LogoSlider
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_LogoSlider_Block_Adminhtml_Slider_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Initialize Tabs
     * @access public
     */
    public function __construct() {
        parent::__construct();
        $this->setId('slider_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('itactica_logoslider')->__('Sliders'));
    }
    /**
     * before render html
     * @access protected
     * @return Itactica_LogoSlider_Block_Adminhtml_Slider_Edit_Tabs
     */
    protected function _beforeToHtml(){
        $this->addTab('form_slider', array(
            'label'     => Mage::helper('itactica_logoslider')->__('General Information'),
            'title'     => Mage::helper('itactica_logoslider')->__('General Information'),
            'content'   => $this->getLayout()->createBlock('itactica_logoslider/adminhtml_slider_edit_tab_form')->toHtml(),
        ));
        if (!Mage::app()->isSingleStoreMode()){
            $this->addTab('form_store_slider', array(
                'label'       => Mage::helper('itactica_logoslider')->__('Store views'),
                'title'       => Mage::helper('itactica_logoslider')->__('Store views'),
                'content'     => $this->getLayout()->createBlock('itactica_logoslider/adminhtml_slider_edit_tab_stores')->toHtml(),
            ));
        }
        $this->addTab('related', array(
            'label'     => Mage::helper('itactica_logoslider')->__('Images'),
            'url'       => $this->getUrl('*/*/logos', array('_current' => true)),
            'class'     => 'ajax',
        ));
        return parent::_beforeToHtml();
    }
    /**
     * Retrieve brand sliders entity
     * @access public
     * @return Itactica_LogoSlider_Model_Slider
     */
    public function getSlider(){
        return Mage::registry('current_slider');
    }
}
