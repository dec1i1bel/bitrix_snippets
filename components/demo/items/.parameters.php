<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc as Loc;

Loc::loadMessages(__FILE__);

try {
    if (Loader::includeModule('iblock')) {
        $iblockTypes = \CIBlockParameters::GetIBlockTypes(["-" => " "]);

        $iblocks = [0 => Loc::getMessage('PARAMETER_NOT_CHOOSEN')];
        $iblocksCode = [0 => Loc::getMessage('PARAMETER_NOT_CHOOSEN')];

        if (!empty($arCurrentValues['IBLOCK_TYPE'])) {

            $order = ['SORT' => 'ASC'];

            $filter = [
                'TYPE' => $arCurrentValues['IBLOCK_TYPE'],
                'ACTIVE' => 'Y'
            ];

            $rsIbs = \CIBlock::GetList($order, $filter);

            while ($iblock = $rsIbs->Fetch()) {
                $iblocks[$iblock['ID']] = $iblock['NAME'];
                $iblocksCode[$iblock['CODE']] = $iblock['NAME'];
            }
        }

        $sortFields = [
            'ID' => Loc::getMessage('PARAMETER_SORT_ID'),
            'NAME' => Loc::getMessage('PARAMETER_SORT_NAME'),
            'ACTIVE_FROM' => Loc::getMessage('PARAMETER_SORT_ACTIVE_FROM'),
            'SORT' => Loc::getMessage('PARAMETER_SORT_SORT')
        ];

        $sortDirection = [
            'ASC' => Loc::getMessage('PARAMETER_SORT_ASC'),
            'DESC' => Loc::getMessage('PARAMETER_SORT_DESC')
        ];

        $arComponentParameters = [
            'GROUPS' => [],
            'PARAMETERS' => [
                'IBLOCK_TYPE' => [
                    'PARENT' => 'BASE',
                    'NAME' => Loc::getMessage('PARAMETER_IBLOCK_TYPE'),
                    'TYPE' => 'LIST',
                    'VALUES' => $iblockTypes,
                    'DEFAULT' => '',
                    'REFRESH' => 'Y'
                ],
                'IBLOCK_ID' => [
                    'PARENT' => 'BASE',
                    'NAME' => Loc::getMessage('PARAMETER_IBLOCK_ID'),
                    'TYPE' => 'LIST',
                    'VALUES' => $iblocks
                ],
                'COUNT' => [
                    'PARENT' => 'BASE',
                    'NAME' => Loc::getMessage('PARAMETER_COUNT'),
                    'TYPE' => 'STRING',
                    'DEFAULT' => '0'
                ],
                'SORT_FIELD' => [
                    'PARENT' => 'BASE',
                    'NAME' => Loc::getMessage('PARAMETER_SORT_FIELD'),
                    'TYPE' => 'LIST',
                    'VALUES' => $sortFields
                ],
                'SORT_DIRECTION' => [
                    'PARENT' => 'BASE',
                    'NAME' => Loc::getMessage('PARAMETER_SORT_DIRECTION'),
                    'TYPE' => 'LIST',
                    'VALUES' => $sortDirection
                ],
                'SEF_MODE' => [
                    'index' => [
                        'NAME' => GetMessage('PARAMETER_LIST_PATH_LIST'),
                        'DEFAULT' => 'index.php',
                        'VARIABLES' => []
                    ],
                    'detail' => [
                        'NAME' => GetMessage('PARAMETER_LIST_PATH_DETAIL'),
                        'DEFAULT' => '#ELEMENT_ID#/',
                        'VARIABLES' => ['ELEMENT_ID'],
                    ],
                ],
            ]
        ];
    } else {
        throw new \Exception(
            Loc::getMessage('PARAMETER_IBLOCK_MODULE_NOT_INSTALLED')
        );
    }
} catch (\Exception $e) {
    ShowError($e->getMessage());
}
