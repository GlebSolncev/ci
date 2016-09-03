<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_OrbitSlider
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_OrbitSlider_Model_Slider extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'itactica_orbitslider_slider';
    const CACHE_TAG = 'itactica_orbitslider_slider';

    /**
     * Prefix of model events names
     * @var string
     */
    protected $_eventPrefix = 'itactica_orbitslider_slider';

    /**
     * Parameter name in event
     * @var string
     */
    protected $_eventObject = 'slider';
    protected $_slideInstance = null;

    /**
     * constructor
     * @access public
     * @return void
     */
    public function _construct(){
        parent::_construct();
        $this->_init('itactica_orbitslider/slider');
    }

    /**
     * before save slider
     * @access protected
     * @return Itactica_OrbitSlider_Model_Slider
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
     * @return Itactica_OrbitSlider_Resource_Slider
     */
    public function loadByIdentifier($identifier){
        $this->_getResource()->loadByIdentifier($identifier, $this);
        return $this;
    }

    /**
     * get the slider Content
     * @access public
     * @return string
     */
    public function getContent(){
        $content = $this->getData('content');
        $helper = Mage::helper('cms');
        $processor = $helper->getBlockTemplateProcessor();
        $html = $processor->filter($content);
        return $html;
    }

    /**
     * save slider relation
     * @access public
     * @return Itactica_OrbitSlider_Model_Slider
     */
    protected function _afterSave() {
        return parent::_afterSave();
    }

    /**
     * get slides relation model
     * @access public
     * @return Itactica_OrbitSlider_Model_Slider_Slides
     */
    public function getSlideInstance(){
        if (!$this->_slideInstance) {
            $this->_slideInstance = Mage::getSingleton('itactica_orbitslider/slider_slides');
        }
        return $this->_slideInstance;
    }

    /**
     * get selected slides array
     * @access public
     * @return array
     */
    public function getSelectedSlides(){
        if (!$this->hasSelectedSlides()) {
            $slides = array();
            foreach ($this->getSelectedSlidesCollection() as $slide) {
                $slides[] = $slide;
            }
            $this->setSelectedSlides($slides);
        }
        return $this->getData('selected_slides');
    }

    /**
     * Retrieve collection selected slides
     * @access public
     * @return Itactica_OrbitSlider_Resource_Slider_Product_Collection
     */
    public function getSelectedSlidesCollection(){
        $collection = $this->getSlideInstance()->getSlidesCollection($this);
        return $collection;
    }

    /**
     * get default values
     * @access public
     * @return array
     */
    public function getDefaultValues() {
        $values = array();
        $values['animation_speed'] = 600;
        $values['timer_speed'] = 7000;
        $values['pause_on_hover'] = 0;
        $values['circular'] = 1;
        $values['swipe'] = 1;
        $values['status'] = 1;
        return $values;
    }
}
