<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_LogoSlider
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_LogoSlider_Model_Resource_Slider_Logos_Collection extends Itactica_LogoSlider_Model_Resource_Logo_Collection
{
    /**
     * remember if fields have been joined
     * @var bool
     */
    protected $_joinedFields = false;
    /**
     * join the link table
     * @access public
     * @return Itactica_LogoSlider_Model_Resource_Slider_Logos_Collection
     */
    public function joinFields(){
        if (!$this->_joinedFields){
            $this->getSelect()->join(
                array('related' => $this->getTable('itactica_logoslider/slider_logos')),
                'related.logo_id = entity_id',
                array('*')
            );
            $this->_joinedFields = true;
        }
        return $this;
    }
    /**
     * add slider filter
     * @access public
     * @param Itactica_LogoSlider_Model_Slider | int $slider
     * @return Itactica_LogoSlider_Model_Resource_Slider_Logos_Collection
     */
    public function addSliderFilter($slider){
        if ($slider instanceof Itactica_LogoSlider_Model_Slider){
            $slider = $slider->getId();
        }
        if (!$this->_joinedFields){
            $this->joinFields();
        }
        $this->getSelect()->where('related.slider_id = ?', $slider);
        return $this;
    }
}
