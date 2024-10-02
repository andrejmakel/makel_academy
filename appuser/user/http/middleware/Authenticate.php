<?php
namespace AppUser\User\Http\Middleware;

use Closure;
use AppUser\User\Services\UserService;

class Authenticate
{
    public function handle($request, Closure $next)
    {
        $user = UserService::getAuthenticatedUser();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->merge(['user' => $user]);

        return $next($request);
    }
}