<?php

namespace App\Providers;

use App\Services\QuestionService;
use Illuminate\Support\ServiceProvider;
use App\Classes\Contracts\Services\QuestionService as RegistrationServiceContract;

class QuestionServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(RegistrationServiceContract::class, QuestionService::class);
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
