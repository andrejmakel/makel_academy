<?php

namespace AppLogger\Logger\Http\Controllers;

use AppLogger\Logger\Models\Log;
use AppUser\User\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LogController
{
    public function create(Request $request)
    {
        $user = UserService::getAuthenticatedUser();

        $log = new Log();
        $log->username = $user->username;
        $log->arrival = Carbon::now();
        if (is_numeric($request->delay)) {
            $log->delay = $request->delay;
        } else {
            return 'Delay is not numeric';
        }
        $log->user_id = $user->id;
        $log->save();
        return response()->json(['message' => 'Log created successfully!', 'log' => $log]);
    }
    public function show(Request $request)
    {
        $user = UserService::getAuthenticatedUser();

        return Log::where('username', $request->user_name)->where('user_id', $user->id)->get();
    }
    public function index(Request $request)
    {
        $user = UserService::getAuthenticatedUser();

        return Log::where('user_id', $user->id)->get();
    }
}