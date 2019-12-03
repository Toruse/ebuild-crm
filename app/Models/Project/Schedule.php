<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'title',
        'description',
    ];

    public function tasks()
    {
        return $this->hasMany('\App\Models\Project\ScheduleTask')->orderBy('name');
    }

    public function firstTask()
    {
        return $this->hasOne('\App\Models\Project\ScheduleTask', 'schedule_id')->orderBy('start_date');
    }
}
