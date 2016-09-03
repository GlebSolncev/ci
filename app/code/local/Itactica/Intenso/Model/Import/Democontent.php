<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_Intenso
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_Intenso_Model_Import_Democontent extends Mage_Core_Model_Abstract
{
	/**
     * folder path for import files
     */
	protected function getFilePath() {
		return Mage::getBaseDir('code') . '/local/Itactica/Intenso/etc/import/';
	}

	/**
     * construct
     * @access protected
     * @return void
     */
	public function __construct() {
        parent::__construct();
    }

    /**
	 * import demo categories, products and widgets
	 *
	 * @access public
	 * @return void
	 */
	public function importProducts($demo, $importType, $storeId) {
		set_time_limit (900);
		// delete previous categories from other demos
		$importFileName = 'all_categories.xml';
		try {
			$file = $this->getFilePath() . $importFileName;
			if (!is_readable($file)) {
				Mage::getSingleton('core/session')->addError(Mage::helper('itactica_intenso')->__("Unable to read file: %s", $file));
				die();
			} else {
				$xmlObj = new Varien_Simplexml_Config($file);

				foreach ($xmlObj->getNode($demo)->children() as $node) {
					$deleteCategory = $this->deleteCategory($node, $storeId);
				}
			}
		} catch (Exception $e) {
			Mage::getSingleton('core/session')->addError($e->getMessage());
			Mage::logException($e);
		}

		// create demo categories
		$importFileName = $demo . '_categories.xml';
    	try {
			$file = $this->getFilePath() . $importFileName;
			if (!is_readable($file)) {
				Mage::getSingleton('core/session')->addError(Mage::helper('itactica_intenso')->__("Unable to read file: %s", $file));
				die();
			} else {
				$xmlObj = new Varien_Simplexml_Config($file);

				foreach ($xmlObj->getNode($demo)->children() as $node) {
					$createCategory = $this->createCategory($node, $storeId);
				}
			}
		} catch (Exception $e) {
			Mage::getSingleton('core/session')->addError($e->getMessage());
			Mage::logException($e);
		}

		$this->addAttributeToAttributeSet('color');
		$this->addAttributeToAttributeSet('manufacturer');

		// create demo products
		$importFileName = $demo . '_products.xml';

    	try {
			$file = $this->getFilePath() . $importFileName;
			if (!is_readable($file)) {
				Mage::getSingleton('core/session')->addError(Mage::helper('itactica_intenso')->__("Unable to read file: %s", $file));
				die();
			} else {
				$xmlObj = new Varien_Simplexml_Config($file);

				$count = 0;
				foreach ($xmlObj->getNode('products')->children() as $node) {
					if ($this->createProduct($node, $storeId)) $count++;
				}
			}
		} catch (Exception $e) {
			Mage::getSingleton('core/session')->addError($e->getMessage());
			Mage::logException($e);
		}

		$this->importFeaturedProductWidget($demo, $storeId);

		$this->importFeaturedCategoryWidget($demo, $storeId);

		// Change Index Status to REINDEX REQUIRED
		$indexIds = array(1,2,3,6,7,8,9,10);
		foreach ($indexIds as $id) {
			$index = Mage::getSingleton('index/indexer')->getProcessById($id);
			$index->changeStatus(Mage_Index_Model_Process::STATUS_REQUIRE_REINDEX);
		}

		if ($importType == 'all' || $importType == 'products') {
			Mage::getSingleton('core/session')->addSuccess(Mage::helper('itactica_intenso')->__("Demo content imported."));
		}
    }

    /**
	 * delete categories
	 *
	 * @access private
	 * @param array $node
	 * @return bool | true = category deleted, false = category doesn't exists
	 */
    private function deleteCategory($node, $storeId) {
    	$parentCategoryId = 0;
    	$storeCode = Mage::app()->getStore($storeId)->getCode();
    	$rootCategoryId = Mage::app()->getStore($storeCode)->getRootCategoryId();

    	if ((string)$node->urls) {
    		// get arrays of categories that match the url_key
    		$categories = explode(',',(string)$node->urls);
            $currentCategories = Mage::getModel('catalog/category') 
	            ->getCollection()
	            ->addAttributeToFilter('url_key',array('in' => $categories))
	            ->addAttributeToFilter('parent_id',array('neq' => 0)); // exclude deleted categories

    		// get children of root category
    		$subcategoryCollection = Mage::getModel('catalog/category')
		    	->getCollection()
		    	->addAttributeToSelect(array('id','url_key'))
		    	->addAttributeToFilter('path',array('like' => '1/'.$rootCategoryId . '/%'));

		    if ($subcategoryCollection->getSize() && $currentCategories->getSize()) {
				$children = $subcategoryCollection->getColumnValues('entity_id');
				$currentCategories = $currentCategories->getColumnValues('entity_id');

				$intersect = array_intersect($currentCategories, $children);

				if(sizeof($intersect) > 1) {
					foreach ($intersect as $id) {
						try {
							Mage::getModel('catalog/category')->load($id)->delete();
						} catch (Exception $e) {
							Mage::getSingleton('core/session')->addError($e->getMessage());
							Mage::logException($e);
						}
					}
				}
				return true;
			} else {
				return false;
			}
    	} else {
    		return false;
    	}	
    }

    /**
	 * create category
	 *
	 * @access private
	 * @param array $node
	 * @return bool | true = category created, false = category already exists
	 */
    private function createCategory($node, $storeId) {
    	$parentCategoryId = 0;
    	$storeCode = Mage::app()->getStore($storeId)->getCode();
    	$rootCategoryId = Mage::app()->getStore($storeCode)->getRootCategoryId();

    	if ((string)$node->parent) {
    		// get children of root category
    		$subcategoryCollection = Mage::getModel('catalog/category')
		    	->getCollection()
		    	->addAttributeToSelect(array('id'))
		    	->addAttributeToFilter('path',array('like' => '1/'.$rootCategoryId . '/%'));

			$children = $subcategoryCollection->getColumnValues('entity_id');

    		// get categories that match the url_key
            $parentCategories = Mage::getModel('catalog/category') 
	            ->getCollection()
	            ->addAttributeToFilter('url_key', $node->parent)
	            ->addAttributeToFilter('parent_id',array('neq' => 0)); // filter out deleted categories

            // select the right category according to its root category
            foreach ($parentCategories as $parentCategory) {
            	if (in_array($parentCategory->getId(), $children)) {
            		$parentCategoryId = $parentCategory->getId();
            	}
            }
    	} else {
    		$parentCategoryId = $rootCategoryId;
    	}

    	$parentCategory = Mage::getModel('catalog/category')->load($parentCategoryId);
    	$childCategory = Mage::getModel('catalog/category')->getCollection()
		    ->addIdFilter($parentCategory->getChildren())
		    ->addAttributeToFilter('url_key', $node->url)
		    ->getFirstItem();

		// create new category if doesn't exist
		if ($childCategory->getId() === null) {
			$category = new Mage_Catalog_Model_Category();
			$category->setName($node->name);
			$category->setUrlKey($node->url);
			$category->setIsActive(1);
			$category->setDisplayMode('PRODUCTS');
			$category->setIsAnchor($node->is_anchor);
			$category->setIncludeInMenu($node->include_in_menu);
			$category->setPath($parentCategory->getPath());

			if ($node->thumbnail) {
				$category->setThumbnail($node->thumbnail);
			}
			if ($node->intenso_menu_style) {
				$category->setIntensoMenuStyle($node->intenso_menu_style);
			}
			if ($node->intenso_menu_columns_large) {
				$category->setIntensoMenuColumnsLarge($node->intenso_menu_columns_large);
			}
			if ($node->intenso_menu_columns_medium) {
				$category->setIntensoMenuColumnsMedium($node->intenso_menu_columns_medium);
			}
			if ($node->intenso_menu_right_block_width) {
				$category->setIntensoMenuRightBlockWidth($node->intenso_menu_right_block_width);
			}
			if ($node->intenso_menu_right_block) {
				$category->setIntensoMenuRightBlock($node->intenso_menu_right_block);
			}
			if ($node->intenso_menu_top_block) {
				$category->setIntensoMenuTopBlock($node->intenso_menu_top_block);
			}
			if ($node->intenso_menu_bottom_block) {
				$category->setIntensoMenuBottomBlock($node->intenso_menu_bottom_block);
			} 
			 
			$category->save();
			unset($category);
			return true;
		} else {
			return false;
		}
    }

    /**
	 * create product
	 *
	 * @access private
	 * @param array $node
	 * @return bool | true = product was created, false = product already exists
	 */
    private function createProduct($node, $storeId) {
    	$storeCode = Mage::app()->getStore($storeId)->getCode();
    	$rootCategoryId = Mage::app()->getStore($storeCode)->getRootCategoryId();

    	// get array of category ids
    	$categoriesUrl = explode(',',$node->category_url);
		$categoryCollection = Mage::getModel('catalog/category')
            ->getCollection()
            ->addAttributeToFilter('url_key',array('in' => $categoriesUrl))
            ->addAttributeToFilter('path',array('like' => '1/'.$rootCategoryId . '/%'));

        $categories = $categoryCollection->getColumnValues('entity_id');

	   	// check if product already exists
    	$product = Mage::getModel('catalog/product');
		$product->load($product->getIdBySku((string)$node->sku));
    	if ($product->getId()) {
    		// get current categories
    		$currentCategoryCollection = $product->getCategoryCollection();
    		$currentCategoryIds = $currentCategoryCollection->getColumnValues('entity_id');

    		// merge current and new categories
    		$categoriesMerge = array_unique(array_merge($categories,$currentCategoryIds));

    		// assign categories to the product
    		$product->setCategoryIds($categoriesMerge);
    		$product->save();

    		return false;
    	} else {
			Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
			$store = Mage::getModel('core/store')->load(Mage_Core_Model_App::DISTRO_STORE_ID);
			$newProduct = Mage::getModel('catalog/product');

			// product's visibility
			if ($node->visible == '1') {
				$visibility = Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH;
			} else {
				$visibility = Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE;
			}
			// default attribute set id
			$attributeSetId = Mage::getModel('catalog/product')->getDefaultAttributeSetId();
			try {
				$newProduct
				    ->setStoreId($store->getId()) 
				    ->setWebsiteIds(array(Mage::app()->getStore($store->getId())->getWebsiteId())) 
				    ->setAttributeSetId($attributeSetId)
				    ->setTypeId((string)$node->type) 
				    ->setCreatedAt(strtotime('now')) 
				    ->setUpdatedAt(strtotime('now')) 
				    ->setSku($node->sku)
				    ->setName($node->name) 
				    ->setWeight(1.0000)
				    ->setStatus(1) // product status (1 - enabled, 2 - disabled)
				    ->setTaxClassId(2) // tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
				    ->setVisibility($visibility)
				    ->setCountryOfManufacture($node->country_of_manufacturer) // (2-letter country code)
				    ->setPrice($node->price)
				    ->setMsrpEnabled($node->msrp_enabled)
				    ->setMsrpDisplayActualPriceType($node->msrp_display_type) // (1-on gesture, 2-in cart, 3-before order confirmation, 4-use config)
				    ->setDescription($node->description)
				    ->setShortDescription($node->short_description)
				    ->setMediaGallery(array('images' => array(), 'values' => array())); //media gallery initialization
				    
				if ($node->type != 'downloadable') {
					$newProduct->setStockData(array(
				            'use_config_manage_stock' => 0, //'Use config settings' checkbox
				            'manage_stock' => 1, //manage stock
				            'min_sale_qty' => 1, //Minimum Qty Allowed in Shopping Cart
				            'max_sale_qty' => 10, //Maximum Qty Allowed in Shopping Cart
				            'is_in_stock' => 1, //Stock Availability
				            'qty' => 100 //qty
				        )
				    );
				}

				if ($node->special_price != '') $newProduct->setSpecialPrice($node->special_price);
			    if ($node->news_from_date != '') $newProduct->setNewsFromDate($node->news_from_date);
			    if ($node->news_to_date != '') $newProduct->setNewsToDate($node->news_to_date);
			    if ($node->special_from_date != '') $newProduct->setSpecialFromDate($node->special_from_date);
			    if ($node->special_to_date != '') $newProduct->setSpecialToDate($node->special_to_date);
			    if ($node->msrp != '') $newProduct->setMsrp($node->msrp);
			    if ($node->type == 'downloadable') {
			    	$newProduct->setHasOptions(4);
			    	$newProduct->setLinksExist(true);		    	
			    	$newProduct->setLinksTitle($node->links_title);
			    	$newProduct->setLinksPurchasedSeparately(1);
			    }

			    $newProduct->setCategoryIds($categories);

			    if ($node->manufacturer != '') {
					// if manufacturer doesn't exists then create it
					if (!$this->attributeValueExists('manufacturer', $node->manufacturer)) {
						$this->addAttributeValue('manufacturer', $node->manufacturer);
					}
					$newProduct->setManufacturer($this->attributeValueExists('manufacturer', $node->manufacturer));
				}

				if ($node->color != '') {
					// if color doesn't exists then create it
					if (!$this->attributeValueExists('color', $node->color)) {
						$this->addAttributeValue('color', $node->color);
					}
					$newProduct->setColor($this->attributeValueExists('color', $node->color));
				}

				// if configurable, add associated products and configurable attributes
				if ($node->type == 'configurable') {
					$configurableAttributesArray = explode(',',$node->configurable_attributes);
					$associatedSkuArray = explode(',',$node->associated_sku);
					$attributeIdsArray = array();
				    $configurableProductsData = array();

				    foreach ($configurableAttributesArray as $attribute) {
						$eavAttribute = new Mage_Eav_Model_Mysql4_Entity_Attribute();
	   					$attributeId = $eavAttribute->getIdByCode('catalog_product', $attribute);
	   					$attributeIdsArray[] = $attributeId;

					    foreach ($associatedSkuArray as $productSku) {
					    	$product = Mage::getModel('catalog/product')->loadByAttribute('sku', $productSku);
					    	if ($product) {
					    		$attributeLabel = $product->getResource()->getAttribute($attribute)
					    			->getFrontend()->getValue($product);
					    		$configurableProductsData[$product->getId()] = array(
					    			'0' => array(
							            'label' => $attributeLabel,
							            'attribute_id' => $attributeId,
							            'value_index' => $this->attributeValueExists($attribute, $attributeLabel),
							            'is_percent' => '0',
							            'pricing_value' => '0' 
							        )
					        	);
					    	}
					    }
					}

				    $newProduct->getTypeInstance()->setUsedProductAttributeIds($attributeIdsArray);
				    $configurableAttributesData = $newProduct->getTypeInstance()->getConfigurableAttributesAsArray();
				    $newProduct->setCanSaveConfigurableAttributes(true);
				    $newProduct->setConfigurableAttributesData($configurableAttributesData);
				    $newProduct->setConfigurableProductsData($configurableProductsData);
				}

			    $newProduct->save();

			    // add images - first one gets used as small, thumbnail and base
			    $product = Mage::getModel('catalog/product')->loadByAttribute('sku', $node->sku);
				$imgArray = explode(',',$node->images);
				$count = 0;
			    $mediaAttribute = array (
		            'thumbnail',
		            'small_image',
		            'image'
			    );
			    if (count($imgArray) > 0) {
				    foreach ($imgArray as $image) {   
				    	$imgPath = Mage::getBaseDir('media') . '/theme/import/images/' . $image;
			            if ($count == 0) {
			                $product->addImageToMediaGallery($imgPath, $mediaAttribute, false, false); 
			            } else {
			                $product->addImageToMediaGallery($imgPath, null, false, false);
			            }
			            $count++;
				    }
				}
				$product->save();

				if ($node->type == 'downloadable') {
					$linkfile = array();
			        $samplefile = array();
			        $samplefilePath = Mage::getBaseUrl('media') . '/theme/import/files/' . $node->sample_file;

			        $samplefile[] = array(
			                'file' => $node->sample_file,
			                'name' => $node->name,
			                'size' => 312,
			                'status' => 'new'
			        );

			        $linkfile[] = array(
			                'file' => $node->link_file,
			                'name' => $node->name,
			                'size' => 312,
			                'status' => 'new'
			        );

			        $linkModel = Mage::getModel('downloadable/link')->setData(array(
			                'product_id' => $product->getId(),
			                'sort_order' => 0,
			                'number_of_downloads' => 0, // Unlimited downloads
			                'is_shareable' => 2, // Not shareable
			                'link_url' => $samplefilePath,
			                'link_type' => 'url',
			                'link_file' => json_encode($linkfile),
			                'sample_url' => $samplefilePath,
			                'sample_file' => json_encode($samplefile),
			                'sample_type' => 'url',
			                'use_default_title' => false,
			                'title' => $node->download_title,
			                'default_price' => 0,
			                'price' => 0,
			                'store_id' => 0,
			                'website_id' => $product->getStore()->getWebsiteId(),
			        ));

			        $linkModel->save();

			        $stockItem = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product->getId());
					$stockItemId = $stockItem->getId();
					$stock = array();
					if (!$stockItemId) {
					    $stockItem->setData('product_id', $product->getId());
					    $stockItem->setData('stock_id', 1);
					} else {
					        $stock = $stockItem->getData();
					}
					$stockItem->setIsInStock(1);
					$stockItem->save();	
			    }
			    return true;
			} catch (Exception $e) {
			    Mage::getSingleton('core/session')->addError($e->getMessage());
				Mage::logException($e);
				return false;
			}
		}
	}


	private function addAttributeToAttributeSet($attribute_code) {
		try {
			$attribute_set_name = 'Default';
			$group_name = 'General';

			$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
	        $attribute_set_id = $setup->getAttributeSetId('catalog_product', $attribute_set_name);
	        $attribute_group_id = $setup->getAttributeGroupId('catalog_product', $attribute_set_id, $group_name);
	        $attribute_id = $setup->getAttributeId('catalog_product', $attribute_code);

	        $setup->addAttributeToSet($entityTypeId='catalog_product',$attribute_set_id, $attribute_group_id, $attribute_id);
	    } catch (Exception $e) {
			Mage::getSingleton('core/session')->addError($e->getMessage());
			Mage::logException($e);
		}
	}

	/**
	 * check if attribute value exist
	 *
	 * @access private
	 * @param array $attributeCode
	 * @param array $attributeValue
	 * @return bool
	 */
	private function attributeValueExists($attributeCode, $attributeValue) {
        $attributeModel = Mage::getModel('eav/entity_attribute');
        $attributeOptionsModel = Mage::getModel('eav/entity_attribute_source_table') ;

        $attributeId = $attributeModel->getIdByCode('catalog_product', $attributeCode);
        $attribute = $attributeModel->load($attributeId);
        
        $attributeTable = $attributeOptionsModel->setAttribute($attribute);
        $options = $attributeOptionsModel->getAllOptions(false);
        
        foreach($options as $option) {
            if ($option['label'] == $attributeValue) {
                return $option['value'];
            }
        }
        
        return false;
    }

    /**
	 * add attribute value
	 *
	 * @access private
	 * @param array $attributeCode
	 * @param array $attributeValue
	 * @return bool
	 */
    public function addAttributeValue($attributeCode, $attributeValue) {
        $attributeModel = Mage::getModel('eav/entity_attribute');
        $attributeOptionsModel = Mage::getModel('eav/entity_attribute_source_table') ;

        $attributeId = $attributeModel->getIdByCode('catalog_product', $attributeCode);
        $attribute = $attributeModel->load($attributeId);
        
        $attributeTable = $attributeOptionsModel->setAttribute($attribute);
        $options = $attributeOptionsModel->getAllOptions(false);
        
        if(!$this->attributeValueExists($attributeCode, $attributeValue)) {
            $value['option'] = array($attributeValue,$attributeValue);
            $result = array('value' => $value);
            $attribute->setData('option',$result);
            $attribute->save();
        }
        
        foreach($options as $option) {
            if ($option['label'] == $attributeValue) {
                return $option['value'];
            }
        }
        return true;
    }
	
	/**
	 * import demo content
	 *
	 * @access public
	 * @param string $importFileName
	 * @param string $model
	 * @param bool $overwrite
	 * @return void
	 */
	public function importDemoContent($demo, $model, $importType, $storeId) {
		if ($model == 'cms/page') {
			$importFileName = $demo . '_pages.xml';
		} else {
			$importFileName = $demo . '_blocks.xml';
		}
		try {
			$file = $this->getFilePath() . $importFileName;
			if (!is_readable($file)) {
				Mage::getSingleton('core/session')->addError(Mage::helper('itactica_intenso')->__("Unable to read file: %s", $file));
				die();
			} else {
				$xmlObj = new Varien_Simplexml_Config($file);
				
				$i = 0;
				foreach ($xmlObj->getNode('democontent')->children() as $node) {
					$storeIds = array($storeId);
					$websites = Mage::app()->getWebsites();
					$defaultStoreId = $websites[1]->getDefaultStore()->getId();
					// adds default store id if scope passed is Default Config
					if ($storeId == 0) {
						$storeIds[] = $defaultStoreId;
					} elseif ($storeId == $defaultStoreId) {
						$storeIds[] = 0;
					}
					// check if block/page already exists
					$oldBlocks = Mage::getModel($model)->getCollection()
						->addStoreFilter($storeIds, false)
						->addFieldToFilter('identifier', $node->identifier)
						->load();

					if (count($oldBlocks) > 0) {
						foreach ($oldBlocks as $old) {
							$old->delete();
						}
					}
					$cmsPageData = array(
						'title' => $node->title,
						'identifier' => $node->identifier,
						'stores' => array($storeId),
						'content' => $node->content,
						'root_template' => $node->template,
						'is_active' => $node->is_active
					);

					Mage::getModel($model)->setData($cmsPageData)->save();
					$i++;
				}
			}
			
		} catch (Exception $e) {
			Mage::getSingleton('core/session')->addError($e->getMessage());
			Mage::logException($e);
		}

		if ($importType == 'cmspages' || $importType == 'staticblocks') {
			Mage::getSingleton('core/session')->addSuccess(Mage::helper('itactica_intenso')->__("Demo content imported."));
		}
    }

    /**
	 * import demo sliders
	 *
	 * @access public
	 * @return void
	 */
	public function importDemoSliders($demo, $importType, $storeId) {
		$importSlidesFileName = $demo . '_orbit_slides.xml';
		$importSliderFileName = $demo . '_orbit_slider.xml';
		$storeCode = Mage::app()->getStore($storeId)->getCode();
    	$rootCategoryId = Mage::app()->getStore($storeCode)->getRootCategoryId();

		try {
			$slideModel = Mage::getModel('itactica_orbitslider/slides');
			$file = $this->getFilePath() . $importSlidesFileName;
			if (!is_readable($file)) {
				Mage::getSingleton('core/session')->addError(Mage::helper('itactica_intenso')->__("Unable to read file: %s", $file));
				die();
			} else {
				$xmlObj = new Varien_Simplexml_Config($file);

				$i = 0;
				$slides = array();
				foreach ($xmlObj->getNode('democontent')->children() as $data) {
					// check if slide with same name already exists and delete it
					$oldContent = Mage::getModel('itactica_orbitslider/slides')
						->setStoreId(Mage::app()->getStore()->getId())->loadByTitle($data->title);
					if (count($oldContent) > 0) {
						$oldContent->delete();
					}
					// add slide
					$slideModel->setData(get_object_vars($data));
	                $slideId = $slideModel->save()->getId();
	                $slideModel->unsetData();
	                $slides[$slideId] = (string)$data->title;
	                $i++;
				}
			}

		} catch (Exception $e) {
			Mage::getSingleton('core/session')->addError($e->getMessage());
			Mage::logException($e);
		}

		try {
			$sliderModel = Mage::getModel('itactica_orbitslider/slider');
			$file = $this->getFilePath() . $importSliderFileName;
			if (is_readable($file)) {
				$xmlObj = new Varien_Simplexml_Config($file);

				$i = 0;
				$orbitSliders = array();
				$sliderIds = array();
				foreach ($xmlObj->getNode('democontent')->children() as $data) {
					// check if widget with same identifier already exists and delete it
					$oldContent = Mage::getModel('itactica_orbitslider/slider')
						->setStoreId(Mage::app()->getStore()->getId())->loadByIdentifier($data->identifier);
					if (count($oldContent) > 0) {
						$oldContent->delete();
					}
					// add widget instance
					$sliderModel->setData(get_object_vars($data));
	                $sliderId = $sliderModel->save()->getId();
	                $sliderIds[$sliderId] = $data->identifier;
	                $sliderModel->unsetData();
	                $i++;

	                if ($data->add_to_category_url) {
	                	$addToCat = (array)$data->add_to_category_url;
	                	if (array_key_exists('item', $addToCat)) {
		                	if (!is_array($addToCat['item'])) $addToCat['item'] = array($addToCat['item']);
		                	foreach ($addToCat['item'] as $catUrl) {
		                		$orbitSliders[(string)$catUrl] = (int)$sliderId;
		                	}
		                }
	                }
				}
			}

		} catch (Exception $e) {
			Mage::getSingleton('core/session')->addError($e->getMessage());
			Mage::logException($e);
		}

		// save slide-slider relation
		try {
			if (is_readable($file)) {
				$sliderSlidesModel = Mage::getResourceModel('itactica_orbitslider/slider_slides');
				$slideSliderRelation = array();
				foreach ($xmlObj->getNode('democontent')->children() as $data) {
					$relatedSlides = (array)$data->slides; // slides titles
					if (array_key_exists('item', $relatedSlides)) {
						if (!is_array($relatedSlides['item'])) $relatedSlides['item'] = array($relatedSlides['item']);
						// get slide Ids from titles
						foreach ($relatedSlides['item'] as $title) {
							if (array_search($title, $slides) > 0) {
								$slideSliderRelation[array_search($title, $slides)] = array_search($data->identifier, $sliderIds);
							}
						}
					}
				}
				$sliderSlidesModel->saveDemoSlidesRelation($slideSliderRelation);
			}
		} catch (Exception $e) {
			Mage::getSingleton('core/session')->addError($e->getMessage());
			Mage::logException($e);
		}			

		// save category-orbitslider relation
		try {
			if ($orbitSliders) {
				foreach ($orbitSliders as $catUrl => $sliderId){
					// get category id by url
					$category = Mage::getModel ('catalog/category')
			            ->getCollection ()
			            ->addAttributeToFilter ('url_key', $catUrl)
			            ->addAttributeToFilter('path',array('like' => '1/'.$rootCategoryId . '/%'))
					    ->addAttributeToFilter('parent_id',array('neq' => 0)) // filter out deleted categories
			            ->getFirstItem();
					// save attribute
			        if ($category) {
						$category->setCategoryOrbitslider($sliderId);
						$category->save();
						$category->unsetData();
					}
				}
			}
		} catch (Exception $e) {
			Mage::getSingleton('core/session')->addError($e->getMessage());
			Mage::logException($e);
		}

		if ($importType == 'imagesliders') {
			Mage::getSingleton('core/session')->addSuccess(Mage::helper('itactica_intenso')->__("Demo content imported."));
		}
	}

	/**
	 * import demo featured products widget
	 *
	 * @access public
	 * @return void
	 */
	public function importFeaturedProductWidget($demo, $storeId) {
		$importFileName = $demo . '_featured_products.xml';
		$storeCode = Mage::app()->getStore($storeId)->getCode();
    	$rootCategoryId = Mage::app()->getStore($storeCode)->getRootCategoryId();

		try {
			$file = $this->getFilePath() . $importFileName;
			if (!is_readable($file)) {
				Mage::getSingleton('core/session')->addError(Mage::helper('itactica_intenso')->__("Unable to read file: %s", $file));
				die();
			} else {
				$xmlObj = new Varien_Simplexml_Config($file);

				$i = 0;
				foreach ($xmlObj->getNode('democontent')->children() as $data) {
					// check if widget with same identifier already exists and delete it
					$oldContent = Mage::getModel('itactica_featuredproducts/slider')
						->setStoreId(Mage::app()->getStore()->getId())->loadByIdentifier($data->identifier);
					if (count($oldContent) > 0) {
						$oldContent->delete();
					}
					// add widget instance
					$featuredSlider = Mage::getModel('itactica_featuredproducts/slider');
					$featuredSlider->addData(get_object_vars($data));

					if ($data->category_url) {
						$categoryIds = array();
						$catUrls = (array)$data->category_url;
						if (array_key_exists('item', $catUrls)) {
							if (!is_array($catUrls['item'])) $catUrls['item'] = array($catUrls['item']);
							foreach ($catUrls['item'] as $categoryURL) {
								$categoryId = Mage::getModel('catalog/category')
						            ->getCollection ()
						            ->addAttributeToFilter('url_key', $categoryURL)
						            ->addAttributeToFilter('path',array('like' => '1/'.$rootCategoryId . '/%'))
						            ->addAttributeToFilter('parent_id',array('neq' => 0)) // filter out deleted categories
						            ->getFirstItem()
						            ->getId();
						        if ($categoryId > 0) {
						        	$categoryIds[] = $categoryId;
						        }
							}
							$featuredSlider->setCategoryIds(implode(',',$categoryIds));
						}
					}
	                $featuredSlider->save();
	                unset($featuredSlider);
	                $i++;
				}
			}

		} catch (Exception $e) {
			Mage::getSingleton('core/session')->addError($e->getMessage());
			Mage::logException($e);
		}
	}

	/**
	 * import demo featured products widget
	 *
	 * @access public
	 * @return void
	 */
	public function importFeaturedCategoryWidget($demo, $storeId) {
		$importFileName = $demo . '_featured_category.xml';
		$storeCode = Mage::app()->getStore($storeId)->getCode();
    	$rootCategoryId = Mage::app()->getStore($storeCode)->getRootCategoryId();

		try {
			$featuredSlider = Mage::getModel('itactica_featuredcategories/slider');
			$file = $this->getFilePath() . $importFileName;
			if (!is_readable($file)) {
				Mage::getSingleton('core/session')->addError(Mage::helper('itactica_intenso')->__("Unable to read file: %s", $file));
				die();
			} else {
				$xmlObj = new Varien_Simplexml_Config($file);

				$i = 0;
				$featuredSliders = array();
				foreach ($xmlObj->getNode('democontent')->children() as $data) {
					// check if widget with same identifier already exists and delete it
					$oldContent = Mage::getModel('itactica_featuredcategories/slider')
						->setStoreId(Mage::app()->getStore()->getId())->loadByIdentifier($data->identifier);
					if (count($oldContent) > 0) {
						$oldContent->delete();
					}
					// add widget instance
					$featuredSlider->addData(get_object_vars($data));
	                $sliderId = $featuredSlider->save()->getId();
	                $featuredSlider->unsetData();
	                $i++;

					if ($data->add_to_category_url) {
						$addToCat = (array)$data->add_to_category_url;
						if (array_key_exists('item', $addToCat)) {
							if (!is_array($addToCat['item'])) $addToCat['item'] = array($addToCat['item']);
		                	foreach ($addToCat['item'] as $catUrl) {
		                		$featuredSliders[(string)$catUrl][] = (int)$sliderId;
		                	}
		                }
	                }

	                try {
						$sliderCategoryModel = Mage::getModel('itactica_featuredcategories/slider_category');

						$j = 0;
						$catUrls = (array)$data->categories;
						if (array_key_exists('item', $catUrls)) {
							if (!is_array($catUrls['item'])) $catUrls['item'] = array($catUrls['item']);
							foreach ($catUrls['item'] as $categoryURL) {
								$categoryId = Mage::getModel ('catalog/category')
						            ->getCollection ()
						            ->addAttributeToFilter ('url_key', $categoryURL)
						            ->addAttributeToFilter('path',array('like' => '1/'.$rootCategoryId . '/%'))
						            ->addAttributeToFilter('parent_id',array('neq' => 0)) // filter out deleted categories
						            ->getFirstItem()
						            ->getId();
						        if ($categoryId > 0) {
									$j++;
									$sliderCategoryModel->setData(array('slider_id' => $sliderId, 'category_id' => $categoryId, 'position' => $j));
					            	$sliderCategoryModel->save();
						        }
							}
						}
					} catch (Exception $e) {
						Mage::getSingleton('core/session')->addError($e->getMessage());
						Mage::logException($e);
					}
				}
			}

		} catch (Exception $e) {
			Mage::getSingleton('core/session')->addError($e->getMessage());
			Mage::logException($e);
		}

		// save category-featuredslider relation
		try {
			if ($featuredSliders) {
				foreach ($featuredSliders as $catUrl => $sliderId){
					// get category id by url
					$category = Mage::getModel('catalog/category')
			            ->getCollection ()
			            ->addAttributeToFilter('url_key', $catUrl)
			            ->addAttributeToFilter('path',array('like' => '1/'.$rootCategoryId . '/%'))
					    ->addAttributeToFilter('parent_id',array('neq' => 0)) // filter out deleted categories
			            ->getFirstItem();
					// save attribute
			        if ($category) {
			        	$category->setFeaturedCategorySlider($sliderId);
						$category->save();
						$category->unsetData();
					}
					
				}
			}
		} catch (Exception $e) {
			Mage::getSingleton('core/session')->addError($e->getMessage());
			Mage::logException($e);
		}
	}

	/**
	 * import demo logo slider widget
	 *
	 * @access public
	 * @return void
	 */
	public function importLogoSliderWidget($demo, $importType, $storeId) {
		$sliderId = 0;
		$importLogosFileName = $demo .'_logos.xml';
		$importSliderFileName = $demo . '_logo_slider.xml';
		$storeCode = Mage::app()->getStore($storeId)->getCode();
    	$rootCategoryId = Mage::app()->getStore($storeCode)->getRootCategoryId();

		try {
			$logoModel = Mage::getModel('itactica_logoslider/logo');
			$file = $this->getFilePath() . $importLogosFileName;
			if (!is_readable($file)) {
				Mage::getSingleton('core/session')->addError(Mage::helper('itactica_intenso')->__("Unable to read file: %s", $file));
				die();
			} else {
				$xmlObj = new Varien_Simplexml_Config($file);

				$i = 0;
				$logos = array();
				foreach ($xmlObj->getNode('democontent')->children() as $data) {
					// check if a logo with the same name already exists and delete it
					$oldContent = Mage::getModel('itactica_logoslider/logo')
						->setStoreId(Mage::app()->getStore()->getId())->loadByTitle($data->title);
					if (count($oldContent) > 0) {
						$oldContent->delete();
					}
					$logoModel->setData(get_object_vars($data));
	                $logoId = $logoModel->save()->getId();
	                $logoModel->unsetData();
	                $logos[] = $logoId;
	                $i++;
				}
			}

		} catch (Exception $e) {
			Mage::getSingleton('core/session')->addError($e->getMessage());
			Mage::logException($e);
		}

		try {
			$sliderModel = Mage::getModel('itactica_logoslider/slider');
			$file = $this->getFilePath() . $importSliderFileName;
			if (is_readable($file)) {
				$xmlObj = new Varien_Simplexml_Config($file);

				$i = 0;
				$logoSliders = array();
				foreach ($xmlObj->getNode('democontent')->children() as $data) {
					// check if widget with same identifier already exists and delete it
					$oldContent = Mage::getModel('itactica_logoslider/slider')
						->setStoreId(Mage::app()->getStore()->getId())->loadByIdentifier($data->identifier);
					if (count($oldContent) > 0) {
						$oldContent->delete();
					}
					// add widget instance
					$sliderModel->setData(get_object_vars($data));
	                $sliderId = $sliderModel->save()->getId();
	                $sliderModel->unsetData();
	                $i++;

	                if ($data->add_to_category_url) {
	                	$catUrls = (array)$data->add_to_category_url;
	                	if (array_key_exists('item', $catUrls)) {
		                	if (!is_array($catUrls['item'])) $catUrls['item'] = array($catUrls['item']);
		                	foreach ($catUrls['item'] as $catUrl) {
		                		$logoSliders[(string)$catUrl] = (int)$sliderId;
		                	}
		                }
	                }
				}
			}

		} catch (Exception $e) {
			Mage::getSingleton('core/session')->addError($e->getMessage());
			Mage::logException($e);
		}

		if ($sliderId > 0) {
			try {
				$sliderLogosModel = Mage::getModel('itactica_logoslider/slider_logos');

				$i = 0;
				foreach ($logos as $logoId) {
					$logoRelationCollection = Mage::getModel('itactica_logoslider/slider_logos')
						->getCollection()
						->addFieldToFilter('slider_id',$sliderId)
						->addFieldToFilter('logo_id',$logoId)->getFirstItem();
					if ($logoRelationCollection->getRelId() > 0) { 
						// relation already exist
					} else {
						$i++;
						$sliderLogosModel->setData(array('slider_id' => $sliderId, 'logo_id' => $logoId, 'position' => $i));
		            	$sliderLogosModel->save();
		            }
				}

			} catch (Exception $e) {
				Mage::getSingleton('core/session')->addError($e->getMessage());
				Mage::logException($e);
			}			
		} else {
			Mage::getSingleton('core/session')->addNotice(Mage::helper('itactica_intenso')
				->__('Unable to create logo/slider relationship'));
		}

		// save category-logoslider relation
		try {
			if ($logoSliders) {
				foreach ($logoSliders as $catUrl => $sliderId){
					// get category id by url
					$category = Mage::getModel('catalog/category')
			            ->getCollection ()
			            ->addAttributeToFilter('url_key', $catUrl)
			            ->addAttributeToFilter('path',array('like' => '1/'.$rootCategoryId . '/%'))
					    ->addAttributeToFilter('parent_id',array('neq' => 0)) // filter out deleted categories
			            ->getFirstItem();
					// save attribute
			        if ($category) {
			        	$category->setCategoryLogoslider($sliderId);
						$category->save();
						$category->unsetData();
					}
				}
			}
		} catch (Exception $e) {
			Mage::getSingleton('core/session')->addError($e->getMessage());
			Mage::logException($e);
		}

		if ($importType == 'logosliders') {
			Mage::getSingleton('core/session')->addSuccess(Mage::helper('itactica_intenso')->__("Demo content imported."));
		}
	}

	/**
	 * import demo logo slider widget
	 *
	 * @access public
	 * @return void
	 */
	public function importConfiguration($demo, $importType, $currentScope) {
		$importConfigFileName = $demo .'_configuration.xml';
		try {
			$file = $this->getFilePath() . $importConfigFileName;
			if (!is_readable($file)) {
				Mage::getSingleton('core/session')->addError(Mage::helper('itactica_intenso')->__("Unable to read file: %s", $file));
				die();
			} else {
				$xmlObj = new Varien_Simplexml_Config($file);

				$i = 0;
				foreach ($xmlObj->getNode('democontent')->children() as $data) {
					foreach ($data as $path => $value) {
						// get config path (convert camel-case/underscore path from the XML file to underscore/slash)
						$path = str_replace('_', '/', $path);
						$path = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $path));
						// get scope and scope_id of config data to be saved
						$configScope = explode("_", $currentScope);
						if ($configScope[0] == 'website') {
							$scope = 'websites';
							$scopeId = Mage::app()->getWebsite(str_replace('website_','',$currentScope))->getId();
							$storeCode = false;
							$websiteCode = false;
						} elseif ($configScope[0] == 'store') {
							$scope = 'stores';
							$storeCode = str_replace('store_','',$currentScope);
							$scopeId = Mage::app()->getStore($storeCode)->getId();
							$websiteCode = Mage::getModel('core/store')->load($scopeId)->getWebsite()->getCode();
						} else {
							$scope = 'default';
							$scopeId = 0;
							// get default store and website code
							$websites = Mage::app()->getWebsites();
							$storeCode = $websites[1]->getDefaultStore()->getCode();
							$websiteCode = $websites[1]->getCode();
						}
						Mage::getConfig()->saveConfig($path, $value, $scope, $scopeId);
					}
				}
				Mage::getConfig()->reinit();
            	Mage::app()->reinitStores();

				Mage::getSingleton('itactica_intenso/css_generator')->generateCssFromConfig($storeCode, $websiteCode);
			}
		} catch (Exception $e) {
			Mage::getSingleton('core/session')->addError($e->getMessage());
			Mage::logException($e);
		}

		if ($importType == 'configuration') {
			Mage::getSingleton('core/session')->addSuccess(Mage::helper('itactica_intenso')->__("Demo content imported."));
		}
	}

	/**
	 * import demo text boxes widget
	 *
	 * @access public
	 * @return void
	 */
	public function importTextBoxesWidget($demo, $importType) {
		$importFileName = $demo . '_text_boxes.xml';

		try {
			$file = $this->getFilePath() . $importFileName;
			if (!is_readable($file)) {
				Mage::getSingleton('core/session')->addError(Mage::helper('itactica_intenso')->__("Unable to read file: %s", $file));
				die();
			} else {
				$xmlObj = new Varien_Simplexml_Config($file);

				$i = 0;
				foreach ($xmlObj->getNode('democontent')->children() as $data) {
					// check if widget with same identifier already exists and delete it
					$oldContent = Mage::getModel('itactica_textboxes/box')
						->setStoreId(Mage::app()->getStore()->getId())->loadByIdentifier($data->identifier);
					if (count($oldContent) > 0) {
						$oldContent->delete();
					}
					// add widget instance
					$textBoxes = Mage::getModel('itactica_textboxes/box');
					$textBoxes->addData(get_object_vars($data));
	                $textBoxes->save();
	                unset($textBoxes);
	                $i++;
				}
			}

		} catch (Exception $e) {
			Mage::getSingleton('core/session')->addError($e->getMessage());
			Mage::logException($e);
		}

		if ($importType == 'textboxes') {
			Mage::getSingleton('core/session')->addSuccess(Mage::helper('itactica_intenso')->__("Demo content imported."));
		}
	}

	/**
	 * import demo billboard widget
	 *
	 * @access public
	 * @return void
	 */
	public function importBillboardWidget($demo, $importType) {
		$importFileName = $demo . '_billboard.xml';

		try {
			$file = $this->getFilePath() . $importFileName;
			if (!is_readable($file)) {
				Mage::getSingleton('core/session')->addError(Mage::helper('itactica_intenso')->__("Unable to read file: %s", $file));
				die();
			} else {
				$xmlObj = new Varien_Simplexml_Config($file);

				$i = 0;
				foreach ($xmlObj->getNode('democontent')->children() as $data) {
					// check if widget with same identifier already exists and delete it
					$oldContent = Mage::getModel('itactica_billboard/unit')
						->setStoreId(Mage::app()->getStore()->getId())->loadByIdentifier($data->identifier);
					if (count($oldContent) > 0) {
						$oldContent->delete();
					}
					// add widget instance
					$billboard = Mage::getModel('itactica_billboard/unit');
					$billboard->addData(get_object_vars($data));
	                $billboard->save();
	                unset($billboard);
	                $i++;
				}
			}

		} catch (Exception $e) {
			Mage::getSingleton('core/session')->addError($e->getMessage());
			Mage::logException($e);
		}

		if ($importType == 'billboard') {
			Mage::getSingleton('core/session')->addSuccess(Mage::helper('itactica_intenso')->__("Demo content imported."));
		}
	}

	/**
	 * import demo CTA widget
	 *
	 * @access public
	 * @return void
	 */
	public function importCallToActionWidget($demo, $importType) {
		$importFileName = $demo . '_calltoaction.xml';

		try {
			$file = $this->getFilePath() . $importFileName;
			if (!is_readable($file)) {
				Mage::getSingleton('core/session')->addError(Mage::helper('itactica_intenso')->__("Unable to read file: %s", $file));
				die();
			} else {
				$xmlObj = new Varien_Simplexml_Config($file);

				$i = 0;
				foreach ($xmlObj->getNode('democontent')->children() as $data) {
					// check if widget with same identifier already exists and delete it
					$oldContent = Mage::getModel('itactica_calltoaction/cta')
						->setStoreId(Mage::app()->getStore()->getId())->loadByIdentifier($data->identifier);
					if (count($oldContent) > 0) {
						$oldContent->delete();
					}
					// add widget instance
					$cta = Mage::getModel('itactica_calltoaction/cta');
					$cta->addData(get_object_vars($data));
	                $cta->save();
	                unset($cta);
	                $i++;
				}
			}

		} catch (Exception $e) {
			Mage::getSingleton('core/session')->addError($e->getMessage());
			Mage::logException($e);
		}

		if ($importType == 'calltoaction') {
			Mage::getSingleton('core/session')->addSuccess(Mage::helper('itactica_intenso')->__("Demo content imported."));
		}
	}
}