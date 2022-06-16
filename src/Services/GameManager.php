<?php

namespace HauntPet\Auth\Services;

use HauntPet\Auth\Facades\HauntID;

class GameManager
{
    const GAME_KEY = 'gameData';

    public static function getGame(): ?array
    {
        return cache()->get(GameManager::GAME_KEY);
    }

    public static function hasGame(): bool
    {
        return cache()->has(GameManager::GAME_KEY);
    }

    public static function setGameConfig(): void
    {
        $data = GameManager::getGame();
        $defaultConnection = config('database.default');
        config(["database.connections.${defaultConnection}.database" => $data['db_name']]);
        config(["database.connections.${defaultConnection}.username" => $data['db_username']]);
        config(["database.connections.${defaultConnection}.password" => $data['db_password']]);
    }

    public static function setGame($data): void
    {
        cache()->put(GameManager::GAME_KEY, $data);
    }
}
