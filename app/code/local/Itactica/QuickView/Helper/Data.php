<?php
/**
 * Intenso Premium Theme
 *
 * @category    Itactica
 * @package     Itactica_QuickView
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */
class Itactica_QuickView_Helper_Data extends Mage_Core_Helper_Abstract
{
	/**
     * return true if Quick View is enabled in config
     * @access public
     * @return bool
     */
    public function isEnabled() {
		return Mage::getStoreConfig('intenso/quickview/enable', 
			Mage::app()->getStore());
	}

	/**
     * return true if Quick View is disabled for mobile in config
     * @access public
     * @return bool
     */
    public function isDisabledForMobile() {
		return Mage::getStoreConfig('intenso/quickview/disable_for_mobile', 
			Mage::app()->getStore());
	}
	
}