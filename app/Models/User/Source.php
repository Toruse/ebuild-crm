<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    protected $fillable = [
        'name',
    ];

    protected $hidden = [
        'created_at', 
        'updated_at'
    ];
}
