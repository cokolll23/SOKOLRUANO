<?php
global $USER;

use Lab\Helpers\UsersHelpers as Users;
use Lab\Helpers\IblockHelpers as IH;

$ar = IH::getPropertyValIblockByEmailCurrentUser('sotrudniki', 'COLUMN33');

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
        <a href="<?= SITE_DIR ?>index.php#feedback"> Написать администратору </a>
    </div>
</div>

