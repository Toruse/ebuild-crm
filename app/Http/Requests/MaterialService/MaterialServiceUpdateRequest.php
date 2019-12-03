<?php

namespace App\Http\Requests\MaterialService;

use Illuminate\Foundation\Http\FormRequest;

class MaterialServiceUpdateRequest extends FormRequest
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