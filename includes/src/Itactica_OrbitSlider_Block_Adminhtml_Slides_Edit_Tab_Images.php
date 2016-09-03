<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_OrbitSlider
 * @copyright   Copyright (c) 2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_OrbitSlider_Block_Adminhtml_Slides_Edit_Tab_Images extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     * @access protected
     * @return LogoSlider_Logo_Block_Adminhtml_Logo_Edit_Tab_Form
     */
    protected function _prepareForm(){
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('slide_');
        $form->setFieldNameSuffix('slide');
        $this->setForm($form);
        $fieldset = $form->addFieldset('slide_form', array('legend'=>Mage::helper('itactica_orbitslider')->__('Images')));
        $fieldset->addType('image', Mage::getConfig()->getBlockClassName('itactica_orbitslider/adminhtml_slides_helper_image'));

        $fieldset->addField('filename_for_large', 'image', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Image for large screens'),
            'name'  => 'filename_for_large',
            'note'	=> $this->__('Recommended width: 1920px. For full screen slides the recommended image size is 1920px by 1080px.'),
            'required'  => true,
            'class' => 'required-entry',

        ));

        $fieldset->addField('filename_for_medium', 'image', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Image for medium screens'),
            'name'  => 'filename_for_medium',
            'note'  => $this->__('Recommended width: 1024px. For full screen slides the recommended image size is 1024px by 576px.'),
            'required'  => true,
            'class' => 'required-entry',

        ));

        $fieldset->addField('filename_for_small', 'image', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Image for small screens'),
            'name'  => 'filename_for_small',
            'note'  => $this->__('Recommended width: 640px. For full screen slides the recommended image size is 640px by 360px.'),
            'required'  => true,
            'class' => 'required-entry',

        ));

        $fieldset->addField('image_link', 'text', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Image Link'),
            'name'  => 'image_link',
            'note'  => $this->__('Enter a link for slide image if you want to link it.<br>The URL could be relative or absolute:<br>catalog/product1.html<br>http://www.example.com/catalog/product1.html'),
        ));

        $formValues = Mage::registry('current_slide')->getDefaultValues();
        if (!is_array($formValues)){
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getSlideData()){
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getSlideData());
            Mage::getSingleton('adminhtml/session')->setSlideData(null);
        }
        elseif (Mage::registry('current_slide')){
            $formValues = array_merge($formValues, Mage::registry('current_slide')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
