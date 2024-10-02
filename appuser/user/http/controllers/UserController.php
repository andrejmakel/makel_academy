<?php
namespace AppUser\User\Http\Controllers;

use AppUser\User\Models\User;
use AppUser\User\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|unique:appuser_users',
            'password' => 'required|min:6',
        ]);

        //dd($validatedData);

        $user = User::create([
            'username' => $validatedData['username'],
            'password' => $validatedData['password'],
            'token' => bin2hex(random_bytes(32)),  // Token na autentifikáciu
        ]);

        //dd($user->password);

        return response()->json($user);
    }

    public function login(Request $request)
    {
        $user = User::where('username', $request->input('username'))->first();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $user->token = bin2hex(random_bytes(32));
        $user->save();

        return response()->json(['token' => $user->token]);
    }

    public function logout(Request $request)
    {
        $user = UserService::getAuthenticatedUser();

        if (!$user) {
            return response()->json(['response' => 'user not found']);
        }

        $user->token = null;
        $user->save();
        return response()->json(['response' => 'success']);

    }
}