<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_ExtendedReviews
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_ExtendedReviews_Model_System_Config_Source_Tips 
{

    public function toOptionArray() {
        $collection = Mage::getResourceModel('cms/block_collection');
        $values = array(array('value' => '', 'label' => ''));
        foreach ($collection as $item) {
            $values[] = array('value' => $item->getIdentifier(), 'label' => $item->getTitle());
        }
        return $values;
    }

}
