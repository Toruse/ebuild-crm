<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Logging extends Model
{
    protected $table = 'user_loggings';

    protected $fillable = [
        'id',
        'user_id', 
        'session_id', 
        'latitude', 
        'longitude',
        'login_user_time',
        'logout_user_time',
        'login_server_time',
        'logout_server_time',
        'data',
    ];
}
