<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_OrbitSlider
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_OrbitSlider_Model_Adminhtml_Search_Slider extends Varien_Object
{
    /**
     * Load search results
     * @access public
     * @return Itactica_OrbitSlider_Model_Adminhtml_Search_Slider
     */
    public function load(){
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('itactica_orbitslider/slider_collection')
            ->addFieldToFilter('title', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $slider) {
            $arr[] = array(
                'id'=> 'slider/1/'.$slider->getId(),
                'type'  => Mage::helper('itactica_orbitslider')->__('Slider'),
                'name'  => $slider->getTitle(),
                'description'   => $slider->getTitle(),
                'url' => Mage::helper('adminhtml')->getUrl('*/orbitslider_slider/edit', array('id'=>$slider->getId())),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
