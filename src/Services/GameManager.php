<?php

namespace HauntPet\Auth\Services;

use HauntPet\Auth\Facades\HauntID;

class GameManager
{
    /**
     * The session key to use.
     * @var string
     */
    private string $gameKey = 'game';

    public function getGame(): ?array
    {
        if ($this->hasGame()) {
            return session($this->gameKey);
        }

        return $this->setGame();
    }

    public function hasGame(): bool
    {
        return session()->has($this->gameKey);
    }

    public function setGame(): ?array
    {
        $response = HauntID::game();

        if ($response->ok()) {
            session([$this->gameKey => $response->json()]);
            return $response->json();
        }

        return null;
    }
}
