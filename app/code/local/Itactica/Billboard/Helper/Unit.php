<?php 
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_Billboard
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_Billboard_Helper_Unit extends Mage_Core_Helper_Abstract
{
    /**
     * check if breadcrumbs can be used
     * @access public
     * @return bool
     */
    public function getUseBreadcrumbs(){
        return Mage::getStoreConfigFlag('itactica_billboard/unit/breadcrumbs');
    }
}
