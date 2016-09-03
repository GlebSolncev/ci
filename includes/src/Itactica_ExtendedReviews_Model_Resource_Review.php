<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_ExtendedReviews
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_ExtendedReviews_Model_Resource_Review extends Mage_Review_Model_Mysql4_Review
{
    public function syncReviews($ids = null) {
        $select = $this->_getReadAdapter()->select();

        $select->from(array('rtable' => $this->_reviewTable), array(
            'review_id',
        ));
        if (!is_null($ids)) {
            $select->where('rtable.review_id in (?)', $ids);
        }
        $select->join(array('rov' => $this->getTable('rating/rating_option_vote')), 'rtable.review_id = rov.review_id and rtable.entity_pk_value = rov.entity_pk_value', array('SUM(rov.percent)/COUNT(rov.percent) as rating_summary'))
                ->group('rtable.review_id')
                ->columns(array('helpful' => new Zend_Db_Expr('0'),
                    'nothelpful' => new Zend_Db_Expr('0'),
                    'comments' => new Zend_Db_Expr('0')));
        $this->_getWriteAdapter()->query($this->_insertFromSelect($select, $this->getTable('itactica_extendedreviews/summary')));
        return $this;
    }

    protected function _insertFromSelect(Varien_Db_Select $select, $table) {
        $query = 'INSERT INTO `' . $table . '` (' . $select->__toString() . ') ON DUPLICATE KEY UPDATE `rating_summary` = VALUES(`rating_summary`)';
        return $query;
    }

    public function getStat($productId) {
        $result = array();
        if ($productId > 0) {
            $adapter = $this->_getReadAdapter();
            $fsql = $adapter->select()
                    ->from(array('main_table' => $this->getTable('review/review')), 'main_table.review_id')
                    ->where('main_table.entity_pk_value = ?', $productId)
                    ->where('main_table.status_id = ?', Mage_Review_Model_Review::STATUS_APPROVED)
                    ->join(array('rdetails' => $this->getTable('review/review_detail')), 'rdetails.review_id = main_table.review_id', array())
                    ->join(array('votes' => $this->getTable('rating/rating_option_vote')), 'main_table.review_id = votes.review_id', array('value' => new Zend_Db_Expr('ROUND(AVG(votes.percent)/20)')))
                    ->group('main_table.review_id');
            $textSql = $fsql->assemble();
            $sql = $adapter->select()
                    ->from(new Zend_Db_Expr("($textSql)"), array('value', 'count' => new Zend_Db_Expr('COUNT(*)')))
                    ->group('value')
                    ->order('value DESC');
            $result = $adapter->fetchAll($sql);
        }
        return $result;
    }

}
