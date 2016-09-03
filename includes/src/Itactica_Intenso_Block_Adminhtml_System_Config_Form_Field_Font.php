<?php
/**
 * Intenso Premium Theme
 *
 * @category    Itactica
 * @package     Itactica_Intenso
 * @copyright   Copyright (c) 2014 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */
class Itactica_Intenso_Block_Adminhtml_System_Config_Form_Field_Font extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    /**
     * Override field method to add js
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return String
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {

        $characterSubset = '["latin","latin","latin-ext,latin","latin","latin","latin","latin","greek,latin-ext,latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin","latin","latin-ext,latin","latin-ext,latin","vietnamese,latin-ext,latin","vietnamese,latin-ext,latin","latin-ext,latin","latin","latin","latin","latin","latin-ext,latin","latin","latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin","latin-ext,latin","latin","latin","latin","latin-ext,latin","latin-ext,latin","cyrillic,cyrillic-ext,latin-ext,latin","khmer","latin","cyrillic,greek,cyrillic-ext,greek-ext,latin-ext,latin","latin","latin","latin","latin-ext,latin","latin","latin-ext,latin","latin-ext,latin","latin","latin-ext,latin","latin-ext,latin","cyrillic,greek,cyrillic-ext,vietnamese,greek-ext,latin-ext,latin","latin-ext,latin","latin-ext,latin","latin","latin","latin-ext,latin","latin","latin","latin","latin","latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin","latin","latin","cyrillic,latin","latin","latin","latin-ext,latin","khmer","latin","khmer","latin","latin-ext,latin","latin-ext,latin","latin","latin-ext,latin","latin","latin-ext,latin","latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","khmer","latin","latin","latin","latin-ext,latin","latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin","latin","latin","latin","latin","latin","latin","latin","latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","greek,greek-ext,latin-ext,latin","latin","latin","latin","latin","greek,greek-ext,latin-ext,latin","latin","latin","latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","khmer","latin","latin-ext,latin","latin","latin-ext,latin","latin","latin","latin","latin-ext,latin","latin","latin","latin-ext,latin","latin-ext,latin","cyrillic,greek,cyrillic-ext,latin-ext,latin","latin","latin-ext,latin","latin-ext,latin","khmer","latin","latin","latin","latin","latin","latin-ext,latin","cyrillic,greek,cyrillic-ext,vietnamese,greek-ext,latin-ext,latin","latin","latin","latin","latin","latin-ext,latin","latin","latin-ext,latin","latin","cyrillic,latin-ext,latin","latin-ext,latin","latin-ext,latin","latin","latin","khmer","latin","latin","latin","latin","latin","latin","latin-ext,latin","latin-ext,latin","cyrillic,greek,cyrillic-ext,greek-ext,latin-ext,latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin","latin-ext,latin","latin-ext,latin","latin","latin","latin","latin-ext,latin","latin-ext,latin","cyrillic,cyrillic-ext,vietnamese,latin-ext,latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin-ext,latin,devanagari","latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin","latin-ext,latin","latin-ext,latin","latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","cyrillic,latin-ext,latin","latin","latin","latin","latin","latin","khmer","latin-ext,latin","latin","latin","latin-ext,latin","latin-ext,latin","latin","latin-ext,latin","latin","latin","latin","latin-ext,latin","latin","cyrillic,cyrillic-ext,latin-ext,latin","latin-ext,latin","latin-ext,latin","latin","latin","khmer","latin-ext,latin","latin","latin-ext,latin","latin","greek","greek","latin-ext,latin","latin-ext,latin","latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin","latin","latin","latin","latin-ext,latin","latin","latin-ext,latin","latin-ext,latin","latin","latin","latin","latin","latin","latin","latin-ext,latin","latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin","khmer","latin-ext,latin","latin-ext,latin","latin","latin-ext,latin","latin","latin","latin-ext,latin","latin","latin","latin","latin","latin","latin","latin","latin","latin","latin","latin","latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin","latin-ext,latin","latin","cyrillic,cyrillic-ext,latin-ext,latin","latin","latin-ext,latin","latin","latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin","latin","latin-ext,latin","latin","latin","latin-ext,latin","latin","cyrillic,greek,cyrillic-ext,greek-ext,latin-ext,latin","latin","latin-ext,latin","latin","khmer","latin-ext,latin","latin-ext,latin","latin-ext,latin","khmer","latin-ext,latin","cyrillic,latin-ext,latin","latin","khmer","latin","latin-ext,latin","latin-ext,latin","khmer","latin","latin","latin","latin-ext,latin","latin","latin","latin","latin","latin","cyrillic,latin-ext,latin","latin-ext,latin","latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin","cyrillic,cyrillic-ext,latin-ext,latin","latin","latin","latin","latin","latin","cyrillic,latin-ext,latin","latin","latin","latin-ext,latin","latin","latin","latin","latin","latin","latin-ext,latin","latin","latin","latin-ext,latin","latin-ext,latin","cyrillic,latin-ext,latin","latin-ext,latin","latin","cyrillic,latin-ext,latin","latin","latin","latin","latin","latin-ext,latin","latin","latin-ext,latin","latin","latin","latin-ext,latin","latin-ext,latin","latin","latin-ext,latin","latin-ext,latin","khmer","latin-ext,latin","latin-ext,latin","latin","latin","latin-ext,latin","latin","latin","latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin","latin","latin-ext,latin","latin","latin","latin","latin","latin","khmer","khmer","latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin","latin-ext,latin","cyrillic,latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin","latin","khmer","latin-ext,latin","latin-ext,latin","latin","vietnamese,latin-ext,latin","cyrillic,greek,cyrillic-ext,vietnamese,greek-ext,latin-ext,latin,devanagari","cyrillic,greek,cyrillic-ext,vietnamese,greek-ext,latin-ext,latin","latin","latin","greek,latin","latin","latin","latin","latin","latin","latin","latin","khmer","latin","latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","cyrillic,greek,cyrillic-ext,vietnamese,greek-ext,latin-ext,latin,devanagari","cyrillic,greek,cyrillic-ext,vietnamese,greek-ext,latin-ext,latin","cyrillic,cyrillic-ext,latin-ext,latin","latin","latin-ext,latin","latin-ext,latin","latin","latin-ext,latin","latin","latin-ext,latin","latin-ext,latin","latin","latin-ext,latin","latin-ext,latin","cyrillic,cyrillic-ext,latin-ext,latin","cyrillic,cyrillic-ext,latin-ext,latin","cyrillic,cyrillic-ext,latin-ext,latin","cyrillic,cyrillic-ext,latin-ext,latin","cyrillic,cyrillic-ext,latin-ext,latin","cyrillic,cyrillic-ext,latin-ext,latin","latin","latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","vietnamese,latin-ext,latin","vietnamese,latin-ext,latin","latin","latin","latin-ext,latin","latin","latin-ext,latin","latin","cyrillic,latin","latin-ext,latin","latin","latin-ext,latin","latin-ext,latin","cyrillic,greek,cyrillic-ext,greek-ext,latin-ext,latin","latin-ext,latin","cyrillic,latin-ext,latin","cyrillic,latin-ext,latin","latin","cyrillic,latin-ext,latin","latin","latin","latin","latin-ext,latin","latin","latin","latin","khmer","cyrillic,greek,latin-ext,latin","latin-ext,latin","latin","cyrillic,latin-ext,latin","latin","latin-ext,latin","latin-ext,latin","latin","latin-ext,latin","latin-ext,latin","latin","latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin","latin","latin","latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","cyrillic,greek,cyrillic-ext,vietnamese,greek-ext,latin-ext,latin","cyrillic,greek,cyrillic-ext,vietnamese,greek-ext,latin-ext,latin","cyrillic,greek,cyrillic-ext,vietnamese,greek-ext,latin-ext,latin","latin","latin","latin","latin-ext,latin","latin-ext,latin","latin","latin-ext,latin","latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","cyrillic,cyrillic-ext,latin-ext,latin","cyrillic,latin-ext,latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin","latin","latin-ext,latin","latin-ext,latin","latin","latin-ext,latin","latin","cyrillic,latin-ext,latin","latin","latin-ext,latin","latin-ext,latin","cyrillic,latin-ext,latin","latin","latin-ext,latin","latin","latin-ext,latin","latin","latin","latin-ext,latin","latin","khmer","latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin","latin","latin-ext,latin","latin","latin","latin","latin-ext,latin","latin","latin-ext,latin","latin","latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","vietnamese,latin-ext,latin","latin","latin","latin-ext,latin","latin","latin","latin-ext,latin","cyrillic,latin-ext,latin","latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin","latin","latin","latin","khmer","latin","latin","latin","khmer","latin-ext,latin","latin","cyrillic,cyrillic-ext,latin-ext,latin","latin-ext,latin","latin","latin","cyrillic,greek,cyrillic-ext,vietnamese,greek-ext,latin-ext,latin","latin-ext,latin","latin-ext,latin","latin","latin-ext,latin","latin","latin-ext,latin","latin","cyrillic,greek,cyrillic-ext,greek-ext,latin-ext,latin","cyrillic,greek,cyrillic-ext,greek-ext,latin-ext,latin","cyrillic,greek,cyrillic-ext,greek-ext,latin-ext,latin","latin","latin","cyrillic,latin-ext,latin","latin-ext,latin","latin","latin","latin","latin","latin","latin","latin-ext,latin","latin-ext,latin","latin","latin","latin","latin","latin-ext,latin","latin-ext,latin","latin","latin","latin","latin","latin","latin","latin-ext,latin","latin-ext,latin","latin-ext,latin","latin","latin-ext,latin","latin","cyrillic,latin-ext,latin","latin","latin"]';
        $fontStyles = '["400,400italic","400","400","400","400","400","400","100,200,300,400,500,600,700","400","400","400","400","400,700","400,400italic,700,700italic,900,900italic","400,400italic,700,700italic,900,900italic","100,100italic,300,300italic,400,400italic,500,500italic,700,700italic,800,800italic,900,900italic","100,100italic,300,300italic,400,400italic,500,500italic,700,700italic,800,800italic,900,900italic","400","400","400","400","400","400,700","400","400","400","400,400italic,700,700italic","400","400","400","400,400italic,700,700italic","400,700","400","400","400","400","400","400","400,400italic,700,700italic","400","400","400","400","400,400italic","400","400","400","400","400,400italic,700,700italic","400,400italic,700,700italic","400","400","400","400,400italic,700,700italic","400,400italic,700,700italic","400","400,700","400,700","400","400","400","400","400","400","400","300,300italic,400,400italic,700,700italic","300,300italic,400,400italic,700,700italic","300,300italic,400,400italic,700,700italic","400","400","400","400","400,700","400","400","400","400","300,400,700","400","400","400","400","400","400","400","400,400italic,700","400","400","400","400","400","400","400","400","400","400","300","400,700","400","400","400,400italic,500,500italic,600,600italic,700,700italic","400,500,600,700","400,700","400","400","400","400","400","400,400italic,700,700italic","400","400","400","400,400italic,700","400","400","400","400","400,400italic,700,700italic","400","400","400,400italic","400","400,400italic","400","400","400","400","400,700","400","400","400,400italic,900,900italic","400,700,900","400,700,900","400","400,800","800","300,400","400","300,400,700","400","400","400","400,700","400","400","400","400","400,700","400","400,400italic,700,700italic","400,900","400","400","400","400,400italic","400,400italic,600,600italic,700,700italic","400","400","400,400italic,700,700italic","400","400","400","400,700","400","400","400","400","400","400,700","400","400","400","400","400","400","400,700","400","400","400","200,300,400,500,600,700,800","400","400,700","400","400,400italic,700,700italic","400","400","400","400","400","400,400italic,700,700italic","200,300,400,500,600,700,800","400","400,900","400,900","400","400","400","400","400,700","400","400","400","400","100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic","100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic","400,400italic,500,500italic,600,600italic,700,700italic","400,400italic","400","400","400","400","400","400","400","400","400","400","400","400","300,400","400","400,400italic","400","400","400","400","400","400","400","400","400","400","400","400","400,400italic,700,700italic","400","400","400","400","400,400italic,700,700italic","400,400italic,700,700italic","400,400italic","400","400","400","400","400","400","400","400","400","400","400,700","400","400","400","400","400","400","400","400,400italic,700","400","400","400","400","400","400,700","400","400","400","400","400","400","400","400,400italic","400","400,400italic","400","400,400italic","400","400,400italic","400","400,400italic","400","400","400","400","400,700","400","400","400,700","400","400,400italic,700,700italic","400","400","400","400","400","400","400","100,100italic,300,300italic,400,400italic,600,600italic,700,700italic","100,100italic,300,300italic,400,400italic,600,600italic,700,700italic","400","400,400italic,700","400","400","400","300,400,500,600","400","400","400,700","300,400,700","400,400italic,700,700italic","400","400","400","400","400","400","400","400","400","400","400","400","300,400,700","400","400","400","400","100,100italic,300,300italic,400,400italic,700,700italic,900,900italic","400","400","400","400,400italic,700","400","400,400italic,700","400,700","400","400","400","400,400italic","400","400,400italic,700,700italic","400","400","400","400","400,400italic,700,700italic","400","400","400","400","400,700","400","400","400","400,700","400","400","400","400","400","400","400","400","400,400italic,700,700italic","400,400italic","400","400,500,700,900","400","400","400","400","400","400","400,700","400","300,300italic,400,400italic,700,700italic,900,900italic","300,300italic,400,400italic,700,700italic,800,800italic","400","400","400","400","400","400","400","400","400","400","400","400","400italic","400,700","400","400","400","400","400","400,700","400,700","400,700","400","400","400,700","400","400","400","400","400","400","300,300italic,400,400italic","400","400","200,300,400,400italic,700,800","400","400,700","400","400","400,400italic,700,700italic","400,700","400","400","400","400,400italic,700,700italic","400,400italic,700,700italic","400,400italic,700,700italic","400","400","400","400","400","400","400","400","400","300,400,700","400","400","400,400italic,700","400","400,700","400,700","300,300italic,400,400italic,600,600italic,700,700italic,800,800italic","300,300italic,700","400","400,500,700,900","400,400italic","400","400","300,400,700","400","400,400italic,700,700italic,900,900italic","400","400","300,400,700","400","400","400,400italic,700,700italic","400,700","400,700","400,400italic,700,700italic","400,400italic","400","400","400","400","400,700,900","400","400","400","400","400","400","400","400","400","400,400italic,700,700italic","400","400","400","400","400,700","400","400,400italic,700,700italic,900,900italic","400,400italic,700,700italic,900,900italic","400,700","400","400","400,400italic","400","400","400","400","400","400","400","400","400","400","400,400italic,700,700italic","400","400","400,400italic,700,700italic","400,700","400,400italic,700,700italic","400","300,400,700","400","400","400","400,400italic","100,200,300,400,500,600,700,800,900","400","400,400italic,700,700italic","400","400","400","400","400","400","400","400","400","400","400","100,100italic,300,300italic,400,400italic,500,500italic,700,700italic,900,900italic","300,300italic,400,400italic,700,700italic","100,300,400,700","400","400","400,700","400","400,400italic","400,400italic,700,700italic","400,400italic","400","400","400","400,700,900","400,700","400","400","400","400","400","400","400","400","400","400","400,400italic","400","400","400","400","400,400italic,700,700italic","400","400","400","400","400","400","400","400,400italic,700,700italic","400","400","400","400","400","400","300,400,600,700","300,400,600,700","400,400italic,900,900italic","400,700","400","400","400,700","400","400","400","400,800","400","400","400","400","400","400,400italic","200,300,400,500,600,700,900","200,200italic,300,300italic,400,400italic,600,600italic,700,700italic,900,900italic","400","400","400","400","400","400","400","400,700","400","400","300,400","400","400","400","400","400","400","400,700","400,700","400","400","400","400","400","400","400,700,900","400,400italic,700,700italic","400","200,200italic,300,300italic,400,400italic,600,600italic,700,700italic,900","400","400","400,400italic,700","400","400","300,300italic,400,400italic,500,500italic,700,700italic","400","400,400italic,700,700italic","400","400","400","400","700","400","400,700","400","400","400","400","400","400","400","400","400","400","400","400,400italic,700,700italic","400,400italic,700,700italic","400","400","400","400","400","400","400","400","200,300,400,700","400","400","400","400"]';

        // Get the default HTML for this option
        $html = parent::_getElementHtml($element);
 
        $html .= '<br/><div id="itactica_googlefonts_preview" style="font-size:20px; margin-top:5px;">The quick brown fox jumps over the lazy dog</div>
        <script>
        var googleFontPreviewModel = Class.create();
        var fontName = "";
        var jsonSubset = '.$characterSubset.';
        var jsonStyles = '.$fontStyles.';
 
        googleFontPreviewModel.prototype = {
            initialize : function()
            {
                this.fontElement = $("'.$element->getHtmlId().'");
                this.previewElement = $("itactica_googlefonts_preview");
                this.groupHeader = $("intenso_fonts-head");
                this.familyField = $("intenso_fonts_font_family");
                this.loadedFonts = "";
 
                this.refreshPreview();
                this.bindFontChange();
            },
            bindFontChange : function()
            {
                Event.observe(this.fontElement, "change", this.refreshPreview.bind(this));
                Event.observe(this.fontElement, "keyup", this.refreshPreview.bind(this));
                Event.observe(this.fontElement, "keydown", this.refreshPreview.bind(this));
                Event.observe(this.groupHeader, "click", this.refreshPreview.bind(this));
                Event.observe(this.familyField, "change", this.refreshPreview.bind(this));
            },
            refreshPreview : function()
            {
                if ( this.loadedFonts.indexOf( this.fontElement.value ) > -1 ) {
                    this.updateFontFamily();
                    return;
                }
 
                var ss = document.createElement("link");
                ss.type = "text/css";
                ss.rel = "stylesheet";
                ss.href = "http://fonts.googleapis.com/css?family=" + this.fontElement.value;
                document.getElementsByTagName("head")[0].appendChild(ss);
 
                this.updateFontFamily();
 
                this.loadedFonts += this.fontElement.value + ",";

                fontName = this.fontElement.value;

            },
            updateFontFamily : function()
            {
                $(this.previewElement).setStyle({ fontFamily: this.fontElement.value });

                var selectedIndex = this.fontElement.selectedIndex;

                // Disable subsets not available for the selected font
                var subsetField = $("intenso_fonts_font_subset");
                if (subsetField) {
                    subsetField = subsetField.getElementsByTagName("option");
                    var availableSubset = jsonSubset[selectedIndex].split(",");
                    // disable all options
                    if (fontName != this.fontElement.value) {
                        for (var i = 0; i < subsetField.length; i++) {
                            subsetField[i].disabled = true;
                            subsetField[i].selected=false;
                        }
                    }
                    // enable available options
                    for (var j = 0; j < availableSubset.length; j++) {
                        for (var i = 0; i < subsetField.length; i++) {
                            if (subsetField[i].value == availableSubset[j]) subsetField[i].disabled = false;
                        }
                    }
                }

                // Disable styles not available for the selected font
                var stylesField = $("intenso_fonts_font_styles");
                if (stylesField) {
                    stylesField = stylesField.getElementsByTagName("option");
                    var availableStyles = jsonStyles[selectedIndex].split(",");
                    // disable all options
                    if (fontName != this.fontElement.value) {
                        for (var i = 0; i < stylesField.length; i++) {
                            stylesField[i].disabled = true;
                            stylesField[i].selected=false;
                        }
                    }
                    // enable available options
                    for (var j = 0; j < availableStyles.length; j++) {
                        for (var i = 0; i < stylesField.length; i++) {
                            if (stylesField[i].value == availableStyles[j]) stylesField[i].disabled = false;
                        }
                    }
                }

            }
        }
 
        googleFontPreview = new googleFontPreviewModel();
        </script>
        ';
        return $html;
    }
}