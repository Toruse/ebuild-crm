<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;

class TaskType extends Model
{
    protected $fillable = [
        'name',
    ];

    protected $hidden = [
        'created_at', 
        'updated_at'
    ];
}
