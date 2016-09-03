<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_CallToAction
 * @copyright   Copyright (c) 2014-2015 Itactica (https://www.getintenso.com)
 * @license     https://getintenso.com/license
 */

class Itactica_CallToAction_Model_Adminhtml_Search_Cta extends Varien_Object
{
    /**
     * Load search results
     * @access public
     * @return Itactica_CallToAction_Model_Adminhtml_Search_Cta
     */
    public function load(){
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('itactica_calltoaction/cta_collection')
            ->addFieldToFilter('title', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $cta) {
            $arr[] = array(
                'id'=> 'cta/1/'.$cta->getId(),
                'type'  => Mage::helper('itactica_calltoaction')->__('CallToAction'),
                'name'  => $cta->getTitle(),
                'description'   => $cta->getTitle(),
                'url' => Mage::helper('adminhtml')->getUrl('*/calltoaction_cta/edit', array('id'=>$cta->getId())),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
