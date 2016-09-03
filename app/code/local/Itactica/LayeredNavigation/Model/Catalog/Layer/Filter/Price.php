<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_LayeredNavigation
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_LayeredNavigation_Model_Catalog_Layer_Filter_Price extends Mage_Catalog_Model_Layer_Filter_Price
{

    /**
     * Get data for build price filter items
     *
     * @return array
     */
    protected function _getItemsData()
    {
        if (Mage::app()->getStore()->getConfig(self::XML_PATH_RANGE_CALCULATION) == self::RANGE_CALCULATION_IMPROVED) {
            return $this->_getCalculatedItemsData();
        }

        $range      = $this->getPriceRange();
        $dbRanges   = $this->getRangeItemCounts($range);
        $data       = array();

        if (!empty($dbRanges)) {
            $lastIndex = array_keys($dbRanges);
            $lastIndex = $lastIndex[count($lastIndex) - 1];

            foreach ($dbRanges as $index => $count) {
                $fromPrice = ($index == 1) ? '' : (($index - 1) * $range);
                $toPrice = ($index == $lastIndex) ? '' : ($index * $range);

                $data[] = array(
                    'label' => $this->_renderRangeLabel($fromPrice, $toPrice),
                    'value' => $fromPrice . '-' . $toPrice,
                    'count' => $count,
                );
            }
        }

        return $data;
    }

    /**
     * Get maximum price from layer products set
     *
     * @return float
     */
    public function getMaxPriceFloat()
    {
        if (!$this->hasData('max_price_float')) {
            $this->_collectPriceRange();
        }

        return $this->getData('max_price_float');
    }

    /**
     * Get minimum price from layer products set
     *
     * @return float
     */
    public function getMinPriceFloat()
    {
        if (!$this->hasData('min_price_float')) {
            $this->_collectPriceRange();
        }

        return $this->getData('min_price_float');
    }
    
    /**
     * Collect usefull information - max and min price
     * 
     * @return Itactica_LayeredNavigation_Model_Catalog_Layer_Filter_Price
     */
    protected function _collectPriceRange() 
    {
        $collection = $this->getLayer()->getProductCollection();
        $select = $collection->getSelect();
        $conditions = $select->getPart(Zend_Db_Select::WHERE);
        
        // Remove price sql conditions
        $conditionsNoPrice = array();
        foreach ($conditions as $key => $condition) {
            if (stripos($condition, 'price_index') !== false) {
                continue;
            }
            $conditionsNoPrice[] = $condition;
        }        
        $select->setPart(Zend_Db_Select::WHERE, $conditionsNoPrice);
        
        $this->setData('min_price_float', floor($collection->getMinPrice()));
        $this->setData('max_price_float', round($collection->getMaxPrice()));
        
        // Restore all sql conditions
        $select->setPart(Zend_Db_Select::WHERE, $conditions);
        
        return $this;
    }

}
