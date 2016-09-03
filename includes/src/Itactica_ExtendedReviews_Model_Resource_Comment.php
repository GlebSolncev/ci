<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_ExtendedReviews
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_ExtendedReviews_Model_Resource_Comment extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct() {
        $this->_init('itactica_extendedreviews/comments', 'entity_id');
    }

    protected function _afterSave(Mage_Core_Model_Abstract $object) {
        parent::_afterSave($object);
        $this->_syncReviewSummary($object);
    }

    protected function _afterDelete(Mage_Core_Model_Abstract $object) {
        parent::_afterDelete($object);
        $this->_syncReviewSummary($object);
    }

    protected function _syncReviewSummary(Mage_Core_Model_Abstract $object) {
        $reviewId = $object->getReviewId();
        $count = $this->_getCommentCountForReview($reviewId);
        $this->_getWriteAdapter()->update($this->getTable('itactica_extendedreviews/summary'), array('comments' => $count), array('review_id = ?' => $reviewId));
    }

    protected function _getCommentCountForReview($reviewId) {
        $adapter = $this->_getReadAdapter();
        $sql = $adapter->select()
                ->from($this->getMainTable(), array('count' => new Zend_Db_Expr('COUNT(*)')))
                ->where('review_id = ?', $reviewId)
                ->where('status = ?', Mage_Review_Model_Review::STATUS_APPROVED);
        $count = $adapter->fetchOne($sql);
        return (int) $count;
    }

}
