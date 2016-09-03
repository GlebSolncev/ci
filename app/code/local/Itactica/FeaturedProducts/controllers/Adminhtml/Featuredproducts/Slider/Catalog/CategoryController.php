<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_FeaturedProducts
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

require_once ("Mage/Adminhtml/controllers/Catalog/CategoryController.php");
class Itactica_FeaturedProducts_Adminhtml_Featuredproducts_Slider_Catalog_CategoryController extends Mage_Adminhtml_Catalog_CategoryController
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
     * sliders grid in the catalog page
     * @access public
     * @return void
     */
    public function slidersgridAction(){
        $this->_initCategory();
        $this->loadLayout();
        $this->getLayout()->getBlock('category.edit.tab.slider')
            ->setCategorySliders($this->getRequest()->getPost('category_sliders', null));
        $this->renderLayout();
    }
}
