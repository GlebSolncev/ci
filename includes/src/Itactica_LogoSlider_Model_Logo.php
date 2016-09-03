<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_LogoSlider
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_LogoSlider_Model_Logo extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'itactica_logoslider_logo';
    const CACHE_TAG = 'itactica_logoslider_logo';
    /**
     * Prefix of model events names
     * @var string
     */
    protected $_eventPrefix = 'itactica_logoslider_logo';

    /**
     * Parameter name in event
     * @var string
     */
    protected $_eventObject = 'logo';
    /**
     * constructor
     * @access public
     * @return void
     */
    public function _construct(){
        parent::_construct();
        $this->_init('itactica_logoslider/logo');
    }
    /**
     * before save brand logos
     * @access protected
     * @return Itactica_LogoSlider_Model_Logo
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
     * save logo relation
     * @access public
     * @return Itactica_LogoSlider_Model_Logo
     */
    protected function _afterSave() {
        return parent::_afterSave();
    }
    /**
     * get default values
     * @access public
     * @return array
     */
    public function getDefaultValues() {
        $values = array();
        $values['status'] = 1;
        return $values;
    }

    /**
     * Retrieve logo collection
     * @access public
     * @param string $title
     * @return Itactica_LogoSlider_Resource_Logo
     */
    public function loadByTitle($title){
        $this->_getResource()->loadByTitle($title, $this);
        return $this;
    }
}
