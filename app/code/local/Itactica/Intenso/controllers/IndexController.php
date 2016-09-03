<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_Intenso
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_Intenso_IndexController extends Mage_Core_Controller_Front_Action
{
	/**
     * default action
     * @return void
     */
    public function indexAction() {
    	$this->loadLayout();
    	$this->renderLayout();
    }
}