<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_ExtendedReviews
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_ExtendedReviews_Model_Resource_Vote_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct() {
        parent::_construct();
        $this->_init('itactica_extendedreviews/vote');
    }

    public function addVotesFilter($customerId, $guestId, $reviewId = null) {
        $this->addFieldToFilter(
            array('customer_id', 'guest_id'),
            array(
                array('eg' => $customerId), 
                array('eg' => $guestId)
            )
        );
        $this->addReviewFilter($reviewId);
    }

    public function addStoreFilter($storeId = null) {
        if ($storeId) {
            $this->getSelect()
                    ->join(array('rstore' => $this->getTable('review/review_store')), 'main_table.review_id = rstore.review_id')
                    ->where('rstore.store_id = ?', $storeId);
        }
        return $this;
    }

    public function addReviewFilter($reviewId) {
        if ($reviewId) {
            $this->addFieldToFilter('review_id', array('eg' => $reviewId));
        }
        return $this;
    }

}
