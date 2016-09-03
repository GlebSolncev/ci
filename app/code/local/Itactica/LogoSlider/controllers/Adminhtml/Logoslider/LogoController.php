<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_LogoSlider
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_LogoSlider_Adminhtml_Logoslider_LogoController extends Itactica_LogoSlider_Controller_Adminhtml_LogoSlider
{
    /**
     * init the logo
     * @access protected
     * @return Itactica_LogoSlider_Model_Logo
     */
    protected function _initLogo(){
        $logoId  = (int) $this->getRequest()->getParam('id');
        $logo    = Mage::getModel('itactica_logoslider/logo');
        if ($logoId) {
            $logo->load($logoId);
        }
        Mage::register('current_logo', $logo);
        return $logo;
    }
     /**
     * default action
     * @access public
     * @return void
     */
    public function indexAction() {
        $this->loadLayout();
        $this->_title(Mage::helper('itactica_logoslider')->__('Logo Slider'))
             ->_title(Mage::helper('itactica_logoslider')->__('Images'));
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
     * edit brand logos - action
     * @access public
     * @return void
     */
    public function editAction() {
        $logoId    = $this->getRequest()->getParam('id');
        $logo      = $this->_initLogo();
        if ($logoId && !$logo->getId()) {
            $this->_getSession()->addError(Mage::helper('itactica_logoslider')->__('This image no longer exists.'));
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getLogoData(true);
        if (!empty($data)) {
            $logo->setData($data);
        }
        Mage::register('logo_data', $logo);
        $this->loadLayout();
        $this->_title(Mage::helper('itactica_logoslider')->__('Logo Slider'))
             ->_title(Mage::helper('itactica_logoslider')->__('Images'));
        if ($logo->getId()){
            $this->_title($logo->getTitle());
        }
        else{
            $this->_title(Mage::helper('itactica_logoslider')->__('Add Image'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }
    /**
     * new brand logos action
     * @access public
     * @return void
     */
    public function newAction() {
        $this->_forward('edit');
    }
    /**
     * save brand logos - action
     * @access public
     * @return void
     */
    public function saveAction() {
        if ($data = $this->getRequest()->getPost('logo')) {
            try {
                $logo = $this->_initLogo();
                $logo->addData($data);
                $filenameName = $this->_uploadAndGetName('filename', Mage::helper('itactica_logoslider/logo_image')->getImageBaseDir(), $data);
                $logo->setData('filename', $filenameName);
                $logo->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('itactica_logoslider')->__('The image was successfully saved.'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $logo->getId()));
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
                Mage::getSingleton('adminhtml/session')->setLogoData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
            catch (Exception $e) {
                Mage::logException($e);
                if (isset($data['filename']['value'])){
                    $data['filename'] = $data['filename']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_logoslider')->__('There was a problem saving the image.'));
                Mage::getSingleton('adminhtml/session')->setLogoData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_logoslider')->__('Unable to find the image to save.'));
        $this->_redirect('*/*/');
    }
    /**
     * delete brand logos - action
     * @access public
     * @return void
     */
    public function deleteAction() {
        if( $this->getRequest()->getParam('id') > 0) {
            try {
                $logo = Mage::getModel('itactica_logoslider/logo');
                $logo->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('itactica_logoslider')->__('The image was successfully deleted.'));
                $this->_redirect('*/*/');
                return;
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_logoslider')->__('There was an error deleting the image.'));
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_logoslider')->__('Could not find an image to delete.'));
        $this->_redirect('*/*/');
    }
    /**
     * mass delete brand logos - action
     * @access public
     * @return void
     */
    public function massDeleteAction() {
        $logoIds = $this->getRequest()->getParam('logo');
        if(!is_array($logoIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_logoslider')->__('Please select an image to delete.'));
        }
        else {
            try {
                foreach ($logoIds as $logoId) {
                    $logo = Mage::getModel('itactica_logoslider/logo');
                    $logo->setId($logoId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('itactica_logoslider')->__('Total of %d images were successfully deleted.', count($logoIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_logoslider')->__('There was an error deleting the image.'));
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
        $logoIds = $this->getRequest()->getParam('logo');
        if(!is_array($logoIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_logoslider')->__('Please select an image.'));
        }
        else {
            try {
                foreach ($logoIds as $logoId) {
                $logo = Mage::getSingleton('itactica_logoslider/logo')->load($logoId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d images were successfully updated.', count($logoIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_logoslider')->__('There was an error updating the image.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * mass Action When Logo is Clicked change - action
     * @access public
     * @return void
     */
    public function massSearchByKeyAction(){
        $logoIds = $this->getRequest()->getParam('logo');
        if(!is_array($logoIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_logoslider')->__('Please select an image.'));
        }
        else {
            try {
                foreach ($logoIds as $logoId) {
                $logo = Mage::getSingleton('itactica_logoslider/logo')->load($logoId)
                            ->setSearchByKey($this->getRequest()->getParam('flag_search_by_key'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d images were successfully updated.', count($logoIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_logoslider')->__('There was an error updating the image.'));
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
        $fileName   = 'logo.csv';
        $content    = $this->getLayout()->createBlock('itactica_logoslider/adminhtml_logo_grid')->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * export as MsExcel - action
     * @access public
     * @return void
     */
    public function exportExcelAction(){
        $fileName   = 'logo.xls';
        $content    = $this->getLayout()->createBlock('itactica_logoslider/adminhtml_logo_grid')->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * export as xml - action
     * @access public
     * @return void
     */
    public function exportXmlAction(){
        $fileName   = 'logo.xml';
        $content    = $this->getLayout()->createBlock('itactica_logoslider/adminhtml_logo_grid')->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * Check if admin has permissions to visit related pages
     * @access protected
     * @return boolean
     */
    protected function _isAllowed() {
        return Mage::getSingleton('admin/session')->isAllowed('theme/itactica_logoslider/logo');
    }
}
