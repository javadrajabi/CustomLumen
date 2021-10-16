<?php

namespace App\Libraries\FilterQueryString;

use Illuminate\Pipeline\Pipeline;
use App\Libraries\FilterQueryString\Filters\{OrderbyClause, WhereClause, WhereInClause, WhereLikeClause};
use App\Libraries\FilterQueryString\Filters\ComparisonClauses\{GreaterOrEqualTo, GreaterThan, LessOrEqualTo, LessThan};
use App\Libraries\FilterQueryString\Filters\ComparisonClauses\Between\{Between, NotBetween};

trait FilterQueryString {

    use Resolvings;

    private $availableFilters = [
        'default' => WhereClause::class,
        'sort' => OrderbyClause::class,
        'greater' => GreaterThan::class,
        'greater_or_equal' => GreaterOrEqualTo::class,
        'less' => LessThan::class,
        'less_or_equal' => LessOrEqualTo::class,
        'between' => Between::class,
        'not_between' => NotBetween::class,
        'in' => WhereInClause::class,
        'like' => WhereLikeClause::class,
    ];

    public function scopeFilter($query, ...$filters)
    {
        $filters = collect($this->getFilters($filters))->map(function ($values, $filter) {
            return $this->resolve($filter, $values);
        })->toArray();

        return app(Pipeline::class)
            ->send($query)
            ->through($filters)
            ->thenReturn();
    }

    private function getFilters($filters)
    {
        $filter = function ($key) use($filters) {

            $filters = $filters ?: $this->filters ?: [];

            return $this->unguardFilters != true ? in_array($key, $filters) : true;
        };

        return array_filter(request()->query(), $filter, ARRAY_FILTER_USE_KEY) ?? [];
    }
}
