<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$APPLICATION->IncludeComponent(
    "demo:items.list",
    "",
    [
        "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
        "IBLOCK_ID" => $arParams['IBLOCK_ID'],
        "COUNT" => $arParams['COUNT'],
        "SORT_FIELD" => $arParams['SORT_FIELD'],
        "SORT_DIRECTION" => $arParams['SORT_DIRECTION'],
    ],
    $component
);
