<?php

namespace App\Providers;

use App\Services\StudyUserService;
use Illuminate\Support\ServiceProvider;
use App\Classes\Contracts\Services\StudyUserService as StudyUserServiceContract;

class StudyUserServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(StudyUserServiceContract::class, StudyUserService::class);
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
