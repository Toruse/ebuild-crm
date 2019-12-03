<?php

namespace App\Http\Requests\SkillSpecialty;

use Illuminate\Foundation\Http\FormRequest;

class SkillSpecialtyUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|max:50',
        ];
    }
}