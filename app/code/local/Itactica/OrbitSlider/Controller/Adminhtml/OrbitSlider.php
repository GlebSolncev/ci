<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_OrbitSlider
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_OrbitSlider_Controller_Adminhtml_OrbitSlider extends Mage_Adminhtml_Controller_Action
{
	/**
     * upload file and get the uploaded name
     * @access public
     * @param string $input
     * @param string $destinationFolder
     * @param array $data
     * @return string
     */
    protected function _uploadAndGetName($input, $destinationFolder, $data) {
        try{
            if (isset($data[$input]['delete'])){
                return '';
            }
            else{
                $uploader = new Varien_File_Uploader($input);
                $uploader->setAllowRenameFiles(true);
                $uploader->setFilesDispersion(true);
                $uploader->setAllowCreateFolders(true);
                $result = $uploader->save($destinationFolder);
                return $result['file'];
            }
        }
        catch (Exception $e) {
            if ($e->getCode() != Varien_File_Uploader::TMP_NAME_EMPTY) {
                throw $e;
            }
            else{
                if (isset($data[$input]['value'])){
                    return $data[$input]['value'];
                }
            }
        }
        return '';
    }
}
