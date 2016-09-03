<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_Billboard
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_Billboard_Model_Unit extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'itactica_billboard_unit';
    const CACHE_TAG = 'itactica_billboard_unit';

    /**
     * Prefix of model events names
     * @var string
     */
    protected $_eventPrefix = 'itactica_billboard_unit';

    /**
     * Parameter name in event
     * @var string
     */
    protected $_eventObject = 'unit';
    protected $_productInstance = null;

    /**
     * constructor
     * @access public
     * @return void
     */
    public function _construct(){
        parent::_construct();
        $this->_init('itactica_billboard/unit');
    }

    /**
     * before save billboard
     * @access protected
     * @return Itactica_Billboard_Model_Unit
     */
    protected function _beforeSave(){
        parent::_beforeSave();
        $now = Mage::getSingleton('core/date')->gmtDate();
        if ($this->isObjectNew()){
            $this->setCreatedAt($now);
        }
        $this->setUpdatedAt($now);
        return $this;
    }

    /**
     * Retrieve collection billboard
     * @access public
     * @param string $identifier
     * @return Itactica_Billboard_Resource_Unit
     */
    public function loadByIdentifier($identifier){
        $this->_getResource()->loadByIdentifier($identifier, $this);
        return $this;
    }

    /**
     * get default values
     * @access public
     * @return array
     */
    public function getDefaultValues() {
        $values = array();

        $values['columns'] = 3;
        $values['billboard_type'] = 1;
        $values['background_color'] = '#ffffff';
        $values['status'] = 1;

        return $values;
    }
}
