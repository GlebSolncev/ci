<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_FeaturedProducts
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_FeaturedProducts_Block_Adminhtml_Slider_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     * @access protected
     * @return FeaturedProducts_Slider_Block_Adminhtml_Slider_Edit_Tab_Form
     */
    protected function _prepareForm(){
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('slider_');
        $form->setFieldNameSuffix('slider');
        $this->setForm($form);
        $fieldset = $form->addFieldset('slider_form', array('legend'=>Mage::helper('itactica_featuredproducts')->__('General Information')));

        $fieldset->addField('title', 'text', array(
            'label' => Mage::helper('itactica_featuredproducts')->__('Title'),
            'name'  => 'title',
            'note'  => $this->__('This is the title shown above the widget on frontend'),
            'required'  => true,
            'class' => 'required-entry',

        ));

        $fieldset->addField('identifier', 'text', array(
            'label' => Mage::helper('itactica_featuredproducts')->__('Identifier'),
            'name'  => 'identifier',
            'note'  => $this->__('For internal use, must be unique. Use only alphanumeric characters, underscores and dashes'),
            'required'  => true,
            'class'     => 'validate-xml-identifier',
            'required' => true,

        ));

        $fieldset->addField('custom_classname', 'text', array(
            'label' => Mage::helper('itactica_featuredproducts')->__('Custom Class Name'),
            'name'  => 'custom_classname',
            'note'  => Mage::helper('itactica_featuredproducts')->__('Add a custom class name if you wish to further customize the widget style using CSS. Refer to this name on your custom.css file'),
            'class' => 'validate-code',
        ));

        $fieldset->addField('animation_speed', 'text', array(
            'label' => Mage::helper('itactica_featuredproducts')->__('Animation Speed'),
            'name'  => 'animation_speed',
            'note'	=> $this->__('Sets the amount of time in milliseconds the transition between products will last. Note that 1000 miliseconds = 1 second'),
            'required'  => true,
            'class'     => 'validate-number',
            'required' => true,

        ));

        $productSource = $fieldset->addField('products_source', 'select', array(
            'label' => Mage::helper('itactica_featuredproducts')->__('Products Source'),
            'name'  => 'products_source',
            'note'	=> $this->__('<strong>All Catalog</strong> -> Show products from entire catalog.<br /><strong>Specific Categories</strong> -> Show products from one or more categories of your choice.<br /><strong>Specific Products</strong> -> Show custom products added on "Featured Products" Tab.'),
            'required'  => true,
            'class' => 'required-entry',
            'values'=> Mage::getModel('itactica_featuredproducts/slider_attribute_source_productssource')->getAllOptions(true),
        ));

        $categoryId = $fieldset->addField('category_ids', 'multiselect', array(
            'label' => Mage::helper('itactica_featuredproducts')->__('Category'),
            'name'  => 'category_ids',
            'note'	=> $this->__('Select one or more categories as the source for the Featured Products.'),
            'required'  => true,
            'class' => 'required-entry',
            'values' => Mage::helper('itactica_featuredproducts')->getCategoryTree(),
        ));

        $fieldset->addField('product_filter', 'select', array(
            'label' => Mage::helper('itactica_featuredproducts')->__('Product Filter'),
            'name'  => 'product_filter',
            'note'	=> $this->__('Choose how the products are ordered on the slider.'),
            'required'  => true,
            'class' => 'required-entry',
            'values'=> Mage::getModel('itactica_featuredproducts/slider_attribute_source_productfilter')->getAllOptions(true),
        ));

        $fieldset->addField('show_category_tabs', 'select', array(
            'label' => Mage::helper('itactica_featuredproducts')->__('Show Category Tabs'),
            'name'  => 'show_category_tabs',
            'note'	=> $this->__('If Yes, tabs will be added with links to allow filtering by category name. This option only works when you select products from at least two distinct categories.'),
            'class' => 'required-entry',

            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('itactica_featuredproducts')->__('Yes'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('itactica_featuredproducts')->__('No'),
                ),
            ),
        ));

        $fieldset->addField('limit', 'text', array(
            'label' => Mage::helper('itactica_featuredproducts')->__('Limit'),
            'name'  => 'limit',
            'note'	=> $this->__('Maximum amount of products to be featured on the slider. Enter "0" to display all matching products.'),
            'required'  => true,
            'class'     => 'validate-number',
            'required' => true,

        ));

        $fieldset->addField('show_out_of_stock', 'select', array(
            'label' => Mage::helper('itactica_featuredproducts')->__('Display Out of Stock Products'),
            'name'  => 'show_out_of_stock',
            'class' => 'required-entry',
            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('itactica_featuredproducts')->__('Yes'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('itactica_featuredproducts')->__('No'),
                ),
            ),
        ));

        $fieldset->addField('show_price_tag', 'select', array(
            'label' => Mage::helper('itactica_featuredproducts')->__('Show Price Tag'),
            'name'  => 'show_price_tag',
            'class' => 'required-entry',
            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('itactica_featuredproducts')->__('Yes'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('itactica_featuredproducts')->__('No'),
                ),
            ),
        ));

        $fieldset->addField('show_rating', 'select', array(
            'label' => Mage::helper('itactica_featuredproducts')->__('Show Products Rating'),
            'name'  => 'show_rating',
            'class' => 'required-entry',
            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('itactica_featuredproducts')->__('Yes'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('itactica_featuredproducts')->__('No'),
                ),
            ),
        ));

        $fieldset->addField('show_color_options', 'select', array(
            'label' => Mage::helper('itactica_featuredproducts')->__('Show Color Options'),
            'name'  => 'show_color_options',
            'note'	=> $this->__('If Yes, color options of configurable products will be shown.'),
            'class' => 'required-entry',
            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('itactica_featuredproducts')->__('Yes'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('itactica_featuredproducts')->__('No'),
                ),
            ),
        ));

        $fieldset->addField('show_add_to_cart_button', 'select', array(
            'label' => Mage::helper('itactica_featuredproducts')->__('Show Add to Cart Button'),
            'name'  => 'show_add_to_cart_button',
            'class' => 'required-entry',
            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('itactica_featuredproducts')->__('Yes'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('itactica_featuredproducts')->__('No'),
                ),
            ),
        ));

        $fieldset->addField('show_compare_button', 'select', array(
            'label' => Mage::helper('itactica_featuredproducts')->__('Show Add to Compare Button'),
            'name'  => 'show_compare_button',
            'class' => 'required-entry',
            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('itactica_featuredproducts')->__('Yes'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('itactica_featuredproducts')->__('No'),
                ),
            ),
        ));

        $fieldset->addField('show_wishlist_button', 'select', array(
            'label' => Mage::helper('itactica_featuredproducts')->__('Show Add to Wishlist Button'),
            'name'  => 'show_wishlist_button',
            'class' => 'required-entry',
            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('itactica_featuredproducts')->__('Yes'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('itactica_featuredproducts')->__('No'),
                ),
            ),
        ));

        $fieldset->addField('minimum_width', 'text', array(
            'label' => Mage::helper('itactica_featuredproducts')->__('Minimum Width'),
            'name'  => 'minimum_width',
            'note'	=> $this->__('Minimum width in pixels of each product box.'),
            'required'  => true,
            'class'     => 'validate-number',
            'required' => true,
        ));

        $fieldset->addField('image_height', 'text', array(
            'label' => Mage::helper('itactica_featuredproducts')->__('Image Height'),
            'name'  => 'image_height',
            'note'  => $this->__('Height in pixels of product image.'),
            'required'  => true,
            'class'     => 'validate-number',
            'required' => true,
        ));

        $fieldset->addField('has_padding', 'select', array(
            'label' => Mage::helper('itactica_featuredproducts')->__('Padding Around Image'),
            'name'  => 'has_padding',
            'note'  => $this->__('If yes, white space around image is added.'),
            'class' => 'required-entry',
            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('itactica_featuredproducts')->__('Yes'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('itactica_featuredproducts')->__('No'),
                ),
            ),
        ));

        $fieldset->addField('enable_adaptive_resize', 'select', array(
            'label' => Mage::helper('itactica_featuredproducts')->__('Enable Adaptive Resize of Image'),
            'name'  => 'enable_adaptive_resize',
            'note'  => $this->__('If yes, the image is cropped to avoid white bars in case the image has a different aspect ratio than product box.'),
            'class' => 'required-entry',
            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('itactica_featuredproducts')->__('Yes'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('itactica_featuredproducts')->__('No'),
                ),
            ),
        ));

        $fieldset->addField('adaptive_resize_position', 'select', array(
            'label' => Mage::helper('itactica_featuredproducts')->__('Adaptive Resize Position'),
            'name'  => 'adaptive_resize_position',
            'note'  => $this->__('Select crop position for the images. You may need to flush "Catalog Images Cache" in System > Cache Management to see changes to this setting.'),
            'class' => 'required-entry',
            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('itactica_featuredproducts')->__('Center'),
                ),
                array(
                    'value' => 2,
                    'label' => Mage::helper('itactica_featuredproducts')->__('top'),
                ),
                array(
                    'value' => 3,
                    'label' => Mage::helper('itactica_featuredproducts')->__('bottom'),
                ),
            ),
        ));

        $fieldset->addField('swipe', 'select', array(
            'label' => Mage::helper('itactica_featuredproducts')->__('Touch Swipe'),
            'name'  => 'swipe',
            'note'	=> $this->__('Allow touch swipe navigation of the slider on touch-enabled devices.'),
            'class' => 'required-entry',
            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('itactica_featuredproducts')->__('Yes'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('itactica_featuredproducts')->__('No'),
                ),
            ),
        ));
        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('itactica_featuredproducts')->__('Status'),
            'name'  => 'status',
            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('itactica_featuredproducts')->__('Enabled'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('itactica_featuredproducts')->__('Disabled'),
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

        $this->setChild('form_after',$this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')
            ->addFieldMap($productSource->getHtmlId(),$productSource->getName())
            ->addFieldMap($categoryId->getHtmlId(),$categoryId->getName())
            ->addFieldDependence($categoryId->getName(),$productSource->getName(),'2'));

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
