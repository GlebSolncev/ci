<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_TextBoxes
 * @copyright   Copyright (c) 2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_TextBoxes_Adminhtml_Textboxes_BoxController extends Itactica_TextBoxes_Controller_Adminhtml_TextBoxes
{
    /**
     * init the box
     * @access protected
     * @return Itactica_TextBoxes_Model_Box
     */
    protected function _initBox(){
        $boxId  = (int) $this->getRequest()->getParam('id');
        $box    = Mage::getModel('itactica_textboxes/box');
        if ($boxId) {
            $box->load($boxId);
        }
        Mage::register('current_box', $box);
        return $box;
    }
     /**
     * default action
     * @access public
     * @return void
     */
    public function indexAction() {
        $this->loadLayout();
        $this->_title(Mage::helper('itactica_textboxes')->__('Text Boxes'))
             ->_title(Mage::helper('itactica_textboxes')->__('Boxes'));
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
     * edit box - action
     * @access public
     * @return void
     */
    public function editAction() {
        $boxId    = $this->getRequest()->getParam('id');
        $box      = $this->_initBox();
        if ($boxId && !$box->getId()) {
            $this->_getSession()->addError(Mage::helper('itactica_textboxes')->__('This text box no longer exists.'));
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getBoxData(true);
        if (!empty($data)) {
            $box->setData($data);
        }
        Mage::register('box_data', $box);
        $this->loadLayout();
        $this->_title(Mage::helper('itactica_textboxes')->__('Text Boxes'))
             ->_title(Mage::helper('itactica_textboxes')->__('Boxes'));
        if ($box->getId()){
            $this->_title($box->getTitle());
        }
        else{
            $this->_title(Mage::helper('itactica_textboxes')->__('Add Text Box'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }
    /**
     * new box action
     * @access public
     * @return void
     */
    public function newAction() {
        $this->_forward('edit');
    }
    /**
     * save box - action
     * @access public
     * @return void
     */
    public function saveAction() {
        if ($data = $this->getRequest()->getPost('box')) {
            try {
                $box = $this->_initBox();
                $box->addData($data);
                $filenameFirst = $this->_uploadAndGetName('image_filename_first', Mage::helper('itactica_textboxes/image')->getImageBaseDir(), $data);
                $filenameSecond = $this->_uploadAndGetName('image_filename_second', Mage::helper('itactica_textboxes/image')->getImageBaseDir(), $data);
                $filenameThird = $this->_uploadAndGetName('image_filename_third', Mage::helper('itactica_textboxes/image')->getImageBaseDir(), $data);
                $box->setData('image_filename_first', $filenameFirst);
                $box->setData('image_filename_second', $filenameSecond);
                $box->setData('image_filename_third', $filenameThird);
                $box->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('itactica_textboxes')->__('Text box successfully saved.'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $box->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setBoxData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
            catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_textboxes')->__('There was a problem saving the text box.'));
                Mage::getSingleton('adminhtml/session')->setBoxData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_textboxes')->__('Unable to find text box to save.'));
        $this->_redirect('*/*/');
    }
    /**
     * delete box - action
     * @access public
     * @return void
     */
    public function deleteAction() {
        if( $this->getRequest()->getParam('id') > 0) {
            try {
                $box = Mage::getModel('itactica_textboxes/box');
                $box->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('itactica_textboxes')->__('Text box was successfully deleted.'));
                $this->_redirect('*/*/');
                return;
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_textboxes')->__('There was an error deleting the text box.'));
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_textboxes')->__('Could not find text box to delete.'));
        $this->_redirect('*/*/');
    }
    /**
     * mass delete box - action
     * @access public
     * @return void
     */
    public function massDeleteAction() {
        $boxIds = $this->getRequest()->getParam('box');
        if(!is_array($boxIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_textboxes')->__('Please select text boxes to delete.'));
        }
        else {
            try {
                foreach ($boxIds as $boxId) {
                    $box = Mage::getModel('itactica_textboxes/box');
                    $box->setId($boxId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('itactica_textboxes')->__('Total of %d text boxes were successfully deleted.', count($boxIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_textboxes')->__('There was an error deleting text boxes.'));
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
        $boxIds = $this->getRequest()->getParam('box');
        if(!is_array($boxIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_textboxes')->__('Please select text boxes.'));
        }
        else {
            try {
                foreach ($boxIds as $boxId) {
                $box = Mage::getSingleton('itactica_textboxes/box')->load($boxId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(Mage::helper('itactica_textboxes')->__('Total of %d text boxes were successfully updated.', count($boxIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_textboxes')->__('There was an error updating text boxes.'));
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
        $boxIds = $this->getRequest()->getParam('box');
        if(!is_array($boxIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_textboxes')->__('Please select text boxes.'));
        }
        else {
            try {
                foreach ($boxIds as $boxId) {
                $box = Mage::getSingleton('itactica_textboxes/box')->load($boxId)
                            ->setProductsSource($this->getRequest()->getParam('flag_products_source'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d text boxes were successfully updated.', count($boxIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_textboxes')->__('There was an error updating text boxes.'));
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
        $fileName   = 'textboxes.csv';
        $content    = $this->getLayout()->createBlock('itactica_textboxes/adminhtml_box_grid')->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * export as MsExcel - action
     * @access public
     * @return void
     */
    public function exportExcelAction(){
        $fileName   = 'textboxes.xls';
        $content    = $this->getLayout()->createBlock('itactica_textboxes/adminhtml_box_grid')->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * export as xml - action
     * @access public
     * @return void
     */
    public function exportXmlAction(){
        $fileName   = 'textboxes.xml';
        $content    = $this->getLayout()->createBlock('itactica_textboxes/adminhtml_box_grid')->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * Check if admin has permissions to visit related pages
     * @access protected
     * @return boolean
     */
    protected function _isAllowed() {
        return Mage::getSingleton('admin/session')->isAllowed('theme/itactica_textboxes/box');
    }
}
