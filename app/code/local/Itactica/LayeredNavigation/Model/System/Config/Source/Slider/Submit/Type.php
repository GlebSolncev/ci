<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_LayeredNavigation
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_LayeredNavigation_Model_System_Config_Source_Slider_Submit_Type
{

    const SUBMIT_AUTO_DELAYED = 1;
    const SUBMIT_BUTTON = 2;

    /**
     * Retrieve types of submit for price slider filter
     * 
     * @return array
     */
    public function toOptionArray()
    {
        $helper = Mage::helper('itactica_layerednavigation');
        $options = array();
        $options[] = array(
            'label' => $helper->__('Delayed auto submit'),
            'value' => self::SUBMIT_AUTO_DELAYED
        );
        $options[] = array(
            'label' => $helper->__('Submit button'),
            'value' => self::SUBMIT_BUTTON
        );

        return $options;
    }

}