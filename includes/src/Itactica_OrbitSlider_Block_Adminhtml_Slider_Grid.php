<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_OrbitSlider
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_OrbitSlider_Block_Adminhtml_Slider_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
     * @return Itactica_OrbitSlider_Block_Adminhtml_Slider_Grid
     */
    protected function _prepareCollection(){
        $collection = Mage::getModel('itactica_orbitslider/slider')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    /**
     * prepare grid collection
     * @access protected
     * @return Itactica_OrbitSlider_Block_Adminhtml_Slider_Grid
     */
    protected function _prepareColumns(){
        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('itactica_orbitslider')->__('Id'),
            'index'        => 'entity_id',
            'type'        => 'number'
        ));
        $this->addColumn('title', array(
            'header'    => Mage::helper('itactica_orbitslider')->__('Title'),
            'align'     => 'left',
            'index'     => 'title',
        ));
        $this->addColumn('status', array(
            'header'    => Mage::helper('itactica_orbitslider')->__('Status'),
            'index'        => 'status',
            'type'        => 'options',
            'options'    => array(
                '1' => Mage::helper('itactica_orbitslider')->__('Enabled'),
                '0' => Mage::helper('itactica_orbitslider')->__('Disabled'),
            )
        ));
        $this->addColumn('identifier', array(
            'header'=> Mage::helper('itactica_orbitslider')->__('Identifier'),
            'index' => 'identifier',
            'type'=> 'text',

        ));
        $this->addColumn('animation_type', array(
            'header'=> Mage::helper('itactica_orbitslider')->__('Animation Type'),
            'index' => 'animation_type',
            'type'  => 'options',
            'options' => Mage::helper('itactica_orbitslider')->convertOptions(Mage::getModel('itactica_orbitslider/slider_attribute_source_animationtype')->getAllOptions(false))

        ));
        if (!Mage::app()->isSingleStoreMode() && !$this->_isExport) {
            $this->addColumn('store_id', array(
                'header'=> Mage::helper('itactica_orbitslider')->__('Store Views'),
                'index' => 'store_id',
                'type'  => 'store',
                'store_all' => true,
                'store_view'=> true,
                'sortable'  => false,
                'filter_condition_callback'=> array($this, '_filterStoreCondition'),
            ));
        }
        $this->addColumn('created_at', array(
            'header'    => Mage::helper('itactica_orbitslider')->__('Created at'),
            'index'     => 'created_at',
            'width'     => '120px',
            'type'      => 'datetime',
        ));
        $this->addColumn('updated_at', array(
            'header'    => Mage::helper('itactica_orbitslider')->__('Updated at'),
            'index'     => 'updated_at',
            'width'     => '120px',
            'type'      => 'datetime',
        ));
        $this->addColumn('action',
            array(
                'header'=>  Mage::helper('itactica_orbitslider')->__('Action'),
                'width' => '100',
                'type'  => 'action',
                'getter'=> 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('itactica_orbitslider')->__('Edit'),
                        'url'   => array('base'=> '*/*/edit'),
                        'field' => 'id'
                    )
                ),
                'filter'=> false,
                'is_system'    => true,
                'sortable'  => false,
        ));
        $this->addExportType('*/*/exportCsv', Mage::helper('itactica_orbitslider')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('itactica_orbitslider')->__('Excel'));
        $this->addExportType('*/*/exportXml', Mage::helper('itactica_orbitslider')->__('XML'));
        return parent::_prepareColumns();
    }
    /**
     * prepare mass action
     * @access protected
     * @return Itactica_OrbitSlider_Block_Adminhtml_Slider_Grid
     */
    protected function _prepareMassaction(){
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('slider');
        $this->getMassactionBlock()->addItem('delete', array(
            'label'=> Mage::helper('itactica_orbitslider')->__('Delete'),
            'url'  => $this->getUrl('*/*/massDelete'),
            'confirm'  => Mage::helper('itactica_orbitslider')->__('Are you sure?')
        ));
        $this->getMassactionBlock()->addItem('status', array(
            'label'=> Mage::helper('itactica_orbitslider')->__('Change status'),
            'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
            'additional' => array(
                'status' => array(
                        'name' => 'status',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('itactica_orbitslider')->__('Status'),
                        'values' => array(
                                '1' => Mage::helper('itactica_orbitslider')->__('Enabled'),
                                '0' => Mage::helper('itactica_orbitslider')->__('Disabled'),
                        )
                )
            )
        ));
        $this->getMassactionBlock()->addItem('animation_type', array(
            'label'=> Mage::helper('itactica_orbitslider')->__('Change Animation Type'),
            'url'  => $this->getUrl('*/*/massAnimationType', array('_current'=>true)),
            'additional' => array(
                'flag_animation_type' => array(
                        'name' => 'flag_animation_type',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('itactica_orbitslider')->__('Animation Type'),
                        'values' => Mage::getModel('itactica_orbitslider/slider_attribute_source_animationtype')->getAllOptions(true),

                )
            )
        ));
        $this->getMassactionBlock()->addItem('pause_on_hover', array(
            'label'=> Mage::helper('itactica_orbitslider')->__('Change Pause on Hover'),
            'url'  => $this->getUrl('*/*/massPauseOnHover', array('_current'=>true)),
            'additional' => array(
                'flag_pause_on_hover' => array(
                        'name' => 'flag_pause_on_hover',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('itactica_orbitslider')->__('Pause on Hover'),
                        'values' => array(
                                '1' => Mage::helper('itactica_orbitslider')->__('Yes'),
                                '0' => Mage::helper('itactica_orbitslider')->__('No'),
                            )

                )
            )
        ));
        $this->getMassactionBlock()->addItem('circular', array(
            'label'=> Mage::helper('itactica_orbitslider')->__('Change Loop'),
            'url'  => $this->getUrl('*/*/massCircular', array('_current'=>true)),
            'additional' => array(
                'flag_circular' => array(
                        'name' => 'flag_circular',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('itactica_orbitslider')->__('Loop'),
                        'values' => array(
                                '1' => Mage::helper('itactica_orbitslider')->__('Yes'),
                                '0' => Mage::helper('itactica_orbitslider')->__('No'),
                            )

                )
            )
        ));
        $this->getMassactionBlock()->addItem('swipe', array(
            'label'=> Mage::helper('itactica_orbitslider')->__('Change Touch Swipe'),
            'url'  => $this->getUrl('*/*/massSwipe', array('_current'=>true)),
            'additional' => array(
                'flag_swipe' => array(
                        'name' => 'flag_swipe',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('itactica_orbitslider')->__('Touch Swipe'),
                        'values' => array(
                                '1' => Mage::helper('itactica_orbitslider')->__('Yes'),
                                '0' => Mage::helper('itactica_orbitslider')->__('No'),
                            )

                )
            )
        ));
        return $this;
    }
    /**
     * get the row url
     * @access public
     * @param Itactica_OrbitSlider_Model_Slider
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
     * @return Itactica_OrbitSlider_Block_Adminhtml_Slider_Grid
     */
    protected function _afterLoadCollection(){
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
    /**
     * filter store column
     * @access protected
     * @param Itactica_OrbitSlider_Model_Resource_Slider_Collection $collection
     * @param Mage_Adminhtml_Block_Widget_Grid_Column $column
     * @return Itactica_OrbitSlider_Block_Adminhtml_Slider_Grid
     */
    protected function _filterStoreCondition($collection, $column){
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }
        $collection->addStoreFilter($value);
        return $this;
    }
}
