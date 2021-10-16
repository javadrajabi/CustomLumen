<?php

namespace App\Libraries\Sanitizer\Filters;

use App\Libraries\Sanitizer\Contracts\Filter;

class Lowercase implements Filter
{
    /**
     *  Lowercase the given string.
     *
     *  @param  string  $value
     *  @return string
     */
    public function apply($value, $options = [])
    {
        return is_string($value) ? mb_strtolower($value, 'UTF-8') : $value;
    }
}
