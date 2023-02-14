<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Application as App;
use Bitrix\Main\Engine\Response\Json;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\Loader;
use Demo\Utils\Validators;

if (!check_bitrix_sessid()) {
    die('access denied');
}

try {
    $req = App::getInstance()->getContext()->getRequest();

    $userId = $req->getPost('user_hlblock')['id'];
    $discountCheckCode = $req->getPost('discount_hlblock')['check'];
    $currentTimestamp = intval((new DateTime())->getTimestamp());
    $checkTimestamp = 10800; // при проверке промокода скидка активна 3 часа

    $ajaxResponse = [
        'discount' => [],
        'minutesRemaining' => 0,
        'isPromoCodeChecked' => '',
    ];

    if (Loader::includeModule('highloadblock')) {
        $discountHL = 'DemoDiscount';

        if ($hlClass = getHLClassByHLName($discountHL)) {
            if ((!empty($discountCheckCode)) && (Validators::validateString($discountCheckCode))) {
                $rsCheck = $hlClass::getList([
                    'select' => [
                        'UF_DISCOUNT_USER_ID',
                        'UF_DISCOUNT_PERCENTAGE',
                    ],
                    'order' => ['ID' => 'DESC'],
                    'filter' => [
                        '=UF_DISCOUNT_USER_ID' => $userId,
                        '>UF_DISCOUNT_END_TIMESTAMP' => $currentTimestamp - $checkTimestamp,
                        '=UF_DISCOUNT_PROMOCODE' => $discountCheckCode
                    ]
                ]);

                if ($check = $rsCheck->fetch()) {
                    if (!empty($check)) {
                        $ajaxResponse['isPromoCodeChecked'] = 'true';
                        $ajaxResponse['discount'] = [
                            'percentage' => intval($check['UF_DISCOUNT_PERCENTAGE']),
                            'promoCode' => $discountCheckCode
                        ];
                    }
                }
            } else {
                if (Validators::validateInteger($userId)) {
                    $discount = intval(rand(1, 50));
                    $promoCode = substr(md5(rand()), 0, 7);
                    $discountTimestamp = 3600; // через час после получения скидки можно получить новую

                    $rsHlData = $hlClass::getList([
                        "select" => ['*'],
                        'order' => ['ID' => 'DESC'],
                        'filter' => [
                            '=UF_DISCOUNT_USER_ID' => $userId,
                            '>UF_DISCOUNT_END_TIMESTAMP' => $currentTimestamp - $discountTimestamp,
                        ]
                    ]);

                    if ($hlData = $rsHlData->Fetch()) {
                        if (!empty($hlData)) {
                            $tsTimeRemaining = $hlData['UF_DISCOUNT_END_TIMESTAMP'] - $currentTimestamp;
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
                            'UF_DISCOUNT_END_TIMESTAMP' => $currentTimestamp + $discountTimestamp,
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
                } else {
                    throw new \Exception('the "user_id" field didn\'t pass validation');
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
