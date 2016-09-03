<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_TextBoxes
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_TextBoxes_Model_Box extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'itactica_textboxes_box';
    const CACHE_TAG = 'itactica_textboxes_box';

    /**
     * Prefix of model events names
     * @var string
     */
    protected $_eventPrefix = 'itactica_textboxes_box';

    /**
     * Parameter name in event
     * @var string
     */
    protected $_eventObject = 'box';
    protected $_productInstance = null;

    /**
     * constructor
     * @access public
     * @return void
     */
    public function _construct(){
        parent::_construct();
        $this->_init('itactica_textboxes/box');
    }

    /**
     * before save box
     * @access protected
     * @return Itactica_TextBoxes_Model_Box
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
     * Retrieve collection box
     * @access public
     * @param string $identifier
     * @return Itactica_TextBoxes_Resource_Box
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
        $mainColor = Mage::getStoreConfig(
            'intenso_design/page/main_color', Mage::app()->getStore()
        );
        $values['columns'] = 3;
        $values['box_type'] = 1;
        $values['background_color'] = '#ffffff';
        $values['status'] = 1;
        $values['icon_class_first'] = 'icon-puzzle';
        $values['icon_style_first'] = 'highlighted';
        $values['icon_color_first'] = $mainColor;
        $values['icon_size_first'] = 25;
        $values['icon_line_height_first'] = 39;
        $values['title_color_first'] = '#000000';
        $values['title_size_first'] = 23;
        $values['title_style_first'] = 'normal';
        $values['title_weight_first'] = 300;
        $values['text_color_first'] = '#5b6064';
        $values['text_size_first'] = 16;
        $values['text_lineheight_first'] = 24;
        $values['button_bg_color_first'] = $buttonBgColor;
        $values['button_text_color_first'] = $buttonTextColor;
        $values['button_bgcolor_hover_first'] = $buttonBgColorHover;
        $values['button_textcolor_hover_first'] = $buttonTextColorHover;

        $values['icon_class_second'] = 'icon-gear';
        $values['icon_style_second'] = 'highlighted';
        $values['icon_color_second'] = $mainColor;
        $values['icon_size_second'] = 25;
        $values['icon_line_height_second'] = 39;
        $values['title_color_second'] = '#000000';
        $values['title_size_second'] = 23;
        $values['title_style_second'] = 'normal';
        $values['title_weight_second'] = 300;
        $values['text_color_second'] = '#5b6064';
        $values['text_size_second'] = 16;
        $values['text_lineheight_second'] = 24;
        $values['button_bg_color_second'] = $buttonBgColor;
        $values['button_text_color_second'] = $buttonTextColor;
        $values['button_bgcolor_hover_second'] = $buttonBgColorHover;
        $values['button_textcolor_hover_second'] = $buttonTextColorHover;

        $values['icon_class_third'] = 'icon-wrench';
        $values['icon_style_third'] = 'highlighted';
        $values['icon_color_third'] = $mainColor;
        $values['icon_size_third'] = 25;
        $values['icon_line_height_third'] = 39;
        $values['title_color_third'] = '#000000';
        $values['title_size_third'] = 23;
        $values['title_style_third'] = 'normal';
        $values['title_weight_third'] = 300;
        $values['text_color_third'] = '#5b6064';
        $values['text_size_third'] = 16;
        $values['text_lineheight_third'] = 24;
        $values['button_bg_color_third'] = $buttonBgColor;
        $values['button_text_color_third'] = $buttonTextColor;
        $values['button_bgcolor_hover_third'] = $buttonBgColorHover;
        $values['button_textcolor_hover_third'] = $buttonTextColorHover;
        return $values;
    }
}
