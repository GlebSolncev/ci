<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_ExtendedReviews
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_ExtendedReviews_Block_Adminhtml_Comment_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    protected function _construct() {
        parent::_construct();
        $this->setDefaultSort('created_at');
    }

    protected function _prepareCollection() {
        $model = Mage::getModel('itactica_extendedreviews/comment');
        $collection = $model->getCollection();
        $collection->appendReviewTitle();
        if (Mage::registry('usePendingFilter') === true) {
            $collection->addFieldToFilter('status', array('eq' => Mage_Review_Model_Review::STATUS_PENDING));
        }
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        $statuses = Mage::getModel('review/review')
                ->getStatusCollection()
                ->load()
                ->toOptionArray();

        $tmpArr = array();
        foreach ($statuses as $key => $status) {
            $tmpArr[$status['value']] = $status['label'];
        }

        $statuses = $tmpArr;

        $this->addColumn('entity_id', array(
            'header' => Mage::helper('itactica_extendedreviews')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'entity_id',
        ));

        $this->addColumn('created_at', array(
            'header' => Mage::helper('itactica_extendedreviews')->__('Created On'),
            'align' => 'left',
            'type' => 'datetime',
            'width' => '100px',
            'index' => 'created_at',
        ));

        if (!Mage::registry('usePendingFilter')) {
            $this->addColumn('status', array(
                'header' => Mage::helper('itactica_extendedreviews')->__('Status'),
                'align' => 'left',
                'type' => 'options',
                'options' => $statuses,
                'width' => '100px',
                'index' => 'status',
            ));
        }
        $this->addColumn('title', array(
            'header' => Mage::helper('itactica_extendedreviews')->__('Review Title'),
            'align' => 'left',
            'width' => '100px',
            'index' => 'title',
            'type' => 'text',
            'truncate' => 50,
            'escape' => true,
            'nl2br' => true
        ));

        $this->addColumn('nickname', array(
            'header' => Mage::helper('itactica_extendedreviews')->__('Nickname'),
            'align' => 'left',
            'width' => '100px',
            'index' => 'nickname',
            'type' => 'text',
            'truncate' => 50,
            'escape' => true,
        ));

        $this->addColumn('text', array(
            'header' => Mage::helper('itactica_extendedreviews')->__('Comment'),
            'align' => 'left',
            'index' => 'text',
            'type' => 'text',
            'truncate' => 50,
            'nl2br' => true,
            'escape' => true,
        ));

        $this->addColumn('action', array(
            'header' => Mage::helper('adminhtml')->__('Action'),
            'width' => '50px',
            'type' => 'action',
            'getter' => 'getId',
            'actions' => array(
                array(
                    'caption' => Mage::helper('adminhtml')->__('Edit'),
                    'url' => array(
                        'base' => 'adminhtml/catalog_product_review_comment/edit',
                        'params' => array(
                            'ret' => ( Mage::registry('usePendingFilter') ) ? 'pending' : null
                        )
                    ),
                    'field' => 'id'
                )
            ),
            'filter' => false,
            'sortable' => false
        ));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction() {
        $this->setMassactionIdField('entity_id');
        $this->setMassactionIdFieldOnlyIndexValue(true);
        $this->getMassactionBlock()->setFormFieldName('comment');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('itactica_extendedreviews')->__('Delete'),
            'url' => $this->getUrl(
                    '*/*/massDelete', array('ret' => Mage::registry('usePendingFilter') ? 'pending' : 'index')
            ),
            'confirm' => Mage::helper('itactica_extendedreviews')->__('Are you sure?')
        ));

        $statuses = Mage::getModel('review/review')
                ->getStatusCollection()
                ->load()
                ->toOptionArray();
        array_unshift($statuses, array('label' => '', 'value' => ''));
        $this->getMassactionBlock()->addItem('update_status', array(
            'label' => Mage::helper('itactica_extendedreviews')->__('Update Status'),
            'url' => $this->getUrl(
                    '*/*/massUpdateStatus', array('ret' => Mage::registry('usePendingFilter') ? 'pending' : 'index')
            ),
            'additional' => array(
                'status' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('itactica_extendedreviews')->__('Status'),
                    'values' => $statuses
                )
            )
        ));
    }

    public function getRowUrl($row) {
        return $this->getUrl('*/catalog_product_review_comment/edit', array(
                    'id' => $row->getId(),
                    'ret' => ( Mage::registry('usePendingFilter') ) ? 'pending' : null,
        ));
    }

}
