<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_ExtendedReviews
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_ExtendedReviews_Block_Product_Review_List extends Mage_Review_Block_Product_View_List {

    protected $_reviewBlock = null;

    protected function _construct() {
        parent::_construct();
        if (Mage::app()->getRequest()->getParam('order', false)) {
            $head = Mage::app()->getLayout()->getBlock('head');
            if ($head) {
                $head->setRobots('NOINDEX, FOLLOW');
            }
        }
    }

    protected function _beforeToHtml() {
        $this->getReviewsCollection()
                ->load()
                ->addRateVotes();
        return parent::_beforeToHtml();
    }

    public function getReviewsCollection() {
        if (null === $this->_reviewsCollection) {
            $this->_reviewsCollection = Mage::getResourceModel('itactica_extendedreviews/review_collection')
                    ->addStoreFilter(Mage::app()->getStore()->getId())
                    ->addStatusFilter(Mage_Review_Model_Review::STATUS_APPROVED)
                    ->addEntityFilter('product', $this->getProduct()->getId())
                    ->appendCanVote();
        }
        return $this->_reviewsCollection;
    }

    public function getReviewHelperBlock() {
        if (!$this->_reviewBlock) {
            $this->_reviewBlock = $this->getLayout()->createBlock('itactica_extendedreviews/helper');
        }
        return $this->_reviewBlock;
    }

}
