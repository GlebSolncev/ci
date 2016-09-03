<?php
/**
 * Intenso Premium Theme
 *
 * @category    Itactica
 * @package     Itactica_Intenso
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

/**
 * Class implementing the media fallback layer for swatches
 */
class Itactica_Intenso_Helper_Mediafallback extends Mage_ConfigurableSwatches_Helper_Mediafallback
{
    /**
     * For given product, get configurable images fallback array
     * Depends on following data available on product:
     * - product must have child attribute label mapping attached
     * - product must have media gallery attached which attaches and differentiates local images and child images
     * - product must have child products attached
     *
     * @param Mage_Catalog_Model_Product $product
     * @param array $imageTypes - image types to select for child products
     * @return array
     */
    public function getConfigurableImagesFallbackArray(Mage_Catalog_Model_Product $product, array $imageTypes,
        $keepFrame = false
    ) {
        if (!$product->hasConfigurableImagesFallbackArray()) {
            $mapping = $product->getChildAttributeLabelMapping();

            $mediaGallery = $product->getMediaGallery();

            if (!isset($mediaGallery['images'])) {
                return array(); //nothing to do here
            }

            // ensure we only attempt to process valid image types we know about
            $imageTypes = array_intersect(array('image', 'small_image'), $imageTypes);

            $imagesByLabel = array();
            $imageHaystack = array_map(function ($value) {
                return Mage_ConfigurableSwatches_Helper_Data::normalizeKey($value['label']);
            }, $mediaGallery['images']);

            // set the size for the additional images of the gallery (shown below main image)
            $additionalImagesSizes = array('thumbnail','medium_image','image');

            // load images from the configurable product for swapping
            foreach ($mapping as $map) {
                $imagePath = null;

                //search by store-specific label and then default label if nothing is found
                $imageKey = array_search($map['label'], $imageHaystack);
                // search additional images by store-specific label
                $additionalImageKeys = array_keys($imageHaystack, $map['label']);
                if ($imageKey === false) {
                    $imageKey = array_search($map['default_label'], $imageHaystack);
                }
                if ($additionalImageKeys === false) {
                    $additionalImageKeys = array_keys($imageHaystack, $map['default_label']);                   
                }

                //assign proper image file if found
                if ($imageKey !== false) {
                    $imagePath = $mediaGallery['images'][$imageKey]['file'];
                }
                // assign additional images
                $additionalImagePaths = array();
                foreach ($additionalImageKeys as $key) {
                    $additionalImagePaths[] = $mediaGallery['images'][$key]['file'];
                }

                $imagesByLabel[$map['label']] = array(
                    'configurable_product' => array(
                        Mage_ConfigurableSwatches_Helper_Productimg::MEDIA_IMAGE_TYPE_SMALL => null,
                        Mage_ConfigurableSwatches_Helper_Productimg::MEDIA_IMAGE_TYPE_BASE => null,
                        'additional_images' => null,
                    ),
                    'products' => $map['product_ids'],
                );

                if ($imagePath) {
                    $imagesByLabel[$map['label']]['configurable_product']
                        [Mage_ConfigurableSwatches_Helper_Productimg::MEDIA_IMAGE_TYPE_SMALL] =
                            $this->_resizeProductImage($product, 'small_image', 'small_image', $imagePath);

                    $imagesByLabel[$map['label']]['configurable_product']
                        [Mage_ConfigurableSwatches_Helper_Productimg::MEDIA_IMAGE_TYPE_BASE] =
                            $this->_resizeProductImage($product, 'image', 'image', $imagePath);
                }
                if (in_array('image', $imageTypes)) {
                    $arrayHelper = null;
                    foreach ($additionalImagePaths as $path) {
                        foreach ($additionalImagesSizes as $size) {                     
                            $arrayHelper[$size][] = $this->_resizeProductImage($product, 'image', $size, $path);
                        }
                    }
                    $imagesByLabel[$map['label']]['configurable_product']['additional_images'] =
                        $arrayHelper;
                }
            }

            $imagesByType = array(
                'image' => array(),
                'medium_image' => array(),
                'small_image' => array(),
                'additional_images' => array(),
            );

            // iterate image types to build image array, normally one type is passed in at a time, but could be two
            foreach ($imageTypes as $imageType) {
                // load image from the configurable product's children for swapping
                /* @var $childProduct Mage_Catalog_Model_Product */
                if ($product->hasChildrenProducts()) {
                    $additionalImages = array();
                    foreach ($product->getChildrenProducts() as $childProduct) {
                        if ($image = $this->_resizeProductImage($childProduct, $imageType, $imageType)) {
                            $imagesByType[$imageType][$childProduct->getId()] = $image;
                        }
                        // add medium sized main image and additional gallery images -  only for product page and quickview
                        if ($imageType == 'image') {
                            if ($image = $this->_resizeProductImage($childProduct, $imageType, 'medium_image')) {
                                $imagesByType['medium_image'][$childProduct->getId()] = $image;
                            }
                            $childImages = array();
                            $childProduct->getResource()->getAttribute('media_gallery')
                                ->getBackend()->afterLoad($childProduct);
                            foreach ($childProduct->getMediaGalleryImages() as $image) {
                                foreach ($additionalImagesSizes as $size) {
                                    $helper = $this->_resizeProductImage($childProduct, 'image', $size, $image->getFile());
                                    $childImages[$size][] = $helper;
                                }
                            }
                            $additionalImages[$childProduct->getId()] = $childImages;
                        }
                    }
                }

                // load image from configurable product for swapping fallback
                if ($image = $this->_resizeProductImage($product, $imageType, $imageType, null, true)) {
                    $imagesByType[$imageType][$product->getId()] = $image;
                }
                // add medium sized main image and additional gallery images - only for product page
                if ($imageType == 'image') {
                    if ($image = $this->_resizeProductImage($product, $imageType, 'medium_image', null, true)) {
                        $imagesByType['medium_image'][$product->getId()] = $image;
                    }
                    if (!empty($additionalImages)) {
                        $imagesByType['additional_images'] = $additionalImages;
                    }
                }
            }

            $array = array(
                'option_labels' => $imagesByLabel,
                Mage_ConfigurableSwatches_Helper_Productimg::MEDIA_IMAGE_TYPE_SMALL => $imagesByType['small_image'],
                'medium_image' => $imagesByType['medium_image'],
                Mage_ConfigurableSwatches_Helper_Productimg::MEDIA_IMAGE_TYPE_BASE => $imagesByType['image'],
                'additional_images' => $imagesByType['additional_images'],
            );

            $product->setConfigurableImagesFallbackArray($array);
        }

        return $product->getConfigurableImagesFallbackArray();
    }

