<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

global $APPLICATION;

$APPLICATION->IncludeComponent(
    'demo:discount.calculate',
    '',
    []
);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");