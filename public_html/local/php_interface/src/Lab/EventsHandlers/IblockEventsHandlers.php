<?php

namespace Lab\EventsHandlers;

use Lab\Helpers\IblockHelpers as IH;

class IblockEventsHandlers
{
    public static function onAfterIBlockElementUpdateHandler(&$arFields)
    {
       $iblockCode = IH::getIBlockCodeById($arFields['IBLOCK_ID']);
       $propertyId= IH::getPropertyIdByCode( 'sotrudniki','COLUMN33');

       if ($iblockCode ==='sotrudniki') {

           $intElementID = $arFields['ID'];
           $iblockID = $arFields['IBLOCK_ID'];

           if (!is_array($arFields['PROPERTY_VALUES']))
               return;

           $res = array_diff_key($arFields['PROPERTY_VALUES'], array($propertyId => true)) ;

           array_walk_recursive($res, function ($item, $key) use (&$result) {
               $result[] = $item;
           });
           $summa=array_sum($result);
       }
        \Bitrix\Main\Loader::includeModule("iblock");
        // ID инфоблока (IBLOCK_ID) и ID элемента (ID)
        $iblockId = $arFields['IBLOCK_ID']; // Замените на ваш ID инфоблока
        $elementId = $intElementID; // Замените на ID элемента

        // Новое значение для свойства COLUMN33
        $newValue = $summa;

        // Устанавливаем значение свойства
        \CIBlockElement::SetPropertyValuesEx(
            $elementId,
            $iblockId,
            array(
                "COLUMN33" => $newValue
            )
        );

        $log = date('Y-m-d H:i:s') . ' OnAfterIBlockElementUpdateHandler ' . print_r($arFields, true);
        file_put_contents(__DIR__ . '/log.txt', $log . PHP_EOL, FILE_APPEND);

    }
}