<?php

namespace App\Nova\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;
use App\Enums\SignUpQuestionTypeEnum;
use Illuminate\Database\Eloquent\Builder;

class SignUpQuestionType extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * Apply the filter to the given query.
     *
     * @param Request $request
     * @param Builder $query
     * @param mixed   $value
     *
     * @return Builder
     */
    public function apply(Request $request, $query, mixed $value)
    {
        return $query->where('type_id', $value);
    }

    /**
     * Get the filter's available options.
     *
     * @param Request  $request
     *
     * @return array
     */
    public function options(Request $request)
    {
        return array_flip(SignUpQuestionTypeEnum::keyValueArray());
    }
}