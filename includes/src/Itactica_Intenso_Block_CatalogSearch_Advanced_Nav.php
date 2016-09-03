<?php
/**
 * Intenso Premium Theme
 *
 * @category    design
 * @package     intenso_default
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */
?>
<?php
class Itactica_Intenso_Block_Catalogsearch_Advanced_Nav extends Mage_CatalogSearch_Block_Advanced_Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('catalogsearch/advanced/nav.phtml');
    }
    
	public function _prepareLayout()
	{
	}
	
    public function getAttributeSelectElement($attribute)
    {
        $extra = '';
        $options = $attribute->getSource()->getAllOptions(false);

        $name = $attribute->getAttributeCode();

        // 2 - avoid yes/no selects to be multiselects
        if (is_array($options) && count($options)>2) {
            $extra = 'multiple="multiple"';
            $name.= '[]';
        }
        else {
            array_unshift($options, array('value'=>'', 'label'=>Mage::helper('catalogsearch')->__('All')));
        }

        return $this->_getSelectBlock()
            ->setName($name)
            ->setId($attribute->getAttributeCode())
            ->setTitle($this->getAttributeLabel($attribute))
            ->setExtraParams($extra)
            ->setValue($this->getAttributeValue($attribute))
            ->setOptions($options)
			->setClass('multiselect')
            ->getHtml();
    }
	
}