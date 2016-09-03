<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_Billboard
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_Billboard_Model_Adminhtml_Search_Unit extends Varien_Object
{
    /**
     * Load search results
     * @access public
     * @return Itactica_Billboard_Model_Adminhtml_Search_Unit
     */
    public function load(){
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('itactica_billboard/unit_collection')
            ->addFieldToFilter('title', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $unit) {
            $arr[] = array(
                'id'=> 'unit/1/'.$unit->getId(),
                'type'  => Mage::helper('itactica_billboard')->__('Billboard'),
                'name'  => $unit->getTitle(),
                'description'   => $unit->getTitle(),
                'url' => Mage::helper('adminhtml')->getUrl('*/billboard_unit/edit', array('id'=>$unit->getId())),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
