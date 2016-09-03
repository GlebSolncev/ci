<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_FeaturedProducts
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_FeaturedProducts_Model_Resource_Slider_Product extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * initialize resource model
     * @access protected
     * @see Mage_Core_Model_Resource_Abstract::_construct()
     */
    protected function  _construct(){
        $this->_init('itactica_featuredproducts/slider_product', 'rel_id');
    }
    /**
     * Save slider - product relations
     * @access public
     * @param Itactica_FeaturedProducts_Model_Slider $slider
     * @param array $data
     * @return Itactica_FeaturedProducts_Model_Resource_Slider_Product
     */
    public function saveSliderRelation($slider, $data){
        if (!is_array($data)) {
            $data = array();
        }
        $deleteCondition = $this->_getWriteAdapter()->quoteInto('slider_id=?', $slider->getId());
        $this->_getWriteAdapter()->delete($this->getMainTable(), $deleteCondition);

        foreach ($data as $productId => $info) {
            $this->_getWriteAdapter()->insert($this->getMainTable(), array(
                'slider_id'      => $slider->getId(),
                'product_id'     => $productId,
                'position'      => @$info['position']
            ));
        }
        return $this;
    }
    /**
     * Save  product - slider relations
     * @access public
     * @param Mage_Catalog_Model_Product $prooduct
     * @param array $data
     * @return Itactica_FeaturedProducts_Model_Resource_Slider_Product
     */
    public function saveProductRelation($product, $data){
        if (!is_array($data)) {
            $data = array();
        }
        $deleteCondition = $this->_getWriteAdapter()->quoteInto('product_id=?', $product->getId());
        $this->_getWriteAdapter()->delete($this->getMainTable(), $deleteCondition);

        foreach ($data as $sliderId => $info) {
            $this->_getWriteAdapter()->insert($this->getMainTable(), array(
                'slider_id' => $sliderId,
                'product_id' => $product->getId(),
                'position'   => @$info['position']
            ));
        }
        return $this;
    }
}
