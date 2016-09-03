<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_ExtendedReviews
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_ExtendedReviews_Model_Comment extends Mage_Core_Model_Abstract
{
    protected function _construct() {
        $this->_init('itactica_extendedreviews/comment');
    }

    public function validate() {
        $errors = array();

        if (!Zend_Validate::is($this->getNickname(), 'NotEmpty')) {
            $errors[] = Mage::helper('itactica_extendedreviews')->__('Nickname can\'t be empty');
        }

        if (!Zend_Validate::is($this->getText(), 'NotEmpty')) {
            $errors[] = Mage::helper('itactica_extendedreviews')->__('Comment can\'t be empty');
        }

        if (empty($errors)) {
            return true;
        }
        return $errors;
    }

}
