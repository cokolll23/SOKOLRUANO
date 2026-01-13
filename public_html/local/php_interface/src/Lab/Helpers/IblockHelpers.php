<?php

namespace Lab\Helpers;

use Bitrix\Iblock\IblockTable;
use Bitrix\Main\SystemException;
use Bitrix\Iblock\PropertyTable;
use Bitrix\Iblock\SectionTable;
use Bitrix\Iblock\ElementTable;
use Bitrix\Main\Loader;
use Lab\Helpers\UsersHelpers as UH;

;

Loader::includeModule('iblock');

class IblockHelpers
{
    /**
     * @throws SystemException
     */
    public static function getIblockIdByCode(string $iblockCode): int
    {
        $foundIblocks = IblockTable::getList([
            'filter' => [
                'CODE' => $iblockCode,
            ],
            'cache' => [
                'ttl' => 360000,
            ],
        ])->fetchAll();
        if (count($foundIblocks) > 1) {
            throw new SystemException('Найдено больше одного инфоблока');
        } elseif (count($foundIblocks) < 1) {
            throw new SystemException('Инфоблоки с кодом ' . $iblockCode . ' не найдены');
        }
        return $foundIblocks[0]['ID'];
    }

    /*
    * получить id раздела ИБ по коду ИБ и раздела
    * */
    public static function getGroupIdByCode(string $iblockCode, $groupCode, $SITE_ID): int
    {
        $iBlockId = self::getIblockIdByCode($iblockCode);
        $res = \CIBlockSection::GetList(array(), array('IBLOCK_ID' => $iBlockId, 'CODE' => $groupCode, 'SITE_ID' => $SITE_ID));
        $section = $res->Fetch();
        return $section['ID'];
    }

    /**
     * изменение активности элемента иб на не активный
     */

    public static function changeActiveElementIb($elementId, $active)
    {
        $el = new CIBlockElement;
        $arLoadProductArray = array(
            "ACTIVE" => "N",            // активен
        );
        $res = $el->Update($elementId, $arLoadProductArray);

    }

    public static function updateElementIblockByElementId($elementId, $iblockUpdateElCode, $arPropValues)
    {

        $el = new CIBlockElement;

        $PROP = $arPropValues;

        $arLoadProductArray = Array(
            //"MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
            "PREVIEW_TEXT"   => "текст для списка элементов",
            "DETAIL_TEXT"    => "текст для детального просмотра",
        );
        if(!empty($PROP)){
            $arLoadProductArray['PROPERTY_VALUES']=$PROP;
        }

        $arLoadProductArray = array(
            "ACTIVE" => "N",            // активен
        );
        $res = $el->Update($elementId, $arLoadProductArray);

    }

    /**
     * добавляем элемент ИБ по коду ИБ
     */
    public static function addElsToIblock($iblockCode = 'sotrudniki', $userID, $elementName, $elementCode, $sectionCode, $SITE_ID)
    {
        // todo добавить элементы в ib  'sotrudniki'
        $iBlockId = self::getIblockIdByCode($iblockCode);
        $sectId = self::getGroupIdByCode($iblockCode, $sectionCode, $SITE_ID);
        $el = new \CIBlockElement;
        $arLoadProductArray = array(
            'IBLOCK_ID' => $iBlockId,
            "IBLOCK_SECTION_ID" => $sectId,
            'NAME' => $elementName,
            "PREVIEW_TEXT" => $userID,
            'CODE' => $elementCode,
            'ACTIVE' => 'Y',
        );

        if ($PRODUCT_ID = $el->Add($arLoadProductArray)) {
            $strRes = "New ID: " . $PRODUCT_ID;
        } else {
            $strRes = "Error: " . $el->LAST_ERROR;
        }

        return $strRes;
    }

    public static function makeNormalizeArray($filePath)
    {
        $arObjFromFile = self::getArrayFromFile($filePath);
        foreach ($arObjFromFile as $arObj) {
            $arFromFile[] = (array)$arObj;
        }

        return $arFromFile;
    }

    public static function getArrayFromFile($filePath)
    {
        $arUsers = json_decode(file_get_contents($filePath));
        return $arUsers;
    }

    public static function getPropsListIblock($iblockCode = 'sotrudniki') : array
    {
        $iblockId = self::getIblockIdByCode($iblockCode);
        $properties = PropertyTable::getList([
            'filter' => ['IBLOCK_ID' => $iblockId],
            'order' => ['SORT' => 'ASC'],
            'select' => ['*']
        ]);

        while ($property = $properties->fetch()) {
            $arProps[] = $property;
        }
        return $arProps;
    }

    public static function getSectionsListIblock($iblockCode = 'sotrudniki')
    {
        $iblockId = self::getIblockIdByCode($iblockCode);

        $sections = SectionTable::getList(array(
            'select' => array('ID', 'NAME'),
            'filter' => array(
                'IBLOCK_ID' => $iblockId,
                'ACTIVE' => 'Y',
            ),
            'order' => array('SORT' => 'ASC'),
        ));
        while ($section = $sections->fetch()) {
            $arSections[] = $section;
        }
        return $arSections;
    }

    public static function getIBlockCodeById($iblockId)
    {

        $iblock = IblockTable::getById($iblockId)->fetch();

        if ($iblock) {
            $iblockCode = $iblock['CODE'];
        }

        return $iblockCode;
    }

    public static function getPropertyIdByCode($iblockCode, $propertyCode)
    {
// Получаем ID инфоблока по коду
        $res = \CIBlock::GetList([], ['CODE' => $iblockCode]);
        if ($iblock = $res->Fetch()) {
            $iblockId = $iblock['ID'];

// Получаем ID свойства по коду
            $propRes = \CIBlockProperty::GetList(
                [],
                [
                    'IBLOCK_ID' => $iblockId,
                    'CODE' => $propertyCode
                ]
            );

            if ($property = $propRes->Fetch()) {
                return $property['ID'];
            }
        }

        return false;
    }

    /*
    * получить инфу элемента иб по емеил текущего пользователя
    * array(ID NAME PROPERTY_$propertyCode_VALUE)
    * output $iblockId
    * $iblockName
    * $propVal by Code
    */
    public static function getPropertyValIblockByEmailCurrentUser($iblockCode, $propertyCode)
    {
        $currentUserEmail = UH::getCurrentUserEmail();
        $IBLOCK_ID = self::getIblockIdByCode($iblockCode);

        $propVal = \CIBlockElement::GetList(
            [],
            [
                'IBLOCK_ID' => $IBLOCK_ID,
                'CODE' => $currentUserEmail,
                'ACTIVE' => 'Y'
            ],
            false,
            false,
            [
                'ID',
                'NAME',
                'PROPERTY_' . $propertyCode
            ]
        )->GetNext();
        /* if ($propVal['PROPERTY_'.$propertyCode.'_VALUE']!=''){

        $propertyVal = 'У вас сумма баллов : '.$propVal['PROPERTY_'.$propertyCode.'_VALUE'];
        }else{
        $propertyVal = 'У вас на данный момент нет баллов';
        }*/

        return $propVal;
    }

    public static function getIblockElementInfo($iblockCode, $userEmailIbElCode)
    {
        $IBLOCK_ID = self::getIblockIdByCode($iblockCode);
        $arElVal = \CIBlockElement::GetList(
            [],
            [
                'IBLOCK_ID' => $IBLOCK_ID,
                'CODE' => $userEmailIbElCode,
                'ACTIVE' => 'Y'
            ],
            false,
            false,
            [
                'ID',
            ]
        )->GetNext();
        return $arElVal;
    }
}