<?php

namespace App\Models\User;

use App\Models\Traits\TableName;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use TableName;

    protected $table = 'user_profiles';

    protected $fillable = [
        'user_id',
        'firstname',
        'lastname',
        'email',
        'street_address1',
        'street_address2',
        'city',
        'state',
        'postal_code',
        'source_id',
        'skill_specialty_id',
        'company',
        'website',
        'fax_number',
        'note',
    ];

    public function source()
    {
        return $this->belongsTo('\App\Models\User\Source');
    }
}
