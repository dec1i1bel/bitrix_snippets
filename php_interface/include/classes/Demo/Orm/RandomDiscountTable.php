<?php

namespace Demo\Orm;

use Bitrix\Main\Entity;
use Bitrix\Main\SystemException;

class RandomDiscountTable extends Entity\DataManager
{
    /**
     * @return string|null
     */
    public static function getTableName()
    {
        return 'd_random_discount';
    }

    /**
     * @return array
     * @throws SystemException
     */
    public static function getMap()
    {
        return [
            new Entity\IntegerField('ID', [
                'primary' => true,
                'autocomplete' => true
            ]),
            new Entity\IntegerField('USER_ID'),
            new Entity\IntegerField('END_TIMESTAMP'),
            new Entity\StringField('PROMOCODE'),
            new Entity\IntegerField('PERCENTAGE'),
        ];
    }
}
