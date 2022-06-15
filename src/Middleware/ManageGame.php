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
        // if game doesn't exist, attempt to set it
        if (!GameManager::hasGame()) {
            $this->setGame();
        }

        if ($game = GameManager::getGame()) {
            GameManager::setGameConfig();
        }

        return $next($request);
    }

    /**
     * Set the game.
     *
     * @return mixed
     */
    protected function setGame()
    {
        HauntID::check(env('HAUNT_ACCESS_TOKEN') ?? '');
    }
}
