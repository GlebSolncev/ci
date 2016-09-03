<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_TextBoxes
 * @copyright   Copyright (c) 2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_TextBoxes_Block_Adminhtml_Box_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * constructor
     * @access public
     * @return void
     */
    public function __construct(){
        parent::__construct();
        $this->_blockGroup = 'itactica_textboxes';
        $this->_controller = 'adminhtml_box';
        $this->_updateButton('save', 'label', Mage::helper('itactica_textboxes')->__('Save Text Box'));
        $this->_updateButton('delete', 'label', Mage::helper('itactica_textboxes')->__('Delete Text Box'));
        $this->_addButton('saveandcontinue', array(
            'label'        => Mage::helper('itactica_textboxes')->__('Save And Continue Edit'),
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
        if( Mage::registry('current_box') && Mage::registry('current_box')->getId() ) {
            return Mage::helper('itactica_textboxes')->__("Edit Text Box '%s'", $this->escapeHtml(Mage::registry('current_box')->getTitle()));
        }
        else {
            return Mage::helper('itactica_textboxes')->__('Add Text Box');
        }
    }
}
