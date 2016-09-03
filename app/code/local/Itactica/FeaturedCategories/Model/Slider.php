<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_FeaturedCategories
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_FeaturedCategories_Model_Slider extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'itactica_featuredcategories_slider';
    const CACHE_TAG = 'itactica_featuredcategories_slider';

    /**
     * Prefix of model events names
     * @var string
     */
    protected $_eventPrefix = 'itactica_featuredcategories_slider';

    /**
     * Parameter name in event
     * @var string
     */
    protected $_eventObject = 'slider';
    protected $_categoryInstance = null;

    /**
     * constructor
     * @access public
     * @return void
     */
    public function _construct(){
        parent::_construct();
        $this->_init('itactica_featuredcategories/slider');
    }

    /**
     * before save slider
     * @access protected
     * @return Itactica_FeaturedCategories_Model_Slider
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
     * @return Itactica_FeaturedCategories_Model_Slider
     */
    protected function _afterSave() {
        $this->getCategoryInstance()->saveSliderRelation($this);
        return parent::_afterSave();
    }

    /**
     * get category relation model
     * @access public
     * @return Itactica_FeaturedCategories_Model_Slider_Category
     */
    public function getCategoryInstance(){
        if (!$this->_categoryInstance) {
            $this->_categoryInstance = Mage::getSingleton('itactica_featuredcategories/slider_category');
        }
        return $this->_categoryInstance;
    }

    /**
     * get selected categories array
     * @access public
     * @return array
     */
    public function getSelectedCategories(){
        if (!$this->hasSelectedCategories()) {
            $categories = array();
            foreach ($this->getSelectedCategoriesCollection() as $category) {
                $categories[] = $category;
            }
            $this->setSelectedCategories($categories);
        }
        return $this->getData('selected_categories');
    }

    /**
     * Retrieve collection selected products
     * @access public
     * @return Itactica_FeaturedCategories_Resource_Slider_Category_Collection
     */
    public function getSelectedCategoriesCollection(){
        $collection = $this->getCategoryInstance()->getCategoryCollection($this);
        return $collection;
    }

    /**
     * Retrieve collection slider
     * @access public
     * @param string $identifier
     * @return Itactica_FeaturedCategories_Resource_Slider
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
        $values['minimum_width'] = 220;
        $values['swipe'] = 1;
        $values['status'] = 1;
        return $values;
    }
}
