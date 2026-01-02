<?
define("HIDE_SIDEBAR", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заказы");
?>

<?$APPLICATION->IncludeComponent(
	"bitrix:sale.order.ajax", 
	"bootstrap_v4", 
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
		"COMPONENT_TEMPLATE" => "bootstrap_v4",
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
		"PROPS_FADE_LIST_3" => array(
		),
		"PROPS_FADE_LIST_5" => array(
		),
		"PROPS_FADE_LIST_4" => array(
		),
		"PROPS_FADE_LIST_6" => array(
		),
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
		"PRODUCT_COLUMNS_HIDDEN" => array(
		),
		"HIDE_ORDER_DESCRIPTION" => "N",
		"USE_YM_GOALS" => "N",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"USE_CUSTOM_MAIN_MESSAGES" => "N",
		"USE_CUSTOM_ADDITIONAL_MESSAGES" => "N",
		"USE_CUSTOM_ERROR_MESSAGES" => "N"
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>