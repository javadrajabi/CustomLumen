<?php

namespace App\Libraries\FilterQueryString\Filters\ComparisonClauses\Between;

use App\Libraries\FilterQueryString\Filters\ComparisonClauses\BaseComparison;

class NotBetween extends BaseComparison
{
    use Betweener;

    public $method = 'whereNotBetween';
}
