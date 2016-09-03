<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_ExtendedReviews
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_ExtendedReviews_Model_Resource_Vote extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct() {
        $this->_init('itactica_extendedreviews/vote', 'entity_id');
    }

    protected function _afterSave(Mage_Core_Model_Abstract $object) {
        parent::_afterSave($object);
        $reviewId = $object->getReviewId();
        $summary = $this->getSummaryForReview($reviewId);
        if ($summary && $summary['total'] > 0) {
            $this->_getWriteAdapter()->update($this->getTable('itactica_extendedreviews/summary'), array('helpful' => $summary['helpful'], 'nothelpful' => $summary['nothelpful']), array('review_id = ?' => $reviewId));
        }
    }

    public function getSummaryForReview($reviewId) {
        $adapter = $this->_getReadAdapter();
        $sql = $adapter->select()
                ->from($this->getMainTable(), array(
                    'total' => new Zend_Db_Expr('COUNT(*)'),
                    'helpful' => new Zend_Db_Expr('SUM(helpful)'),
                    'nothelpful' => new Zend_Db_Expr('COUNT(*) - SUM(helpful)')))
                ->where('review_id = ?', $reviewId);
        $result = $adapter->fetchRow($sql);
        return $result;
    }

}
