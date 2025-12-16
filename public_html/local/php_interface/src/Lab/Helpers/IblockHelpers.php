<?php

namespace Lab\Helpers;

use Bitrix\Iblock\IblockTable;
use Bitrix\Main\SystemException;
use Bitrix\Iblock\PropertyTable;
use Bitrix\Iblock\SectionTable;
use Bitrix\Iblock\ElementTable;
use Bitrix\Main\Loader;

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

    public static function addElsToIblock($iblockCode = 'sotrudniki', $elementName, $elementCode)
    {
        // todo добавить элементы в ib  'sotrudniki'
        $iBlockId = self::getIblockIdByCode($iblockCode);

        $result = ElementTable::add([
            'IBLOCK_ID' => $iBlockId,
            'NAME' => $elementName,
            'CODE' => $elementCode,
            'ACTIVE' => 'Y',
        ]);

        if ($result->isSuccess()) {
            $elementId = $result->getId();
            $strRes = "Элемент добавлен с ID: " . $elementId;
        } else {
            $errors = $result->getErrorMessages();
            $strRes = $errors[0];
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

    public static function getPropsListIblock($iblockCode = 'sotrudniki')
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
}