<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_TextBoxes
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_TextBoxes_Block_View extends Mage_Catalog_Block_Product_Abstract
{
    const FORM_KEY_PLACEHOLDER = '%%form_key_placeholder%%';

    /**
     * Initialize block's cache
     */
    protected function _construct()
    {
        if (Mage::getStoreConfigFlag('itactica_textboxes/cache/cache_enabled')) {
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
            'TEXT_BOXES_'.strtoupper($identifier),
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
     * Prepare box widget
     * @access protected
     * @return Itactica_TextBoxes_Block_Box_Widget_View
     */
    protected function _beforeToHtml() {
        parent::_beforeToHtml();
        $helper = Mage::helper('itactica_textboxes');
        $identifier = $this->getData('identifier');
        if ($identifier) {
            $box = Mage::getModel('itactica_textboxes/box')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->loadByIdentifier($identifier);
            if ($box->getStatus()) {
                $this->setCurrentBox($box);

                // box class
                $this->setClassFirst($box->getIconClassFirst() . ' ' . $box->getIconStyleFirst());
                $this->setClassSecond($box->getIconClassSecond() . ' ' . $box->getIconStyleSecond());
                $this->setClassThird($box->getIconClassThird() . ' ' . $box->getIconStyleThird());

                // first box inline css
                $iconTagSizeFirst = round($box->getIconSizeFirst() * 1.68);
                if ($box->getIconStyleFirst() == 'icon-solidcircle'
                    || $box->getIconStyleFirst() == 'icon-solidsquare') {
                    $styleFirst = 'color: '. $helper->hex($box->getBackgroundColor()) . '; background-color: ' . $helper->hex($box->getIconColorFirst());
                } else {
                    $styleFirst = 'color: '. $helper->hex($box->getIconColorFirst());
                }
                if ($box->getIconSizeFirst()) {
                    $styleFirst .= '; font-size: ' . $box->getIconSizeFirst().'px';
                } 
                if ($box->getIconLineHeightFirst()) {
                    $styleFirst .= '; line-height: ' . $box->getIconLineHeightFirst().'px';
                }
                if ($box->getIconStyleFirst() == 'icon-circle' || $box->getIconStyleFirst() == 'icon-square') {
                    $styleFirst .= '; border-color: ' . $helper->hex($box->getIconColorFirst());
                }
                if ($iconTagSizeFirst > 0) {
                    $styleFirst .= '; width: ' . $iconTagSizeFirst . 'px; height: ' . $iconTagSizeFirst . 'px';
                }
                $this->setStyleFirst($styleFirst);

                // second box inline css
                $iconTagSizeSecond = round($box->getIconSizeSecond() * 1.68);
                if ($box->getIconStyleSecond() == 'icon-solidcircle'
                    || $box->getIconStyleSecond() == 'icon-solidsquare') {
                    $styleSecond = 'color: '. $helper->hex($box->getBackgroundColor())  . '; background-color: ' . $helper->hex($box->getIconColorSecond());
                } else {
                    $styleSecond = 'color: '. $helper->hex($box->getIconColorSecond());
                }
                if ($box->getIconSizeSecond()) {
                    $styleSecond .= '; font-size: ' . $box->getIconSizeSecond().'px';
                } 
                if ($box->getIconLineHeightSecond()) {
                    $styleSecond .= '; line-height: ' . $box->getIconLineHeightSecond().'px';
                }
                if ($box->getIconStyleSecond() == 'icon-circle' || $box->getIconStyleSecond() == 'icon-square') {
                    $styleSecond .= '; border-color: ' . $helper->hex($box->getIconColorSecond());
                }
                if ($iconTagSizeSecond > 0) {
                    $styleSecond .= '; width: ' . $iconTagSizeSecond . 'px; height: ' . $iconTagSizeSecond . 'px';
                }
                $this->setStyleSecond($styleSecond);

                // third box inline css
                $iconTagSizeThird = round($box->getIconSizeThird() * 1.68);
                if ($box->getIconStyleThird() == 'icon-solidcircle'
                    || $box->getIconStyleThird() == 'icon-solidsquare') {
                    $styleThird = 'color: '. $helper->hex($box->getBackgroundColor()) . '; background-color: ' . $helper->hex($box->getIconColorThird());
                } else {
                    $styleThird = 'color: '. $helper->hex($box->getIconColorThird());
                }
                if ($box->getIconSizeThird()) {
                    $styleThird .= '; font-size: ' . $box->getIconSizeThird().'px';
                } 
                if ($box->getIconLineHeightThird()) {
                    $styleThird .= '; line-height: ' . $box->getIconLineHeightThird().'px';
                }
                if ($box->getIconStyleThird() == 'icon-circle' || $box->getIconStyleThird() == 'icon-square') {
                    $styleThird .= '; border-color: ' . $helper->hex($box->getIconColorThird());
                }
                if ($iconTagSizeThird > 0) {
                    $styleThird .= '; width: ' . $iconTagSizeThird . 'px; height: ' . $iconTagSizeThird . 'px';
                }
                $this->setStyleThird($styleThird);
            }
        }
        return $this;
    }

    /**
     * Replace form_key by a placeholder
     * This prevent the block caching the form_key of the first user that refresh cache
     * @access protected
     * @return Itactica_TextBoxes_Block_Box_Widget_View
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
     * @return Itactica_TextBoxes_Block_Box_Widget_View
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
     * Get links HTML
     * @access public
     * @return Itactica_TextBoxes_Block_Box_Widget_View
     */
    public function getLink($column) {
        $helper = Mage::helper('itactica_textboxes');
        $box = $this->getCurrentBox();
        $_link = '';
        if ($column == 1) {
            if ($box->getLinkFirst() && $box->getLinkTextFirst()) {
                $_link = '<p><a href="' . $box->getLinkFirst() . '"';
                $_link .= ' class="' . $box->getLinkTypeFirst() . '"';
                if ($box->getLinkTypeFirst() != 'arrow-right') {
                    $_link .= ' data-colorover="' . $helper->hex($box->getButtonTextcolorHoverFirst()) . '"';
                    $_link .= ' data-colorout="' . $helper->hex($box->getButtonTextColorFirst()) . '"';
                    $_link .= ' data-bgover="' . $helper->hex($box->getButtonBgcolorHoverFirst()) . '"';
                    $_link .= ' data-bgout="' . $helper->hex($box->getButtonBgColorFirst()) . '"';
                    $_link .= ' style="color: ' . $helper->hex($box->getButtonTextColorFirst()) . ' !important';
                    if (strpos($box->getLinkTypeFirst(),'ghost') !== false) {
                        $_link .= '; border-color: ';
                    } else {
                        $_link .= '; background-color: ';
                    }
                    $_link .= $helper->hex($box->getButtonBgColorFirst()) . ' !important;"';
                } elseif ($box->getTextSizeFirst() > 0) {
                    $_link .= ' style="font-size: ' . $box->getTextSizeFirst() .'px;"';
                }
                $_link .= '>' . $box->getLinkTextFirst() . '</a></p>';
            }
        }
        if ($column == 2) {
            if ($box->getLinkSecond() && $box->getLinkTextSecond()) {
                $_link = '<p><a href="' . $box->getLinkSecond() . '"';
                $_link .= ' class="' . $box->getLinkTypeSecond() . '"';
                if ($box->getLinkTypeSecond() != 'arrow-right') {
                    $_link .= ' data-colorover="' . $helper->hex($box->getButtonTextcolorHoverSecond()) . '"';
                    $_link .= ' data-colorout="' . $helper->hex($box->getButtonTextColorSecond()) . '"';
                    $_link .= ' data-bgover="' . $helper->hex($box->getButtonBgcolorHoverSecond()) . '"';
                    $_link .= ' data-bgout="' . $helper->hex($box->getButtonBgColorSecond()) . '"';
                    $_link .= ' style="color: ' . $helper->hex($box->getButtonTextColorSecond()) . ' !important';
                    if (strpos($box->getLinkTypeSecond(),'ghost') !== false) {
                        $_link .= '; border-color: ';
                    } else {
                        $_link .= '; background-color: ';
                    }
                    $_link .= $helper->hex($box->getButtonBgColorSecond()) . ' !important;"';
                } elseif ($box->getTextSizeSecond() > 0) {
                    $_link .= ' style="font-size: ' . $box->getTextSizeSecond() .'px;"';
                }
                $_link .= '>' . $box->getLinkTextSecond() . '</a></p>';
            }
        }
        if ($column == 3) {
            if ($box->getLinkThird() && $box->getLinkTextThird()) {
                $_link = '<p><a href="' . $box->getLinkThird() . '"';
                $_link .= ' class="' . $box->getLinkTypeThird() . '"';
                if ($box->getLinkTypeThird() != 'arrow-right') {
                    $_link .= ' data-colorover="' . $helper->hex($box->getButtonTextcolorHoverThird()) . '"';
                    $_link .= ' data-colorout="' . $helper->hex($box->getButtonTextColorThird()) . '"';
                    $_link .= ' data-bgover="' . $helper->hex($box->getButtonBgcolorHoverThird()) . '"';
                    $_link .= ' data-bgout="' . $helper->hex($box->getButtonBgColorThird()) . '"';
                    $_link .= ' style="color: ' . $helper->hex($box->getButtonTextColorThird()) . ' !important';
                    if (strpos($box->getLinkTypeThird(),'ghost') !== false) {
                        $_link .= '; border-color: ';
                    } else {
                        $_link .= '; background-color: ';
                    }
                    $_link .= $helper->hex($box->getButtonBgColorThird()) . ' !important;"';
                } elseif ($box->getTextSizeThird() > 0) {
                    $_link .= ' style="font-size: ' . $box->getTextSizeThird() .'px;"';
                }
                $_link .= '>' . $box->getLinkTextThird() . '</a></p>';
            }
        }
        return $_link;
    }

    /**
     * Check if any of the links is a button
     * @access public
     * @return boolean
     */
    public function linkIsButton() {
        $box = $this->getCurrentBox();
        if ($box->getLinkTypeFirst() == 'arrow-right'
            && $box->getLinkTypeSecond() == 'arrow-right'
            && $box->getLinkTypeThird() == 'arrow-right') {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Return margin-left size for left-aligned boxes
     * @access public
     * @return string
     */
    public function getMarginLeft($column) {
        $box = $this->getCurrentBox();
        if ($box->getBoxType() == 2) {
            if ($column == 1) {
                return ' margin-left: ' . ($box->getIconSizeFirst() + 30) . 'px;';
            } elseif ($column == 2) {
                return ' margin-left: ' . ($box->getIconSizeSecond() + 30) . 'px;';
            } elseif ($column == 3) {
                return ' margin-left: ' . ($box->getIconSizeThird() + 30) . 'px;';
            }
        }
    }
}