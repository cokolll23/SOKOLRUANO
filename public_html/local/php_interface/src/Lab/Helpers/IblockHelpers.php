<?php

namespace Lab\Helpers;

use Bitrix\Iblock\IblockTable;
use Bitrix\Main\SystemException;
use Bitrix\Iblock\PropertyTable;

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

    public static function addElsToIblock($arUsers, $IblockId)
    {
// todo добавить элементы в ib  'sotrudniki'
    }

    public static function getPropsListIblock($iblockCode='sotrudniki')
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


}