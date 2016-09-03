<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_LogoSlider
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_LogoSlider_Model_Adminhtml_Observer
{
    /**
     * save slider - logos relation
     * @access public
     * @param Varien_Event_Observer $observer
     * @return Itactica_LogoSlider_Model_Adminhtml_Observer
     */
    public function saveLogoSliderData($observer){
        $post = Mage::app()->getRequest()->getPost('logos', -1);
        if ($post != '-1') {
            $post = Mage::helper('adminhtml/js')->decodeGridSerializedInput($post);
            $slider = Mage::registry('current_slider');
            $sliderLogos = Mage::getResourceSingleton('itactica_logoslider/slider_logos')->saveLogosRelation($slider, $post);
        }
        return $this;
    }
}
