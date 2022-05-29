<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\StudyInvitationService;
use App\Classes\Contracts\Services\StudyInvitationService as StudyInvitaitonServiceContract;

class StudyInvitationServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(StudyInvitaitonServiceContract::class, StudyInvitationService::class);
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
