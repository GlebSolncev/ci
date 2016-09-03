<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_OrbitSlider
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_OrbitSlider_Block_Adminhtml_Slider_Edit_Tab_Content extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     * @access protected
     * @return OrbitSlider_Slider_Block_Adminhtml_Slider_Edit_Tab_Form
     */
    protected function _prepareForm(){
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('slider_');
        $form->setFieldNameSuffix('slider');
        $this->setForm($form);
        $fieldset = $form->addFieldset('slider_form', array(
            'legend'=>Mage::helper('itactica_orbitslider')->__('Advanced'),
            'class'     => 'fieldset-wide'
        ));
        $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();

        $fieldset->addField('content', 'editor', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Custom Content'),
            'name'  => 'content',
            'style'  => 'width:100%;height:400px;',
            'config' => $wysiwygConfig,
            'note'	=> $this->__('Insert here list tags with the content of each slide. Please refer to the User Manual for more information and examples.'),
        ));

        $formValues = Mage::registry('current_slider')->getDefaultValues();
        if (!is_array($formValues)){
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getSliderData()){
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getSliderData());
            Mage::getSingleton('adminhtml/session')->setSliderData(null);
        }
        elseif (Mage::registry('current_slider')){
            $formValues = array_merge($formValues, Mage::registry('current_slider')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
