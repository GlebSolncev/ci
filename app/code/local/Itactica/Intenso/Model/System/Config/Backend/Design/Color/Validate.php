<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_Intenso
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_Intenso_Model_System_Config_Backend_Design_Color_Validate extends Mage_Core_Model_Config_Data
{
	public function save() {
		$value = $this->getValue();
		if (!$value) {
			$this->setValue('transparent');
		}
		return parent::save();
	}
}