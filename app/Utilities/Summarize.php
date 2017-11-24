<?php

namespace App\Utilities;

class Summarize
{
    public static function summary($string)
    {

        return substr($string, 0, 20) . '...';

    }

    public static function summaryWithoutTags($string)
    {

        $string = str_replace('<p>', '', $string );

        $string = str_replace('</p>', '', $string );

        return substr($string, 0, 80) . '...';

    }

    public static function longSummary($string)
    {

        return substr($string, 0, 140) . '...';

    }

    public static function componentSummary($string)
    {

        return substr($string, 0, 145);

    }


}

