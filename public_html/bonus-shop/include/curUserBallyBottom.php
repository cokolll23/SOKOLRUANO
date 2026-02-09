<div class="row">

    <div class="col-md-6">
        <? $APPLICATION->IncludeComponent("interlabs:feedbackform", "bonshop", array(
	"AGREE_PROCESSING" => "N",
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"EMAIL_FROM" => "sale@sokolru.ru",
		"EMAIL_TO" => "cavjob@yandex.ru",
		"EVENT_TYPE" => "INTERLABS_FEEDBACK",
		"FIELD_CHECK" => array(
			0 => "NAME",
			1 => "PHONE",
			2 => "EMAIL",
			3 => "",
		),
		"FORM_ID" => "i_3",
		"IBLOCK_FIELDS_USE" => array(
			0 => "NAME",
			1 => "PHONE",
			2 => "EMAIL",
			3 => "MESSAGE",
		),
		"IBLOCK_FIELD_EMAIL" => "EMAIL",
		"IBLOCK_FIELD_PHONE" => "PHONE",
		"IBLOCK_ID" => "46",
		"IBLOCK_TYPE" => "feedbackmsgs",
		"MAX_FILE_COUNT" => "10",
		"MAX_FILE_SIZE" => "5",
		"MESSAGE_ID" => "137",
		"SUBJECT" => "Написать администратору",
		"USE_CAPTCHA" => "N"
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "Y"
	)
); ?>
    </div>
    <div class="col-md-6">
        <? $APPLICATION->IncludeComponent(
	"interlabs:feedbackform", 
	"bonshop", 
	array(
		"AGREE_PROCESSING" => "N",
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"EMAIL_FROM" => "sale@sokolru.ru",
		"EMAIL_TO" => "cavjob@yandex.ru , BaryshevaAD1@mos.ru, StarenkoOG@mos.ru, PORT-communications@mos.ru",
		"EVENT_TYPE" => "INTERLABS_FEEDBACK",
		"FIELD_CHECK" => array(
			0 => "",
			1 => "PHONE",
			2 => "EMAIL",
			3 => "EVENT_CODE",
			4 => "EVENT_NAME",
			5 => "SCORES_QTT",
			6 => "NAME",
			7 => "",
		),
		"FORM_ID" => "i_4",
		"IBLOCK_FIELDS_USE" => array(
		),
		"IBLOCK_FIELD_EMAIL" => "EMAIL",
		"IBLOCK_FIELD_PHONE" => "PHONE",
		"IBLOCK_ID" => "47",
		"IBLOCK_TYPE" => "feedbackmsgs",
		"MAX_FILE_COUNT" => "10",
		"MAX_FILE_SIZE" => "5",
		"MESSAGE_ID" => "137",
		"SUBJECT" => "Записать М-Баллы",
		"USE_CAPTCHA" => "N",
		"COMPONENT_TEMPLATE" => "bonshop"
	),
	false
); ?> <!--<a href="<?php /*= SITE_DIR */ ?>index.php#feedback"> Написать администратору </a>-->
    </div>
</div>
