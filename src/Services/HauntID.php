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
     * The token to use for requests.
     * @var string|null
     */
    private ?string $token = null;

    /**
     * Get a game's information.
     *
     * @return \Illuminate\Http\Client\Response
     */
    public function game(): \Illuminate\Http\Client\Response
    {
        $token = $this->getToken();

        return Http::withToken($token)->get("{$this->authUrl}/game");
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

        return Http::withToken($token)->post("{$this->authUrl}/register", $data);
    }

    /**
     * Login to an account.
     *
     * @param array $data
     * @return \Illuminate\Http\Client\Response
     */
    public function login(array $data): \Illuminate\Http\Client\Response
    {
        $token = $this->getToken();

        return Http::withToken($token)->post("{$this->authUrl}/login", $data);
    }

    /**
     * Get the token.
     *
     * @return string|null
     */
    private function getToken(): ?string
    {
        if (!$this->hasToken()) {
            $this->setToken();
        }

        return $this->token;
    }

    /**
     * Check if a token has already been set.
     *
     * @return bool
     */
    private function hasToken(): bool
    {
        return $this->token !== null;
    }

    /**
     * Set the token.
     *
     * @return void
     */
    private function setToken(): void
    {
        $host = request()->getHost();

        $response = Http::get("{$this->authUrl}/token", [
            'host' => $host,
        ]);

        if ($response->ok()) {
            $this->token = $response->body();
        }
    }
}
