<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_LayeredNavigation
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_LayeredNavigation_Block_Catalog_Layer_Filter_Category extends Mage_Catalog_Block_Layer_Filter_Category
{

    /**
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct();

        if ($this->helper('itactica_layerednavigation')->isEnabled()
            && $this->helper('itactica_layerednavigation')->isMultipleChoiceFiltersEnabled()) {
            /**
             * Modify template for multiple filters rendering
             */
            $this->setTemplate('itactica_layerednavigation/catalog/layer/catalogfilter.phtml');
        }
    }

}