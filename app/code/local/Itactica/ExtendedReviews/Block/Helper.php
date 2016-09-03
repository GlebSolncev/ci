<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_ExtendedReviews
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */
class Itactica_ExtendedReviews_Block_Helper extends Mage_Review_Block_Helper
{
    protected $_helper;

    protected $_writtenByTemplates = array(
        'review' => array('By %s from %s, %s', 'By %s from %s', 'By %s', 'On %s'),
        'category' => array('%s | %s | %s', '%s | %s', '%s'),
    );

    protected $_writtenByType = 'review';

    public function _construct() {
        parent::_construct();
        $this->_helper = Mage::helper('itactica_extendedreviews');
        $this->setTemplate('itactica_extendedreviews/product_review.phtml');
        $this->addTemplate('head', 'itactica_extendedreviews/helper/head.phtml');
        $this->setWrittenByType('category');
        $this->addTemplate('short', 'itactica_extendedreviews/helper/summary_short.phtml');
    }

    public function getProduct() {
        $product = parent::getProduct();
        if (!$product) {
            $product = Mage::registry('current_product');
        }
        return $product;
    }

    public function getSummaryHead($templateType, $displayIfNoReviews) {
        return $this->getSummaryHtml($this->getProduct(), $templateType, $displayIfNoReviews);
    }

    public function getCollectionByDate() {
        return $this->_getCollection()->setDateOrder('DESC');
    }

    public function getCollectionByHelpful() {
        return $this->_getCollection()->setHelpfulOrder('DESC');
    }

    protected function _getCollection() {
        $collection = Mage::getResourceModel('itactica_extendedreviews/review_collection');
        $collection->limit(Mage::helper('itactica_extendedreviews')->getNumReviewsForProductPage())
                ->addStoreFilter(Mage::app()->getStore()->getId())
                ->addStatusFilter(Mage_Review_Model_Review::STATUS_APPROVED)
                ->addEntityFilter('product', $this->getProduct()->getId())
                ->appendCanVote();
        return $collection;
    }

    public function getSummaryRatingHtmlForReview($review) {
        return $this->getStarsHtmlForValue($review->getRatingSummary());
    }

    public function getStarsHtmlForValue($val) {
        $this->setReviewRating($val);
        $template = $this->getTemplate();
        $this->setTemplate('itactica_extendedreviews/helper/star.phtml');
        $html = $this->toHtml();
        $this->setTemplate($template);
        return $html;
    }

    public function formatDate($date = null, $format = Mage_Core_Model_Locale::FORMAT_TYPE_SHORT, $showTime = false) {
        $date = Mage::helper('core')->formatDate($date, Mage_Core_Model_Locale::FORMAT_TYPE_LONG);
        return $date;
    }

    public function getReviewUrl($id) {
        return Mage::getUrl('review/product/view', array('id' => $id));
    }

    public function getReviewContentHtml($review) {
        $this->setCurrentReview($review);
        $template = $this->getTemplate();
        $this->setTemplate('itactica_extendedreviews/helper/review.phtml');
        $html = $this->toHtml();
        $this->setTemplate($template);
        return $html;
    }

    public function getProductReviewsAction($productId) {
        return Mage::getUrl('itactica_extendedreviews/product/reviews', array('id' => $productId));
    }

    public function setWrittenByType($type) {
        $this->_writtenByType = $type;
        return $this;
    }

    public function getProductStat($productId) {
        return Mage::getResourceModel('itactica_extendedreviews/review')->getStat($productId);
    }
}
