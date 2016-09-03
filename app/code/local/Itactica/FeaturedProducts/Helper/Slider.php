<?php 
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_FeaturedProducts
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_FeaturedProducts_Helper_Slider extends Mage_Core_Helper_Abstract
{
    /**
     * check if breadcrumbs can be used
     * @access public
     * @return bool
     */
    public function getUseBreadcrumbs(){
        return Mage::getStoreConfigFlag('itactica_featuredproducts/slider/breadcrumbs');
    }
}
