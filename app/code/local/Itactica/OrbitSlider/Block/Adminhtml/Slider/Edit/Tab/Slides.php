<?php
/**
 * Intenso Premium Theme
 *
 * @category    Itactica
 * @package     Itactica_OrbitSlider
 * @copyright   Copyright (c) 2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_OrbitSlider_Block_Adminhtml_Slider_Edit_Tab_Slides extends Mage_Adminhtml_Block_Widget_Grid
{

    /**
     * Set grid params
     * @access protected
     */
    public function __construct() {
        parent::__construct();
        $this->setId('slides_grid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setUseAjax(true);
        if ($this->getSlider()->getId()) {
            $this->setDefaultFilter(array('in_slides'=>1));
        }
    }

    /**
     * prepare slides collection
     * @access protected
     * @return Itactica_OrbitSlider_Block_Adminhtml_Slider_Edit_Tab_Slides
     */
    protected function _prepareCollection() {
        $collection = Mage::getModel('itactica_orbitslider/slides')->getCollection();
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

    /**
     * prepare mass action grid
     * @access protected
     * @return Itactica_OrbitSlider_Block_Adminhtml_Slider_Edit_Tab_Slides
     */
    protected function _prepareMassaction(){
        return $this;
    }

    /**
     * prepare the grid columns
     * @access protected
     * @return Itactica_OrbitSlider_Block_Adminhtml_Slider_Edit_Tab_Slides
     */
    protected function _prepareColumns() {
		$this->addColumn('in_slides', array(
			'header_css_class'  => 'a-center',
			'type'              => 'checkbox',
			'name'              => 'in_slides',
			'values'            => $this->_getSelectedSlides(),
			'align'             => 'center',
			'index'             => 'entity_id'
		));
        $this->addColumn('entity_id', array(
            'header'=> Mage::helper('itactica_orbitslider')->__('ID'),
            'sortable'  => true,
        	'width'     => 60,
            'index' => 'entity_id'
        ));
        $this->addColumn('title', array(
            'header'=> Mage::helper('itactica_orbitslider')->__('Name'),
            'index' => 'title'
        ));

        $this->addColumn('title_for_large', array(
            'header'=> Mage::helper('itactica_orbitslider')->__('Title'),
            'width' => 150,
            'index' => 'title_for_large'
        ));

        $this->addColumn('text_for_large', array(
            'header'=> Mage::helper('itactica_orbitslider')->__('Text'),
            'width' => 150,
            'index' => 'text_for_large'
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('itactica_orbitslider')->__('Status'),
            'width'     => 90,
            'index'     => 'status',
            'type'      => 'options',
            'options'    => array(
                '1' => Mage::helper('itactica_orbitslider')->__('Enabled'),
                '0' => Mage::helper('itactica_orbitslider')->__('Disabled'),
            )
        ));

        if (!Mage::app()->isSingleStoreMode()) {
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
            : $this->getUrl('*/*/slides', array('_current' => true));
    }

    /**
     * Retrieve selected slides
     * @access protected
     * @return array
     */
    protected function _getSelectedSlides() {
        $slides = $this->getSliderSlides();
        if (!is_array($slides)) {
            $slides = array_keys($this->getSelectedSlides());
        }
        return $slides;
    }
     /**
     * Retrieve selected slides
     * @access protected
     * @return array
     */
    public function getSelectedSlides() {
        $slides = array();
        $selected = Mage::registry('current_slider')->getSelectedSlides();
        if (!is_array($selected)){
            $selected = array();
        }
        foreach ($selected as $slide) {
            $slides[$slide->getId()] = array('position' => $slide->getPosition());
        }
        return $slides;
    }

    /**
     * get the current slider
     * @access public
     * @return Itactica_OrbitSlider_Model_Slider
     */
    public function getSlider() {
        return Mage::registry('current_slider');
    }

    /**
     * after collection load
     * @access protected
     * @return Itactica_OrbitSlider_Block_Adminhtml_Slides_Grid
     */
    protected function _afterLoadCollection() {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }

    /**
     * filter store column
     * @access protected
     * @param Itactica_OrbitSlider_Model_Resource_Slides_Collection $collection
     * @param Mage_Adminhtml_Block_Widget_Grid_Column $column
     * @return Itactica_OrbitSlider_Block_Adminhtml_Slides_Grid
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
     * @return Itactica_OrbitSlider_Block_Adminhtml_Slider_Edit_Tab_Slides
     */
    protected function _addColumnFilterToCollection($column){
        // Set custom filter for slides in slider flag
        if ($column->getId() == 'in_slides') {
            $slideIds = $this->_getSelectedSlides();
            if (empty($slideIds)) {
                $slideIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', array('in'=>$slideIds));
            }
            else {
                if($slideIds) {
                    $this->getCollection()->addFieldToFilter('entity_id', array('nin'=>$slideIds));
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

}