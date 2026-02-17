<?php
global $USER;

use Lab\Helpers\UsersHelpers as UH;
use Lab\Helpers\IblockHelpers as IH;

$ar = IH::getPropertyValIblockByEmailCurrentUser('sotrudniki', 'COLUMN33');
//pretty_print($ar);
global $USER;
 $userId = $USER->GetID();
// Email текущего пользователя
$currEmail = UH::getCurrentUserEmail();
// Email  пользователя по его id
$userEmail = UH::getUserEmailByUserId(664);

$sumBallov = IH::getPropertyValueByElementCode($currEmail, 'COLUMN33');



if ($sumBallov) {

    $propertyVal = 'У вас сумма баллов : ' . $sumBallov;
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
        <? if ($ar['ID'] != '' && $USER->IsAuthorized()) { ?> <a
                href="<?= SITE_DIR ?>detal/?ELEMENT_ID=<?= $ar['ID']; ?>
		 ">Перейти на детальный просмотр баллов</a>
        <?php } ?>
    </div>
    <div class="col-12">
        <? // редактировать поля в шаблонепочтовом public_html/bitrix/components/interlabs/feedbackform/class.php
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
                ),false,
                array(
                        "ACTIVE_COMPONENT" => "N"
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
                ),false,
                array(
                        "ACTIVE_COMPONENT" => "N"
                )
        ); ?> <!--<a href="<?php /*= SITE_DIR */ ?>index.php#feedback"> Написать администратору </a>-->
    </div>
</div>
