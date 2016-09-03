<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_ExtendedReviews
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */


class Itactica_ExtendedReviews_Block_Form extends Mage_Review_Block_Form {

    public function __construct() {
        parent::__construct();
        $this->setTemplate('itactica_extendedreviews/form.phtml');
    }

    public function getRatingOptionsJson($ratingId, $options) {
        $optionData = array();
        foreach ($options as $option) {
            $optionData[$option->getId()] = $option->getValue();
        }
        $data = array('rating' => $ratingId, 'options' => $optionData);
        return json_encode($data);
    }

    public function getAction() {
        $productId = Mage::app()->getRequest()->getParam('id', false);
        return Mage::getUrl('itactica_extendedreviews/product/post', array('id' => $productId));
    }

}
