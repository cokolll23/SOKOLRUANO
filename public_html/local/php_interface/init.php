<?php
if (file_exists(__DIR__ . '/src/autoloader.php')) {
    require_once __DIR__ . '/src/autoloader.php';
}
if (file_exists(__DIR__ . '/includes/pretty-print/pretty_print.php')) {
    require_once __DIR__ . '/includes/pretty-print/pretty_print.php';
}

use Lab\EventsHandlers\IblockEventsHandlers as EH;
use Lab\Helpers\IblockHelpers as IH;

//CUtil::InitJSCore(array('jquery3', 'popup', 'ajax', 'date'));

$eventManager = \Bitrix\Main\EventManager::getInstance();

if (!CModule::IncludeModule("sale")) {
    return;
}
if (!CModule::IncludeModule("iblock")) {
    return;
}

// todo сделать хендлер при изменении элемента складывать значения свойств
$eventManager->addEventHandler("iblock", "OnAfterIBlockElementUpdate", ['Lab\EventsHandlers\IblockEventsHandlers', 'onAfterIBlockElementUpdateHandler']);
//$eventManager->addEventHandler("iblock", "OnAfterIBlockElementUpdate", 'OnAfterIBlockElementUpdateHandler');

//todo Отменяем создание заказа до его создания при цена заказа выше определенной цифры https://chat.deepseek.com/a/chat/s/6e829ee6-c90c-46b8-a2f5-dbab70924b95
AddEventHandler("sale", "OnBeforeOrderAdd", ['Lab\EventsHandlers\SaleEventsHandlers', 'onBeforeOrderAdd']);

//todo при изменении статуса на Выполнен id F  вычитает стоимость заказа из значения св-ва COLUMN33 данного покупателя вычисляем по E-mail
// в иб sotrudniki по символьному коду элемента
//$eventManager->addEventHandler('sale', 'OnSaleStatusOrderChange', ['\Lab\EventsHandlers\SaleEventsHandlers', 'onStatusChange']);
$eventManager->addEventHandler('sale', 'OnSaleStatusOrderChange', 'statusChange');
//addEventHandler('sale', 'OnSaleOrderSaved', ['Lab\EventsHandlers\SaleEventsHandlers', 'onStatusChange']);
function statusChange(\Bitrix\Main\Event $event)

{
    $order = $event->getParameter("ENTITY");
    if (in_array($order->getField('STATUS_ID'), array('F'))) {

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

        $COLUMN33_ValueNew = (int)$COLUMN33_Value - (int)$customerProperties['PRICE'];

        $arPrices = [$COLUMN33_Value, $customerProperties['PRICE'], $COLUMN33_ValueNew];

        // Устанавливаем значение свойства
        \CIBlockElement::SetPropertyValuesEx(
            $elementId,
            $iblockId,
            array(
                "COLUMN33" => $COLUMN33_ValueNew
            )
        );


        $log = date('Y-m-d H:i:s') . ' onStatusChange' . print_r($arPrices, true);
        file_put_contents(__DIR__ . '/log.txt', $log . PHP_EOL, FILE_APPEND);
        Bitrix\Main\Diag\Debug::dumpToFile($log, '$event onStatusChange' . date('d-m-Y; H:i:s'));

    }


}
