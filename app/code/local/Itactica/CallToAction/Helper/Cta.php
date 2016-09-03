<?php 
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_CallToAction
 * @copyright   Copyright (c) 2014-2015 Itactica (https://www.getintenso.com)
 * @license     https://getintenso.com/license
 */

class Itactica_CallToAction_Helper_Cta extends Mage_Core_Helper_Abstract
{
    /**
     * check if breadcrumbs can be used
     * @access public
     * @return bool
     */
    public function getUseBreadcrumbs(){
        return Mage::getStoreConfigFlag('itactica_calltoaction/cta/breadcrumbs');
    }
}
