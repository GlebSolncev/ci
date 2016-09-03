<?php
/**
 * Intenso Premium Theme
 *
 * @category    Itactica
 * @package     Itactica_Intenso
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */
class Itactica_Intenso_Model_Css_Generator extends Mage_Core_Model_Abstract 
{
    /**
     * constructor
     * @access public
     * @return void
     */
    public function _construct(){
        parent::_construct();
    }

    /**
     * write CSS file to disk
     * @access protected
     * @param $options
     * @return string
     */
    protected function _generateCssFromConfig($storeCode){
        if (Mage::app()->getStore($storeCode)->getIsActive()) {
            $file = Mage::helper('itactica_intenso/data')->getConfigCssFile($storeCode) . 'settings-' . $storeCode . '.css';
            $template = Mage::helper('itactica_intenso/data')->getConfigCssTemplate() . 'configCss.phtml';
            $baseUrl = Mage::app()->getStore($storeCode)->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK);
            $templateOutputUrl = $baseUrl . 'itactica_intenso_css';

            try{ 
                $string = $this->fileGetContentsCurl($templateOutputUrl, Mage::app()->getStore($storeCode)->getId());

                if (empty($string)) {
                    throw new Exception( Mage::helper('itactica_intenso')->__("Template file is empty or doesn't exist: %s", $template) ); 
                }
                if (strpos($string, '.off-canvas-wrap') !== false) {
                    $io = new Varien_Io_File(); 
                    $io->setAllowCreateFolders(true); 
                    $io->open(array('path' => Mage::helper('itactica_intenso/data')->getConfigCssFile($storeCode))); 
                    $io->streamOpen($file, 'w+', 0777); 
                    $io->streamLock(true); 
                    $io->streamWrite($string); 
                    $io->streamUnlock(); 
                    $io->streamClose(); 
                } else {
                    Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_intenso')->__('CSS style sheet for store "%s" couldn\'t be generated. Please check that Intenso is active for this store.',$storeCode));
                }
            } catch (Exception $message) { 
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_intenso')->__('Error generating CSS file: %s', $file. '<br/>Message: ' . $message->getMessage()));
                Mage::logException($message);
            }
            Mage::unregister('store-code'); 
        } else {
            return;
        }
    }

    /**
     * get file content
     * @access protected
     * @param $url
     * @return string
     */
    protected function fileGetContentsCurl($url, $storeId) {
        if ($this->isCurl()) {
            curl_setopt($ch=curl_init(), CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, 'store-id='.$storeId);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if ($httpCode == 200) {
                return $response;
            } else {
                // try adding a user agent and a referer
                $agent = 'Mozilla/5.0 (Windows NT 6.2) AppleWebKit/536.6 (KHTML, like Gecko) Chrome/20.0.1090.0 Safari/536.6';
                curl_setopt($ch=curl_init(), CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_USERAGENT, $agent);
                curl_setopt($ch, CURLOPT_POSTFIELDS, 'store-id='.$storeId);
                curl_setopt($ch, CURLOPT_REFERER, 'http://www.google.com/');
                $response = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
                if ($httpCode == 200) {
                    return $response;
                } else {                  
                    throw new Exception( Mage::helper('itactica_intenso')->__('cURL returned status code %s',$httpCode) ); 
                }
            }
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('itactica_intenso')->__('PHP\'s curl extension is not installed!'));
        }
    }

    /**
     * check if cURL is enabled on the server
     * @access protected
     * @return bool
     */
    function isCurl(){
        return function_exists('curl_version');
    }

    /**
     * create CSS file(s) based on theme's configuration
     * @access public
     * @param $storeCode
     * @param $websiteCode
     * @return string
     */
    public function generateCssFromConfig($storeCode, $websiteCode){

        if ($websiteCode){ 
            if ($storeCode) {
                $this->_generateCssFromConfig($storeCode); 
            } else {
                $this->_websiteStores($websiteCode); 
            }
        } else {
            $websites = Mage::app()->getWebsites(false, true);
            foreach ($websites as $websiteCode => $value) {
                $this->_websiteStores($websiteCode); 
            }
        } 
    } 

    /**
     * website stores
     * @access protected
     * @param $websiteCode
     * @return string
     */
    protected function _websiteStores($websiteCode) {
        $website = Mage::app()->getWebsite($websiteCode);

        foreach ($website->getStoreCodes() as $storeCode) { 
            $this->_generateCssFromConfig($storeCode);
        } 
    } 

}