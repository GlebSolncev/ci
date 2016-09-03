<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_FeaturedProducts
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_FeaturedProducts_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * convert array to options
     * @access public
     * @param $options
     * @return array
     */
    public function convertOptions($options){
        $converted = array();
        foreach ($options as $option){
            if (isset($option['value']) && !is_array($option['value']) && isset($option['label']) && !is_array($option['label'])){
                $converted[$option['value']] = $option['label'];
            }
        }
        return $converted;
    }

    /**
     * format category tree
     * @access public
     * @param Varien_Data_Tree_Node $node
     * @param array $values
     * @param int $level
     * @return array
     */
    private function _formatCategoryTree(Varien_Data_Tree_Node $node, $values, $level = 0) {
        $nonEscapableNbspChar = html_entity_decode('&#160;&#160;', ENT_NOQUOTES, 'UTF-8');
        $level++;

        if ($level > 1) {  
            $values[$node->getId()]['label'] = str_repeat($nonEscapableNbspChar, ($level - 2) * 4) . $node->getName();
            $values[$node->getId()]['value'] =  $node->getId();
        }
        
        foreach ($node->getChildren() as $child) {
            $values = $this->_formatCategoryTree($child, $values, $level);
        }
        
        return $values;
    }

    /**
     * retrieve category tree
     * @access public
     * @return array
     */
    public function getCategoryTree() {
        $tree = Mage::getResourceSingleton('catalog/category_tree')->load();    
        $root = $tree->getNodeById(1);
        
        if($root && $root->getId() == 1) {
            $root->setName(Mage::helper('catalog')->__('Root')); 
        }

        $collection = Mage::getModel('catalog/category')->getCollection() 
            ->addAttributeToSelect('name') 
            ->addAttributeToSelect('is_active');
        
        $tree->addCollectionData($collection, true); 

        return $this->_formatCategoryTree($root, array());    
    }
}
