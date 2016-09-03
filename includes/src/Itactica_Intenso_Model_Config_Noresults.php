<?php
/**
 * Intenso Premium Theme
 *
 * @category    Itactica
 * @package     Itactica_Intenso
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */
class Itactica_Intenso_Model_Config_Noresults
{
    public function toOptionArray()
    {
        $feturedProductSlider = Mage::getModel('itactica_featuredproducts/slider')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->getCollection()
            ->addFieldToSelect('*');
        $options[] = array(
          'value' => 0,
          'label' => 'No Block'
        );
        foreach ($feturedProductSlider as $slider) {
            if ($slider->getStatus()) {
                $options[] = array(
                    'value' => $slider->getIdentifier(),
                    'label' => $slider->getTitle() . ' (' . $slider->getIdentifier() . ')'
                );
            }
        }
 
        return $options;
    }
}