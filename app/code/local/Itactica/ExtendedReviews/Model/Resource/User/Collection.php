<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_ExtendedReviews
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_ExtendedReviews_Model_Resource_User_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct() {
        parent::_construct();
        $this->_init('itactica_extendedreviews/user');
    }

    public function getUserByIpAndUserAgent($longIp, $userAgent) {
        $this->addFieldToFilter('ip', array('eq' => $longIp))
                ->addFieldToFilter('http_user_agent', array('eq' => $userAgent));
        return $this;
    }
}
