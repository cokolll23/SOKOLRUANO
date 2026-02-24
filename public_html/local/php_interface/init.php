<?php
if (file_exists(__DIR__ . '/src/autoloader.php')) {
    require_once __DIR__ . '/src/autoloader.php';
}
if (file_exists(__DIR__ . '/includes/pretty-print/pretty_print.php')) {
    require_once __DIR__ . '/includes/pretty-print/pretty_print.php';
}

use Lab\EventsHandlers\IblockEventsHandlers as EH;
use Lab\Helpers\IblockHelpers as IH;
use \Lab\Helpers\UsersHelpers as UH;
use Lab\Helpers\RecalculateScores as RS;

\Bitrix\Main\UI\Extension::load('lab.mainjs');
// , BaryshevaAD1@mos.ru, StarenkoOG@mos.ru, PORT-communications@mos.ru
//CUtil::InitJSCore(array('jquery3', 'popup', 'ajax', 'date'));
$eventManager = \Bitrix\Main\EventManager::getInstance();

if (!CModule::IncludeModule("sale")) {
    return;
}
if (!CModule::IncludeModule("iblock")) {
    return;
}

// SALE ORDERS
//todo Отменяем создание заказа до его создания при цена заказа выше определенной цифры https://chat.deepseek.com/a/chat/s/6e829ee6-c90c-46b8-a2f5-dbab70924b95
AddEventHandler("sale", "OnBeforeOrderAdd", ['Lab\EventsHandlers\SaleEventsHandlers', 'onBeforeOrderAdd']);
//\Bitrix\Main\EventManager::getInstance()->addEventHandler('sale', 'OnSaleOrderBeforeSaved', ['Lab\EventsHandlers\SaleEventsHandlers', 'onBeforeOrderAdd1']);

// todo  при Отмене заказа из личного кабинета покупателя изменяет статус на D
$eventManager->addEventHandler("sale", "OnSaleOrderSaved", ['Lab\EventsHandlers\SaleEventsHandlers', 'OnSaleOrderSavedHandler1']);

// todo  уменьшение количества товара и итого баллов у юзера при оформлении заказа битрикс
// в SaleEventsHandlers не работает много переадресации
//$eventManager->addEventHandler('sale', 'OnSaleOrderSaved',['Lab\EventsHandlers\SaleEventsHandlers','onSaleOrderSavedHandler']);
$eventManager->addEventHandler('sale', 'OnSaleOrderSaved', 'OnSaleOrderSavedHandler');
function OnSaleOrderSavedHandler(\Bitrix\Main\Event $event)
{
    $order = $event->getParameter("ENTITY");
    $isNew = $event->getParameter("IS_NEW");
    if ($isNew) {
        $basket = $order->getBasket();
        // вычитаем кол-во шт из Доступного кол-ва при создании Заказа
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

        // вычитаем баллы из Итого при создании Заказа
        if (in_array($order->getField('STATUS_ID'), array('N'))) {

            $ORDER = \Bitrix\Sale\Order::load($order->getId());

            if (!$ORDER) {
                return;
            }

            // Получаем коллекцию свойств заказа
            $propertyCollection = $ORDER->getPropertyCollection();
            $userId = $ORDER->getUserId();

            $customerProperties = [];

            // Получаем email
            $emailProperty = $propertyCollection->getUserEmail();
            $orderPrice = $ORDER->getPrice();

            $customerProperties['EMAIL'] = $emailProperty->getValue();
            $customerProperties['PRICE'] = $orderPrice;
            $elementCode = $customerProperties['EMAIL'];
            $propertyCode = 'COLUMN33';
            $propertyCode34 = 'COLUMN34';

            $iblockId = IH::getIblockIdByCode('sotrudniki');
            $propertyId = IH::getPropertyIdByCode('sotrudniki', 'COLUMN33');
            $elementId = IH::getIblockElementInfo('sotrudniki', $elementCode)['ID'];

            // получить стоимость всех не отмененных заказов покупателя по его ID пользователя
            $elementPropColumn34Val = \Lab\Helpers\SaleHelpers::getPriceOrdersByUserId($userId);

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
                    'PROPERTY_' . $propertyCode,
                ]
            )->GetNext();

            $res = \CIBlockElement::GetProperty($iblockId, $elementId, "sort", "asc", array());
            while ($ob = $res->GetNext()) {
                if ($ob['VALUE'] > 0 && $ob['CODE'] != 'COLUMN33') {
                    $propsNotZero[] = $ob;
                }
            }

            $COLUMN33_Value = $COLUMN33_Result['PROPERTY_' . $propertyCode . '_VALUE'] ?? null;
            //$COLUMN34_Value = $COLUMN33_Result['PROPERTY_' . $propertyCode34 . '_VALUE'] ?? null;
            $elementId = $COLUMN33_Result['ID'];

            // $COLUMN34_ValueNew = $COLUMN34_Value + (int)$customerProperties['PRICE'];


            $COLUMN33_ValueNew = (int)$COLUMN33_Value - (int)$customerProperties['PRICE'];

            $arPrices = [$COLUMN33_Value, $customerProperties['PRICE'], $COLUMN33_ValueNew];

            // Устанавливаем значение свойства
            /*\CIBlockElement::SetPropertyValuesEx(
                $elementId,
                $iblockId,
                array(
                    "COLUMN33" => $COLUMN33_ValueNew,
                    "COLUMN34" => $elementPropColumn34Val
                )
            );*/
            RS::getTotalScores('sotrudniki', $elementCode);

        }
    }
}

