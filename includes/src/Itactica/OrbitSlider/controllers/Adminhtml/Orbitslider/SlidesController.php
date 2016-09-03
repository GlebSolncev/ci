<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_OrbitSlider
 * @copyright   Copyright (c) 2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_OrbitSlider_Adminhtml_Orbitslider_SlidesController extends Itactica_OrbitSlider_Controller_Adminhtml_OrbitSlider
{
    /**
     * init the slide
     * @access protected
     * @return Itactica_OrbitSlider_Model_Slides
     */
    protected function _initSlide(){
        $slideId  = (int) $this->getRequest()->getParam('id');
        $slide    = Mage::getModel('itactica_orbitslider/slides');
        if ($slideId) {
            $slide->load($slideId);
        }
        Mage::register('current_slide', $slide);
        return $slide;
    }
     /**
     * default action
     * @access public
     * @return void
     */
    public function indexAction() {
        $this->loadLayout();
        $this->_title(Mage::helper('itactica_orbitslider')->__('Image Slider'))
             ->_title(Mage::helper('itactica_orbitslider')->__('Slides'));
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
     * edit slide - action
     * @access public
     * @return void
     */
    public function editAction() {
        $slideId    = $this->getRequest()->getParam('id');
        $slide      = $this->_initSlide();
        if ($slideId && !$slide->getId()) {
            $this->_getSession()->addError(Mage::helper('itactica_orbitslider')->__('This image no longer exists.'));
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getSlideData(true);
        if (!empty($data)) {
            $slide->setData($data);
        }
        Mage::register('slide_data', $slide);
        $this->loadLayout();
        $this->_title(Mage::helper('itactica_orbitslider')->__('Image Slider'))
             ->_title(Mage::helper('itactica_orbitslider')->__('Slides'));
        if ($slide->getId()){
            $this->_title($slide->getTitle());
        }
        else{
            $this->_title(Mage::helper('itactica_orbitslider')->__('Add Slide'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }
    /**
     * new slide action
     * @access public
     * @return void
     */
    public function newAction() {
        $this->_forward('edit');
    }
    /**
     * save slide - action
     * @access public
     * @return void
     */
    public function saveAction() {
        if ($data = $this->getRequest()->getPost('slide')) {
            try {
                $slide = $this->_initSlide();
                $slide->addData($data);
                $filenameLarge = $this->_uploadAndGetName('filename_for_large', Mage::helper('itactica_orbitslider/slides_image')->getImageBaseDir(), $data);
                $filenameMedium = $this->_uploadAndGetName('filename_for_medium', Mage::helper('itactica_orbitslider/slides_image')->getImageBaseDir(), $data);
                $filenameSmall = $this->_uploadAndGetName('filename_for_small', Mage::helper('itactica_orbitslider/slides_image')->getImageBaseDir(), $data);
                $slide->setData('filename_for_large', $filenameLarge);
                $slide->setData('filename_for_medium', $filenameMedium);
                $slide->setData('filename_for_small', $filenameSmall);
                $slide->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('itactica_orbitslider')->__('The slide was successfully saved.'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $slide->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            }
            catch (Mage_Core_Exception $e){
                if (isset($data['filename']['value'])){
                    $data['filename'] = $data['filename']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setSlideData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
            catch (Exception $e) {
                Mage::logException($e);
                if (isset($data['filename']['value'])){
                    $data['filename'] = $data['filename']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_orbitslider')->__('There was a problem saving the image.'));
                Mage::getSingleton('adminhtml/session')->setSlideData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_orbitslider')->__('Unable to find the slide to save.'));
        $this->_redirect('*/*/');
    }
    /**
     * delete slide - action
     * @access public
     * @return void
     */
    public function deleteAction() {
        if( $this->getRequest()->getParam('id') > 0) {
            try {
                $slide = Mage::getModel('itactica_orbitslider/slides');
                $slide->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('itactica_orbitslider')->__('The slide was successfully deleted.'));
                $this->_redirect('*/*/');
                return;
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_orbitslider')->__('There was an error deleting the slide.'));
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_orbitslider')->__('Could not find a slide to delete.'));
        $this->_redirect('*/*/');
    }
    /**
     * mass delete slides - action
     * @access public
     * @return void
     */
    public function massDeleteAction() {
        $slideIds = $this->getRequest()->getParam('slide');
        if(!is_array($slideIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_orbitslider')->__('Please select a slide to delete.'));
        }
        else {
            try {
                foreach ($slideIds as $slideId) {
                    $slide = Mage::getModel('itactica_orbitslider/slides');
                    $slide->setId($slideId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('itactica_orbitslider')->__('Total of %d slides were successfully deleted.', count($slideIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_orbitslider')->__('There was an error deleting the slide.'));
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
        $slideIds = $this->getRequest()->getParam('slide');
        if(!is_array($slideIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_orbitslider')->__('Please select a slide.'));
        }
        else {
            try {
                foreach ($slideIds as $slideId) {
                $slide = Mage::getSingleton('itactica_orbitslider/slides')->load($slideId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d slides were successfully updated.', count($slideIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_orbitslider')->__('There was an error updating the slide.'));
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
        $fileName   = 'slides.csv';
        $content    = $this->getLayout()->createBlock('itactica_orbitslider/adminhtml_slides_grid')->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * export as MsExcel - action
     * @access public
     * @return void
     */
    public function exportExcelAction(){
        $fileName   = 'slides.xls';
        $content    = $this->getLayout()->createBlock('itactica_orbitslider/adminhtml_slides_grid')->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * export as xml - action
     * @access public
     * @return void
     */
    public function exportXmlAction(){
        $fileName   = 'slides.xml';
        $content    = $this->getLayout()->createBlock('itactica_orbitslider/adminhtml_slides_grid')->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * Check if admin has permissions to visit related pages
     * @access protected
     * @return boolean
     */
    protected function _isAllowed() {
        return Mage::getSingleton('admin/session')->isAllowed('theme/itactica_orbitslider/slides');
    }
}
