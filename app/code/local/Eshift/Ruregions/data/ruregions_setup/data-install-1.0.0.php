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

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

/**
 * Удаляем старые данные о регионах RU (на всякий случай)
 */

$installer->getConnection()->delete($installer->getTable('directory/country_region'), array('country_id = ?' => 'RU'));
$installer->getConnection()->delete($installer->getTable('directory/country_region_name'), array('locale = ?' => 'ru_RU'));

/**
 * Заполняем таблицу directory/country_region
 * Заполняем таблицу directory/country_region_name для ru_RU
 */

$data = array(
    array('RU', '99', 'г. Москва'),
    array('RU', '78', 'г. Санкт-Петербург'),
    array('RU', '01', 'Адыгея республика '),
    array('RU', '04', 'Алтай республика '),
    array('RU', '22', 'Алтайский край'),
    array('RU', '28', 'Амурская область'),
    array('RU', '29', 'Архангельская область'),
    array('RU', '30', 'Астраханская область'),
    array('RU', '02', 'Башкортостан республика '),
    array('RU', '31', 'Белгородская область'),
    array('RU', '32', 'Брянская область'),
    array('RU', '03', 'Бурятия республика '),
    array('RU', '33', 'Владимирская область'),
    array('RU', '34', 'Волгоградская область'),
    array('RU', '35', 'Вологодская область'),
    array('RU', '36', 'Воронежская область'),
    array('RU', '05', 'Дагестан республика'),
    array('RU', '79', 'Еврейская автономная область'),
    array('RU', '75', 'Забайкальский край'),
    array('RU', '37', 'Ивановская область'),
    array('RU', '06', 'Ингушетия республика '),
    array('RU', '38', 'Иркутская область'),
    array('RU', '07', 'Кабардино-Балкарская республика '),
    array('RU', '39', 'Калининградская область'),
    array('RU', '08', 'Калмыкия республика '),
    array('RU', '40', 'Калужская область'),
    array('RU', '41', 'Камчатский край'),
    array('RU', '09', 'Карачаево-Черкессия республика '),
    array('RU', '10', 'Карелия республика '),
    array('RU', '42', 'Кемеровская область'),
    array('RU', '43', 'Кировская область'),
    array('RU', '11', 'Коми республика '),
    array('RU', '44', 'Костромская область'),
    array('RU', '23', 'Краснодарский край'),
    array('RU', '24', 'Красноярский край'),
    array('RU', '92', 'Крым республика'),
    array('RU', '45', 'Курганская область'),
    array('RU', '46', 'Курская область'),
    array('RU', '47', 'Ленинградская область'),
    array('RU', '48', 'Липецкая область'),
    array('RU', '49', 'Магаданская область'),
    array('RU', '12', 'Марий Эл республика '),
    array('RU', '13', 'Мордовия республика '),
    array('RU', '90', 'Московская область'),
    array('RU', '51', 'Мурманская область'),
    array('RU', '83', 'Ненецкий автономный округ'),
    array('RU', '52', 'Нижегородская область'),
    array('RU', '53', 'Новгородская область'),
    array('RU', '54', 'Новосибирская область'),
    array('RU', '55', 'Омская область'),
    array('RU', '56', 'Оренбургская область'),
    array('RU', '57', 'Орловская область'),
    array('RU', '58', 'Пензенская область'),
    array('RU', '59', 'Пермский край'),
    array('RU', '25', 'Приморский край'),
    array('RU', '60', 'Псковская область'),
    array('RU', '61', 'Ростовская область'),
    array('RU', '62', 'Рязанская область'),
    array('RU', '63', 'Самарская область'),
    array('RU', '64', 'Саратовская область'),
    array('RU', '14', 'Саха (Якутия) республика '),
    array('RU', '65', 'Сахалинская область'),
    array('RU', '66', 'Свердловская область'),
    array('RU', '15', 'Северная Осетия-Алания республика '),
    array('RU', '67', 'Смоленская область'),
    array('RU', '26', 'Ставропольский край'),
    array('RU', '68', 'Тамбовская область'),
    array('RU', '16', 'Татарстан республика '),
    array('RU', '69', 'Тверская область'),
    array('RU', '70', 'Томская область'),
    array('RU', '71', 'Тульская область'),
    array('RU', '17', 'Тыва республика '),
    array('RU', '72', 'Тюменская область'),
    array('RU', '18', 'Удмуртская республика '),
    array('RU', '73', 'Ульяновская область'),
    array('RU', '27', 'Хабаровский край'),
    array('RU', '19', 'Хакасия республика '),
    array('RU', '86', 'Ханты-Мансийский автономный округ - Югра'),
    array('RU', '74', 'Челябинская область'),
    array('RU', '95', 'Чеченская республика'),
    array('RU', '21', 'Чувашская республика '),
    array('RU', '87', 'Чукотский автономный округ'),
    array('RU', '89', 'Ямало-Ненецкий автономный округ'),
    array('RU', '76', 'Ярославская область')
);

foreach ($data as $row) {
    $bind = array(
        'country_id'    => $row[0],
        'code'          => $row[1],
        'default_name'  => $row[2],
    );
    $installer->getConnection()->insert($installer->getTable('directory/country_region'), $bind);
    $regionId = $installer->getConnection()->lastInsertId($installer->getTable('directory/country_region'));

    $bind = array(
        'locale'    => 'ru_RU',
        'region_id' => $regionId,
        'name'      => $row[2]
    );
    $installer->getConnection()->insert($installer->getTable('directory/country_region_name'), $bind);
}