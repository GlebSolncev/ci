<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_ExtendedReviews
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_ExtendedReviews_Model_Vote extends Mage_Core_Model_Abstract
{
    const INCORRECT_VOTE = -1;
    const ALREADY_VOTED = 0;
    const CAN_VOTE = 1;

    protected function _construct() {
        $this->_init('itactica_extendedreviews/vote');
    }

    public function checkVote($vote = array()) {
        $collection = null;
        $review = Mage::getModel('review/review');
        $review->load($vote['review_id']);
        if ($review->getId() && $review->getStoreId() === Mage::app()->getStore()->getId()) {
            $collection = Mage::getResourceModel('itactica_extendedreviews/vote_collection');
            $collection->addVotesFilter($vote['customer_id'], $vote['guest_id'], $review->getId());
            if ($collection) {
                if ($collection->count() > 0) {
                    return self::ALREADY_VOTED;
                } else {
                    return self::CAN_VOTE;
                }
            }
        }
        return self::INCORRECT_VOTE;
    }

}
