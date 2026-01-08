<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Lab\Helpers\IblockHelpers;

$context = \Bitrix\Main\Application::getInstance()->getContext();
$request = $context->getRequest();

if ($request->isAjaxRequest() && $request->get("action") == "propsEventsList" ) {



    ob_start();
    $arProps=IblockHelpers::getPropsListIblock('sotrudniki');

    $output = ob_get_contents();
    ob_end_clean();

    $arResult = [
        "success" => true,
        "html" => $output
    ];
    echo json_encode($arResult);
}