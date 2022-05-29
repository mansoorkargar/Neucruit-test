<?php

declare (strict_types = 1);

namespace App\Providers;

use App\Repositories\RepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register RepositoryInterface services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(RepositoryInterface::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