    /**
     * Resize specified type of image on the product for use in the fallback and returns the image URL
     * or returns the image URL for the specified image path if present
     *
     * @param Mage_Catalog_Model_Product $product
     * @param string $type
     * @param string $sizeType
     * @param string $image
     * @param bool $placeholder
     */
    protected function _resizeProductImage($product, $type, $sizeType, $image = null, $placeholder = false)
    {
        $hasTypeData = $product->hasData($type) && $product->getData($type) != 'no_selection';
        if ($image == 'no_selection') {
            $image = null;
        }
        if ($hasTypeData || $image) {
            $keepAspectRatioProduct = Mage::getStoreConfig('intenso/product_page/keep_image_aspect_ratio', Mage::app()->getStore());
            $keepAspectRatioList = Mage::getStoreConfig('intenso/catalog/keep_image_aspect_ratio', Mage::app()->getStore());
            $helper = Mage::helper('catalog/image')
                ->init($product, $type, $image);

            if ($sizeType == 'thumbnail') {
                $width = 68;
                $height = 68;
            } elseif ($sizeType == 'small_image') {
                $width = 430;
                if ($keepAspectRatioList) {
                    $height = null;
                } else {
                    $height = Mage::getStoreConfig('intenso/catalog/catalog_product_height', Mage::app()->getStore());
                }
            } elseif ($sizeType == 'medium_image') {
                $width = 500;
                if ($keepAspectRatioProduct) {
                    $height = null;
                } else {
                    $height = Mage::getStoreConfig('intenso/product_page/image_fixed_height', Mage::app()->getStore());
                }
            } else {
                $width = 1200;
                $height = 1200;
            }

            $helper->resize($width,$height);

            return (string)$helper;
        }
        return false;
    }
}
