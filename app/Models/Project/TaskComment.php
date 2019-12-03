<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;

class TaskComment extends Model
{
    protected $fillable = [
        'task_id',
        'user_id',
        'comment',
    ];
}
