<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("test");

?>
<?php
use Lab\Helpers\SaleHelpers as SaleHelpers;
$arResQntt= SaleHelpers::getCurrentUserRealQuantityBasketProduct();
pretty_print($arResQntt);
?>
<?php
/*    $ORDER = \Bitrix\Sale\Order::load(58);

    CModule::IncludeModule('sale');
    CModule::IncludeModule('catalog');

     $res = \CSaleBasket::GetList(array(), array("ORDER_ID" => $ORDER)); // ID заказа
    $json_product = array();
    while ($arItem = $res->Fetch()) {
    $json_product[] = array(
    'name' => $arItem['NAME'],
    'id' => $arItem['PRODUCT_ID'],
    'price' => $arItem['PRICE'],
    'quantity' => $arItem['QUANTITY']
    );
    }
    foreach ($json as $item) {
    $basketQuantity = $item['quantity'];
    $quantityNow = \CCatalogProduct::GetByID($item['id'])['QUANTITY'];
    $ar_res[] = \CCatalogProduct::GetByID($item['id']);
    $quantityNew = $quantityNow + $basketQuantity;
    $arFields = array('QUANTITY' => $quantityNew);// зарезервированное количество
    \CCatalogProduct::Update($item['id'], $arFields);
    }
*/ ?>
<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>