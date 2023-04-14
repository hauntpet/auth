<?php

namespace HauntPet\Auth\Http\Middleware;

use Closure;
use HauntPet\Auth\Facades\HauntID;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetHauntState
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        HauntID::setState();

        return $next($request);
    }
}
