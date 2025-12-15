<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
?>
<table class="bonus iksweb">
    <thead class="stiky">
    <tr>

    </tr>
    <tr>

        <? foreach ($arResult['PROPERTIES'] as $ITEM): ?>

            <th><?= $ITEM['NAME'] ?></th>
        <? endforeach; ?>

    </tr>
    </thead>
    <tbody>

   <tr>
       <? foreach($arResult["PROPERTIES"] as $pid=>$arProperty):?>
           <? if ($arProperty["VALUE"] != ''): ?>
               <td><?=$arProperty["VALUE"];?></td>
           <? else: ?>
               <td></td>
           <? endif; ?>

       <?endforeach;?>
   </tr>
    </tbody>
</table>
