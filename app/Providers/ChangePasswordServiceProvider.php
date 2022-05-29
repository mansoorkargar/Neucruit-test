<?php

namespace App\Providers;

use App\Services\User\ChangePasswordService;
use Illuminate\Support\ServiceProvider;
use App\Classes\Contracts\Services\ChangePasswordService as ChangePasswordServiceContract;

class ChangePasswordServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ChangePasswordServiceContract::class, ChangePasswordService::class);
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
