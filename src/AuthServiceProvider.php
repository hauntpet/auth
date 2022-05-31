<?php

namespace HauntPet\Auth;

use HauntPet\Auth\HauntID;
use Illuminate\Support\ServiceProvider;

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
}
