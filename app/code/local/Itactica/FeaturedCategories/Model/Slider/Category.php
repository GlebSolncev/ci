<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_FeaturedCategories
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_FeaturedCategories_Model_Slider_Category extends Mage_Core_Model_Abstract
{
    /**
     * Initialize resource
     * @access protected
     * @return void
     */
    protected function _construct(){
        $this->_init('itactica_featuredcategories/slider_category');
    }
    /**
     * Save data for slider-category relation
     * @access public
     * @param  Itactica_FeaturedCategories_Model_Slider $slider
     * @return Itactica_FeaturedCategories_Model_Slider_Category
     */
    public function saveSliderRelation($slider){
        $data = $slider->getCategoriesData();
        if (!is_null($data)) {
            $this->_getResource()->saveSliderRelation($slider, $data);
        }
        return $this;
    }
    /**
     * get categories for slider
     * @access public
     * @param Itactica_FeaturedCategories_Model_Slider $slider
     * @return Itactica_FeaturedCategories_Model_Resource_Slider_Category_Collection
     */
    public function getCategoryCollection($slider){
        $collection = Mage::getResourceModel('itactica_featuredcategories/slider_category_collection')
            ->addSliderFilter($slider);
        return $collection;
    }
}
