<?php

namespace App\Nova;

use Laravel\Nova\Resource;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\BelongsTo;
use App\Enums\StudyQuestionTypeEnum;
use App\Models\StudyQuestion as StudyQuestionModel;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;

class StudyQuestion extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = StudyQuestionModel::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name'
    ];

    public function actions(Request $request)
    {
        return [];
    }

    public function cards(Request $request)
    {
        return [];
    }

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make(__('global.study'), 'study')->nullable(),

            Text::make(__('global.question'), 'name')
                ->rules('required'),

            Select::make(__('global.type'), 'type')
                  ->options(StudyQuestionTypeEnum::keyValueArray())
                  ->displayUsingLabels()
                  ->rules('required'),

            NovaDependencyContainer::make([
                Textarea::make(__('global.options'), 'options')->rules('required')
            ])
            ->dependsOn('type', StudyQuestionTypeEnum::DROPDOWN)
            ->dependsOn('type', StudyQuestionTypeEnum::CHECKBOX)
            ->dependsOn('type', StudyQuestionTypeEnum::RADIOBUTTON),

            NovaDependencyContainer::make([
                Textarea::make('Ineligible options', 'ineligible_options')->rules('required')
            ])
                ->dependsOn('type', StudyQuestionTypeEnum::DROPDOWN)
                ->dependsOn('type', StudyQuestionTypeEnum::CHECKBOX)
                ->dependsOn('type', StudyQuestionTypeEnum::RADIOBUTTON),

            Boolean::make(__('global.is_required'), 'is_required'),

            Number::make(__('global.position'), 'position')
                  ->rules('required'),
        ];
    }

    public function filters(Request $request)
    {
        return [];
    }

    public static function label()
    {
        return __('global.study_questions');
    }

    public function lenses(Request $request)
    {
        return [];
    }

    public static function singularLabel()
    {
        return __('global.study_question');
    }
}
