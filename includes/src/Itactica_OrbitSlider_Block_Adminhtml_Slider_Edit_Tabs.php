<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_OrbitSlider
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_OrbitSlider_Block_Adminhtml_Slider_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Initialize Tabs
     * @access public
     */
    public function __construct() {
        parent::__construct();
        $this->setId('slider_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('itactica_orbitslider')->__('Image Slider'));
    }
    /**
     * before render html
     * @access protected
     * @return Itactica_OrbitSlider_Block_Adminhtml_Slider_Edit_Tabs
     */
    protected function _beforeToHtml(){
        $this->addTab('form_slider', array(
            'label'        => Mage::helper('itactica_orbitslider')->__('General Information'),
            'title'        => Mage::helper('itactica_orbitslider')->__('General Information'),
            'content'     => $this->getLayout()->createBlock('itactica_orbitslider/adminhtml_slider_edit_tab_form')->toHtml(),
        ));
        if (!Mage::app()->isSingleStoreMode()){
            $this->addTab('form_store_slider', array(
                'label'        => Mage::helper('itactica_orbitslider')->__('Store views'),
                'title'        => Mage::helper('itactica_orbitslider')->__('Store views'),
                'content'     => $this->getLayout()->createBlock('itactica_orbitslider/adminhtml_slider_edit_tab_stores')->toHtml(),
            ));
        }
        $this->addTab('related', array(
            'label'     => Mage::helper('itactica_orbitslider')->__('Slides'),
            'url'       => $this->getUrl('*/*/slides', array('_current' => true)),
            'class'     => 'ajax',
        ));
        $this->addTab('content_slider', array(
            'label'        => Mage::helper('itactica_orbitslider')->__('Advanced'),
            'title'        => Mage::helper('itactica_orbitslider')->__('Content'),
            'content'     => $this->getLayout()->createBlock('itactica_orbitslider/adminhtml_slider_edit_tab_content')->toHtml(),
        ));
        return parent::_beforeToHtml();
    }
    /**
     * Retrieve slider entity
     * @access public
     * @return Itactica_OrbitSlider_Model_Slider
     */
    public function getSlider(){
        return Mage::registry('current_slider');
    }
}
