<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_FeaturedCategories
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_FeaturedCategories_Block_Adminhtml_Catalog_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
	/**
     * render row
     * @access public
     * @param Varien_Object $row
     * @return string
     */
	public function render(Varien_Object $row)
    {
    	if ($imageUrl = $row->getData($this->getColumn()->getIndex())) {
	        $html = '<img ';
	        $html .= 'id="' . $this->getColumn()->getId() . '" ';
	        $html .= 'src="' . Mage::getBaseUrl('media').'catalog/category/' .$imageUrl . '"';
	        $html .= 'class="grid-image ' . $this->getColumn()->getInlineCss() . '" height="50"/>';
	    } else {
	    	$html = '';
	    }
	        return $html;
    }
}