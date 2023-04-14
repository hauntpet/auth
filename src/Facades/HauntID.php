<?php

namespace HauntPet\Auth\Facades;

use Illuminate\Support\Facades\Facade;

class HauntID extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'haunt-id';
    }
}
