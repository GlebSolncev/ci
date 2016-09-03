<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_ExtendedReviews
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_ExtendedReviews_Block_Adminhtml_Comment_Main extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct() {
        parent::__construct();
        $this->_removeButton('add');
        $this->_controller = 'adminhtml_comment';
        $this->_blockGroup = 'itactica_extendedreviews';

        $customerId = $this->getRequest()->getParam('customerId', false);
        $customerName = '';
        if ($customerId) {
            $customer = Mage::getModel('customer/customer')->load($customerId);
            $customerName = $customer->getFirstname() . ' ' . $customer->getLastname();
            $customerName = $this->escapeHtml($customerName);
        }

        if (Mage::registry('usePendingFilter') === true) {
            if ($customerName) {
                $this->_headerText = Mage::helper('itactica_extendedreviews')->__('Pending Comments of Customer `%s`', $customerName);
            } else {
                $this->_headerText = Mage::helper('itactica_extendedreviews')->__('Pending Comments');
            }
        } else {
            if ($customerName) {
                $this->_headerText = Mage::helper('itactica_extendedreviews')->__('All Comments of Customer `%s`', $customerName);
            } else {
                $this->_headerText = Mage::helper('itactica_extendedreviews')->__('All Comments');
            }
        }
    }

}
