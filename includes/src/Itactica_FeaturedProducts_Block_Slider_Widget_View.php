<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_FeaturedProducts
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_FeaturedProducts_Block_Slider_Widget_View extends Mage_Catalog_Block_Product_Abstract implements Mage_Widget_Block_Interface
{
    const FORM_KEY_PLACEHOLDER = '%%form_key_placeholder%%';

    /**
     * Initialize block's cache
     */
    protected function _construct()
    {
        if (Mage::getStoreConfigFlag('itactica_featuredproducts/cache/cache_enabled')) {
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
            'FEATURED_PRODUCTS_'.strtoupper($identifier),
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
     * slider collection
     * @var Mage_Eav_Model_Entity_Collection_Abstract
     */
    protected $_slider;

    /**
     * product collection
     * @var Mage_Eav_Model_Entity_Collection_Abstract
     */
    protected $_productCollection;

    /**
     * category ids
     * @var array
     */
    protected $_categoryIds;

    /**
     * categories parent-child relationship
     * @var array
     */
    protected $_catRelation;

    /**
     * template route
     * @var string
     */
    protected $_htmlTemplate = 'itactica_featuredproducts/slider/widget/view.phtml';

    /**
     * Prepare slider widget
     * @access protected
     * @return Itactica_FeaturedProducts_Block_Slider_Widget_View
     */
    protected function _beforeToHtml() {
        parent::_beforeToHtml();
        $sliderId = $this->getData('slider_id');
        if ($sliderId) {
            $slider = Mage::getModel('itactica_featuredproducts/slider')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->load($sliderId);
            if ($slider->getStatus()) {
                $this->setCurrentSlider($slider);
                $this->_slider = $slider;
                $this->setTemplate($this->_htmlTemplate);
            }
            // set padding-top
            $paddingTopRatio = 0.232549504950495;
            $paddingTopPercentage = $paddingTopRatio * $slider->getImageHeight();
            $this->setPictureStyle('style="padding-top: ' . $paddingTopPercentage . '%;"');
        }
        return $this;
    }

    /**
     * Replace form_key by a placeholder
     * This prevent the block caching the form_key of the first user that refresh cache
     * @access protected
     * @return Itactica_FeaturedProducts_Block_Slider_Widget_View
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
     * @return Itactica_FeaturedProducts_Block_Slider_Widget_View
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
     * retrieve categories array (category_id => name)
     * @access public
     * @param int $level
     * @return array
     */
    public function getCategories($level = 2)
    {
        if (is_null($this->_productCollection)) {
            $this->_productCollection = $this->getProductCollection(0, false);
        }

        $storeId = (int) Mage::app()->getStore()->getId();
        $storeCode = Mage::app()->getStore($storeId)->getCode();
        $rootCategoryId = Mage::app()->getStore($storeCode)->getRootCategoryId();
        $cat = array();
        $parentCat = array();
        $catRelation = array();
        $arrayHelper = array();
        $categoryTabs = array();
        $sortHelper = array();
        $collection = $this->_productCollection;

        if (!$collection) return false;

        $categoryIds = array();
        foreach ($collection as $product) {
            if ($product->getCategoryIds()) {
                $categoryIds[] = $product->getCategoryIds();
            }
        }

        $subcategoryCollection = Mage::getModel('catalog/category')
            ->getCollection()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('entity_id',array('in' => $categoryIds))
            ->addAttributeToFilter('path',array('like' => '1/'.$rootCategoryId . '/%'));

        foreach ($subcategoryCollection as $category) {
            $parentCat[] = $category->getParentId();
            $cat[] = $category->getId();
            $arrayHelper[$category->getParentId()] = $category->getId();
            $catRelation[] = $arrayHelper;
            if ($category->getLevel() == $level) {
                $categoryTabs[$category->getId()] = $category->getName();
                $sortHelper[$category->getPosition()] = $category->getId();
            }
            unset($arrayHelper);
        }

        // all category ids from products in collection
        $this->_categoryIds = array_unique($cat);
        // parent > child
        $this->_catRelation = $catRelation;

        if ($this->_slider->getShowCategoryTabs()) {
            // sort array by category position
            ksort($sortHelper);
            $categoryNames = array_replace(array_flip($sortHelper), $categoryTabs);

            if (count($parentCat) > 1) {
                return $categoryNames;
            } else {
                return array('0');
            }
        }
        
        return array('0');
    }

    /**
     * retrieve product collection
     * @access public
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function getProductCollection($categoryId = 0, $applyLimit = true, $setImageFallback = false) 
    {
        if (!$this->_slider) return false;
        
        $store = Mage::app()->getStore()->getStoreId();
        $sort = $this->_slider->getProductFilter();

        switch ($sort) {
            case 1:
                $collection = $this->_getProductCollection($categoryId, 'best-sellers', $applyLimit, $setImageFallback);
                return $collection;
                break;

            case 2:
                $collection = $this->_getProductCollection($categoryId, 'rating', $applyLimit, $setImageFallback);
                return $collection;
                break;

            case 3:
                $collection = $this->_getProductCollection($categoryId, 'reviews', $applyLimit, $setImageFallback);
                return $collection;
                break;

            case 4:
                $collection = $this->_getProductCollection($categoryId, 'recent', $applyLimit, $setImageFallback);
                return $collection;
                break;

            case 5:
                $collection = $this->_getProductCollection($categoryId, 'position', $applyLimit, $setImageFallback);
                return $collection;
                break;

            default:
                $collection = $this->_getProductCollection($categoryId, 'recent', $applyLimit, $setImageFallback);
                return $collection;
        }
    }

    /**
     * get collection of products
     * @access public
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function _getProductCollection($categoryId, $sortBy = 'recent', $applyLimit, $setImageFallback)
    {
        $productsSource = $this->_slider->getProductsSource();
        $limit = $this->_slider->getLimit();
        if ($limit == 0) $limit = 50;
        $storeId = (int) Mage::app()->getStore()->getId();

        $collection = Mage::getResourceModel('catalog/product_collection')
            ->addStoreFilter()
            ->addMinimalPrice()
            ->addFinalPrice()
            ->addPriceData()
            ->addTaxPercents()
            ->addUrlRewrite()
            ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
            ->setVisibility(Mage::getSingleton('catalog/product_visibility')->getVisibleInCatalogIds())
            ->joinField('category_id', 'catalog/category_product', 'category_id', 'product_id = entity_id', null, 'left');

        if ($applyLimit) {
            $collection->setPageSize($limit);
        }

        $collection->getSelect()->group('e.entity_id');

        if ($productsSource == 2 && $categoryId == 0) { // specific category
            $selectedCategories = explode(',', $this->_slider->getCategoryIds());
            $collection->addFieldToFilter(array(array('attribute' => 'category_id', 'in' => array('finset' => $selectedCategories))));
        }

        if (!$this->_slider->getShowOutOfStock()) {
            Mage::getSingleton('cataloginventory/stock')->addInStockFilterToCollection($collection);
        }

        if ($productsSource == 3) { // specific products
            $select = $collection->getSelect()->join(
                array('specific_products' => $collection->getTable('itactica_featuredproducts/slider_product')),
                'e.entity_id = specific_products.product_id',
                array('slider_id')
            )
            ->where('specific_products.slider_id = ?', $this->_slider->getId())
            ->order('specific_products.position ASC');
        }

        if ($categoryId) {
            $_categoryIds = $this->_categoryIds;
            $_idsToExclude = array();
            foreach ($this->_catRelation as $key => $value) {
                foreach ($value as $parent => $child) {
                    if ($parent != $categoryId)
                        // add child's category ids that doesn't belong to parent category
                        $_idsToExclude[] = $child;
                }
            }
            $categoryIds = array_diff($_categoryIds, $_idsToExclude);
            if (empty($categoryIds)) $categoryIds = array($categoryId);
            $collection->addFieldToFilter(array(array('attribute' => 'category_id', 'in' => array('finset' => $categoryIds))));
        }

        if ($sortBy == 'rating') {
            $collection->joinField(
                'ratings', 
                Mage::getConfig()->getTablePrefix().'review_entity_summary', 
                'rating_summary', 
                'entity_pk_value=entity_id', 
                array('entity_type'=>1, 'store_id'=> $storeId), 
                'left');
            $collection->getSelect()->order('rating_summary DESC');
        } elseif ($sortBy == 'reviews') {
            $collection->joinField(
                'reviews_count', 
                Mage::getConfig()->getTablePrefix().'review_entity_summary', 
                'reviews_count', 
                'entity_pk_value=entity_id', 
                array('entity_type'=>1, 'store_id'=> $storeId), 
                'left');
            $collection->addAttributeToSort('reviews_count', 'desc');
        } elseif ($sortBy == 'best-sellers') {
            $bestsellers = Mage::getSingleton('core/resource')->getConnection('core_read')
                ->select()
                ->from('sales_flat_order_item', array('product_id', 'count' => 'SUM(`qty_ordered`)'))
                ->group('product_id');

            $collection->getSelect()
                ->joinLeft(array('bs' => $bestsellers),
                        'bs.product_id = e.entity_id')
                ->order('bs.count DESC');
        } elseif ($sortBy == 'position') {
            $collection->addAttributeToSort('position', 'desc');
        } else {
            $collection->addAttributeToSort('entity_id', 'desc');
        }

        if (Mage::helper('itactica_intenso')->isConfigSwatchesEnabled()) {
            /* @var $helper Mage_ConfigurableSwatches_Helper_Mediafallback */
            $helper = Mage::helper('configurableswatches/mediafallback');

            $products = $collection->getItems();
            $helper->attachChildrenProducts($products, $collection->getStoreId());
            $helper->attachConfigurableProductChildrenAttributeMapping($products, $collection->getStoreId());
            
            if ($setImageFallback) {
                $helper->attachGallerySetToCollection($products, $collection->getStoreId());

                /* @var $product Mage_Catalog_Model_Product */
                foreach ($products as $product) {
                    $helper->groupMediaGalleryImages($product);
                    Mage::helper('configurableswatches/productimg')
                        ->indexProductImages($product, $product->getListSwatchAttrValues());
                }

                $this->_productCollection = $collection;
            }
        }

        return $collection;
    }

    /**
     * get product image
     * @access public
     * @return string
     */
    public function getProductImage($product)
    {
        // set image
        if ($this->_slider->getEnableAdaptiveResize()) {
            if ($this->_slider->getAdaptiveResizePosition() == 2) {
                $cropPosition = 'top';
            } elseif ($this->getAdaptiveResizePosition() == 3) {
                $cropPosition = 'bottom';
            } else {
                $cropPosition = 'center';
            }
            $image = Mage::helper('itactica_intenso/image')
                ->init($product, 'small_image')
                ->setCropPosition($cropPosition)
                ->adaptiveResize(430, $this->_slider->getImageHeight());
        } else {
            $image = Mage::helper('catalog/image')
                ->init($product, 'small_image')
                ->resize(430, $this->_slider->getImageHeight());
        }
        return $image;
    }
}
