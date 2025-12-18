<?php

namespace Lab\Helpers;

use \Bitrix\Main\UserGroupTable as UserGroupTable;

use Bitrix\Main\Loader;
use Bitrix\Main\UserTable;
use Bitrix\Main\Security\Password;

Loader::includeModule('main');

class UsersHelpers
{
    /**
     * Получаем список активных пользователей в группе
     */

    public static function getActiveUsersInGroupId(int $groupId): array
    {
        $result = UserGroupTable::getList(array(
            'filter' => array('GROUP_ID' => $groupId, 'USER.ACTIVE' => 'Y'),
            'select' => array('USER_ID', 'NAME' => 'USER.NAME', 'LAST_NAME' => 'USER.LAST_NAME'), // выбираем идентификатор п-ля, имя и фамилию
            'order' => array('USER.ID' => 'DESC'), // сортируем по идентификатору пользователя
        ));
        while ($arGroup = $result->fetch()) {
            //Обрабатываем результат
            $arActiveGroupUsers[$arGroup['USER_ID']] = $arGroup;
        }
        return $arActiveGroupUsers;
    }

    public static function registerUserWithGroup($userFields, $groupId)
    { // https://chat.deepseek.com/a/chat/s/6093b3bf-783b-4ccc-af14-999acc92bf29
        // Проверяем обязательные поля
        if (empty($userFields['LOGIN']) || empty($userFields['EMAIL']) || empty($userFields['PASSWORD'])) {
            return ['success' => false, 'message' => 'Не заполнены обязательные поля'];
        }

        // Проверка существования пользователя
        $existingUser = UserTable::getList([
            'filter' => [
                'LOGIC' => 'OR',
                ['=LOGIN' => $userFields['LOGIN']],
                ['=EMAIL' => $userFields['EMAIL']]
            ],
            'select' => ['ID']
        ])->fetch();

        if ($existingUser) {
            return ['success' => false, 'message' => 'Пользователь уже существует'];
        }

        // Хешируем пароль
        $hashedPassword = Password::hash($userFields['PASSWORD']);

        // Создаем пользователя через CUser (более удобно для регистрации)
        $user = new \CUser;

        $defaultFields = [
            'ACTIVE' => 'Y',
            'GROUP_ID' => [$groupId], // Основной способ указания групп
            'CONFIRM_PASSWORD' => $userFields['PASSWORD']
        ];

        $userFields = array_merge($userFields, $defaultFields);

        $userId = $user->Add($userFields);

        if ($userId > 0) {
            // Дополнительная проверка/добавление группы
            $userGroups = \CUser::GetUserGroup($userId);
            if (!in_array($groupId, $userGroups)) {
                $userGroups[] = $groupId;
                \CUser::SetUserGroup($userId, $userGroups);
            }
           // addUserToGroup($userId, $groupId);

            $res = [
                'success' => true,
                'userId' => $userId,
                'message' => 'Пользователь успешно создан'
            ];
        } else {
            $res =[
                'success' => false,
                'message' => $user->LAST_ERROR
            ];
        }
        return $res;

        // Пример использования
        /*  $newUser = [
              'LOGIN' => 'newuser@example.com',
              'EMAIL' => 'newuser@example.com',
              'PASSWORD' => 'SecurePass123!',
              'NAME' => 'Петр',
              'LAST_NAME' => 'Петров',
              'PHONE_NUMBER' => '+79991234567', // Дополнительное поле
              'WORK_COMPANY' => 'Тестовая компания',
          ];

          $result = registerUserWithGroup($newUser);

          if ($result['success']) {
              echo "ID созданного пользователя: " . $result['userId'];
          } else {
              echo "Ошибка: " . $result['message'];
          }*/
    }

}