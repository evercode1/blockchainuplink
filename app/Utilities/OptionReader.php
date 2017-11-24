<?php

namespace App\Utilities;

class OptionReader
{


    public static function displayValue($attribute, $value)
    {

         return $value = config('select-options.' . $attribute. '.' . $value);


    }

    public static function getOptionKey($attribute, $optionString)
    {

         $options = config('select-options.' . $attribute);

         return $key = array_search($optionString, $options);


    }


}