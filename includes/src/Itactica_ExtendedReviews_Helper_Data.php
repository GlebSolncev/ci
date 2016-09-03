<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_ExtendedReviews
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_ExtendedReviews_Helper_Data extends Mage_Core_Helper_Abstract
{
    protected $_starFilterName = array(
        1 => 'one-star',
        2 => 'two-stars',
        3 => 'three-stars',
        4 => 'four-stars',
        5 => 'five-stars');

    /**
     * Get filter action
     *
     * @param int $stars
     * @return string
     */
    public function starFilterName($stars) {
        if (isset($this->_starFilterName[$stars])) {
            return $this->_starFilterName[$stars];
        }
    }

    /**
     * Get filter header
     *
     * @param int $stars
     * @return string
     */
    public function starFilterCount() {
        $filter = Mage::app()->getRequest()->getParam('filter');
        return array_search($filter, $this->_starFilterName);
    }

    /**
     * Returns max number of characters for review's preview
     *
     * @return int
     */
    public function getMaxCharactersForPreview() {
        return Mage::getStoreConfig('itactica_extendedreviews/reviews/max_words_preview');
    }

    /**
     * Returns number of reviews to be shown on product page
     *
     * @return int
     */
    public function getNumReviewsForProductPage() {
        return Mage::getStoreConfig('itactica_extendedreviews/reviews/num_reviews');
    }

    /**
     * Get comment action url
     *
     * @param int $reviewId
     * @return url|string
     */
    public function getCommentsAction($reviewId) {
        return Mage::getUrl('itactica_extendedreviews/product_comment/list/', array('id' => $reviewId));
    }

    /**
     * Get add comment action url
     *
     * @param int $reviewId
     * @return url|string
     */
    public function getAddCommentAction($reviewId) {
        return Mage::getUrl('itactica_extendedreviews/product_comment/add/', array('id' => $reviewId));
    }

    /**
     * Returns decoded cookie
     *
     * @param string $key
     * @return bool|string
     */
    public function getCookie($key, $decode = false)
    {
        $cookie = Mage::getModel('core/cookie');
        if ($cookie->get($key)) {
            $result = $cookie->get($key);
            if($decode){
                $result = base64_decode($result);
            }
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Sets encoded cookie
     *
     * @param string $key
     * @param mixed $value
     * @return Zend_Controller_Request_Http
     */
    public function setCookie($key, $value, $encode = true)
    {
        $version = Mage::getVersion();
        $cookie = Mage::getModel('core/cookie');
        $lifetime = 3600 * 24 * 365;
        if($encode){
            $value = base64_encode($value);
        }

        foreach(Mage::app()->getStores() as $store){
            $urlParse = parse_url($store->getBaseUrl());
            $path = rtrim(str_replace('index.php', '', $urlParse['path']), '/');
            $cookie->set($key, $value, true, $path);
        }

        return true;
    }

    /**
     * Returns static block identifier
     *
     * @return string
     */
    public function getStaticBlock() {
        return Mage::getStoreConfig('itactica_extendedreviews/reviews/static_block');
    }
}
