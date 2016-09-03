<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_ExtendedReviews
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_ExtendedReviews_VoteController extends Mage_Core_Controller_Front_Action {

    public function indexAction() {
        $helper = Mage::helper('itactica_extendedreviews');
        $rc = array(
            'vote' => 'error',
            'msg' => $helper->__('Something went wrong, please try later')
        );
        if ($this->getRequest()->isPost()) {
            $customerId = null;
            $guestId = null;
            if (Mage::getSingleton('customer/session')->isLoggedIn()) {
                $customer = Mage::getSingleton('customer/session')->getCustomer();
                if ($customer->getId()) {
                    $customerId = $customer->getId();
                }
            }
            $guest = Mage::getModel('itactica_extendedreviews/user')->identify();
            if ($guest->getId()) {
                $guestId = $guest->getId();
            }
            if ($customerId || $guestId) {
                $voteData = array(
                    'customer_id' => $customerId,
                    'guest_id' => $guestId,
                    'review_id' => (int) $this->getRequest()->getParam('review'),
                    'helpful' => (int) $this->getRequest()->getParam('helpful')
                );
                $vote = Mage::getModel('itactica_extendedreviews/vote');
                $canVote = $vote->checkVote($voteData);
                if ($canVote == Itactica_ExtendedReviews_Model_Vote::CAN_VOTE) {
                    $vote->setData($voteData)->save();
                    if ($vote->getId()) {
                        $rc['vote'] = 'success';
                        $rc['msg'] = $helper->__(' Thank you for your feedback!');
                    }
                } else if ($canVote == Itactica_ExtendedReviews_Model_Vote::ALREADY_VOTED) {
                    $rc['msg'] = $helper->__('You already voted');
                }
            }
        }
        echo json_encode($rc);
        exit;
    }

}
