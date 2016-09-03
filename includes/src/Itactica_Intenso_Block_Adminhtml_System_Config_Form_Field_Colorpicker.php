<?php
/**
 * Intenso Premium Theme
 *
 * @category    Itactica
 * @package     Itactica_Intenso
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */
class Itactica_Intenso_Block_Adminhtml_System_Config_Form_Field_Colorpicker extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    /**
     * javascript files paths
     */
    const JS_JQUERY_PATH        = 'frontend/intenso/default/js/lib/jquery.js';
    const JS_COLORPICKER_PATH   = 'frontend/intenso/default/js/lib/spectrum.js';

	/**
     * Add the colorpicker
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        // javascript paths
        $jQueryPath = Mage::getBaseUrl('skin') . self::JS_JQUERY_PATH;
        $colorPickerPath = Mage::getBaseUrl('skin') . self::JS_COLORPICKER_PATH;

        // use Varien text element as a basis
        $input = new Varien_Data_Form_Element_Text();

        // set data from config element on Varien text element
        $input->setForm($element->getForm())
            ->setElement($element)
            ->setValue($element->getValue())
            ->setHtmlId('colorpicker-'.$element->getHtmlId())
            ->setName($element->getName())
            ->addClass('colorpicker'); 

        $html = '<div id="'.$element->getHtmlId().'">'.$input->getHtml();
        
        if (!Mage::registry('jquery-loaded')) {
            $html .= '<script type="text/javascript" src="' . $jQueryPath . '"></script>
                <script type="text/javascript">jQuery.noConflict();</script>';
            
            Mage::register('jquery-loaded', true);
        }

        if (!Mage::registry('colorpicker-loaded')) {
            $html .= '<script type="text/javascript" src="' . $colorPickerPath . '"></script>';
            $html .= '<script>
                var paletteColors = [
                    ["#D24D57", "#F22613", "#FF0000", "#D91E18", "#96281B", 
                    "#EF4836", "#D64541", "#C0392B", "#CF000F", "#E74C3C"],
                    ["#DB0A5B", "#FFECDB", "#F64747", "#F1A9A0", "#D2527F",
                    "#E08283", "#F62459", "#E26A6A", "#DCC6E0", "#663399"],
                    ["#674172", "#AEA8D3", "#913D88", "#9A12B3", "#BF55EC",
                    "#BE90D4", "#8E44AD", "#9B59B6", "#E4F1FE", "#4183D7"],
                    ["#59ABE3", "#81CFE0", "#52B3D9", "#C5EFF7", "#22A7F0",
                    "#3498DB", "#2C3E50", "#19B5FE", "#336E7B", "#22313F"],
                    ["#6BB9F0", "#1E8BC3", "#3A539B", "#34495E", "#67809F",
                    "#2574A9", "#1F3A93", "#89C4F4", "#4B77BE", "#5C97BF"],
                    ["#4ECDC4", "#A2DED0", "#87D37C", "#90C695", "#26A65B",
                    "#03C9A9", "#68C3A3", "#65C6BB", "#1BBC9B", "#1BA39C"],
                    ["#66CC99", "#36D7B7", "#C8F7C5", "#86E2D5", "#2ECC71",
                    "#16a085", "#3FC380", "#019875", "#03A678", "#4DAF7C"],
                    ["#27ccc0", "#00B16A", "#1E824C", "#049372", "#26C281",
                    "#FDE3A7", "#F89406", "#EB9532", "#E87E04", "#F4B350"],
                    ["#F2784B", "#EB974E", "#F5AB35", "#D35400", "#F39C12",
                    "#F9690E", "#F9BF3B", "#F27935", "#5b6064", "#ececec"],
                    ["#6C7A89", "#D2D7D3", "#EEEEEE", "#BDC3C7", "#ECF0F1",
                    "#95A5A6", "#DADFE1", "#ABB7B7", "#f4f4f4", "#BFBFBF"]
                ]
                </script>';

            Mage::register('colorpicker-loaded', true);
        }

        $html .= '<script type="text/javascript">
                jQuery("#colorpicker-' . $element->getId() . '").spectrum({
                    showInput: true,
                    showInitial: true,
                    showInput: true,
                    preferredFormat: "hex",
                    allowEmpty: true,
                    showPalette: true,
                    palette: paletteColors
                });
            </script>
            ';

        $html .= '</div>';
			
        return $html;
    }
}