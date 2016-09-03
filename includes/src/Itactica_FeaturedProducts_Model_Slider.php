<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_FeaturedProducts
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_FeaturedProducts_Model_Slider extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'itactica_featuredproducts_slider';
    const CACHE_TAG = 'itactica_featuredproducts_slider';

    /**
     * Prefix of model events names
     * @var string
     */
    protected $_eventPrefix = 'itactica_featuredproducts_slider';

    /**
     * Parameter name in event
     * @var string
     */
    protected $_eventObject = 'slider';
    protected $_productInstance = null;

    /**
     * constructor
     * @access public
     * @return void
     */
    public function _construct(){
        parent::_construct();
        $this->_init('itactica_featuredproducts/slider');
    }

    /**
     * before save slider
     * @access protected
     * @return Itactica_FeaturedProducts_Model_Slider
     */
    protected function _beforeSave(){
        parent::_beforeSave();
        $now = Mage::getSingleton('core/date')->gmtDate();
        if ($this->isObjectNew()){
            $this->setCreatedAt($now);
        }
        $this->setUpdatedAt($now);
        return $this;
    }

    /**
     * save slider relation
     * @access public
     * @return Itactica_FeaturedProducts_Model_Slider
     */
    protected function _afterSave() {
        $this->getProductInstance()->saveSliderRelation($this);
        return parent::_afterSave();
    }

    /**
     * get product relation model
     * @access public
     * @return Itactica_FeaturedProducts_Model_Slider_Product
     */
    public function getProductInstance(){
        if (!$this->_productInstance) {
            $this->_productInstance = Mage::getSingleton('itactica_featuredproducts/slider_product');
        }
        return $this->_productInstance;
    }

    /**
     * get selected products array
     * @access public
     * @return array
     */
    public function getSelectedProducts(){
        if (!$this->hasSelectedProducts()) {
            $products = array();
            foreach ($this->getSelectedProductsCollection() as $product) {
                $products[] = $product;
            }
            $this->setSelectedProducts($products);
        }
        return $this->getData('selected_products');
    }

    /**
     * Retrieve collection selected products
     * @access public
     * @return Itactica_FeaturedProducts_Resource_Slider_Product_Collection
     */
    public function getSelectedProductsCollection(){
        $collection = $this->getProductInstance()->getProductCollection($this);
        return $collection;
    }

    /**
     * Retrieve collection slider
     * @access public
     * @param string $identifier
     * @return Itactica_FeaturedProducts_Resource_Slider
     */
    public function loadByIdentifier($identifier){
        $this->_getResource()->loadByIdentifier($identifier, $this);
        return $this;
    }

    /**
     * get default values
     * @access public
     * @return array
     */
    public function getDefaultValues() {
        $values = array();
        $values['animation_speed'] = 300;
        $values['show_category_tabs'] = 0;
        $values['limit'] = 15;
        $values['show_out_of_stock'] = 0;
        $values['show_price_tag'] = 1;
        $values['show_rating'] = 1;
        $values['show_color_options'] = 1;
        $values['show_add_to_cart_button'] = 1;
        $values['show_compare_button'] = 1;
        $values['show_wishlist_button'] = 1;
        $values['minimum_width'] = 220;
        $values['image_height'] = 404;
        $values['has_padding'] = 1;
        $values['enable_adaptive_resize'] = 0;
        $values['adaptive_resize_position'] = 1;
        $values['swipe'] = 1;
        $values['status'] = 1;
        return $values;
    }
}
