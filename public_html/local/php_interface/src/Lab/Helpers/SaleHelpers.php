<?php

namespace Lab\Helpers;

use Bitrix\Main\Loader;
use Bitrix\Sale;


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

}