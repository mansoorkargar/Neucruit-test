<?php

namespace App\Providers;

use App\Services\StudyCampaignService;
use Illuminate\Support\ServiceProvider;
use App\Classes\Contracts\Services\StudyCampaignService as StudyCampaignServiceContract;

class StudyCampaignServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(StudyCampaignServiceContract::class, StudyCampaignService::class);
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
