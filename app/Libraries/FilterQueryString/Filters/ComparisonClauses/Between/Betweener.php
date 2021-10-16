<?php

namespace App\Libraries\FilterQueryString\Filters\ComparisonClauses\Between;

use Illuminate\Database\Eloquent\Builder;

trait Betweener
{
    public function apply($query): Builder
    {
        $this->normalizeValues($this->values);

        foreach($this->normalized as $field => $values) {
            $query->{$this->method}($field, $values);
        }

        return $query;
    }

    public function validate($value): bool
    {
        include(__DIR__.'/../../../helper.php');
        if (count(separateCommaValues($value)) != 3) {
            return false;
        }

        return true;
    }

    protected function normalizeValues($values)
    {
        include(__DIR__.'/../../../helper.php');
        [$field, $val1, $val2] = separateCommaValues($values);
        $this->normalized[$field] = [$val1, $val2];
    }
}
