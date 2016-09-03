<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_TextBoxes
 * @copyright   Copyright (c) 2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_TextBoxes_Block_Adminhtml_Box_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     * @access protected
     * @return Itactica_TextBoxes_Block_Adminhtml_Box_Edit_Tab_Form
     */
    protected function _prepareForm(){
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('box_');
        $form->setFieldNameSuffix('box');
        $this->setForm($form);
        $fieldset = $form->addFieldset('box_form', array('legend'=>Mage::helper('itactica_textboxes')->__('General Information')));
        $fieldset->addType('colorpicker', 'Itactica_TextBoxes_Block_Adminhtml_Box_Edit_Form_Renderer_Fieldset_Colorpicker');

        $fieldset->addField('title', 'text', array(
            'label' => Mage::helper('itactica_textboxes')->__('Title'),
            'name'  => 'title',
            'note'  => Mage::helper('itactica_textboxes')->__('Not visible on frontend. Used for internal reference'),
            'required'  => true,
            'class' => 'required-entry',
        ));

        $fieldset->addField('identifier', 'text', array(
            'label' => Mage::helper('itactica_textboxes')->__('Identifier'),
            'name'  => 'identifier',
            'note'  => Mage::helper('itactica_textboxes')->__('For internal use, must be unique. Use only alphanumeric characters, underscores and dashes'),
            'required'  => true,
            'class'     => 'validate-xml-identifier',
            'required' => true,
        ));

        $fieldset->addField('custom_classname', 'text', array(
            'label' => Mage::helper('itactica_textboxes')->__('Custom Class Name'),
            'name'  => 'custom_classname',
            'note'  => Mage::helper('itactica_textboxes')->__('Add a custom class name if you wish to further customize the widget style using CSS. Refer to this name on your custom.css file'),
            'class' => 'validate-code',
        ));

        $fieldset->addField('columns', 'select', array(
            'label' => Mage::helper('itactica_textboxes')->__('Number of Columns'),
            'name'  => 'columns',
            'note'	=> Mage::helper('itactica_textboxes')->__('Set the number of text boxes in a row'),
            'values'=> Mage::getModel('itactica_textboxes/box_attribute_source_columns')->getAllOptions(false),
            'after_element_html' =>
                '<script type="text/javascript">
                    checkColumns = function() {
                        if ($("box_columns").getValue() == 2) {
                            $("box_box_form4").hide();
                            $("box_box_form4").previous(".entry-edit-head").hide();
                        } else {
                            $("box_box_form4").show();
                            $("box_box_form4").previous(".entry-edit-head").show();
                        }
                    }

                    Event.observe(window, "load", function() {
                        Event.observe("box_columns", "change", checkColumns);
                        checkColumns();
                    })
                </script>',
        ));

        $fieldset->addField('box_type', 'select', array(
            'label' => Mage::helper('itactica_textboxes')->__('Box Type'),
            'name'  => 'box_type',
            'values'=> Mage::getModel('itactica_textboxes/box_attribute_source_boxtype')->getAllOptions(false),
            'after_element_html' =>
                '<script type="text/javascript">
                    var fieldGroup1 = ["box_icon_class_","box_icon_color_","box_icon_style_","box_icon_size_","box_icon_line_height_"],
                        fieldGroup2 = ["box_image_filename_"],
                        fieldSection = ["first","second","third"];
                    checkBoxType = function() {
                        if ($("box_box_type").getValue() == 1 || $("box_box_type").getValue() == 2) {
                            groupVisibility(fieldGroup1, "show");
                            groupVisibility(fieldGroup2, "hide");
                        } else if ($("box_box_type").getValue() == 3) {
                            groupVisibility(fieldGroup1, "hide");
                            groupVisibility(fieldGroup2, "show");
                        } else {
                            groupVisibility(fieldGroup1, "hide");
                            groupVisibility(fieldGroup2, "hide");
                        }
                    }

                    groupVisibility = function(fieldGroup, action) {
                        for (i = 0; i < fieldGroup.length; i++) {
                            for (j = 0; j < fieldSection.length; j++) {
                                if (action == "show") {
                                    $(fieldGroup[i]+fieldSection[j]).up(1).show();
                                } else {
                                    $(fieldGroup[i]+fieldSection[j]).up(1).hide();
                                }
                            }
                        }
                    }

                    Event.observe(window, "load", function() {
                        Event.observe("box_box_type", "change", checkBoxType);
                        checkBoxType();
                    })
                </script>',
        ));

        $fieldset->addField('background_color', 'colorpicker', array(
            'label' => Mage::helper('itactica_textboxes')->__('Background Color'),
            'name'  => 'background_color',
            'note'  => $this->__('Select background color for the entire section'),
        ));

        $fieldset->addField('padding_top', 'text', array(
            'label' => Mage::helper('itactica_textboxes')->__('Padding Top'),
            'name'  => 'padding_top',
            'note'  => Mage::helper('itactica_textboxes')->__('If you want to set your own padding, enter it here (e.g. 50). This is the space in pixels between the icon or image and the upper edge of the box'),
            'class' => 'validate-number',
        ));

        $fieldset->addField('padding_bottom', 'text', array(
            'label' => Mage::helper('itactica_textboxes')->__('Padding Bottom'),
            'name'  => 'padding_bottom',
            'note'  => Mage::helper('itactica_textboxes')->__('If you want to set your own padding, enter it here (e.g. 50). This is the space in pixels between the text and the bottom edge of the box'),
            'class' => 'validate-number',
        ));

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('itactica_textboxes')->__('Status'),
            'name'  => 'status',
            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('itactica_textboxes')->__('Enabled'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('itactica_textboxes')->__('Disabled'),
                ),
            ),
        ));
        if (Mage::app()->isSingleStoreMode()){
            $fieldset->addField('store_id', 'hidden', array(
                'name'      => 'stores[]',
                'value'     => Mage::app()->getStore(true)->getId()
            ));
            Mage::registry('current_box')->setStoreId(Mage::app()->getStore(true)->getId());
        }

        $fieldset2 = $form->addFieldset('box_form2', array('legend'=>Mage::helper('itactica_textboxes')->__('Content for Text Box #1')));
        $fieldset2->addType('image', Mage::getConfig()->getBlockClassName('itactica_textboxes/adminhtml_box_helper_image'));
        $fieldset2->addType('colorpicker', 'Itactica_TextBoxes_Block_Adminhtml_Box_Edit_Form_Renderer_Fieldset_Colorpicker');
        $fieldset2->addType('chosen', 'Itactica_TextBoxes_Block_Adminhtml_Box_Edit_Form_Renderer_Fieldset_Chosen');

        $fieldset2->addField('icon_class_first', 'chosen', array(
            'label' => Mage::helper('itactica_textboxes')->__('Icon'),
            'name'  => 'icon_class_first',
            'values'=> Mage::getModel('itactica_textboxes/box_attribute_source_icons')->getAllOptions(false),
        ));

        $fieldset2->addField('icon_style_first', 'select', array(
            'label' => Mage::helper('itactica_textboxes')->__('Icon Style'),
            'name'  => 'icon_style_first',
            'values'=> Mage::getModel('itactica_textboxes/box_attribute_source_iconstyle')->getAllOptions(false),
        ));

        $fieldset2->addField('icon_color_first', 'colorpicker', array(
            'label' => Mage::helper('itactica_textboxes')->__('Icon Color'),
            'name'  => 'icon_color_first',
            'note'  => $this->__('Select icon color'),
        ));

        $fieldset2->addField('icon_size_first', 'text', array(
            'label' => Mage::helper('itactica_textboxes')->__('Icon Font Size'),
            'name'  => 'icon_size_first',
            'note'  => Mage::helper('itactica_textboxes')->__('Enter font size of the icon in pixels (e.g. 25)'),
            'class'     => 'validate-number',
        ));

        $fieldset2->addField('icon_line_height_first', 'text', array(
            'label' => Mage::helper('itactica_textboxes')->__('Icon Line Height'),
            'name'  => 'icon_line_height_first',
            'note'  => Mage::helper('itactica_textboxes')->__('Enter line-height for the icon in pixels (e.g. 39). Use this meassure to adjust vertical alignment of the icon.'),
            'class'     => 'validate-number',
        ));

        $fieldset2->addField('image_filename_first', 'image', array(
            'label' => Mage::helper('itactica_textboxes')->__('Image'),
            'name'  => 'image_filename_first',
            'note'  => Mage::helper('itactica_textboxes')->__('Recommended image width: 472px'),
        ));

        $fieldset2->addField('title_first', 'text', array(
            'label' => Mage::helper('itactica_textboxes')->__('Title'),
            'name'  => 'title_first',
        ));

        $fieldset2->addField('title_color_first', 'colorpicker', array(
            'label' => Mage::helper('itactica_textboxes')->__('Title Color'),
            'name'  => 'title_color_first',
            'note'  => $this->__('Select font-color'),
        ));

        $fieldset2->addField('title_size_first', 'text', array(
            'label' => Mage::helper('itactica_textboxes')->__('Title Size'),
            'name'  => 'title_size_first',
            'note'  => Mage::helper('itactica_textboxes')->__('Font-size in pixels (e.g. 23)'),
            'class' => 'validate-number',
        ));

        $fieldset2->addField('title_style_first', 'select', array(
            'label' => Mage::helper('itactica_textboxes')->__('Title Style'),
            'name'  => 'title_style_first',
            'note'  => $this->__('Select font-style'),
            'values'=> Mage::getModel('itactica_textboxes/box_attribute_source_fontstyle')->getAllOptions(false),
        ));

        $fieldset2->addField('title_weight_first', 'select', array(
            'label' => Mage::helper('itactica_textboxes')->__('Title Weight'),
            'name'  => 'title_weight_first',
            'note'  => $this->__('Select font-weight'),
            'values'=> Mage::getModel('itactica_textboxes/box_attribute_source_fontweight')->getAllOptions(false),
        ));

        $fieldset2->addField('text_first', 'textarea', array(
            'label' => Mage::helper('itactica_textboxes')->__('Text'),
            'name'  => 'text_first',
            'style' => 'height: 8em',
        ));

        $fieldset2->addField('text_color_first', 'colorpicker', array(
            'label' => Mage::helper('itactica_textboxes')->__('Text Color'),
            'name'  => 'text_color_first',
            'note'  => $this->__('Select font-color'),
        ));

        $fieldset2->addField('text_size_first', 'text', array(
            'label' => Mage::helper('itactica_textboxes')->__('Text Size'),
            'name'  => 'text_size_first',
            'note'  => $this->__('Enter font-size in pixels (e.g. 16)'),
            'class' => 'validate-number',
        ));

        $fieldset2->addField('text_lineheight_first', 'text', array(
            'label' => Mage::helper('itactica_textboxes')->__('Text Line Height'),
            'name'  => 'text_lineheight_first',
            'note'  => $this->__('Enter line-height in pixels (e.g. 24). Should be larger than the Text Size'),
            'class' => 'validate-number',
        ));

        $fieldset2->addField('link_first', 'text', array(
            'label' => Mage::helper('itactica_textboxes')->__('Link URL'),
            'name'  => 'link_first',
            'note'  => $this->__('The URL could be relative or absolute:<br>catalog/product1.html<br>http://www.example.com/catalog/product1.html'),
        ));

        $fieldset2->addField('link_text_first', 'text', array(
            'label' => Mage::helper('itactica_textboxes')->__('Link Text'),
            'name'  => 'link_text_first',
        ));

        $fieldset2->addField('link_type_first', 'select', array(
            'label' => Mage::helper('itactica_textboxes')->__('Link Type'),
            'name'  => 'link_type_first',
            'values'=> Mage::getModel('itactica_textboxes/box_attribute_source_linktype')->getAllOptions(false),
            'after_element_html' =>
                '<script type="text/javascript">
                    var fieldGroup3 = ["box_button_bg_color_first","box_button_text_color_first","box_button_bgcolor_hover_first","box_button_textcolor_hover_first"];
                    checkLinkTypeFirst = function() {
                        if ($("box_link_type_first").getValue() == "arrow-right") {
                            linkOrButton(fieldGroup3, "hide");
                        } else {
                            linkOrButton(fieldGroup3, "show");
                        }
                    }

                    var linkOrButton = function(fieldGroup, action) {
                        for (i = 0; i < fieldGroup.length; i++) {
                            if (action == "show") {
                                $(fieldGroup[i]).up(1).show();
                            } else {
                                $(fieldGroup[i]).up(1).hide();
                            }
                        }
                    }

                    Event.observe(window, "load", function() {
                        Event.observe("box_link_type_first", "change", checkLinkTypeFirst);
                        checkLinkTypeFirst();
                    })
                </script>',
        ));

        $fieldset2->addField('button_text_color_first', 'colorpicker', array(
            'label' => Mage::helper('itactica_textboxes')->__('Button Text Color'),
            'name'  => 'button_text_color_first',
            'note'  => $this->__('Select font-color'),
        ));

        $fieldset2->addField('button_textcolor_hover_first', 'colorpicker', array(
            'label' => Mage::helper('itactica_textboxes')->__('Button Text Color on Hover'),
            'name'  => 'button_textcolor_hover_first',
            'note'  => $this->__('Select font-color on hover'),
        ));

        $fieldset2->addField('button_bg_color_first', 'colorpicker', array(
            'label' => Mage::helper('itactica_textboxes')->__('Button Background Color'),
            'name'  => 'button_bg_color_first',
            'note'  => $this->__('Select background-color'),
        ));

        $fieldset2->addField('button_bgcolor_hover_first', 'colorpicker', array(
            'label' => Mage::helper('itactica_textboxes')->__('Button Background Color on Hover'),
            'name'  => 'button_bgcolor_hover_first',
            'note'  => $this->__('Select background-color on hover'),
        ));

        $fieldset3 = $form->addFieldset('box_form3', array('legend'=>Mage::helper('itactica_textboxes')->__('Content for Text Box #2')));
        $fieldset3->addType('image', Mage::getConfig()->getBlockClassName('itactica_textboxes/adminhtml_box_helper_image'));
        $fieldset3->addType('colorpicker', 'Itactica_TextBoxes_Block_Adminhtml_Box_Edit_Form_Renderer_Fieldset_Colorpicker');
        $fieldset3->addType('chosen', 'Itactica_TextBoxes_Block_Adminhtml_Box_Edit_Form_Renderer_Fieldset_Chosen');

        $fieldset3->addField('icon_class_second', 'chosen', array(
            'label' => Mage::helper('itactica_textboxes')->__('Icon'),
            'name'  => 'icon_class_second',
            'values'=> Mage::getModel('itactica_textboxes/box_attribute_source_icons')->getAllOptions(false),
        ));

        $fieldset3->addField('icon_style_second', 'select', array(
            'label' => Mage::helper('itactica_textboxes')->__('Icon Style'),
            'name'  => 'icon_style_second',
            'values'=> Mage::getModel('itactica_textboxes/box_attribute_source_iconstyle')->getAllOptions(false),
        ));

        $fieldset3->addField('icon_color_second', 'colorpicker', array(
            'label' => Mage::helper('itactica_textboxes')->__('Icon Color'),
            'name'  => 'icon_color_second',
            'note'  => $this->__('Select icon color'),
        ));

        $fieldset3->addField('icon_size_second', 'text', array(
            'label' => Mage::helper('itactica_textboxes')->__('Icon Font Size'),
            'name'  => 'icon_size_second',
            'note'  => Mage::helper('itactica_textboxes')->__('Enter font size of the icon in pixels (e.g. 25)'),
            'class'     => 'validate-number',
        ));

        $fieldset3->addField('icon_line_height_second', 'text', array(
            'label' => Mage::helper('itactica_textboxes')->__('Icon Line Height'),
            'name'  => 'icon_line_height_second',
            'note'  => Mage::helper('itactica_textboxes')->__('Enter line-height for the icon in pixels (e.g. 39). Use this meassure to adjust vertical alignment of the icon.'),
            'class'     => 'validate-number',
        ));

        $fieldset3->addField('image_filename_second', 'image', array(
            'label' => Mage::helper('itactica_textboxes')->__('Image'),
            'name'  => 'image_filename_second',
            'note'  => Mage::helper('itactica_textboxes')->__('Recommended image width: 472px'),
        ));

        $fieldset3->addField('title_second', 'text', array(
            'label' => Mage::helper('itactica_textboxes')->__('Title'),
            'name'  => 'title_second',
        ));

        $fieldset3->addField('title_color_second', 'colorpicker', array(
            'label' => Mage::helper('itactica_textboxes')->__('Title Color'),
            'name'  => 'title_color_second',
            'note'  => $this->__('Select font-color'),
        ));

        $fieldset3->addField('title_size_second', 'text', array(
            'label' => Mage::helper('itactica_textboxes')->__('Title Size'),
            'name'  => 'title_size_second',
            'note'  => Mage::helper('itactica_textboxes')->__('Font-size in pixels (e.g. 23)'),
            'class' => 'validate-number',
        ));

        $fieldset3->addField('title_style_second', 'select', array(
            'label' => Mage::helper('itactica_textboxes')->__('Title Style'),
            'name'  => 'title_style_second',
            'note'  => $this->__('Select font-style'),
            'values'=> Mage::getModel('itactica_textboxes/box_attribute_source_fontstyle')->getAllOptions(false),
        ));

        $fieldset3->addField('title_weight_second', 'select', array(
            'label' => Mage::helper('itactica_textboxes')->__('Title Weight'),
            'name'  => 'title_weight_second',
            'note'  => $this->__('Select font-weight'),
            'values'=> Mage::getModel('itactica_textboxes/box_attribute_source_fontweight')->getAllOptions(false),
        ));

        $fieldset3->addField('text_second', 'textarea', array(
            'label' => Mage::helper('itactica_textboxes')->__('Text'),
            'name'  => 'text_second',
            'style' => 'height: 8em',
        ));

        $fieldset3->addField('text_color_second', 'colorpicker', array(
            'label' => Mage::helper('itactica_textboxes')->__('Text Color'),
            'name'  => 'text_color_second',
            'note'  => $this->__('Select font-color'),
        ));

        $fieldset3->addField('text_size_second', 'text', array(
            'label' => Mage::helper('itactica_textboxes')->__('Text Size'),
            'name'  => 'text_size_second',
            'note'  => $this->__('Enter font-size in pixels (e.g. 16)'),
            'class' => 'validate-number',
        ));

        $fieldset3->addField('text_lineheight_second', 'text', array(
            'label' => Mage::helper('itactica_textboxes')->__('Text Line Height'),
            'name'  => 'text_lineheight_second',
            'note'  => $this->__('Enter line-height in pixels (e.g. 24). Should be larger than the Text Size'),
            'class' => 'validate-number',
        ));

        $fieldset3->addField('link_second', 'text', array(
            'label' => Mage::helper('itactica_textboxes')->__('Link URL'),
            'name'  => 'link_second',
            'note'  => $this->__('The URL could be relative or absolute:<br>catalog/product1.html<br>http://www.example.com/catalog/product1.html'),
        ));

        $fieldset3->addField('link_text_second', 'text', array(
            'label' => Mage::helper('itactica_textboxes')->__('Link Text'),
            'name'  => 'link_text_second',
        ));

        $fieldset3->addField('link_type_second', 'select', array(
            'label' => Mage::helper('itactica_textboxes')->__('Link Type'),
            'name'  => 'link_type_second',
            'values'=> Mage::getModel('itactica_textboxes/box_attribute_source_linktype')->getAllOptions(false),
            'after_element_html' =>
                '<script type="text/javascript">
                    var fieldGroup4 = ["box_button_bg_color_second","box_button_text_color_second","box_button_bgcolor_hover_second","box_button_textcolor_hover_second"];
                    checkLinkTypeSecond = function() {
                        if ($("box_link_type_second").getValue() == "arrow-right") {
                            linkOrButton(fieldGroup4, "hide");
                        } else {
                            linkOrButton(fieldGroup4, "show");
                        }
                    }

                    Event.observe(window, "load", function() {
                        Event.observe("box_link_type_second", "change", checkLinkTypeSecond);
                        checkLinkTypeSecond();
                    })
                </script>',
        ));

        $fieldset3->addField('button_text_color_second', 'colorpicker', array(
            'label' => Mage::helper('itactica_textboxes')->__('Button Text Color'),
            'name'  => 'button_text_color_second',
            'note'  => $this->__('Select font-color'),
        ));

        $fieldset3->addField('button_textcolor_hover_second', 'colorpicker', array(
            'label' => Mage::helper('itactica_textboxes')->__('Button Text Color on Hover'),
            'name'  => 'button_textcolor_hover_second',
            'note'  => $this->__('Select font-color on hover'),
        ));

        $fieldset3->addField('button_bg_color_second', 'colorpicker', array(
            'label' => Mage::helper('itactica_textboxes')->__('Button Background Color'),
            'name'  => 'button_bg_color_second',
            'note'  => $this->__('Select background-color'),
        ));

        $fieldset3->addField('button_bgcolor_hover_second', 'colorpicker', array(
            'label' => Mage::helper('itactica_textboxes')->__('Button Background Color on Hover'),
            'name'  => 'button_bgcolor_hover_second',
            'note'  => $this->__('Select background-color on hover'),
        ));

        $fieldset4 = $form->addFieldset('box_form4', array('legend'=>Mage::helper('itactica_textboxes')->__('Content for Text Box #3')));
        $fieldset4->addType('image', Mage::getConfig()->getBlockClassName('itactica_textboxes/adminhtml_box_helper_image'));
        $fieldset4->addType('colorpicker', 'Itactica_TextBoxes_Block_Adminhtml_Box_Edit_Form_Renderer_Fieldset_Colorpicker');
        $fieldset4->addType('chosen', 'Itactica_TextBoxes_Block_Adminhtml_Box_Edit_Form_Renderer_Fieldset_Chosen');

        $fieldset4->addField('icon_class_third', 'chosen', array(
            'label' => Mage::helper('itactica_textboxes')->__('Icon'),
            'name'  => 'icon_class_third',
            'values'=> Mage::getModel('itactica_textboxes/box_attribute_source_icons')->getAllOptions(false),
        ));

        $fieldset4->addField('icon_style_third', 'select', array(
            'label' => Mage::helper('itactica_textboxes')->__('Icon Style'),
            'name'  => 'icon_style_third',
            'values'=> Mage::getModel('itactica_textboxes/box_attribute_source_iconstyle')->getAllOptions(false),
        ));

        $fieldset4->addField('icon_color_third', 'colorpicker', array(
            'label' => Mage::helper('itactica_textboxes')->__('Icon Color'),
            'name'  => 'icon_color_third',
            'note'  => $this->__('Select icon color'),
        ));

        $fieldset4->addField('icon_size_third', 'text', array(
            'label' => Mage::helper('itactica_textboxes')->__('Icon Font Size'),
            'name'  => 'icon_size_third',
            'note'  => Mage::helper('itactica_textboxes')->__('Enter font size of the icon in pixels (e.g. 25)'),
            'class'     => 'validate-number',
        ));

        $fieldset4->addField('icon_line_height_third', 'text', array(
            'label' => Mage::helper('itactica_textboxes')->__('Icon Line Height'),
            'name'  => 'icon_line_height_third',
            'note'  => Mage::helper('itactica_textboxes')->__('Enter line-height for the icon in pixels (e.g. 39). Use this meassure to adjust vertical alignment of the icon.'),
            'class'     => 'validate-number',
        ));

        $fieldset4->addField('image_filename_third', 'image', array(
            'label' => Mage::helper('itactica_textboxes')->__('Image'),
            'name'  => 'image_filename_third',
            'note'  => Mage::helper('itactica_textboxes')->__('Recommended image width: 472px'),
        ));

        $fieldset4->addField('title_third', 'text', array(
            'label' => Mage::helper('itactica_textboxes')->__('Title'),
            'name'  => 'title_third',
        ));

        $fieldset4->addField('title_color_third', 'colorpicker', array(
            'label' => Mage::helper('itactica_textboxes')->__('Title Color'),
            'name'  => 'title_color_third',
            'note'  => $this->__('Select font-color'),
        ));

        $fieldset4->addField('title_size_third', 'text', array(
            'label' => Mage::helper('itactica_textboxes')->__('Title Size'),
            'name'  => 'title_size_third',
            'note'  => Mage::helper('itactica_textboxes')->__('Font-size in pixels (e.g. 23)'),
            'class' => 'validate-number',
        ));

        $fieldset4->addField('title_style_third', 'select', array(
            'label' => Mage::helper('itactica_textboxes')->__('Title Style'),
            'name'  => 'title_style_third',
            'note'  => $this->__('Select font-style'),
            'values'=> Mage::getModel('itactica_textboxes/box_attribute_source_fontstyle')->getAllOptions(false),
        ));

        $fieldset4->addField('title_weight_third', 'select', array(
            'label' => Mage::helper('itactica_textboxes')->__('Title Weight'),
            'name'  => 'title_weight_third',
            'note'  => $this->__('Select font-weight'),
            'values'=> Mage::getModel('itactica_textboxes/box_attribute_source_fontweight')->getAllOptions(false),
        ));

        $fieldset4->addField('text_third', 'textarea', array(
            'label' => Mage::helper('itactica_textboxes')->__('Text'),
            'name'  => 'text_third',
            'style' => 'height: 8em',
        ));

        $fieldset4->addField('text_color_third', 'colorpicker', array(
            'label' => Mage::helper('itactica_textboxes')->__('Text Color'),
            'name'  => 'text_color_third',
            'note'  => $this->__('Select font-color'),
        ));

        $fieldset4->addField('text_size_third', 'text', array(
            'label' => Mage::helper('itactica_textboxes')->__('Text Size'),
            'name'  => 'text_size_third',
            'note'  => $this->__('Enter font-size in pixels (e.g. 16)'),
            'class' => 'validate-number',
        ));

        $fieldset4->addField('text_lineheight_third', 'text', array(
            'label' => Mage::helper('itactica_textboxes')->__('Text Line Height'),
            'name'  => 'text_lineheight_third',
            'note'  => $this->__('Enter line-height in pixels (e.g. 24). Should be larger than the Text Size'),
            'class' => 'validate-number',
        ));

        $fieldset4->addField('link_third', 'text', array(
            'label' => Mage::helper('itactica_textboxes')->__('Link URL'),
            'name'  => 'link_third',
            'note'  => $this->__('The URL could be relative or absolute:<br>catalog/product1.html<br>http://www.example.com/catalog/product1.html'),
        ));

        $fieldset4->addField('link_text_third', 'text', array(
            'label' => Mage::helper('itactica_textboxes')->__('Link Text'),
            'name'  => 'link_text_third',
        ));

        $fieldset4->addField('link_type_third', 'select', array(
            'label' => Mage::helper('itactica_textboxes')->__('Link Type'),
            'name'  => 'link_type_third',
            'values'=> Mage::getModel('itactica_textboxes/box_attribute_source_linktype')->getAllOptions(false),
            'after_element_html' =>
                '<script type="text/javascript">
                    var fieldGroup5 = ["box_button_bg_color_third","box_button_text_color_third","box_button_bgcolor_hover_third","box_button_textcolor_hover_third"];
                    checkLinkTypeThird = function() {
                        if ($("box_link_type_third").getValue() == "arrow-right") {
                            linkOrButton(fieldGroup5, "hide");
                        } else {
                            linkOrButton(fieldGroup5, "show");
                        }
                    }

                    Event.observe(window, "load", function() {
                        Event.observe("box_link_type_third", "change", checkLinkTypeThird);
                        checkLinkTypeThird();
                    })
                </script>',
        ));

        $fieldset4->addField('button_text_color_third', 'colorpicker', array(
            'label' => Mage::helper('itactica_textboxes')->__('Button Text Color'),
            'name'  => 'button_text_color_third',
            'note'  => $this->__('Select font-color'),
        ));

        $fieldset4->addField('button_textcolor_hover_third', 'colorpicker', array(
            'label' => Mage::helper('itactica_textboxes')->__('Button Text Color on Hover'),
            'name'  => 'button_textcolor_hover_third',
            'note'  => $this->__('Select font-color on hover'),
        ));

        $fieldset4->addField('button_bg_color_third', 'colorpicker', array(
            'label' => Mage::helper('itactica_textboxes')->__('Button Background Color'),
            'name'  => 'button_bg_color_third',
            'note'  => $this->__('Select background-color'),
        ));

        $fieldset4->addField('button_bgcolor_hover_third', 'colorpicker', array(
            'label' => Mage::helper('itactica_textboxes')->__('Button Background Color on Hover'),
            'name'  => 'button_bgcolor_hover_third',
            'note'  => $this->__('Select background-color on hover'),
        ));

        $formValues = Mage::registry('current_box')->getDefaultValues();
        if (!is_array($formValues)){
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getBoxData()){
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getBoxData());
            Mage::getSingleton('adminhtml/session')->setBoxData(null);
        }
        elseif (Mage::registry('current_box')){
            $formValues = array_merge($formValues, Mage::registry('current_box')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
