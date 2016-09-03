<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_FeaturedCategories
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_FeaturedCategories_Block_View extends Mage_Catalog_Block_Product_Abstract
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
        $identifier = $this->getData('identifier');
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
     * Prepare slider
     * @access protected
     * @return Itactica_FeaturedCategories_Block_View
     */
    protected function _beforeToHtml() {
        parent::_beforeToHtml();
        $identifier = $this->getData('identifier');
        $category  = Mage::registry('current_category');
        if ($identifier) {
            $_slider = Mage::getModel('itactica_featuredcategories/slider')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->loadByIdentifier($identifier);
            if ($_slider->getStatus()) {
                $slider[] = $_slider;
                $this->setSlider($slider);
                $this->_slider = $slider;
            }
        } elseif ($categorySliderIds = $category->getData('featured_category_slider')) {
            $categorySliderIds = explode(',',$categorySliderIds);
            foreach ($categorySliderIds as $id) {
                $_slider = Mage::getModel('itactica_featuredcategories/slider')
                    ->setStoreId(Mage::app()->getStore()->getId())
                    ->load($id);
                if ($_slider->getStatus()) {
                    $position = $_slider->getPosition();
                    if (isset($slider[$position])) {
                        $slider[] = $_slider;
                    } else {
                        $slider[$position] = $_slider;
                    }
                }
            }
            if (isset($slider) && is_array($slider)) {
                ksort($slider);
                $this->setSlider($slider);
                $this->_slider = $slider;
            }
        }
        return $this;
    }

    /**
     * Replace form_key by a placeholder
     * This prevent the block caching the form_key of the first user that refresh cache
     * @access protected
     * @return Itactica_FeaturedCategories_Block_View
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
     * @return Itactica_FeaturedCategories_Block_View
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
