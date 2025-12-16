<?php
if (file_exists(__DIR__ . '/src/autoloader.php')) {
    require_once __DIR__ . '/src/autoloader.php';
}
if (file_exists(__DIR__ . '/includes/pretty-print/pretty_print.php')) {
    require_once __DIR__ . '/includes/pretty-print/pretty_print.php';
}

use Lab\EventsHandlers\IblockEventsHandlers as EH;
use Lab\Helpers\IblockHelpers as IH;
//CUtil::InitJSCore(array('jquery3', 'popup', 'ajax', 'date'));

$eventManager = \Bitrix\Main\EventManager::getInstance();

// todo сделать хендлер при изменении элемента складывать значения свойств
$eventManager->addEventHandler("iblock", "OnAfterIBlockElementUpdate", ['Lab\EventsHandlers\IblockEventsHandlers', 'onAfterIBlockElementUpdateHandler']);
//$eventManager->addEventHandler("iblock", "OnAfterIBlockElementUpdate", 'OnAfterIBlockElementUpdateHandler');

//todo Отменяем создание заказа до его создания при цена заказа выше определенной цифры https://chat.deepseek.com/a/chat/s/6e829ee6-c90c-46b8-a2f5-dbab70924b95
AddEventHandler("sale", "OnBeforeOrderAdd", ['Lab\EventsHandlers\SaleEventsHandlers', 'onBeforeOrderAdd']);
