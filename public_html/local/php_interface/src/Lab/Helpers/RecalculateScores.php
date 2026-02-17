<?php

namespace Lab\Helpers;

use Bitrix\Main\Loader;
use Lab\Helpers\IblockHelpers;
use \Lab\Helpers\SaleHelpers;
use  \Lab\Helpers\UsersHelpers as UH;
use Bitrix\Sale;
use Bitrix\Sale\Order;

class RecalculateScores
{
    public static function getTotalScores($IBLOCK_CODE, $ELEMENT_CODE)
    {

        \Bitrix\Main\Loader::includeModule("iblock");

        $userId = UH::getUserIdIdByUserEmail($ELEMENT_CODE);

        // стоимость всех неотмененных заказов юзера по его id
        $realPriceUserOrders = SaleHelpers::getPriceOrdersByUserId($userId);

        // $ELEMENT_CODE Email usera
        $IBLOCK_ID = IblockHelpers::getIblockIdByCode($IBLOCK_CODE);

        $arProps = IblockHelpers::getPropsListIblock($IBLOCK_CODE);

        $props = \CIBlockElement::GetPropertyValues(
            $IBLOCK_ID,
            ['CODE' => $ELEMENT_CODE], // Фильтр по CODE элемента
            true, // extMode - вернет DESCRIPTION и PROPERTY_VALUE_ID
            []    // Фильтр свойств (пусто = все свойства)
        );

        while ($propValues0 = $props->Fetch()) {
            $propValues['arValues'][] = $propValues0;
        }

        $propValues['arPropsCodes'] = $arProps;

        foreach ($propValues['arPropsCodes'] as $code => $value) {
            if ($value['CODE'] != 'COLUMN34' && $value['CODE'] != 'COLUMN33') {
                $arPropsCodesVals[$value['ID']] = $propValues['arValues'][0][$value['ID']];
            } elseif ($value['CODE'] == 'COLUMN34') {
                $arPropsFullCodes[$value['CODE']] = $propValues['arValues'][0][$value['ID']];
            }
        }
        $COLUMN33_ValueNew = array_sum($arPropsCodesVals);
        $elementPropColumn34Val = $realPriceUserOrders;

        $elementCode = $ELEMENT_CODE;
        $iblockId = IblockHelpers::getIblockIdByCode($IBLOCK_CODE);

        $findTools = new \CIBlockFindTools();
        $elementId = $findTools->GetElementID(
            false,          // ID элемента (не используется)
            $elementCode,   // Символьный код элемента
            false,          // ID секции
            false,          // Символьный код секции
            array("IBLOCK_ID" => $iblockId) // Дополнительный фильтр
        );


        if ($arPropsFullCodes['COLUMN34'] != $elementPropColumn34Val) {

            $totalScores = array_sum($arPropsCodesVals) - $realPriceUserOrders;//$arPropsFullCodes['COLUMN34'];
            // Устанавливаем значение свойства
            \CIBlockElement::SetPropertyValuesEx(
                $elementId,
                $iblockId,
                array(
                    "COLUMN33" => $totalScores,
                    "COLUMN34" => $elementPropColumn34Val,
                )
            );

        } else {

            $totalScores = array_sum($arPropsCodesVals) - $arPropsFullCodes['COLUMN34'];

            \CIBlockElement::SetPropertyValuesEx(
                $elementId,
                $iblockId,
                array(
                    "COLUMN33" => $totalScores,
                    //"COLUMN34" => $elementPropColumn34Val,
                )
            );
        }


       // $totalScores = array_sum($arPropsCodesVals) - $realPriceUserOrders;//$arPropsFullCodes['COLUMN34'];


        return $totalScores;//$realPriceUserOrders;//$totalScores;

    }

}