<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Textarea;
use App\Enums\SignUpQuestionTypeEnum;
use App\Nova\Filters\SignUpQuestionType;
use App\Models\SignUpQuestion as SignUpQuestionModel;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;

class SignUpQuestion extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = SignUpQuestionModel::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';


    public $type;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param Request $request Request body
     *
     * @return array
     */
    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make(__('global.question'), 'question')
                ->rules('required'),

            Select::make(__('global.type'), 'type_id')
                  ->options(SignUpQuestionTypeEnum::keyValueArray())
                  ->displayUsingLabels()
                  ->rules('required'),

            Boolean::make(__('global.is_required'), 'is_required'),

            NovaDependencyContainer::make([
                Textarea::make(__('global.options'), 'options')->rules('required')
            ])
            ->dependsOn('type_id', SignUpQuestionTypeEnum::DROPDOWN)
            ->dependsOn('type_id', SignUpQuestionTypeEnum::CHECKBOX)
            ->dependsOn('type_id', SignUpQuestionTypeEnum::RADIOBUTTON),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param Request $request Request body
     *
     * @return array
     */
    public function cards(Request $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param Request $request Request body
     *
     * @return array
     */
    public function filters(Request $request): array
    {
        return [new SignUpQuestionType];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param Request $request Request body
     *
     * @return array
     */
    public function lenses(Request $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param Request $request Request body
     *
     * @return array
     */
    public function actions(Request $request): array
    {
        return [];
    }
}
