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
        $response = Http::acceptJson()
            ->withToken($token)
            ->get("{$this->authUrl}/token");

        if (!$response->ok()) {
            return false;
        }

        $gameData = $response->json();

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
        $token = $this->getToken();

        return Http::acceptJson()
            ->withToken($this->getToken())
            ->post("{$this->authUrl}/register", $data);
    }

    /**
     * Get the token.
     *
     * @return string|null
     */
    private function getToken(): ?string
    {
        return session(HauntID::TOKEN_KEY) ?? env('HAUNT_ACCESS_TOKEN');
    }

    /**
     * Set the token.
     *
     * @param string $token
     * @return void
     */
    private function setToken(string $token): void
    {
        session([HauntID::TOKEN_KEY => $token]);
    }
}
