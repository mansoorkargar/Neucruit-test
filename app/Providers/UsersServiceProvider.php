<?php


namespace App\Providers;
use App\Services\UsersService;
use Illuminate\Support\ServiceProvider;
use App\Classes\Contracts\Services\UsersService as UsersServiceContract;

class UsersServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UsersServiceContract::class, UsersService::class);
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
