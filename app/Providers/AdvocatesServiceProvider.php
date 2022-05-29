<?php

namespace App\Providers;

use App\Services\AdvocatesService;
use Illuminate\Support\ServiceProvider;
use App\Classes\Contracts\Services\AdvocatesService as AdvocatesServiceContract;

class AdvocatesServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AdvocatesServiceContract::class, AdvocatesService::class);
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
