<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_LayeredNavigation
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_LayeredNavigation_Model_System_Config_Backend_Seo_Catalog extends Mage_Core_Model_Config_Data
{

    /**
     * After enabling layered navigation seo cache refresh is required
     *
     * @return Itactica_LayeredNavigation_Model_System_Config_Backend_Seo_Catalog
     */
    protected function _afterSave()
    {
        if ($this->isValueChanged()) {
            $instance = Mage::app()->getCacheInstance();
            $instance->invalidateType('block_html');
        }

        return $this;
    }

}
