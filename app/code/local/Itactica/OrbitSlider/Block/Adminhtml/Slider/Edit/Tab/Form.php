<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_OrbitSlider
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_OrbitSlider_Block_Adminhtml_Slider_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
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
        $fieldset = $form->addFieldset('slider_form', array('legend'=>Mage::helper('itactica_orbitslider')->__('Settings')));

        $fieldset->addField('title', 'text', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Title'),
            'name'  => 'title',
            'required'  => true,
            'class' => 'required-entry',

        ));

        $fieldset->addField('identifier', 'text', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Identifier'),
            'name'  => 'identifier',
            'note'  => $this->__('For internal use, must be unique. Use only alphanumeric characters, underscores and dashes'),
            'required'  => true,
            'class'     => 'validate-xml-identifier',
            'required' => true,

        ));

        $fieldset->addField('custom_classname', 'text', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Custom Class Name'),
            'name'  => 'custom_classname',
            'note'  => Mage::helper('itactica_orbitslider')->__('Add a custom class name if you wish to further customize the widget style using CSS. Refer to this name on your custom.css file'),
            'class' => 'validate-code',
        ));

        $fieldset->addField('full_screen', 'select', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Full Screen'),
            'name'  => 'full_screen',
            'note'  => $this->__('If Yes, images will be resized to fit the entire screen on medium and large devices.'),
            'required'  => true,
            'class' => 'required-entry',

            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('itactica_orbitslider')->__('Yes'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('itactica_orbitslider')->__('No'),
                ),
            ),
        ));

        $fieldset->addField('animation_type', 'select', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Animation Type'),
            'name'  => 'animation_type',
            'required'  => true,
            'class' => 'required-entry',

            'values'=> Mage::getModel('itactica_orbitslider/slider_attribute_source_animationtype')->getAllOptions(true),
        ));

        $fieldset->addField('animation_speed', 'text', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Animation Speed'),
            'name'  => 'animation_speed',
            'note'	=> $this->__('Sets the amount of time in milliseconds the transition between slides will last. Note that 1000 miliseconds = 1 second.'),
            'required'  => true,
            'class'     => 'validate-number',
            'required' => true,

        ));

        $fieldset->addField('timer_speed', 'text', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Timer Speed'),
            'name'  => 'timer_speed',
            'note'	=> $this->__('Sets the amount of time in milliseconds before transitioning a slide.'),
            'required'  => true,
            'class'     => 'validate-number',
            'required'  => true,

        ));

        $fieldset->addField('pause_on_hover', 'select', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Pause on Hover'),
            'name'  => 'pause_on_hover',
            'note'	=> $this->__('If Yes, pauses on the current slide while hovering.'),
            'required'  => true,
            'class' => 'required-entry',

            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('itactica_orbitslider')->__('Yes'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('itactica_orbitslider')->__('No'),
                ),
            ),
        ));

        $fieldset->addField('circular', 'select', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Loop'),
            'name'  => 'circular',
            'note'	=> $this->__('If Yes, the slider will go to the first slide after showing the last.'),
            'required'  => true,
            'class' => 'required-entry',

            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('itactica_orbitslider')->__('Yes'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('itactica_orbitslider')->__('No'),
                ),
            ),
        ));

        $fieldset->addField('swipe', 'select', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Touch Swipe'),
            'name'  => 'swipe',
            'note'	=> $this->__('Allow touch swipe navigation of the slider on touch-enabled devices.'),
            'required'  => true,
            'class' => 'required-entry',

            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('itactica_orbitslider')->__('Yes'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('itactica_orbitslider')->__('No'),
                ),
            ),
        ));

        $fieldset->addField('use_advanced', 'select', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Enable Advanced Mode'),
            'name'  => 'use_advanced',
            'note'  => $this->__('When advanced mode is enabled, you can enter your own HTML and inline-CSS content for each slide on the Advanced tab.'),
            'required'  => true,
            'class' => 'required-entry',

            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('itactica_orbitslider')->__('Yes'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('itactica_orbitslider')->__('No'),
                ),
            ),
        ));

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Status'),
            'name'  => 'status',
            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('itactica_orbitslider')->__('Enabled'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('itactica_orbitslider')->__('Disabled'),
                ),
            ),
        ));
        if (Mage::app()->isSingleStoreMode()){
            $fieldset->addField('store_id', 'hidden', array(
                'name'      => 'stores[]',
                'value'     => Mage::app()->getStore(true)->getId()
            ));
            Mage::registry('current_slider')->setStoreId(Mage::app()->getStore(true)->getId());
        }
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
