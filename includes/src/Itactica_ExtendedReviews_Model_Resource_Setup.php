<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_ExtendedReviews
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_ExtendedReviews_Model_Resource_Setup extends Mage_Core_Model_Resource_Setup
{
    public function syncReviews() {
        Mage::getResourceModel('itactica_extendedreviews/review')->syncReviews();
    }

}
