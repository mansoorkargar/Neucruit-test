<?php

namespace App\Providers;

use App\Services\MakeDesignService;
use Illuminate\Support\ServiceProvider;
use App\Classes\Contracts\Services\MakeDesignService as MakeDesignServiceContract;

class MakeDesignServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MakeDesignServiceContract::class, MakeDesignService::class);
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
