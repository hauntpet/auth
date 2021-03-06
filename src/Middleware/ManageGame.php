<?php

namespace HauntPet\Auth\Middleware;

use Closure;
use Illuminate\Http\Request;
use HauntPet\Auth\Facades\HauntID;
use HauntPet\Auth\Services\GameManager;
use HauntPet\Auth\Exceptions\GameNotFoundException;

class ManageGame
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request  $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!GameManager::hasGame()) {
            HauntID::check(env('HAUNT_ACCESS_TOKEN') ?? '');
        }

        if ($game = GameManager::getGame()) {
            GameManager::setGameConfig();
        }

        return $next($request);
    }
}
