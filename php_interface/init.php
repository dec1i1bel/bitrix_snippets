<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Application;
use Arrilot\BitrixBlade\BladeProvider;

// toDo: универсальный autoload
require $_SERVER['DOCUMENT_ROOT']."/vendor/autoload.php";
include(__DIR__ . '/include/autoload.php');
include(__DIR__ . '/include/functions.php');

BladeProvider::register();

AddEventHandler(
    'iblock',
    'OnBeforeIBlockElementUpdate',
    'OnBeforeIBlockElementUpdateHandler'
);

function OnBeforeIBlockElementUpdateHandler(&$arFields)
{
    if (!empty($arFields)) {
        $taggedCache = Application::getInstance()->getTaggedCache();
        $taggedCache->clearByTag('iblock_'.$arFields['IBLOCK_ID'].'_item_'.$arFields['ID']);
    }
}