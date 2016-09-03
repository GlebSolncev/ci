<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_CallToAction
 * @copyright   Copyright (c) 2014-2015 Itactica (https://www.getintenso.com)
 * @license     https://getintenso.com/license
 */

class Itactica_CallToAction_Block_View extends Mage_Catalog_Block_Product_Abstract
{
    const FORM_KEY_PLACEHOLDER = '%%form_key_placeholder%%';

    /**
     * Initialize block's cache
     */
    protected function _construct()
    {
        if (Mage::getStoreConfigFlag('itactica_calltoaction/cache/cache_enabled')) {
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
        $identifier = $this->getData('identifier');
        $cacheArray = array(
            'CALLTOACTION_'.strtoupper($identifier),
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
     * Prepare calltoaction widget
     * @access protected
     * @return Itactica_CallToAction_Block_Cta_Widget_View
     */
    protected function _beforeToHtml() {
        parent::_beforeToHtml();
        $identifier = $this->getData('identifier');
        if ($identifier) {
            $cta = Mage::getModel('itactica_calltoaction/cta')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->loadByIdentifier($identifier);
            if ($cta->getStatus()) {
                $this->setCurrentCallToAction($cta);

                // set columns
                $columns = $cta->getColumns();
                if ($columns == 1) {
                    $mediumFirst = 6;
                    $largeFirst = 6;
                    $mediumSecond = 6;
                    $largeSecond = 6;
                } elseif ($columns == 2) {
                    $mediumFirst = 8;
                    $largeFirst = 7;
                    $mediumSecond = 4;
                    $largeSecond = 5;
                } elseif ($columns == 3) {
                    $mediumFirst = 9;
                    $largeFirst = 8;
                    $mediumSecond = 3;
                    $largeSecond = 4;
                } else {
                    $mediumFirst = 9;
                    $largeFirst = 10;
                    $mediumSecond = 3;
                    $largeSecond = 2;
                }

                $this->setMediumFirst($mediumFirst);
                $this->setLargeFirst($largeFirst);
                $this->setMediumSecond($mediumSecond);
                $this->setLargeSecond($largeSecond);
            }
        }
        return $this;
    }

    /**
     * Replace form_key by a placeholder
     * This prevent the block caching the form_key of the first user that refresh cache
     * @access protected
     * @return Itactica_CallToAction_Block_Box_Widget_View
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
     * @return Itactica_CallToAction_Block_Box_Widget_View
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
     * Get button data attributes
     * @access public
     * @return Itactica_CallToAction_Block_View
     */
    public function getDataAttr() {
        $cta = $this->getCurrentCallToAction();
        $_attr = '';
        if ($cta->getButtonType() != 'none') {
            $_attr .= ' data-colorover="' . $cta->getButtonTextColorHover() . '"';
            $_attr .= ' data-colorout="' . $cta->getButtonTextColor() . '"';
            $_attr .= ' data-bgover="' . $cta->getButtonBackgroundColorHover() . '"';
            if (strpos($cta->getButtonType(),'ghost') !== false) {
                $_attr .= ' data-bgout="transparent"';
            } else {
                $_attr .= ' data-bgout="' . $cta->getButtonBackgroundColor() . '"';
            }
            $_attr .= ' data-borderover="' . $cta->getButtonBorderColor() . '"';
            $_attr .= ' data-borderout="' . $cta->getButtonBorderColorHover() . '"';
            $_attr .= ' style="color: ' . $cta->getButtonTextColor() . ' !important';
            if (strpos($cta->getButtonType(),'ghost') !== false) {
                $_attr .= '; border-color: ' . $cta->getButtonBorderColor() . ' !important;"';
            } else {
                $_attr .= '; background-color: ' . $cta->getButtonBackgroundColor() . ' !important;"';
            }
        }
        return $_attr;
    }

}