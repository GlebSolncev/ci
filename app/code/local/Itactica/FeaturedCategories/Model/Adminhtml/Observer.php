<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_FeaturedCategories
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_FeaturedCategories_Model_Adminhtml_Observer
{
    /**
     * check if tab can be added
     * @access protected
     * @param Mage_Catalog_Model_Category $category
     * @return bool
     */
    protected function _canAddTab($category){
        if ($category->getId()){
            return true;
        }
        if (!$category->getAttributeSetId()){
            return false;
        }
        $request = Mage::app()->getRequest();
        if ($request->getParam('type') == 'configurable'){
            if ($request->getParam('attributes')){
                return true;
            }
        }
        return false;
    }
    /**
     * add the slider tab to categories
     * @access public
     * @param Varien_Event_Observer $observer
     * @return Itactica_FeaturedCategories_Model_Adminhtml_Observer
     */
    public function addCategoriesSliderBlock($observer){
        $block = $observer->getEvent()->getBlock();
        $category = Mage::registry('category');
        if ($block instanceof Mage_Adminhtml_Block_Catalog_Category_Edit_Tabs && $this->_canAddTab($category)){
            $block->addTab('sliders', array(
                'label' => Mage::helper('itactica_featuredcategories')->__('Sliders'),
                'url'   => Mage::helper('adminhtml')->getUrl('adminhtml/featuredcategories_slider_catalog_category/sliders', array('_current' => true)),
                'class' => 'ajax',
            ));
        }
        return $this;
    }
    /**
     * save slider - category relation
     * @access public
     * @param Varien_Event_Observer $observer
     * @return Itactica_FeaturedCategories_Model_Adminhtml_Observer
     */
    public function saveCategorySliderData($observer){
        $post = Mage::app()->getRequest()->getPost('sliders', -1);
        if ($post != '-1') {
            $post = Mage::helper('adminhtml/js')->decodeGridSerializedInput($post);
            $category = Mage::registry('category');
            $sliderCategory = Mage::getResourceSingleton('itactica_featuredcategories/slider_category')->saveCategoryRelation($category, $post);
        }
        return $this;
    }
}
