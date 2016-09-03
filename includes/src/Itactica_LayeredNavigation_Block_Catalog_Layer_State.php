<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_LayeredNavigation
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_LayeredNavigation_Block_Catalog_Layer_State extends Mage_Catalog_Block_Layer_State
{

    /**
     * Retrieve Clear Filters URL
     *
     * @return string
     */
    public function getClearUrl()
    {
        if (!$this->helper('itactica_layerednavigation')->isEnabled()) {
            return parent::getClearUrl();
        }

        if ($this->helper('itactica_layerednavigation')->isCatalogSearch()) {
            $filterState = array('isLayerAjax' => null);
            foreach ($this->getActiveFilters() as $item) {
                $filterState[$item->getFilter()->getRequestVar()] = $item->getFilter()->getCleanValue();
            }
            $params['_current'] = true;
            $params['_use_rewrite'] = true;
            $params['_query'] = $filterState;
            $params['_escape'] = true;
            return Mage::getUrl('*/*/*', $params);
        }

        return $this->helper('itactica_layerednavigation')->getClearFiltersUrl();
    }
}
