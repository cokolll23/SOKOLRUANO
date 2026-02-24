<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Lab\Helpers\IblockHelpers;

$context = \Bitrix\Main\Application::getInstance()->getContext();
$request = $context->getRequest();

if ($request->isAjaxRequest() && $request->get("action") == "propsEventsList" ) {

    $arProps=IblockHelpers::getPropsListIblockForFeedBackForm('sotrudniki');

    ob_start();?>
    <ul class="ul-events-props">
    <? foreach ($arProps as $prop) {?>
        <li id="<?= $prop['CODE']?>" class="li-events-prop" value="<?= $prop['CODE']?>"><?= $prop['NAME']?></li>
    <?php }?>
    </ul>
   <? $output = ob_get_contents();
    ob_end_clean();

    $arResult = [
        "success" => true,
        "html" => $output
    ];
    echo json_encode($arResult);
}