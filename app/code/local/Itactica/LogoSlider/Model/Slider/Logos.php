<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_LogoSlider
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_LogoSlider_Model_Slider_Logos extends Mage_Core_Model_Abstract
{
    /**
     * Initialize resource
     * @access protected
     * @return void
     */
    protected function _construct(){
        $this->_init('itactica_logoslider/slider_logos');
    }
    /**
     * Save data for slider-logos relation
     * @access public
     * @param  Itactica_LogoSlider_Model_Slider $slider
     * @return Itactica_LogoSlider_Model_Slider_Product
     */
    public function saveSliderRelation($slider){
        $data = $slider->getLogosData();
        if (!is_null($data)) {
            $this->_getResource()->saveSliderRelation($slider, $data);
        }
        return $this;
    }
    /**
     * get logos for slider
     * @access public
     * @param Itactica_LogoSlider_Model_Slider $slider
     * @return Itactica_LogoSlider_Model_Resource_Slider_Logos_Collection
     */
    public function getLogoCollection($slider){
        $collection = Mage::getResourceModel('itactica_logoslider/slider_logos_collection')
            ->addSliderFilter($slider);
        return $collection;
    }
}
