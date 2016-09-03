<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_LogoSlider
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_LogoSlider_Block_Slider_Widget_View extends Mage_Core_Block_Template implements Mage_Widget_Block_Interface
{
    protected $_htmlTemplate = 'itactica_logoslider/slider/widget/view.phtml';

    const FORM_KEY_PLACEHOLDER = '%%form_key_placeholder%%';

    /**
     * Initialize block's cache
     */
    protected function _construct()
    {
        if (Mage::getStoreConfigFlag('itactica_logoslider/cache/cache_enabled')) {
            $this->addData(array('cache_lifetime' => false));
            $this->addCacheTag(array(
                Mage_Core_Model_Store::CACHE_TAG,
                Mage_Cms_Model_Block::CACHE_TAG
            ));
        }
    }

    /**
     * Get cache key informative items
     *
     * @return array
     */
    public function getCacheKeyInfo()
    {
        $identifier = $this->getData('slider_id');
        $cacheArray = array(
            'LOGO_SLIDER_'.strtoupper($identifier),
            Mage::app()->getStore()->getId(),
            (int)Mage::app()->getStore()->isCurrentlySecure(),
            Mage::getDesign()->getPackageName(),
            Mage::getDesign()->getTheme('template'),
            Mage::app()->getStore()->getCurrentCurrencyCode(),
            Mage::getSingleton('customer/session')->isLoggedIn()
        );

        return $cacheArray;
    }

    /**
     * Prepare widget
     * @access protected
     * @return Itactica_LogoSlider_Block_Slider_Widget_View
     */
    protected function _beforeToHtml() {
        parent::_beforeToHtml();
        $sliderId = $this->getData('slider_id');
        if ($sliderId) {
            $slider = Mage::getModel('itactica_logoslider/slider')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->load($sliderId);
            if ($slider->getStatus()) {
                $this->setCurrentSlider($slider);
                $this->setTemplate($this->_htmlTemplate);
            }
        }
        return $this;
    }

    /**
     * Replace form_key by a placeholder
     * This prevent the block caching the form_key of the first user that refresh cache
     * @access protected
     * @return Itactica_LogoSlider_Block_Slider_Widget_View
     */
    protected function _toHtml() {
        $html = parent::_toHtml();
        $session = Mage::getSingleton('core/session');
        $formKey = $session->getFormKey();

        $html = str_replace(
            $formKey,
            self::FORM_KEY_PLACEHOLDER,
            $html
        );
        return $html;
    }

    /**
     * Replace placeholder by the user's form_key
     * @access protected
     * @return Itactica_LogoSlider_Block_Slider_Widget_View
     */
    protected function _afterToHtml($html) {
        $session = Mage::getSingleton('core/session');
        $formKey = $session->getFormKey();
        
        $html = str_replace(
            self::FORM_KEY_PLACEHOLDER,
            $formKey,
            $html
        );
        return $html;
    }

    /**
     * get logos collection
     * @access public
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function getLogos($sliderId)
    {
        return Mage::helper('itactica_logoslider')->getLogos($sliderId);
    }
}
