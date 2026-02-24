<?php

namespace Lab\EventsHandlers;

use Lab\Helpers\UsersHelpers;
use Lab\Helpers\IblockHelpers;

class UserEventsHandlers
{
    /**
     * при добавлении нового сотрудника АНО - добавление его в иб sotrudniki в раздел ano
     * с названием Фамилия имя с символьным кодом почта нового сотрудника
     * @param $arFields
     * @return void
     */
    public static function onAfterUserAddHandler(&$arFields)
    {
        // если группа пользователя id 12 ['STRING_ID']= EMPLOYEES_s1 то добавляем пользователя в иб sotrudniki
        $userId = $arFields["ID"];
        $arUserGroupes = $arFields["GROUP_ID"];
        $gropeCode = "EMPLOYEES_s1";
        // $codeUserGroup = UsersHelpers::getUsersGroupCodeByGropeID($arFields['ID']);
        $gropeId = UsersHelpers::getUsersGroupIdByCode($gropeCode);

        if (in_array($gropeId, \CUser::GetUserGroup($userId))) {
            $userName = $arFields["LAST_NAME"] . ' ' . $arFields["NAME"];
            $res = IblockHelpers::addElsToIblock('sotrudniki', $userId, $userName, $arFields["EMAIL"], 'ano', 's2');
            $log = date('Y-m-d H:i:s') . ' OnAfterUserAddHandler ' . print_r($arFields, true);
            file_put_contents($_SERVER["DOCUMENT_ROOT"] . '/log.txt', $log . PHP_EOL, FILE_APPEND);
            \Bitrix\Main\Diag\Debug::dumpToFile($res, 'OnAfterUserAddHandler' . date('d-m-Y; H:i:s'));
        };
    }

    public static function onAfterUserUpdateHandler(&$arFields)
    {
        \CModule::IncludeModule('iblock');
        $ACTIVE = $arFields["ACTIVE"];
        $userId = $arFields["ID"];

        $userEmail = UsersHelpers::getUserEmailByUserId($userId);
        $userIblockId = IblockHelpers::getIblockElementInfo('sotrudniki', $userEmail)['ID'];

        if ($arFields['RESULT'] == 1) {
            $el = new \CIBlockElement;
            $arLoadProductArray = array(
                "ACTIVE" => $ACTIVE,
            );
            $PRODUCT_ID = $userIblockId;
            $res = $el->Update($PRODUCT_ID, $arLoadProductArray);
        }
        $log = date('Y-m-d H:i:s') . ' onAfterUserUpdateHandler ' . print_r($arFields, true);
        file_put_contents($_SERVER["DOCUMENT_ROOT"] . '/log.txt', $log . PHP_EOL, FILE_APPEND);
        \Bitrix\Main\Diag\Debug::dumpToFile($log, 'onAfterUserUpdateHandler' . date('d-m-Y; H:i:s'));
    }

// Функция-обработчик
    public static function onAfterUserRegisterHandler(&$arFields)
    {
        // Проверяем, что регистрация прошла успешно (присвоен ID)
        if ($arFields["USER_ID"] > 0) {
            // Здесь можно написать свой код: отправить доп. уведомление, записать в лог и т.д.
            $userId = $arFields["USER_ID"];
            $userEmail = $arFields["EMAIL"];

            // Пример: запись в лог события
            CEventLog::Add(array(
                "SEVERITY" => "INFO",
                "AUDIT_TYPE_ID" => "USER_REGISTER_SUCCESS",
                "DESCRIPTION" => "Зарегистрирован новый пользователь ID: " . $userId . ", Email: " . $userEmail,
            ));
        }
        $log = date('Y-m-d H:i:s') . ' OnAfterIBlockElementUpdateHandler ' . print_r($arFields, true);
        file_put_contents($_SERVER["DOCUMENT_ROOT"] . '/log.txt', $log . PHP_EOL, FILE_APPEND);
        Bitrix\Main\Diag\Debug::dumpToFile($log, '$event onStatusChange' . date('d-m-Y; H:i:s'));

    }
}