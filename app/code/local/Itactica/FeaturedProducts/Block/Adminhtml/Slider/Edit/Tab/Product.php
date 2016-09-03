<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_FeaturedProducts
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_FeaturedProducts_Block_Adminhtml_Slider_Edit_Tab_Product extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Set grid params
     * @access protected
     */
    public function __construct(){
        parent::__construct();
        $this->setId('product_grid');
        $this->setDefaultSort('position');
        $this->setDefaultDir('ASC');
        $this->setUseAjax(true);
        if ($this->getSlider()->getId()) {
            $this->setDefaultFilter(array('in_products'=>1));
        }
    }

    /**
     * prepare the product collection
     * @access protected
     * @return Itactica_FeaturedProducts_Block_Adminhtml_Slider_Edit_Tab_Product
     */
    protected function _prepareCollection() {
        $collection = Mage::getResourceModel('catalog/product_collection');
        $collection->addAttributeToSelect('*');
        $adminStore = Mage_Core_Model_App::ADMIN_STORE_ID;
        $collection->joinAttribute('product_name', 'catalog_product/name', 'entity_id', null, 'left', $adminStore);
        if ($this->getSlider()->getId()){
            $constraint = '{{table}}.slider_id='.$this->getSlider()->getId();
        }
        else{
            $constraint = '{{table}}.slider_id=0';
        }
        $collection->joinField('position',
            'itactica_featuredproducts/slider_product',
            'position',
            'product_id=entity_id',
            $constraint,
            'left');
        $this->setCollection($collection);
        parent::_prepareCollection();
        $this->getCollection()->addWebsiteNamesToResult();
        return $this;
    }

    /**
     * prepare mass action grid
     * @access protected
     * @return Itactica_FeaturedProducts_Block_Adminhtml_Slider_Edit_Tab_Product
     */
    protected function _prepareMassaction(){
        return $this;
    }

    /**
     * prepare the grid columns
     * @access protected
     * @return Itactica_FeaturedProducts_Block_Adminhtml_Slider_Edit_Tab_Product
     */
    protected function _prepareColumns(){
        $this->addColumn('in_products', array(
            'header_css_class'  => 'a-center',
            'type'  => 'checkbox',
            'name'  => 'in_products',
            'values'=> $this->_getSelectedProducts(),
            'align' => 'center',
            'index' => 'entity_id'
        ));
        $this->addColumn('product_name', array(
            'header'=> Mage::helper('catalog')->__('Name'),
            'align' => 'left',
            'index' => 'product_name',
        ));
        $this->addColumn('type', array(
            'header'=> Mage::helper('catalog')->__('Type'),
            'width' => 120,
            'index' => 'type_id',
            'type'  => 'options',
            'options' => Mage::getSingleton('catalog/product_type')->getOptionArray()
        ));
        $sets = Mage::getResourceModel('eav/entity_attribute_set_collection')
            ->setEntityTypeFilter(Mage::getModel('catalog/product')->getResource()->getTypeId())
            ->load()
            ->toOptionHash();
        $this->addColumn('set_name', array(
            'header'=> Mage::helper('catalog')->__('Attrib. Set Name'),
            'width' => 100,
            'index' => 'attribute_set_id',
            'type'  => 'options',
            'options' => $sets
        ));
        $this->addColumn('status', array(
            'header'    => Mage::helper('catalog')->__('Status'),
            'width'     => 90,
            'index'     => 'status',
            'type'      => 'options',
            'options'   => Mage::getSingleton('catalog/product_status')->getOptionArray(),
        ));
        $this->addColumn('visibility', array(
            'header'    => Mage::helper('catalog')->__('Visibility'),
            'width'     => 90,
            'index'     => 'visibility',
            'type'      => 'options',
            'options'   => Mage::getSingleton('catalog/product_visibility')->getOptionArray(),
        ));
        $this->addColumn('sku', array(
            'header'=> Mage::helper('catalog')->__('SKU'),
            'align' => 'left',
            'index' => 'sku',
        ));
        $this->addColumn('price', array(
            'header'=> Mage::helper('catalog')->__('Price'),
            'type'  => 'currency',
            'width' => '1',
            'currency_code' => (string) Mage::getStoreConfig(Mage_Directory_Model_Currency::XML_PATH_CURRENCY_BASE),
            'index' => 'price'
        ));
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('websites', array(
                'header'=> Mage::helper('catalog')->__('Websites'),
                'width' => '100px',
                'sortable'  => false,
                'index'     => 'websites',
                'type'      => 'options',
                'options'   => Mage::getModel('core/website')->getCollection()->toOptionHash()
            ));
        }
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
     * Retrieve selected products
     * @access protected
     * @return array
     */
    protected function _getSelectedProducts(){
        $products = $this->getSliderProducts();
        if (!is_array($products)) {
            $products = array_keys($this->getSelectedProducts());
        }
        return $products;
    }

     /**
     * Retrieve selected products
     * @access protected
     * @return array
     */
    public function getSelectedProducts() {
        $products = array();
        $selected = Mage::registry('current_slider')->getSelectedProducts();
        if (!is_array($selected)){
            $selected = array();
        }
        foreach ($selected as $product) {
            $products[$product->getId()] = array('position' => $product->getPosition());
        }
        return $products;
    }

    /**
     * get row url
     * @access public
     * @param Itactica_FeaturedProducts_Model_Product
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
        return $this->getUrl('*/*/productsGrid', array(
            'id'=>$this->getSlider()->getId()
        ));
    }

    /**
     * get the current slider
     * @access public
     * @return Itactica_FeaturedProducts_Model_Slider
     */
    public function getSlider(){
        return Mage::registry('current_slider');
    }

    /**
     * Add filter
     * @access protected
     * @param object $column
     * @return Itactica_FeaturedProducts_Block_Adminhtml_Slider_Edit_Tab_Product
     */
    protected function _addColumnFilterToCollection($column){
        // Set custom filter for in product flag
        if ($column->getId() == 'in_products') {
            $productIds = $this->_getSelectedProducts();
            if (empty($productIds)) {
                $productIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', array('in'=>$productIds));
            }
            else {
                if($productIds) {
                    $this->getCollection()->addFieldToFilter('entity_id', array('nin'=>$productIds));
                }
            }
        } else {
            if ($this->getCollection()) {
                if ($column->getId() == 'websites') {
                    $this->getCollection()->joinField('websites',
                        'catalog/product_website',
                        'website_id',
                        'product_id=entity_id',
                        null,
                        'left');
                }
            }
            return parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }
}
