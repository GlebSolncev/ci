<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_CallToAction
 * @copyright   Copyright (c) 2014-2015 Itactica (https://www.getintenso.com)
 * @license     https://getintenso.com/license
 */

class Itactica_CallToAction_Adminhtml_CallToAction_CtaController extends Itactica_CallToAction_Controller_Adminhtml_Calltoaction
{
    /**
     * init the cta
     * @access protected
     * @return Itactica_CallToAction_Model_Cta
     */
    protected function _initCta(){
        $ctaId  = (int) $this->getRequest()->getParam('id');
        $cta    = Mage::getModel('itactica_calltoaction/cta');
        if ($ctaId) {
            $cta->load($ctaId);
        }
        Mage::register('current_calltoaction', $cta);
        return $cta;
    }
     /**
     * default action
     * @access public
     * @return void
     */
    public function indexAction() {
        $this->loadLayout();
        $this->_title(Mage::helper('itactica_calltoaction')->__('CallToAction'))
             ->_title(Mage::helper('itactica_calltoaction')->__('CTA'));
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
     * edit cta - action
     * @access public
     * @return void
     */
    public function editAction() {
        $ctaId    = $this->getRequest()->getParam('id');
        $cta      = $this->_initCta();
        if ($ctaId && !$cta->getId()) {
            $this->_getSession()->addError(Mage::helper('itactica_calltoaction')->__('This calltoaction no longer exists.'));
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getCtaData(true);
        if (!empty($data)) {
            $cta->setData($data);
        }
        Mage::register('calltoaction_data', $cta);
        $this->loadLayout();
        $this->_title(Mage::helper('itactica_calltoaction')->__('CallToAction'))
             ->_title(Mage::helper('itactica_calltoaction')->__('CTA'));
        if ($cta->getId()){
            $this->_title($cta->getTitle());
        }
        else{
            $this->_title(Mage::helper('itactica_calltoaction')->__('Add CallToAction'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }
    /**
     * new calltoaction action
     * @access public
     * @return void
     */
    public function newAction() {
        $this->_forward('edit');
    }
    /**
     * save calltoaction - action
     * @access public
     * @return void
     */
    public function saveAction() {
        if ($data = $this->getRequest()->getPost('cta')) {
            try {
                $cta = $this->_initCta();
                $cta->addData($data);
                $filename = $this->_uploadAndGetName('background_image', Mage::helper('itactica_calltoaction/image')->getImageBaseDir(), $data);
                $cta->setData('background_image', $filename);
                $cta->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('itactica_calltoaction')->__('CallToAction successfully saved.'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $cta->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setCallToActionData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
            catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_calltoaction')->__('There was a problem saving the calltoaction.'));
                Mage::getSingleton('adminhtml/session')->setCallToActionData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_calltoaction')->__('Unable to find the calltoaction to save.'));
        $this->_redirect('*/*/');
    }
    /**
     * delete calltoaction - action
     * @access public
     * @return void
     */
    public function deleteAction() {
        if( $this->getRequest()->getParam('id') > 0) {
            try {
                $cta = Mage::getModel('itactica_calltoaction/cta');
                $cta->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('itactica_calltoaction')->__('CallToAction was successfully deleted.'));
                $this->_redirect('*/*/');
                return;
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_calltoaction')->__('There was an error deleting the calltoaction.'));
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_calltoaction')->__('Could not find the calltoaction to delete.'));
        $this->_redirect('*/*/');
    }
    /**
     * mass delete calltoaction - action
     * @access public
     * @return void
     */
    public function massDeleteAction() {
        $ctaIds = $this->getRequest()->getParam('cta');
        if(!is_array($ctaIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_calltoaction')->__('Please select calltoactions to delete.'));
        }
        else {
            try {
                foreach ($ctaIds as $ctaId) {
                    $cta = Mage::getModel('itactica_calltoaction/cta');
                    $cta->setId($ctaId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('itactica_calltoaction')->__('Total of %d calltoaction ctas were successfully deleted.', count($ctaIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_calltoaction')->__('There was an error deleting the calltoaction ctas.'));
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
        $ctaIds = $this->getRequest()->getParam('cta');
        if(!is_array($ctaIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_calltoaction')->__('Please select calltoaction ctas.'));
        }
        else {
            try {
                foreach ($ctaIds as $ctaId) {
                $cta = Mage::getSingleton('itactica_calltoaction/cta')->load($ctaId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(Mage::helper('itactica_calltoaction')->__('Total of %d calltoaction ctas were successfully updated.', count($ctaIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_calltoaction')->__('There was an error updating the calltoaction ctas.'));
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
        $ctaIds = $this->getRequest()->getParam('cta');
        if(!is_array($ctaIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_calltoaction')->__('Please select calltoaction.'));
        }
        else {
            try {
                foreach ($ctaIds as $ctaId) {
                $cta = Mage::getSingleton('itactica_calltoaction/calltoaction')->load($ctaId)
                            ->setProductsSource($this->getRequest()->getParam('flag_products_source'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d calltoaction ctas were successfully updated.', count($ctaIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_calltoaction')->__('There was an error updating the calltoaction.'));
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
        $fileName   = 'calltoaction.csv';
        $content    = $this->getLayout()->createBlock('itactica_calltoaction/adminhtml_cta_grid')->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * export as MsExcel - action
     * @access public
     * @return void
     */
    public function exportExcelAction(){
        $fileName   = 'calltoaction.xls';
        $content    = $this->getLayout()->createBlock('itactica_calltoaction/adminhtml_cta_grid')->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * export as xml - action
     * @access public
     * @return void
     */
    public function exportXmlAction(){
        $fileName   = 'calltoaction.xml';
        $content    = $this->getLayout()->createBlock('itactica_calltoaction/adminhtml_cta_grid')->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * Check if admin has permissions to visit related pages
     * @access protected
     * @return boolean
     */
    protected function _isAllowed() {
        return Mage::getSingleton('admin/session')->isAllowed('theme/itactica_calltoaction/calltoaction');
    }
}
