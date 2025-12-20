<?php

use Lab\Helpers\UsersHelpers as Users;
use Lab\Helpers\IblockHelpers as IH;

$ar = IH::getPropertyValIblockByEmailCurrentUser('sotrudniki', 'COLUMN33');

if ($ar['PROPERTY_COLUMN33_VALUE'] != '') {

    $propertyVal = 'У вас сумма баллов : ' . $ar['PROPERTY_COLUMN33_VALUE'];
} else {
    $propertyVal = 'У вас на данный момент нет баллов';
} ?>
<div>
    <?= $propertyVal; ?>
</div>
<? if ($ar['ID'] != '') { ?>
    <a href='<?= SITE_DIR ?>tablitsa-ballov/?ELEMENT_ID=<?= $ar['ID']; ?>'>Перейти на детальный просмотр баллов</a>
<?php } ?>
<a href="<?= SITE_DIR?>index.php#feedback"> Написать администратору </a>

