<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_ExtendedReviews
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_ExtendedReviews_Adminhtml_Catalog_Product_Review_CommentController extends Mage_Adminhtml_Controller_Action {

    public function indexAction() {
        $this->_title($this->__('Catalog'))
                ->_title($this->__('Reviews and Ratings'))
                ->_title(Mage::helper('itactica_extendedreviews')->__('Customer Comments'));
        $this->_title(Mage::helper('itactica_extendedreviews')->__('All Comments'));
        if ($this->getRequest()->getParam('ajax')) {
            return $this->_forward('reviewGrid');
        }
        $this->loadLayout();
        $this->_setActiveMenu('catalog/review');
        $this->_addContent($this->getLayout()->createBlock('itactica_extendedreviews/adminhtml_comment_main'));
        $this->renderLayout();
    }

    public function pendingAction() {
        $this->_title($this->__('Catalog'))
                ->_title($this->__('Reviews and Ratings'))
                ->_title(Mage::helper('itactica_extendedreviews')->__('Customer Comments'));
        $this->_title(Mage::helper('itactica_extendedreviews')->__('Pending Comments'));
        Mage::register('usePendingFilter', true);
        if ($this->getRequest()->getParam('ajax')) {
            return $this->_forward('reviewGrid');
        }
        $this->loadLayout();
        $this->_setActiveMenu('catalog/review');
        $this->_addContent($this->getLayout()->createBlock('itactica_extendedreviews/adminhtml_comment_main'));
        $this->renderLayout();
    }

    public function editAction() {
        $this->_title($this->__('Catalog'))
                ->_title($this->__('Reviews and Ratings'))
                ->_title(Mage::helper('itactica_extendedreviews')->__('Customer Comments'));
        $this->_title(Mage::helper('itactica_extendedreviews')->__('Edit Comment'));
        $this->loadLayout();
        $this->_setActiveMenu('catalog/review');
        $this->_addContent($this->getLayout()->createBlock('itactica_extendedreviews/adminhtml_comment_edit'));
        $this->renderLayout();
    }

    public function saveAction() {
        if (($data = $this->getRequest()->getPost()) && ($commentId = $this->getRequest()->getParam('id'))) {
            $comment = Mage::getModel('itactica_extendedreviews/comment')->load($commentId);
            $session = Mage::getSingleton('adminhtml/session');
            if (!$comment->getId()) {
                $session->addError(Mage::helper('itactica_extendedreviews')->__('The comment was removed by another user or does not exist.'));
            } else {
                try {
                    $comment->addData($data)->save();
                    $session->addSuccess(Mage::helper('itactica_extendedreviews')->__('The comment has been saved.'));
                } catch (Mage_Core_Exception $e) {
                    $session->addError($e->getMessage());
                } catch (Exception $e) {
                    $session->addException($e, Mage::helper('itactica_extendedreviews')->__('An error occurred while saving this comment.'));
                }
            }
            return $this->getResponse()->setRedirect($this->getUrl($this->getRequest()->getParam('ret') == 'pending' ? '*/*/pending' : '*/*/'));
        }
        $this->_redirect('*/*/');
    }

    public function deleteAction() {
        $commentId = $this->getRequest()->getParam('id', false);
        $session = Mage::getSingleton('adminhtml/session');
        try {
            Mage::getModel('itactica_extendedreviews/comment')->setId($commentId)
                    ->delete();

            $session->addSuccess(Mage::helper('itactica_extendedreviews')->__('The comment has been deleted'));
            if ($this->getRequest()->getParam('ret') == 'pending') {
                $this->getResponse()->setRedirect($this->getUrl('*/*/pending'));
            } else {
                $this->getResponse()->setRedirect($this->getUrl('*/*/'));
            }
            return;
        } catch (Mage_Core_Exception $e) {
            $session->addError($e->getMessage());
        } catch (Exception $e) {
            $session->addException($e, Mage::helper('catalog')->__('An error occurred while deleting this review.'));
        }

        $this->_redirect('*/*/edit/', array('id' => $commentId));
    }

    public function reviewGridAction() {
        $this->getResponse()->setBody($this->getLayout()->createBlock('itactica_extendedreviews/adminhtml_comment_grid')->toHtml());
    }

    public function massUpdateStatusAction() {
        $commentsIds = $this->getRequest()->getParam('comment');
        $session = Mage::getSingleton('adminhtml/session');
        if (!is_array($commentsIds)) {
            $session->addError(Mage::helper('itactica_extendedreviews')->__('Please select comment(s).'));
        } else {
            try {
                $status = $this->getRequest()->getParam('status');
                foreach ($commentsIds as $commentId) {
                    $model = Mage::getModel('itactica_extendedreviews/comment')->load($commentId);
                    $model->setStatus($status)
                            ->save();
                }
                $session->addSuccess(
                        Mage::helper('adminhtml')->__('Total of %d record(s) have been updated.', count($commentsIds))
                );
            } catch (Mage_Core_Exception $e) {
                $session->addError($e->getMessage());
            } catch (Exception $e) {
                $session->addException($e, Mage::helper('itactica_extendedreviews')->__('An error occurred while updating the selected comment(s).'));
            }
        }
        $this->_redirect('*/*/' . $this->getRequest()->getParam('ret', 'index'));
    }

    public function massDeleteAction() {
        $commentsIds = $this->getRequest()->getParam('comment');
        $session = Mage::getSingleton('adminhtml/session');

        if (!is_array($commentsIds)) {
            $session->addError(Mage::helper('adminhtml')->__('Please select review(s).'));
        } else {
            try {
                foreach ($commentsIds as $commentId) {
                    $model = Mage::getModel('itactica_extendedreviews/comment')->load($commentId);
                    $model->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                        Mage::helper('adminhtml')->__('Total of %d record(s) have been deleted.', count($commentsIds))
                );
            } catch (Mage_Core_Exception $e) {
                $session->addError($e->getMessage());
            } catch (Exception $e) {
                $session->addException($e, Mage::helper('adminhtml')->__('An error occurred while deleting record(s).'));
            }
        }
        $this->_redirect('*/*/' . $this->getRequest()->getParam('ret', 'index'));
    }

}