;

//todo при изменении статуса на D  id F  вычитает стоимость заказа из значения св-ва COLUMN33 данного покупателя вычисляем по E-mail
// и при отмене из кабинета добавляет
//$eventManager->addEventHandler('sale', 'OnSaleStatusOrderChange', 'statusChange');
function statusChange(\Bitrix\Main\Event $event)
{
    $order = $event->getParameter("ENTITY");
    // если статус заказа вотменен
    if (in_array($order->getField('STATUS_ID'), array('D'))) {

        $ORDER = \Bitrix\Sale\Order::load($order->getId());

        if (!$ORDER) {
            return;
        }

        // Получаем коллекцию свойств заказа
        $propertyCollection = $ORDER->getPropertyCollection();
        $userId = $ORDER->getUserId();

        $customerProperties = [];

        // Получаем email
        $emailProperty = $propertyCollection->getUserEmail();
        $orderPrice = $ORDER->getPrice();

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


        /*$log = date('Y-m-d H:i:s') . ' onStatusChange' . print_r($arPrices, true);
        file_put_contents(__DIR__ . '/log.txt', $log . PHP_EOL, FILE_APPEND);
        Bitrix\Main\Diag\Debug::dumpToFile($log, '$event onStatusChange' . date('d-m-Y; H:i:s'));*/

    }


}


// todo действия при регистрации и удалении пользователя если пользователь из группы K-Team: Сотрудники [12 EMPLOYEES_s1]
// todo если из АНО
AddEventHandler("main", "OnAfterUserAdd", ['Lab\EventsHandlers\UserEventsHandlers', 'onAfterUserAddHandler']);
AddEventHandler("main", "OnAfterUserUpdate", ['Lab\EventsHandlers\UserEventsHandlers', 'onAfterUserUpdateHandler']);


// todo регистрация пользователя не из АНО после добавления в иб ТАБЛИЦА БОНУСОВ в группу Все покупатели [ 24 CRM_SHOP_BUYER]
// todo удаление пользователя не из АНО после добавления в иб ТАБЛИЦА БОНУСОВ в группу Все покупатели [ 24 CRM_SHOP_BUYER]
$eventManager->addEventHandler("iblock", "OnAfterIBlockElementAdd", ['Lab\EventsHandlers\IblockEventsHandlers', 'onAfterIBlockElementAddHandler']);
// todo  при изменении элемента складывать значения свойств
$eventManager->addEventHandler("iblock", "OnAfterIBlockElementUpdate", ['Lab\EventsHandlers\IblockEventsHandlers', 'onAfterIBlockElementUpdateHandler']);
//$eventManager->addEventHandler("iblock", "OnAfterIBlockElementDelete", ['Lab\EventsHandlers\IblockEventsHandlers','onAfterIBlockElementDeleteHandler']);
//$eventManager->addEventHandler("iblock", "OnAfterIBlockElementAdd", 'onAfterIBlockElementAddHandler1');
//$eventManager->addEventHandler("iblock", "OnAfterIBlockElementAdd", 'onAfterIBlockElementAddHandlerSendMail');
$eventManager->addEventHandler("iblock", "OnAfterIBlockElementAdd", ['Lab\EventsHandlers\IblockEventsHandlers', 'onAfterIBlockElementAddHandlerSendMail']);



