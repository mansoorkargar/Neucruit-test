<?php

namespace App\Nova;

use App\Enums\RoleEnum;
use Laravel\Nova\Panel;
use Laravel\Nova\Fields\ID;
use Dnwjn\NovaButton\Button;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use App\Models\SignUpQuestion;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use App\Nova\Filters\RoleFilter;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\BelongsToMany;

class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\User::class;

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
        'id', 'name', 'last_name', 'email',
    ];

    /**
     * @param array $answers
     * @return array
     */
    protected function getAnswersQuestions(array $answers): array
    {
        $answerFields = [];
        foreach ($answers as $key => $answer) {
            $answerFields[] = Text::make($answer['question'])->hideFromIndex()->readonly()->default($answer['answer']);
        }

        return $answerFields;
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Select::make(__('global.role'), 'role_id')->options(RoleEnum::keyValueArray())->sortable()
                  ->displayUsing(function ($id) { return RoleEnum::getById($id)['name'] ?? '–'; }),

            Text::make(__('global.name'), 'name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make(__('global.last_name'), 'last_name')
                ->sortable()
                ->rules('required', 'max:255'),

            Number::make(__('global.phone_number')),

            Text::make(__('global.company'), 'company')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make(__('global.study'), function() {
                return $this->studies->pluck('name')->join(', ');
            }),

            Text::make(__('global.email'), 'email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Boolean::make(__('global.user_would_like_to_receive_aadditional_information_from_neucruit'), 'checked')
                  ->hideFromIndex()
                  ->readonly()
                  ->hideFromDetail($this->resource->role_id == RoleEnum::SUPERUSER),

            Button::make(__('global.reset_password'), 'reset_password')->confirm(__('global.are_you_sure_you_want_to_reset_a_password'))
                  ->loadingText('Sending...')
                  ->successText('Sent!')
                  ->errorText('Something went wrong...')
                  ->event('App\Events\ResetPasswordRequest')
                  ->hideFromIndex(),

            new Panel('Questions and Answers', $this->getAnswersQuestions($this->resource->answers->toArray())),

            BelongsToMany::make('Studies')->searchable()
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
        return [
            new RoleFilter
        ];
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
