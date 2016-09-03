<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_ExtendedReviews
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_ExtendedReviews_Block_Product_Review_Comment_List extends Mage_Core_Block_Template {

    protected function _construct() {
        parent::_construct();
        $this->setTemplate('itactica_extendedreviews/comment/list.phtml');
    }

    protected function _prepareLayout() {
        parent::_prepareLayout();

        if ($toolbar = $this->getLayout()->getBlock('product_review_comment_list.toolbar')) {
            $toolbar->setCollection($this->getCollection());
            $this->setChild('toolbar', $toolbar);
        }

        return $this;
    }

    public function getCollection() {
        if ($this->_collection == null) {
            $this->_collection = Mage::getModel('itactica_extendedreviews/comment')->getCollection()
                    ->addFieldToFilter('review_id', array('eg' => $this->getReviewId()));
        }
        return $this->_collection;
    }

    public function getReviewId() {
        return Mage::app()->getRequest()->getParam('id', false);
    }

}
