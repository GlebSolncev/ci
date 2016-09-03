<?php
class Eshift_Escommon_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_PATH_JQUERY_ENABLED = 'escommon/jquery/enabled19';
    const XML_PATH_USER_USER_EMAIL = 'escommon/user/user_email';
    const XML_PATH_OTHER_FAWESOME = 'escommon/other/fawesome';

    public function isJqueryEnabled()
    {
        return Mage::getStoreConfig( self::XML_PATH_JQUERY_ENABLED );
    }

    public function getJqueryFallbackSrc()
    {
        $jspath = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_JS);
        $jquerypath = $jspath.'eshift/jquery/jquery-1.9.1.min.js';
        return $jquerypath;
    }

    public function getUserHash()
    {
        $userEmail = Mage::getStoreConfig( self::XML_PATH_USER_USER_EMAIL );
        $userHash = md5($userEmail);
        return $userHash;
    }

    public function isUserEmailSet()
    {
        return Mage::getStoreConfigFlag( self::XML_PATH_USER_USER_EMAIL );
    }

    public function isFontAwesomeEnabled()
    {
        return Mage::getStoreConfigFlag( self::XML_PATH_OTHER_FAWESOME );
    }
}
	 