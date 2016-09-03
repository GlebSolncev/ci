<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_MegaMenu
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_MegaMenu_Block_Menu_Renderer extends Mage_Page_Block_Html_Topmenu_Renderer
{
	/**
     * category collection
     *
     * @var Mage_Eav_Model_Entity_Collection_Abstract
     */
    protected $_cat;

	/**
     * renders block html
     * @return string
     * @throws Exception
     */
    protected function _toHtml() {
    	return parent::_toHtml();
    }

    /**
     * get menu style
     * @param string $categoryNode
     * @return string
     */
    public function getMenuStyle($categoryNode) {
    	if (!isset($this->_cat[$categoryNode])) {
	    	$categoryId = str_replace('category-node-', '', $categoryNode);
	    	$this->_cat[$categoryNode] = Mage::getModel("catalog/category")->load($categoryId);
	    }
	    
	    $menuStyle = $this->_cat[$categoryNode]->getIntensoMenuStyle();
    	if ($menuStyle == 2 && $this->_cat[$categoryNode]->getLevel() == 2) {
    		return "mega-menu";
    	} elseif ($menuStyle == 1 && $this->_cat[$categoryNode]->getLevel() == 2) {
    		return "classic";
    	} elseif ($menuStyle == 3 && $this->_cat[$categoryNode]->getLevel() == 2) {
    		return "no-dropdown";
    	} else {
    		return false;
    	}
    }

    /**
     * get right block content
     * @param string $categoryNode
     * @return string
     */
    public function getRightBlock($categoryNode) {
    	if (!isset($this->_cat[$categoryNode])) {
	    	$categoryId = str_replace('category-node-', '', $categoryNode);
	    	$this->_cat[$categoryNode] = Mage::getModel("catalog/category")->load($categoryId);
	    }

	    $rightBlock = $this->_cat[$categoryNode]->getIntensoMenuRightBlock();
	    if (strlen($rightBlock) > 1) {
	    	if (!$this->_tplProcessor){ 
				$this->_tplProcessor = Mage::helper('cms')->getBlockTemplateProcessor();
			}
			return $this->_tplProcessor->filter( trim($rightBlock) );
    	} else {
    		return false;
    	}
    }

    /**
     * get class for number of columns on large screens
     * @param string $categoryNode
     * @return string
     */
    public function getColumnsClassForLarge($categoryNode) {
    	if (!isset($this->_cat[$categoryNode])) {
	    	$categoryId = str_replace('category-node-', '', $categoryNode);
	    	$this->_cat[$categoryNode] = Mage::getModel("catalog/category")->load($categoryId);
	    }

	    $columns = $this->_cat[$categoryNode]->getIntensoMenuColumnsLarge();
	    if ($columns > 0 && $columns < 10) {
    		return ' columns-'.$columns.'-for-large';
    	} elseif ($columns == 10) {
    		return ' hide-subcategories-for-large';
    	}
    }

    /**
     * get class for number of columns on medium screens
     * @param string $categoryNode
     * @return string
     */
    public function getColumnsClassForMedium($categoryNode) {
    	if (!isset($this->_cat[$categoryNode])) {
	    	$categoryId = str_replace('category-node-', '', $categoryNode);
	    	$this->_cat[$categoryNode] = Mage::getModel("catalog/category")->load($categoryId);
	    }

	    $columns = $this->_cat[$categoryNode]->getIntensoMenuColumnsMedium();
	    if ($this->getMenuStyle($categoryNode) == 'mega-menu') {
		    if ($columns > 0 && $columns < 10) {
	    		return ' columns-'.$columns.'-for-medium';
	    	} elseif ($columns == 10) {
	    		return ' hide-subcategories-for-medium';
	    	}
	    }
    }

    /**
     * get width of right block
     * @param string $categoryNode
     * @param string $type (width | padding)
     * @return string
     */
    public function getRightBlockWidth($categoryNode, $type) {
    	if (!isset($this->_cat[$categoryNode])) {
	    	$categoryId = str_replace('category-node-', '', $categoryNode);
	    	$this->_cat[$categoryNode] = Mage::getModel("catalog/category")->load($categoryId);
	    }

	    $width = $this->_cat[$categoryNode]->getIntensoMenuRightBlockWidth();
        $columns = $this->_cat[$categoryNode]->getIntensoMenuColumnsLarge();
	    if ($this->getMenuStyle($categoryNode) == 'mega-menu') {
		    if ($width > 0 && $type == 'width' && $columns != 10) {
	    		return ' style="width: '.$width.' !important"';
            } elseif ($columns == 10) {
                return ' style="padding-right: 93.5%"';
	    	} elseif ($width > 0 && $type == 'padding') {
				return ' style="padding-right: '.$width.'"';
	    	}
	    }
    }

    /**
     * get top block content
     * @param string $categoryNode
     * @return string
     */
    public function getTopBlock($categoryNode) {
    	if (!isset($this->_cat[$categoryNode])) {
	    	$categoryId = str_replace('category-node-', '', $categoryNode);
	    	$this->_cat[$categoryNode] = Mage::getModel("catalog/category")->load($categoryId);
	    }

	    $topBlock = $this->_cat[$categoryNode]->getIntensoMenuTopBlock();
	    if (strlen($topBlock) > 1) {
	    	if (!$this->_tplProcessor){ 
				$this->_tplProcessor = Mage::helper('cms')->getBlockTemplateProcessor();
			}
			return $this->_tplProcessor->filter(trim($topBlock));
    	} else {
    		return false;
    	}
    }

    /**
     * get bottom block content
     * @param string $categoryNode
     * @return string
     */
    public function getBottomBlock($categoryNode) {
    	if (!isset($this->_cat[$categoryNode])) {
	    	$categoryId = str_replace('category-node-', '', $categoryNode);
	    	$this->_cat[$categoryNode] = Mage::getModel("catalog/category")->load($categoryId);
	    }

	    $bottomBlock = $this->_cat[$categoryNode]->getIntensoMenuBottomBlock();
	    if (strlen($bottomBlock) > 1) {
	    	if (!$this->_tplProcessor){ 
				$this->_tplProcessor = Mage::helper('cms')->getBlockTemplateProcessor();
			}
			return $this->_tplProcessor->filter(trim($bottomBlock));
    	} else {
    		return false;
    	}
    }
}