<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("test");

use Lab\Users\UsersHelper;

$stringB = 'ziminSY@mos.ru';
echo $string2 = UsersHelper::explodeEmail($stringB);

$arMatchedUsers = UsersHelper::searchForMatchesByUsername($string2);
pretty_print($arMatchedUsers);

if (!empty($arMatchedUsers)) {
    foreach ($arMatchedUsers as $arMatchedUser) {
        echo $explPart = UsersHelper::explodeEmail($arMatchedUser['LOGIN']);
        if (strcasecmp($explPart, $string2) === 0) {

            $checkUser = 1;

        } else {
            $checkUser = 0;
        }
    }
    echo $checkUser;
}


?>

<?php

?>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>