<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_ExtendedReviews
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_ExtendedReviews_Model_Resource_User extends Mage_Core_Model_Resource_Db_Abstract {

    protected function _construct() {
        $this->_init('itactica_extendedreviews/userdata', 'entity_id');
    }

}
