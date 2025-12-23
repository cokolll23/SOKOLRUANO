<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
//pretty_print($arResult);
?>
<div class="news-detail">
    <? if ((!isset($arParams["DISPLAY_NAME"]) || $arParams["DISPLAY_NAME"] != "N") && $arResult["NAME"]): ?>
        <h3><?= $arResult["NAME"] ?></h3>
    <? endif; ?>
    <div style="clear:both"></div>
    <br/>

    <?
    foreach ($arResult["DISPLAY_PROPERTIES"] as $pid => $arProperty):?>
        <? if ($pid === 'COLUMN33'): ?>
            <div class="item i-<?= $pid ?>">
           <span style="font-weight: bold; font-size: 120%"> <?= $arProperty["NAME"] ?>:&nbsp;
            <?= $arProperty["DISPLAY_VALUE"]; ?>
               </span>
            </div>
        <?else:?>
            <div class="item i-<?= $pid ?>">
           <span> <?= $arProperty["NAME"] ?>:&nbsp;
            <?= $arProperty["DISPLAY_VALUE"]; ?>
               </span>
            </div>

        <? endif; ?>
        <br/>
    <?endforeach;

    ?>
</div>