<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_LogoSlider
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_LogoSlider_Block_Adminhtml_Logo_Helper_Image extends Varien_Data_Form_Element_Image
{
    /**
     * get the url of the image
     * @access protected
     * @return string
     */
    protected function _getUrl(){
        $url = false;
        if ($this->getValue()) {
            $url = Mage::helper('itactica_logoslider/logo_image')->getImageBaseUrl().$this->getValue();
        }
        return $url;
    }
}
