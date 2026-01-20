<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Lab\Helpers\IblockHelpers;

$context = \Bitrix\Main\Application::getInstance()->getContext();
$request = $context->getRequest();

if ($request->isAjaxRequest() && $request->get("action") == "mobileInsert" ) {



    ob_start();?>
    <!--region search.title -->
    <?php

    if (\Bitrix\Main\ModuleManager::isModuleInstalled('search')):?>
        <div class="searchMobile">
            <div class="">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:search.title",
                    "visual1",
                    array(
                        "NUM_CATEGORIES" => "1",
                        "TOP_COUNT" => "5",
                        "CHECK_DATES" => "N",
                        "SHOW_OTHERS" => "N",
                        "PAGE" => SITE_DIR . "tablitsa-ballov/",
                        "CATEGORY_0_TITLE" => GetMessage("SEARCH_GOODS"),
                        "CATEGORY_0" => array(
                            0 => "iblock_catalog",
                            1 => "iblock_users",
                        ),
                        "CATEGORY_0_iblock_catalog" => array(
                            0 => "all",
                        ),
                        "CATEGORY_OTHERS_TITLE" => GetMessage("SEARCH_OTHER"),
                        "SHOW_INPUT" => "Y",
                        "INPUT_ID" => "title-search-input",
                        "CONTAINER_ID" => "search",
                        "PRICE_CODE" => array(
                            0 => "BASE",
                        ),
                        "SHOW_PREVIEW" => "Y",
                        "PREVIEW_WIDTH" => "75",
                        "PREVIEW_HEIGHT" => "75",
                        "CONVERT_CURRENCY" => "Y",
                        "COMPONENT_TEMPLATE" => "visual",
                        "ORDER" => "date",
                        "USE_LANGUAGE_GUESS" => "Y",
                        "TEMPLATE_THEME" => "red",
                        "PRICE_VAT_INCLUDE" => "Y",
                        "PREVIEW_TRUNCATE_LEN" => "",
                        "CURRENCY_ID" => "RUB",
                        "CATEGORY_0_iblock_users" => array(
                            0 => "all",
                        )
                    ),
                    false
                ); ?>
            </div>
        </div>
    <?php
    endif;

    ?>
    <!--endregion-->

   <?php $output = ob_get_contents();
    ob_end_clean();

    $arResult = [
        "success" => true,
        "html" => $output
    ];
    echo json_encode($arResult);
}