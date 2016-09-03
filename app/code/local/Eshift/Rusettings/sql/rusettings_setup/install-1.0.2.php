<?php
/**
 *
 * This source file is subject to the Ecommerce Shift Software License, which is available at http://ecommerceshift.com/common/license-free-ru.txt.
 * Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
 *
 * NOTICE OF LICENSE
 *
 * You may not sell, sub-license, rent or lease
 * any portion of the Software or Documentation to anyone.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade to newer
 * versions in the future.
 *
 * @category   Eshift
 * @copyright  Copyright (c) 2014 Ecommerce Shift (http://ecommerceshift.com/)
 * @contacts   support@ecommerceshift.com
 * @author     Alexander Dashkov (dashkov1@gmail.com)
 * @license    http://ecommerceshift.com/common/license-free-ru.txt
 */

$installer = $this;
/* @var $installer Mage_Catalog_Model_Resource_Setup */

$config = Mage::getConfig();
/* @var $config Mage_Core_Model_Config */

$installer->startSetup();

/* Переводим стандартные атрибуты товара на русский */
$ruAttributes = array(
    'color' => 'Цвет',
    'cost' => 'Базовая цена',
    'country_of_manufacture' => 'Страна изготовления',
    'custom_design' => 'Индивидуальный дизайн',
    'custom_design_from' => 'Использовать с',
    'custom_design_to' => 'Использовать по',
    'custom_layout_update' => 'Индивидуальное обновление макета',
    'description' => 'Описание',
    'gallery' => 'Изображения',
    'gift_message_available' => 'Разрешить поздравительные сообщения',
    'group_price' => 'Цены по группам',
    'image' => 'Основное изображение',
    'is_recurring' => 'Включить повторяющиеся платежи',
    'manufacturer' => 'Производитель',
    'media_gallery' => 'Изображения',
    'meta_description' => 'Описание META',
    'meta_keyword' => 'Ключевые слова META',
    'meta_title' => 'Заголовок META',
    'msrp' => 'Рекомендованная розничная цена производителя',
    'msrp_display_actual_price_type' => 'Отображать текущую цену',
    'msrp_enabled' => 'Применить РРЦ (рекомендованные розничные цены)',
    'name' => 'Название',
    'news_from_date' => 'Отображать как Новинка с',
    'news_to_date' => 'Отображать как Новинка по',
    'options_container' => 'Отображать параметры товара в',
    'page_layout' => 'Макет страницы',
    'price' => 'Цена',
    'price_view' => 'Отображение цены',
    'recurring_profile' => 'Профиль повторяющихся платежей',
    'short_description' => 'Краткое описание',
    'sku' => 'Артикул (SKU)',
    'small_image' => 'Маленькое изображение',
    'special_from_date' => 'Скидка действует с',
    'special_price' => 'Цена со скидкой',
    'special_to_date' => 'Скидка действует по',
    'status' => 'Статус',
    'tax_class_id' => 'Налоговый класс',
    'thumbnail' => 'Миниатюра',
    'tier_price' => 'Цены по количеству',
    'url_key' => 'URL Адрес',
    'visibility' => 'Видимость',
    'weight' => 'Вес'
);

/* Переводим стандартные настройки на русский */
$ruConfig = array(
    'carriers/flatrate/title' => 'Стандартная доставка',
    'carriers/flatrate/name' => 'Стоимость',
    'carriers/flatrate/specificerrmsg' => 'Данный способ доставки временно недоступен.',
    'carriers/tablerate/title' => 'Региональная доставка',
    'carriers/tablerate/name' => 'Стоимость',
    'carriers/tablerate/specificerrmsg' => 'Данный способ доставки временно недоступен.',
    'carriers/freeshipping/title' => 'Бесплатная доставка',
    'carriers/freeshipping/name' => 'Бесплатно',
    'carriers/freeshipping/specificerrmsg' => 'Данный способ доставки временно недоступен.',
    'payment/ccsave/active' => '0',
    'payment/ccsave/title' => 'Кредитная карта (оффлайн, данные карты сохраняются в магазине)',
    'payment/checkmo/title' => 'Денежный перевод',
    'payment/free/title' => 'Информация о способе оплаты не требуется.',
    'payment/banktransfer/title' => 'Перевод на р/сч в банке',
    'payment/cashondelivery/title' => 'Оплата при получении',
    'payment/purchaseorder/title' => 'Оплата по договору',
    'design/header/welcome' => 'Добро пожаловать!',
    'design/footer/copyright' => '&copy; 2014 Модули и шаблоны для Magento - быстрый старт с <a href="http://magebox.ru/" target="_blank">Magento на русском</a>.',
    'shipping/option/checkout_multiple' => '0',
    'shipping/origin/country_id' => 'RU',
    'shipping/origin/postcode' => '101000',
    'design/header/logo_alt' => '',
    'design/head/default_title' => 'Интернет-магазин',
    'design/head/default_description' => '',
    'design/head/default_keywords' => '',
    'payment/banktransfer/active' => '1',
    'payment/cashondelivery/active' => '1',
    'payment/purchaseorder/active' => '1',
    'carriers/freeshipping/active' => '1'
);

