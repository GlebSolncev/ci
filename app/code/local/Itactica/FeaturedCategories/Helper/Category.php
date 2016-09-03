<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_FeaturedCategories
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_FeaturedCategories_Helper_Category extends Itactica_FeaturedCategories_Helper_Data
{
    /**
     * get the selected sliders for a category
     * @access public
     * @param Mage_Catalog_Model_Category $category
     * @return array()
     */
    public function getSelectedSliders(Mage_Catalog_Model_Product $category){
        if (!$category->hasSelectedSliders()) {
            $sliders = array();
            foreach ($this->getSelectedSlidersCollection($category) as $slider) {
                $sliders[] = $slider;
            }
            $category->setSelectedSliders($sliders);
        }
        return $category->getData('selected_sliders');
    }

    /**
     * get slider collection for a category
     * @access public
     * @param Mage_Catalog_Model_Category $category
     * @return Itactica_FeaturedCategories_Model_Resource_Slider_Collection
     */
    public function getSelectedSlidersCollection(Mage_Catalog_Model_Category $category){
        $collection = Mage::getResourceSingleton('itactica_featuredcategories/slider_collection')
            ->addCategoryFilter($category);
        return $collection;
    }

    /**
     * resize any image
     * @access public
     * @param string $fileName
     * @param int $width
     * @param int $height (optional)
     * @return string
     */
    public function resize($fileName, $width, $height = '')
    {
        $folderURL = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA);
        $imageURL = $folderURL . $fileName;
     
        $basePath = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA) . DS . $fileName;
        $newPath = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA) . DS . "resized" . DS . $fileName;
        //if width empty then return original size image's URL
        if ($width != '') {
            //if image has already resized then just return URL
            if (file_exists($basePath) && is_file($basePath) && !file_exists($newPath)) {
                $imageObj = new Varien_Image($basePath);
                $imageObj->constrainOnly(TRUE);
                $imageObj->keepAspectRatio(FALSE);
                $imageObj->keepFrame(FALSE);
                $imageObj->resize($width, $height);
                $imageObj->save($newPath);
            }
            $resizedURL = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . "resized/" . $fileName;
         } else {
            $resizedURL = $imageURL;
         }
         return $resizedURL;
    }
}
