<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
IncludeTemplateLangFile($_SERVER["DOCUMENT_ROOT"] . "/bitrix/templates/" . SITE_TEMPLATE_ID . "/header.php");
CJSCore::Init(array("fx"));

\Bitrix\Main\UI\Extension::load(["ui.bootstrap4", "ui.fonts.opensans"]);

if (isset($_GET["theme"]) && in_array($_GET["theme"], array("blue", "green", "yellow", "red"))) {
    COption::SetOptionString("main", "wizard_eshop_bootstrap_theme_id", $_GET["theme"], false, SITE_ID);
}
$theme = COption::GetOptionString("main", "wizard_eshop_bootstrap_theme_id", "green", SITE_ID);

$curPage = $APPLICATION->GetCurPage(true);

?><!DOCTYPE html>
<html xml:lang="<?= LANGUAGE_ID ?>" lang="<?= LANGUAGE_ID ?>">
<head>
    <title><? $APPLICATION->ShowTitle() ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width">
    <link rel="shortcut icon" type="image/x-icon" href="<?= SITE_DIR ?>favicon.ico"/>

    <? $APPLICATION->ShowHead();
    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . '/css/fonts/ony/ony.css');
    ?>

</head>
<body class="bx-background-image bx-theme-<?= $theme ?>" <? $APPLICATION->ShowProperty("backgroundImage"); ?>>
<div id="panel"><? $APPLICATION->ShowPanel(); ?></div>

