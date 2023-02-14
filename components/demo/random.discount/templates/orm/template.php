<?php

use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

global $APPLICATION;

$user = $arResult['USER'];
?>
<h2 class="mt-4"><?= Loc::getMessage('TYPE_ORM') ?></h2>
<form
        id="form_get_discount_orm"
        action="<?= $this->getFolder() . '/ajax.php' ?>"
        method="post"
        enctype="multipart/form-data"
        style="max-width: 520px"
        class="border p-3"
>
    <?= bitrix_sessid_post() ?>
    <input type="hidden" id="user_orm_id" name="user_orm[id]" value="<?= $user['ID'] ?>"/>
    <fieldset disabled>
        <div class="mb-3">
            <label for="discount_orm_quantity" class="form-label"><?= Loc::getMessage('ORM_PERCENTAGE') ?></label>
            <input type="number" value="" id="discount_orm_quantity" name="" class="form-control">
        </div>
        <div class="mb-3">
            <label for="discount_orm_code" class="form-label"><?= Loc::getMessage('ORM_PROMOCODE') ?></label>
            <input type="text" value="" id="discount_orm_code" name="" class="form-control">
        </div>
    </fieldset>
    <div class="mb-3">
        <button type="submit" class="btn btn-primary"><?= Loc::getMessage('ORM_GET_DISCOUNT') ?></button>
    </div>
    <p class="discount-status-message js-discount-status-message-orm"></p>
    <div class="mb-3">
        <label for="discount_orm_check" class="form-label"><?= Loc::getMessage('ORM_PUT_PROMOCODE') ?></label>
        <input type="text" value="" id="discount_orm_check" name="discount_orm[check]" class="form-control">
    </div>
    <div class="mb-3">
        <button type="submit" class="btn btn-primary"><?= Loc::getMessage('ORM_CHECK_DISCOUNT') ?></button>
    </div>
    <p class="discount-status-message js-check-status-message-orm"></p>
    <?php
    //toDo: cron удаления протухших скидок
    ?>
</form>