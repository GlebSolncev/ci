<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_OrbitSlider
 * @copyright   Copyright (c) 2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_OrbitSlider_Block_Adminhtml_Slides_Edit_Tab_Content extends Mage_Adminhtml_Block_Widget_Form
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
        $fieldset = $form->addFieldset('slide_form', array('legend'=>Mage::helper('itactica_orbitslider')->__('Content for Medium and Large Screens')));
        $fieldset->addType('colorpicker', 'Itactica_OrbitSlider_Block_Adminhtml_Slides_Edit_Form_Renderer_Fieldset_Colorpicker');

        $fieldset->addField('title_for_large', 'text', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Slide Title'),
            'name'  => 'title_for_large',
            'note'  => $this->__('Enter slide title (optional)'),
        ));

        $fieldset->addField('title_for_large_color', 'colorpicker', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Title Color'),
            'name'  => 'title_for_large_color',
            'note'  => $this->__('Select font-color'),
        ));

        $fieldset->addField('title_for_large_size', 'text', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Title Size'),
            'name'  => 'title_for_large_size',
            'note'  => $this->__('Enter font-size in pixels'),
            'class' => 'validate-number',
        ));

        $fieldset->addField('title_for_large_style', 'select', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Title Style'),
            'name'  => 'title_for_large_style',
            'note'  => $this->__('Select font-style'),
            'values'=> Mage::getModel('itactica_orbitslider/slides_attribute_source_fontstyle')->getAllOptions(true),
        ));

        $fieldset->addField('title_for_large_weight', 'select', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Title Weight'),
            'name'  => 'title_for_large_weight',
            'note'  => $this->__('Select font-weight'),
            'values'=> Mage::getModel('itactica_orbitslider/slides_attribute_source_fontweight')->getAllOptions(true),
        ));

        $fieldset->addField('text_for_large', 'textarea', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Text'),
            'name'  => 'text_for_large',
            'note'  => $this->__('Enter slide text (optional)'),
            'style' => 'height: 8em',
        ));

        $fieldset->addField('text_for_large_color', 'colorpicker', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Text Color'),
            'name'  => 'text_for_large_color',
            'note'  => $this->__('Select font-color'),
        ));

        $fieldset->addField('text_for_large_size', 'text', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Text Size'),
            'name'  => 'text_for_large_size',
            'note'  => $this->__('Enter font-size in pixels'),
            'class' => 'validate-number',
        ));

        $fieldset->addField('text_for_large_style', 'select', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Text Style'),
            'name'  => 'text_for_large_style',
            'note'  => $this->__('Select font-style'),
            'values'=> Mage::getModel('itactica_orbitslider/slides_attribute_source_fontstyle')->getAllOptions(true),
        ));

        $fieldset->addField('text_for_large_weight', 'select', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Text Weight'),
            'name'  => 'text_for_large_weight',
            'note'  => $this->__('Select font-weight'),
            'values'=> Mage::getModel('itactica_orbitslider/slides_attribute_source_fontweight')->getAllOptions(true),
        ));

        $fieldset2 = $form->addFieldset('slide_form2', array('legend'=>Mage::helper('itactica_orbitslider')->__('Content for Small Screens')));
        $fieldset2->addType('colorpicker', 'Itactica_OrbitSlider_Block_Adminhtml_Slides_Edit_Form_Renderer_Fieldset_Colorpicker');

        $fieldset2->addField('text_block_color_for_small', 'colorpicker', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Text Block Background Color'),
            'name'  => 'text_block_color_for_small',
            'note'  => $this->__('Select background-color'),
        ));

        $fieldset2->addField('title_for_small', 'text', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Slide Title'),
            'name'  => 'title_for_small',
            'note'  => $this->__('Enter slide title (optional). Leave "Slide Title" and "Text" fields empty to hide the text block on mobile'),
        ));

        $fieldset2->addField('title_for_small_color', 'colorpicker', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Title Color'),
            'name'  => 'title_for_small_color',
            'note'  => $this->__('Select font-color'),
        ));

        $fieldset2->addField('title_for_small_size', 'text', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Title Size'),
            'name'  => 'title_for_small_size',
            'note'  => $this->__('Enter font-size in pixels'),
            'class' => 'validate-number',
        ));

        $fieldset2->addField('title_for_small_style', 'select', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Title Style'),
            'name'  => 'title_for_small_style',
            'note'  => $this->__('Select font-style'),
            'values'=> Mage::getModel('itactica_orbitslider/slides_attribute_source_fontstyle')->getAllOptions(true),
        ));

        $fieldset2->addField('title_for_small_weight', 'select', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Title Weight'),
            'name'  => 'title_for_small_weight',
            'note'  => $this->__('Select font-weight'),
            'values'=> Mage::getModel('itactica_orbitslider/slides_attribute_source_fontweight')->getAllOptions(true),
        ));

        $fieldset2->addField('text_for_small', 'textarea', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Text'),
            'name'  => 'text_for_small',
            'note'  => $this->__('Enter slide text (optional)'),
            'style' => 'height: 8em',
        ));

        $fieldset2->addField('text_for_small_color', 'colorpicker', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Text Color'),
            'name'  => 'text_for_small_color',
            'note'  => $this->__('Select font-color'),
        ));

        $fieldset2->addField('text_for_small_size', 'text', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Text Size'),
            'name'  => 'text_for_small_size',
            'note'  => $this->__('Enter font-size in pixels'),
            'class' => 'validate-number',
        ));

        $fieldset2->addField('text_for_small_style', 'select', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Text Style'),
            'name'  => 'text_for_small_style',
            'note'  => $this->__('Select font-style'),
            'values'=> Mage::getModel('itactica_orbitslider/slides_attribute_source_fontstyle')->getAllOptions(true),
        ));

        $fieldset2->addField('text_for_small_weight', 'select', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Text Weight'),
            'name'  => 'text_for_small_weight',
            'note'  => $this->__('Select font-weight'),
            'values'=> Mage::getModel('itactica_orbitslider/slides_attribute_source_fontweight')->getAllOptions(true),
        ));

        $fieldset3 = $form->addFieldset('slide_form3', array('legend'=>Mage::helper('itactica_orbitslider')->__('Button 1')));
        $fieldset3->addType('colorpicker', 'Itactica_OrbitSlider_Block_Adminhtml_Slides_Edit_Form_Renderer_Fieldset_Colorpicker');

        $fieldset3->addField('button_one_text', 'text', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Button 1 - Text'),
            'name'  => 'button_one_text',
            'note'  => $this->__('Enter text for button 1. Leave blank to hide the button'),
        ));

        $fieldset3->addField('button_one_style', 'select', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Button 1 - Style'),
            'name'  => 'button_one_style',
            'note'  => $this->__('Select button style'),
            'values'=> Mage::getModel('itactica_orbitslider/slides_attribute_source_buttonstyle')->getAllOptions(true),
        ));

        $fieldset3->addField('button_one_size', 'select', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Button 1 - Size'),
            'name'  => 'button_one_size',
            'note'  => $this->__('Select button size'),
            'values'=> Mage::getModel('itactica_orbitslider/slides_attribute_source_buttonsize')->getAllOptions(true),
        ));

        $fieldset3->addField('button_one_link', 'text', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Button 1 - Link'),
            'name'  => 'button_one_link',
            'note'  => $this->__('Enter link for button 1. <br>The URL could be relative or absolute:<br>catalog/product1.html<br>http://www.example.com/catalog/product1.html'),
        ));

        $fieldset3->addField('button_one_text_color', 'colorpicker', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Button 1 - Text Color'),
            'name'  => 'button_one_text_color',
            'note'  => $this->__('Select font-color'),
        ));

        $fieldset3->addField('button_one_text_color_hover', 'colorpicker', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Button 1 - Text Color on Hover'),
            'name'  => 'button_one_text_color_hover',
            'note'  => $this->__('Select font-color on hover'),
        ));

        $fieldset3->addField('button_one_background', 'colorpicker', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Button 1 - Background Color'),
            'name'  => 'button_one_background',
            'note'  => $this->__('Select background color'),
        ));

        $fieldset3->addField('button_one_background_hover', 'colorpicker', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Button 1 - Background Color on Hover'),
            'name'  => 'button_one_background_hover',
            'note'  => $this->__('Select background color on hover'),
        ));

        $fieldset4 = $form->addFieldset('slide_form4', array('legend'=>Mage::helper('itactica_orbitslider')->__('Button 2')));
        $fieldset4->addType('colorpicker', 'Itactica_OrbitSlider_Block_Adminhtml_Slides_Edit_Form_Renderer_Fieldset_Colorpicker');

        $fieldset4->addField('button_two_text', 'text', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Button 2 - Text'),
            'name'  => 'button_two_text',
            'note'  => $this->__('Enter text for button 2. Leave blank to hide the button'),
        ));

        $fieldset4->addField('button_two_style', 'select', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Button 2 - Style'),
            'name'  => 'button_two_style',
            'note'  => $this->__('Select button style'),
            'values'=> Mage::getModel('itactica_orbitslider/slides_attribute_source_buttonstyle')->getAllOptions(true),
        ));

        $fieldset4->addField('button_two_size', 'select', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Button 2 - Size'),
            'name'  => 'button_two_size',
            'note'  => $this->__('Select button size'),
            'values'=> Mage::getModel('itactica_orbitslider/slides_attribute_source_buttonsize')->getAllOptions(true),
        ));

        $fieldset4->addField('button_two_link', 'text', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Button 2 - Link'),
            'name'  => 'button_two_link',
            'note'  => $this->__('Enter link for button 2. <br>The URL could be relative or absolute:<br>catalog/product1.html<br>http://www.example.com/catalog/product1.html'),
        ));

        $fieldset4->addField('button_two_text_color', 'colorpicker', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Button 2 - Text Color'),
            'name'  => 'button_two_text_color',
            'note'  => $this->__('Select font-color'),
        ));

        $fieldset4->addField('button_two_text_color_hover', 'colorpicker', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Button 2 - Text Color on Hover'),
            'name'  => 'button_two_text_color_hover',
            'note'  => $this->__('Select font-color on hover'),
        ));

        $fieldset4->addField('button_two_background', 'colorpicker', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Button 2 - Background Color'),
            'name'  => 'button_two_background',
            'note'  => $this->__('Select background color'),
        ));

        $fieldset4->addField('button_two_background_hover', 'colorpicker', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Button 2 - Background Color on Hover'),
            'name'  => 'button_two_background_hover',
            'note'  => $this->__('Select background color on hover'),
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
