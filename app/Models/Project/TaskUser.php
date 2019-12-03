<?php

namespace App\Models\Project;

use App\Models\Traits\TableName;
use Illuminate\Database\Eloquent\Model;

class TaskUser extends Model
{
    use TableName;

    public $timestamps = false;

    protected $fillable = [
        'task_id',
        'user_id',
    ];
}
