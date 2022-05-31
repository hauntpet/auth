<?php

namespace HauntPet\Auth;

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
     * Create an account.
     *
     * @param array $data
     */
    public function register(array $data = [])
    {
        $token = $this->getToken();

        return Http::withToken($token)->post("{$this->authUrl}/register", $data);
    }

    public function login(string $email, string $password)
    {
        $token = $this->getToken();

        return Http::withToken($token)->post("{$this->authUrl}/login", [
            'email' => $email,
            'password' => $password,
        ]);
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
