<?php
namespace AppUser\User\Services;

use AppUser\User\Models\User;

class UserService
{

    public static $user;
    public static function getAuthenticatedUser()
    {
        if (static::$user) {
            return static::$user;
        }
        $token = request()->header('Authorization');
        if ($token != null) {
            static::$user = User::where('token', $token)->first();
            return static::$user;
        }
    }
}