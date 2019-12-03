<?php

namespace App\Repositories\User;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoggingRepository
{
    public function insertInfoLogging(Request $request, $user) {
        $data = [
            'session_id' => Session::getId(),
            'login_server_time' => Carbon::now(),
        ];
        if (isset($request['user_time'])) {
            $data['login_user_time'] = $request['user_time'];
        }
        if (isset($request['latitude'])) {
            $data['latitude'] = $request['latitude'];
        }
        if (isset($request['longitude'])) {
            $data['longitude'] = $request['longitude'];
        }
        return $user->logging()->create($data);
    }

    public function updateInfoLogging(Request $request, $logging) {
        $logging->logout_server_time = Carbon::now();
        if (isset($request['user_time'])) {
            $logging->logout_user_time = $request['user_time'];
        }
        
        return $logging->save();
    }
}