<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_FeaturedCategories
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_FeaturedCategories_Model_Resource_Slider extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * constructor
     * @access public
     */
    public function _construct(){
        $this->_init('itactica_featuredcategories/slider', 'entity_id');
    }

    /**
     * get store ids to which specified item is assigned
     * @access public
     * @param int $sliderId
     * @return array
     */
    public function lookupStoreIds($sliderId){
        $adapter = $this->_getReadAdapter();
        $select  = $adapter->select()
            ->from($this->getTable('itactica_featuredcategories/slider_store'), 'store_id')
            ->where('slider_id = ?',(int)$sliderId);
        return $adapter->fetchCol($select);
    }

    /**
     * get slider by identifier
     * @access public
     * @param string $identifier
     * @return array
     */
    public function loadByIdentifier($identifier, Itactica_FeaturedCategories_Model_Slider $slider){
        $adapter = $this->_getReadAdapter();
        $select  = $adapter->select()
            ->from($this->getTable('itactica_featuredcategories/slider'))
            ->where('identifier = ?',(string)$identifier);

        $sliderId = $adapter->fetchOne($select);
        if ($sliderId) {
            $this->load($slider, $sliderId);
        }
        return $this;
    }

    /**
     * perform operations after object load
     * @access public
     * @param Mage_Core_Model_Abstract $object
     * @return Itactica_FeaturedCategories_Model_Resource_Slider
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
     * @param Itactica_FeaturedCategories_Model_Slider $object
     * @return Zend_Db_Select
     */
    protected function _getLoadSelect($field, $value, $object){
        $select = parent::_getLoadSelect($field, $value, $object);
        if ($object->getStoreId()) {
            $storeIds = array(Mage_Core_Model_App::ADMIN_STORE_ID, (int)$object->getStoreId());
            $select->join(
                array('featuredcategories_slider_store' => $this->getTable('itactica_featuredcategories/slider_store')),
                $this->getMainTable() . '.entity_id = featuredcategories_slider_store.slider_id',
                array()
            )
            ->where('featuredcategories_slider_store.store_id IN (?)', $storeIds)
            ->order('featuredcategories_slider_store.store_id DESC')
            ->limit(1);
        }
        return $select;
    }
    /**
     * assign slider to store views
     * @access protected
     * @param Mage_Core_Model_Abstract $object
     * @return Itactica_FeaturedCategories_Model_Resource_Slider
     */
    protected function _afterSave(Mage_Core_Model_Abstract $object){
        $oldStores = $this->lookupStoreIds($object->getId());
        $newStores = (array)$object->getStores();
        if (empty($newStores)) {
            $newStores = (array)$object->getStoreId();
        }
        $table  = $this->getTable('itactica_featuredcategories/slider_store');
        $insert = array_diff($newStores, $oldStores);
        $delete = array_diff($oldStores, $newStores);
        if ($delete) {
            $where = array(
                'slider_id = ?' => (int) $object->getId(),
                'store_id IN (?)' => $delete
            );
            $this->_getWriteAdapter()->delete($table, $where);
        }
        if ($insert) {
            $data = array();
            foreach ($insert as $storeId) {
                $data[] = array(
                    'slider_id'  => (int) $object->getId(),
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
