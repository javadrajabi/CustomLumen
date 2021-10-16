<?php

namespace App\Libraries\FilterQueryString\Filters\ComparisonClauses;

use Illuminate\Database\Eloquent\Builder;
use App\Libraries\FilterQueryString\Filters\BaseClause;

abstract class BaseComparison extends BaseClause
{
    protected $isDateTime = false;
    protected $method;
    protected $normalized = [];

    public function apply($query): Builder
    {
        $this->normalizeValues($this->values);

        foreach ($this->normalized as $field => $value) {
            $query->{$this->determineMethod($value)}($field, $this->operator, $value);
        }

        return $query;
    }

    public function validate($value): bool
    {
        if(is_null($value)) {
            return false;
        }
//        echo __DIR__.'helper.php';exit;
        include(__DIR__.'/../../helper.php');

        if (!hasComma($value)) {
            return false;
        }

        return true;
    }

    protected function determineMethod($value)
    {
        include(__DIR__.'/../../helper.php');
        return isDateTime($value) ? 'whereDate' : 'where';
    }

    protected function normalizeValues($values)
    {
        include(__DIR__.'/../../helper.php');
        [$field, $val] = separateCommaValues($values);
        $this->normalized[$field] = $val;
    }
}
