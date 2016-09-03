<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_FeaturedCategories
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_FeaturedCategories_Block_Adminhtml_Slider_Edit_Tab_Category extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Set grid params
     * @access protected
     */
    public function __construct(){
        parent::__construct();
        $this->setId('category_grid');
        $this->setDefaultSort('position');
        $this->setDefaultDir('ASC');
        $this->setUseAjax(true);
        if ($this->getSlider()->getId()) {
            $this->setDefaultFilter(array('in_categories'=>1));
        }
    }
    /**
     * prepare the category collection
     * @access protected
     * @return Itactica_FeaturedCategories_Block_Adminhtml_Slider_Edit_Tab_Category
     */
    protected function _prepareCollection() {
        $collection = Mage::getResourceModel('catalog/category_collection');
        $collection->addAttributeToSelect('*');
        $collection->addAttributeToFilter('level',array(2,3,4,5,6,7));
        $collection->addIsActiveFilter();
        $adminStore = Mage_Core_Model_App::ADMIN_STORE_ID;
        $collection->joinAttribute('category_name', 'catalog_category/name', 'entity_id', null, 'left', $adminStore);
        if ($this->getSlider()->getId()){
            $constraint = '{{table}}.slider_id='.$this->getSlider()->getId();
        }
        else{
            $constraint = '{{table}}.slider_id=0';
        }
        $collection->joinField('position',
            'itactica_featuredcategories/slider_category',
            'position',
            'category_id=entity_id',
            $constraint,
            'left');
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

    /**
     * prepare mass action grid
     * @access protected
     * @return Itactica_FeaturedCategories_Block_Adminhtml_Slider_Edit_Tab_Category
     */
    protected function _prepareMassaction(){
        return $this;
    }

    /**
     * This override getMultipleRows($item) on Mage_Adminhtml_Block_Widget_Grid
     *
     * @param Varien_Object $item
     * @return array
     */
    public function getMultipleRows($item)
    {
        return array();
    }

    /**
     * prepare the grid columns
     * @access protected
     * @return Itactica_FeaturedCategories_Block_Adminhtml_Slider_Edit_Tab_Category
     */
    protected function _prepareColumns(){
        $this->addColumn('in_categories', array(
            'header_css_class'  => 'a-center',
            'type'  => 'checkbox',
            'name'  => 'in_categories',
            'values'=> $this->_getSelectedCategories(),
            'align' => 'center',
            'index' => 'entity_id'
        ));
        $this->addColumn('category_name', array(
            'header'=> Mage::helper('catalog')->__('Name'),
            'align' => 'left',
            'index' => 'category_name',
        ));
        $this->addColumn('thumbnail', array(
            'header'=> Mage::helper('catalog')->__('Thumbnail'),
            'align' => 'left',
            'index' => 'thumbnail',
            'renderer' => 'itactica_featuredcategories/adminhtml_catalog_renderer_image',
        ));
        $this->addColumn('category_url_key', array(
            'header'=> Mage::helper('catalog')->__('Category URL Key'),
            'align' => 'left',
            'index' => 'url_key',
        ));
        $this->addColumn('position', array(
            'header'=> Mage::helper('catalog')->__('Position'),
            'name'  => 'position',
            'width' => 60,
            'type'  => 'number',
            'validate_class'=> 'validate-number',
            'index' => 'position',
            'editable'  => true,
        ));
    }
    /**
     * Retrieve selected categories
     * @access protected
     * @return array
     */
    protected function _getSelectedCategories(){
        $categories = $this->getSliderCategories();
        if (!is_array($categories)) {
            $categories = array_keys($this->getSelectedCategories());
        }
        return $categories;
    }
     /**
     * Retrieve selected categories
     * @access protected
     * @return array
     */
    public function getSelectedCategories() {
        $categories = array();
        $selected = Mage::registry('current_slider')->getSelectedCategories();
        if (!is_array($selected)){
            $selected = array();
        }
        foreach ($selected as $category) {
            $categories[$category->getId()] = array('position' => $category->getPosition());
        }
        return $categories;
    }
    /**
     * get row url
     * @access public
     * @param Itactica_FeaturedCategories_Model_Category
     * @return string
     */
    public function getRowUrl($item){
        return '#';
    }
    /**
     * get grid url
     * @access public
     * @return string
     */
    public function getGridUrl(){
        return $this->getUrl('*/*/categoriesGrid', array(
            'id'=>$this->getSlider()->getId()
        ));
    }
    /**
     * get the current slider
     * @access public
     * @return Itactica_FeaturedCategories_Model_Slider
     */
    public function getSlider(){
        return Mage::registry('current_slider');
    }
    /**
     * Add filter
     * @access protected
     * @param object $column
     * @return Itactica_FeaturedCategories_Block_Adminhtml_Slider_Edit_Tab_Category
     */
    protected function _addColumnFilterToCollection($column){
        // Set custom filter for in category flag
        if ($column->getId() == 'in_categories') {
            $categoryIds = $this->_getSelectedCategories();
            if (empty($categoryIds)) {
                $categoryIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', array('in'=>$categoryIds));
            }
            else {
                if($categoryIds) {
                    $this->getCollection()->addFieldToFilter('entity_id', array('nin'=>$categoryIds));
                }
            }
        } else {
            return parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }
}
