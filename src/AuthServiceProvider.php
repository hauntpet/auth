<?php

namespace HauntPet\Auth;

use Illuminate\Routing\Router;
use HauntPet\Auth\Services\HauntID;
use Illuminate\Support\ServiceProvider;
use HauntPet\Auth\Middleware\ManageGame;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $hauntID = new HauntID;
        $this->app->instance(HauntID::class, $hauntID);
        $this->app->bind('haunt-id', function ($app) use ($hauntID) {
            return $hauntID;
        });
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
