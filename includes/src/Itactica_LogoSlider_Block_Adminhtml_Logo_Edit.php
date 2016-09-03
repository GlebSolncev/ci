<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_LogoSlider
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_LogoSlider_Block_Adminhtml_Logo_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * constructor
     * @access public
     * @return void
     */
    public function __construct(){
        parent::__construct();
        $this->_blockGroup = 'itactica_logoslider';
        $this->_controller = 'adminhtml_logo';
        $this->_updateButton('save', 'label', Mage::helper('itactica_logoslider')->__('Save Image'));
        $this->_updateButton('delete', 'label', Mage::helper('itactica_logoslider')->__('Delete Image'));
        $this->_addButton('saveandcontinue', array(
            'label'        => Mage::helper('itactica_logoslider')->__('Save And Continue Edit'),
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
        if( Mage::registry('current_logo') && Mage::registry('current_logo')->getId() ) {
            return Mage::helper('itactica_logoslider')->__("Edit '%s'", $this->escapeHtml(Mage::registry('current_logo')->getTitle()));
        }
        else {
            return Mage::helper('itactica_logoslider')->__('Add Image');
        }
    }
}
