<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_ExtendedReviews
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_ExtendedReviews_Helper_Render extends Mage_Core_Helper_Abstract {

    public function getOrderItemOptionsHtml($item) {
        $options = $this->getItemOptions($item);
        $html = '';
        foreach ($options as $option) {
            $label = htmlspecialchars($option['label']);
            $value = htmlspecialchars($option['value']);
            $html.="<dl class=\"item-options\"><dt>{$label}</dt><dd>{$value}</dd></dl>";
        }
        return $html;
    }

    public function getItemOptions($item) {
        $result = array();
        if ($options = $item->getProductOptions()) {
            if (isset($options['options'])) {
                $result = array_merge($result, $options['options']);
            }
            if (isset($options['additional_options'])) {
                $result = array_merge($result, $options['additional_options']);
            }
            if (!empty($options['attributes_info'])) {
                $result = array_merge($options['attributes_info'], $result);
            }
        }
        return $result;
    }
}
