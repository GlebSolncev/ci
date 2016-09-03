<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_OrbitSlider
 * @copyright   Copyright (c) 2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_OrbitSlider_Model_Slides extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'itactica_orbitslider_slides';
    const CACHE_TAG = 'itactica_orbitslider_slides';
    /**
     * Prefix of model events names
     * @var string
     */
    protected $_eventPrefix = 'itactica_orbitslider_slides';

    /**
     * Parameter name in event
     * @var string
     */
    protected $_eventObject = 'slides';
    /**
     * constructor
     * @access public
     * @return void
     */
    public function _construct(){
        parent::_construct();
        $this->_init('itactica_orbitslider/slides');
    }
    /**
     * before save slide
     * @access protected
     * @return Itactica_OrbitSlider_Model_Slides
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
     * save slide relation
     * @access public
     * @return Itactica_OrbitSlider_Model_Slides
     */
    protected function _afterSave() {
        return parent::_afterSave();
    }
    /**
     * get default values
     * @access public
     * @return array
     */
    public function getDefaultValues() {
        $values = array();
        $buttonTextColor = Mage::getStoreConfig(
            'intenso_design/page/primary_button_text_color', Mage::app()->getStore()
        );
        $buttonTextColorHover = Mage::getStoreConfig(
            'intenso_design/page/primary_button_hover_text_color', Mage::app()->getStore()
        );
        $buttonBgColor = Mage::getStoreConfig(
            'intenso_design/page/primary_button_background_color', Mage::app()->getStore()
        );
        $buttonBgColorHover = Mage::getStoreConfig(
            'intenso_design/page/primary_button_hover_background_color', Mage::app()->getStore()
        );

        $values['title_for_large_color'] = '#000000';
        $values['title_for_large_size'] = 44;
        $values['title_for_large_style'] = 'normal';
        $values['title_for_large_weight'] = 'normal';
        $values['text_for_large_color'] = '#000000';
        $values['text_for_large_size'] = 20;
        $values['text_for_large_style'] = 'normal';
        $values['text_for_large_weight'] = 'normal';

        $values['text_block_color_for_small'] = '#d9dfe2';
        $values['title_for_small_color'] = '#000000';
        $values['title_for_small_size'] = 24;
        $values['title_for_small_style'] = 'normal';
        $values['title_for_small_weight'] = 'normal';
        $values['text_for_small_color'] = '#000000';
        $values['text_for_small_size'] = 14;
        $values['text_for_small_style'] = 'normal';
        $values['text_for_small_weight'] = 'normal';

        $values['button_one_style'] = 'normal';
        $values['button_one_text_color'] = $buttonTextColor;
        $values['button_one_text_color_hover'] = $buttonTextColorHover;
        $values['button_one_background'] = $buttonBgColor;
        $values['button_one_background_hover'] = $buttonBgColorHover;
        $values['button_two_style'] = 'normal';
        $values['button_two_text_color'] = $buttonTextColor;
        $values['button_two_text_color_hover'] = $buttonTextColorHover;
        $values['button_two_background'] = $buttonBgColor;
        $values['button_two_background_hover'] = $buttonBgColorHover;

        $values['status'] = 1;
        return $values;
    }

    /**
     * Retrieve slide collection
     * @access public
     * @param string $title
     * @return Itactica_OrbitSlider_Resource_Slides
     */
    public function loadByTitle($title){
        $this->_getResource()->loadByTitle($title, $this);
        return $this;
    }
}
