<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_CallToAction
 * @copyright   Copyright (c) 2014-2015 Itactica (https://www.getintenso.com)
 * @license     https://getintenso.com/license
 */

class Itactica_CallToAction_Model_Resource_Cta extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * constructor
     * @access public
     */
    public function _construct(){
        $this->_init('itactica_calltoaction/calltoaction', 'entity_id');
    }

    /**
     * get store ids to which specified item is assigned
     * @access public
     * @param int $ctaId
     * @return array
     */
    public function lookupStoreIds($ctaId){
        $adapter = $this->_getReadAdapter();
        $select  = $adapter->select()
            ->from($this->getTable('itactica_calltoaction/calltoaction_store'), 'store_id')
            ->where('calltoaction_id = ?',(int)$ctaId);
        return $adapter->fetchCol($select);
    }

    /**
     * get calltoaction by identifier
     * @access public
     * @param string $identifier
     * @return array
     */
    public function loadByIdentifier($identifier, Itactica_CallToAction_Model_Cta $cta){
        $adapter = $this->_getReadAdapter();
        $select  = $adapter->select()
            ->from($this->getTable('itactica_calltoaction/calltoaction'))
            ->where('identifier = ?',(string)$identifier);

        $ctaId = $adapter->fetchOne($select);
        if ($ctaId) {
            $this->load($cta, $ctaId);
        }
        return $this;
    }

    /**
     * perform operations after object load
     * @access public
     * @param Mage_Core_Model_Abstract $object
     * @return Itactica_CallToAction_Model_Resource_Cta
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
     * @param Itactica_CallToAction_Model_Cta $object
     * @return Zend_Db_Select
     */
    protected function _getLoadSelect($field, $value, $object){
        $select = parent::_getLoadSelect($field, $value, $object);
        if ($object->getStoreId()) {
            $storeIds = array(Mage_Core_Model_App::ADMIN_STORE_ID, (int)$object->getStoreId());
            $select->join(
                array('calltoaction_cta_store' => $this->getTable('itactica_calltoaction/calltoaction_store')),
                $this->getMainTable() . '.entity_id = calltoaction_cta_store.calltoaction_id',
                array()
            )
            ->where('calltoaction_cta_store.store_id IN (?)', $storeIds)
            ->order('calltoaction_cta_store.store_id DESC')
            ->limit(1);
        }
        return $select;
    }
    /**
     * assign calltoaction to store views
     * @access protected
     * @param Mage_Core_Model_Abstract $object
     * @return Itactica_CallToAction_Model_Resource_Cta
     */
    protected function _afterSave(Mage_Core_Model_Abstract $object){
        $oldStores = $this->lookupStoreIds($object->getId());
        $newStores = (array)$object->getStores();
        if (empty($newStores)) {
            $newStores = (array)$object->getStoreId();
        }
        $table  = $this->getTable('itactica_calltoaction/calltoaction_store');
        $insert = array_diff($newStores, $oldStores);
        $delete = array_diff($oldStores, $newStores);
        if ($delete) {
            $where = array(
                'calltoaction_id = ?' => (int) $object->getId(),
                'store_id IN (?)' => $delete
            );
            $this->_getWriteAdapter()->delete($table, $where);
        }
        if ($insert) {
            $data = array();
            foreach ($insert as $storeId) {
                $data[] = array(
                    'calltoaction_id'  => (int) $object->getId(),
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
