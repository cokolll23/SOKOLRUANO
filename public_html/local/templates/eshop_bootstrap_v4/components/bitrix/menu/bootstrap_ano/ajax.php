<?php
$context = \Bitrix\Main\Application::getInstance()->getContext();
$request = $context->getRequest();

if ($request->isAjaxRequest() && $request->get("action") == "mobileInsert" ) {
    ob_start();
      // редактировать поля в шаблонепочтовом public_html/bitrix/components/interlabs/feedbackform/class.php
        $APPLICATION->IncludeComponent(
                "interlabs:feedbackform",
                ".popup1",
                array(
                        "AGREE_PROCESSING" => "N",
                        "AJAX_MODE" => "Y",
                        "AJAX_OPTION_ADDITIONAL" => "",
                        "AJAX_OPTION_HISTORY" => "N",
                        "AJAX_OPTION_JUMP" => "N",
                        "AJAX_OPTION_STYLE" => "Y",
                        "EMAIL_FROM" => "cavjob@yandex.ru, BaryshevaAD1@mos.ru, StarenkoOG@mos.ru, PORT-communications@mos.ru ",
                        "EMAIL_TO" => "cavjob@yandex.ru",
                        "EVENT_TYPE" => "INTERLABS_FEEDBACK",
                        "FIELD_CHECK" => array("NAME", "PHONE", "EMAIL", ""),
                        "FORM_ID" => "i_1",
                        "IBLOCK_FIELDS_USE" => array("NAME", "PHONE", "EMAIL", "MESSAGE"),
                        "IBLOCK_FIELD_EMAIL" => "EMAIL",
                        "IBLOCK_FIELD_PHONE" => "PHONE",
                        "IBLOCK_ID" => "23",
                        "IBLOCK_TYPE" => "feedbackmsgs",
                        "MAX_FILE_COUNT" => "10",
                        "MAX_FILE_SIZE" => "5",
                        "MESSAGE_ID" => "137",
                        "SUBJECT" => "Написать администратору",
                        "USE_CAPTCHA" => "N"
                )
        ); ?>
        <? $APPLICATION->IncludeComponent(
                "interlabs:feedbackform",
                ".popup2",
                array(
                        "AGREE_PROCESSING" => "N",
                        "AJAX_MODE" => "Y",
                        "AJAX_OPTION_ADDITIONAL" => "",
                        "AJAX_OPTION_HISTORY" => "N",
                        "AJAX_OPTION_JUMP" => "N",
                        "AJAX_OPTION_STYLE" => "Y",
                        "EMAIL_FROM" => "sale@sokolru.ru",
                        "EMAIL_TO" => "cavjob@yandex.ru, BaryshevaAD1@mos.ru, StarenkoOG@mos.ru, PORT-communications@mos.ru ",
                        "EVENT_TYPE" => "INTERLABS_FEEDBACK",
                        "FIELD_CHECK" => array("PHONE", "EMAIL", "EVENT_CODE", "EVENT_NAME", "SCORES_QTT", "NAME", ""),
                        "FORM_ID" => "i_2",
                        "IBLOCK_FIELDS_USE" => array("PHONE", "EMAIL", "EVENT_CODE", "EVENT_NAME", "SCORES_QTT", "NAME"),
                        "IBLOCK_FIELD_EMAIL" => "EMAIL",
                        "IBLOCK_FIELD_PHONE" => "PHONE",
                        "IBLOCK_ID" => "24",
                        "IBLOCK_TYPE" => "feedbackmsgs",
                        "MAX_FILE_COUNT" => "10",
                        "MAX_FILE_SIZE" => "5",
                        "MESSAGE_ID" => "137",
                        "SUBJECT" => "Записать баллы бонусов",
                        "USE_CAPTCHA" => "N"
                )
        );

    $output = ob_get_contents();
    ob_end_clean();

    $arResult = [
        "success" => true,
        "html" => $output
    ];
    echo json_encode($arResult);

}