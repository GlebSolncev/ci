<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_FeaturedCategories
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_FeaturedCategories_Model_Resource_Slider_Category extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * initialize resource model
     * @access protected
     * @see Mage_Core_Model_Resource_Abstract::_construct()
     */
    protected function  _construct(){
        $this->_init('itactica_featuredcategories/slider_category', 'rel_id');
    }
    /**
     * Save slider - category relations
     * @access public
     * @param Itactica_FeaturedCategories_Model_Slider $slider
     * @param array $data
     * @return Itactica_FeaturedCategories_Model_Resource_Slider_Category
     */
    public function saveSliderRelation($slider, $data){
        if (!is_array($data)) {
            $data = array();
        }
        $deleteCondition = $this->_getWriteAdapter()->quoteInto('slider_id=?', $slider->getId());
        $this->_getWriteAdapter()->delete($this->getMainTable(), $deleteCondition);

        foreach ($data as $categoryId => $info) {
            $this->_getWriteAdapter()->insert($this->getMainTable(), array(
                'slider_id'      => $slider->getId(),
                'category_id'     => $categoryId,
                'position'      => @$info['position']
            ));
        }
        return $this;
    }
    /**
     * Save category - slider relations
     * @access public
     * @param Mage_Catalog_Model_Category $category
     * @param array $data
     * @return Itactica_FeaturedCategories_Model_Resource_Slider_Category
     */
    public function saveCategoryRelation($category, $data){
        if (!is_array($data)) {
            $data = array();
        }
        $deleteCondition = $this->_getWriteAdapter()->quoteInto('category_id=?', $category->getId());
        $this->_getWriteAdapter()->delete($this->getMainTable(), $deleteCondition);

        foreach ($data as $sliderId => $info) {
            $this->_getWriteAdapter()->insert($this->getMainTable(), array(
                'slider_id' => $sliderId,
                'category_id' => $category->getId(),
                'position'   => @$info['position']
            ));
        }
        return $this;
    }
}
