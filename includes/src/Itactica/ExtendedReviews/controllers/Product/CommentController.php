<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_ExtendedReviews
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_ExtendedReviews_Product_CommentController extends Mage_Core_Controller_Front_Action {

    public function listAction() {
        $reviewId = $this->getRequest()->getParam('id', null);
        if ($reviewId) {
            $comments = $this->getLayout()->createBlock('itactica_extendedreviews/product_review_comment_list', 'reviews_comment_list');
            echo $comments->toHtml();
            exit;
        } else {
            $this->_forward('defaultNoRoute');
        }
    }

    public function addAction() {
        $reviewId = $this->getRequest()->getParam('id', null);
        if ($reviewId) {
            $data = array();
            $response = array();
            $session = Mage::getSingleton('core/session');
            if ($this->getRequest()->isPost()) {
                $data = $this->getRequest()->getPost();
                $comment = Mage::getModel('itactica_extendedreviews/comment');
                $now = Mage::getSingleton('core/date')->gmtDate();
                $saveData = array(
                    'text' => $data['text'],
                    'nickname' => $data['nickname'],
                    'user_id' => Mage::getSingleton('customer/session')->getCustomerId(),
                    'review_id' => $reviewId,
                    'status' => Mage_Review_Model_Review::STATUS_PENDING,
                    'created_at' => $now
                );
                $comment->setData($saveData);
                $v = $comment->validate();
                if ($v === true) {
                    try {
                        $comment->save();
                        $message = Mage::helper('itactica_extendedreviews')->__('Thanks for commenting! Your comment has been accepted for moderation.');
                        $response['success'] = 1;
                    } catch (Exception $e) {
                        $session->setFormData($data);
                        $message = Mage::helper('itactica_extendedreviews')->__('Unable to post the comment.');
                    }
                } else {
                    $session->setFormData($data);
                    if (is_array($v)) {
                        foreach ($v as $errorMessage) {
                            $session->addError($errorMessage);
                        }
                    } else {
                        $message = $this->__('Unable to post the review.');
                    }
                }
                $response['msg'] = $message;
            } else {
                $form = $this->getLayout()->createBlock('itactica_extendedreviews/product_review_comment_form', 'reviews_comment_form_' . $reviewId);
                $form->setTemplate('itactica_extendedreviews/comment/form.phtml');
                $response['content'] = $form->toHtml();
            }

            echo json_encode($response);
        }
        exit;
    }

}
