<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_CallToAction
 * @copyright   Copyright (c) 2014-2015 Itactica (https://www.getintenso.com)
 * @license     https://getintenso.com/license
 */

class Itactica_CallToAction_Block_Adminhtml_Cta_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     * @access protected
     * @return Itactica_CallToAction_Block_Adminhtml_Cta_Edit_Tab_Form
     */
    protected function _prepareForm(){
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('cta_');
        $form->setFieldNameSuffix('cta');
        $this->setForm($form);
        $fieldset = $form->addFieldset('cta_form', array('legend'=>Mage::helper('itactica_calltoaction')->__('General Information')));
        $fieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('itactica_calltoaction/adminhtml_cta_edit_form_renderer_fieldset_colorpicker'));
        $fieldset->addType('image', Mage::getConfig()->getBlockClassName('itactica_calltoaction/adminhtml_cta_helper_image'));

        $fieldset->addField('title', 'text', array(
            'label' => Mage::helper('itactica_calltoaction')->__('Title'),
            'name'  => 'title',
            'note'  => Mage::helper('itactica_calltoaction')->__('Not visible on frontend. Used for internal reference'),
            'required'  => true,
            'class' => 'required-entry',
        ));

        $fieldset->addField('identifier', 'text', array(
            'label' => Mage::helper('itactica_calltoaction')->__('Identifier'),
            'name'  => 'identifier',
            'note'  => Mage::helper('itactica_calltoaction')->__('For internal use, must be unique. Use only alphanumeric characters, underscores and dashes'),
            'required'  => true,
            'class'     => 'validate-xml-identifier',
            'required' => true,
        ));

        $fieldset->addField('custom_classname', 'text', array(
            'label' => Mage::helper('itactica_calltoaction')->__('Custom Class Name'),
            'name'  => 'custom_classname',
            'note'  => Mage::helper('itactica_calltoaction')->__('Add a custom class name if you wish to further customize the widget style using CSS. Refer to this name on your custom.css file'),
            'class' => 'validate-code',
        ));

        $fieldset->addField('full_width', 'select', array(
            'label' => Mage::helper('itactica_calltoaction')->__('Full Width'),
            'name'  => 'full_width',
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

        $fieldset->addField('columns', 'select', array(
            'label' => Mage::helper('itactica_calltoaction')->__('Columns Ratio'),
            'name'  => 'columns',
            'note'  => Mage::helper('itactica_calltoaction')->__('Left column is used for text and right column for button'),
            'values'=> Mage::getModel('itactica_calltoaction/cta_attribute_source_columns')->getAllOptions(false),
        ));

        $fieldset->addField('background_color', 'colorpicker', array(
            'label' => Mage::helper('itactica_calltoaction')->__('Background Color'),
            'name'  => 'background_color',
            'note'  => $this->__('Select background color for the entire section'),
        ));

        $fieldset->addField('background_image', 'image', array(
            'label' => Mage::helper('itactica_calltoaction')->__('Background Image'),
            'name'  => 'background_image',
            'note'  => Mage::helper('itactica_calltoaction')->__('Recommended image width: 1920px'),
        ));

        $fieldset->addField('margin_top', 'text', array(
            'label' => Mage::helper('itactica_calltoaction')->__('Margin Top'),
            'name'  => 'margin_top',
            'note'  => Mage::helper('itactica_calltoaction')->__('If you want to set your own margin, enter it here (e.g. 50). This is the space in pixels at the top of this widget'),
            'class' => 'validate-number',
        ));

        $fieldset->addField('margin_bottom', 'text', array(
            'label' => Mage::helper('itactica_calltoaction')->__('Margin Bottom'),
            'name'  => 'margin_bottom',
            'note'  => Mage::helper('itactica_calltoaction')->__('If you want to set your own margin, enter it here (e.g. 50). This is the space in pixels at the bottom of this widget'),
            'class' => 'validate-number',
        ));

        $fieldset->addField('text', 'textarea', array(
            'label' => Mage::helper('itactica_calltoaction')->__('Text'),
            'name'  => 'text',
            'style' => 'height: 8em',
        ));

        $fieldset->addField('text_color', 'colorpicker', array(
            'label' => Mage::helper('itactica_calltoaction')->__('Text Color'),
            'name'  => 'text_color',
            'note'  => $this->__('Select font-color'),
        ));

        $fieldset->addField('font_size', 'text', array(
            'label' => Mage::helper('itactica_calltoaction')->__('Text Size'),
            'name'  => 'font_size',
            'note'  => $this->__('Enter font-size in pixels (e.g. 16)'),
            'class' => 'validate-number',
        ));

        $fieldset->addField('font_style', 'select', array(
            'label' => Mage::helper('itactica_calltoaction')->__('Title Style'),
            'name'  => 'font_style',
            'note'  => $this->__('Select font-style'),
            'values'=> Mage::getModel('itactica_calltoaction/cta_attribute_source_fontstyle')->getAllOptions(false),
        ));

        $fieldset->addField('font_weight', 'select', array(
            'label' => Mage::helper('itactica_calltoaction')->__('Title Weight'),
            'name'  => 'font_weight',
            'note'  => $this->__('Select font-weight'),
            'values'=> Mage::getModel('itactica_calltoaction/cta_attribute_source_fontweight')->getAllOptions(false),
        ));

        $fieldset->addField('text_lineheight', 'text', array(
            'label' => Mage::helper('itactica_calltoaction')->__('Text Line Height'),
            'name'  => 'text_lineheight',
            'note'  => $this->__('Enter line-height in pixels (e.g. 24)'),
            'class' => 'validate-number',
        ));

        $buttonType = $fieldset->addField('button_type', 'select', array(
            'label' => Mage::helper('itactica_calltoaction')->__('Button Type'),
            'name'  => 'button_type',
            'values'=> Mage::getModel('itactica_calltoaction/cta_attribute_source_buttontype')->getAllOptions(false),
        ));

        $buttonText = $fieldset->addField('button_text', 'text', array(
            'label' => Mage::helper('itactica_calltoaction')->__('Button Text'),
            'name'  => 'button_text',
        ));

        $link = $fieldset->addField('link', 'text', array(
            'label' => Mage::helper('itactica_calltoaction')->__('Link'),
            'name'  => 'link',
            'note'  => $this->__('URL to redirect when button is clicked. Could be an absolute or relative path'),
        ));

        $linkTarget = $fieldset->addField('link_target', 'select', array(
            'label' => Mage::helper('itactica_calltoaction')->__('Link Target'),
            'name'  => 'link_target',
            'note'  => $this->__('Select font-weight'),
            'values'=> Mage::getModel('itactica_calltoaction/cta_attribute_source_linktarget')->getAllOptions(false),
        ));

        $buttonTextColor = $fieldset->addField('button_text_color', 'colorpicker', array(
            'label' => Mage::helper('itactica_calltoaction')->__('Button Text Color'),
            'name'  => 'button_text_color',
            'note'  => $this->__('Select font-color'),
        ));

        $buttonTextColorHover = $fieldset->addField('button_text_color_hover', 'colorpicker', array(
            'label' => Mage::helper('itactica_calltoaction')->__('Button Text Color on Hover'),
            'name'  => 'button_text_color_hover',
            'note'  => $this->__('Select font-color on hover'),
        ));

        $buttonBgColor = $fieldset->addField('button_background_color', 'colorpicker', array(
            'label' => Mage::helper('itactica_calltoaction')->__('Button Background Color'),
            'name'  => 'button_background_color',
            'note'  => $this->__('Select background-color'),
        ));

        $buttonBgColorHover = $fieldset->addField('button_background_color_hover', 'colorpicker', array(
            'label' => Mage::helper('itactica_calltoaction')->__('Button Background Color on Hover'),
            'name'  => 'button_background_color_hover',
            'note'  => $this->__('Select background-color on hover'),
        ));

        $ghostBorderColor = $fieldset->addField('button_border_color', 'colorpicker', array(
            'label' => Mage::helper('itactica_calltoaction')->__('Button Border Color'),
            'name'  => 'button_border_color',
            'note'  => $this->__('Select border-color'),
        ));

        $ghostBorderColorHover = $fieldset->addField('button_border_color_hover', 'colorpicker', array(
            'label' => Mage::helper('itactica_calltoaction')->__('Button Border Color on Hover'),
            'name'  => 'button_border_color_hover',
            'note'  => $this->__('Select border-color on hover'),
        ));

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('itactica_calltoaction')->__('Status'),
            'name'  => 'status',
            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('itactica_calltoaction')->__('Enabled'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('itactica_calltoaction')->__('Disabled'),
                ),
            ),
        ));
        if (Mage::app()->isSingleStoreMode()){
            $fieldset->addField('store_id', 'hidden', array(
                'name'      => 'stores[]',
                'value'     => Mage::app()->getStore(true)->getId()
            ));
            Mage::registry('current_calltoaction')->setStoreId(Mage::app()->getStore(true)->getId());
        }

        $this->setChild('form_after',$this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')
            ->addFieldMap($buttonType->getHtmlId(),$buttonType->getName())
            ->addFieldMap($link->getHtmlId(),$link->getName())
            ->addFieldMap($buttonType->getHtmlId(),$buttonType->getName())
            ->addFieldMap($buttonText->getHtmlId(),$buttonText->getName())
            ->addFieldMap($buttonType->getHtmlId(),$buttonType->getName())
            ->addFieldMap($linkTarget->getHtmlId(),$linkTarget->getName())
            ->addFieldMap($buttonType->getHtmlId(),$buttonType->getName())
            ->addFieldMap($buttonTextColor->getHtmlId(),$buttonTextColor->getName())
            ->addFieldMap($buttonType->getHtmlId(),$buttonType->getName())
            ->addFieldMap($buttonTextColorHover->getHtmlId(),$buttonTextColorHover->getName())
            ->addFieldMap($buttonType->getHtmlId(),$buttonType->getName())
            ->addFieldMap($buttonBgColor->getHtmlId(),$buttonBgColor->getName())
            ->addFieldMap($buttonType->getHtmlId(),$buttonType->getName())
            ->addFieldMap($buttonBgColorHover->getHtmlId(),$buttonBgColorHover->getName())
            ->addFieldMap($buttonType->getHtmlId(),$buttonType->getName())
            ->addFieldMap($ghostBorderColor->getHtmlId(),$ghostBorderColor->getName())
            ->addFieldMap($buttonType->getHtmlId(),$buttonType->getName())
            ->addFieldMap($ghostBorderColorHover->getHtmlId(),$ghostBorderColorHover->getName())
            ->addFieldDependence($link->getName(),$buttonType->getName(),array('button tiny','button small','button','button large','button ghost tiny','button ghost small','button ghost','button ghost large'))
            ->addFieldDependence($buttonText->getName(),$buttonType->getName(),array('button tiny','button small','button','button large','button ghost tiny','button ghost small','button ghost','button ghost large'))
            ->addFieldDependence($linkTarget->getName(),$buttonType->getName(),array('button tiny','button small','button','button large','button ghost tiny','button ghost small','button ghost','button ghost large'))
            ->addFieldDependence($buttonTextColor->getName(),$buttonType->getName(),array('button tiny','button small','button','button large','button ghost tiny','button ghost small','button ghost','button ghost large'))
            ->addFieldDependence($buttonTextColorHover->getName(),$buttonType->getName(),array('button tiny','button small','button','button large','button ghost tiny','button ghost small','button ghost','button ghost large'))
            ->addFieldDependence($buttonBgColor->getName(),$buttonType->getName(),array('button tiny','button small','button','button large'))
            ->addFieldDependence($buttonBgColorHover->getName(),$buttonType->getName(),array('button tiny','button small','button','button large','button ghost tiny','button ghost small','button ghost','button ghost large'))
            ->addFieldDependence($ghostBorderColor->getName(),$buttonType->getName(),array('button ghost tiny','button ghost small','button ghost','button ghost large'))
            ->addFieldDependence($ghostBorderColorHover->getName(),$buttonType->getName(),array('button ghost tiny','button ghost small','button ghost','button ghost large')));

        $formValues = Mage::registry('current_calltoaction')->getDefaultValues();
        if (!is_array($formValues)){
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getCallToActionData()){
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getCallToActionData());
            Mage::getSingleton('adminhtml/session')->setCallToActionData(null);
        }
        elseif (Mage::registry('current_calltoaction')){
            $formValues = array_merge($formValues, Mage::registry('current_calltoaction')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
