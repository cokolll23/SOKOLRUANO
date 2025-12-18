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
$arPtoperties = $arResult["PROPERTIES"];
pretty_print($arResult["ITEMS"]);
?>
<? if ($arParams["DISPLAY_TOP_PAGER"]): ?>
    <?= $arResult["NAV_STRING"] ?><br/>
<? endif; ?>

<table class="bonus iksweb">
    <thead class="stiky">
    <tr>
        <?php global $USER;
        if ($USER->IsAdmin()) {?>
            <a class="btn btn-danger mr-1"  href="https://sokolru.ru/bitrix/admin/iblock_list_admin.php?IBLOCK_ID=21&type=users&lang=ru&find_section_section=0&SECTION_ID=0&apply_filter=Y">Редактировать</a>
        <?php }; ?>

        <?php foreach ($arResult["SECTIONS"] as $section): ?>
            <a class="btn btn-danger mr-1" href=<?= SITE_DIR . 'tablitsa-ballov/?SECTION_ID='.$section['ID']?> ><?php echo $section['NAME']?></a>
        <?php endforeach; ?>
        <br>
        <br>
    </tr>
    <tr>
        <th>Сотрудники</th>
        <?// foreach ($arResult["ITEMS"][0]['PROPERTIES'] as $ITEM): ?>
        <? foreach ($arPtoperties as $ITEM): ?>
            <th><?= $ITEM['NAME'] ?></th>
        <? endforeach; ?>

    </tr>
    </thead>
    <tbody>

    <? foreach ($arResult["ITEMS"] as $arItem): ?>
        <?
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>
        <tr class="news-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <td><? if ($arParams["DISPLAY_NAME"] != "N" && $arItem["NAME"]): ?>
                    <? if (!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])): ?>
                        <a href="<? echo $arItem["DETAIL_PAGE_URL"] ?>"><b><? echo $arItem["NAME"] ?></b></a><br/>
                    <? else: ?>
                        <b><? echo $arItem["NAME"] ?></b><br/>
                    <? endif; ?>
                <? endif; ?></td>

            <?

            foreach ($arItem["PROPERTIES"] as $pid => $arProperty): ?>
                <? if ($arProperty["VALUE"] != ''): ?>
                    <td>
                        <?= $arProperty["DISPLAY_VALUE"]; ?>
                    </td>
                <? else: ?>
                    <td></td>
                <? endif; ?>
            <? endforeach; ?>
        </tr>
    <? endforeach; ?>
    </tbody>
</table>
<? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
    <br/><?= $arResult["NAV_STRING"] ?>
<? endif; ?>



