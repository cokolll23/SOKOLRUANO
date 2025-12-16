<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
use Lab\Helpers\IblockHelpers as IH;
$arPtoperties = IH::getPropsListIblock();
$arResult["PROPERTIES"] = $arPtoperties;
$arResult["SECTIONS"] = IH::getSectionsListIblock();
$component = $this->__component;

