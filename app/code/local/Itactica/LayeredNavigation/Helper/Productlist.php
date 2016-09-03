<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_LayeredNavigation
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_LayeredNavigation_Helper_Productlist extends Mage_ConfigurableSwatches_Helper_Productlist
{
    /**
     * Convert a catalog layer block with the right templates
     *
     * @param string $blockName
     * @return void
     */
    public function convertLayerBlock($blockName) {
        if (Mage::getStoreConfig('configswatches/general/enabled', Mage::app()->getStore())
            && ($block = Mage::app()->getLayout()->getBlock($blockName))
            && $block instanceof Mage_Catalog_Block_Layer_View
            && Mage::getStoreConfig('itactica_layerednavigation/catalog/enabled', Mage::app()->getStore())) {

            // if LayeredNavigation extension is enabled
            // First, set a new template for the attribute that should show as a swatch
            if ($layer = $block->getLayer()) {
                foreach ($layer->getFilterableAttributes() as $attribute) {
                    if (Mage::helper('configurableswatches')->attrIsSwatchType($attribute)) {
                        $block->getChild($attribute->getAttributeCode() . '_filter')
                            ->setTemplate('itactica_layerednavigation/catalog/layer/swatches.phtml');
                    }
                }
            }
        } else {
            // LayeredNavigation extension is disabled
            return parent::convertLayerBlock($blockName);
        }
    }

}
