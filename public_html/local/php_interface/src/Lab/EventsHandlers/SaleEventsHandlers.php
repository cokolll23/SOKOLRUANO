<?php
namespace Lab\EventsHandlers;


use Bitrix\Sale;
use Bitrix\Catalog;
use Bitrix\Main\Diag\Debug;
use Lab\Helpers\IblockHelpers as IH;


class SaleEventsHandlers
{
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
            $APPLICATION->ThrowException('Не можете заказать на эту сумму.  Стоимость заказа - '. $orderPrice . ' руб. , у Вас в наличие - ' . $column33Value . ' баллов');
            return false;
        }

        $log = date('Y-m-d H:i:s') . ' OnAfterIBlockElementUpdateHandler ' . print_r($arFields, true);
        file_put_contents(__DIR__ . '/log.txt', $log . PHP_EOL, FILE_APPEND);

    }

    public static function onStatusChange(Bitrix\Main\Event $event)
    {
        $log = date('Y-m-d H:i:s') . ' onStatusChange' . print_r($event, true);
        file_put_contents(__DIR__ . '/log.txt', $log . PHP_EOL, FILE_APPEND);
        Bitrix\Main\Diag\Debug::dumpToFile($log, '$event onStatusChange' . date('d-m-Y; H:i:s'));

    }

}