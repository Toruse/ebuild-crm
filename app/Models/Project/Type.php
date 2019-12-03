<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'project_types';

    protected $fillable = [
        'name',
    ];

    protected $hidden = [
        'created_at', 
        'updated_at'
    ];
}
