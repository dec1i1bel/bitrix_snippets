<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Application as App;
use Bitrix\Main\Engine\Response\Json;
use Bitrix\Main\Type\DateTime;
use Demo\Orm\RandomDiscountTable;
use Demo\Utils\Validators;

try {
    $req = App::getInstance()->getContext()->getRequest();

    $userId = $req->getPost('user_orm')['id'];
    $discountCheckCode = $req->getPost('discount_orm')['check'];
    $currentTimestamp = intval((new DateTime())->getTimestamp());
    $checkTimestamp = 10800; // при проверке промокода скидка активна 3 часа

    printr([
        $userId,
        $discountCheckCode,
    ]);

    $ajaxResponse = [
        'discount' => [],
        'minutesRemaining' => 0,
        'isPromoCodeChecked' => '',
    ];

    if ((!empty($discountCheckCode)) && Validators::validateString($discountCheckCode)) {
        $rsCheck = RandomDiscountTable::getList([
            'select' => ['ID', 'PERCENTAGE'],
            'order' => ['ID' => 'DESC'],
            'filter' => [
                '=USER_ID' => $userId,
                '>END_TIMESTAMP' => $currentTimestamp - $checkTimestamp,
                '=PROMOCODE' => $discountCheckCode
            ],
        ]);

        if ($check = $rsCheck->fetch()) {
            if (!empty($check)) {
                $ajaxResponse['isPromoCodeChecked'] = 'true';
                $ajaxResponse['discount']['percentage'] = intval($check['PERCENTAGE']);
            }
        }

    } else {

        if (Validators::validateInteger($userId)) {
            $percentage = intval(rand(1, 50));
            $promoCode = substr(md5(rand()), 0, 7);
            $discountTimestamp = 3600; // через час после получения скидки можно получить новую

            $rsDiscount = RandomDiscountTable::getList([
                'select' => ['*'],
                'order' => ['ID' => 'DESC'],
                'filter' => [
                    '=USER_ID' => $userId,
                    '>END_TIMESTAMP' => $currentTimestamp - $discountTimestamp
                ],
            ]);

            if ($discount = $rsDiscount->fetch()) {
                if (!empty($discount)) {
                    $tsTimeRemaining = $discount['END_TIMESTAMP'] - $currentTimestamp;
                    $minutesRemaining = (DateTime::createFromTimestamp($tsTimeRemaining))->format('i');

                    $ajaxResponse = [
                        'discount' => [
                            'percentage' => $discount['PERCENTAGE'],
                            'promoCode' => $discount['PROMOCODE'],
                        ],
                        'minutesRemaining' => $minutesRemaining
                    ];
                }
            } else {
                $newDiscountId = RandomDiscountTable::add([
                    'END_TIMESTAMP' => $currentTimestamp + $discountTimestamp,
                    'PERCENTAGE' => $percentage,
                    'PROMOCODE' => $promoCode,
                    'USER_ID' => $userId,
                ]);
                if ($newDiscountId) {
                    $ajaxResponse = [
                        'discount' => [
                            'percentage' => $percentage,
                            'promoCode' => $promoCode,
                        ],
                    ];
                } else {
                    throw new \Exception('error: discount was not added');
                }
            }
        } else {
            throw new Exception('the "user_id" field didn\'t pass validation');
        }
    }

    (new Json($ajaxResponse))->send();

} catch (Exception $e) {
    (new Json([
        'ajax_error' => $e->getMessage()
    ]))->send();
}
