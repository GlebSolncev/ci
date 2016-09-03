<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_OrbitSlider
 * @copyright   Copyright (c) 2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_OrbitSlider_Model_Slider_Slides extends Mage_Core_Model_Abstract
{
    /**
     * Initialize resource
     * @access protected
     * @return void
     */
    protected function _construct(){
        $this->_init('itactica_orbitslider/slider_slide');
    }
    /**
     * Save data for slider-slides relation
     * @access public
     * @param  Itactica_OrbitSlider_Model_Slider $slider
     * @return Itactica_OrbitSlider_Model_Slider_Slides
     */
    public function saveSliderRelation($slider){
        $data = $slider->getSlidesData();
        if (!is_null($data)) {
            $this->_getResource()->saveSliderRelation($slider, $data);
        }
        return $this;
    }
    /**
     * get slides for slider
     * @access public
     * @param Itactica_OrbitSlider_Model_Slider $slider
     * @return Itactica_OrbitSlider_Model_Resource_Slider_Slides_Collection
     */
    public function getSlidesCollection($slider){
        $collection = Mage::getResourceModel('itactica_orbitslider/slider_slides_collection')
            ->addSliderFilter($slider);
        return $collection;
    }
}
