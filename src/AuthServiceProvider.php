<?php

namespace HauntPet\Auth;

use HauntPet\Auth\Services\HauntID;
use HauntPet\Auth\Services\HauntIDDecoration;
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
        $this->app->bind('haunt-id', function () use ($hauntID) {
            return $hauntID;
        });

        $hauntIDDecoration = new HauntIDDecoration;
        $this->app->instance(HauntIDDecoration::class, $hauntIDDecoration);
        $this->app->bind('haunt-id-decoration', function () use ($hauntIDDecoration) {
            return $hauntIDDecoration;
        });

        $this->mergeConfigFrom(__DIR__.'/../config/haunt-auth.php', 'haunt-auth');
    }
}
