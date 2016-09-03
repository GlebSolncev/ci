<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_ExtendedReviews
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_ExtendedReviews_Block_Product_Review_List_Toolbar extends Mage_Page_Block_Html_Pager {

    protected $_avalibleOrders = array();
    protected $_orderVarName = 'order';
    protected $_orderField = null;

    protected function _construct() {
        parent::_construct();
        $this->setTemplate('itactica_extendedreviews/list/toolbar.phtml');
        $this->_avalibleOrders = array('top-helpful' => Mage::helper('itactica_extendedreviews')->__('Most Helpful First'), 'top-recent' => Mage::helper('itactica_extendedreviews')->__('Most Recent First'));
    }

    public function getOrderUrl($order) {
        if (is_null($order)) {
            $order = $this->getCurrentOrder() ? $this->getCurrentOrder() : $this->_availableOrder[0];
        }
        return $this->getPagerUrl(array(
                    $this->getOrderVarName() => $order,
                    $this->getPageVarName() => null
        ));
    }

    public function getAvailableOrders() {
        return $this->_avalibleOrders;
    }

    public function isOrderCurrent($order) {
        return ($order == $this->getCurrentOrder());
    }

    public function getCurrentOrder() {
        $order = $this->_getData('_current_grid_order');
        if ($order) {
            return $order;
        }

        $orders = $this->getAvailableOrders();
        $defaultOrder = $this->_orderField;

        if (!isset($orders[$defaultOrder])) {
            $keys = array_keys($orders);
            $defaultOrder = $keys[0];
        }

        $order = $this->getRequest()->getParam($this->getOrderVarName());
        if ($order && isset($orders[$order])) {
            if ($order == $defaultOrder) {
                Mage::getSingleton('catalog/session')->unsSortOrder();
            }
        } else {
            $order = Mage::getSingleton('catalog/session')->getSortOrder();
        }
        // validate session value
        if (!$order || !isset($orders[$order])) {
            $order = $defaultOrder;
        }
        $this->setData('_current_grid_order', $order);
        return $order;
    }

    public function getOrderVarName() {
        return $this->_orderVarName;
    }

    public function setCollection($collection) {
        parent::setCollection($collection);
        $order = $this->getCurrentOrder();
        if ($order == 'top-helpful') {
            $collection->setHelpfulOrder('DESC');
        } else if ($order == 'top-recent') {
            $collection->setDateOrder('DESC');
        }
        $filter = $this->getRequest()->getParam('filter');
        if ($filter == 'five-stars') {
            $collection->setFiveStarsFilter();
        } elseif ($filter == 'four-stars') {
            $collection->setFourStarsFilter();
        } elseif ($filter == 'three-stars') {
            $collection->setThreeStarsFilter();
        } elseif ($filter == 'two-stars') {
            $collection->setTwoStarsFilter();
        } elseif ($filter == 'one-star') {
            $collection->setOneStarFilter();
        }
    }

}
