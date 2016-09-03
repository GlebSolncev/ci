<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_ExtendedReviews
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

include_once ('Mage/Review/controllers/ProductController.php');

class Itactica_ExtendedReviews_ProductController extends Mage_Review_ProductController {

    public function postAction() {
        $success = false;
        if ($data = Mage::getSingleton('review/session')->getFormData(true)) {
            $rating = array();
            if (isset($data['ratings']) && is_array($data['ratings'])) {
                $rating = $data['ratings'];
            }
        } else {
            $data = $this->getRequest()->getPost();
            $rating = $this->getRequest()->getParam('ratings', array());
        }

        if (($product = $this->_initProduct()) && !empty($data)) {
            $session = Mage::getSingleton('core/session');
            $review = Mage::getModel('review/review')->setData($data);

            $validate = $review->validate();
            if ($validate === true) {
                try {
                    $review->setEntityId($review->getEntityIdByCode(Mage_Review_Model_Review::ENTITY_PRODUCT_CODE))
                            ->setEntityPkValue($product->getId())
                            ->setStatusId(Mage_Review_Model_Review::STATUS_PENDING)
                            ->setCustomerId(Mage::getSingleton('customer/session')->getCustomerId())
                            ->setStoreId(Mage::app()->getStore()->getId())
                            ->setStores(array(Mage::app()->getStore()->getId()))
                            ->save();

                    foreach ($rating as $ratingId => $optionId) {
                        Mage::getModel('rating/rating')
                                ->setRatingId($ratingId)
                                ->setReviewId($review->getId())
                                ->setCustomerId(Mage::getSingleton('customer/session')->getCustomerId())
                                ->addOptionVote($optionId, $product->getId());
                    }

                    $review->aggregate();
                    Mage::getResourceModel('itactica_extendedreviews/review')->syncReviews($review->getId());
                    $session->addSuccess($this->__('Thanks for your review! Your review has been accepted for moderation.'));
                    $success = true;
                } catch (Exception $e) {
                    $session->setFormData($data);
                    $session->addError($this->__('Unable to post the review.'));
                }
            } else {
                $session->setFormData($data);
                if (is_array($validate)) {
                    foreach ($validate as $errorMessage) {
                        $session->addError($errorMessage);
                    }
                } else {
                    $session->addError($this->__('Unable to post the review.'));
                }
            }
        }
        echo json_encode(array('success' => $success, 'msg' => $this->getLayout()->getMessagesBlock()->getGroupedHtml()));
        exit;
    }

    public function reviewsAction() {
        if (($product = $this->_initProduct())) {
            $block = $this->getLayout()
                    ->createBlock('itactica_extendedreviews/helper')
                    ->setProduct($product)
                    ->setTemplate('itactica_extendedreviews/catalog/reviews.phtml')
                    ->setWrittenByType('category');

            echo $block->toHtml();
        }
        exit;
    }

    public function addcommentAction() {
        $session = Mage::getSingleton('core/session');
        if (Mage::helper('review')->getIsGuestAllowToWrite()) {
            $data = array();
            $data = Mage::getSingleton('core/session')->getFormData(true);
            if (!$data) {
                $data = $this->getRequest()->getPost();
            }
            $reviewId = Mage::app()->getRequest()->getParam('review', 0);
            if ($reviewId > 0 && !empty($data)) {

                $comment = Mage::getModel('itactica_extendedreviews/comment');
                $saveData = array(
                    'text' => $data['text'],
                    'nickname' => $data['nickname'],
                    'user_id' => Mage::getSingleton('customer/session')->getCustomerId(),
                    'review_id' => $reviewId,
                    'status' => Mage_Review_Model_Review::STATUS_PENDING
                );
                $comment->setData($saveData);
                $v = $comment->validate();
                if ($v === true) {
                    try {
                        $comment->save();
                    } catch (Exception $e) {
                        $session->setFormData($data);
                        $session->addError(Mage::helper('itactica_extendedreviews')->__('Unable to post the comment.'));
                    }
                } else {
                    $session->setFormData($data);
                    if (is_array($v)) {
                        foreach ($v as $errorMessage) {
                            $session->addError($errorMessage);
                        }
                    } else {
                        $session->addError($this->__('Unable to post the review.'));
                    }
                }
            }
        }
        if ($redirectUrl = $session->getRedirectUrl(true)) {
            $this->_redirectUrl($redirectUrl);
            return;
        }
        $this->_redirectReferer();
    }

}