<div class="bx-wrapper" id="bx_eshop_wrap">
    <header class="bx-header stiky">
        <div class="bx-header-section container-fluid">
            <!--region bx-header-->
            <div class="row pt-0 pt-md-3 mb-3 align-items-center" style="position: relative;">
                <div class="d-block d-md-none bx-menu-button-mobile" data-role='bx-menu-button-mobile-position'></div>
                <!--region menu-->
                <? if ($curPage == SITE_DIR . "index.php"): ?>
                    <div class="col-4">
                        <? $APPLICATION->IncludeComponent(
                                "bitrix:menu",
                                "bootstrap_ano",
                                array(
                                        "ROOT_MENU_TYPE" => "left",
                                        "MENU_CACHE_TYPE" => "A",
                                        "MENU_CACHE_TIME" => "36000000",
                                        "MENU_CACHE_USE_GROUPS" => "Y",
                                        "MENU_THEME" => "red",
                                        "CACHE_SELECTED_ITEMS" => "N",
                                        "MENU_CACHE_GET_VARS" => array(),
                                        "MAX_LEVEL" => "3",
                                        "CHILD_MENU_TYPE" => "left",
                                        "USE_EXT" => "N",
                                        "DELAY" => "N",
                                        "ALLOW_MULTI_SELECT" => "N",
                                        "COMPONENT_TEMPLATE" => "bootstrap_ano"
                                ),
                                false
                        ); ?>
                    </div>
                <? else: ?>
                    <div class="col-4">
                        <? $APPLICATION->IncludeComponent(
                                "bitrix:menu",
                                "bootstrap_ano",
                                array(
                                        "ROOT_MENU_TYPE" => "top",
                                        "MENU_CACHE_TYPE" => "A",
                                        "MENU_CACHE_TIME" => "36000000",
                                        "MENU_CACHE_USE_GROUPS" => "Y",
                                        "MENU_THEME" => "red",
                                        "CACHE_SELECTED_ITEMS" => "N",
                                        "MENU_CACHE_GET_VARS" => array(),
                                        "MAX_LEVEL" => "3",
                                        "CHILD_MENU_TYPE" => "left",
                                        "USE_EXT" => "N",
                                        "DELAY" => "N",
                                        "ALLOW_MULTI_SELECT" => "N",
                                        "COMPONENT_TEMPLATE" => "bootstrap_ano"
                                ),
                                false
                        ); ?>
                    </div>
                <? endif; ?>

                <!--endregion-->
                <div class="col-4 col-md-4 align-items-center bx-header-logo"
                     style="display: flex;justify-content: center;">
                    <a class="bx-logo-block d-none d-md-block" href="<?= SITE_DIR ?>">
                        <? $APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                array(
                                        "AREA_FILE_SHOW" => "file",
                                        "PATH" => SITE_DIR . "include/company_logo.php"),
                                false
                        ); ?>
                    </a>
                    <a class="bx-logo-block d-block d-md-none text-center" href="<?= SITE_DIR ?>">
                        <? $APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                array(
                                        "AREA_FILE_SHOW" => "file",
                                        "PATH" => SITE_DIR . "include/company_logo_mobile.php"
                                ),
                                false
                        ); ?>
                    </a>
                </div>

                <div class="col-4 d-none d-md-block bx-header-personal">
                    <? $APPLICATION->IncludeComponent(
                            "bitrix:sale.basket.basket.line",
                            "bootstrap_v4",
                            array(
                                    "PATH_TO_BASKET" => SITE_DIR . "personal/cart/",
                                    "PATH_TO_PERSONAL" => SITE_DIR . "personal/",
                                    "SHOW_PERSONAL_LINK" => "N",
                                    "SHOW_NUM_PRODUCTS" => "Y",
                                    "SHOW_TOTAL_PRICE" => "Y",
                                    "SHOW_PRODUCTS" => "N",
                                    "POSITION_FIXED" => "N",
                                    "SHOW_AUTHOR" => "Y",
                                    "PATH_TO_REGISTER" => SITE_DIR . "login/",
                                    "PATH_TO_PROFILE" => SITE_DIR . "personal/"
                            ),
                            false,
                            array()
                    ); ?>
                </div>

                <!--<div class="col bx-header-contact">
                    <div class="d-flex align-items-center justify-content-between justify-content-md-center flex-column flex-sm-row flex-md-column flex-lg-row">
                        <div class="p-lg-3 p-1">
                            <div class="bx-header-phone-block">
                                <i class="bx-header-phone-icon"></i>
                                <span class="bx-header-phone-number">
									<? /* $APPLICATION->IncludeComponent(
                                            "bitrix:main.include",
                                            "",
                                            array(
                                                    "AREA_FILE_SHOW" => "file",
                                                    "PATH" => SITE_DIR . "include/telephone.php"
                                            ),
                                            false
                                    ); */ ?>
								</span>
                            </div>
                        </div>
                        <div class="p-lg-3 p-1">
                            <div class="bx-header-worktime">
                                <div class="bx-worktime-title"><?php /*= GetMessage('HEADER_WORK_TIME'); */ ?></div>
                                <div class="bx-worktime-schedule">
                                    <? /* $APPLICATION->IncludeComponent(
                                            "bitrix:main.include",
                                            "",
                                            array(
                                                    "AREA_FILE_SHOW" => "file",
                                                    "PATH" => SITE_DIR . "include/schedule.php"
                                            ),
                                            false
                                    ); */ ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>-->
            </div>
            <!--endregion-->


            <!--region search.title -->
            <?php
            //if ($curPage != SITE_DIR."index.php"):
            if (1):
                if (\Bitrix\Main\ModuleManager::isModuleInstalled('search')):
                    ?>
                    <div class="row mb-4">
                        <div class="col">
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
            endif;
            ?>
            <!--endregion-->

            <!--region breadcrumb-->
            <? if ($curPage != SITE_DIR . "index.php"): ?>
                <div class="row mb-4">
                    <div class="col" id="navigation">
                        <? $APPLICATION->IncludeComponent(
                                "bitrix:breadcrumb",
                                "universal",
                                array(
                                        "START_FROM" => "0",
                                        "PATH" => "",
                                        "SITE_ID" => "-"
                                ),
                                false,
                                array('HIDE_ICONS' => 'Y')
                        ); ?>
                    </div>
                </div>
                <h1 id="pagetitle"><? $APPLICATION->ShowTitle(false); ?></h1>
            <? endif ?>
            <!--endregion-->
        </div>
    </header>

    <div class="workarea">
        <div class="container-fluid bx-content-section">
            <!--red banner img-->
            <? if ($curPage == SITE_DIR . "index.php"): ?>
                <div class="row lab-banner">
                    <div class='col lab-banner_text-wrapp'>
                        <div class='col lab-banner_text-inner'>
                            <div class="">
                                <div class="lab-banner_text-big1">Магазин</div>
                                <br>
                                <div class="lab-banner_text-big2">бонусов</div>
                            </div>
                            <div class="">
                                <div class="lab-banner_text-small1">Обменяй М-баллы</div>
                                <div class="lab-banner_text-small2">на приятные сюрпризы!</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 lab-banner-img">
                        <? $curPage = $APPLICATION->GetCurPage(true);
                        if ($curPage == SITE_DIR . "index.php"):
                            $APPLICATION->IncludeComponent(
                                    "bitrix:main.include",
                                    "",
                                    array(
                                            "AREA_FILE_SHOW" => "file",
                                            "PATH" => SITE_DIR . "include/banner-img.php"),
                                    false
                            );
                        endif; ?>
                    </div>
                </div>
                <div class="container">
                    <div id="lab-text-order" class="row lab-text-order">
                        <? $APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                array(
                                        "AREA_FILE_SHOW" => "file",
                                        "PATH" => SITE_DIR . "include/text-order.php"
                                ),
                                false
                        ); ?>

                    </div>
                </div>
                <div class="row container lab-text-order1">
                    <? $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            array(
                                    "AREA_FILE_SHOW" => "file",
                                    "PATH" => SITE_DIR . "include/text-order1.php"
                            ),
                            false
                    ); ?>

                </div>
            <? endif ?>
            <!--End red banner img-->
            <? if ($curPage != SITE_DIR . "tablitsa-ballov/index.php"): ?>
            <div class="row row-content ">
                <? else: ?>
                <div class="row ">
                    <? endif; ?>
                    <? $needSidebar = preg_match("~^" . SITE_DIR . "(catalog|personal\/cart|personal\/order\/make)/~", $curPage); ?>
                    <div class="bx-content <?= ($needSidebar ? "col" : "col-md-9 col-sm-8") ?>">