<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_OrbitSlider
 * @copyright   Copyright (c) 2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_OrbitSlider_Adminhtml_Orbitslider_SliderController extends Itactica_OrbitSlider_Controller_Adminhtml_OrbitSlider
{
    /**
     * init the slider
     * @access protected
     * @return Itactica_OrbitSlider_Model_Slider
     */
    protected function _initSlider(){
        $sliderId  = (int) $this->getRequest()->getParam('id');
        $slider    = Mage::getModel('itactica_orbitslider/slider');
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
        $this->_title(Mage::helper('itactica_orbitslider')->__('Image Slider'))
             ->_title(Mage::helper('itactica_orbitslider')->__('Sliders'));
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
     * slides action
     * @access public
     * @return void
     */
    public function slidesAction() {
        $this->_initSlider();
        $this->loadLayout();
        $this->getLayout()->getBlock('slider.edit.tab.slides')
            ->setSliderSlides($this->getRequest()->getPost('slider_slides', null));
        $this->renderLayout();
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
            $this->_getSession()->addError(Mage::helper('itactica_orbitslider')->__('This slider no longer exists.'));
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getSliderData(true);
        if (!empty($data)) {
            $slider->setData($data);
        }
        Mage::register('slider_data', $slider);
        $this->loadLayout();
        $this->_title(Mage::helper('itactica_orbitslider')->__('Image Slider'))
             ->_title(Mage::helper('itactica_orbitslider')->__('Sliders'));
        if ($slider->getId()){
            $this->_title($slider->getTitle());
        }
        else{
            $this->_title(Mage::helper('itactica_orbitslider')->__('Add slider'));
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
            try {
                $slider = $this->_initSlider();
                $slider->addData($data);
                $slider->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('itactica_orbitslider')->__('Slider was successfully saved'));
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
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_orbitslider')->__('There was a problem saving the slider.'));
                Mage::getSingleton('adminhtml/session')->setSliderData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_orbitslider')->__('Unable to find slider to save.'));
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
                $slider = Mage::getModel('itactica_orbitslider/slider');
                $slider->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('itactica_orbitslider')->__('Slider was successfully deleted.'));
                $this->_redirect('*/*/');
                return;
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_orbitslider')->__('There was an error deleting slider.'));
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_orbitslider')->__('Could not find slider to delete.'));
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
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_orbitslider')->__('Please select sliders to delete.'));
        }
        else {
            try {
                foreach ($sliderIds as $sliderId) {
                    $slider = Mage::getModel('itactica_orbitslider/slider');
                    $slider->setId($sliderId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('itactica_orbitslider')->__('Total of %d sliders were successfully deleted.', count($sliderIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_orbitslider')->__('There was an error deleting sliders.'));
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
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_orbitslider')->__('Please select sliders.'));
        }
        else {
            try {
                foreach ($sliderIds as $sliderId) {
                $slider = Mage::getSingleton('itactica_orbitslider/slider')->load($sliderId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d sliders were successfully updated.', count($sliderIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_orbitslider')->__('There was an error updating sliders.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * mass Animation Type change - action
     * @access public
     * @return void
     */
    public function massAnimationTypeAction(){
        $sliderIds = $this->getRequest()->getParam('slider');
        if(!is_array($sliderIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_orbitslider')->__('Please select sliders.'));
        }
        else {
            try {
                foreach ($sliderIds as $sliderId) {
                $slider = Mage::getSingleton('itactica_orbitslider/slider')->load($sliderId)
                            ->setAnimationType($this->getRequest()->getParam('flag_animation_type'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d sliders were successfully updated.', count($sliderIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_orbitslider')->__('There was an error updating sliders.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * mass Pause on Hover change - action
     * @access public
     * @return void
     */
    public function massPauseOnHoverAction(){
        $sliderIds = $this->getRequest()->getParam('slider');
        if(!is_array($sliderIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_orbitslider')->__('Please select sliders.'));
        }
        else {
            try {
                foreach ($sliderIds as $sliderId) {
                $slider = Mage::getSingleton('itactica_orbitslider/slider')->load($sliderId)
                            ->setPauseOnHover($this->getRequest()->getParam('flag_pause_on_hover'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d sliders were successfully updated.', count($sliderIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_orbitslider')->__('There was an error updating sliders.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * mass Loop change - action
     * @access public
     * @return void
     */
    public function massCircularAction(){
        $sliderIds = $this->getRequest()->getParam('slider');
        if(!is_array($sliderIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_orbitslider')->__('Please select sliders.'));
        }
        else {
            try {
                foreach ($sliderIds as $sliderId) {
                $slider = Mage::getSingleton('itactica_orbitslider/slider')->load($sliderId)
                            ->setCircular($this->getRequest()->getParam('flag_circular'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d sliders were successfully updated.', count($sliderIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_orbitslider')->__('There was an error updating sliders.'));
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
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_orbitslider')->__('Please select sliders.'));
        }
        else {
            try {
                foreach ($sliderIds as $sliderId) {
                $slider = Mage::getSingleton('itactica_orbitslider/slider')->load($sliderId)
                            ->setSwipe($this->getRequest()->getParam('flag_swipe'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d sliders were successfully updated.', count($sliderIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_orbitslider')->__('There was an error updating sliders.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * export as csv - action
     * @access public
     * @return void
     */
    public function exportCsvAction(){
        $fileName   = 'slider.csv';
        $content    = $this->getLayout()->createBlock('itactica_orbitslider/adminhtml_slider_grid')->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * export as MsExcel - action
     * @access public
     * @return void
     */
    public function exportExcelAction(){
        $fileName   = 'slider.xls';
        $content    = $this->getLayout()->createBlock('itactica_orbitslider/adminhtml_slider_grid')->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * export as xml - action
     * @access public
     * @return void
     */
    public function exportXmlAction(){
        $fileName   = 'slider.xml';
        $content    = $this->getLayout()->createBlock('itactica_orbitslider/adminhtml_slider_grid')->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * Check if admin has permissions to visit related pages
     * @access protected
     * @return boolean
     */
    protected function _isAllowed() {
        return Mage::getSingleton('admin/session')->isAllowed('theme/itactica_orbitslider/slider');
    }
}
