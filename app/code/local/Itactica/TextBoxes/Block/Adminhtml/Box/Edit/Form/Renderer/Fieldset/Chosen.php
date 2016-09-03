<?php
/**
 * Intenso Premium Theme
 *
 * @category    Itactica
 * @package     Itactica_TextBoxes
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */
class Itactica_TextBoxes_Block_Adminhtml_Box_Edit_Form_Renderer_Fieldset_Chosen extends Varien_Data_Form_Element_Abstract
{
    /**
     * javascript files paths
     */
    const JS_JQUERY_PATH        = 'frontend/intenso/default/js/lib/jquery.js';
    const JS_CHOSEN_PATH   = 'frontend/intenso/default/js/lib/chosen.jquery.min.js';

    /**
     * Init Element
     *
     * @param array $attributes
     */
    public function __construct($attributes=array())
    {
        parent::__construct($attributes);
        $this->setType('select');
        $this->setExtType('combobox');
        $this->_prepareOptions();
    }

	/**
     * Add the colorpicker
     *
     * @return string
     */
    public function getElementHtml()
    {
        // javascript paths
        $jQueryPath = Mage::getBaseUrl('skin') . self::JS_JQUERY_PATH;
        $jQueryChosenPath = Mage::getBaseUrl('skin') . self::JS_CHOSEN_PATH;

        $this->addClass('select');
        $html = '<select id="'.$this->getHtmlId().'" name="'.$this->getName().'" '.$this->serialize($this->getHtmlAttributes()).'>'."\n";

        $value = $this->getValue();
        if (!is_array($value)) {
            $value = array($value);
        }

        if ($values = $this->getValues()) {
            foreach ($values as $key => $option) {
                if (!is_array($option)) {
                    $html.= $this->_optionToHtml(array(
                        'value' => $key,
                        'label' => $option),
                        $value
                    );
                }
                elseif (is_array($option['value'])) {
                    $html.='<optgroup label="'.$option['label'].'">'."\n";
                    foreach ($option['value'] as $groupItem) {
                        $html.= $this->_optionToHtml($groupItem, $value);
                    }
                    $html.='</optgroup>'."\n";
                }
                else {
                    $html.= $this->_optionToHtml($option, $value);
                }
            }
        }

        $html.= '</select>'."\n";
        $html.= $this->getAfterElementHtml();
  
        if (!Mage::registry('jquery-loaded')) {
            $html .= '<script type="text/javascript" src="' . $jQueryPath . '"></script>
                <script type="text/javascript">jQuery.noConflict();</script>';
            
            Mage::register('jquery-loaded', true);
        }

        if (!Mage::registry('chosen-loaded')) {
            $html .= '<script type="text/javascript" src="' . $jQueryChosenPath . '"></script>';
            
            Mage::register('chosen-loaded', true);
        }

        $html .= '<script type="text/javascript">
                jQuery("#'.$this->getHtmlId().'").chosen();
            </script>
            ';

        $html.= $this->getAfterElementHtml();
			
        return $html;
    }

    protected function _optionToHtml($option, $selected)
    {
        if (is_array($option['value'])) {
            $html ='<optgroup label="'.$option['label'].'">'."\n";
            foreach ($option['value'] as $groupItem) {
                $html .= $this->_optionToHtml($groupItem, $selected);
            }
            $html .='</optgroup>'."\n";
        }
        else {
            $html = '<option value="'.$this->_escape($option['value']).'"';
            $html.= isset($option['title']) ? 'title="'.$this->_escape($option['title']).'"' : '';
            $html.= isset($option['style']) ? 'style="'.$option['style'].'"' : '';
            if (in_array($option['value'], $selected)) {
                $html.= ' selected="selected"';
            }
            $html.= '>'.$option['label']. '</option>'."\n";
        }
        return $html;
    }

    protected function _prepareOptions()
    {
        $values = $this->getValues();
        if (empty($values)) {
            $options = $this->getOptions();
            if (is_array($options)) {
                $values = array();
                foreach ($options as  $value => $label) {
                    $values[] = array('value' => $value, 'label' => $label);
                }
            } elseif (is_string($options)) {
                $values = array( array('value' => $options, 'label' => $options) );
            }
            $this->setValues($values);
        }
    }

    public function getHtmlAttributes()
    {
        return array('title', 'class', 'style', 'onclick', 'onchange', 'disabled', 'readonly', 'tabindex');
    }
}