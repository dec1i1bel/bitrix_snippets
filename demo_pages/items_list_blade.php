<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

global $APPLICATION;

$APPLICATION->IncludeComponent(
    "demo:items.list",
    "blade.default",
    array(
        "IBLOCK_TYPE" => "news",
        "IBLOCK_ID" => getIblockId('news'),
        "COUNT" => "",
        "SORT_FIELD" => "ID",
        "SORT_DIRECTION" => "ASC",
    ),
    false
);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");