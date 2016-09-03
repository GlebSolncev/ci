<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_FeaturedCategories
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_FeaturedCategories_Block_Adminhtml_Slider_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Initialize Tabs
     * @access public
     */
    public function __construct() {
        parent::__construct();
        $this->setId('slider_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('itactica_featuredcategories')->__('Ultimate Featured Categories'));
    }
    /**
     * before render html
     * @access protected
     * @return Itactica_FeaturedCategories_Block_Adminhtml_Slider_Edit_Tabs
     */
    protected function _beforeToHtml(){
        $this->addTab('form_slider', array(
            'label'        => Mage::helper('itactica_featuredcategories')->__('General Information'),
            'title'        => Mage::helper('itactica_featuredcategories')->__('General Information'),
            'content'     => $this->getLayout()->createBlock('itactica_featuredcategories/adminhtml_slider_edit_tab_form')->toHtml(),
        ));
        if (!Mage::app()->isSingleStoreMode()){
            $this->addTab('form_store_slider', array(
                'label'        => Mage::helper('itactica_featuredcategories')->__('Store views'),
                'title'        => Mage::helper('itactica_featuredcategories')->__('Store views'),
                'content'     => $this->getLayout()->createBlock('itactica_featuredcategories/adminhtml_slider_edit_tab_stores')->toHtml(),
            ));
        }
        $this->addTab('categories', array(
            'label' => Mage::helper('itactica_featuredcategories')->__('Featured Categories'),
            'url'   => $this->getUrl('*/*/categories', array('_current' => true)),
            'class'    => 'ajax'
        ));
        return parent::_beforeToHtml();
    }
    /**
     * Retrieve slider entity
     * @access public
     * @return Itactica_FeaturedCategories_Model_Slider
     */
    public function getSlider(){
        return Mage::registry('current_slider');
    }
}
