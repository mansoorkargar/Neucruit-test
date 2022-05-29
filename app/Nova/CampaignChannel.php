<?php

namespace App\Nova;

use App\Models\Channel;
use Laravel\Nova\Resource;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsTo;
use Benjaminhirsch\NovaSlugField\Slug;
use Benjaminhirsch\NovaSlugField\TextWithSlug;

class CampaignChannel extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Channel::class;

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

            BelongsTo::make(__('global.study'), 'study')->rules('required'),

            Text::make(__('global.company'), function() {
                $companies = [];
                foreach ($this->study->users as $admin) {
                    $companies[] = $admin->company;
                }

                return implode(', ', array_unique($companies));
            }),

            TextWithSlug::make(__('global.name'), 'name')
                ->rules('required')
                ->sortable()
                ->slug('slug'),

            Slug::make(__('global.slug'), 'slug')
                ->rules('required')
                ->sortable()
                ->hideFromIndex(),

            Text::make(__('global.type'), 'type')
                ->rules('required')
                ->sortable(),

            Date::make(__('global.start_date'), 'starts_at')
                ->rules('required', 'date', 'date_format:Y-m-d'),

            Date::make(__('global.end_date'), 'ends_at')
                ->rules('required', 'date', 'date_format:Y-m-d', 'after:starts_at'),
        ];
    }

    public function filters(Request $request)
    {
        return [];
    }

    public static function label()
    {
        return __('global.campaign_channels');
    }

    public function lenses(Request $request)
    {
        return [];
    }

    public static function singularLabel()
    {
        return __('global.campaign_channel');
    }
}
