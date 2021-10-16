<?php

namespace App\Libraries\Sanitizer\Filters;

use App\Libraries\Sanitizer\Contracts\Filter;

class PersianToLatin implements Filter
{
    /**
     *  Trims the given string.
     *
     *  @param  string  $value
     *  @return string
     */
    public function apply($value, $options = [])
    {


        return is_string($value) ? \App\Libraries\Numbers::persianToLatin($value) : $value;
    }
}
