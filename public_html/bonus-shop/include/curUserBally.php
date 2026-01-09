<?php
global $USER;

use Lab\Helpers\UsersHelpers as Users;
use Lab\Helpers\IblockHelpers as IH;

$ar = IH::getPropertyValIblockByEmailCurrentUser('sotrudniki', 'COLUMN33');
//pretty_print($ar);
global $USER;
$userId = $USER->GetID();

if ($userId > 0) {
    // Запрашиваем профиль пользователя
    $rsUser = \CUser::GetByID($userId);
    if ($arUser = $rsUser->Fetch()) {
        $userEmail = $arUser["EMAIL"];
    }
}

if ($ar['PROPERTY_COLUMN33_VALUE'] != '') {

    $propertyVal = 'У вас сумма баллов : ' . $ar['PROPERTY_COLUMN33_VALUE'];
} else {
    $propertyVal = 'У вас на данный момент нет баллов';
} ?>


<div class="row">

    <? if ($USER->IsAuthorized()): ?>
        <div class="col-12">
            <?= $propertyVal; ?>
        </div>
    <? endif; ?>
    <div class="col-12">
        <? if ($ar['ID'] != '' && $USER->IsAuthorized()) { ?>
            <a href='<?= SITE_DIR ?>detal/?ELEMENT_ID=<?= $ar['ID']; ?>'>Перейти на детальный просмотр баллов</a>

        <?php } ?>
    </div>
    <div class="col-12">
        <? $APPLICATION->IncludeComponent(// создать инфоблок
                "interlabs:feedbackform",
                ".popup1",
                array(
                        "AGREE_PROCESSING" => "N",
                        "AJAX_MODE" => "Y",
                        "AJAX_OPTION_ADDITIONAL" => "",
                        "AJAX_OPTION_HISTORY" => "N",
                        "AJAX_OPTION_JUMP" => "N",
                        "AJAX_OPTION_STYLE" => "Y",
                        "EMAIL_FROM" => "sale@sokolru.ru",
                        "EMAIL_TO" => "cavjob@yandex.ru ,  av230267@yandex.ru",
                        "EVENT_TYPE" => "INTERLABS_FEEDBACK",
                        "FIELD_CHECK" => array(
                                0 => "NAME",
                                1 => "PHONE",
                                2 => "EMAIL",

                        ),
                        "FORM_ID" => "i_1",
                        "IBLOCK_FIELDS_USE" => array(
                                0 => "NAME",
                                1 => "PHONE",
                                2 => "EMAIL",
                                3 => "MESSAGE",

                        ),
                        "IBLOCK_FIELD_EMAIL" => "EMAIL",
                        "IBLOCK_FIELD_PHONE" => "PHONE",
                        "IBLOCK_ID" => "23",
                        "IBLOCK_TYPE" => "feedbackmsgs",
                        "MAX_FILE_COUNT" => "10",
                        "MAX_FILE_SIZE" => "5",
                        "MESSAGE_ID" => "137",
                        "SUBJECT" => "Написать администратору",
                        "USE_CAPTCHA" => "N",
                        "COMPONENT_TEMPLATE" => ".popup1"
                ),
                false
        ); ?>
        <? $APPLICATION->IncludeComponent(// создать инфоблок
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
                        "EMAIL_TO" => "cavjob@yandex.ru ,  av230267@yandex.ru",
                        "EVENT_TYPE" => "INTERLABS_FEEDBACK",
                        "FIELD_CHECK" => array(
                                0 => "NAME",
                                1 => "PHONE",
                                2 => "EMAIL",
                                3 => "EVENT_CODE",
                                4 => "EVENT_NAME",
                                5 => "SCORES_QTT",
                        ),
                        "FORM_ID" => "i_2",
                        "IBLOCK_FIELDS_USE" => array(
                                0 => "NAME",
                                1 => "PHONE",
                                2 => "EMAIL",
                                3 => "EVENT_CODE",
                                4 => "EVENT_NAME",
                                5 => "SCORES_QTT",
                        ),
                        "IBLOCK_FIELD_EMAIL" => "EMAIL",
                        "IBLOCK_FIELD_PHONE" => "PHONE",
                        "IBLOCK_ID" => "24",
                        "IBLOCK_TYPE" => "feedbackmsgs",
                        "MAX_FILE_COUNT" => "10",
                        "MAX_FILE_SIZE" => "5",

                        "SUBJECT" => "Записать баллы бонусов",
                        "USE_CAPTCHA" => "N",
                        "COMPONENT_TEMPLATE" => ".popup2"
                ),
                false
        ); ?>
        <!--<a href="<?php /*= SITE_DIR */ ?>index.php#feedback"> Написать администратору </a>-->
    </div>
</div>

