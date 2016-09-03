<?php
/**
 * Intenso Premium Theme
 *
 * @category    Itactica
 * @package     Itactica_LogoSlider
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_LogoSlider_Block_Adminhtml_Slider_Edit_Tab_Logos extends Mage_Adminhtml_Block_Widget_Grid
{

    /**
     * Set grid params
     * @access protected
     */
    public function __construct() {
        parent::__construct();
        $this->setId('logos_grid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setUseAjax(true);
        if ($this->getSlider()->getId()) {
            $this->setDefaultFilter(array('in_logos'=>1));
        }
    }

    /**
     * prepare the logos collection
     * @access protected
     * @return Itactica_LogoSlider_Block_Adminhtml_Slider_Edit_Tab_Logos
     */
    protected function _prepareCollection() {
        $collection = Mage::getModel('itactica_logoslider/logo')->getCollection();
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

    /**
     * prepare mass action grid
     * @access protected
     * @return Itactica_LogoSlider_Block_Adminhtml_Slider_Edit_Tab_Logos
     */
    protected function _prepareMassaction(){
        return $this;
    }

    /**
     * prepare the grid columns
     * @access protected
     * @return Itactica_LogoSlider_Block_Adminhtml_Slider_Edit_Tab_Logos
     */
    protected function _prepareColumns() {
		$this->addColumn('in_logos', array(
			'header_css_class'  => 'a-center',
			'type'              => 'checkbox',
			'name'              => 'in_logos',
			'values'            => $this->_getSelectedLogos(),
			'align'             => 'center',
			'index'             => 'entity_id'
		));
        $this->addColumn('entity_id', array(
            'header'=> Mage::helper('itactica_logoslider')->__('ID'),
            'sortable'  => true,
        	'width'     => 60,
            'index' => 'entity_id'
        ));
        $this->addColumn('title', array(
            'header'=> Mage::helper('itactica_logoslider')->__('title'),
            'index' => 'title'
        ));

        $this->addColumn('url_to_redirect', array(
            'header'=> Mage::helper('itactica_logoslider')->__('URL'),
            'width' => 100,
            'index' => 'url_to_redirect'
        ));

        $this->addColumn('search_key', array(
            'header'=> Mage::helper('itactica_logoslider')->__('Search Key'),
            'width' => 100,
            'index' => 'search_key'
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('itactica_logoslider')->__('Status'),
            'width'     => 90,
            'index'     => 'status',
            'type'      => 'options',
            'options'    => array(
                '1' => Mage::helper('itactica_logoslider')->__('Enabled'),
                '0' => Mage::helper('itactica_logoslider')->__('Disabled'),
            )
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                'header'=> Mage::helper('itactica_logoslider')->__('Store Views'),
                'index' => 'store_id',
                'type'  => 'store',
                'store_all' => true,
                'store_view'=> true,
                'sortable'  => false,
                'filter_condition_callback'=> array($this, '_filterStoreCondition'),
            ));
        }

        $this->addColumn('created_at', array(
            'header'    => Mage::helper('itactica_logoslider')->__('Created at'),
            'index'     => 'created_at',
            'width'     => '120px',
            'type'      => 'datetime',
        ));
        $this->addColumn('updated_at', array(
            'header'    => Mage::helper('itactica_logoslider')->__('Updated at'),
            'index'     => 'updated_at',
            'width'     => '120px',
            'type'      => 'datetime',
        ));

        $this->addColumn('position', array(
            'header'            => Mage::helper('catalog')->__('Position'),
            'name'              => 'position',
            'type'              => 'number',
            'validate_class'    => 'validate-number',
            'index'             => 'position',
            'width'             => 60,
            'editable'          => true,
            'edit_only'         => false
        ));

        return parent::_prepareColumns();
    }

    /**
     * get grid url
     * @access public
     * @return string
     */
    public function getGridUrl() {
        return $this->getData('grid_url')
            ? $this->getData('grid_url')
            : $this->getUrl('*/*/logos', array('_current' => true));
    }

    /**
     * Retrieve selected logos
     * @access protected
     * @return array
     */
    protected function _getSelectedLogos() {
        $logos = $this->getSliderLogos();
        if (!is_array($logos)) {
            $logos = array_keys($this->getSelectedLogos());
        }
        return $logos;
    }
     /**
     * Retrieve selected logos
     * @access protected
     * @return array
     */
    public function getSelectedLogos() {
        $logos = array();
        $selected = Mage::registry('current_slider')->getSelectedLogos();
        if (!is_array($selected)){
            $selected = array();
        }
        foreach ($selected as $logo) {
            $logos[$logo->getId()] = array('position' => $logo->getPosition());
        }
        return $logos;
    }

    /**
     * get the current slider
     * @access public
     * @return Itactica_LogoSlider_Model_Slider
     */
    public function getSlider() {
        return Mage::registry('current_slider');
    }

    /**
     * after collection load
     * @access protected
     * @return Itactica_LogoSlider_Block_Adminhtml_Logo_Grid
     */
    protected function _afterLoadCollection() {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }

    /**
     * filter store column
     * @access protected
     * @param Itactica_LogoSlider_Model_Resource_Logo_Collection $collection
     * @param Mage_Adminhtml_Block_Widget_Grid_Column $column
     * @return Itactica_LogoSlider_Block_Adminhtml_Logo_Grid
     */
    protected function _filterStoreCondition($collection, $column) {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }
        $collection->addStoreFilter($value);
        return $this;
    }

    /**
     * Add filter
     * @access protected
     * @param object $column
     * @return Itactica_LogoSlider_Block_Adminhtml_Slider_Edit_Tab_Logos
     */
    protected function _addColumnFilterToCollection($column){
        // Set custom filter for logos in slider flag
        if ($column->getId() == 'in_logos') {
            $logoIds = $this->_getSelectedLogos();
            if (empty($logoIds)) {
                $logoIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', array('in'=>$logoIds));
            }
            else {
                if($logoIds) {
                    $this->getCollection()->addFieldToFilter('entity_id', array('nin'=>$logoIds));
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

}