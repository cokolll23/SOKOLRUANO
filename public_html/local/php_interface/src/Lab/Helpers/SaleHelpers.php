<?php

namespace Lab\Helpers;

use Bitrix\Main\Loader;
use Bitrix\Sale;
use Bitrix\Sale\Order;
use Bitrix\Main\Entity;
use Bitrix\Main\Diag\Debug;


Loader::includeModule('sale');

class SaleHelpers
{
    /**
     * получить количество товаров в корзине текущего пользователя
     * @throws SystemException
     */
    public static function getCurrentUserRealQuantityBasketProduct()
    {
        global $USER;
        if ($USER->IsAuthorized()) {
            try {
                // Получаем корзину
                $basket = Sale\Basket::loadItemsForFUser(
                    Sale\Fuser::getId(),
                    \Bitrix\Main\Context::getCurrent()->getSite()
                );
                $totalQuantity = 0;

                /** @var \Bitrix\Sale\BasketItem $item */
                foreach ($basket as $item) {
                    $product = [
                        'ID' => $item->getId(),
                        'PRODUCT_ID' => $item->getProductId(),
                        'QUANTITY' => $item->getQuantity(),
                    ];
                    $totalQuantity += $item->getQuantity();
                }

                // Возвращаем данные
                $TOTAL_QUANTITY = $totalQuantity;
                $result = [
                    'TOTAL_QUANTITY' => $totalQuantity
                ];

            } catch (\Exception $e) {
                // Обработка ошибок
                $result = [
                    'ERROR' => $e->getMessage()
                ];
            }
        }
        return $result;
    }

    /**
     * получить заказы(Стоимость всех) с ид N(Принят) , DF(Отгружен)  F  (выполнен) и   текущего пользователя
     * @throws SystemException
     */
    public static function getCurrentUserPriceOrders()
    { // todo добавить вывод потраченных баллов
        global $USER;
        $userId = $USER->GetID();

        if ($userId > 0) {
            $orders = Order::getList([
                'select' => [
                    'ID',
                    'PRICE'
                ],
                'filter' => [
                    'USER_ID' => $userId,
                    // Можно добавить дополнительные фильтры:
                    // '>=DATE_INSERT' => (new DateTime())->modify('-1 month'), // За последний месяц
                    '!CANCELED' => 'Y', // Только не отмененные
                ],
                'order' => [],
            ]);

            while ($order = $orders->fetch()) {
                // Обработка каждого заказа
                $TotalPrice += $order['PRICE'];
            }

        }
        return $TotalPrice;
    }

    /**
     * получить заказы(Стоимость всех) с ид N(Принят) , DF(Отгружен)  F  (выполнен) и   по id  пользователя
     * @throws SystemException
     */
    public static function getPriceOrdersByUserId($user_id,$CANCELED = 'N')
    {
        Loader::includeModule('sale');

        $orders = Order::getList([
            'filter' => [
                'USER_ID' => $user_id,
                'CANCELED' => $CANCELED, // если нужно исключить отмененные
            ],
            'select' => ['ID', 'PRICE', 'CURRENCY']
        ]);

        while ($order = $orders->fetch()) {
            $totalSum += $order['PRICE'];
        }

        return $totalSum;

    }


}