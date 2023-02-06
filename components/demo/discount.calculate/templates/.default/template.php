<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

global $APPLICATION;

$user = $arResult['USER'];

if (empty($user['MESSAGE_NOT_AUTHORIZED'])) {
    ?>
    <form
        id="form_get_discount"
        action="<?= '/local/components/demo/discount.calculate/templates/.default/ajax.php' ?>"
        method="post"
        enctype="multipart/form-data"
        style="max-width: 520px"
    >
        <?= bitrix_sessid_post() ?>
        <input type="hidden" id="user_id" name="user[id]" value="<?= $user['ID'] ?>" />
        <fieldset disabled>
            <div class="mb-3">
                <label for="discount_quantity" class="form-label">Процент скидки:</label>
                <input type="number" value="" id="discount_quantity" name="discount[quantity]" class="form-control">
            </div>
            <div class="mb-3">
                <label for="discount_code" class="form-label">Промокод:</label>
                <input type="text" value="" id="discount_code" name="discount[code]" class="form-control">
            </div>
        </fieldset>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Получить скидку</button>
        </div>
        <p class="discount-status-message js-discount-status-message"></p>
    </form>
    <?php
} else {
    ?>
    <p class="fs-2"><?= $user['MESSAGE_NOT_AUTHORIZED'] ?></p>
    <?php
}

?>