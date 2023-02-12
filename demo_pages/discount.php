<?php

use Bitrix\Main\Localization\Loc;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

global $APPLICATION;
global $USER;

Loc::loadMessages(__FILE__);

$APPLICATION->SetTitle(Loc::getMessage('TITLE'));

?>
<hr>
<?php

if (!($USER->IsAuthorized())) {
    ?>
    <p><?= Loc::getMessage('NOT_AUTHORIZED') ?></p>
    <?php
} else {
    $APPLICATION->IncludeComponent(
        'demo:random.discount',
        'hlblock',
        []
    );

    $APPLICATION->IncludeComponent(
        'demo:random.discount',
        'orm',
        []
    );
}

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");