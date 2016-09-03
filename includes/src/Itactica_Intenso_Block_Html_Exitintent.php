<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_Intenso
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_Intenso_Block_Html_Exitintent extends Mage_Catalog_Block_Product_Abstract
{
	public function isActive() {
		return Mage::getStoreConfig('intenso/exit_intent_popup/enable_popup', 
			Mage::app()->getStore());
	}

	public function popupType() {
		return Mage::getStoreConfig('intenso/exit_intent_popup/popup_type', 
			Mage::app()->getStore());
	}

	public function entryTime() {
		return Mage::getStoreConfig('intenso/exit_intent_popup/entry_time', 
			Mage::app()->getStore());
	}

	public function popupSize() {
		return Mage::getStoreConfig('intenso/exit_intent_popup/popup_size', 
			Mage::app()->getStore());
	}

	public function background() {
		$backgroundImage = Mage::getStoreConfig('intenso/exit_intent_popup/background_image', 
			Mage::app()->getStore());
		$color = Mage::getStoreConfig('intenso/exit_intent_popup/background_color', 
			Mage::app()->getStore());
		$bgImage = '';
		$bgColor = '';
		if ($backgroundImage) {
			$basePath = Mage::getBaseUrl('media');
			$imagePath = $basePath . 'popup/' . $backgroundImage;
			$bgImage = 'background-image: url(' . $imagePath . '); background-size: cover; ';
		}
		if ($color) {
			if (substr($color, 0, 1) != '#') {
	    		$color = '#' . $color;
	    	}
			$bgColor = 'background-color: ' . $color . '; ';
		}
		return 'style="' . $bgImage . $bgColor . '"';
	}

	public function staticBlock() {
		return Mage::getStoreConfig('intenso/exit_intent_popup/static_block', 
			Mage::app()->getStore());
	}

	public function staticBlockWidth() {
		return Mage::getStoreConfig('intenso/exit_intent_popup/static_block_width', 
			Mage::app()->getStore());
	}

	public function staticBlockAlignment() {
		$alignment = Mage::getStoreConfig('intenso/exit_intent_popup/static_block_alignment', 
			Mage::app()->getStore());
		if ($alignment == 1) {
			return ' margin: 0 auto;';
		} elseif ($alignment == 2) {
			return ' margin-left: auto; margin-right: 0;';
		}
	}

	public function sensitivity() {
		return Mage::getStoreConfig('intenso/exit_intent_popup/sensitivity', 
			Mage::app()->getStore());
	}

	public function delay() {
		return Mage::getStoreConfig('intenso/exit_intent_popup/delay', 
			Mage::app()->getStore());
	}

	public function cookieExpiration() {
		return Mage::getStoreConfig('intenso/exit_intent_popup/cookie_expiration', 
			Mage::app()->getStore());
	}

	public function cookieName() {
		return Mage::getStoreConfig('intenso/exit_intent_popup/cookie_name', 
			Mage::app()->getStore());
	}
}