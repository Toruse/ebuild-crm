<?php

namespace App\Models\Project;

use Carbon\Carbon;
use App\Events\TaskDeleted;
use App\Events\NameTaskUpdated;
use App\Models\Traits\TableName;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use TableName;

    protected $fillable = [
        'project_id',
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
        'deleted' => TaskDeleted::class,
        'updating' => NameTaskUpdated::class,
    ];

    public function type()
    {
        return $this->belongsTo('\App\Models\Project\TaskType', 'task_type_id');
    }

    public function bindUsers()
    {
        return $this->belongsToMany('App\Models\User\User', 'task_users');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Project\TaskComment');
    }

    public function project()
    {
        return $this->belongsTo('App\Models\Project\Project');
    }

    public function getEndDateCalendarAttribute() {
        return (new Carbon($this->end_date))->addDays(1)->format('Y-m-d');
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
