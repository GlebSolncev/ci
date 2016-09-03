<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_TextBoxes
 * @copyright   Copyright (c) 2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_TextBoxes_Adminhtml_Textboxes_Box_WidgetController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Chooser Source action
     * @access public
     * @return void
     */
    public function chooserAction(){
        $uniqId = $this->getRequest()->getParam('uniq_id');
        $grid = $this->getLayout()->createBlock('itactica_textboxes/adminhtml_box_widget_chooser', '', array(
            'id' => $uniqId,
        ));
        $this->getResponse()->setBody($grid->toHtml());
    }
}
