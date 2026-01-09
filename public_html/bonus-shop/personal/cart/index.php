<?
define("HIDE_SIDEBAR", true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

//\Bitrix\Main\UI\Extension::load('lab.mainjs');
$dbBasketItems = CSaleBasket::GetList(
        false,
        array(
                "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                "LID" => SITE_ID,
                "ORDER_ID" => "NULL"
        ),
        false,
        false,
        array(
                "QUANTITY"
        )
);
while ($arItems = $dbBasketItems->Fetch()) {
    $countItemsInCart += $arItems['QUANTITY'];
}
?>
<?php if ($countItemsInCart == 0): ?>
    <div class="container flex" style="min-height: 500px; justify-content: center;">
        <div class="">
            <h3>Ваша корзина пуста</h3>
            <button class="btn btn-danger"><a style="color: #fff" href="/bonus-shop/#lab-catalog" type="button">Перейти к покупкам</a></button>
        </div>
    </div>


<?php else: ?>

    <? $APPLICATION->SetTitle("Корзина");
    $APPLICATION->IncludeComponent("bitrix:sale.basket.basket", "bootstrap_bonus", array(
            "BASKET_WITH_ORDER_INTEGRATION" => "Y",
            "COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
            "COLUMNS_LIST" => array(
                    0 => "NAME",
                    1 => "DISCOUNT",
                    2 => "PRICE",
                    3 => "QUANTITY",
                    4 => "SUM",
                    5 => "PROPS",
                    6 => "DELETE",
                    7 => "DELAY",
            ),
            "AJAX_MODE" => "Y",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "Y",
            "AJAX_OPTION_HISTORY" => "N",
            "PATH_TO_ORDER" => "/bonus-shop/personal/order/make/",    // Страница оформления заказа
            "HIDE_COUPON" => "Y",    // Спрятать поле ввода купона
            "QUANTITY_FLOAT" => "N",    // Использовать дробное значение количества
            "PRICE_VAT_SHOW_VALUE" => "Y",    // Отображать значение НДС
            "TEMPLATE_THEME" => "site",    // Цветовая тема
            "SET_TITLE" => "Y",    // Устанавливать заголовок страницы
            "AJAX_OPTION_ADDITIONAL" => "",
            "OFFERS_PROPS" => array(
                    0 => "SIZES_SHOES",
                    1 => "SIZES_CLOTHES",
                    2 => "COLOR_REF",
            ),
            "COMPONENT_TEMPLATE" => "bootstrap_v4",
            "DEFERRED_REFRESH" => "N",    // Использовать механизм отложенной актуализации данных товаров с провайдером
            "USE_DYNAMIC_SCROLL" => "Y",    // Использовать динамическую подгрузку товаров
            "SHOW_FILTER" => "N",    // Отображать фильтр товаров
            "SHOW_RESTORE" => "N",    // Разрешить восстановление удалённых товаров
            "COLUMNS_LIST_EXT" => array(    // Выводимые колонки
                    0 => "PREVIEW_PICTURE",
                    1 => "DISCOUNT",
                    2 => "DELETE",
                    3 => "DELAY",
                    4 => "TYPE",
                    5 => "SUM",
            ),
            "COLUMNS_LIST_MOBILE" => array(    // Колонки, отображаемые на мобильных устройствах
                    0 => "PREVIEW_PICTURE",
                    1 => "DISCOUNT",
                    2 => "DELETE",
                    3 => "DELAY",
                    4 => "TYPE",
                    5 => "SUM",
            ),
            "TOTAL_BLOCK_DISPLAY" => array(    // Отображение блока с общей информацией по корзине
                    0 => "top",
            ),
            "DISPLAY_MODE" => "compact",    // Режим отображения корзины
            "PRICE_DISPLAY_MODE" => "Y",    // Отображать цену в отдельной колонке
            "SHOW_DISCOUNT_PERCENT" => "Y",    // Показывать процент скидки рядом с изображением
            "DISCOUNT_PERCENT_POSITION" => "bottom-right",    // Расположение процента скидки
            "PRODUCT_BLOCKS_ORDER" => "props,sku,columns",    // Порядок отображения блоков товара
            "USE_PRICE_ANIMATION" => "Y",    // Использовать анимацию цен
            "LABEL_PROP" => "",    // Свойства меток товара
            "USE_PREPAYMENT" => "N",    // Использовать предавторизацию для оформления заказа (PayPal Express Checkout)
            "CORRECT_RATIO" => "Y",    // Автоматически рассчитывать количество товара кратное коэффициенту
            "AUTO_CALCULATION" => "Y",    // Автопересчет корзины
            "ACTION_VARIABLE" => "basketAction",    // Название переменной действия
            "COMPATIBLE_MODE" => "Y",    // Включить режим совместимости
            "EMPTY_BASKET_HINT_PATH" => "/",    // Путь к странице для продолжения покупок
            "ADDITIONAL_PICT_PROP_17" => "-",    // Дополнительная картинка [Магазин бонусов]
            "ADDITIONAL_PICT_PROP_18" => "-",    // Дополнительная картинка [Одежда (предложения)]
            "BASKET_IMAGES_SCALING" => "adaptive",    // Режим отображения изображений товаров
            "USE_GIFTS" => "N",    // Показывать блок "Подарки"
            "GIFTS_PLACE" => "BOTTOM",
            "GIFTS_BLOCK_TITLE" => "Выберите один из подарков",
            "GIFTS_HIDE_BLOCK_TITLE" => "N",
            "GIFTS_TEXT_LABEL_GIFT" => "Подарок",
            "GIFTS_PRODUCT_QUANTITY_VARIABLE" => "quantity",
            "GIFTS_PRODUCT_PROPS_VARIABLE" => "prop",
            "GIFTS_SHOW_OLD_PRICE" => "N",
            "GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",
            "GIFTS_MESS_BTN_BUY" => "Выбрать",
            "GIFTS_MESS_BTN_DETAIL" => "Подробнее",
            "GIFTS_PAGE_ELEMENT_COUNT" => "4",
            "GIFTS_CONVERT_CURRENCY" => "N",
            "GIFTS_HIDE_NOT_AVAILABLE" => "N",
            "USE_ENHANCED_ECOMMERCE" => "N",    // Отправлять данные электронной торговли в Google и Яндекс
            "ADDITIONAL_PICT_PROP_14" => "-",
            "ADDITIONAL_PICT_PROP_15" => "-"
    ),
            false
    ); ?>
    <? $APPLICATION->IncludeComponent(
            "bitrix:sale.order.ajax",
            "bootstrap_bonus1",
            array(
                    "PAY_FROM_ACCOUNT" => "Y",
                    "COUNT_DELIVERY_TAX" => "N",
                    "COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
                    "ONLY_FULL_PAY_FROM_ACCOUNT" => "N",
                    "ALLOW_AUTO_REGISTER" => "N",
                    "SEND_NEW_USER_NOTIFY" => "N",
                    "DELIVERY_NO_AJAX" => "N",
                    "TEMPLATE_LOCATION" => "popup",
                    "PROP_1" => "",
                    "PATH_TO_BASKET" => "/bonus-shop/personal/cart/",
                    "PATH_TO_PERSONAL" => "/bonus-shop/personal/order/",
                    "PATH_TO_PAYMENT" => "/bonus-shop/personal/order/payment/",
                    "PATH_TO_ORDER" => "/bonus-shop/personal/order/make/",
                    "SET_TITLE" => "Y",
                    "SHOW_ACCOUNT_NUMBER" => "Y",
                    "DELIVERY_NO_SESSION" => "Y",
                    "COMPATIBLE_MODE" => "N",
                    "BASKET_POSITION" => "before",
                    "BASKET_IMAGES_SCALING" => "adaptive",
                    "SERVICES_IMAGES_SCALING" => "adaptive",
                    "USER_CONSENT" => "Y",
                    "USER_CONSENT_ID" => "2",
                    "USER_CONSENT_IS_CHECKED" => "Y",
                    "USER_CONSENT_IS_LOADED" => "Y",
                    "COMPONENT_TEMPLATE" => "bootstrap_bonus1",
                    "ALLOW_APPEND_ORDER" => "Y",
                    "SHOW_NOT_CALCULATED_DELIVERIES" => "N",
                    "SPOT_LOCATION_BY_GEOIP" => "N",
                    "DELIVERY_TO_PAYSYSTEM" => "d2p",
                    "SHOW_VAT_PRICE" => "N",
                    "USE_PREPAYMENT" => "N",
                    "USE_PRELOAD" => "Y",
                    "ALLOW_USER_PROFILES" => "N",
                    "ALLOW_NEW_PROFILE" => "N",
                    "TEMPLATE_THEME" => "red",
                    "SHOW_ORDER_BUTTON" => "always",
                    "SHOW_TOTAL_ORDER_BUTTON" => "Y",
                    "SHOW_PAY_SYSTEM_LIST_NAMES" => "N",
                    "SHOW_PAY_SYSTEM_INFO_NAME" => "N",
                    "SHOW_DELIVERY_LIST_NAMES" => "N",
                    "SHOW_DELIVERY_INFO_NAME" => "N",
                    "SHOW_DELIVERY_PARENT_NAMES" => "N",
                    "SHOW_STORES_IMAGES" => "N",
                    "SKIP_USELESS_BLOCK" => "N",
                    "SHOW_BASKET_HEADERS" => "N",
                    "DELIVERY_FADE_EXTRA_SERVICES" => "N",
                    "SHOW_NEAREST_PICKUP" => "N",
                    "DELIVERIES_PER_PAGE" => "1",
                    "PAY_SYSTEMS_PER_PAGE" => "1",
                    "PICKUPS_PER_PAGE" => "1",
                    "SHOW_PICKUP_MAP" => "N",
                    "SHOW_MAP_IN_PROPS" => "N",
                    "PICKUP_MAP_TYPE" => "yandex",
                    "SHOW_COUPONS" => "Y",
                    "SHOW_COUPONS_BASKET" => "Y",
                    "SHOW_COUPONS_DELIVERY" => "Y",
                    "SHOW_COUPONS_PAY_SYSTEM" => "Y",
                    "PROPS_FADE_LIST_3" => array(),
                    "PROPS_FADE_LIST_5" => array(),
                    "PROPS_FADE_LIST_4" => array(),
                    "PROPS_FADE_LIST_6" => array(),
                    "ACTION_VARIABLE" => "soa-action",
                    "PATH_TO_AUTH" => "/auth/",
                    "DISABLE_BASKET_REDIRECT" => "N",
                    "EMPTY_BASKET_HINT_PATH" => "/",
                    "USE_PHONE_NORMALIZATION" => "Y",
                    "PRODUCT_COLUMNS_VISIBLE" => array(
                            0 => "PREVIEW_PICTURE",
                            1 => "PROPS",
                    ),
                    "ADDITIONAL_PICT_PROP_17" => "-",
                    "ADDITIONAL_PICT_PROP_18" => "-",
                    "PRODUCT_COLUMNS_HIDDEN" => array(),
                    "HIDE_ORDER_DESCRIPTION" => "N",
                    "USE_YM_GOALS" => "N",
                    "USE_ENHANCED_ECOMMERCE" => "N",
                    "USE_CUSTOM_MAIN_MESSAGES" => "N",
                    "USE_CUSTOM_ADDITIONAL_MESSAGES" => "N",
                    "USE_CUSTOM_ERROR_MESSAGES" => "N",
                    "ADDITIONAL_PICT_PROP_14" => "-",
                    "ADDITIONAL_PICT_PROP_15" => "-"
            ),
            false
    ); ?>
<?php endif; ?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>