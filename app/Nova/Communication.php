<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Boolean;
use App\Nova\Filters\StudyFilter;
use Laravel\Nova\Fields\BelongsTo;
use App\Enums\CommunicationTriggerEnum;
use App\Models\Communication as CommunicationEloquent;

class Communication extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = CommunicationEloquent::class;

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
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param Request $request
     *
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            BelongsTo::make(__('global.study'), 'study')->nullable(),

            Text::make(__('global.name'), 'template_name')->sortable(),
            Text::make(__('global.email_subject'), 'email_subject')->sortable(),
            Code::make(__('global.email_html_content'), 'content')->hideFromIndex(),
            Text::make(__('global.design_structure'), 'design_structure')->hideFromIndex(),
            Boolean::make(__('global.opt_in'), 'enabled')->sortable(),
            Select::make(__('global.trigger'), 'communication_trigger_id')->options(CommunicationTriggerEnum::keyValueArray())->sortable()
                   ->displayUsing(function ($id) { return CommunicationTriggerEnum::getById($id)['name'] ?? '–'; }),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [new StudyFilter];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}