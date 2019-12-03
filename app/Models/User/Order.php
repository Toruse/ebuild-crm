<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'user_orders';

    const STATUS_OPEN = 'open';
    const STATUS_SOLD = 'sold';
    const STATUS_LOST = 'lost';
    const STATUS_COMPLETE = 'complete';
    const STATUS_NO_OPPORTUNITY = 'no_opportunity';

    protected $fillable = [
        'user_id',
        'project_type_id',
        'project_manager_id',
        'status',
        'active',
    ];

    public static function getStatuses()
    {
        return [
            self::STATUS_OPEN => 'Open',
            self::STATUS_SOLD => 'Sold',
            self::STATUS_LOST => 'Lost',
            self::STATUS_COMPLETE => 'Complete',
            self::STATUS_NO_OPPORTUNITY => 'No Opportunity',
        ];
    }

    public function projectManager() {
        return $this->belongsTo('\App\Models\User\User');
    }

    public function projectType() {
        return $this->belongsTo('\App\Models\Project\Type');
    }

    public static function getLabelStatus($name)
    {
        return self::getStatuses()[$name];
    }

    public static function getListActive()
    {
        return [
            1 => 'Active',
            0 => 'Inactive',
        ];
    }

    public static function getLabelActive($index)
    {
        return self::getListActive()[$index];
    }
}
