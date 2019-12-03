<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;
use App\Events\NameScheduleTaskUpdating;
use Carbon\Carbon;

class ScheduleTask extends Model
{
    protected $fillable = [
        'schedule_id',
        'color',
        'start_date',
        'end_date',
        'note',
        'task_type_id',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'updating' => NameScheduleTaskUpdating::class,
        'creating' => NameScheduleTaskUpdating::class,
    ];

    public function type()
    {
        return $this->belongsTo('\App\Models\Project\TaskType', 'task_type_id');
    }

    public function schedule()
    {
        return $this->belongsTo('\App\Models\Project\Schedule');
    }

    public function bindUsers()
    {
        return $this->belongsToMany('App\Models\User\User', 'schedule_task_users', 'task_id', 'user_id');
    }

    public function getNameTypeAttribute() {
        if ($this->name) {
            return $this->name;
        }

        if ($this->type) {
            $this->name = $this->type->name;
            $this->save();
            return $this->name;
        }

        return '';
    }

    public function getEndDateCalendarAttribute() {
        return (new Carbon($this->end_date))->addDays(1)->format('Y-m-d');
    }

    public function setUserStartDateAttribute($value)
    {
        $this->attributes['start_date'] = (new Carbon($value))->format('Y-m-d');
    }

    public function setUserEndDateAttribute($value)
    {
        $this->attributes['end_date'] = (new Carbon($value))->format('Y-m-d');
    }

    public function getUserStartDateAttribute()
    {
        return (new Carbon($this->start_date))->format('d F Y');
    }

    public function getUserEndDateAttribute()
    {
        return (new Carbon($this->end_date))->format('d F Y');
    }
}
