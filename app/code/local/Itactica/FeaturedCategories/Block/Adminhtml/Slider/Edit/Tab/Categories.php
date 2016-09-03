<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_FeaturedCategories
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_FeaturedCategories_Block_Adminhtml_Slider_Edit_Tab_Categories extends Mage_Adminhtml_Block_Catalog_Category_Tree
{
    protected $_categoryIds = null;
    protected $_selectedNodes = null;

    /**
     * constructor
     * Specify template to use
     * @access public
     */
    public function __construct() {
        parent::__construct();
        $this->setTemplate('itactica_featuredcategories/slider/edit/tab/categories.phtml');
        $this->_withProductCount = false;
    }
    /**
     * Retrieve currently edited slider
     * @access public
     * @return Itactica_FeaturedCategories_Model_Slider
     */
    public function getSlider(){
        return Mage::registry('current_slider');
    }
    /**
     * Return array with categories IDs which the slider is linked to
     * @access public
     * @return array
     */
    public function getCategoryIds(){
        if (is_null($this->_categoryIds)){
            $categories = $this->getSlider()->getSelectedCategories();
                $ids = array();
                foreach ($categories as $category){
                    $ids[] = $category->getId();
                }
                $this->_categoryIds = $ids;
        }
        return $this->_categoryIds;
    }
    /**
     * Forms string out of getCategoryIds()
     * @access public
     * @return string
     */
    public function getIdsString(){
        return implode(',', $this->getCategoryIds());
    }
    /**
     * Returns root node and sets 'checked' flag (if necessary)
     * @access public
     * @return Varien_Data_Tree_Node
     */
    public function getRootNode(){
        $root = $this->getRoot();
        if ($root && in_array($root->getId(), $this->getCategoryIds())) {
            $root->setChecked(true);
        }
        return $root;
    }

    /**
     * Returns root node
     *
     * @param Itactica_FeaturedCategories_Model_Category|null $parentNodeCategory
     * @param int  $recursionLevel
     * @return Varien_Data_Tree_Node
     */
    public function getRoot($parentNodeCategory = null, $recursionLevel = 3){
        if (!is_null($parentNodeCategory) && $parentNodeCategory->getId()) {
            return $this->getNode($parentNodeCategory, $recursionLevel);
        }
        $root = Mage::registry('category_root');
        if (is_null($root)) {
            $rootId = Mage_Catalog_Model_Category::TREE_ROOT_ID;
            $ids = $this->getSelectedCategoryPathIds($rootId);
            $tree = Mage::getResourceSingleton('catalog/category_tree')
                ->loadByIds($ids, false, false);
            if ($this->getCategory()) {
                $tree->loadEnsuredNodes($this->getCategory(), $tree->getNodeById($rootId));
            }
            $tree->addCollectionData($this->getCategoryCollection());
            $root = $tree->getNodeById($rootId);
            Mage::register('category_root', $root);
        }
        return $root;
    }
    /**
     * Returns array with configuration of current node
     * @access public
     * @param Varien_Data_Tree_Node $node
     * @param int $level How deep is the node in the tree
     * @return array
     */
    protected function _getNodeJson($node, $level = 1){
        $item = parent::_getNodeJson($node, $level);
        if ($this->_isParentSelectedCategory($node)) {
            $item['expanded'] = true;
        }
        if (in_array($node->getId(), $this->getCategoryIds())) {
            $item['checked'] = true;
        }
        return $item;
    }
    /**
     * Returns whether $node is a parent (not exactly direct) of a selected node
     * @access public
     * @param Varien_Data_Tree_Node $node
     * @return bool
     */
    protected function _isParentSelectedCategory($node){
        $result = false;
        // Contains string with all category IDs of children (not exactly direct) of the node
        $allChildren = $node->getAllChildren();
        if ($allChildren) {
            $selectedCategoryIds = $this->getCategoryIds();
            $allChildrenArr = explode(',', $allChildren);
            for ($i = 0, $cnt = count($selectedCategoryIds); $i < $cnt; $i++) {
                $isSelf = $node->getId() == $selectedCategoryIds[$i];
                if (!$isSelf && in_array($selectedCategoryIds[$i], $allChildrenArr)) {
                    $result = true;
                    break;
                }
            }
        }
        return $result;
    }
    /**
     * Returns array with nodes those are selected (contain current slider)
     *
     * @return array
     */
    protected function _getSelectedNodes(){
        if ($this->_selectedNodes === null) {
            $this->_selectedNodes = array();
            $root = $this->getRoot();
            foreach ($this->getCategoryIds() as $categoryId) {
                if ($root) {
                    $this->_selectedNodes[] = $root->getTree()->getNodeById($categoryId);
                }
            }
        }
        return $this->_selectedNodes;
    }

    /**
     * Returns JSON-encoded array of category children
     * @access public
     * @param int $categoryId
     * @return string
     */
    public function getCategoryChildrenJson($categoryId){
        $category = Mage::getModel('catalog/category')->load($categoryId);
        $node = $this->getRoot($category, 1)->getTree()->getNodeById($categoryId);
        if (!$node || !$node->hasChildren()) {
            return '[]';
        }
        $children = array();
        foreach ($node->getChildren() as $child) {
            $children[] = $this->_getNodeJson($child);
        }
        return Mage::helper('core')->jsonEncode($children);
    }
    /**
     * Returns URL for loading tree
     * @access public
     * @param null $expanded
     * @return string
     */
    public function getLoadTreeUrl($expanded = null){
        return $this->getUrl('*/*/categoriesJson', array('_current' => true));
    }

    /**
     * Return distinct path ids of selected category
     * @access public
     * @param mixed $rootId Root category Id for context
     * @return array
     */
    public function getSelectedCategoryPathIds($rootId = false){
        $ids = array();
        $categoryIds = $this->getCategoryIds();
        if (empty($categoryIds)) {
            return array();
        }
        $collection = Mage::getResourceModel('catalog/category_collection');
        if ($rootId) {
            $collection->addFieldToFilter('parent_id', $rootId);
        }
        else {
            $collection->addFieldToFilter('entity_id', array('in'=>$categoryIds));
        }

        foreach ($collection as $item) {
            if ($rootId && !in_array($rootId, $item->getPathIds())) {
                continue;
            }
            foreach ($item->getPathIds() as $id) {
                if (!in_array($id, $ids)) {
                    $ids[] = $id;
                }
            }
        }
        return $ids;
    }
}