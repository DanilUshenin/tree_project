<?php

namespace Components;

class Helper
{
    /**
     * @param array $array
     * @param $key
     * @param null $defaultValue
     * @return mixed|null
     */
    public static function arrayGet(array $array, $key, $defaultValue = null)
    {
        $value = $defaultValue;

        if (array_key_exists($key, $array)) {
            $value = $array[$key];
        }

        return $value;
    }
}