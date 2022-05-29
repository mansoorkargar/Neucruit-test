<?php

namespace App\Providers;

use App\Services\StudyCommunicationService;
use Illuminate\Support\ServiceProvider;
use App\Classes\Contracts\Services\StudyCommunicationService as StudyCommunicationServiceContract;

class StudyCommunicationServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(StudyCommunicationServiceContract::class, StudyCommunicationService::class);
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
