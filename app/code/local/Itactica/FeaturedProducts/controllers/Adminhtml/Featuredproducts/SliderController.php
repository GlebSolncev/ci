<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_FeaturedProducts
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_FeaturedProducts_Adminhtml_Featuredproducts_SliderController extends Itactica_FeaturedProducts_Controller_Adminhtml_FeaturedProducts
{
    /**
     * init the slider
     * @access protected
     * @return Itactica_FeaturedProducts_Model_Slider
     */
    protected function _initSlider(){
        $sliderId  = (int) $this->getRequest()->getParam('id');
        $slider    = Mage::getModel('itactica_featuredproducts/slider');
        if ($sliderId) {
            $slider->load($sliderId);
        }
        Mage::register('current_slider', $slider);
        return $slider;
    }
     /**
     * default action
     * @access public
     * @return void
     */
    public function indexAction() {
        $this->loadLayout();
        $this->_title(Mage::helper('itactica_featuredproducts')->__('Featured Products'))
             ->_title(Mage::helper('itactica_featuredproducts')->__('Sliders'));
        $this->renderLayout();
    }
    /**
     * grid action
     * @access public
     * @return void
     */
    public function gridAction() {
        $this->loadLayout()->renderLayout();
    }
    /**
     * edit slider - action
     * @access public
     * @return void
     */
    public function editAction() {
        $sliderId    = $this->getRequest()->getParam('id');
        $slider      = $this->_initSlider();
        if ($sliderId && !$slider->getId()) {
            $this->_getSession()->addError(Mage::helper('itactica_featuredproducts')->__('This slider no longer exists.'));
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getSliderData(true);
        if (!empty($data)) {
            $slider->setData($data);
        }
        Mage::register('slider_data', $slider);
        $this->loadLayout();
        $this->_title(Mage::helper('itactica_featuredproducts')->__('Featured Products'))
             ->_title(Mage::helper('itactica_featuredproducts')->__('Sliders'));
        if ($slider->getId()){
            $this->_title($slider->getTitle());
        }
        else{
            $this->_title(Mage::helper('itactica_featuredproducts')->__('Add slider'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }
    /**
     * new slider action
     * @access public
     * @return void
     */
    public function newAction() {
        $this->_forward('edit');
    }
    /**
     * save slider - action
     * @access public
     * @return void
     */
    public function saveAction() {
        if ($data = $this->getRequest()->getPost('slider')) {
            // array to string conversion for category_ids
            if (isset($data['category_ids'])) {
                if (is_array($data['category_ids'])) {
                    $data['category_ids'] = implode(",", $data['category_ids']);
                } else {
                    $data['category_ids'] = '';
                }
            }

            try {
                $slider = $this->_initSlider();
                $slider->addData($data);
                $products = $this->getRequest()->getPost('products', -1);
                if ($products != -1) {
                    $slider->setProductsData(Mage::helper('adminhtml/js')->decodeGridSerializedInput($products));
                }
                $slider->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('itactica_featuredproducts')->__('Slider was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $slider->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setSliderData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
            catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_featuredproducts')->__('There was a problem saving the slider.'));
                Mage::getSingleton('adminhtml/session')->setSliderData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_featuredproducts')->__('Unable to find slider to save.'));
        $this->_redirect('*/*/');
    }
    /**
     * delete slider - action
     * @access public
     * @return void
     */
    public function deleteAction() {
        if( $this->getRequest()->getParam('id') > 0) {
            try {
                $slider = Mage::getModel('itactica_featuredproducts/slider');
                $slider->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('itactica_featuredproducts')->__('Slider was successfully deleted.'));
                $this->_redirect('*/*/');
                return;
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_featuredproducts')->__('There was an error deleting slider.'));
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_featuredproducts')->__('Could not find slider to delete.'));
        $this->_redirect('*/*/');
    }
    /**
     * mass delete slider - action
     * @access public
     * @return void
     */
    public function massDeleteAction() {
        $sliderIds = $this->getRequest()->getParam('slider');
        if(!is_array($sliderIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_featuredproducts')->__('Please select sliders to delete.'));
        }
        else {
            try {
                foreach ($sliderIds as $sliderId) {
                    $slider = Mage::getModel('itactica_featuredproducts/slider');
                    $slider->setId($sliderId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('itactica_featuredproducts')->__('Total of %d sliders were successfully deleted.', count($sliderIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_featuredproducts')->__('There was an error deleting sliders.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * mass status change - action
     * @access public
     * @return void
     */
    public function massStatusAction(){
        $sliderIds = $this->getRequest()->getParam('slider');
        if(!is_array($sliderIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_featuredproducts')->__('Please select sliders.'));
        }
        else {
            try {
                foreach ($sliderIds as $sliderId) {
                $slider = Mage::getSingleton('itactica_featuredproducts/slider')->load($sliderId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(Mage::helper('itactica_featuredproducts')->__('Total of %d sliders were successfully updated.', count($sliderIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_featuredproducts')->__('There was an error updating sliders.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * mass Products Source change - action
     * @access public
     * @return void
     */
    public function massProductsSourceAction(){
        $sliderIds = $this->getRequest()->getParam('slider');
        if(!is_array($sliderIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_featuredproducts')->__('Please select sliders.'));
        }
        else {
            try {
                foreach ($sliderIds as $sliderId) {
                $slider = Mage::getSingleton('itactica_featuredproducts/slider')->load($sliderId)
                            ->setProductsSource($this->getRequest()->getParam('flag_products_source'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(Mage::helper('itactica_featuredproducts')->__('Total of %d sliders were successfully updated.', count($sliderIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_featuredproducts')->__('There was an error updating sliders.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * mass Product Filter change - action
     * @access public
     * @return void
     */
    public function massProductFilterAction(){
        $sliderIds = $this->getRequest()->getParam('slider');
        if(!is_array($sliderIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_featuredproducts')->__('Please select sliders.'));
        }
        else {
            try {
                foreach ($sliderIds as $sliderId) {
                $slider = Mage::getSingleton('itactica_featuredproducts/slider')->load($sliderId)
                            ->setProductFilter($this->getRequest()->getParam('flag_product_filter'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(Mage::helper('itactica_featuredproducts')->__('Total of %d sliders were successfully updated.', count($sliderIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_featuredproducts')->__('There was an error updating sliders.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * mass Show Category Tabs change - action
     * @access public
     * @return void
     */
    public function massShowCategoryTabsAction(){
        $sliderIds = $this->getRequest()->getParam('slider');
        if(!is_array($sliderIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_featuredproducts')->__('Please select sliders.'));
        }
        else {
            try {
                foreach ($sliderIds as $sliderId) {
                $slider = Mage::getSingleton('itactica_featuredproducts/slider')->load($sliderId)
                            ->setShowCategoryTabs($this->getRequest()->getParam('flag_show_category_tabs'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(Mage::helper('itactica_featuredproducts')->__('Total of %d sliders were successfully updated.', count($sliderIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_featuredproducts')->__('There was an error updating sliders.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * mass Display Out of Stock Products change - action
     * @access public
     * @return void
     */
    public function massShowOutOfStockAction(){
        $sliderIds = $this->getRequest()->getParam('slider');
        if(!is_array($sliderIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_featuredproducts')->__('Please select sliders.'));
        }
        else {
            try {
                foreach ($sliderIds as $sliderId) {
                $slider = Mage::getSingleton('itactica_featuredproducts/slider')->load($sliderId)
                            ->setShowOutOfStock($this->getRequest()->getParam('flag_show_out_of_stock'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(Mage::helper('itactica_featuredproducts')->__('Total of %d sliders were successfully updated.', count($sliderIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_featuredproducts')->__('There was an error updating sliders.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * mass Show Price Tag change - action
     * @access public
     * @return void
     */
    public function massShowPriceTagAction(){
        $sliderIds = $this->getRequest()->getParam('slider');
        if(!is_array($sliderIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_featuredproducts')->__('Please select sliders.'));
        }
        else {
            try {
                foreach ($sliderIds as $sliderId) {
                $slider = Mage::getSingleton('itactica_featuredproducts/slider')->load($sliderId)
                            ->setShowPriceTag($this->getRequest()->getParam('flag_show_price_tag'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(Mage::helper('itactica_featuredproducts')->__('Total of %d sliders were successfully updated.', count($sliderIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_featuredproducts')->__('There was an error updating sliders.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * mass Show Products Rating change - action
     * @access public
     * @return void
     */
    public function massShowRatingAction(){
        $sliderIds = $this->getRequest()->getParam('slider');
        if(!is_array($sliderIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_featuredproducts')->__('Please select sliders.'));
        }
        else {
            try {
                foreach ($sliderIds as $sliderId) {
                $slider = Mage::getSingleton('itactica_featuredproducts/slider')->load($sliderId)
                            ->setShowRating($this->getRequest()->getParam('flag_show_rating'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(Mage::helper('itactica_featuredproducts')->__('Total of %d sliders were successfully updated.', count($sliderIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_featuredproducts')->__('There was an error updating sliders.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * mass Show Color Options change - action
     * @access public
     * @return void
     */
    public function massShowColorOptionsAction(){
        $sliderIds = $this->getRequest()->getParam('slider');
        if(!is_array($sliderIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_featuredproducts')->__('Please select sliders.'));
        }
        else {
            try {
                foreach ($sliderIds as $sliderId) {
                $slider = Mage::getSingleton('itactica_featuredproducts/slider')->load($sliderId)
                            ->setShowColorOptions($this->getRequest()->getParam('flag_show_color_options'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(Mage::helper('itactica_featuredproducts')->__('Total of %d sliders were successfully updated.', count($sliderIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_featuredproducts')->__('There was an error updating sliders.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * mass Show Add to Cart Button change - action
     * @access public
     * @return void
     */
    public function massShowAddToCartButtonAction(){
        $sliderIds = $this->getRequest()->getParam('slider');
        if(!is_array($sliderIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_featuredproducts')->__('Please select sliders.'));
        }
        else {
            try {
                foreach ($sliderIds as $sliderId) {
                $slider = Mage::getSingleton('itactica_featuredproducts/slider')->load($sliderId)
                            ->setShowAddToCartButton($this->getRequest()->getParam('flag_show_add_to_cart_button'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(Mage::helper('itactica_featuredproducts')->__('Total of %d sliders were successfully updated.', count($sliderIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_featuredproducts')->__('There was an error updating sliders.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * mass Show Add to Compare Button change - action
     * @access public
     * @return void
     */
    public function massShowCompareButtonAction(){
        $sliderIds = $this->getRequest()->getParam('slider');
        if(!is_array($sliderIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_featuredproducts')->__('Please select sliders.'));
        }
        else {
            try {
                foreach ($sliderIds as $sliderId) {
                $slider = Mage::getSingleton('itactica_featuredproducts/slider')->load($sliderId)
                            ->setShowCompareButton($this->getRequest()->getParam('flag_show_compare_button'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(Mage::helper('itactica_featuredproducts')->__('Total of %d sliders were successfully updated.', count($sliderIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_featuredproducts')->__('There was an error updating sliders.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * mass Show Add to Wishlist Button change - action
     * @access public
     * @return void
     */
    public function massShowWishlistButtonAction(){
        $sliderIds = $this->getRequest()->getParam('slider');
        if(!is_array($sliderIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_featuredproducts')->__('Please select sliders.'));
        }
        else {
            try {
                foreach ($sliderIds as $sliderId) {
                $slider = Mage::getSingleton('itactica_featuredproducts/slider')->load($sliderId)
                            ->setShowWishlistButton($this->getRequest()->getParam('flag_show_wishlist_button'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(Mage::helper('itactica_featuredproducts')->__('Total of %d sliders were successfully updated.', count($sliderIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_featuredproducts')->__('There was an error updating sliders.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * mass Touch Swipe change - action
     * @access public
     * @return void
     */
    public function massSwipeAction(){
        $sliderIds = $this->getRequest()->getParam('slider');
        if(!is_array($sliderIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_featuredproducts')->__('Please select sliders.'));
        }
        else {
            try {
                foreach ($sliderIds as $sliderId) {
                $slider = Mage::getSingleton('itactica_featuredproducts/slider')->load($sliderId)
                            ->setSwipe($this->getRequest()->getParam('flag_swipe'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(Mage::helper('itactica_featuredproducts')->__('Total of %d sliders were successfully updated.', count($sliderIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_featuredproducts')->__('There was an error updating sliders.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * get grid of products action
     * @access public
     * @return void
     */
    public function productsAction(){
        $this->_initSlider();
        $this->loadLayout();
        $this->getLayout()->getBlock('slider.edit.tab.product')
            ->setSliderProducts($this->getRequest()->getPost('slider_products', null));
        $this->renderLayout();
    }
    /**
     * get grid of products action
     * @access public
     * @return void
     */
    public function productsgridAction(){
        $this->_initSlider();
        $this->loadLayout();
        $this->getLayout()->getBlock('slider.edit.tab.product')
            ->setSliderProducts($this->getRequest()->getPost('slider_products', null));
        $this->renderLayout();
    }
    /**
     * export as csv - action
     * @access public
     * @return void
     */
    public function exportCsvAction(){
        $fileName   = 'slider.csv';
        $content    = $this->getLayout()->createBlock('itactica_featuredproducts/adminhtml_slider_grid')->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * export as MsExcel - action
     * @access public
     * @return void
     */
    public function exportExcelAction(){
        $fileName   = 'slider.xls';
        $content    = $this->getLayout()->createBlock('itactica_featuredproducts/adminhtml_slider_grid')->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * export as xml - action
     * @access public
     * @return void
     */
    public function exportXmlAction(){
        $fileName   = 'slider.xml';
        $content    = $this->getLayout()->createBlock('itactica_featuredproducts/adminhtml_slider_grid')->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * Check if admin has permissions to visit related pages
     * @access protected
     * @return boolean
     */
    protected function _isAllowed() {
        return Mage::getSingleton('admin/session')->isAllowed('theme/itactica_featuredproducts/slider');
    }
}
