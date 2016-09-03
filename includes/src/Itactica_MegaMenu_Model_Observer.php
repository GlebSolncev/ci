<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_MegaMenu
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */
class Itactica_MegaMenu_Model_Observer
{
    public function prepare_form(Varien_Event_Observer $observer)
    {
    	$form = $observer->getEvent()->getForm();

		if ($form) {
			foreach($form->getElements() as $fieldset){
				if ($fieldset['container']['data_object']['level'] > 2) {
        			$fieldset->removeField('intenso_menu_style');
        			$fieldset->removeField('intenso_menu_columns_large');
        			$fieldset->removeField('intenso_menu_columns_medium');
        			$fieldset->removeField('intenso_menu_right_block_width');
        			$fieldset->removeField('intenso_menu_right_block');
        		}
    		}
		}
		return $this;
    }
}