<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Localization\Loc as Loc;

Loc::loadMessages(__FILE__);

$arComponentDescription = [
    "NAME" => Loc::getMessage('DESCRIPTION_NAME'),
    "DESCRIPTION" => Loc::getMessage('DESCRIPTION_DESCRIPTION'),
    "ICON" => '',
    "SORT" => 10,
    "PATH" => [
        "ID" => 'demo_items',
        "NAME" => Loc::getMessage('DESCRIPTION_GROUP'),
        "SORT" => 10,
        "CHILD" => [
            "ID" => 'list',
            "NAME" => Loc::getMessage('DESCRIPTION_DIR'),
            "SORT" => 10
        ]
    ],
];
