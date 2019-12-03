<?php

namespace App\Http\Requests\ProjectType;

use Illuminate\Foundation\Http\FormRequest;

class ProjectTypeCreateRequest extends FormRequest
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