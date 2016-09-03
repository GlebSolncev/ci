<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_FeaturedCategories
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_FeaturedCategories_Model_Adminhtml_Search_Slider extends Varien_Object
{
    /**
     * Load search results
     * @access public
     * @return Itactica_FeaturedCategories_Model_Adminhtml_Search_Slider
     */
    public function load(){
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('itactica_featuredcategories/slider_collection')
            ->addFieldToFilter('title', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $slider) {
            $arr[] = array(
                'id'=> 'slider/1/'.$slider->getId(),
                'type'  => Mage::helper('itactica_featuredcategories')->__('Slider'),
                'name'  => $slider->getTitle(),
                'description'   => $slider->getTitle(),
                'url' => Mage::helper('adminhtml')->getUrl('*/featuredcategories_slider/edit', array('id'=>$slider->getId())),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
