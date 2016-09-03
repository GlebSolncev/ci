<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_TextBoxes
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_TextBoxes_Model_Adminhtml_Search_Box extends Varien_Object
{
    /**
     * Load search results
     * @access public
     * @return Itactica_TextBoxes_Model_Adminhtml_Search_Box
     */
    public function load(){
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('itactica_textboxes/box_collection')
            ->addFieldToFilter('title', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $box) {
            $arr[] = array(
                'id'=> 'box/1/'.$box->getId(),
                'type'  => Mage::helper('itactica_textboxes')->__('Advanced Text Box'),
                'name'  => $box->getTitle(),
                'description'   => $box->getTitle(),
                'url' => Mage::helper('adminhtml')->getUrl('*/textboxes_box/edit', array('id'=>$box->getId())),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
