<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_ExtendedReviews
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_ExtendedReviews_Model_Resource_Review_Collection extends Mage_Review_Model_Resource_Review_Collection
{
    protected function _initSelect() {
        parent::_initSelect();
        $this->getSelect()
                ->join(array('summary' => $this->getTable('itactica_extendedreviews/summary')), 'main_table.review_id = summary.review_id', '*');
        return $this;
    }

    public function setHelpfulOrder($dir = 'DESC') {
        $this->setOrder('summary.helpful-summary.nothelpful', $dir);
        return $this;
    }

    public function setFiveStarsFilter() {
        $this->addFieldToFilter('rating_summary', array('gt' => 89));
        return $this;
    }

    public function setFourStarsFilter() {
        $this->addFieldToFilter('rating_summary', array('gt' => 79));
        $this->addFieldToFilter('rating_summary', array('lt' => 90));
        return $this;
    }

    public function setThreeStarsFilter() {
        $this->addFieldToFilter('rating_summary', array('gt' => 59));
        $this->addFieldToFilter('rating_summary', array('lt' => 79));
        return $this;
    }

    public function setTwoStarsFilter() {
        $this->addFieldToFilter('rating_summary', array('gt' => 39));
        $this->addFieldToFilter('rating_summary', array('lt' => 59));
        return $this;
    }

    public function setOneStarFilter() {
        $this->addFieldToFilter('rating_summary', array('lt' => 39));
        return $this;
    }

    public function appendCanVote() {
        $customerId = -1;
        $guestId = -1;
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            $customer = $customerData = Mage::getSingleton('customer/session')->getCustomer();
            if ($customer->getId()) {
                $customerId = $customer->getId();
            } 
        }
        $guest = Mage::getModel('itactica_extendedreviews/user')->identify();
        if ($guest->getId()) {
            $guestId = $guest->getId();
        }

        $this->getSelect()
            ->joinLeft(array(
                'vote' => $this->getTable('itactica_extendedreviews/vote')), 
                'main_table.review_id = vote.review_id AND (vote.guest_id = ' . $guestId . ' OR vote.customer_id = ' . $customerId . ')', 
                array('can_vote' => new Zend_Db_Expr("IF((vote.customer_id = {$customerId} OR vote.guest_id = {$guestId}),0,1)")
            )
        );
        return $this;
    }

    public function limit($limit) {
        $this->getSelect()->limit($limit);
        return $this;
    }

}
