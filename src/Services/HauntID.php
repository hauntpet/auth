<?php

namespace HauntPet\Auth\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class HauntID
{
    /**
     * The url for the haunt api.
     *
     * @var string
     */
    private string $appUrl = 'https://haunt.pet';

    /**
     * The key to use for the "state" in the cache.
     *
     * @var string
     */
    private string $cacheState = 'state';

    /**
     * The key to use for the "user" in the session.
     *
     * @var string
     */
    private string $sessionUser = 'user';

    /**
     * The cached user instance.
     *
     * @var \Laravel\Socialite\Two\User|null
     */
    protected $user;

    /**
     * Redirect to the haunt application to authenticate.
     *
     * @return
     */
    public function redirect()
    {
        request()->session()->put($this->cacheState, $state = Str::random(40));

        $query = http_build_query([
            'client_id' => config('haunt-auth.client_id'),
            'redirect_uri' => config('haunt-auth.redirect'),
            'response_type' => 'code',
            'scope' => '',
            'state' => $state,
        ]);

        return redirect()->away("{$this->appUrl}/api/authorize?{$query}");
    }

    /**
     * Fetch the authorized user from Haunt.
     *
     * @return array
     */
    public function user(): array
    {
        if ($this->hasUser()) {
            return $this->getUser();
        }

        $this->checkState();

        $token = $this->getAccessToken($this->getCode());

        $this->setUser($this->getUserByToken($token));

        return $this->getUser();
    }

    /**
     * Check if a user exists in the session.
     *
     * @return bool
     */
    private function hasUser(): bool
    {
        return request()->session()->has($this->sessionUser);
    }

    /**
     * Attempt to get the user from the session.
     *
     * @return null|array
     */
    private function getUser(): array
    {
        return request()->session()->get($this->sessionUser);
    }

    /**
     * Set the user in the session.
     *
     * @return array
     */
    private function setUser(array $user): array
    {
        request()->session()->put($this->sessionUser, $user);

        return $user;
    }

    /**
     * Check the state in the session is correct
     * for the request.
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    private function checkState(): void
    {
        $state = request()->session()->pull($this->cacheState);

        throw_unless(
            strlen($state) > 0 && $state === request()->state,
            \InvalidArgumentException::class,
            'Invalid state value.'
        );
    }

    /**
     * Get the code from the request.
     *
     * @return null|string
     */
    private function getCode(): null|string
    {
        return request()->code ?? null;
    }

    /**
     * Get an access token for the user.
     *
     * @param  string  $code
     * @param  string  $tokenName
     * @return string
     */
    private function getAccessToken(string $code, string $tokenName = 'access_token'): string
    {
        $response = Http::asForm()->post("{$this->appUrl}/api/token", [
            'grant_type' => 'authorization_code',
            'client_id' => config('haunt-auth.client_id'),
            'client_secret' => config('haunt-auth.client_secret'),
            'redirect_uri' => config('haunt-auth.redirect'),
            'code' => $code,
        ])->json();

        return $response[$tokenName];
    }

    /**
     * Get the authenticated user from Haunt by
     * their Bearer token.
     *
     * @param  string  $token
     * @return array
     */
    private function getUserByToken(string $token): array
    {
        return Http::withHeaders([
            'Authorization' => "Bearer {$token}",
        ])
            ->get("{$this->appUrl}/api/user")->json();
    }
}
