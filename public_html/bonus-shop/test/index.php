<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("test");

?>

<?
use Bitrix\Main\UserTable;
use Lab\Helpers\UsersHelpers as UH;



function getUserWithDetails($userId) {
    $user = CUser::GetByID($userId)->Fetch();

    if ($user) {
        // Получить группы пользователя
        $userGroups = CUser::GetUserGroup($userId);
        $user['GROUPS'] = $userGroups;

        // Получить отделы (если есть модуль intranet)
        /*if (CModule::IncludeModule('intranet')) {
            $departments = CIntranetUtils::GetUserDepartments($userId);
            $user['DEPARTMENTS'] = $departments;
        }*/
    }

    return $user;
}
$userId = 2397;
$userGroups = CUser::GetUserGroup($userId);
//$arUser=getUserWithDetails($userId) ;
pretty_print($userGroups);

echo $gropeId = UH::getUsersGroupIdByCode('EMPLOYEES_s1');
$arGroups = CUser::GetUserGroup($userId);
//pretty_print($arGroups);
if (in_array(12, CUser::GetUserGroup($userId)))
{
    echo 1;

};

?>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>