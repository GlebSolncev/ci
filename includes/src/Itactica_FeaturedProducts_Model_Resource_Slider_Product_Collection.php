<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_FeaturedProducts
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_FeaturedProducts_Model_Resource_Slider_Product_Collection extends Mage_Catalog_Model_Resource_Product_Collection
{
    /**
     * remember if fields have been joined
     * @var bool
     */
    protected $_joinedFields = false;
    /**
     * join the link table
     * @access public
     * @return Itactica_FeaturedProducts_Model_Resource_Slider_Product_Collection
     */
    public function joinFields(){
        if (!$this->_joinedFields){
            $this->getSelect()->join(
                array('related' => $this->getTable('itactica_featuredproducts/slider_product')),
                'related.product_id = e.entity_id',
                array('position')
            );
            $this->_joinedFields = true;
        }
        return $this;
    }
    /**
     * add slider filter
     * @access public
     * @param Itactica_FeaturedProducts_Model_Slider | int $slider
     * @return Itactica_FeaturedProducts_Model_Resource_Slider_Product_Collection
     */
    public function addSliderFilter($slider){
        if ($slider instanceof Itactica_FeaturedProducts_Model_Slider){
            $slider = $slider->getId();
        }
        if (!$this->_joinedFields){
            $this->joinFields();
        }
        $this->getSelect()->where('related.slider_id = ?', $slider);
        return $this;
    }
}
