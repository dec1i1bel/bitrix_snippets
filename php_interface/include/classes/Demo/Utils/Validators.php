<?php

namespace Demo\Utils;

class Validators
{
    /**
     * Проверка типа
     *
     * @param $var
     * @param string $type - доступны: 'integer'
     * @return bool
     */
    public static function validateInteger($var): bool
    {
        return (intval($var) > 0);
    }

    /**
     * @param string $string
     * @return bool
     */
    public static function validateString(string $string): bool
    {
        // toDo: сделать валидацию строки
        return true;
    }
}