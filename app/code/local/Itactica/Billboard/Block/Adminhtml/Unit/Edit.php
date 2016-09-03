<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_Billboard
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_Billboard_Block_Adminhtml_Unit_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * constructor
     * @access public
     * @return void
     */
    public function __construct(){
        parent::__construct();
        $this->_blockGroup = 'itactica_billboard';
        $this->_controller = 'adminhtml_unit';
        $this->_updateButton('save', 'label', Mage::helper('itactica_billboard')->__('Save Billboard'));
        $this->_updateButton('delete', 'label', Mage::helper('itactica_billboard')->__('Delete Billboard'));
        $this->_addButton('saveandcontinue', array(
            'label'        => Mage::helper('itactica_billboard')->__('Save And Continue Edit'),
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
        if( Mage::registry('current_billboard') && Mage::registry('current_billboard')->getId() ) {
            return Mage::helper('itactica_billboard')->__("Edit Billboard '%s'", $this->escapeHtml(Mage::registry('current_billboard')->getTitle()));
        }
        else {
            return Mage::helper('itactica_billboard')->__('Add Billboard');
        }
    }
}
