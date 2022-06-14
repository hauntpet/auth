<?php

namespace HauntPet\Auth\Services;

use HauntPet\Auth\Facades\HauntID;

class GameManager
{
    const GAME_KEY = 'gameData';

    public static function getGame(): ?array
    {
        return session(GameManager::GAME_KEY);
    }

    public static function setGameConfig(): void
    {
        $data = GameManager::getGame();
        config(['database.connections.mysql.database' => $data['db_name']]);
        config(['database.connections.mysql.username' => $data['db_username']]);
        config(['database.connections.mysql.password' => $data['db_password']]);
    }

    public static function setGame($data): void
    {
        session([GameManager::GAME_KEY => $data]);
    }
}
