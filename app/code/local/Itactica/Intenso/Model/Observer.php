<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_Intenso
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_Intenso_Model_Observer
{
	/**
	 * generate CSS file after store edit
	 *
	 * @access public
	 * @param Varien_Event_Observer $observer
	 * @return void
	 */
    public function afterStoreEdit($observer) {
    	$store = $observer->getEvent()->getStore();
		$storeCode = $store->getCode();
		$websiteCode = $store->getWebsite()->getCode();
		
		Mage::getSingleton('itactica_intenso/css_generator')->generateCssFromConfig($storeCode, $websiteCode);
    }

    /**
	 * generate CSS file after theme config edit
	 *
	 * @access public
	 * @param Varien_Event_Observer $observer
	 * @return void
	 */
    public function afterConfigSave() {
    	$configSection = Mage::app()->getRequest()->getParam('section');

		if ($configSection == 'intenso' || $configSection == 'intenso_design') {
			$storeCode = Mage::app()->getRequest()->getParam('store');
			$websiteCode = Mage::app()->getRequest()->getParam('website');
			Mage::getSingleton('itactica_intenso/css_generator')->generateCssFromConfig($storeCode, $storeCode);
		}
    }
}