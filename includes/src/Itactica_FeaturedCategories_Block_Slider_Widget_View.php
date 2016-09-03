<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_FeaturedCategories
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_FeaturedCategories_Block_Slider_Widget_View extends Mage_Catalog_Block_Product_Abstract implements Mage_Widget_Block_Interface
{
    const FORM_KEY_PLACEHOLDER = '%%form_key_placeholder%%';

    /**
     * Initialize block's cache
     */
    protected function _construct()
    {
        if (Mage::getStoreConfigFlag('itactica_featuredcategories/cache/cache_enabled')) {
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
            'FEATURED_CATEGORIES_'.strtoupper($identifier),
            Mage::app()->getStore()->getId(),
            Mage::getModel('catalog/layer')->getCurrentCategory()->getUrlKey(),
            (int)Mage::app()->getStore()->isCurrentlySecure(),
            Mage::getDesign()->getPackageName(),
            Mage::getDesign()->getTheme('template'),
            Mage::app()->getStore()->getCurrentCurrencyCode(),
            Mage::getSingleton('customer/session')->isLoggedIn()
        );

        return $cacheArray;
    }

    /**
     * slider collection
     * @var Mage_Eav_Model_Entity_Collection_Abstract
     */
    protected $_slider;

    /**
     * template route
     * @var string
     */
    protected $_htmlTemplate = 'itactica_featuredcategories/slider/widget/view.phtml';

    /**
     * Prepare slider widget
     * @access protected
     * @return Itactica_FeaturedCategories_Block_Slider_Widget_View
     */
    protected function _beforeToHtml() {
        parent::_beforeToHtml();
        $sliderId = $this->getData('slider_id');
        if ($sliderId) {
            $_slider = Mage::getModel('itactica_featuredcategories/slider')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->load($sliderId);
            if ($_slider->getStatus()) {
                $slider[] = $_slider;
                $this->setSlider($slider);
                $this->_slider = $slider;
                $this->setTemplate($this->_htmlTemplate);
            }
        }
        return $this;
    }

    /**
     * Replace form_key by a placeholder
     * This prevent the block caching the form_key of the first user that refresh cache
     * @access protected
     * @return Itactica_FeaturedCategories_Block_Slider_Widget_View
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
     * @return Itactica_FeaturedCategories_Block_Slider_Widget_View
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
     * get categories for slider
     * @access public
     * @param Itactica_FeaturedCategories_Model_Slider $slider
     * @return Itactica_FeaturedCategories_Model_Resource_Slider_Category_Collection
     */
    public function getCategoryCollection($sliderId){
        $collection = Mage::getResourceModel('itactica_featuredcategories/slider_category_collection')
            ->addSliderFilter($sliderId)
            ->addAttributeToSelect('*');
        $constraint = '{{table}}.slider_id='.$sliderId;
        $collection->joinField('position',
            'itactica_featuredcategories/slider_category',
            'position',
            'category_id=entity_id',
            $constraint,
            'left');

        $collection->addAttributeToSort('position', 'ASC');
        return $collection;
    }
}
