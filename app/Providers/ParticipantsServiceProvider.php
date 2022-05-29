<?php

namespace App\Providers;

use App\Services\ParticipantsService;
use Illuminate\Support\ServiceProvider;
use App\Classes\Contracts\Services\ParticipantsService as ParticipantsServiceContract;

class ParticipantsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ParticipantsServiceContract::class, ParticipantsService::class);
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
