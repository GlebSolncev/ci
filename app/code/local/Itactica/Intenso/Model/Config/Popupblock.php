<?php
/**
 * Intenso Premium Theme
 *
 * @category    Itactica
 * @package     Itactica_Intenso
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */
class Itactica_Intenso_Model_Config_Popupblock
{
    public function toOptionArray()
    {
        $model = Mage::getModel('cms/block');
        $collection = $model->getCollection()->addFieldToFilter('is_active', 1);
        if ($collection->getSize()) {
            foreach ($collection as $block) {
                $options[] = array(
                    'value' => $block->getIdentifier(),
                    'label' => $block->getTitle() . ' (' . $block->getIdentifier() . ')'
                );
            }
        } else {
            $options[] = array(
                'value' => '0',
                'label' => Mage::helper('itactica_intenso')->__('No static blocks found on your store')
            );
        }
 
        return $options;
    }
}