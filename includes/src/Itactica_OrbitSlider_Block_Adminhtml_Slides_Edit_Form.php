<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_OrbitSlider
 * @copyright   Copyright (c) 2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */


class Itactica_OrbitSlider_Block_Adminhtml_Slides_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare form
     * @access protected
     * @return Itactica_OrbitSlider_Block_Adminhtml_Slides_Edit_Form
     */
    protected function _prepareForm() {
        $form = new Varien_Data_Form(array(
                        'id'         => 'edit_form',
                        'action'     => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                        'method'     => 'post',
                        'enctype'    => 'multipart/form-data'
                    )
        );
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
