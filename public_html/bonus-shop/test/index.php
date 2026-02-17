<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("test");
global $USER;
$USER->Authorize(1);
$currentUserId = $USER->GetID();
?>

<?php

use Bitrix\Sale\Order;
use Bitrix\Main\Loader;
use Bitrix\Main\Type\DateTime;
use Lab\Helpers\SaleHelpers;
use Lab\Helpers\RecalculateScores as RS;

//echo 'getTotalScores : '. $propValues = RS::getTotalScores('sotrudniki', 'vasin.v@ya.ru') . '<br>';

//echo $realPriceUserOrders = SaleHelpers::getPriceOrdersByUserId(665);

// ID пользователя
$userId = 1;

// Подгружаем модуль sale
if (!Loader::includeModule('sale')) {
    die("Не удалось загрузить модуль Интернет-магазина");
}

try {
    $orderList = Order::getList([
            'filter' => [
                    'USER_ID' => 665,
                    'CANCELED' => 'N' // N - не отменен
                // Можно добавить фильтр по статусам, если нужно исключить, например, 'F' (выполнен)
                // 'STATUS_ID' => ['N', 'P', ...] // только определенные статусы
            ],
            'select' => ['PRICE', 'CURRENCY'] // Выбираем только цену и валюту
    ]);

    $totalSum = 0;
    $currency = '';

    while ($order = $orderList->fetch()) {
        $totalSum += (float)$order['PRICE'];
        if (empty($currency)) {
            $currency = $order['CURRENCY'];
        }
    }

    echo "Сумма неотмененных заказов (D7): {$totalSum} {$currency}";

} catch (\Exception $e) {
    echo "Ошибка: " . $e->getMessage();
}


?>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>