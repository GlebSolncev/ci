<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_LogoSlider
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_LogoSlider_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * convert array to options
     * @access public
     * @param $options
     * @return array
     */
    public function convertOptions($options){
        $converted = array();
        foreach ($options as $option){
            if (isset($option['value']) && !is_array($option['value']) && isset($option['label']) && !is_array($option['label'])){
                $converted[$option['value']] = $option['label'];
            }
        }
        return $converted;
    }

    /**
     * get logos collection
     * @access public
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function getLogos($sliderId)
    {
        $collection = Mage::getModel('itactica_logoslider/logo')
            ->getCollection()
            ->addFieldToFilter('status', 1);
        $select = $collection->getSelect()->join(
                array('logoslider_slider_logos' => $collection->getTable('itactica_logoslider/slider_logos')),
                'main_table.entity_id = logoslider_slider_logos.logo_id',
                array('logo_id')
            )
            ->where('logoslider_slider_logos.slider_id = (?)', $sliderId)
            ->order('logoslider_slider_logos.position ASC');

        return $collection;
    }
}
