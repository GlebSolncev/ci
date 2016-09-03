<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_LayeredNavigation
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

require_once 'Mage/Catalog/controllers/CategoryController.php';

class Itactica_LayeredNavigation_CategoryController extends Mage_Catalog_CategoryController
{

    public function viewAction()
    {
        if (($category = $this->_initCatagory())) {
            $design = Mage::getSingleton('catalog/design');
            $settings = $design->getDesignSettings($category);

            // apply custom design
            if ($settings->getCustomDesign()) {
                $design->applyCustomDesign($settings->getCustomDesign());
            }

            Mage::getSingleton('catalog/session')->setLastViewedCategoryId($category->getId());

            $update = $this->getLayout()->getUpdate();
            $update->addHandle('default');

            if (!$category->hasChildren()) {
                $update->addHandle('catalog_category_layered_nochildren');
            }

            $this->addActionLayoutHandles();
            $update->addHandle($category->getLayoutUpdateHandle());
            $update->addHandle('CATEGORY_' . $category->getId());
            // apply custom ajax layout
            if ($this->getRequest()->isAjax()) {
                $update->addHandle('catalog_category_layered_ajax_layer');
            }
            $this->loadLayoutUpdates();

            // apply custom layout update once layout is loaded
            if (($layoutUpdates = $settings->getLayoutUpdates())) {
                if (is_array($layoutUpdates)) {
                    foreach ($layoutUpdates as $layoutUpdate) {
                        $update->addUpdate($layoutUpdate);
                    }
                }
            }

            $this->generateLayoutXml()->generateLayoutBlocks();
            // apply custom layout (page) template once the blocks are generated
            if ($settings->getPageLayout()) {
                $this->getLayout()->helper('page/layout')->applyTemplate($settings->getPageLayout());
            }

            if (($root = $this->getLayout()->getBlock('root'))) {
                $root->addBodyClass('categorypath-' . $category->getUrlPath())
                    ->addBodyClass('category-' . $category->getUrlKey());
            }

            $this->_initLayoutMessages('catalog/session');
            $this->_initLayoutMessages('checkout/session');

            // return json formatted response for ajax
            if ($this->getRequest()->isAjax()) {
                $listing = $this->getLayout()->getBlock('product_list')->toHtml();
                $layer = $this->getLayout()->getBlock('catalog.leftnav')->toHtml();
                
                // Fix urls that contain '___SID=U'
                $urlModel = Mage::getSingleton('core/url');
                $listing = $urlModel->sessionUrlVar($listing);
                $layer = $urlModel->sessionUrlVar($layer);

                $catalogLayer = Mage::getSingleton('catalog/layer');

                // get name of child category
                $appliedFilters = $catalogLayer->getState()->getFilters();
                $CategoryName = $category->getName();
                $appliedFiltersCount = 0;
                foreach ($appliedFilters as $item) {
                    if ($item->getFilter()->getRequestVar() == 'cat') {
                        $CategoryName = $item->getLabel();
                    }
                    $appliedFiltersCount ++;
                }

                // link to clear all filters
                $clearUrl = Mage::helper('itactica_layerednavigation')->getClearFiltersUrl();
                $clearLink = '';
                if ($appliedFiltersCount > 0) {
                    $clearLink = '<a href="'.$clearUrl.'" class="filter-reset">'. $this->__('Reset Filters') .'</a>';
                }

                // amount
                $lastPageNum = $catalogLayer->getProductCollection()->getLastPageNumber();
                $size = $catalogLayer->getProductCollection()->getSize();
                if ($lastPageNum > 1) {
                    $curPage = $catalogLayer->getProductCollection()->getCurPage();
                    $count = $catalogLayer->getProductCollection()->count();
                    $limit = $catalogLayer->getProductCollection()->getPageSize();
                    $firstNum = $limit * ($curPage - 1) + 1;
                    $lastNum = $limit * ($curPage - 1) + $count;
                    $amount = $this->__('Items %s to %s of %s total', $firstNum, $lastNum, $size);
                } else {
                    $amount = '<strong>'. $this->__('%s Item(s)', $size) . '</strong>';
                }

                // toolbar pager
                $toolbar= Mage::getBlockSingleton('catalog/product_list')->getToolbarBlock()->setTemplate('catalog/product/list/pager.phtml');
                $toolbar->setCollection($catalogLayer->getProductCollection());
                $pager = $this->getLayout()->createBlock('itactica_layerednavigation/catalog_product_list_pager', 'product_list_toolbar_pager');
                $toolbar->setChild('product_list_toolbar_pager', $pager);

                // orders
                $toolbarSingleton = Mage::getBlockSingleton('catalog/product_list_toolbar');
                $availableOrders = $toolbarSingleton->getAvailableOrders();
                $orders = '';
                foreach ($availableOrders as $_key=>$_order) {
                    // ascending order
                    $orders .= '<option value="'. $toolbarSingleton->getOrderUrl($_key, 'asc') .'"';
                    if ($toolbarSingleton->isOrderCurrent($_key)) {
                        $orders .= ' selected="selected">';
                    } else {
                        $orders .= '>';
                    }
                    $orders .= $this->__($_order) . ' ' . $this->__('asc.') . '</option>';
                    // descending order
                    $orders .= '<option value="'. $toolbarSingleton->getOrderUrl($_key, 'desc') .'"';
                    if ($toolbarSingleton->isOrderCurrent($_key)) {
                        $orders .= ' selected="selected">';
                    } else {
                        $orders .= '>';
                    }
                    $orders .= $this->__($_order) . ' ' . $this->__('desc.') . '</option>';
                }

                // limits
                $availableLimit = $toolbarSingleton->getAvailableLimit();
                $limits = '';
                foreach ($availableLimit as $_key=>$_limit) {
                    $limits .= '<option value="'. $toolbarSingleton->getLimitUrl($_key) .'"';
                    if ($toolbarSingleton->isLimitCurrent($_key)) {
                        $limits .= ' selected="selected">';
                    } else {
                        $limits .= '>';
                    }
                    $limits .= $this->__($_limit) . ' ' . $this->__('items per page') . '</option>';
                }

                // response
                $response = array(
                    'listing' => $listing,
                    'layer' => $layer,
                    'categoryName' => $CategoryName,
                    'clearLink' => $clearLink,
                    'amount' => $amount,
                    'pager' => $toolbar->toHtml(),
                    'orders' => $orders,
                    'limits' => $limits
                );

                $this->getResponse()->setHeader('Content-Type', 'application/json', true);
                $this->getResponse()->setBody(json_encode($response));
            } else {
                $this->renderLayout();
            }
        } elseif (!$this->getResponse()->isRedirect()) {
            $this->_forward('noRoute');
        }
    }

}