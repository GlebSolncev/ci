<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_LogoSlider
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_LogoSlider_Model_Resource_Slider_Logos extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * initialize resource model
     * @access protected
     * @see Mage_Core_Model_Resource_Abstract::_construct()
     */
    protected function  _construct(){
        $this->_init('itactica_logoslider/slider_logos', 'rel_id');
    }

    /**
     * Save  product - slider relations
     * @access public
     * @param Itactica_LogoSlider_Model_Slider $slider
     * @param array $data
     * @return Itactica_LogoSlider_Model_Resource_Slider_Logos
     */
    public function saveLogosRelation($slider, $data){
        if (!is_array($data)) {
            $data = array();
        }
        $deleteCondition = $this->_getWriteAdapter()->quoteInto('slider_id=?', $slider->getId());
        $this->_getWriteAdapter()->delete($this->getMainTable(), $deleteCondition);

        foreach ($data as $logoId => $info) {
            $this->_getWriteAdapter()->insert($this->getMainTable(), array(
                'slider_id' => $slider->getId(),
                'logo_id' => $logoId,
                'position'   => @$info['position']
            ));
        }
        return $this;
    }
}
