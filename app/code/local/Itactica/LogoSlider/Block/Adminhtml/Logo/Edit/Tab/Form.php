<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_LogoSlider
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_LogoSlider_Block_Adminhtml_Logo_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     * @access protected
     * @return LogoSlider_Logo_Block_Adminhtml_Logo_Edit_Tab_Form
     */
    protected function _prepareForm(){
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('logo_');
        $form->setFieldNameSuffix('logo');
        $this->setForm($form);
        $fieldset = $form->addFieldset('logo_form', array('legend'=>Mage::helper('itactica_logoslider')->__('Images')));
        $fieldset->addType('image', Mage::getConfig()->getBlockClassName('itactica_logoslider/adminhtml_logo_helper_image'));

        $fieldset->addField('title', 'text', array(
            'label' => Mage::helper('itactica_logoslider')->__('Title'),
            'name'  => 'title',
            'note'	=> $this->__('Name of the brand.'),
            'required'  => true,
            'class' => 'required-entry',
        ));

        $fieldset->addField('filename', 'image', array(
            'label' => Mage::helper('itactica_logoslider')->__('Logo Image'),
            'name'  => 'filename',
            'note'	=> $this->__('Select the logo image from your computer.'),
            'required'  => true,
            'class' => 'required-entry',
        ));

        $searchByKey = $fieldset->addField('search_by_key', 'select', array(
            'label' => Mage::helper('itactica_logoslider')->__('Action When Logo is Clicked'),
            'name'  => 'search_by_key',
            'note'	=> $this->__('<strong>Search</strong> -> A search will be performed using a string (e.g. name of brand).<br/><strong>URL</strong> -> User will be redirected to a specific URL.<br/><strong>Nothing</strong> -> Logos can\'t be clicked'),
            'required'  => true,
            'class' => 'required-entry',
            'values'=> Mage::getModel('itactica_logoslider/logo_attribute_source_searchbykey')->getAllOptions(true),
        ));

        $URL = $fieldset->addField('url_to_redirect', 'text', array(
            'label' => Mage::helper('itactica_logoslider')->__('URL to Redirect on Click'),
            'name'  => 'url_to_redirect',
            'note'	=> $this->__('URL to redirect when logo is clicked. Could be an absolute or relative path.'),
            'required'  => true,
            'class' => 'required-entry',
        ));

        $searchKey = $fieldset->addField('search_key', 'text', array(
            'label' => Mage::helper('itactica_logoslider')->__('Product Search Key'),
            'name'  => 'search_key',
            'note'	=> $this->__('Search key to look up when logo is clicked'),
            'required'  => true,
            'class' => 'required-entry',
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

        $this->setChild('form_after',$this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')
            ->addFieldMap($searchByKey->getHtmlId(),$searchByKey->getName())
            ->addFieldMap($URL->getHtmlId(),$URL->getName())
            ->addFieldMap($searchKey->getHtmlId(),$searchKey->getName())
            ->addFieldDependence($URL->getName(),$searchByKey->getName(),'2')
            ->addFieldDependence($searchKey->getName(),$searchByKey->getName(),'1'));

        if (Mage::app()->isSingleStoreMode()){
            $fieldset->addField('store_id', 'hidden', array(
                'name'      => 'stores[]',
                'value'     => Mage::app()->getStore(true)->getId()
            ));
            Mage::registry('current_logo')->setStoreId(Mage::app()->getStore(true)->getId());
        }
        $formValues = Mage::registry('current_logo')->getDefaultValues();
        if (!is_array($formValues)){
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getLogoData()){
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getLogoData());
            Mage::getSingleton('adminhtml/session')->setLogoData(null);
        }
        elseif (Mage::registry('current_logo')){
            $formValues = array_merge($formValues, Mage::registry('current_logo')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
