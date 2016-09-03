<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_Billboard
 * @copyright   Copyright (c) 2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_Billboard_Block_Adminhtml_Unit_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     * @access protected
     * @return Itactica_Billboard_Block_Adminhtml_Unit_Edit_Tab_Form
     */
    protected function _prepareForm(){
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('unit_');
        $form->setFieldNameSuffix('unit');
        $this->setForm($form);
        $fieldset = $form->addFieldset('unit_form', array('legend'=>Mage::helper('itactica_billboard')->__('General Information')));
        $fieldset->addType('colorpicker', Mage::getConfig()->getBlockClassName('itactica_billboard/adminhtml_unit_edit_form_renderer_fieldset_colorpicker'));

        $fieldset->addField('title', 'text', array(
            'label' => Mage::helper('itactica_billboard')->__('Title'),
            'name'  => 'title',
            'note'  => Mage::helper('itactica_billboard')->__('Not visible on frontend. Used for internal reference'),
            'required'  => true,
            'class' => 'required-entry',
        ));

        $fieldset->addField('identifier', 'text', array(
            'label' => Mage::helper('itactica_billboard')->__('Identifier'),
            'name'  => 'identifier',
            'note'  => Mage::helper('itactica_billboard')->__('For internal use, must be unique. Use only alphanumeric characters, underscores and dashes'),
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

        $fieldset->addField('columns', 'select', array(
            'label' => Mage::helper('itactica_billboard')->__('Number of Columns'),
            'name'  => 'columns',
            'note'	=> Mage::helper('itactica_billboard')->__('Set the number of images in a row'),
            'values'=> Mage::getModel('itactica_billboard/unit_attribute_source_columns')->getAllOptions(false),
            'after_element_html' =>
                '<script type="text/javascript">
                    checkColumns = function() {
                        columns = $("unit_columns").getValue();
                        for (var i = 1; i < 5; i++) {
                            if (i <= columns) {
                                $("unit_unit_form"+(i+1)).show();
                                $("unit_unit_form"+(i+1)).previous(".entry-edit-head").show();
                            } else {
                                $("unit_unit_form"+(i+1)).hide();
                                $("unit_unit_form"+(i+1)).previous(".entry-edit-head").hide();
                            }
                        }
                    }
                    Event.observe(window, "load", function() {
                        Event.observe("unit_columns", "change", checkColumns);
                        checkColumns();
                    })
                </script>',
        ));

        $fieldset->addField('billboard_type', 'select', array(
            'label' => Mage::helper('itactica_billboard')->__('Billboard Type'),
            'name'  => 'billboard_type',
            'values'=> Mage::getModel('itactica_billboard/unit_attribute_source_billboardtype')->getAllOptions(false),
        ));

        $fieldset->addField('image_options_small', 'select', array(
            'label' => Mage::helper('itactica_billboard')->__('Image Options for Small Screens'),
            'name'  => 'image_options_small',
            'note'  => $this->__('Select how images are shown on small screen devices'),
            'values'=> Mage::getModel('itactica_billboard/unit_attribute_source_imageoptionsforsmall')->getAllOptions(false),
        ));

        $imageOptionsMedium = $fieldset->addField('image_options_medium', 'select', array(
            'label' => Mage::helper('itactica_billboard')->__('Image Options for Medium Screens'),
            'name'  => 'image_options_medium',
            'note'  => $this->__('Select how images are shown on medium screen devices'),
            'values'=> Mage::getModel('itactica_billboard/unit_attribute_source_imageoptionsformedium')->getAllOptions(false),
        ));

        $imagesToShow = $fieldset->addField('images_to_show', 'multiselect', array(
            'label' => Mage::helper('itactica_featuredproducts')->__('Specific Images for Medium Screens'),
            'name'  => 'images_to_show',
            'note'  => $this->__('Select one or more images to be shown on medium screens (Hold Ctrl+click to select multiple images)'),
            'values' => Mage::getModel('itactica_billboard/unit_attribute_source_images')->getAllOptions(false),
        ));

        $fieldset->addField('background_color', 'colorpicker', array(
            'label' => Mage::helper('itactica_billboard')->__('Background Color'),
            'name'  => 'background_color',
            'note'  => $this->__('Select background color for the entire section'),
        ));

        $fieldset->addField('padding_top', 'text', array(
            'label' => Mage::helper('itactica_billboard')->__('Padding Top'),
            'name'  => 'padding_top',
            'note'  => Mage::helper('itactica_billboard')->__('If you want to set your own padding, enter it here (e.g. 50). This is the space in pixels at the top of the images'),
            'class' => 'validate-number',
        ));

        $fieldset->addField('padding_bottom', 'text', array(
            'label' => Mage::helper('itactica_billboard')->__('Padding Bottom'),
            'name'  => 'padding_bottom',
            'note'  => Mage::helper('itactica_billboard')->__('If you want to set your own padding, enter it here (e.g. 50). This is the space in pixels at the bottom of the images'),
            'class' => 'validate-number',
        ));

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('itactica_billboard')->__('Status'),
            'name'  => 'status',
            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('itactica_billboard')->__('Enabled'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('itactica_billboard')->__('Disabled'),
                ),
            ),
        ));
        if (Mage::app()->isSingleStoreMode()){
            $fieldset->addField('store_id', 'hidden', array(
                'name'      => 'stores[]',
                'value'     => Mage::app()->getStore(true)->getId()
            ));
            Mage::registry('current_billboard')->setStoreId(Mage::app()->getStore(true)->getId());
        }

        $fieldset2 = $form->addFieldset('unit_form2', array('legend'=>Mage::helper('itactica_billboard')->__('Image #1')));
        $fieldset2->addType('image', Mage::getConfig()->getBlockClassName('itactica_billboard/adminhtml_unit_helper_image'));

        $fieldset2->addField('image_large_first', 'image', array(
            'label' => Mage::helper('itactica_billboard')->__('Image for Large Screens'),
            'name'  => 'image_large_first',
            'note'  => Mage::helper('itactica_billboard')->__('Recommended image width: 1067px'),
        ));

        $fieldset2->addField('image_medium_first', 'image', array(
            'label' => Mage::helper('itactica_billboard')->__('Optimized Image for Medium and Small Screens'),
            'name'  => 'image_medium_first',
            'note'  => Mage::helper('itactica_billboard')->__('Recommended image width: 640px'),
        ));

        $fieldset2->addField('alt_first', 'text', array(
            'label' => Mage::helper('itactica_billboard')->__('Alt Attribute Text'),
            'name'  => 'alt_first',
            'note'  => Mage::helper('itactica_billboard')->__('Enter an alternate text for the image'),
        ));

        $fieldset2->addField('link_first', 'text', array(
            'label' => Mage::helper('itactica_billboard')->__('Link'),
            'name'  => 'link_first',
            'note'  => $this->__('URL to redirect when image is clicked. Could be an absolute or relative path. Leave empty for no link'),
        ));


        $fieldset3 = $form->addFieldset('unit_form3', array('legend'=>Mage::helper('itactica_billboard')->__('Image #2')));
        $fieldset3->addType('image', Mage::getConfig()->getBlockClassName('itactica_billboard/adminhtml_unit_helper_image'));

        $fieldset3->addField('image_large_second', 'image', array(
            'label' => Mage::helper('itactica_billboard')->__('Image for Large Screens'),
            'name'  => 'image_large_second',
            'note'  => Mage::helper('itactica_billboard')->__('Recommended image width: 1067px'),
        ));

        $fieldset3->addField('image_medium_second', 'image', array(
            'label' => Mage::helper('itactica_billboard')->__('Optimized Image for Medium and Small Screens'),
            'name'  => 'image_medium_second',
            'note'  => Mage::helper('itactica_billboard')->__('Recommended image width: 640px'),
        ));

        $fieldset3->addField('alt_second', 'text', array(
            'label' => Mage::helper('itactica_billboard')->__('Alt Attribute Text'),
            'name'  => 'alt_second',
            'note'  => Mage::helper('itactica_billboard')->__('Enter an alternate text for the image'),
        ));

        $fieldset3->addField('link_second', 'text', array(
            'label' => Mage::helper('itactica_billboard')->__('Link'),
            'name'  => 'link_second',
            'note'  => $this->__('URL to redirect when image is clicked. Could be an absolute or relative path. Leave empty for no link'),
        ));

        $fieldset4 = $form->addFieldset('unit_form4', array('legend'=>Mage::helper('itactica_billboard')->__('Image #3')));
        $fieldset4->addType('image', Mage::getConfig()->getBlockClassName('itactica_billboard/adminhtml_unit_helper_image'));

        $fieldset4->addField('image_large_third', 'image', array(
            'label' => Mage::helper('itactica_billboard')->__('Image for Large Screens'),
            'name'  => 'image_large_third',
            'note'  => Mage::helper('itactica_billboard')->__('Recommended image width: 1067px'),
        ));

        $fieldset4->addField('image_medium_third', 'image', array(
            'label' => Mage::helper('itactica_billboard')->__('Optimized Image for Medium and Small Screens'),
            'name'  => 'image_medium_third',
            'note'  => Mage::helper('itactica_billboard')->__('Recommended image width: 640px'),
        ));

        $fieldset4->addField('alt_third', 'text', array(
            'label' => Mage::helper('itactica_billboard')->__('Alt Attribute Text'),
            'name'  => 'alt_third',
            'note'  => Mage::helper('itactica_billboard')->__('Enter an alternate text for the image'),
        ));

        $fieldset4->addField('link_third', 'text', array(
            'label' => Mage::helper('itactica_billboard')->__('Link'),
            'name'  => 'link_third',
            'note'  => $this->__('URL to redirect when image is clicked. Could be an absolute or relative path. Leave empty for no link'),
        ));

        $fieldset5 = $form->addFieldset('unit_form5', array('legend'=>Mage::helper('itactica_billboard')->__('Image #4')));
        $fieldset5->addType('image', Mage::getConfig()->getBlockClassName('itactica_billboard/adminhtml_unit_helper_image'));

        $fieldset5->addField('image_large_fourth', 'image', array(
            'label' => Mage::helper('itactica_billboard')->__('Image for Large Screens'),
            'name'  => 'image_large_fourth',
            'note'  => Mage::helper('itactica_billboard')->__('Recommended image width: 1067px'),
        ));

        $fieldset5->addField('image_medium_fourth', 'image', array(
            'label' => Mage::helper('itactica_billboard')->__('Optimized Image for Medium and Small Screens'),
            'name'  => 'image_medium_fourth',
            'note'  => Mage::helper('itactica_billboard')->__('Recommended image width: 640px'),
        ));

        $fieldset5->addField('alt_fourth', 'text', array(
            'label' => Mage::helper('itactica_billboard')->__('Alt Attribute Text'),
            'name'  => 'alt_fourth',
            'note'  => Mage::helper('itactica_billboard')->__('Enter an alternate text for the image'),
        ));

        $fieldset5->addField('link_fourth', 'text', array(
            'label' => Mage::helper('itactica_billboard')->__('Link'),
            'name'  => 'link_fourth',
            'note'  => $this->__('URL to redirect when image is clicked. Could be an absolute or relative path. Leave empty for no link'),
        ));

        $this->setChild('form_after',$this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')
            ->addFieldMap($imageOptionsMedium->getHtmlId(),$imageOptionsMedium->getName())
            ->addFieldMap($imagesToShow->getHtmlId(),$imagesToShow->getName())
            ->addFieldDependence($imagesToShow->getName(),$imageOptionsMedium->getName(),'2'));

        $formValues = Mage::registry('current_billboard')->getDefaultValues();
        if (!is_array($formValues)){
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getBillboardData()){
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getBillboardData());
            Mage::getSingleton('adminhtml/session')->setBillboardData(null);
        }
        elseif (Mage::registry('current_billboard')){
            $formValues = array_merge($formValues, Mage::registry('current_billboard')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
