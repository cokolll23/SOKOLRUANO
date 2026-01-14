<?php

namespace Lab\EventsHandlers;

use Lab\Helpers\IblockHelpers as IblockHelpers;

class IblockEventsHandlers
{
    /**
     * суммируются все значения свойств ИБ в поле Итого CODE COLUMN33
     * @param $arFields
     * @return void
     */
    public static function onAfterIBlockElementUpdateHandler(&$arFields)
    {
        $iblockCode = IblockHelpers::getIBlockCodeById($arFields['IBLOCK_ID']);
        $propertyId = IblockHelpers::getPropertyIdByCode('sotrudniki', 'COLUMN33');


        if ($iblockCode === 'sotrudniki') {

            $intElementID = $arFields['ID'];
            $iblockID = $arFields['IBLOCK_ID'];

            if (!is_array($arFields['PROPERTY_VALUES']))
                return;

            $res = array_diff_key($arFields['PROPERTY_VALUES'], array($propertyId => true));

            array_walk_recursive($res, function ($item, $key) use (&$result) {
                $result[] = $item;
            });
            $summa = array_sum($result);
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

        /*$log = date('Y-m-d H:i:s') . ' OnAfterIBlockElementUpdateHandler ' . print_r($arFields, true);
        file_put_contents(__DIR__ . '/log.txt', $log . PHP_EOL, FILE_APPEND);*/

    }

    public static function onAfterIBlockElementAddHandler(&$arFields)
    {
        // todo при добавлении сотрудника в таблицу баллов CODE sotrudniki если раздел muf или komitet
        //todo  регистрация нового пользователя в группу Все покупатели
        // todo отправка писем при добавлении сообщения обратной связи CODE interlabs.feedbackform
        $IBLOCK_ID = $arFields['IBLOCK_ID'];
        $IBLOCK_CODE = IblockHelpers::getIBlockCodeById($IBLOCK_ID);

        if ($IBLOCK_CODE === 'sotrudniki') {

        }
        if ($IBLOCK_CODE === 'interlabs.feedbackform') {

            //$PROPERTY_VALUES = $arFields['PROPERTY_VALUES'];
            //$updatingElementCode = $PROPERTY_VALUES['EMAIL'];
            //$updatingElementId = IblockHelpers::getIblockElementInfo('sotrudniki', $updatingElementCode)['ID'];
            //$updatingElementChangingPropCode = $PROPERTY_VALUES['EVENT_CODE'];
            //$updatingElementChangingPropId = ;
            //$interlabsSignscoresPropsList = IblockHelpers::getPropsListIblock('interlabs.signscores');


            $log = date('Y-m-d H:i:s') . ' interlabs.feedbackform ' . print_r($arFields, true);
            file_put_contents(__DIR__ . '/log.txt', $log . PHP_EOL, FILE_APPEND);
            \Bitrix\Main\Diag\Debug::dumpToFile($log, 'interlabs.feedbackform' . date('d-m-Y; H:i:s'));

        }

        if ($IBLOCK_CODE === 'interlabs.feedbackform') {

            /* $adminEmail = COption::GetOptionString("main", "email_from");
             $iblockName = CIBlock::GetByID($targetIblockId)->Fetch()['NAME'];

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
                     <a href='/bitrix/admin/iblock_element_edit.php?IBLOCK_ID={$targetIblockId}&type=content&ID={$arFields['ID']}'>
                         Редактировать элемент
                     </a>
                 </p>
             ";

             CEvent::SendImmediate(
                 "IBLOCK_NEW_ELEMENT",
                 SITE_ID,
                 array(
                     "EMAIL_TO" => $adminEmail,
                     "SUBJECT" => $subject,
                     "BODY" => $message,
                 )
             );*/

        }


    }
}