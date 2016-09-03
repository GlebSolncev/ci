<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_LayeredNavigation
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_LayeredNavigation_Model_Catalog_Resource_Layer_Filter_Price extends Mage_Catalog_Model_Resource_Layer_Filter_Price
{
    /**
     * Get comparing value sql part
     *
     * @param float $price
     * @param Mage_Catalog_Model_Layer_Filter_Price $filter
     * @param bool $decrease
     * @return float
     */
    protected function _getComparingValue($price, $filter, $decrease = true)
    {
        if (Mage::helper('itactica_layerednavigation')->isEnabled()
            && Mage::helper('itactica_layerednavigation')->isPriceSliderEnabled()
        ) {
            $currencyRate = $filter->getLayer()->getProductCollection()->getCurrencyRate();
            return $price / $currencyRate;
        }

        return parent::_getComparingValue($price, $filter, $decrease);
    }

    /**
     * Apply price range filter to product collection
     *
     * @param Mage_Catalog_Model_Layer_Filter_Price $filter
     * @return Mage_Catalog_Model_Resource_Layer_Filter_Price
     */
    public function applyPriceRange($filter)
    {
        $interval = $filter->getInterval();
        if (!$interval) {
            return $this;
        }

        list($from, $to) = $interval;
        if ($from === '' && $to === '') {
            return $this;
        }

        $select = $filter->getLayer()->getProductCollection()->getSelect();
        $priceExpr = $this->_getPriceExpression($filter, $select, false);

        if ($to !== '') {
            $to = (float)$to;
            if ($from == $to) {
                $to += self::MIN_POSSIBLE_PRICE;
            }
        }

        if ($from !== '') {
            $select->where($priceExpr . ' >= ' . $this->_getComparingValue($from, $filter));
        }
        if ($to !== '') {
            $select->where($priceExpr . ' <= ' . $this->_getComparingValue($to, $filter));
        }

        return $this;
    }

}