/* Обновления для страниц */
$updatePages = array(
    'home' => array(
        'title' => 'Главная'
    ),
    'about-magento-demo-store' => array(
        'title' => 'О Магазине',
        'content_heading' => 'О Магазине',
        'identifier' => 'about',
        'content' => '<p>Информация о магазине.</p>',
        'root_template' => 'one_column'
    ),
    'customer-service' =>array(
        'title' => 'Доставка и оплата',
        'content_heading' => 'Доставка и оплата',
        'identifier' => 'delivery-payment',
        'content' => '<p>Информация о доставке и оплате.</p>',
        'root_template' => 'one_column'
    ),
    'privacy-policy-cookie-restriction-mode' => array(
        'title' => 'Гарантия',
        'content_heading' => 'Гарантия',
        'identifier' => 'warranty',
        'content' => '<p>Информация о гарантии.</p>',
        'root_template' => 'one_column'
    ),
    'no-route' => array(
        'title' => '404 Не найдено 1',
        'content' => '<div class="page-title">
<h1>Упс, страница не найдена...</h1>
</div>
<dl><dt>Вы попытались зайти на страницу, которой не существует. Вероятно, это произошло по следующим причинам:</dt><dd>
<ul class="disc">
<li>Неправильно напечатан адрес страницы</li>
<li>Страница уже не актуальна</li>
</ul>
</dd></dl><dl><dt>Что же делать?</dt><dd>Предлагаем Вам несколько вариантов дальнейших действий:</dd><dd>
<ul class="disc">
<li><a onclick="history.go(-1); return false;" href="#">Вернитесь</a> на предыдущую страницу.</li>
<li>Воспользуйтесь формой поиска в верху страницы для поиска нужного товара..</li>
<li>Перейдите в другой раздел сайта:&nbsp;<br /><a href="{{store url=""}}">Главная страница</a> <span class="separator">или </span><a href="{{store url="customer/account"}}">Личный кабинет</a></li>
</ul>
</dd></dl>'
    )
);

$updateBlocks = array(
    'footer_links_company' => array(
        'title' => 'Ссылки в футере',
        'content' => '<div class="links">
<div class="block-title"><strong><span>Компания</span></strong></div>
<ul>
<li><a href="{{store url=""}}about/">О нас</a></li>
<li><a href="{{store url=""}}delivery-payment/">Доставка и оплата</a></li>
<li><a href="{{store url=""}}warranty/">Гарантия</a></li>
<li><a href="{{store url=""}}contacts/">Контакты</a></li>
</ul>
</div>'
    )
);
    foreach ($ruAttributes as $attributeCode => $attributeProp) {
        $installer->updateAttribute(
            Mage_Catalog_Model_Product::ENTITY,
            $attributeCode,
            'frontend_label',
            $attributeProp
        );
    }

    foreach ($ruConfig as $configPath => $configValue) {
        $config->saveConfig($configPath, $configValue);
    }

    foreach ($updatePages as $pageID => $pageData) {
        $page = Mage::getModel('cms/page')->load($pageID);
        if ($page->getIdentifier()) {
            $page->addData($pageData);
            $page->save();
        }
    }

    foreach ($updateBlocks as $blockName => $blockData) {
        $block = Mage::getModel('cms/block')->load($blockName);

        if ($block->getID()) {
            $block->addData($blockData)->save();
            $block->save();
        }

    }

/* Убираем класс налогов из расширенного поиска */

     $installer->updateAttribute(
         Mage_Catalog_Model_Product::ENTITY,
         'tax_class_id',
         'is_visible_in_advanced_search',
         0
     );

$installer->endSetup();
