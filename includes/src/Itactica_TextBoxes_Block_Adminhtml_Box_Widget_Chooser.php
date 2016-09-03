<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_TextBoxes
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */


class Itactica_TextBoxes_Block_Adminhtml_Box_Widget_Chooser extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Block construction, prepare grid params
     * @access public
     * @param array $arguments Object data
     * @return void
     */
    public function __construct($arguments=array()){
        parent::__construct($arguments);
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setUseAjax(true);
        $this->setDefaultFilter(array('chooser_status' => '1'));
    }
    /**
     * Prepare chooser element HTML
     * @access public
     * @param Varien_Data_Form_Element_Abstract $element Form Element
     * @return Varien_Data_Form_Element_Abstract
     */
    public function prepareElementHtml(Varien_Data_Form_Element_Abstract $element){
        $uniqId = Mage::helper('core')->uniqHash($element->getId());
        $sourceUrl = $this->getUrl('*/textboxes_box_widget/chooser', array('uniq_id' => $uniqId));
        $chooser = $this->getLayout()->createBlock('widget/adminhtml_widget_chooser')
                ->setElement($element)
                ->setTranslationHelper($this->getTranslationHelper())
                ->setConfig($this->getConfig())
                ->setFieldsetId($this->getFieldsetId())
                ->setSourceUrl($sourceUrl)
                ->setUniqId($uniqId);
        if ($element->getValue()) {
            $box = Mage::getModel('itactica_textboxes/box')->load($element->getValue());
            if ($box->getId()) {
                $chooser->setLabel($box->getTitle());
            }
        }
        $element->setData('after_element_html', $chooser->toHtml());
        return $element;
    }
    /**
     * Grid Row JS Callback
     * @access public
     * @return string
     */
    public function getRowClickCallback(){
        $chooserJsObject = $this->getId();
        $js = '
            function (grid, event) {
                var trElement = Event.findElement(event, "tr");
                var boxId = trElement.down("td").innerHTML.replace(/^\s+|\s+$/g,"");
                var boxTitle = trElement.down("td").next().innerHTML;
                '.$chooserJsObject.'.setElementValue(boxId);
                '.$chooserJsObject.'.setElementLabel(boxTitle);
                '.$chooserJsObject.'.close();
            }
        ';
        return $js;
    }
    /**
     * Prepare a static blocks collection
     * @access protected
     * @return Itactica_TextBoxes_Block_Adminhtml_Box_Widget_Chooser
     */
    protected function _prepareCollection(){
        $collection = Mage::getModel('itactica_textboxes/box')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    /**
     * Prepare columns for the grid
     * @access protected
     * @return Itactica_TextBoxes_Block_Adminhtml_Box_Widget_Chooser
     */
    protected function _prepareColumns(){
        $this->addColumn('chooser_id', array(
            'header'    => Mage::helper('itactica_textboxes')->__('Id'),
            'align'     => 'right',
            'index'     => 'entity_id',
            'type'        => 'number',
            'width'     => 50
        ));

        $this->addColumn('chooser_title', array(
            'header'=> Mage::helper('itactica_textboxes')->__('Title'),
            'align' => 'left',
            'index' => 'title',
        ));
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                'header'=> Mage::helper('itactica_textboxes')->__('Store Views'),
                'index' => 'store_id',
                'type'  => 'store',
                'store_all' => true,
                'store_view'=> true,
                'sortable'  => false,
            ));
        }
        $this->addColumn('chooser_status', array(
            'header'=> Mage::helper('itactica_textboxes')->__('Status'),
            'index' => 'status',
            'type'  => 'options',
            'options'   => array(
                0 => Mage::helper('itactica_textboxes')->__('Disabled'),
                1 => Mage::helper('itactica_textboxes')->__('Enabled')
            ),
        ));
        return parent::_prepareColumns();
    }
    /**
     * get url for grid
     * @access public
     * @return string
     */
    public function getGridUrl(){
        return $this->getUrl('adminhtml/textboxes_box_widget/chooser', array('_current' => true));
    }
    /**
     * after collection load
     * @access protected
     * @return Itactica_TextBoxes_Block_Adminhtml_Box_Widget_Chooser
     */
    protected function _afterLoadCollection(){
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
