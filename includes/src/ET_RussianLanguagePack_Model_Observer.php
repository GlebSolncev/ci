<?php

/**
 * ET_RussianLanguagePack_Model_Observer
 **/
class ET_RussianLanguagePack_Model_Observer
{
    public function addExtraBlocks($observer)
    {
        /** @var $helper ET_RussianLanguagePack_Helper_Data */
        $helper = Mage::helper('etrussianlanguagepack');
        if ($helper->isEditorTranslationEnabled()) {

            $layout = $observer->getLayout();
            if (!$layout) {
                return;
            }

            $head = $layout->getBlock('head');
            if (!$head) {
                return;
            }

            $currentLocaleCode = substr(Mage::app()->getLocale()->getLocaleCode(), 0, 2);
            if ($currentLocaleCode == 'ru') {
                $head->addJs('ru.tiny_mce.settings.js');
            }
        }
    }
}
