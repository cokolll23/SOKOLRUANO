<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("test");

?>

<?
use Bitrix\Main\UserTable;
use Lab\Helpers\UsersHelpers;
use Lab\Helpers\IblockHelpers;
use Bitrix\Iblock\Elements\ElementTable;
use Bitrix\Iblock\PropertyTable;

$PROPERTY_VALUES=IblockHelpers::getPropsListIblock('interlabs.signscores');

// todo получить id элемента по его коду сим
$elementCode = $PROPERTY_VALUES ['EMAIL'];
$elPropertyCode = $PROPERTY_VALUES ['EVENT_CODE'];
$elPropertyNewValue = $PROPERTY_VALUES ['EVENT_NAME'];

$ID=IblockHelpers::getIblockElementInfo('sotrudniki', 'somov.i@ya.ru')['ID'];
$IBLOCK_ID = IblockHelpers ::getIblockIdByCode('sotrudniki');
$VALUES = array();
$res = CIBlockElement::GetProperty($IBLOCK_ID, $ID, "sort", "asc", array());
while ($ob = $res->GetNext())
{
    if ($ob['VALUE']>0 && $ob['CODE']!='COLUMN33' ){
        $VALUES[] = $ob;
    }

}
pretty_print($VALUES);
?>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>