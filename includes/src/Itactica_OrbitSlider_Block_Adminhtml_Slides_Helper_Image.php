<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_OrbitSlider
 * @copyright   Copyright (c) 2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_OrbitSlider_Block_Adminhtml_Slides_Helper_Image extends Varien_Data_Form_Element_Image
{
    /**
     * get the url of the image
     * @access protected
     * @return string
     */
    protected function _getUrl(){
        $url = false;
        if ($this->getValue()) {
            $url = Mage::helper('itactica_orbitslider/slides_image')->getImageBaseUrl().$this->getValue();
        }
        return $url;
    }
}
