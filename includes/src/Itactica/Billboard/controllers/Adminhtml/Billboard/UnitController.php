<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_Billboard
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_Billboard_Adminhtml_Billboard_UnitController extends Itactica_Billboard_Controller_Adminhtml_Billboard
{
    /**
     * init the unit
     * @access protected
     * @return Itactica_Billboard_Model_Unit
     */
    protected function _initUnit(){
        $unitId  = (int) $this->getRequest()->getParam('id');
        $unit    = Mage::getModel('itactica_billboard/unit');
        if ($unitId) {
            $unit->load($unitId);
        }
        Mage::register('current_billboard', $unit);
        return $unit;
    }
     /**
     * default action
     * @access public
     * @return void
     */
    public function indexAction() {
        $this->loadLayout();
        $this->_title(Mage::helper('itactica_billboard')->__('Billboard'))
             ->_title(Mage::helper('itactica_billboard')->__('Units'));
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
     * edit unit - action
     * @access public
     * @return void
     */
    public function editAction() {
        $unitId    = $this->getRequest()->getParam('id');
        $unit      = $this->_initUnit();
        if ($unitId && !$unit->getId()) {
            $this->_getSession()->addError(Mage::helper('itactica_billboard')->__('This billboard no longer exists.'));
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getUnitData(true);
        if (!empty($data)) {
            $unit->setData($data);
        }
        Mage::register('billboard_data', $unit);
        $this->loadLayout();
        $this->_title(Mage::helper('itactica_billboard')->__('Billboard'))
             ->_title(Mage::helper('itactica_billboard')->__('Units'));
        if ($unit->getId()){
            $this->_title($unit->getTitle());
        }
        else{
            $this->_title(Mage::helper('itactica_billboard')->__('Add Billboard'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }
    /**
     * new billboard action
     * @access public
     * @return void
     */
    public function newAction() {
        $this->_forward('edit');
    }
    /**
     * save billboard - action
     * @access public
     * @return void
     */
    public function saveAction() {
        if ($data = $this->getRequest()->getPost('unit')) {
            try {
                // array to string conversion for images_to_show
                if (isset($data['images_to_show'])) {
                    if (is_array($data['images_to_show'])) {
                        $data['images_to_show'] = implode(",", $data['images_to_show']);
                    } else {
                        $data['images_to_show'] = '';
                    }
                }
                $unit = $this->_initUnit();
                $unit->addData($data);
                $filenameLargeFirst = $this->_uploadAndGetName('image_large_first', Mage::helper('itactica_billboard/image')->getImageBaseDir(), $data);
                $filenameLargeSecond = $this->_uploadAndGetName('image_large_second', Mage::helper('itactica_billboard/image')->getImageBaseDir(), $data);
                $filenameLargeThird = $this->_uploadAndGetName('image_large_third', Mage::helper('itactica_billboard/image')->getImageBaseDir(), $data);
                $filenameLargeFourth = $this->_uploadAndGetName('image_large_fourth', Mage::helper('itactica_billboard/image')->getImageBaseDir(), $data);
                $filenameMediumFirst = $this->_uploadAndGetName('image_medium_first', Mage::helper('itactica_billboard/image')->getImageBaseDir(), $data);
                $filenameMediumSecond = $this->_uploadAndGetName('image_medium_second', Mage::helper('itactica_billboard/image')->getImageBaseDir(), $data);
                $filenameMediumThird = $this->_uploadAndGetName('image_medium_third', Mage::helper('itactica_billboard/image')->getImageBaseDir(), $data);
                $filenameMediumFourth = $this->_uploadAndGetName('image_medium_fourth', Mage::helper('itactica_billboard/image')->getImageBaseDir(), $data);
                $unit->setData('image_large_first', $filenameLargeFirst);
                $unit->setData('image_large_second', $filenameLargeSecond);
                $unit->setData('image_large_third', $filenameLargeThird);
                $unit->setData('image_large_fourth', $filenameLargeFourth);
                $unit->setData('image_medium_first', $filenameMediumFirst);
                $unit->setData('image_medium_second', $filenameMediumSecond);
                $unit->setData('image_medium_third', $filenameMediumThird);
                $unit->setData('image_medium_fourth', $filenameMediumFourth);
                $unit->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('itactica_billboard')->__('Billboard successfully saved.'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $unit->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setBillboardData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
            catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_billboard')->__('There was a problem saving the billboard.'));
                Mage::getSingleton('adminhtml/session')->setBillboardData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_billboard')->__('Unable to find the billboard to save.'));
        $this->_redirect('*/*/');
    }
    /**
     * delete billboard - action
     * @access public
     * @return void
     */
    public function deleteAction() {
        if( $this->getRequest()->getParam('id') > 0) {
            try {
                $unit = Mage::getModel('itactica_billboard/unit');
                $unit->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('itactica_billboard')->__('Billboard was successfully deleted.'));
                $this->_redirect('*/*/');
                return;
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_billboard')->__('There was an error deleting the billboard.'));
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_billboard')->__('Could not find the billboard to delete.'));
        $this->_redirect('*/*/');
    }
    /**
     * mass delete billboard - action
     * @access public
     * @return void
     */
    public function massDeleteAction() {
        $unitIds = $this->getRequest()->getParam('unit');
        if(!is_array($unitIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_billboard')->__('Please select billboards to delete.'));
        }
        else {
            try {
                foreach ($unitIds as $unitId) {
                    $unit = Mage::getModel('itactica_billboard/unit');
                    $unit->setId($unitId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('itactica_billboard')->__('Total of %d billboard units were successfully deleted.', count($unitIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_billboard')->__('There was an error deleting the billboard units.'));
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
        $unitIds = $this->getRequest()->getParam('unit');
        if(!is_array($unitIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_billboard')->__('Please select billboard units.'));
        }
        else {
            try {
                foreach ($unitIds as $unitId) {
                $unit = Mage::getSingleton('itactica_billboard/unit')->load($unitId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(Mage::helper('itactica_billboard')->__('Total of %d billboard units were successfully updated.', count($unitIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_billboard')->__('There was an error updating the billboard units.'));
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
        $unitIds = $this->getRequest()->getParam('unit');
        if(!is_array($unitIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_billboard')->__('Please select billboard units.'));
        }
        else {
            try {
                foreach ($unitIds as $unitId) {
                $unit = Mage::getSingleton('itactica_billboard/billboard')->load($unitId)
                            ->setProductsSource($this->getRequest()->getParam('flag_products_source'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d billboard units were successfully updated.', count($unitIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_billboard')->__('There was an error updating the billboar units.'));
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
        $fileName   = 'billboard.csv';
        $content    = $this->getLayout()->createBlock('itactica_billboard/adminhtml_unit_grid')->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * export as MsExcel - action
     * @access public
     * @return void
     */
    public function exportExcelAction(){
        $fileName   = 'billboard.xls';
        $content    = $this->getLayout()->createBlock('itactica_billboard/adminhtml_unit_grid')->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * export as xml - action
     * @access public
     * @return void
     */
    public function exportXmlAction(){
        $fileName   = 'billboard.xml';
        $content    = $this->getLayout()->createBlock('itactica_billboard/adminhtml_unit_grid')->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * Check if admin has permissions to visit related pages
     * @access protected
     * @return boolean
     */
    protected function _isAllowed() {
        return Mage::getSingleton('admin/session')->isAllowed('theme/itactica_billboard/billboard');
    }
}
