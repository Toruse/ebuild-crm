<?php

namespace App\Http\Requests\Source;

use Illuminate\Foundation\Http\FormRequest;

class SourceCreateRequest extends FormRequest
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