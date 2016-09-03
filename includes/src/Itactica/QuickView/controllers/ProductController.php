<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_QuickView
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

require_once 'Mage/Catalog/controllers/ProductController.php';

class Itactica_QuickView_ProductController extends Mage_Catalog_ProductController
{

	/**
     * view action
     * @return void
     */
    public function viewAction() {
    	if ($this->getRequest()->isXmlHttpRequest()) {
			if ($product = $this->_initProduct()) {
				$this->_initProductLayout($product);

			    $update = $this->getLayout()->getUpdate();
            	$update->addHandle('default');
            	$update->addHandle('itactica_quickview_product_view');
            	$this->addActionLayoutHandles();
            	$update->addHandle('PRODUCT_TYPE_' . $product->getTypeId());
        		$update->addHandle('PRODUCT_' . $product->getId());
        		$this->loadLayoutUpdates();
        		$this->generateLayoutXml()->generateLayoutBlocks();
        		$this->renderLayout();
        	}
    	}
    }
}