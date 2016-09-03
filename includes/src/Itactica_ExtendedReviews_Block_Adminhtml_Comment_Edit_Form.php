<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_ExtendedReviews
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_ExtendedReviews_Block_Adminhtml_Comment_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {
        $comment = Mage::registry('comment_data');
        $review = Mage::getModel('review/review')->load($comment->getReviewId());
        $statuses = Mage::getModel('review/review')
                ->getStatusCollection()
                ->load()
                ->toOptionArray();

        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'), 'ret' => Mage::registry('ret'))),
            'method' => 'post'
        ));

        $fieldset = $form->addFieldset('comment_details', array('legend' => Mage::helper('itactica_extendedreviews')->__('Comment Details'), 'class' => 'fieldset-wide'));

        $fieldset->addField('review_title', 'note', array(
            'label' => Mage::helper('review')->__('Review'),
            'text' => '<a href="' . $this->getUrl('adminhtml/catalog_product_review/edit', array('id' => $review->getId())) . '" onclick="this.target=\'blank\'">' . $review->getTitle() . '</a>'
        ));

        $customerText = Mage::helper('review')->__('Guest');
        if ($comment->getUserId()) {
            $customer = Mage::getModel('customer/customer')->load($comment->getUserId());
            if ($customer->getId() != null) {
                $customerText = Mage::helper('review')->__('<a href="%1$s" onclick="this.target=\'blank\'">%2$s %3$s</a> <a href="mailto:%4$s">(%4$s)</a>', $this->getUrl('adminhtml/customer/edit', array('id' => $customer->getId())), $this->escapeHtml($customer->getFirstname()), $this->escapeHtml($customer->getLastname()), $this->escapeHtml($customer->getEmail()));
            }
        }


        $fieldset->addField('customer', 'note', array(
            'label' => Mage::helper('review')->__('Posted By'),
            'text' => $customerText,
        ));

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('review')->__('Status'),
            'required' => true,
            'name' => 'status',
            'values' => Mage::helper('review')->translateArray($statuses),
        ));

        $fieldset->addField('nickname', 'text', array(
            'label' => Mage::helper('review')->__('Nickname'),
            'required' => true,
            'name' => 'nickname'
        ));

        $fieldset->addField('text', 'textarea', array(
            'label' => Mage::helper('itactica_extendedreviews')->__('Comment'),
            'required' => true,
            'name' => 'text',
            'style' => 'height:24em;',
        ));

        $form->setUseContainer(true);
        $form->setValues($comment->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }

}
