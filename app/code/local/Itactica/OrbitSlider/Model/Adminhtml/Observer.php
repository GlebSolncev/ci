<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_OrbitSlider
 * @copyright   Copyright (c) 2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_OrbitSlider_Model_Adminhtml_Observer
{
    /**
     * save slider - slides relation
     * @access public
     * @param Varien_Event_Observer $observer
     * @return Itactica_OrbitSlider_Model_Adminhtml_Observer
     */
    public function saveSlideSliderData($observer){
        $post = Mage::app()->getRequest()->getPost('slides', -1);
        if ($post != '-1') {
            $post = Mage::helper('adminhtml/js')->decodeGridSerializedInput($post);
            $slider = Mage::registry('current_slider');
            $sliderSlides = Mage::getResourceSingleton('itactica_orbitslider/slider_slides')->saveSlidesRelation($slider, $post);
        }
        return $this;
    }
}
