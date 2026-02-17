<?php

namespace Lab\Users;

use Bitrix\Main\Entity\Query;
use Bitrix\Main\UserTable;

class UsersHelper
{
    public static function searchForMatchesByUsername($searchString)
    {


        $query = new Query(UserTable::getEntity());
        $query
            ->setSelect(['ID', 'LOGIN', 'NAME', 'LAST_NAME', 'EMAIL'])
            ->setFilter([
                [
                    'LOGIN' => '%' . $searchString . '%'

                ]
            ]);

        $result = $query->exec()->fetchAll();

        return $result;
    }

    public static function explodeEmail($email)
    {
        if (self::checkEmail($email) == 1) {
            $strRes = explode('@', $email)[0];
        } else {
            $strRes = $email;
        }

        return $strRes;
    }

    public static function checkEmail($str)
    {
        if (strpos($str, '@') !== false) {
            $blEmail = 1;
        } else {
            $blEmail = 0;
        }
        return $blEmail;
    }



}