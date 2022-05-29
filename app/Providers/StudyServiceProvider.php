<?php

namespace App\Providers;

use App\Services\StudyService;
use Illuminate\Support\ServiceProvider;
use App\Classes\Contracts\Services\StudyService as StudyServiceContract;

class StudyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(StudyServiceContract::class, StudyService::class);
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
