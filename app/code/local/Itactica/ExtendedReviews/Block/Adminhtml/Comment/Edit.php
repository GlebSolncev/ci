<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_ExtendedReviews
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_ExtendedReviews_Block_Adminhtml_Comment_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {

    public function __construct() {
        parent::__construct();
        $this->_blockGroup = 'itactica_extendedreviews';
        $this->_objectId = 'id';
        $this->_controller = 'adminhtml_comment';
        if ($this->getRequest()->getParam('ret', false) == 'pending') {
            $this->_updateButton('back', 'onclick', 'setLocation(\'' . $this->getUrl('*/*/pending') . '\')');
            $this->_updateButton('delete', 'onclick', 'deleteConfirm(\'' . Mage::helper('review')->__('Are you sure you want to do this?') . '\', \'' . $this->getUrl('*/*/delete', array(
                        $this->_objectId => $this->getRequest()->getParam($this->_objectId),
                        'ret' => 'pending',
                    )) . '\')');
            Mage::register('ret', 'pending');
        }

        if ($this->getRequest()->getParam($this->_objectId)) {
            $commentData = Mage::getModel('itactica_extendedreviews/comment')
                    ->load($this->getRequest()->getParam($this->_objectId));
            Mage::register('comment_data', $commentData);
        }
    }

    public function getHeaderText() {
        if (Mage::registry('comment_data')) {
            return Mage::helper('itactica_extendedreviews')->__('Edit Comment');
        } else {
            return parent::getHeaderText();
        }
    }

}
