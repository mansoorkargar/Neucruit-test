<?php

namespace App\Providers;

use App\Services\StudyParticipantService;
use Illuminate\Support\ServiceProvider;
use App\Classes\Contracts\Services\StudyParticipantService as StudyParticipantServiceContract;

class StudyParticipantServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(StudyParticipantServiceContract::class, StudyParticipantService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
