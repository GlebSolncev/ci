<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_OrbitSlider
 * @copyright   Copyright (c) 2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_OrbitSlider_Block_Adminhtml_Slides_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * constructor
     * @access public
     * @return void
     */
    public function __construct(){
        parent::__construct();
        $this->_blockGroup = 'itactica_orbitslider';
        $this->_controller = 'adminhtml_slides';
        $this->_updateButton('save', 'label', Mage::helper('itactica_orbitslider')->__('Save Slide'));
        $this->_updateButton('delete', 'label', Mage::helper('itactica_orbitslider')->__('Delete Slide'));
        $this->_addButton('saveandcontinue', array(
            'label'        => Mage::helper('itactica_orbitslider')->__('Save And Continue Edit'),
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
        if( Mage::registry('current_slide') && Mage::registry('current_slide')->getId() ) {
            return Mage::helper('itactica_orbitslider')->__("Edit '%s'", $this->escapeHtml(Mage::registry('current_slide')->getTitle()));
        }
        else {
            return Mage::helper('itactica_orbitslider')->__('Add Slide');
        }
    }
}
