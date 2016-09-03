<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_OrbitSlider
 * @copyright   Copyright (c) 2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_OrbitSlider_Block_Adminhtml_Slides_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Initialize Tabs
     * @access public
     */
    public function __construct() {
        parent::__construct();
        $this->setId('slides_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('itactica_orbitslider')->__('Slides'));
    }
    /**
     * before render html
     * @access protected
     * @return Itactica_OrbitSlider_Block_Adminhtml_Slides_Edit_Tabs
     */
    protected function _beforeToHtml(){
        $this->addTab('form_slide', array(
            'label'        => Mage::helper('itactica_orbitslider')->__('Slide Information'),
            'title'        => Mage::helper('itactica_orbitslider')->__('Slide Information'),
            'content'     => $this->getLayout()->createBlock('itactica_orbitslider/adminhtml_slides_edit_tab_form')->toHtml(),
        ));
        $this->addTab('form_images', array(
            'label'        => Mage::helper('itactica_orbitslider')->__('Images'),
            'title'        => Mage::helper('itactica_orbitslider')->__('Images'),
            'content'     => $this->getLayout()->createBlock('itactica_orbitslider/adminhtml_slides_edit_tab_images')->toHtml(),
        ));
        $this->addTab('form_content', array(
            'label'        => Mage::helper('itactica_orbitslider')->__('Content'),
            'title'        => Mage::helper('itactica_orbitslider')->__('Content'),
            'content'     => $this->getLayout()->createBlock('itactica_orbitslider/adminhtml_slides_edit_tab_content')->toHtml(),
        ));
        if (!Mage::app()->isSingleStoreMode()){
            $this->addTab('form_store_slide', array(
                'label'        => Mage::helper('itactica_orbitslider')->__('Store views'),
                'title'        => Mage::helper('itactica_orbitslider')->__('Store views'),
                'content'     => $this->getLayout()->createBlock('itactica_orbitslider/adminhtml_slides_edit_tab_stores')->toHtml(),
            ));
        }
        return parent::_beforeToHtml();
    }
    /**
     * Retrieve slide entity
     * @access public
     * @return Itactica_OrbitSlider_Model_Slides
     */
    public function getSlide(){
        return Mage::registry('current_slide');
    }
}
