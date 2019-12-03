<?php

namespace App\Models\Billing;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Priced extends Model
{
    protected $fillable = [
        'name',
        'type',
        'default',
        'repeat',
        'period',
        'period_type',
        'price',
        'end_date',
        'note',
    ];

    protected $hidden = [
        'created_at', 
        'updated_at'
    ];

    protected $dates = [
        'end_date',
    ];

    const TYPE_FREE = 'free';
    const TYPE_SUBSCRIPTION = 'subscription';

    const PERIOD_TYPE_DAY = 'day';
    const PERIOD_TYPE_WEEK = 'week';
    const PERIOD_TYPE_MONTH = 'month';
    const PERIOD_TYPE_YEAR = 'year';

    public static function getListPeriodType()
    {
        return [
            '' => 'None',
            self::PERIOD_TYPE_DAY => 'Day',
            self::PERIOD_TYPE_WEEK => 'Week',
            self::PERIOD_TYPE_MONTH => 'Month',
            self::PERIOD_TYPE_YEAR => 'Year',
        ];
    }

    public static function getListType()
    {
        return [
            self::TYPE_FREE => 'Free',
            self::TYPE_SUBSCRIPTION => 'Subscription',
        ];
    }

    public function getFormEndDateAttribute()
    {
        return $this->end_date?(new Carbon($this->end_date))->format('d F Y'):null;
    }
}
