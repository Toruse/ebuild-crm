<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserPriced extends Model
{
    protected $fillable = [
        'user_id',
        'priced_id',
        'end_date',
        'is_notify',
    ];

    public function priced()
    {
        return $this->belongsTo('\App\Models\Billing\Priced');
    }
}
