<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("test");

?>

<?
use Bitrix\Main\UserTable;
use Lab\Helpers\UsersHelpers;
use Lab\Helpers\IblockHelpers;

$PROPERTY_VALUES=IblockHelpers::getPropsListIblock('interlabs.signscores');

// todo получить id элемента по его коду сим
$elementCode = $PROPERTY_VALUES ['EMAIL'];
$elPropertyCode = $PROPERTY_VALUES ['EVENT_CODE'];
$elPropertyNewValue = $PROPERTY_VALUES ['EVENT_NAME'];

echo IblockHelpers::getIblockElementInfo('sotrudniki', 'somov.i@ya.ru')['ID'];

pretty_print($PROPERTY_VALUES);

?>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>