<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_Intenso
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_Intenso_Adminhtml_Intenso_ImportController extends Mage_Adminhtml_Controller_Action
{
	/**
     * default action
     * @return void
     */
    public function indexAction() {
		$this->getResponse()->setRedirect($this->getUrl("adminhtml/system_config/edit/section/intenso/")); 
    }

    /**
     * products action
     * @return void
     */
	public function demoproductsAction() {
		$demo = $this->getRequest()->getParam('demo');
		$importType = $this->getRequest()->getParam('import_type');
		$storeId = $this->getRequest()->getParam('store_id');
		Mage::getSingleton('itactica_intenso/import_democontent')->importProducts($demo, $importType, $storeId);
	}

	/**
     * pages action
     * @return void
     */
	public function demopagesAction() {
		$demo = $this->getRequest()->getParam('demo');
		$importType = $this->getRequest()->getParam('import_type');
		$storeId = $this->getRequest()->getParam('store_id');
		Mage::getSingleton('itactica_intenso/import_democontent')->importDemoContent($demo, 'cms/page', $importType, $storeId);
	}

	/**
     * blocks action
     * @return void
     */
    public function demoblocksAction() {
		$demo = $this->getRequest()->getParam('demo');
		$importType = $this->getRequest()->getParam('import_type');
		$storeId = $this->getRequest()->getParam('store_id');
		Mage::getSingleton('itactica_intenso/import_democontent')->importDemoContent($demo, 'cms/block', $importType, $storeId);
	}

	/**
     * widgets action
     * @return void
     */
	public function demoslidersAction() {
		$demo = $this->getRequest()->getParam('demo');
		$importType = $this->getRequest()->getParam('import_type');
		$storeId = $this->getRequest()->getParam('store_id');
		Mage::getSingleton('itactica_intenso/import_democontent')->importDemoSliders($demo, $importType, $storeId);
	}

	/**
     * widgets action
     * @return void
     */
	public function demologosliderAction() {
		$demo = $this->getRequest()->getParam('demo');
		$importType = $this->getRequest()->getParam('import_type');
		$storeId = $this->getRequest()->getParam('store_id');
		Mage::getSingleton('itactica_intenso/import_democontent')->importLogoSliderWidget($demo, $importType, $storeId);
	}

	/**
     * widgets action
     * @return void
     */
	public function demotextboxesAction() {
		$demo = $this->getRequest()->getParam('demo');
		$importType = $this->getRequest()->getParam('import_type');
		Mage::getSingleton('itactica_intenso/import_democontent')->importTextBoxesWidget($demo, $importType);
	}

	/**
     * widgets action
     * @return void
     */
	public function demobillboardAction() {
		$demo = $this->getRequest()->getParam('demo');
		$importType = $this->getRequest()->getParam('import_type');
		Mage::getSingleton('itactica_intenso/import_democontent')->importBillboardWidget($demo, $importType);
	}

	/**
     * widgets action
     * @return void
     */
	public function democalltoactionAction() {
		$demo = $this->getRequest()->getParam('demo');
		$importType = $this->getRequest()->getParam('import_type');
		Mage::getSingleton('itactica_intenso/import_democontent')->importCallToActionWidget($demo, $importType);
	}

	/**
     * configuration action
     * @return void
     */
	public function configurationAction() {
		$demo = $this->getRequest()->getParam('demo');
		$importType = $this->getRequest()->getParam('import_type');
		$scope = $this->getRequest()->getParam('scope');
		Mage::getSingleton('itactica_intenso/import_democontent')->importConfiguration($demo, $importType, $scope);
	}
}