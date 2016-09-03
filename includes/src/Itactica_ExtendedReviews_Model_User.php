<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_ExtendedReviews
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_ExtendedReviews_Model_User extends Mage_Core_Model_Abstract
{
    protected function _construct() {
        $this->_init('itactica_extendedreviews/user');
    }

    public function identify() {
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        $ip = ip2long($_SERVER['REMOTE_ADDR']);
        $data = array(
            'ip' => $ip,
            'http_user_agent' => Mage::helper('core/http')->getHttpUserAgent(),
            'cookie' => Mage::helper('itactica_extendedreviews')->getCookie('magereviews', true),
        );
        $newCookieCode = $this->_generateCookieCode($data['ip'] . $data['http_user_agent']);

        // check if user has a review cookie
        if ($data['cookie']) {
            $this->load($data['cookie'], 'cookie');
            if ($this->getIp() != $data['ip'] || $this->getHttpUserAgent() != $data['http_user_agent']) {
                $data['cookie'] = $newCookieCode;
                $this->setData($data)->save();
            }
        } else {
            // check if IP and HTTP user agent are stored in database
            $collection = $this->getCollection()->getUserByIpAndUserAgent($data['ip'], $data['http_user_agent']);
            $user = $collection->getLastItem();
            if ($user && $user->getId()) {
                $this->setData($user->getData());
            } else {
                $data['cookie'] = $newCookieCode;
                $this->setData($data)->save();
            }
        }

        // create or update cookie
        Mage::helper('itactica_extendedreviews')->setCookie('magereviews', $this->getCookie(), true);

        return $this;
    }

    protected function _generateCookieCode($salt = '') {
        return md5(time() . $salt);
    }
}
