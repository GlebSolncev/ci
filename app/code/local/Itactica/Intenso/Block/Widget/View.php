<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_Intenso
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_Intenso_Block_Widget_View extends Mage_Core_Block_Template implements Mage_Widget_Block_Interface
{
    /**
     * template route
     * @var string
     */
    protected $_htmlTemplate = 'itactica_intenso/widget/view.phtml';

    /**
     * Prepare widget
     * @access protected
     * @return Itactica_Intenso_Block_Slider_Widget_View
     */
    protected function _beforeToHtml() {
        parent::_beforeToHtml();
        $_cartCount = $this->helper('checkout/cart')->getSummaryCount();
        if (!$_cartCount > 0) {
            $_cartCount = 0;
        }
        $this->setCartCount($_cartCount);
        $this->setTemplate($this->_htmlTemplate);
        return $this;
    }
}
