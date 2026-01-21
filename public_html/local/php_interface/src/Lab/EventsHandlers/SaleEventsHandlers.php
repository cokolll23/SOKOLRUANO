<?php
namespace Lab\EventsHandlers;


use Bitrix\Sale;
use Bitrix\Catalog;
use Bitrix\Main\Diag\Debug;
use Lab\Helpers\IblockHelpers as IH;


class SaleEventsHandlers
{
    // todo  уменьшение количества товара при оформлении заказа битрикс
    public static  function onSaleOrderSavedHandler (\Bitrix\Main\Event $event)
    {
        $order = $event->getParameter("ENTITY");
        $isNew = $event->getParameter("IS_NEW");

        if (!$isNew) {
            return;
        }
        $basket = $order->getBasket();

        foreach ($basket as $basketItem) {
            $productId = $basketItem->getProductId();
            $quantity = $basketItem->getQuantity();
            if (\Bitrix\Main\Loader::includeModule('catalog')) {
                // Получаем текущие остатки
                $productData = CCatalogProduct::GetByID($productId);

                if ($productData) {
                    $newQuantity = $productData['QUANTITY'] - $quantity;

                    // Обновляем общее количество
                    CCatalogProduct::Update($productId, [
                        'QUANTITY' => $newQuantity
                    ]);
                }
            }

        }
    }
    public static function onBeforeOrderAdd(&$arFields)
    {
        $orderPrice = $arFields['PRICE'] ;
        $USER_EMAIL =  $arFields['USER_EMAIL'];
        $iblockId = IH::getIblockIdByCode('sotrudniki');
        $orderPrice = $arFields['PRICE'] ;
        $elementCode = $arFields['USER_EMAIL'];

        \Bitrix\Main\Loader::includeModule("iblock");

        $res = \CIBlockElement::GetList(
            array(),
            array(
                'IBLOCK_ID' => $iblockId,
                'CODE' => $elementCode,
                'ACTIVE' => 'Y'
            ),
            false,
            false,
            array('ID', 'NAME', 'PROPERTY_COLUMN33')
        );

        $column33Value = '';
        if ($element = $res->Fetch()) {
            $column33Value = $element['PROPERTY_COLUMN33_VALUE'];

        } else {
            $column33Value = 0;
        }
        if ($column33Value >=$orderPrice){
            $diffRes = 1;
        }else{
            $diffRes = 0;
        }

        if ($diffRes != 1) {
            global $APPLICATION;
            $APPLICATION->ThrowException('Не можете заказать на эту сумму, Уменьшите количество товаров в блоке выше со списком товаров .  Стоимость заказа - '. $orderPrice . ' руб. , у Вас в наличие - ' . $column33Value . ' баллов');
            return false;
        }

        $log = date('Y-m-d H:i:s') . ' OnAfterIBlockElementUpdateHandler ' . print_r($arFields, true);
        file_put_contents(__DIR__ . '/log.txt', $log . PHP_EOL, FILE_APPEND);

    }

    // todo  изменение статуса заказа на D Выполнен
    public static function OnSaleOrderSavedHandler1(\Bitrix\Main\Event $event) {
        $order = $event->getParameter("ENTITY");
        if ($order->isCanceled() && $order->getField("STATUS_ID") != "D") {
            $order->setField("STATUS_ID", "D");

            if ($order) {
                $basket = $order->getBasket();
                $price = $basket->getPrice();
                // Получаем коллекцию свойств заказа
                $propertyCollection = $order->getPropertyCollection();
                $userId = $order->getUserId();

                $customerProperties = [];

                // Получаем email
                $emailProperty = $propertyCollection->getUserEmail();
                $orderPrice = $order->getPrice();

                $customerProperties['EMAIL'] = $emailProperty->getValue();
                $customerProperties['PRICE'] = $orderPrice;


                $iblockId = IH::getIblockIdByCode('sotrudniki');
                $propertyId = IH::getPropertyIdByCode('sotrudniki', 'COLUMN33');
                $elementCode = $customerProperties['EMAIL'];
                $propertyCode = 'COLUMN33';

                $COLUMN33_Result = \CIBlockElement::GetList(
                    [],
                    [
                        'IBLOCK_ID' => $iblockId,
                        'CODE' => $elementCode,
                        'ACTIVE' => 'Y'
                    ],
                    false,
                    false,
                    [
                        'ID',
                        'NAME',
                        'PROPERTY_' . $propertyCode
                    ]
                )->GetNext();

                $COLUMN33_Value = $COLUMN33_Result['PROPERTY_' . $propertyCode . '_VALUE'] ?? null;
                $elementId = $COLUMN33_Result['ID'];

                $COLUMN33_ValueNew = (int)$COLUMN33_Value + (int)$customerProperties['PRICE'];

                $arPrices = [$COLUMN33_Value, $customerProperties['PRICE'], $COLUMN33_ValueNew];

                // Устанавливаем значение свойства
                \CIBlockElement::SetPropertyValuesEx(
                    $elementId,
                    $iblockId,
                    array(
                        "COLUMN33" => $COLUMN33_ValueNew
                    )
                );

                foreach ($basket as $i=> $basketItem) {
                    $productName = $basketItem->getField('NAME');
                    $productId = $basketItem->getField('PRODUCT_ID');
                    $quantity = $basketItem->getField('QUANTITY');
                    $price = $basketItem->getPrice();

                    $arBasketInfo [$i]["NAME"] = $productName;
                    $arBasketInfo [$i]["productId "] = $basketItem->getField('PRODUCT_ID');
                    $arBasketInfo [$i]["quantity"] = $basketItem->getField('QUANTITY');
                    $arBasketInfo [$i]["price"] = $basketItem->getPrice();
                    $arBasketInfo [$i]["priceTotal"] = $basketItem->getPrice()*$basketItem->getField('QUANTITY');
                }
            } else {
                echo "Заказ не найден";
            }



            $log = date('Y-m-d H:i:s') . ' onSaleOrderSavedHandler1 ' . print_r($arBasketInfo, true);
            file_put_contents(__DIR__ . '/log.txt', $log . PHP_EOL, FILE_APPEND);
            \Bitrix\Main\Diag\Debug::dumpToFile($log, 'onSaleOrderSavedHandler1' . date('d-m-Y; H:i:s'));
        }

    }

}