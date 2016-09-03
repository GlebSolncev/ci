<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_Billboard
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_Billboard_Helper_Data extends Mage_Core_Helper_Abstract
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
     * ads # symbol to hexadecimal color code in case is not present
     * @access public
     * @param string
     * @return string
     */
    public function hex($color) {
        if (substr($color, 0, 1) != '#') {
            $color = '#' . $color;
        }
        return $color;
    }

}
