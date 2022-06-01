<?php

namespace HauntPet\Auth\Middleware;

use Closure;
use Illuminate\Http\Request;
use HauntPet\Auth\Services\GameManager;
use HauntPet\Auth\Exceptions\GameNotFoundException;

class IdentifyGame
{
    /**
     * The game manager instance.
     * @var \App\Services\GameManager
     */
    protected GameManager $gameManager;

    /**
     * Create a new middleware instance.
     *
     * @param \App\Services\GameManager $gameManager
     * @return void
     */
    public function __construct(GameManager $gameManager)
    {
        $this->gameManager = $gameManager;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request  $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$this->gameManager->hasGame()) {
            $this->gameManager->setGame();
        }

        $game = $this->gameManager->getGame();

        if (!$game) {
            throw new GameNotFoundException();
        }

        return $next($request);
    }
}
