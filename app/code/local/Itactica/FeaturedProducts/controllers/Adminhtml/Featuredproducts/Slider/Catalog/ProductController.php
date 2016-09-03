<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_FeaturedProducts
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

require_once ("Mage/Adminhtml/controllers/Catalog/ProductController.php");
class Itactica_FeaturedProducts_Adminhtml_Featuredproducts_Slider_Catalog_ProductController extends Mage_Adminhtml_Catalog_ProductController
{
    /**
     * construct
     * @access protected
     * @return void
     */
    protected function _construct(){
        // Define module dependent translate
        $this->setUsedModuleName('Itactica_FeaturedProducts');
    }
    /**
     * sliders in the product page
     * @access public
     * @return void
     */
    public function slidersAction(){
        $this->_initProduct();
        $this->loadLayout();
        $this->getLayout()->getBlock('product.edit.tab.slider')
            ->setProductSliders($this->getRequest()->getPost('product_sliders', null));
        $this->renderLayout();
    }
    /**
     * sliders grid in the product page
     * @access public
     * @return void
     */
    public function slidersGridAction(){
        $this->_initProduct();
        $this->loadLayout();
        $this->getLayout()->getBlock('product.edit.tab.slider')
            ->setProductSliders($this->getRequest()->getPost('product_sliders', null));
        $this->renderLayout();
    }
}
