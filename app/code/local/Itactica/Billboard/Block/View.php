<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_Billboard
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_Billboard_Block_View extends Mage_Catalog_Block_Product_Abstract
{
    const FORM_KEY_PLACEHOLDER = '%%form_key_placeholder%%';

    /**
     * Initialize block's cache
     */
    protected function _construct()
    {
        if (Mage::getStoreConfigFlag('itactica_billboard/cache/cache_enabled')) {
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
            'BILLBOARD_'.strtoupper($identifier),
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
     * Prepare billboard widget
     * @access protected
     * @return Itactica_Billboard_Block_Unit_Widget_View
     */
    protected function _beforeToHtml() {
        parent::_beforeToHtml();
        $identifier = $this->getData('identifier');
        if ($identifier) {
            $unit = Mage::getModel('itactica_billboard/unit')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->loadByIdentifier($identifier);
            if ($unit->getStatus()) {
                $this->setCurrentBillboard($unit);

                // get visibility of images for small and medium screens
                $hideForMediumOnly = array();
                $showForMediumUp = array();
                $showForLargeUp = array();
                $arraySmall = array(1,2,3,4);
                $arrayMedium = array(1,2,3,4);
                $imagesSmall = $unit->getImageOptionsSmall();
                $imagesMedium = $unit->getImageOptionsMedium();
                if ($imagesSmall > 1 && $imagesSmall < 6) {
                    unset($arraySmall[$imagesSmall - 2]);
                }
                if ($imagesMedium == 2) {
                    $imagesToShow = explode(',', $unit->getImagesToShow());
                    $arrayMedium = array_intersect($arrayMedium, $imagesToShow);
                }
                if (($imagesSmall == 1 || $imagesSmall == 6) && $imagesMedium > 1) {
                    $hideForMediumOnly = array_diff($arraySmall, $arrayMedium);
                }
                if ($imagesSmall > 1 && $imagesSmall < 6) {
                    $showForMediumUp = array_intersect($arraySmall, $arrayMedium);
                }
                if ($imagesSmall > 1 && $imagesSmall < 6 && $imagesMedium > 1) {
                    $showForLargeUp = array_diff($arraySmall, $arrayMedium);
                    if ($imagesSmall > 1 && $imagesSmall < 6) {
                        $hideForMediumOnly = array_diff(array(1,2,3,4), $arrayMedium);
                    }
                }
                $colsForMedium = $unit->getColumns() - count($hideForMediumOnly) + 4 - $unit->getColumns();
                if ($imagesMedium == 1) {
                    $colsForMedium = 1;
                } else {
                    $colsForMedium = ($colsForMedium > 1) ? $colsForMedium : 1;
                }
                $mediumColumnCount = 12 / $colsForMedium;

                // get padding
                $inlineStyle = '';
                $paddingTop = '';
                $paddingBottom = '';
                if ($unit->getPaddingTop() >= 0) {
                    $paddingTop = 'padding-top: '.$unit->getPaddingTop().'px; ';
                }
                if ($unit->getPaddingBottom() >= 0) {
                    $paddingBottom = 'padding-bottom: '.$unit->getPaddingBottom().'px; ';
                }
                if ($unit->getPaddingTop() >= 0 || $unit->getPaddingBottom() >= 0) {
                    $inlineStyle = ' '.$paddingTop.$paddingBottom;
                }

                $this->setHideForMediumOnly($hideForMediumOnly);
                $this->setShowForMediumUp($showForMediumUp);
                $this->setShowForLargeUp($showForLargeUp);
                $this->setMediumColumnCount($mediumColumnCount);
                $this->setInlineStyle($inlineStyle);
            }
        }
        return $this;
    }

    /**
     * Replace form_key by a placeholder
     * This prevent the block caching the form_key of the first user that refresh cache
     * @access protected
     * @return Itactica_Billboard_Block_Box_Widget_View
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
     * @return Itactica_Billboard_Block_Box_Widget_View
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

}