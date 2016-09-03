<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_LogoSlider
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_LogoSlider_Block_Adminhtml_Slider_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     * @access protected
     * @return LogoSlider_Slider_Block_Adminhtml_Slider_Edit_Tab_Form
     */
    protected function _prepareForm(){
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('slider_');
        $form->setFieldNameSuffix('slider');
        $this->setForm($form);
        $fieldset = $form->addFieldset('slider_form', array('legend'=>Mage::helper('itactica_logoslider')->__('Slider')));

        $fieldset->addField('title', 'text', array(
            'label' => Mage::helper('itactica_logoslider')->__('Title'),
            'name'  => 'title',
            'note'	=> $this->__('Title of the slider'),
            'required'  => true,
            'class' => 'required-entry',

        ));

        $fieldset->addField('identifier', 'text', array(
            'label' => Mage::helper('itactica_logoslider')->__('Identifier'),
            'name'  => 'identifier',
            'note'	=> $this->__('For internal use, must be unique. Use only alphanumeric characters, underscores and dashes'),
            'required'  => true,
            'class' => 'validate-xml-identifier',
            'required' => true,
        ));

        $fieldset->addField('min_item_width', 'text', array(
            'label' => Mage::helper('itactica_logoslider')->__('Minimum Width'),
            'name'  => 'min_item_width',
            'note'	=> $this->__('Minimum width in pixels for each logo'),
            'required'  => true,
            'class' => 'validate-number',
            'required' => true,
        ));

        $fieldset->addField('animation_speed', 'text', array(
            'label' => Mage::helper('itactica_logoslider')->__('Animation Speed'),
            'name'  => 'animation_speed',
            'note'	=> $this->__('Sets the amount of time in milliseconds the transition between logos will last. Note that 1000 miliseconds = 1 second'),
            'required'  => true,
            'class' => 'validate-number',
            'required' => true,
        ));

        $fieldset->addField('show_bullets', 'select', array(
            'label' => Mage::helper('itactica_logoslider')->__('Show Navigation Bullets'),
            'name'  => 'show_bullets',
            'required'  => true,
            'class' => 'required-entry',
            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('itactica_logoslider')->__('Yes'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('itactica_logoslider')->__('No'),
                ),
            ),
        ));

        $fieldset->addField('show_arrows', 'select', array(
            'label' => Mage::helper('itactica_logoslider')->__('Show Navigation Arrows'),
            'name'  => 'show_arrows',
            'required'  => true,
            'class' => 'required-entry',
            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('itactica_logoslider')->__('Yes'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('itactica_logoslider')->__('No'),
                ),
            ),
        ));

        $fieldset->addField('swipe', 'select', array(
            'label' => Mage::helper('itactica_logoslider')->__('Touch Swipe'),
            'name'  => 'swipe',
            'note'	=> $this->__('Allow touch swipe navigation of the slider on touch-enabled devices'),
            'required'  => true,
            'class' => 'required-entry',
            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('itactica_logoslider')->__('Yes'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('itactica_logoslider')->__('No'),
                ),
            ),
        ));

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('itactica_logoslider')->__('Status'),
            'name'  => 'status',
            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('itactica_logoslider')->__('Enabled'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('itactica_logoslider')->__('Disabled'),
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
