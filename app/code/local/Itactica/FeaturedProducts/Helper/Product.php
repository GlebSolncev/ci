<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_FeaturedProducts
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_FeaturedProducts_Helper_Product extends Itactica_FeaturedProducts_Helper_Data
{
    /**
     * get the selected sliders for a product
     * @access public
     * @param Mage_Catalog_Model_Product $product
     * @return array()
     */
    public function getSelectedSliders(Mage_Catalog_Model_Product $product){
        if (!$product->hasSelectedSliders()) {
            $sliders = array();
            foreach ($this->getSelectedSlidersCollection($product) as $slider) {
                $sliders[] = $slider;
            }
            $product->setSelectedSliders($sliders);
        }
        return $product->getData('selected_sliders');
    }
    /**
     * get slider collection for a product
     * @access public
     * @param Mage_Catalog_Model_Product $product
     * @return Itactica_FeaturedProducts_Model_Resource_Slider_Collection
     */
    public function getSelectedSlidersCollection(Mage_Catalog_Model_Product $product){
        $collection = Mage::getResourceSingleton('itactica_featuredproducts/slider_collection')
            ->addProductFilter($product);
        return $collection;
    }
}
