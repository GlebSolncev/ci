<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_OrbitSlider
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_OrbitSlider_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * convert array to options
     * @access public
     * @param $options
     * @return array
     */
    public function convertOptions($options){
        $converted = array();
        foreach ($options as $option){
            if (isset($option['value']) && !is_array($option['value']) && isset($option['label']) && !is_array($option['label'])){
                $converted[$option['value']] = $option['label'];
            }
        }
        return $converted;
    }

    /**
     * get slides collection
     * @access public
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function getSlides($sliderId)
    {
        $collection = Mage::getModel('itactica_orbitslider/slides')
            ->getCollection()
            ->addFieldToFilter('status', 1);
        $select = $collection->getSelect()->join(
                array('orbitslider_slider_slides' => $collection->getTable('itactica_orbitslider/slider_slide')),
                'main_table.entity_id = orbitslider_slider_slides.slide_id',
                array('slide_id')
            )
            ->where('orbitslider_slider_slides.slider_id = (?)', $sliderId)
            ->order('orbitslider_slider_slides.position ASC');

        return $collection;
    }

    /**
     * ads # symbol to hexadecimal color code in case is not present
     * @access public
     * @param string
     * @return string
     */
    public function hex($color) {
        if (substr($color, 0, 1) != '#') {
            $color = '#' . $color;
        }
        return $color;
    }
}
