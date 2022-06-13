<?php

namespace HauntPet\Auth\Services;

use Illuminate\Support\Facades\Http;

class HauntID
{
    /**
     * The url to authenticate against.
     * @var string
     */
    private string $authUrl = 'http://haunt.test/api';

    /**
     * The session key to use.
     * @var string
     */
    private string $tokenKey = 'gameToken';

    public function check(string $token): \Illuminate\Http\Client\Response
    {
        return Http::acceptJson()->withToken($token)->get("{$this->authUrl}/token");
    }

    /**
     * Get a game's information.
     *
     * @return \Illuminate\Http\Client\Response
     */
    public function game(): \Illuminate\Http\Client\Response
    {
        $token = $this->getToken();

        return Http::acceptJson()
            ->withToken($this->getToken())
            ->get("{$this->authUrl}/game");
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
     * Get the token.
     *
     * @return string|null
     */
    private function getToken(): ?string
    {
        return env('HAUNT_ACCESS_TOKEN') ?? null;
    }
}
