<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_CallToAction
 * @copyright   Copyright (c) 2014-2015 Itactica (https://www.getintenso.com)
 * @license     https://getintenso.com/license
 */

class Itactica_CallToAction_Model_Cta extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'itactica_calltoaction_cta';
    const CACHE_TAG = 'itactica_calltoaction_cta';

    /**
     * Prefix of model events names
     * @var string
     */
    protected $_eventPrefix = 'itactica_calltoaction_cta';

    /**
     * Parameter name in event
     * @var string
     */
    protected $_eventObject = 'cta';
    protected $_productInstance = null;

    /**
     * constructor
     * @access public
     * @return void
     */
    public function _construct(){
        parent::_construct();
        $this->_init('itactica_calltoaction/cta');
    }

    /**
     * before save calltoaction
     * @access protected
     * @return Itactica_CallToAction_Model_Cta
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
     * Retrieve collection calltoaction
     * @access public
     * @param string $identifier
     * @return Itactica_CallToAction_Resource_Cta
     */
    public function loadByIdentifier($identifier){
        $this->_getResource()->loadByIdentifier($identifier, $this);
        return $this;
    }

    /**
     * get default values
     * @access public
     * @return array
     */
    public function getDefaultValues() {
        $values = array();
        $mainColor = Mage::getStoreConfig(
            'intenso_design/page/main_color', Mage::app()->getStore()
        );
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
        $ghostButtonBorderColor = Mage::getStoreConfig(
            'intenso_design/page/ghost_button_border_color', Mage::app()->getStore()
        );
        $ghostButtonBorderColorHover = Mage::getStoreConfig(
            'intenso_design/page/ghost_button_hover_border_color', Mage::app()->getStore()
        );
        $values['full_width'] = 1;
        $values['columns'] = 2;
        $values['background_color'] = '#f0f0f0';
        $values['margin_top'] = '0';
        $values['margin_bottom'] = '0';
        $values['text'] = 'I am a dummy text for a Call to Action';
        $values['text_color'] = $mainColor;
        $values['font_size'] = 42;
        $values['font_style'] = 'normal';
        $values['font_weight'] = 300;
        $values['text_lineheight'] = 42;
        $values['button_type'] = 'none';
        $values['button_text'] = 'Click here!';
        $values['font_style'] = 'normal';
        $values['button_text_color'] = $buttonTextColor;
        $values['button_text_color_hover'] = $buttonTextColorHover;
        $values['button_background_color'] = $buttonBgColor;
        $values['button_background_color_hover'] = $buttonBgColorHover;
        $values['button_border_color'] = $ghostButtonBorderColor;
        $values['button_border_color_hover'] = $ghostButtonBorderColorHover;      
        $values['status'] = 1;

        return $values;
    }
}
