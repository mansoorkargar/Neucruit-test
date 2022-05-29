<?php

namespace App\Nova;

use App\Enums\GenderEnum;
use Laravel\Nova\Fields\ID;
use App\Enums\StudyTypeEnum;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Text;
use App\Enums\StudyStatusEnum;
use NovaAttachMany\AttachMany;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Password;
use App\Nova\Filters\GenderFilter;
use App\Nova\Filters\StudyTypeFilter;
use App\Models\Study as StudyEloquent;
use Laravel\Nova\Fields\BelongsToMany;
use App\Nova\Filters\StudyStatusFilter;

class Study extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = StudyEloquent::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name'
    ];

    /**
     * The relationship columns that should be searched.
     *
     * @var array
     */
    public static $searchRelations = [
        'users' => ['name', 'last_name', 'company', 'email'],
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
            Text::make(__('global.name'), 'name')->sortable()->rules('required', 'max:255'),

            Text::make(__('global.clients'), function () {
                return $this->getFullTitle();
            }),

            Text::make(__('global.study_question'), 'study_question'),
            Text::make(__('global.description'), 'description'),
            Text::make(__('global.trial_id'), 'trial_id')->required(),
            Select::make(__('global.study_type'), 'study_type_id')->options(StudyTypeEnum::keyValueArray())->sortable()
                  ->displayUsing(function ($id) { return StudyTypeEnum::getById($id)['name'] ?? '–'; }),
            Text::make(__('global.investigating_audience'), 'investigating_audience'),
            Text::make(__('global.study_run_time'), 'study_run_time'),
            Boolean::make(__('global.is_offering_incentives'), 'is_offering_incentives'),
            Text::make(__('global.incentive_description'), 'incentive_description'),
            Text::make(__('global.field'), 'field'),
            Text::make(__('global.location'), 'location'),
            Date::make(__('global.recruitment_start_date'), 'recruitment_starts_at'),
            Date::make(__('global.recruitment_end_date'), 'recruitment_ends_at'),
            Number::make(__('global.participant_min_age'), 'participant_min_age'),
            Number::make(__('global.participant_max_age'), 'participant_max_age'),
            Select::make(__('global.gender'), 'gender_id')->options(GenderEnum::keyValueArray())->sortable()
                  ->displayUsing(function ($id) { return GenderEnum::getById($id)['name'] ?? '–'; }),
            Text::make(__('global.condition'), 'condition'),
            Text::make(__('global.criteria'), 'criteria'),
            Text::make(__('global.approval_number'), 'approval_number'),
            Boolean::make(__('global.consent'), 'consent')->required(),
            Select::make(__('global.study_status'), 'study_status_id')->options(StudyStatusEnum::keyValueArray())->sortable()->required()
                  ->displayUsing(function ($id) { return StudyStatusEnum::getById($id)['name'] ?? '–'; }),
            Text::make(__('global.designated_contact'), 'designated_contact')->required(),
            Number::make(__('global.required_participants'), 'required_participants')->required(),
            Text::make(__('global.link_suffix'), 'link_suffix'),

            HasMany::make(__('global.study_questions')),

            HasMany::make(__('global.communications')),

            BelongsToMany::make('Users')->searchable()->display(function($model){ 
                return $model->name .' ' . $this->last_name . '('.$this->company.')'; 
            })
        ];
    }



    /**
     * Get the value that should be displayed to represent the resource.
     *
     * @return string
     */
    public function name()
    {
        $users = $this->admins->map(function($item) {
            return $item->name . ' ' . $item->last_name . ', ' . $item->company; 
        })->join('; ');

        return $this->name . '(' . $users .  ')';
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
        return [
            new StudyTypeFilter,
            new StudyStatusFilter,
            new GenderFilter
        ];
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