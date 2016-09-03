<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_LogoSlider
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_LogoSlider_Model_Resource_Logo extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * constructor
     * @access public
     */
    public function _construct(){
        $this->_init('itactica_logoslider/logo', 'entity_id');
    }
    /**
     * Get store ids to which specified item is assigned
     * @access public
     * @param int $logoId
     * @return array
     */
    public function lookupStoreIds($logoId){
        $adapter = $this->_getReadAdapter();
        $select  = $adapter->select()
            ->from($this->getTable('itactica_logoslider/logo_store'), 'store_id')
            ->where('logo_id = ?',(int)$logoId);
        return $adapter->fetchCol($select);
    }
    /**
     * Perform operations after object load
     * @access public
     * @param Mage_Core_Model_Abstract $object
     * @return Itactica_LogoSlider_Model_Resource_Logo
     */
    protected function _afterLoad(Mage_Core_Model_Abstract $object){
        if ($object->getId()) {
            $stores = $this->lookupStoreIds($object->getId());
            $object->setData('store_id', $stores);
        }
        return parent::_afterLoad($object);
    }

    /**
     * Retrieve select object for load object data
     *
     * @param string $field
     * @param mixed $value
     * @param Itactica_LogoSlider_Model_Logo $object
     * @return Zend_Db_Select
     */
    protected function _getLoadSelect($field, $value, $object){
        $select = parent::_getLoadSelect($field, $value, $object);
        if ($object->getStoreId()) {
            $storeIds = array(Mage_Core_Model_App::ADMIN_STORE_ID, (int)$object->getStoreId());
            $select->join(
                array('logoslider_logo_store' => $this->getTable('itactica_logoslider/logo_store')),
                $this->getMainTable() . '.entity_id = logoslider_logo_store.logo_id',
                array()
            )
            ->where('logoslider_logo_store.store_id IN (?)', $storeIds)
            ->order('logoslider_logo_store.store_id DESC')
            ->limit(1);
        }
        return $select;
    }
    /**
     * Assign brand logos to store views
     * @access protected
     * @param Mage_Core_Model_Abstract $object
     * @return Itactica_LogoSlider_Model_Resource_Logo
     */
    protected function _afterSave(Mage_Core_Model_Abstract $object){
        $oldStores = $this->lookupStoreIds($object->getId());
        $newStores = (array)$object->getStores();
        if (empty($newStores)) {
            $newStores = (array)$object->getStoreId();
        }
        $table  = $this->getTable('itactica_logoslider/logo_store');
        $insert = array_diff($newStores, $oldStores);
        $delete = array_diff($oldStores, $newStores);
        if ($delete) {
            $where = array(
                'logo_id = ?' => (int) $object->getId(),
                'store_id IN (?)' => $delete
            );
            $this->_getWriteAdapter()->delete($table, $where);
        }
        if ($insert) {
            $data = array();
            foreach ($insert as $storeId) {
                $data[] = array(
                    'logo_id'  => (int) $object->getId(),
                    'store_id' => (int) $storeId
                );
            }
            $this->_getWriteAdapter()->insertMultiple($table, $data);
        }

        // mark block_html cache as invalidated
        Mage::app()->getCacheInstance()->invalidateType('block_html');
        
        return parent::_afterSave($object);
    }

    /**
     * get logo by title
     * @access public
     * @param string $title
     * @return array
     */
    public function loadByTitle($title, Itactica_LogoSlider_Model_Logo $logo){
        $adapter = $this->_getReadAdapter();
        $select  = $adapter->select()
            ->from($this->getTable('itactica_logoslider/logo'))
            ->where('title = ?',(string)$title);

        $logoId = $adapter->fetchOne($select);
        if ($logoId) {
            $this->load($logo, $logoId);
        }
        return $this;
    }
}
