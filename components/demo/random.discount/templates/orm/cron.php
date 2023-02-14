<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Type\DateTime;
use Demo\Orm\RandomDiscountTable;

try {
    $currentTimestamp = intval((new DateTime())->getTimestamp());
    $discountTimestamp = 86400;

    $rsData = RandomDiscountTable::getList([
        "select" => ['ID'],
        'filter' => [
            '>END_TIMESTAMP' => $currentTimestamp - $discountTimestamp,
        ],
    ]);

    while ($data = $rsData->Fetch()) {
        RandomDiscountTable::delete($data['ID']);
    }

} catch (\Exception $e) {
    ShowError($e->getMessage());
}