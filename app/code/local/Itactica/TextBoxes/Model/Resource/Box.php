<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_TextBoxes
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_TextBoxes_Model_Resource_Box extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * constructor
     * @access public
     */
    public function _construct(){
        $this->_init('itactica_textboxes/box', 'entity_id');
    }

    /**
     * get store ids to which specified item is assigned
     * @access public
     * @param int $boxId
     * @return array
     */
    public function lookupStoreIds($boxId){
        $adapter = $this->_getReadAdapter();
        $select  = $adapter->select()
            ->from($this->getTable('itactica_textboxes/box_store'), 'store_id')
            ->where('box_id = ?',(int)$boxId);
        return $adapter->fetchCol($select);
    }

    /**
     * get box by identifier
     * @access public
     * @param string $identifier
     * @return array
     */
    public function loadByIdentifier($identifier, Itactica_TextBoxes_Model_Box $box){
        $adapter = $this->_getReadAdapter();
        $select  = $adapter->select()
            ->from($this->getTable('itactica_textboxes/box'))
            ->where('identifier = ?',(string)$identifier);

        $boxId = $adapter->fetchOne($select);
        if ($boxId) {
            $this->load($box, $boxId);
        }
        return $this;
    }

    /**
     * perform operations after object load
     * @access public
     * @param Mage_Core_Model_Abstract $object
     * @return Itactica_TextBoxes_Model_Resource_Box
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
     * @param Itactica_TextBoxes_Model_Box $object
     * @return Zend_Db_Select
     */
    protected function _getLoadSelect($field, $value, $object){
        $select = parent::_getLoadSelect($field, $value, $object);
        if ($object->getStoreId()) {
            $storeIds = array(Mage_Core_Model_App::ADMIN_STORE_ID, (int)$object->getStoreId());
            $select->join(
                array('textboxes_box_store' => $this->getTable('itactica_textboxes/box_store')),
                $this->getMainTable() . '.entity_id = textboxes_box_store.box_id',
                array()
            )
            ->where('textboxes_box_store.store_id IN (?)', $storeIds)
            ->order('textboxes_box_store.store_id DESC')
            ->limit(1);
        }
        return $select;
    }
    /**
     * assign box to store views
     * @access protected
     * @param Mage_Core_Model_Abstract $object
     * @return Itactica_TextBoxes_Model_Resource_Box
     */
    protected function _afterSave(Mage_Core_Model_Abstract $object){
        $oldStores = $this->lookupStoreIds($object->getId());
        $newStores = (array)$object->getStores();
        if (empty($newStores)) {
            $newStores = (array)$object->getStoreId();
        }
        $table  = $this->getTable('itactica_textboxes/box_store');
        $insert = array_diff($newStores, $oldStores);
        $delete = array_diff($oldStores, $newStores);
        if ($delete) {
            $where = array(
                'box_id = ?' => (int) $object->getId(),
                'store_id IN (?)' => $delete
            );
            $this->_getWriteAdapter()->delete($table, $where);
        }
        if ($insert) {
            $data = array();
            foreach ($insert as $storeId) {
                $data[] = array(
                    'box_id'  => (int) $object->getId(),
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
