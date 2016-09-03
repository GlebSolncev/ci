<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_Billboard
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_Billboard_Block_Adminhtml_Unit_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * constructor
     * @access public
     */
    public function __construct(){
        parent::__construct();
        $this->setId('unitGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }
    /**
     * prepare collection
     * @access protected
     * @return Itactica_Billboard_Block_Adminhtml_Unit_Grid
     */
    protected function _prepareCollection(){
        $collection = Mage::getModel('itactica_billboard/unit')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    /**
     * prepare grid collection
     * @access protected
     * @return Itactica_Billboard_Block_Adminhtml_Unit_Grid
     */
    protected function _prepareColumns(){
        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('itactica_billboard')->__('Id'),
            'index'        => 'entity_id',
            'type'        => 'number'
        ));
        $this->addColumn('title', array(
            'header'    => Mage::helper('itactica_billboard')->__('Title'),
            'align'     => 'left',
            'index'     => 'title',
        ));
        $this->addColumn('status', array(
            'header'    => Mage::helper('itactica_billboard')->__('Status'),
            'index'        => 'status',
            'type'        => 'options',
            'options'    => array(
                '1' => Mage::helper('itactica_billboard')->__('Enabled'),
                '0' => Mage::helper('itactica_billboard')->__('Disabled'),
            )
        ));
        $this->addColumn('identifier', array(
            'header'=> Mage::helper('itactica_billboard')->__('Identifier'),
            'index' => 'identifier',
            'type'=> 'text',

        ));
        $this->addColumn('columns', array(
            'header'=> Mage::helper('itactica_billboard')->__('Columns'),
            'index' => 'columns',
            'type'  => 'options',
            'options' => Mage::helper('itactica_billboard')->convertOptions(Mage::getModel('itactica_billboard/unit_attribute_source_columns')->getAllOptions(false))

        ));
        $this->addColumn('billboard_type', array(
            'header'=> Mage::helper('itactica_billboard')->__('Billboard Type'),
            'index' => 'billboard_type',
            'type'  => 'options',
            'options' => Mage::helper('itactica_billboard')->convertOptions(Mage::getModel('itactica_billboard/unit_attribute_source_billboardtype')->getAllOptions(false))

        ));
        if (!Mage::app()->isSingleStoreMode() && !$this->_isExport) {
            $this->addColumn('store_id', array(
                'header'=> Mage::helper('itactica_billboard')->__('Store Views'),
                'index' => 'store_id',
                'type'  => 'store',
                'store_all' => true,
                'store_view'=> true,
                'sortable'  => false,
                'filter_condition_callback'=> array($this, '_filterStoreCondition'),
            ));
        }
        $this->addColumn('created_at', array(
            'header'    => Mage::helper('itactica_billboard')->__('Created at'),
            'index'     => 'created_at',
            'width'     => '120px',
            'type'      => 'datetime',
        ));
        $this->addColumn('updated_at', array(
            'header'    => Mage::helper('itactica_billboard')->__('Updated at'),
            'index'     => 'updated_at',
            'width'     => '120px',
            'type'      => 'datetime',
        ));
        $this->addColumn('action',
            array(
                'header'=>  Mage::helper('itactica_billboard')->__('Action'),
                'width' => '100',
                'type'  => 'action',
                'getter'=> 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('itactica_billboard')->__('Edit'),
                        'url'   => array('base'=> '*/*/edit'),
                        'field' => 'id'
                    )
                ),
                'filter'=> false,
                'is_system'    => true,
                'sortable'  => false,
        ));
        $this->addExportType('*/*/exportCsv', Mage::helper('itactica_billboard')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('itactica_billboard')->__('Excel'));
        $this->addExportType('*/*/exportXml', Mage::helper('itactica_billboard')->__('XML'));
        return parent::_prepareColumns();
    }
    /**
     * prepare mass action
     * @access protected
     * @return Itactica_Billboard_Block_Adminhtml_Unit_Grid
     */
    protected function _prepareMassaction(){
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('unit');
        $this->getMassactionBlock()->addItem('delete', array(
            'label'=> Mage::helper('itactica_billboard')->__('Delete'),
            'url'  => $this->getUrl('*/*/massDelete'),
            'confirm'  => Mage::helper('itactica_billboard')->__('Are you sure?')
        ));
        $this->getMassactionBlock()->addItem('status', array(
            'label'=> Mage::helper('itactica_billboard')->__('Change status'),
            'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
            'additional' => array(
                'status' => array(
                        'name' => 'status',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('itactica_billboard')->__('Status'),
                        'values' => array(
                                '1' => Mage::helper('itactica_billboard')->__('Enabled'),
                                '0' => Mage::helper('itactica_billboard')->__('Disabled'),
                        )
                )
            )
        ));
        return $this;
    }
    /**
     * get the row url
     * @access public
     * @param Itactica_Billboard_Model_Unit
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
     * @return Itactica_Billboard_Block_Adminhtml_Unit_Grid
     */
    protected function _afterLoadCollection(){
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
    /**
     * filter store column
     * @access protected
     * @param Itactica_Billboard_Model_Resource_Unit_Collection $collection
     * @param Mage_Adminhtml_Block_Widget_Grid_Column $column
     * @return Itactica_Billboard_Block_Adminhtml_Unit_Grid
     */
    protected function _filterStoreCondition($collection, $column){
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }
        $collection->addStoreFilter($value);
        return $this;
    }
}
