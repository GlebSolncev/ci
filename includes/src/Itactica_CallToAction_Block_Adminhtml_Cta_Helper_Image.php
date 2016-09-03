<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_CallToAction
 * @copyright   Copyright (c) 2014-2015 Itactica (https://www.getintenso.com)
 * @license     https://getintenso.com/license
 */

class Itactica_CallToAction_Block_Adminhtml_Cta_Helper_Image extends Varien_Data_Form_Element_Image
{
    /**
     * get the url of the image
     * @access protected
     * @return string
     */
    protected function _getUrl(){
        $url = false;
        if ($this->getValue()) {
            $url = Mage::helper('itactica_calltoaction/image')->getImageBaseUrl().$this->getValue();
        }
        return $url;
    }
}
