<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_FeaturedProducts
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_FeaturedProducts_Model_Adminhtml_Search_Slider extends Varien_Object
{
    /**
     * Load search results
     * @access public
     * @return Itactica_FeaturedProducts_Model_Adminhtml_Search_Slider
     */
    public function load(){
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('itactica_featuredproducts/slider_collection')
            ->addFieldToFilter('title', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $slider) {
            $arr[] = array(
                'id'=> 'slider/1/'.$slider->getId(),
                'type'  => Mage::helper('itactica_featuredproducts')->__('Slider'),
                'name'  => $slider->getTitle(),
                'description'   => $slider->getTitle(),
                'url' => Mage::helper('adminhtml')->getUrl('*/featuredproducts_slider/edit', array('id'=>$slider->getId())),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
