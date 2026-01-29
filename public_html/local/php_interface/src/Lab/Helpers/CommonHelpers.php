<?php

namespace Lab\Helpers;

use Lab\Helpers\IblockHelpers as IblockHelpers;

class CommonHelpers
{
    /*
      * получаем массив юзеров с баллами по мероприятиям из json файла
     * input src файла
     * output  array
     */
    public static function getStartUsersBallyArrayFromFileJson($fileSrc = "/s2/test/ANObally.json")
    {
        /*
        * получаем массив юзеров с баллами по мероприятиям из json файла
        * $res = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/s2/test/ANObally.json");
         $arUsers = json_decode($res, true);*/
        $res = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/s2/test/ANObally.json");
        $arUsers = json_decode($res, true);

        return $arUsers;
    }

    /*
      * функция подстановки в ключи COMMON сделать метод
     * $keyValueArray массив для сравнения и подмены ключей
     * $arPropsCodes  array cdjqcnd
     */
    //  todo функция подстановки в ключи COMMON сделать метод
    public static function getReplacedArray($keyValueArray, $arPropsCodes)
    {
        $result = array_combine(array_map(fn($k) => $keyValueArray[$k] ?? $k, array_keys($arPropsCodes)), array_values($arPropsCodes));
        return $result;
    }


    public static function getRemakedArray($strFileSrcStartUsers = "/s2/test/ANObally.json", $iblockCodeProps = 'sotrudniki')
    {

        /*
         * получаем массив юзеров с баллами по мероприятиям из json файла
         *  $res = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/s2/test/ANObally.json");
         $arUsers = json_decode($res, true);*/

        $arUsers = self::getStartUsersBallyArrayFromFileJson($strFileSrcStartUsers);

        // получить массив свойств инфоблока по его коду
        $arProps = IblockHelpers::getPropsListIblock('sotrudniki');

        // получить массив Меропрятий из массива $arUsers с ключом 0 и убираем его из стартового
        $arShift = array_shift($arUsers);
        // ключи и их значения которые уберем
        $delKeys = ['field1', 'field2'];

        // todo переделаем массив под наши COMMON коды
        $u = 2;
        foreach ($arShift as $i => $arProp) {
            if ($i != 'field1' && $i != 'field2') {
                $arPropsCodes[$i] = 'COLUMN' . $u;
                $u++;
            }
        }

        // execute функция
        foreach ($arUsers as $i => $arUser) {
            $keyValueArray = array_filter(array_diff_key($arUsers[$i], array_flip($delKeys)));
            $arUsersSA[$arUsers[$i]['field2']]['fio'] = $arUsers[$i]['field1'];
            $arUsersSA[$arUsers[$i]['field2']]['props'] = self::getReplacedArray($arPropsCodes, $keyValueArray);
        }

        return $arUsersSA;
    }
}