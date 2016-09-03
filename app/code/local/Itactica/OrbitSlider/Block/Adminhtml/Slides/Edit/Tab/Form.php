<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_OrbitSlider
 * @copyright   Copyright (c) 2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_OrbitSlider_Block_Adminhtml_Slides_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
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
        $fieldset = $form->addFieldset('slide_form', array('legend'=>Mage::helper('itactica_orbitslider')->__('Slides')));
        $fieldset->addType('image', Mage::getConfig()->getBlockClassName('itactica_orbitslider/adminhtml_slides_helper_image'));

        $fieldset->addField('title', 'text', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Name'),
            'name'  => 'title',
            'note'  => $this->__('Enter a name for the slide. Just for internal reference'),
            'required'  => true,
            'class' => 'required-entry',
        ));

        $fieldset->addField('navigation_skin', 'select', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Navigation Skin'),
            'name'  => 'navigation_skin',
            'note'  => $this->__('Navigation skin will be applied when this slide is in focus. Use "Dark" for images with a dark background and "Light" for images with lighter backgrounds. Navigation bullets will be rendered in a contrasting color'),
            'required'  => true,
            'class' => 'required-entry',
            'values'=> Mage::getModel('itactica_orbitslider/slides_attribute_source_navigationskin')->getAllOptions(true),
        ));

        $textBlockAlignment = $fieldset->addField('text_block_alignment', 'select', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Text Block Horizontal Alignment'),
            'name'  => 'text_block_alignment',
            'note'  => $this->__('Choose horizontal alignment for text block'),
            'required'  => true,
            'class' => 'required-entry',
            'values'=> Mage::getModel('itactica_orbitslider/slides_attribute_source_blockalignment')->getAllOptions(true),
        ));

        $customAlignment = $fieldset->addField('custom_alignment', 'text', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Margin-left'),
            'name'  => 'custom_alignment',
            'note'  => $this->__('Enter margin-left value in percentage (0-99). The block of text will be aligned at the specified distance from the left of the screen (only on medium and large screens)'),
            'required'  => true,
            'class' => 'required-entry validate-digits validate-digits-range digits-range-0-99',
        ));

        $textBlockVerticalAlignment = $fieldset->addField('vertical_alignment', 'select', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Text Block Vertical Alignment'),
            'name'  => 'vertical_alignment',
            'note'  => $this->__('Choose vertical alignment for text block'),
            'required'  => true,
            'class' => 'required-entry',
            'values'=> Mage::getModel('itactica_orbitslider/slides_attribute_source_blockverticalalignment')->getAllOptions(true),
        ));

        $customVerticalAlignment = $fieldset->addField('text_block_top', 'text', array(
            'label' => Mage::helper('itactica_orbitslider')->__('Distance from Top'),
            'name'  => 'text_block_top',
            'note'  => $this->__('Distance from the top of the slide to text box in pixels or percentage (e.g 50px or 20%). This setting apply only on medium and large screens)'),
            'required'  => true,
            'class' => 'required-entry',
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

        $this->setChild('form_after',$this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')
            ->addFieldMap($textBlockAlignment->getHtmlId(),$textBlockAlignment->getName())
            ->addFieldMap($customAlignment->getHtmlId(),$customAlignment->getName())
            ->addFieldDependence($customAlignment->getName(),$textBlockAlignment->getName(),'custom')
            ->addFieldMap($textBlockVerticalAlignment->getHtmlId(),$textBlockVerticalAlignment->getName())
            ->addFieldMap($customVerticalAlignment->getHtmlId(),$customVerticalAlignment->getName())
            ->addFieldDependence($customVerticalAlignment->getName(),$textBlockVerticalAlignment->getName(),'1'));

        

        if (Mage::app()->isSingleStoreMode()){
            $fieldset->addField('store_id', 'hidden', array(
                'name'      => 'stores[]',
                'value'     => Mage::app()->getStore(true)->getId()
            ));
            Mage::registry('current_slide')->setStoreId(Mage::app()->getStore(true)->getId());
        }
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
