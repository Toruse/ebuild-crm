<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class SkillSpecialty extends Model
{
    
    protected $table = 'skill_specialtys';

    protected $fillable = [
        'name',
    ];

    protected $hidden = [
        'created_at', 
        'updated_at'
    ];

}
