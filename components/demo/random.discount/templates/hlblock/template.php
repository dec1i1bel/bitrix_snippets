<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

global $APPLICATION;

Loc::loadMessages(__FILE__);

$user = $arResult['USER'];

?>
<h2 class="mt-4"><?= Loc::getMessage('TYPE_HLBLOCK') ?></h2>
<form
        id="form_get_discount_hlblock"
        action="<?= $this->GetFolder() . '/ajax.php' ?>"
        method="post"
        enctype="multipart/form-data"
        style="max-width: 520px"
        class="border p-3"
>
    <?= bitrix_sessid_post() ?>
    <input type="hidden" id="user_hlblock_id" name="user_hlblock[id]" value="<?= $user['ID'] ?>">
    <fieldset disabled>
        <div class="mb-3">
            <label for="discount_quantity_hlblock" class="form-label"><?= Loc::getMessage('HL_PERCENTAGE') ?></label>
            <input type="number" value="" id="discount_hlblock_quantity" name="discount_hlblock[quantity]"
                   class="form-control">
        </div>
        <div class="mb-3">
            <label for="discount_hlblock_code" class="form-label"><?= Loc::getMessage('HL_PROMOCODE') ?></label>
            <input type="text" value="" id="discount_hlblock_code" name="discount_hlblock[code]" class="form-control">
        </div>
    </fieldset>
    <div class="mb-3">
        <button type="submit" class="btn btn-primary"><?= Loc::getMessage('HL_GET_DISCOUNT') ?></button>
    </div>
    <p class="discount-status-message js-discount-status-message-hlblock"></p>
</form>