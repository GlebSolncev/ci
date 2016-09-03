<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_OrbitSlider
 * @copyright   Copyright (c) 2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_OrbitSlider_Model_Resource_Slider_Slides extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * initialize resource model
     * @access protected
     * @see Mage_Core_Model_Resource_Abstract::_construct()
     */
    protected function  _construct()
    {
        $this->_init('itactica_orbitslider/slider_slide', 'rel_id');
    }

    /**
     * Save  slide - slider relations
     * @access public
     * @param Itactica_OrbitSlider_Model_Slider $slider
     * @param array $data
     * @return Itactica_OrbitSlider_Model_Resource_Slider_Slides
     */
    public function saveSlidesRelation($slider, $data)
    {
        if (!is_array($data)) {
            $data = array();
        }
        $deleteCondition = $this->_getWriteAdapter()->quoteInto('slider_id=?', $slider->getId());
        $this->_getWriteAdapter()->delete($this->getMainTable(), $deleteCondition);

        foreach ($data as $slideId => $info) {
            $this->_getWriteAdapter()->insert($this->getMainTable(), array(
                'slider_id' => $slider->getId(),
                'slide_id' => $slideId,
                'position'   => @$info['position']
            ));
        }
        return $this;
    }

    /**
     * Save  slide - slider relations for demo import
     * @access public
     * @param array $slideSliderRelation
     * @return Itactica_OrbitSlider_Model_Resource_Slider_Slides
     */
    public function saveDemoSlidesRelation($slideSliderRelation)
    {
        if (!is_array($slideSliderRelation)) {
            $slideSliderRelation = array();
        }

        // delete any previous relation stored on db
        foreach (array_unique($slideSliderRelation) as $sliderId) {
            $deleteCondition = $this->_getWriteAdapter()->quoteInto('slider_id=?', $sliderId);
            $this->_getWriteAdapter()->delete($this->getMainTable(), $deleteCondition);
        }

        // save slide-slider relation
        $i = 0;
        foreach ($slideSliderRelation as $slideId => $sliderId) {
            $this->_getWriteAdapter()->insert($this->getMainTable(), array(
                'slider_id' => $sliderId,
                'slide_id' => $slideId,
                'position'   => $i
            ));
            $i++;
        }

        return $this;
    }
}
