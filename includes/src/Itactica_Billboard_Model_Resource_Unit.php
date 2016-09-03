<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_Billboard
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_Billboard_Model_Resource_Unit extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * constructor
     * @access public
     */
    public function _construct(){
        $this->_init('itactica_billboard/billboard', 'entity_id');
    }

    /**
     * get store ids to which specified item is assigned
     * @access public
     * @param int $unitId
     * @return array
     */
    public function lookupStoreIds($unitId){
        $adapter = $this->_getReadAdapter();
        $select  = $adapter->select()
            ->from($this->getTable('itactica_billboard/billboard_store'), 'store_id')
            ->where('billboard_id = ?',(int)$unitId);
        return $adapter->fetchCol($select);
    }

    /**
     * get billboard by identifier
     * @access public
     * @param string $identifier
     * @return array
     */
    public function loadByIdentifier($identifier, Itactica_Billboard_Model_Unit $unit){
        $adapter = $this->_getReadAdapter();
        $select  = $adapter->select()
            ->from($this->getTable('itactica_billboard/billboard'))
            ->where('identifier = ?',(string)$identifier);

        $unitId = $adapter->fetchOne($select);
        if ($unitId) {
            $this->load($unit, $unitId);
        }
        return $this;
    }

    /**
     * perform operations after object load
     * @access public
     * @param Mage_Core_Model_Abstract $object
     * @return Itactica_Billboard_Model_Resource_Unit
     */
    protected function _afterLoad(Mage_Core_Model_Abstract $object){
        if ($object->getId()) {
            $stores = $this->lookupStoreIds($object->getId());
            $object->setData('store_id', $stores);
        }
        return parent::_afterLoad($object);
    }

    /**
     * retrieve select object for load object data
     * @param string $field
     * @param mixed $value
     * @param Itactica_Billboard_Model_Unit $object
     * @return Zend_Db_Select
     */
    protected function _getLoadSelect($field, $value, $object){
        $select = parent::_getLoadSelect($field, $value, $object);
        if ($object->getStoreId()) {
            $storeIds = array(Mage_Core_Model_App::ADMIN_STORE_ID, (int)$object->getStoreId());
            $select->join(
                array('billboard_unit_store' => $this->getTable('itactica_billboard/billboard_store')),
                $this->getMainTable() . '.entity_id = billboard_unit_store.billboard_id',
                array()
            )
            ->where('billboard_unit_store.store_id IN (?)', $storeIds)
            ->order('billboard_unit_store.store_id DESC')
            ->limit(1);
        }
        return $select;
    }
    /**
     * assign billboard to store views
     * @access protected
     * @param Mage_Core_Model_Abstract $object
     * @return Itactica_Billboard_Model_Resource_Unit
     */
    protected function _afterSave(Mage_Core_Model_Abstract $object){
        $oldStores = $this->lookupStoreIds($object->getId());
        $newStores = (array)$object->getStores();
        if (empty($newStores)) {
            $newStores = (array)$object->getStoreId();
        }
        $table  = $this->getTable('itactica_billboard/billboard_store');
        $insert = array_diff($newStores, $oldStores);
        $delete = array_diff($oldStores, $newStores);
        if ($delete) {
            $where = array(
                'billboard_id = ?' => (int) $object->getId(),
                'store_id IN (?)' => $delete
            );
            $this->_getWriteAdapter()->delete($table, $where);
        }
        if ($insert) {
            $data = array();
            foreach ($insert as $storeId) {
                $data[] = array(
                    'billboard_id'  => (int) $object->getId(),
                    'store_id' => (int) $storeId
                );
            }
            $this->_getWriteAdapter()->insertMultiple($table, $data);
        }

        // mark block_html cache as invalidated
        Mage::app()->getCacheInstance()->invalidateType('block_html');

        return parent::_afterSave($object);
    }
}
