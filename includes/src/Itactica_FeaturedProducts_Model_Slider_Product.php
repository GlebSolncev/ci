<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_FeaturedProducts
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_FeaturedProducts_Model_Slider_Product extends Mage_Core_Model_Abstract
{
    /**
     * Initialize resource
     * @access protected
     * @return void
     */
    protected function _construct(){
        $this->_init('itactica_featuredproducts/slider_product');
    }
    /**
     * Save data for slider-product relation
     * @access public
     * @param  Itactica_FeaturedProducts_Model_Slider $slider
     * @return Itactica_FeaturedProducts_Model_Slider_Product
     */
    public function saveSliderRelation($slider){
        $data = $slider->getProductsData();
        if (!is_null($data)) {
            $this->_getResource()->saveSliderRelation($slider, $data);
        }
        return $this;
    }
    /**
     * get products for slider
     * @access public
     * @param Itactica_FeaturedProducts_Model_Slider $slider
     * @return Itactica_FeaturedProducts_Model_Resource_Slider_Product_Collection
     */
    public function getProductCollection($slider){
        $collection = Mage::getResourceModel('itactica_featuredproducts/slider_product_collection')
            ->addSliderFilter($slider);
        return $collection;
    }
}
