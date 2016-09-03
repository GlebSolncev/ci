<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_FeaturedProducts
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_FeaturedProducts_Block_Adminhtml_Slider_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * constructor
     * @access public
     */
    public function __construct(){
        parent::__construct();
        $this->setId('sliderGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }
    /**
     * prepare collection
     * @access protected
     * @return Itactica_FeaturedProducts_Block_Adminhtml_Slider_Grid
     */
    protected function _prepareCollection(){
        $collection = Mage::getModel('itactica_featuredproducts/slider')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    /**
     * prepare grid collection
     * @access protected
     * @return Itactica_FeaturedProducts_Block_Adminhtml_Slider_Grid
     */
    protected function _prepareColumns(){
        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('itactica_featuredproducts')->__('Id'),
            'index'        => 'entity_id',
            'type'        => 'number'
        ));
        $this->addColumn('title', array(
            'header'    => Mage::helper('itactica_featuredproducts')->__('Title'),
            'align'     => 'left',
            'index'     => 'title',
        ));
        $this->addColumn('status', array(
            'header'    => Mage::helper('itactica_featuredproducts')->__('Status'),
            'index'        => 'status',
            'type'        => 'options',
            'options'    => array(
                '1' => Mage::helper('itactica_featuredproducts')->__('Enabled'),
                '0' => Mage::helper('itactica_featuredproducts')->__('Disabled'),
            )
        ));
        $this->addColumn('identifier', array(
            'header'=> Mage::helper('itactica_featuredproducts')->__('Identifier'),
            'index' => 'identifier',
            'type'=> 'text',

        ));
        $this->addColumn('products_source', array(
            'header'=> Mage::helper('itactica_featuredproducts')->__('Products Source'),
            'index' => 'products_source',
            'type'  => 'options',
            'options' => Mage::helper('itactica_featuredproducts')->convertOptions(Mage::getModel('itactica_featuredproducts/slider_attribute_source_productssource')->getAllOptions(false))

        ));
        $this->addColumn('product_filter', array(
            'header'=> Mage::helper('itactica_featuredproducts')->__('Product Filter'),
            'index' => 'product_filter',
            'type'  => 'options',
            'options' => Mage::helper('itactica_featuredproducts')->convertOptions(Mage::getModel('itactica_featuredproducts/slider_attribute_source_productfilter')->getAllOptions(false))

        ));
        if (!Mage::app()->isSingleStoreMode() && !$this->_isExport) {
            $this->addColumn('store_id', array(
                'header'=> Mage::helper('itactica_featuredproducts')->__('Store Views'),
                'index' => 'store_id',
                'type'  => 'store',
                'store_all' => true,
                'store_view'=> true,
                'sortable'  => false,
                'filter_condition_callback'=> array($this, '_filterStoreCondition'),
            ));
        }
        $this->addColumn('created_at', array(
            'header'    => Mage::helper('itactica_featuredproducts')->__('Created at'),
            'index'     => 'created_at',
            'width'     => '120px',
            'type'      => 'datetime',
        ));
        $this->addColumn('updated_at', array(
            'header'    => Mage::helper('itactica_featuredproducts')->__('Updated at'),
            'index'     => 'updated_at',
            'width'     => '120px',
            'type'      => 'datetime',
        ));
        $this->addColumn('action',
            array(
                'header'=>  Mage::helper('itactica_featuredproducts')->__('Action'),
                'width' => '100',
                'type'  => 'action',
                'getter'=> 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('itactica_featuredproducts')->__('Edit'),
                        'url'   => array('base'=> '*/*/edit'),
                        'field' => 'id'
                    )
                ),
                'filter'=> false,
                'is_system'    => true,
                'sortable'  => false,
        ));
        $this->addExportType('*/*/exportCsv', Mage::helper('itactica_featuredproducts')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('itactica_featuredproducts')->__('Excel'));
        $this->addExportType('*/*/exportXml', Mage::helper('itactica_featuredproducts')->__('XML'));
        return parent::_prepareColumns();
    }
    /**
     * prepare mass action
     * @access protected
     * @return Itactica_FeaturedProducts_Block_Adminhtml_Slider_Grid
     */
    protected function _prepareMassaction(){
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('slider');
        $this->getMassactionBlock()->addItem('delete', array(
            'label'=> Mage::helper('itactica_featuredproducts')->__('Delete'),
            'url'  => $this->getUrl('*/*/massDelete'),
            'confirm'  => Mage::helper('itactica_featuredproducts')->__('Are you sure?')
        ));
        $this->getMassactionBlock()->addItem('status', array(
            'label'=> Mage::helper('itactica_featuredproducts')->__('Change status'),
            'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
            'additional' => array(
                'status' => array(
                        'name' => 'status',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('itactica_featuredproducts')->__('Status'),
                        'values' => array(
                                '1' => Mage::helper('itactica_featuredproducts')->__('Enabled'),
                                '0' => Mage::helper('itactica_featuredproducts')->__('Disabled'),
                        )
                )
            )
        ));
        $this->getMassactionBlock()->addItem('products_source', array(
            'label'=> Mage::helper('itactica_featuredproducts')->__('Change Products Source'),
            'url'  => $this->getUrl('*/*/massProductsSource', array('_current'=>true)),
            'additional' => array(
                'flag_products_source' => array(
                        'name' => 'flag_products_source',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('itactica_featuredproducts')->__('Products Source'),
                        'values' => Mage::getModel('itactica_featuredproducts/slider_attribute_source_productssource')->getAllOptions(true),

                )
            )
        ));
        $this->getMassactionBlock()->addItem('product_filter', array(
            'label'=> Mage::helper('itactica_featuredproducts')->__('Change Product Filter'),
            'url'  => $this->getUrl('*/*/massProductFilter', array('_current'=>true)),
            'additional' => array(
                'flag_product_filter' => array(
                        'name' => 'flag_product_filter',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('itactica_featuredproducts')->__('Product Filter'),
                        'values' => Mage::getModel('itactica_featuredproducts/slider_attribute_source_productfilter')->getAllOptions(true),

                )
            )
        ));
        $this->getMassactionBlock()->addItem('show_category_tabs', array(
            'label'=> Mage::helper('itactica_featuredproducts')->__('Change Show Category Tabs'),
            'url'  => $this->getUrl('*/*/massShowCategoryTabs', array('_current'=>true)),
            'additional' => array(
                'flag_show_category_tabs' => array(
                        'name' => 'flag_show_category_tabs',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('itactica_featuredproducts')->__('Show Category Tabs'),
                        'values' => array(
                                '1' => Mage::helper('itactica_featuredproducts')->__('Yes'),
                                '0' => Mage::helper('itactica_featuredproducts')->__('No'),
                            )

                )
            )
        ));
        $this->getMassactionBlock()->addItem('show_out_of_stock', array(
            'label'=> Mage::helper('itactica_featuredproducts')->__('Change Display Out of Stock Products'),
            'url'  => $this->getUrl('*/*/massShowOutOfStock', array('_current'=>true)),
            'additional' => array(
                'flag_show_out_of_stock' => array(
                        'name' => 'flag_show_out_of_stock',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('itactica_featuredproducts')->__('Display Out of Stock Products'),
                        'values' => array(
                                '1' => Mage::helper('itactica_featuredproducts')->__('Yes'),
                                '0' => Mage::helper('itactica_featuredproducts')->__('No'),
                            )

                )
            )
        ));
        $this->getMassactionBlock()->addItem('show_price_tag', array(
            'label'=> Mage::helper('itactica_featuredproducts')->__('Change Show Price Tag'),
            'url'  => $this->getUrl('*/*/massShowPriceTag', array('_current'=>true)),
            'additional' => array(
                'flag_show_price_tag' => array(
                        'name' => 'flag_show_price_tag',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('itactica_featuredproducts')->__('Show Price Tag'),
                        'values' => array(
                                '1' => Mage::helper('itactica_featuredproducts')->__('Yes'),
                                '0' => Mage::helper('itactica_featuredproducts')->__('No'),
                            )

                )
            )
        ));
        $this->getMassactionBlock()->addItem('show_rating', array(
            'label'=> Mage::helper('itactica_featuredproducts')->__('Change Show Products Rating'),
            'url'  => $this->getUrl('*/*/massShowRating', array('_current'=>true)),
            'additional' => array(
                'flag_show_rating' => array(
                        'name' => 'flag_show_rating',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('itactica_featuredproducts')->__('Show Products Rating'),
                        'values' => array(
                                '1' => Mage::helper('itactica_featuredproducts')->__('Yes'),
                                '0' => Mage::helper('itactica_featuredproducts')->__('No'),
                            )

                )
            )
        ));
        $this->getMassactionBlock()->addItem('show_color_options', array(
            'label'=> Mage::helper('itactica_featuredproducts')->__('Change Show Color Options'),
            'url'  => $this->getUrl('*/*/massShowColorOptions', array('_current'=>true)),
            'additional' => array(
                'flag_show_color_options' => array(
                        'name' => 'flag_show_color_options',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('itactica_featuredproducts')->__('Show Color Options'),
                        'values' => array(
                                '1' => Mage::helper('itactica_featuredproducts')->__('Yes'),
                                '0' => Mage::helper('itactica_featuredproducts')->__('No'),
                            )

                )
            )
        ));
        $this->getMassactionBlock()->addItem('show_add_to_cart_button', array(
            'label'=> Mage::helper('itactica_featuredproducts')->__('Change Show Add to Cart Button'),
            'url'  => $this->getUrl('*/*/massShowAddToCartButton', array('_current'=>true)),
            'additional' => array(
                'flag_show_add_to_cart_button' => array(
                        'name' => 'flag_show_add_to_cart_button',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('itactica_featuredproducts')->__('Show Add to Cart Button'),
                        'values' => array(
                                '1' => Mage::helper('itactica_featuredproducts')->__('Yes'),
                                '0' => Mage::helper('itactica_featuredproducts')->__('No'),
                            )

                )
            )
        ));
        $this->getMassactionBlock()->addItem('show_compare_button', array(
            'label'=> Mage::helper('itactica_featuredproducts')->__('Change Show Add to Compare Button'),
            'url'  => $this->getUrl('*/*/massShowCompareButton', array('_current'=>true)),
            'additional' => array(
                'flag_show_compare_button' => array(
                        'name' => 'flag_show_compare_button',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('itactica_featuredproducts')->__('Show Add to Compare Button'),
                        'values' => array(
                                '1' => Mage::helper('itactica_featuredproducts')->__('Yes'),
                                '0' => Mage::helper('itactica_featuredproducts')->__('No'),
                            )

                )
            )
        ));
        $this->getMassactionBlock()->addItem('show_wishlist_button', array(
            'label'=> Mage::helper('itactica_featuredproducts')->__('Change Show Add to Wishlist Button'),
            'url'  => $this->getUrl('*/*/massShowWishlistButton', array('_current'=>true)),
            'additional' => array(
                'flag_show_wishlist_button' => array(
                        'name' => 'flag_show_wishlist_button',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('itactica_featuredproducts')->__('Show Add to Wishlist Button'),
                        'values' => array(
                                '1' => Mage::helper('itactica_featuredproducts')->__('Yes'),
                                '0' => Mage::helper('itactica_featuredproducts')->__('No'),
                            )

                )
            )
        ));
        $this->getMassactionBlock()->addItem('swipe', array(
            'label'=> Mage::helper('itactica_featuredproducts')->__('Change Touch Swipe'),
            'url'  => $this->getUrl('*/*/massSwipe', array('_current'=>true)),
            'additional' => array(
                'flag_swipe' => array(
                        'name' => 'flag_swipe',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('itactica_featuredproducts')->__('Touch Swipe'),
                        'values' => array(
                                '1' => Mage::helper('itactica_featuredproducts')->__('Yes'),
                                '0' => Mage::helper('itactica_featuredproducts')->__('No'),
                            )

                )
            )
        ));
        return $this;
    }
    /**
     * get the row url
     * @access public
     * @param Itactica_FeaturedProducts_Model_Slider
     * @return string
     */
    public function getRowUrl($row){
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
    /**
     * get the grid url
     * @access public
     * @return string
     */
    public function getGridUrl(){
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }
    /**
     * after collection load
     * @access protected
     * @return Itactica_FeaturedProducts_Block_Adminhtml_Slider_Grid
     */
    protected function _afterLoadCollection(){
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
    /**
     * filter store column
     * @access protected
     * @param Itactica_FeaturedProducts_Model_Resource_Slider_Collection $collection
     * @param Mage_Adminhtml_Block_Widget_Grid_Column $column
     * @return Itactica_FeaturedProducts_Block_Adminhtml_Slider_Grid
     */
    protected function _filterStoreCondition($collection, $column){
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }
        $collection->addStoreFilter($value);
        return $this;
    }
}
