<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Iblock\IblockTable;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\Loader;
use Bitrix\Highloadblock\HighloadBlockTable as HLTable;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;

Loader::includeModule('iblock');

if (!function_exists('getIblockId')) {
    /**
     * @throws ObjectPropertyException
     * @throws SystemException
     * @throws ArgumentException
     */
    function getIblockId($ibcode)
    {
        return IblockTable::getList([
            'select' => ['ID'],
            'filter' => ['=CODE' => $ibcode],
        ])->fetch()['ID'];
    }
}

if (!function_exists('printr')) {
    function printr($var, $die = false)
    {
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

if (!function_exists('getHLClassByHLName')) {
    /**
     * @throws ObjectPropertyException
     * @throws SystemException
     * @throws ArgumentException
     */
    function getHLClassByHLName($hlname)
    {
        $rsHlBlock = HLTable::getList([
            'filter' => ['=NAME' => $hlname]
        ]);

        if ($hlBlock = $rsHlBlock->fetch()) {
            $hlClass = (HLTable::compileEntity($hlBlock))->getDataClass();
        } else {
            $hlClass = false;
        }
        return $hlClass;
    }
}