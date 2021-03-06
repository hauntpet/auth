<?php

namespace HauntPet\Auth\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class HauntID
{
    const TOKEN_KEY = 'accessToken';

    /**
     * The url to authenticate against.
     * @var string
     */
    private string $authUrl = 'http://haunt.test/api';

    /**
     * Check an access token.
     * If it works, set the game in the game manager.
     *
     * @param string $token
     * @return bool
     */
    public function check(string $token): bool
    {
        // attempt to fetch the game
        $response = Http::acceptJson()
            ->withToken($token)
            ->get("{$this->authUrl}/game");

        if (!$response->ok()) {
            return false;
        }

        $gameData = $response->json();

        // check the current website is for this game
        if (!Str::contains(request()->root(), $gameData['url'])) {
            return false;
        }

        $this->setToken($token);
        GameManager::setGame($gameData);
        return true;
    }

    /**
     * Login to an account.
     *
     * @param array $data
     * @return \Illuminate\Http\Client\Response
     */
    public function login(array $data): \Illuminate\Http\Client\Response
    {
        return Http::acceptJson()
            ->withToken($this->getToken())
            ->post("{$this->authUrl}/login", $data);
    }

    /**
     * Create an account.
     *
     * @param array $data
     * @return \Illuminate\Http\Client\Response
     */
    public function register(array $data = []): \Illuminate\Http\Client\Response
    {
        return Http::acceptJson()
            ->withToken($this->getToken())
            ->post("{$this->authUrl}/register", $data);
    }

    /**
     * Get the token.
     *
     * @return string|null
     */
    public function getToken(): ?string
    {
        return cache()->get(HauntID::TOKEN_KEY);
    }

    /**
     * Set the token.
     *
     * @param string $token
     * @return void
     */
    public function setToken(string $token): void
    {
        cache()->put(HauntID::TOKEN_KEY, $token);
    }
}
