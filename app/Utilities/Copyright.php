<?php

namespace App\Utilities;

class Copyright
{

    public static function displayNotice()
    {

        $date = date('Y') > 2017 ? date ('Y') : 2017;


        return '&copy ' . $date . '&nbsp; Crowd Pointer &nbsp; All rights Reserved.';


    }

}