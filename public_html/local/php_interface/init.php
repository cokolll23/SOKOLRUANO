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
$eventManager->addEventHandler("sale", "OnSaleOrderSaved", ['Lab\EventsHandlers\SaleEventsHandlers','OnSaleOrderSavedHandler1']);

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
            $elementPropColumn34Val= \Lab\Helpers\SaleHelpers::getPriceOrdersByUserId($userId);

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
            RS::getTotalScores('sotrudniki',  $elementCode ) ;

        }
    }
};

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
$eventManager->addEventHandler("iblock", "OnAfterIBlockElementAdd", 'onAfterIBlockElementAddHandler1');
function onAfterIBlockElementAddHandler1(&$arFields)
{
    // todo отправка писем при добавлении сообщения обратной связи CODE interlabs.feedbackform
    $IBLOCK_ID = $arFields['IBLOCK_ID'];
    $IBLOCK_CODE = IH::getIBlockCodeById($IBLOCK_ID);

    if ($IBLOCK_CODE === 'interlabs.feedbackform') {

        $log = date('Y-m-d H:i:s') . ' interlabs.feedbackform ' . print_r($arFields, true);
        file_put_contents(__DIR__ . '/log.txt', $log . PHP_EOL, FILE_APPEND);
        Bitrix\Main\Diag\Debug::dumpToFile($log, 'interlabs.feedbackform' . date('d-m-Y; H:i:s'));

         $adminEmail = 'cavjob@ya.ru';
         $iblockName = CIBlock::GetByID($IBLOCK_ID)->Fetch()['NAME'];

         $subject = "Добавлен новый элемент в инфоблок «{$iblockName}»";

         $message = "
             <h3>Новый элемент #{$arFields['ID']}</h3>
             <p><strong>Название:</strong> {$arFields['NAME']}</p>
             <p><strong>Дата создания:</strong> ".FormatDate('j F Y H:i')."</p>
         ";

         if (!empty($arFields['PREVIEW_TEXT'])) {
             $message .= "<p><strong>Описание:</strong> {$arFields['PREVIEW_TEXT']}</p>";
         }

         $message .= "
             <p>
                 <a href='/bitrix/admin/iblock_element_edit.php?IBLOCK_ID={$IBLOCK_ID}&type=content&ID={$arFields['ID']}'>
                     Редактировать элемент
                 </a>
             </p>
         ";

        $to = "cavjob@ya.ru"; // Адрес получателя
        $subject = "Привет из PHP!"; // Тема письма
        $message = "Это тестовое письмо, отправленное с помощью функции mail() в PHP."; // Тело письма
        $headers = "From: sender@example.com\r\n"; // Заголовки

      /*  mail($to, $subject, "Текст письма \n 1-ая строчка \n 2-ая строчка \n 3-ая строчка",$headers);


        CEvent::SendImmediate(
             "WF_NEW_IBLOCK_ELEMENT",
             SITE_ID,
             array(
                 "EMAIL_TO" => $adminEmail,
                 "SUBJECT" => $subject,
                 "BODY" => $message,
             )
         );*/

    }


}
// регистронезависимый логин
$eventManager->addEventHandler(
    'main',
    'OnBeforeUserLogin',
    function(&$fields) {
        // Ищем пользователя по логину без учета регистра
        $login = $fields['LOGIN'];
        $string2 = Lab\Users\UsersHelper::explodeEmail($login);
        $arMatchedUsers = Lab\Users\UsersHelper::searchForMatchesByUsername($string2);

        if (!empty($arMatchedUsers)) {
            foreach ($arMatchedUsers as $arMatchedUser) {
                $explPart = Lab\Users\UsersHelper::explodeEmail($arMatchedUser['LOGIN']);
                if (strcasecmp($explPart, $string2) === 0) {

                    $fields['LOGIN'] = $arMatchedUser['LOGIN'];

                }
            }
        }


        $log = date('Y-m-d H:i:s') . ' OnBeforeUserLogin ' . print_r($fields, true);
        file_put_contents(__DIR__ . '/log.txt', $log . PHP_EOL, FILE_APPEND);
        Bitrix\Main\Diag\Debug::dumpToFile($log, 'OnBeforeUserLogin' . date('d-m-Y; H:i:s'));

        return null;
    }
);
