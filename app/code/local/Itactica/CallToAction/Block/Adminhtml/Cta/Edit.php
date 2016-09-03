<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_CallToAction
 * @copyright   Copyright (c) 2014-2015 Itactica (https://www.getintenso.com)
 * @license     https://getintenso.com/license
 */

class Itactica_CallToAction_Block_Adminhtml_Cta_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * constructor
     * @access public
     * @return void
     */
    public function __construct(){
        parent::__construct();
        $this->_blockGroup = 'itactica_calltoaction';
        $this->_controller = 'adminhtml_cta';
        $this->_updateButton('save', 'label', Mage::helper('itactica_calltoaction')->__('Save CallToAction'));
        $this->_updateButton('delete', 'label', Mage::helper('itactica_calltoaction')->__('Delete CallToAction'));
        $this->_addButton('saveandcontinue', array(
            'label'        => Mage::helper('itactica_calltoaction')->__('Save And Continue Edit'),
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
        if( Mage::registry('current_calltoaction') && Mage::registry('current_calltoaction')->getId() ) {
            return Mage::helper('itactica_calltoaction')->__("Edit CallToAction '%s'", $this->escapeHtml(Mage::registry('current_calltoaction')->getTitle()));
        }
        else {
            return Mage::helper('itactica_calltoaction')->__('Add CallToAction');
        }
    }
}
