<?php
/**
 * Intenso Premium Theme
 *
 * @category    Itactica
 * @package     Itactica_Intenso
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */
class Itactica_Intenso_Model_Catalog_Product_Image extends Mage_Catalog_Model_Product_Image
{
    const POSITION_TOP    = 'top';
    const POSITION_BOTTOM = 'bottom';
    const POSITION_CENTER = 'center';

    /**
     * crop position from top
     * @access protected
     * @var float
     */
    protected $_topRate = 0.5;

    /**
     * crop position from bottom
     * @access protected
     * @var float
     */
    protected $_bottomRate = 0.5;

    /**
     * adaptive Resize
     * @access public
     * @return Mage_Catalog_Model_Product_Image
     */
    public function adaptiveResize()
    {
        if (is_null($this->getWidth())) {
            return $this;
        }
        if (is_null($this->getHeight())) {
            $this->setHeight($this->getWidth());
        }
        $processor = $this->getImageProcessor();
        $currentRatio = $processor->getOriginalWidth() / $processor->getOriginalHeight();
        $targetRatio = $this->getWidth() / $this->getHeight();
        if ($targetRatio > $currentRatio) {
            $processor->resize($this->getWidth(), null);
        } else {
            $processor->resize(null, $this->getHeight());
        }
        $diffWidth  = $processor->getOriginalWidth() - $this->getWidth();
        $diffHeight = $processor->getOriginalHeight() - $this->getHeight();
        $processor->crop(
            floor($diffHeight * $this->_topRate),
            floor($diffWidth / 2),
            ceil($diffWidth / 2),
            ceil($diffHeight * $this->_bottomRate)
        );
        return $this;
    }

    /**
     * set crop position
     * @access public
     * @param string $position top, bottom or center
     * @return Mage_Catalog_Model_Product_Image
     */
    public function setCropPosition($position)
    {
        switch ($position) {
            case self::POSITION_TOP:
                $this->_topRate    = 0;
                $this->_bottomRate = 1;
                break;
            case self::POSITION_BOTTOM:
                $this->_topRate    = 1;
                $this->_bottomRate = 0;
                break;
            default:
                $this->_topRate    = 0.5;
                $this->_bottomRate = 0.5;
        }
        return $this;
    }
}