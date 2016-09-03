<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_FeaturedProducts
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_FeaturedProducts_Model_Adminhtml_Observer
{
    /**
     * check if tab can be added
     * @access protected
     * @param Mage_Catalog_Model_Product $product
     * @return bool
     */
    protected function _canAddTab($product){
        if ($product->getId()){
            return true;
        }
        if (!$product->getAttributeSetId()){
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
     * add the slider tab to products
     * @access public
     * @param Varien_Event_Observer $observer
     * @return Itactica_FeaturedProducts_Model_Adminhtml_Observer
     */
    public function addProductSliderBlock($observer){
        $block = $observer->getEvent()->getBlock();
        $product = Mage::registry('product');
        if ($block instanceof Mage_Adminhtml_Block_Catalog_Product_Edit_Tabs && $this->_canAddTab($product)){
            $block->addTab('sliders', array(
                'label' => Mage::helper('itactica_featuredproducts')->__('Sliders'),
                'url'   => Mage::helper('adminhtml')->getUrl('adminhtml/featuredproducts_slider_catalog_product/sliders', array('_current' => true)),
                'class' => 'ajax',
            ));
        }
        return $this;
    }
    /**
     * save slider - product relation
     * @access public
     * @param Varien_Event_Observer $observer
     * @return Itactica_FeaturedProducts_Model_Adminhtml_Observer
     */
    public function saveProductSliderData($observer){
        $post = Mage::app()->getRequest()->getPost('sliders', -1);
        if ($post != '-1') {
            $post = Mage::helper('adminhtml/js')->decodeGridSerializedInput($post);
            $product = Mage::registry('product');
            $sliderProduct = Mage::getResourceSingleton('itactica_featuredproducts/slider_product')->saveProductRelation($product, $post);
        }
        return $this;
    }}
