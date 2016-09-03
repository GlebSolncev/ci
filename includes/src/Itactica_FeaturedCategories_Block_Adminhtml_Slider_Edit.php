<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_FeaturedCategories
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_FeaturedCategories_Block_Adminhtml_Slider_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * constructor
     * @access public
     * @return void
     */
    public function __construct(){
        parent::__construct();
        $this->_blockGroup = 'itactica_featuredcategories';
        $this->_controller = 'adminhtml_slider';
        $this->_updateButton('save', 'label', Mage::helper('itactica_featuredcategories')->__('Save Slider'));
        $this->_updateButton('delete', 'label', Mage::helper('itactica_featuredcategories')->__('Delete Slider'));
        $this->_addButton('saveandcontinue', array(
            'label'        => Mage::helper('itactica_featuredcategories')->__('Save And Continue Edit'),
            'onclick'    => 'saveAndContinueEdit()',
            'class'        => 'save',
        ), -100);
        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }
    /**
     * get the edit form header
     * @access public
     * @return string
     */
    public function getHeaderText(){
        if( Mage::registry('current_slider') && Mage::registry('current_slider')->getId() ) {
            return Mage::helper('itactica_featuredcategories')->__("Edit Slider '%s'", $this->escapeHtml(Mage::registry('current_slider')->getTitle()));
        }
        else {
            return Mage::helper('itactica_featuredcategories')->__('Add Slider');
        }
    }
}
