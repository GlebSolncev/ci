<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_LayeredNavigation
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

require_once 'Mage/CatalogSearch/controllers/ResultController.php';

class Itactica_LayeredNavigation_ResultController extends Mage_CatalogSearch_ResultController
{

    /**
     * Display search result
     */
    public function indexAction()
    {
        $query = Mage::helper('catalogsearch')->getQuery();
        /* @var $query Mage_CatalogSearch_Model_Query */

        $query->setStoreId(Mage::app()->getStore()->getId());

        if ($query->getQueryText() != '') {
            if (Mage::helper('catalogsearch')->isMinQueryLength()) {
                $query->setId(0)
                    ->setIsActive(1)
                    ->setIsProcessed(1);
            } else {
                if ($query->getId()) {
                    $query->setPopularity($query->getPopularity() + 1);
                } else {
                    $query->setPopularity(1);
                }

                if ($query->getRedirect()) {
                    $query->save();
                    $this->getResponse()->setRedirect($query->getRedirect());
                    return;
                } else {
                    $query->prepare();
                }
            }

            Mage::helper('catalogsearch')->checkNotes();

            $this->loadLayout();
            // apply custom ajax layout
            if ($this->getRequest()->isAjax()) {
                $update = $this->getLayout()->getUpdate();
                $update->addHandle('catalog_category_layered_ajax_layer');
            }
            $this->_initLayoutMessages('catalog/session');
            $this->_initLayoutMessages('checkout/session');

            // return json formatted response for ajax
            if ($this->getRequest()->isAjax()) {
                $listing = $this->getLayout()->getBlock('search_result_list')->toHtml();
                $layer = $this->getLayout()->getBlock('catalogsearch.leftnav')->toHtml();
                
                // fix urls that contain '___SID=U'
                $urlModel = Mage::getSingleton('core/url');
                $listing = $urlModel->sessionUrlVar($listing);
                $layer = $urlModel->sessionUrlVar($layer);

                // get query text
                $searchQuery = Mage::helper('catalogsearch')->getQueryText();

                $catalogLayer = Mage::getSingleton('catalogsearch/layer');

                $appliedFilters = $catalogLayer->getState()->getFilters();
                $appliedFiltersCount = 0;
                foreach ($appliedFilters as $item) {
                    $appliedFiltersCount ++;
                }

                // link to clear all filters
                $clearLink = '';
                if ($appliedFiltersCount > 0) {
                    $clearLink = '<a href="?q='.$searchQuery.'" class="filter-reset">'. $this->__('Reset Filters') .'</a>';
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

                $response = array(
                    'listing' => $listing,
                    'layer' => $layer,
                    'categoryName' => $searchQuery,
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

            if (!Mage::helper('catalogsearch')->isMinQueryLength()) {
                $query->save();
            }
        } else {
            $this->_redirectReferer();
        }
    }

}