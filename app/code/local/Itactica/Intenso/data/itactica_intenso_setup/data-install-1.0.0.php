<?php
/**
 * Intenso Premium Theme
 *
 * @category    Itactica
 * @package     Itactica_Intenso
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */
/** @var $installer Itactica_Intenso_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

/*
 * hide WYSIWYG by default
 */
Mage::getConfig()->saveConfig('cms/wysiwyg/enabled', 'hidden');

/*
 * set maximum display recently added items
 */
Mage::getConfig()->saveConfig('checkout/sidebar/count', 100);

/*
 * set header config
 */
Mage::getConfig()->saveConfig('design/header/logo_src', 'images/logo.svg');
Mage::getConfig()->saveConfig('design/header/logo_src_small', 'images/logo.svg');

/*
 * create custom.css file
 */
try {
	$skinPath = Mage::getBaseDir('skin');
	$cssFolderPath = $skinPath . DS . 'frontend' . DS . 'intenso' . DS . 'default' . DS . 'css';
	$customCssFile = fopen($cssFolderPath . DS . 'custom.css', 'w');
	$fileContent = '/**'.PHP_EOL;
	$fileContent .= ' * Custom CSS stylesheet. Add here your custom styles.'.PHP_EOL;
	$fileContent .= ' *'.PHP_EOL;
	$fileContent .= ' * Enable this file from the backend:'.PHP_EOL;
	$fileContent .= ' * System -> Configuration -> Theme Setup -> Custom CSS -> Load Custom CSS File'.PHP_EOL;
	$fileContent .= ' * '.PHP_EOL;
	$fileContent .= ' * Please refer to the User\'s Guide for more information.'.PHP_EOL;
	$fileContent .= '*/'.PHP_EOL . PHP_EOL . PHP_EOL;
	$fileContent .= 'body.es_es #histogram .stars {'.PHP_EOL;
	$fileContent .= '	width: 4rem !important;'.PHP_EOL;
	$fileContent .= '}'.PHP_EOL . PHP_EOL;
	$fileContent .= 'body.es_es #select_language_chosen.chosen-container-active .chosen-single span:before,'.PHP_EOL;
	$fileContent .= 'body.es_es #select_language_chosen.chosen-container .chosen-single span:before {'.PHP_EOL;
	$fileContent .= '	content: \'Idioma: \';'.PHP_EOL;
	$fileContent .= '}'.PHP_EOL;
	$fileContent .= 'body.es_es #select_currency_chosen.chosen-container-active .chosen-single span:before,'.PHP_EOL;
	$fileContent .= 'body.es_es #select_currency_chosen.chosen-container .chosen-single span:before {'.PHP_EOL;
	$fileContent .= '	content: \'Moneda: \';'.PHP_EOL;
	$fileContent .= '}'.PHP_EOL . PHP_EOL;
	fwrite($customCssFile, $fileContent);
	fclose($customCssFile);
} catch (Exception $e) {
	Mage::log($e);
}

$installer->endSetup();
