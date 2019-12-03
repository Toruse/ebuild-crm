<?php

namespace App\Http\Requests\ProjectType;

use Illuminate\Foundation\Http\FormRequest;

class ProjectTypeUpdateRequest extends FormRequest
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