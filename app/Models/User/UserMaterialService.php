<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserMaterialService extends Model
{
    protected $fillable = [
        'user_id',
        'material_service_id',
    ];
}
