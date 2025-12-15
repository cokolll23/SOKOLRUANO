<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Таблица баллов");
?>
    <a class="btn btn-danger"  href="https://otus.cokru.ru/bitrix/admin/iblock_list_admin.php?IBLOCK_ID=19&type=news&lang=ru&find_section_section=37&SECTION_ID=37">Редактировать</a>
    <a class="btn btn-danger" href='/s2/tabl/?SECTION_ID=37'>АНО</a>
    <a class="btn btn-danger" href="/s2/tabl/?SECTION_ID=39">МУФ</a>
    <a class="btn btn-danger" href="/s2/tabl/?SECTION_ID=38">Комитет</a>

<?$APPLICATION->IncludeComponent(
        "lab:news",
        "template1",
        [
                "LIST_PROPERTY_CODE" => array("COLUMN2","COLUMN3","COLUMN4","COLUMN5","COLUMN6","COLUMN7","COLUMN8","COLUMN9","COLUMN10","COLUMN11","COLUMN12","COLUMN13","COLUMN14","COLUMN15","COLUMN16","COLUMN17","COLUMN18","COLUMN19","COLUMN20","COLUMN21","COLUMN22","COLUMN23","COLUMN24","COLUMN25","COLUMN26","COLUMN27","COLUMN28","COLUMN29","COLUMN30","COLUMN31","COLUMN32","COLUMN33",),
                "DETAIL_PROPERTY_CODE" => array("COLUMN2","COLUMN3","COLUMN4","COLUMN5","COLUMN6","COLUMN7","COLUMN8","COLUMN9","COLUMN10","COLUMN11","COLUMN12","COLUMN13","COLUMN14","COLUMN15","COLUMN16","COLUMN17","COLUMN18","COLUMN19","COLUMN20","COLUMN21","COLUMN22","COLUMN23","COLUMN24","COLUMN25","COLUMN26","COLUMN27","COLUMN28","COLUMN29","COLUMN30","COLUMN31","COLUMN32","COLUMN33",),
                "ADD_ELEMENT_CHAIN" => "N",
                "ADD_SECTIONS_CHAIN" => "Y",
                "AJAX_MODE" => "Y",
                "AJAX_OPTION_ADDITIONAL" => "",
                "AJAX_OPTION_HISTORY" => "N",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "Y",
                "BROWSER_TITLE" => "-",
                "CACHE_FILTER" => "N",
                "CACHE_GROUPS" => "Y",
                "CACHE_TIME" => "36000000",
                "CACHE_TYPE" => "A",
                "CHECK_DATES" => "Y",
                "DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
                "DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
                "DETAIL_DISPLAY_TOP_PAGER" => "N",

                "DETAIL_PAGER_SHOW_ALL" => "Y",
                "DETAIL_PAGER_TEMPLATE" => "",
                "DETAIL_PAGER_TITLE" => "Страница",

                "DETAIL_SET_CANONICAL_URL" => "N",
                "DISPLAY_BOTTOM_PAGER" => "Y",
                "DISPLAY_DATE" => "Y",
                "DISPLAY_NAME" => "Y",
                "DISPLAY_PICTURE" => "Y",
                "DISPLAY_PREVIEW_TEXT" => "Y",
                "DISPLAY_TOP_PAGER" => "N",
                "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                "IBLOCK_ID" => "21",
                "IBLOCK_TYPE" => "news",
                "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
                "LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
                "LIST_FIELD_CODE" => [
                        0 => "",
                        1 => "",
                ],

                "MESSAGE_404" => "",
                "META_DESCRIPTION" => "-",
                "META_KEYWORDS" => "-",
                "NEWS_COUNT" => "10",
                "PAGER_BASE_LINK_ENABLE" => "N",
                "PAGER_DESC_NUMBERING" => "N",
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                "PAGER_SHOW_ALL" => "N",
                "PAGER_SHOW_ALWAYS" => "N",
                "PAGER_TEMPLATE" => ".default",
                "PAGER_TITLE" => "Новости",
                "PREVIEW_TRUNCATE_LEN" => "",
                "SEF_MODE" => "N",
                "SET_LAST_MODIFIED" => "N",
                "SET_STATUS_404" => "N",
                "SET_TITLE" => "Y",
                "SHOW_404" => "N",
                "SORT_BY1" => "NAME",
                "SORT_BY2" => "SORT",
                "SORT_ORDER1" => "ASC",
                "SORT_ORDER2" => "ASC",
                "STRICT_SECTION_CHECK" => "N",
                "USE_CATEGORIES" => "N",
                "USE_FILTER" => "N",
                "USE_PERMISSIONS" => "N",
                "USE_RATING" => "N",
                "USE_REVIEW" => "N",
                "USE_RSS" => "N",
                "USE_SEARCH" => "N",
                "USE_SHARE" => "N",
                "COMPONENT_TEMPLATE" => ".default",
                "VARIABLE_ALIASES" => [
                        "SECTION_ID" => "SECTION_ID",
                        "ELEMENT_ID" => "ELEMENT_ID",
                ]
        ],
        false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>