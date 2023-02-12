<?php

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Type\DateTime;
use Bitrix\Main\Loader;
use Bitrix\Highloadblock\HighloadBlockTable as HLTable;

try {
    if (Loader::includeModule('highloadblock')) {

        $discountHL = 'DemoDiscount';

        $currentTimestamp = intval((new DateTime())->getTimestamp());
        $discountTimestamp = 1; // период действия скидки

        $rsHlBlock = HLTable::getList([
            'filter' => ['=NAME' => $discountHL],
        ]);

        if ($hlBlock = $rsHlBlock->fetch()) {

            $hlClass = (HLTable::compileEntity($hlBlock))->getDataClass();

            $rsHlData = $hlClass::getList([
                "select" => ['*'],
                'filter' => [
                    '>UF_DISCOUNT_END_TIMESTAMP' => $currentTimestamp - $discountTimestamp,
                ],
            ]);

            while ($hlData = $rsHlData->Fetch()) {
                $hlClass::Delete($hlData['ID']);
            }

        } else {
            throw new \Exception('HL-block "' . $discountHL . '" not installed');
        }
    } else {
        throw new \Exception('Module "highloadblock" not installed');
    }

} catch (\Exception $e) {
    ShowError($e->getMessage());
}