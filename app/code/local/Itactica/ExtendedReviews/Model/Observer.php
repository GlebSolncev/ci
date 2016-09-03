<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_ExtendedReviews
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_ExtendedReviews_Model_Observer
{

    public function reviewSaveAfter($observer) {
        $review = $observer->getEvent()->getObject();
        $reviews = Mage::registry('current_reviews');
        if ($reviews) {
            Mage::unregister('current_reviews');
        } else {
            $reviews = array();
        }
        if (!isset($reviews[$review->getId()])) {
            $reviews[$review->getId()] = $review;
        }
        Mage::register('current_reviews', $reviews);
    }

    public function syncReviewAfterSave($observer) {
        $reviews = Mage::registry('current_reviews');
        if (is_array($reviews)) {
            Mage::getResourceModel('itactica_extendedreviews/review')->syncReviews(array_keys($reviews));
        }
    }
}
