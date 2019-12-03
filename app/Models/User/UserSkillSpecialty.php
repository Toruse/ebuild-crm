<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserSkillSpecialty extends Model
{
    protected $table = 'user_skill_specialtys';

    protected $fillable = [
        'user_id',
        'skill_specialty_id',
    ];
}
