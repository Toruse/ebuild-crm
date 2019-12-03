<?php

namespace App\Models\Project;

use Carbon\Carbon;
use App\Models\Traits\TableName;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use TableName;

    protected $fillable = [
        'customer_id',
        'price',
        'project_type_id',
        'street_address1',
        'street_address2',
        'city',
        'state',
        'postal_code',
        'project_manager_id',
        'color',
        'start_date',
        'end_date',
    ];

    protected $hidden = [
        'created_at', 
        'updated_at'
    ];

    protected $dates = [
        'start_date',
        'end_date',
    ];

    public function customer()
    {
        return $this->belongsTo('\App\Models\User\User');
    }

    public function projectManager()
    {
        return $this->belongsTo('\App\Models\User\User');
    }

    public function tasks()
    {
        return $this->hasMany('\App\Models\Project\Task');
    }

    public function getProfileCustomer() {
        if (($customer = $this->customer)) {
            return $customer->profile;
        }
        return null;
    }

    public function getCustomerFullNameAttribute() {
        $customer = $this->getProfileCustomer();
        if ($customer) {
            return $customer->firstname.' '.$customer->lastname;
        }
        return '';
    }

    public function projectType()
    {
        return $this->belongsTo('\App\Models\Project\Type');
    }

    public function getTypeNameAttribute() {
        $type = $this->projectType;
        if ($type) {
            return $type->name;
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
