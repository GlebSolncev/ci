<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_ExtendedReviews
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_ExtendedReviews_Model_Resource_Comment_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct() {
        $this->_init('itactica_extendedreviews/comment');
    }

    public function appendReviewTitle() {
        $this->getSelect()
                ->join(array('tb_details' => $this->getTable('review/review_detail')), 'tb_details.review_id = main_table.review_id', 'tb_details.title');
        return $this;
    }

}
