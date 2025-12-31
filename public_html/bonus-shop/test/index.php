<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("test");

?>

<?$APPLICATION->IncludeComponent(
	"interlabs:feedbackform", 
	".default", 
	array(
		"AGREE_PROCESSING" => "N",
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"EMAIL_FROM" => "sale@sokolru.ru",
		"EMAIL_TO" => "",
		"EVENT_TYPE" => "INTERLABS_FEEDBACK",
		"FIELD_CHECK" => array(
			0 => "NAME",
			1 => "PHONE",
			2 => "EMAIL",
			3 => "",
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
		"IBLOCK_ID" => "19",
		"IBLOCK_TYPE" => "sporina_forms",
		"MAX_FILE_COUNT" => "10",
		"MAX_FILE_SIZE" => "5",
		"MESSAGE_ID" => "137",
		"SUBJECT" => "Напишите нам",
		"USE_CAPTCHA" => "N",
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>