<?php

namespace Lab\EventsHandlers;

use Lab\Helpers\UsersHelpers as UH;
use Lab\Helpers\IblockHelpers as IH;

class UserEventsHandlers
{
    public static function onAfterUserAddHandler(&$arFields)
    {
        // если группа пользователя id 12 ['STRING_ID']= EMPLOYEES_s1 то добавляем пользователя в иб sotrudniki
        $userId = $arFields["ID"];
        $arUserGroupes = $arFields["GROUP_ID"];
        $gropeCode = "EMPLOYEES_s1";
        // $codeUserGroup = UH::getUsersGroupCodeByGropeID($arFields['ID']);
        $gropeId = UH::getUsersGroupIdByCode($gropeCode);

        if (in_array($gropeId, \CUser::GetUserGroup($userId))) {
            $userName = $arFields["LAST_NAME"] . ' ' . $arFields["NAME"];
            $res = IH::addElsToIblock('sotrudniki', $userId, $userName, $arFields["EMAIL"], 'ano', 's2');
            $log = date('Y-m-d H:i:s') . ' OnAfterUserAddHandler ' . print_r($arFields, true);
            file_put_contents(__DIR__ . '/log.txt', $log . PHP_EOL, FILE_APPEND);
            \Bitrix\Main\Diag\Debug::dumpToFile($res, 'OnAfterUserAddHandler' . date('d-m-Y; H:i:s'));
        };
    }

    public static function onAfterUserUpdateHandler(&$arFields)
    {
        $ACTIVE = $arFields["ACTIVE"];
        $userId = $arFields["ID"];

        $userEmail = UH::getUserEmailByUserId($userId);
        $userIblockId = IH::getIblockElementInfo('sotrudniki', $userEmail)['ID'];

        //if ($ACTIVE == "N") {
            $el = new \CIBlockElement;
            $arLoadProductArray = array(
                "ACTIVE" => $ACTIVE,
            );
            $PRODUCT_ID = $userIblockId;
            $res = $el->Update($PRODUCT_ID, $arLoadProductArray);
        //}
        /*if ($ACTIVE == "Y") {
            $el = new \CIBlockElement;
            $arLoadProductArray = array(
                "ACTIVE" => 'Y',
            );
            $PRODUCT_ID = $userIblockId;
            $res = $el->Update($PRODUCT_ID, $arLoadProductArray);
        }*/
        $log = date('Y-m-d H:i:s') . ' onAfterUserUpdateHandler ' . print_r($arFields, true);
        file_put_contents(__DIR__ . '/log.txt', $log . PHP_EOL, FILE_APPEND);
        \Bitrix\Main\Diag\Debug::dumpToFile($log, 'onAfterUserUpdateHandler' . date('d-m-Y; H:i:s'));
    }


}