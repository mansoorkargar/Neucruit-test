<?php

namespace App\Providers;

use App\Services\RegisterService;
use Illuminate\Support\ServiceProvider;
use App\Classes\Contracts\Services\RegisterService as RegistrationServiceContract;

class RegisterServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(RegistrationServiceContract::class, RegisterService::class);
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
