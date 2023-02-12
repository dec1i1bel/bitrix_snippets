<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Application as App;
use Bitrix\Main\Engine\Response\Json;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\Loader;

if (!check_bitrix_sessid()) {
    die('access denied');
}

try {
    $req = App::getInstance()->getContext()->getRequest();

    $discount = intval(rand(1, 50));
    $promoCode = substr(md5(rand()), 0, 7);
    $currentTimestamp = intval((new DateTime())->getTimestamp());
    $discountTimestamp = 3600; // период действия скидки
    $userId = $req->getPost('user')['id'];

    $ajaxResponse = [
        'discount' => [],
        'minutesRemaining' => 0
    ];

    if (Loader::includeModule('highloadblock')) {
        $discountHL = 'DemoDiscount';

        if ($hlClass = getHLClassByHLName($discountHL)) {

            $rsHlData = $hlClass::getList([
                "select" => ['*'],
                'order' => ['ID' => 'DESC'],
                'filter' => [
                    '=UF_DISCOUNT_USER_ID' => $userId,
                    '>UF_DISCOUNT_END_TIMESTAMP' => $currentTimestamp-$discountTimestamp,
                ]
            ]);

            if ($hlData = $rsHlData->Fetch()) {
                if (!empty($hlData)) {
                    $tsTimeRemaining = $hlData['UF_DISCOUNT_END_TIMESTAMP']-$currentTimestamp;
                    $minutesRemaining = (DateTime::createFromTimestamp($tsTimeRemaining))->format('i');

                    $ajaxResponse = [
                        'discount' => [
                            'percentage' => $hlData['UF_DISCOUNT_PERCENTAGE'],
                            'promoCode' => $hlData['UF_DISCOUNT_PROMOCODE'],
                        ],
                        'minutesRemaining' => $minutesRemaining
                    ];
                }
            } else {
                $newDiscountId = $hlClass::add([
                    'UF_DISCOUNT_END_TIMESTAMP' => $currentTimestamp+$discountTimestamp,
                    'UF_DISCOUNT_PERCENTAGE' => $discount,
                    'UF_DISCOUNT_PROMOCODE' => $promoCode,
                    'UF_DISCOUNT_USER_ID' => $userId,
                ]);
                if (!$newDiscountId) {
                    throw new \Exception('error: discount was not added');
                } else {
                    $ajaxResponse = [
                        'discount' => [
                            'percentage' => $discount,
                            'promoCode' => $promoCode,
                        ],
                    ];
                }
            }
            (new Json($ajaxResponse))->send();
        } else {
            throw new \Exception('HL-block "' . $discountHL . '" not installed');
        }
    } else {
        throw new \Exception('Module "highloadblock" not installed');
    }
} catch (Exception $e) {
    (new Json([
        'ajax_error' => $e->getMessage()
    ]))->send();
}
