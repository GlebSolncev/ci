<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_LayeredNavigation
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_LayeredNavigation_Model_Catalog_Layer_Filter_Category extends Mage_Catalog_Model_Layer_Filter_Category
{
    /**
     * Get selected category object
     *
     * @return Mage_Catalog_Model_Category
     */
    public function getCategory()
    {
        if (!is_null($this->_categoryId)) {
            $category = Mage::getModel('catalog/category')
                ->load($this->_categoryId);
            if (count(explode(",", $category->getChildren())) == 1) {
                $category = $category->getParentCategory();
            }
            if ($category->getId()) {
                return $category;
            }
        }
        return $this->getLayer()->getCurrentCategory();
    }
    
    /**
     * Get data array for building category filter items
     *
     * @return array
     */
    protected function _getItemsData()
    {
        if (!Mage::helper('itactica_layerednavigation')->isEnabled()) {
            return parent::_getItemsData();
        }
        
        $key = $this->getLayer()->getStateKey().'_SUBCATEGORIES';
        $data = $this->getLayer()->getAggregator()->getCacheData($key);

        if ($data === null) {
            $category   = $this->getCategory();
            /** @var $category Mage_Catalog_Model_Category */
            $categories = $category->getChildrenCategories();

            $this->getLayer()->getProductCollection()
                ->addCountToCategories($categories);

            $data = array();
            $pageIdentifier = Mage::app()->getFrontController()->getAction()->getFullActionName();
            foreach ($categories as $category) {
                if ($pageIdentifier == 'catalogsearch_result_index' || $pageIdentifier == 'catalogsearch_advanced_result') {
                    $collection = Mage::getResourceModel('catalogsearch/fulltext_collection');
                    $this->prepareProductCollection($collection, $category->getId());
                    $collection->setVisibility(array(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH, Mage_Catalog_Model_Product_Visibility::VISIBILITY_IN_CATALOG));     
                    $collection->addFieldToFilter('status',Mage_Catalog_Model_Product_Status::STATUS_ENABLED);
                    $_categoryCount = $collection->getSize();
                } else {
                    $_categoryCount = $category->getProductCount();
                }

                if ($category->getIsActive() && $_categoryCount) {
                    $urlKey = $category->getUrlKey();
                    if (empty($urlKey)) {
                        $urlPath = explode('/',$category->getRequestPath());
                        if (is_array($urlPath) && end($urlPath)) {
                            $categoryUrlSuffix = Mage::helper('catalog/category')->getCategoryUrlSuffix();
                            $urlKey = str_replace($categoryUrlSuffix, '', end($urlPath));
                        } else {
                            $urlKey = $category->getId();
                        }
                    }

                    $data[] = array(
                        'label' => Mage::helper('core')->htmlEscape($category->getName()),
                        'value' => $urlKey,
                        'count' => $_categoryCount,
                    );
                }
            }
            $tags = $this->getLayer()->getStateTags();
            $this->getLayer()->getAggregator()->saveCacheData($data, $key, $tags);
        }
        return $data;
    }

    /**
     * Prepare product collection
     *
     * @param Mage_Catalog_Model_Resource_Eav_Resource_Product_Collection $collection
     * @return Mage_Catalog_Model_Layer
     */
    public function prepareProductCollection($collection, $categoryId)
    {
        $collection
            ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
            ->addSearchFilter(Mage::helper('catalogsearch')->getQuery()->getQueryText())
            ->joinField('category_id', 'catalog/category_product', 'category_id', 'product_id = entity_id', null, 'left')
            ->addAttributeToFilter('category_id', array('in' => $categoryId))
            ->setStore(Mage::app()->getStore())
            ->addMinimalPrice()
            ->addFinalPrice()
            ->addTaxPercents()
            ->addStoreFilter()
            ->addUrlRewrite();

        $collection->getSelect()->group('e.entity_id');

        if (Mage::helper('catalog/product_flat')->isEnabled()) {
            $collection->addFieldToFilter(array(array('attribute' => 'category_id', 'in' => array('finset' => $categoryId))));
        }

        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInSearchFilterToCollection($collection);

        return $this;
    }
    
    /**
     * Apply category filter to layer
     *
     * @param   Zend_Controller_Request_Abstract $request
     * @param   Mage_Core_Block_Abstract $filterBlock
     * @return  Mage_Catalog_Model_Layer_Filter_Category
     */
    public function apply(Zend_Controller_Request_Abstract $request, $filterBlock)
    {
        if (!Mage::helper('itactica_layerednavigation')->isEnabled()) {
            return parent::apply($request, $filterBlock);
        }
        
        $filter = $request->getParam($this->getRequestVar());
        if (!$filter) {
            return $this;
        }
        
        // Load the category filter by url_key
        $this->_appliedCategory = Mage::getModel('catalog/category')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->loadByAttribute('url_key', $filter);

        // Extra check in case it is a category id and not url key
        if (! ($this->_appliedCategory instanceof Mage_Catalog_Model_Category)) {
            return parent::apply($request, $filterBlock);
        }        
        
        $this->_categoryId = $this->_appliedCategory->getId();
        Mage::register('current_category_filter', $this->getCategory(), true);        
        
        if ($this->_isValidCategory($this->_appliedCategory)) {
            $this->getLayer()->getProductCollection()
                ->addCategoryFilter($this->_appliedCategory);

            $this->getLayer()->getState()->addFilter(
                $this->_createItem($this->_appliedCategory->getName(), $filter)
            );
        }

        return $this;
    }

}