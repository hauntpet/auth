<?php

namespace HauntPet\Auth\Middleware;

use Closure;
use Illuminate\Http\Request;
use HauntPet\Auth\Services\GameManager;
use HauntPet\Auth\Exceptions\GameNotFoundException;

class HasGame
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
        $game = GameManager::getGame();

        if (!$game) {
            return $this->fail();
        }

        GameManager::setGameConfig();

        return $next($request);
    }

    /**
     * The request has failed.
     *
     * @throws \HauntPet\Auth\Exceptions\GameNotFoundException
     */
    protected function fail()
    {
        throw new GameNotFoundException();
    }
}
