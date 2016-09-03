<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_FeaturedCategories
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_FeaturedCategories_Block_Adminhtml_Slider_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
     * @return Itactica_FeaturedCategories_Block_Adminhtml_Slider_Grid
     */
    protected function _prepareCollection(){
        $collection = Mage::getModel('itactica_featuredcategories/slider')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    /**
     * prepare grid collection
     * @access protected
     * @return Itactica_FeaturedCategories_Block_Adminhtml_Slider_Grid
     */
    protected function _prepareColumns(){
        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('itactica_featuredcategories')->__('Id'),
            'index'        => 'entity_id',
            'type'        => 'number'
        ));
        $this->addColumn('title', array(
            'header'    => Mage::helper('itactica_featuredcategories')->__('Title'),
            'align'     => 'left',
            'index'     => 'title',
        ));
        $this->addColumn('status', array(
            'header'    => Mage::helper('itactica_featuredcategories')->__('Status'),
            'index'        => 'status',
            'type'        => 'options',
            'options'    => array(
                '1' => Mage::helper('itactica_featuredcategories')->__('Enabled'),
                '0' => Mage::helper('itactica_featuredcategories')->__('Disabled'),
            )
        ));
        $this->addColumn('identifier', array(
            'header'=> Mage::helper('itactica_featuredcategories')->__('Identifier'),
            'index' => 'identifier',
            'type'=> 'text',

        ));
        if (!Mage::app()->isSingleStoreMode() && !$this->_isExport) {
            $this->addColumn('store_id', array(
                'header'=> Mage::helper('itactica_featuredcategories')->__('Store Views'),
                'index' => 'store_id',
                'type'  => 'store',
                'store_all' => true,
                'store_view'=> true,
                'sortable'  => false,
                'filter_condition_callback'=> array($this, '_filterStoreCondition'),
            ));
        }
        $this->addColumn('created_at', array(
            'header'    => Mage::helper('itactica_featuredcategories')->__('Created at'),
            'index'     => 'created_at',
            'width'     => '120px',
            'type'      => 'datetime',
        ));
        $this->addColumn('updated_at', array(
            'header'    => Mage::helper('itactica_featuredcategories')->__('Updated at'),
            'index'     => 'updated_at',
            'width'     => '120px',
            'type'      => 'datetime',
        ));
        $this->addColumn('action',
            array(
                'header'=>  Mage::helper('itactica_featuredcategories')->__('Action'),
                'width' => '100',
                'type'  => 'action',
                'getter'=> 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('itactica_featuredcategories')->__('Edit'),
                        'url'   => array('base'=> '*/*/edit'),
                        'field' => 'id'
                    )
                ),
                'filter'=> false,
                'is_system'    => true,
                'sortable'  => false,
        ));
        $this->addExportType('*/*/exportCsv', Mage::helper('itactica_featuredcategories')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('itactica_featuredcategories')->__('Excel'));
        $this->addExportType('*/*/exportXml', Mage::helper('itactica_featuredcategories')->__('XML'));
        return parent::_prepareColumns();
    }
    /**
     * prepare mass action
     * @access protected
     * @return Itactica_FeaturedCategories_Block_Adminhtml_Slider_Grid
     */
    protected function _prepareMassaction(){
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('slider');
        $this->getMassactionBlock()->addItem('delete', array(
            'label'=> Mage::helper('itactica_featuredcategories')->__('Delete'),
            'url'  => $this->getUrl('*/*/massDelete'),
            'confirm'  => Mage::helper('itactica_featuredcategories')->__('Are you sure?')
        ));
        $this->getMassactionBlock()->addItem('status', array(
            'label'=> Mage::helper('itactica_featuredcategories')->__('Change status'),
            'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
            'additional' => array(
                'status' => array(
                        'name' => 'status',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('itactica_featuredcategories')->__('Status'),
                        'values' => array(
                                '1' => Mage::helper('itactica_featuredcategories')->__('Enabled'),
                                '0' => Mage::helper('itactica_featuredcategories')->__('Disabled'),
                        )
                )
            )
        ));
        $this->getMassactionBlock()->addItem('swipe', array(
            'label'=> Mage::helper('itactica_featuredcategories')->__('Change Touch Swipe'),
            'url'  => $this->getUrl('*/*/massSwipe', array('_current'=>true)),
            'additional' => array(
                'flag_swipe' => array(
                        'name' => 'flag_swipe',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('itactica_featuredcategories')->__('Touch Swipe'),
                        'values' => array(
                                '1' => Mage::helper('itactica_featuredcategories')->__('Yes'),
                                '0' => Mage::helper('itactica_featuredcategories')->__('No'),
                            )

                )
            )
        ));
        return $this;
    }
    /**
     * get the row url
     * @access public
     * @param Itactica_FeaturedCategories_Model_Slider
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
     * @return Itactica_FeaturedCategories_Block_Adminhtml_Slider_Grid
     */
    protected function _afterLoadCollection(){
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
    /**
     * filter store column
     * @access protected
     * @param Itactica_FeaturedCategories_Model_Resource_Slider_Collection $collection
     * @param Mage_Adminhtml_Block_Widget_Grid_Column $column
     * @return Itactica_FeaturedCategories_Block_Adminhtml_Slider_Grid
     */
    protected function _filterStoreCondition($collection, $column){
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }
        $collection->addStoreFilter($value);
        return $this;
    }
}
