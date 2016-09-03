<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_ExtendedReviews
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_ExtendedReviews_Block_Product_Review_Comment_Form extends Mage_Core_Block_Template
{

    public function __construct() {
        $customerSession = Mage::getSingleton('customer/session');

        parent::__construct();

        $data = Mage::getSingleton('core/session')->getFormData(true);
        $data = new Varien_Object($data);

        if (!$data->getNickname()) {
            $customer = $customerSession->getCustomer();
            if ($customer && $customer->getId()) {
                $data->setNickname($customer->getFirstname());
            }
        }

        $this->setAllowWriteReviewFlag($customerSession->isLoggedIn() || Mage::helper('review')->getIsGuestAllowToWrite());
        if (!$this->getAllowWriteReviewFlag()) {
            $this->setLoginLink(
                    Mage::getUrl('customer/account/login/', array(
                        Mage_Customer_Helper_Data::REFERER_QUERY_PARAM_NAME => Mage::helper('core')->urlEncode(
                                Mage::getUrl('*/*/*', array('_current' => true)) . '#review_comment_form')
                            )
                    )
            );
        }

        $this->assign('data', $data)
                ->assign('messages', Mage::getSingleton('core/session')->getMessages(true));
    }

    public function getAction() {
        $reviewId = Mage::app()->getRequest()->getParam('id', false);
        return Mage::helper('itactica_extendedreviews')->getAddCommentAction($reviewId);
    }

    public function getReviewId() {
        return Mage::app()->getRequest()->getParam('id', false);
    }

}
