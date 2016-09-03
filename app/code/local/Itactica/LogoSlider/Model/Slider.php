<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_LogoSlider
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_LogoSlider_Model_Slider extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'itactica_logoslider_slider';
    const CACHE_TAG = 'itactica_logoslider_slider';

    /**
     * Prefix of model events names
     * @var string
     */
    protected $_eventPrefix = 'itactica_logoslider_slider';

    /**
     * Parameter name in event
     * @var string
     */
    protected $_eventObject = 'slider';
    protected $_logoInstance = null;

    /**
     * constructor
     * @access public
     * @return void
     */
    public function _construct(){
        parent::_construct();
        $this->_init('itactica_logoslider/slider');
    }

    /**
     * before save brand sliders
     * @access protected
     * @return Itactica_LogoSlider_Model_Slider
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
     * Retrieve collection slider
     * @access public
     * @param string $identifier
     * @return Itactica_LogoSlider_Resource_Slider
     */
    public function loadByIdentifier($identifier){
        $this->_getResource()->loadByIdentifier($identifier, $this);
        return $this;
    }

    /**
     * save slider relation
     * @access public
     * @return Itactica_LogoSlider_Model_Slider
     */
    protected function _afterSave() {
        $this->getLogoInstance()->saveSliderRelation($this);
        return parent::_afterSave();
    }

    /**
     * get product relation model
     * @access public
     * @return Itactica_LogoSlider_Model_Slider_Product
     */
    public function getLogoInstance(){
        if (!$this->_logoInstance) {
            $this->_logoInstance = Mage::getSingleton('itactica_logoslider/slider_logos');
        }
        return $this->_logoInstance;
    }

    /**
     * get selected logos array
     * @access public
     * @return array
     */
    public function getSelectedLogos(){
        if (!$this->hasSelectedLogos()) {
            $logos = array();
            foreach ($this->getSelectedLogosCollection() as $logo) {
                $logos[] = $logo;
            }
            $this->setSelectedLogos($logos);
        }
        return $this->getData('selected_logos');
    }

    /**
     * Retrieve collection selected logos
     * @access public
     * @return Itactica_LogoSlider_Resource_Slider_Product_Collection
     */
    public function getSelectedLogosCollection(){
        $collection = $this->getLogoInstance()->getLogoCollection($this);
        return $collection;
    }

    /**
     * get default values
     * @access public
     * @return array
     */
    public function getDefaultValues() {
        $values = array();
        $values['min_item_width'] = 120;
        $values['animation_speed'] = 300;
        $values['show_bullets'] = 1;
        $values['show_arrows'] = 1;
        $values['swipe'] = 1;
        $values['status'] = 1;
        return $values;
    }
}
