<?php

namespace Demo\Utils;

class Validators
{
    /**
     * Проверка типа
     *
     * @param $var
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
        return preg_match("/[^a-z\s]/iu", mb_strtolower($string)) !== false;
    }
}