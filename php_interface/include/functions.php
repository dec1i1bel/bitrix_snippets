<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Iblock\IblockTable;
use Bitrix\Main\Loader;

Loader::includeModule('iblock');

if (!function_exists('getIblockId')) {
    function getIblockId($ibcode) {
        return IblockTable::getList([
            'select' => ['ID'],
            'filter' => ['=CODE' => $ibcode],
        ])->fetch()['ID'];
    }
}

if (!function_exists('printr')) {
    function printr($var, $die = false) {
        if (!is_array($var)) {
            $var = [$var];
        }

        echo '<pre>__printr__';
        print_r($var);
        echo '</pre>';

        if ($die) {
            die();
        }
    }
}