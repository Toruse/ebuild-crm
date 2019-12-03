<?php

namespace App\Models\User;

use App\Models\Traits\TableName;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use TableName;

    protected $fillable = [
        'user_id',
        'role_id',
    ];

    public function role()
    {
        return $this->belongsTo('\App\Models\User\Role');
    }
}
