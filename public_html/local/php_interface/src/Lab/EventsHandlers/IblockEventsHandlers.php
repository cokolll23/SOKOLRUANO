<?php

namespace Lab\EventsHandlers;

use Lab\Helpers\IblockHelpers as IblockHelpers;
use Lab\Helpers\IblockHelpers as IH;
use Lab\Helpers\SaleHelpers;
use Lab\Helpers\RecalculateScores as RS;

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
        $propertyIdColumn34 = IblockHelpers::getPropertyIdByCode('sotrudniki', 'COLUMN34');
        $userEmail = $arFields['CODE'];

        if ($iblockCode === 'sotrudniki') {

            $intElementID = $arFields['ID'];
            $iblockID = $arFields['IBLOCK_ID'];

            if (!is_array($arFields['PROPERTY_VALUES']))
                return;
            $res = array_diff_key($arFields['PROPERTY_VALUES'], array($propertyId => true, $propertyIdColumn34 => true));


            array_walk_recursive($res, function ($item, $key) use (&$result) {
                $result[] = $item;
            });

            $summa = array_sum($result);
        }
        \Bitrix\Main\Loader::includeModule("iblock");
        // ID инфоблока (IBLOCK_ID) и ID элемента (ID)
        $iblockId = $arFields['IBLOCK_ID']; // Замените на ваш ID инфоблока
        $elementId = $intElementID; // Замените на ID элемента

        $arPropertyValueColumn34 = $arFields['PROPERTY_VALUES'][$propertyIdColumn34];
        foreach ($arPropertyValueColumn34 as $item) {
            if (!empty($item['VALUE'])) {
                $propertyValueColumn34 = $item['VALUE'];
            }
        }
        $newValue = $summa - $propertyValueColumn34;

        $totalPrise = RS::getTotalScores('sotrudniki', $userEmail);
        // Устанавливаем значение свойства
        /* \CIBlockElement::SetPropertyValuesEx(
             $elementId,
             $iblockId,
             array(
                 "COLUMN33" => $newValue
             )
         );*/

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

    /**
     * отправляет письмо после добавления элемента в иб interlabs.feedbackform Написать администратору
     * @param $arFields
     * @return void
     */
    public static function onAfterIBlockElementAddHandlerSendMail(&$arFields)
    {
        // todo отправка писем при добавлении сообщения обратной связи CODE interlabs.feedbackform
        $IBLOCK_ID = $arFields['IBLOCK_ID'];
        $IBLOCK_CODE = IH::getIBlockCodeById($IBLOCK_ID);
        $elID = $arFields['ID'];


        $server = \Bitrix\Main\Context::getCurrent()->getServer();
        $domain = $server->getServerName();

        if ($IBLOCK_CODE === 'interlabs.feedbackform') { // Из формы Написать администратору

            $to = $adminEmail = 'cavjob@ya.ru';

            $hrefToEditionElementInIB = "https://{$domain}/bitrix/admin/iblock_element_edit.php?IBLOCK_ID={$IBLOCK_ID}&type=feedbackmsgs&lang=ru&ID={$elID}&find_section_section=0&WF=Y";


            $iblockName = \CIBlock::GetByID($IBLOCK_ID)->Fetch()['NAME'];

            $subject = "=?UTF-8?B?" . base64_encode("Магазин бонусов форма Написать администратору") . "?=";

            $message = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <title>Пример письма</title>
</head>
<body>
<p class='highlight'>Письмо от {$arFields['NAME']} </p>
<p class='highlight'>Телефон: {$arFields ['PROPERTY_VALUES']['PHONE']} </p>
<p class='highlight'>EMAIL: {$arFields['PROPERTY_VALUES']['EMAIL']} </p>
<p class='highlight'>Сообщение: {$arFields['PROPERTY_VALUES']['MESSAGE']} </p>
<a href="{$hrefToEditionElementInIB}">В сообщение</a>
    
</body>
</html>
HTML;

            $headers = [
                'MIME-Version: 1.0',
                'Content-type: text/html; charset=utf-8',
                'From: Магазин бонусов <ya@example.com>',
                'Reply-To: ответ@example.com',
                'X-Mailer: PHP/' . phpversion()
            ];
            if (mail($to, $subject, $message, implode("\r\n", $headers))) {
                echo "<h2 style='color: green;'>Письмо отправлено администратору</h2>";
            } else {
                echo "Ошибка отправки";
            }

        }
        if ($IBLOCK_CODE === 'interlabs.signscores') { // Из формы Написать администратору


            $log = date('Y-m-d H:i:s') . ' interlabs.signscores ' . print_r($arFields, true);
            file_put_contents($_SERVER["DOCUMENT_ROOT"] . '/log.txt', $log . PHP_EOL, FILE_APPEND);
            \Bitrix\Main\Diag\Debug::dumpToFile($log, 'interlabs.signscores' . date('d-m-Y; H:i:s'));

            $to = $adminEmail = 'cavjob@ya.ru';

            $hrefToEditionElementInIB = "https://{$domain}/bitrix/admin/iblock_element_edit.php?IBLOCK_ID={$IBLOCK_ID}&type=feedbackmsgs&lang=ru&ID={$elID}&find_section_section=0&WF=Y";


            $iblockName = \CIBlock::GetByID($IBLOCK_ID)->Fetch()['NAME'];

            $subject = "=?UTF-8?B?" . base64_encode("Магазин бонусов форма Запись М-баллов") . "?=";
           /* [EVENT_CODE] => COLUMN12
            [EVENT_NAME] => Проведение семинара/вебинара/экскурсии/мастер-классадля сотрудников (детей сотрудников) 20 б
            [SCORES_QTT] => 10*/
            $message = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <title>Пример письма</title>
</head>
<body>
<p class='highlight'>Письмо от {$arFields['NAME']} </p>
<p class='highlight'>Телефон: {$arFields ['PROPERTY_VALUES']['PHONE']} </p>
<p class='highlight'>EMAIL: {$arFields['PROPERTY_VALUES']['EMAIL']} </p>
<p class='highlight'>Количество М-баллов: {$arFields['PROPERTY_VALUES']['SCORES_QTT']} </p>
<p class='highlight'>Название мероприятия: {$arFields['PROPERTY_VALUES']['EVENT_NAME']} </p>
<p class='highlight'>Код мероприятия: {$arFields['PROPERTY_VALUES']['EVENT_CODE']} </p>
<a href="{$hrefToEditionElementInIB}">В сообщение {$hrefToEditionElementInIB}</a>
    
</body>
</html>
HTML;

            $headers = [
                'MIME-Version: 1.0',
                'Content-type: text/html; charset=utf-8',
                'From: Магазин бонусов <ya@example.com>',
                'Reply-To: ответ@example.com',
                'X-Mailer: PHP/' . phpversion()
            ];
            if (mail($to, $subject, $message)) {
                echo "<h2 style='color: green;'>Письмо отправлено администратору</h2>";
            } else {
                echo "Ошибка отправки";
            }

        }


    }
}