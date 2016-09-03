<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_FeaturedCategories
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_FeaturedCategories_Block_Adminhtml_Slider_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     * @access protected
     * @return FeaturedCategories_Slider_Block_Adminhtml_Slider_Edit_Tab_Form
     */
    protected function _prepareForm(){
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('slider_');
        $form->setFieldNameSuffix('slider');
        $this->setForm($form);
        $fieldset = $form->addFieldset('slider_form', array('legend'=>Mage::helper('itactica_featuredcategories')->__('General Information')));

        $fieldset->addField('title', 'text', array(
            'label' => Mage::helper('itactica_featuredcategories')->__('Title'),
            'name'  => 'title',
            'note'  => $this->__('This is the title shown above the widget on frontend'),
            'required'  => true,
            'class' => 'required-entry',

        ));

        $fieldset->addField('identifier', 'text', array(
            'label' => Mage::helper('itactica_featuredcategories')->__('Identifier'),
            'name'  => 'identifier',
            'note'  => $this->__('For internal use, must be unique. Use only alphanumeric characters, underscores and dashes'),
            'class'     => 'validate-xml-identifier',
            'required' => true,

        ));

        $fieldset->addField('animation_speed', 'text', array(
            'label' => Mage::helper('itactica_featuredcategories')->__('Animation Speed'),
            'name'  => 'animation_speed',
            'note'	=> $this->__('Sets the amount of time in milliseconds the transition between categories will last. Note that 1000 miliseconds = 1 second'),
            'class'     => 'validate-number',
            'required' => true,

        ));

        $fieldset->addField('minimum_width', 'text', array(
            'label' => Mage::helper('itactica_featuredcategories')->__('Minimum Width'),
            'name'  => 'minimum_width',
            'note'	=> $this->__('Minimum width in pixels of each category box'),
            'class'     => 'validate-number',
            'required' => true,

        ));

        $fieldset->addField('swipe', 'select', array(
            'label' => Mage::helper('itactica_featuredcategories')->__('Touch Swipe'),
            'name'  => 'swipe',
            'note'	=> $this->__('Allow touch swipe navigation of the slider on touch-enabled devices'),
            'required'  => true,
            'class' => 'required-entry',
            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('itactica_featuredcategories')->__('Yes'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('itactica_featuredcategories')->__('No'),
                ),
            ),
        ));

        $fieldset->addField('position', 'text', array(
            'label' => Mage::helper('itactica_featuredcategories')->__('Position'),
            'name'  => 'position',
            'required'  => false,
            'class'     => 'validate-number',

        ));

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('itactica_featuredcategories')->__('Status'),
            'name'  => 'status',
            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('itactica_featuredcategories')->__('Enabled'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('itactica_featuredcategories')->__('Disabled'),
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
